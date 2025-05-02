<?php

namespace App\Http\Controllers;

use App\Models\Communication;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class CommunicationController extends Controller
{
    // Show the communication list
    public function communicationList()
    {
        $communicationList = Communication::all();
        return view('communication.communication-list', compact('communicationList'));
    }

    // Show the communication grid
    public function communicationGrid()
    {
        $communicationList = Communication::all();
        return view('communication.communication-grid', compact('communicationList'));
    }

    // Show add communication page
    public function communicationAdd()
    {
        return view('communication.add-communication');
    }

    // Redirect to Zoom for authorization
    public function authorizeZoom()
    {
        $clientId = env('ZOOM_CLIENT_ID');
        $redirectUri = env('ZOOM_REDIRECT_URI', 'http://localhost:8000/callback');
        $authorizeUrl = "https://zoom.us/oauth/authorize?response_type=code&client_id={$clientId}&redirect_uri=" . urlencode($redirectUri);
        return redirect($authorizeUrl);
    }

    // Handle Zoom OAuth callback
    public function handleCallback(Request $request)
    {
        $code = $request->query('code');
        if (!$code) {
            Toastr::error('Zoom authorization failed: No code received.', 'Error');
            return redirect()->route('communication/add/page');
        }

        $clientId = env('ZOOM_CLIENT_ID');
        $clientSecret = env('ZOOM_CLIENT_SECRET');
        $redirectUri = env('ZOOM_REDIRECT_URI', 'http://localhost:8000/callback');

        try {
            $response = Http::asForm()->withBasicAuth($clientId, $clientSecret)->post('https://zoom.us/oauth/token', [
                'grant_type' => 'authorization_code',
                'code' => $code,
                'redirect_uri' => $redirectUri,
            ]);

            if ($response->successful()) {
                $tokenData = $response->json();
                Session::put('zoom_access_token', $tokenData['access_token']);
                Session::put('zoom_refresh_token', $tokenData['refresh_token']);
                Session::put('zoom_token_expires', now()->addSeconds($tokenData['expires_in']));

                Toastr::success('Zoom authorization successful!', 'Success');
            } else {
                Toastr::error('Failed to get Zoom access token: ' . $response->body(), 'Error');
            }
        } catch (\Exception $e) {
            Toastr::error('Error during Zoom authorization: ' . $e->getMessage(), 'Error');
        }

        return redirect()->route('communication/add/page');
    }

    // Refresh Zoom access token if expired
    private function refreshAccessToken()
    {
        $refreshToken = Session::get('zoom_refresh_token');
        if (!$refreshToken) {
            return null;
        }

        $clientId = env('ZOOM_CLIENT_ID');
        $clientSecret = env('ZOOM_CLIENT_SECRET');

        try {
            $response = Http::asForm()->withBasicAuth($clientId, $clientSecret)->post('https://zoom.us/oauth/token', [
                'grant_type' => 'refresh_token',
                'refresh_token' => $refreshToken,
            ]);

            if ($response->successful()) {
                $tokenData = $response->json();
                Session::put('zoom_access_token', $tokenData['access_token']);
                Session::put('zoom_refresh_token', $tokenData['refresh_token']);
                Session::put('zoom_token_expires', now()->addSeconds($tokenData['expires_in']));
                return $tokenData['access_token'];
            } else {
                Toastr::error('Failed to refresh Zoom token: ' . $response->body(), 'Error');
                return null;
            }
        } catch (\Exception $e) {
            Toastr::error('Error refreshing Zoom token: ' . $e->getMessage(), 'Error');
            return null;
        }
    }

    // Get a valid Zoom access token
    private function getAccessToken()
    {
        $accessToken = Session::get('zoom_access_token');
        $expiresAt = Session::get('zoom_token_expires');

        if ($accessToken && $expiresAt && now()->lt($expiresAt)) {
            return $accessToken;
        }

        return $this->refreshAccessToken();
    }

    // Generate a meeting link using Zoom API
    private function generateMeetingLink($title)
    {
        $accessToken = $this->getAccessToken();
        if (!$accessToken) {
            Toastr::error('Zoom authentication required. Please authorize Zoom first.', 'Error');
            return null;
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type' => 'application/json',
            ])->post('https://api.zoom.us/v2/users/me/meetings', [
                'topic' => $title,
                'type' => 2, // Scheduled meeting
                'start_time' => now()->addHour()->toIso8601String(),
                'duration' => 60,
                'timezone' => 'Asia/Kolkata',
                'settings' => [
                    'host_video' => true,
                    'participant_video' => true,
                    'join_before_host' => false,
                    'mute_upon_entry' => true,
                ],
            ]);

            if ($response->successful()) {
                $data = $response->json();
                return $data['join_url'];
            } else {
                Toastr::error('Failed to create meeting: ' . $response->body(), 'Error');
                return null;
            }
        } catch (\Exception $e) {
            Toastr::error('Error connecting to Zoom API: ' . $e->getMessage(), 'Error');
            return null;
        }
    }

    // Save the new communication
    public function communicationSave(Request $request)
    {
        $request->validate([
            'title'    => 'required|string',
            'message'  => 'required|string',
            'sender'   => 'required|string',
            'receiver' => 'required|string',
            'schedule_meeting' => 'nullable|boolean',
        ]);

        DB::beginTransaction();
        try {
            $communication = new Communication();
            $communication->title    = $request->title;
            $communication->message  = $request->message;
            $communication->sender   = $request->sender;
            $communication->receiver = $request->receiver;

            if ($request->schedule_meeting) {
                $meetingLink = $this->generateMeetingLink($request->title);
                if ($meetingLink) {
                    $communication->meeting_link = $meetingLink;
                } else {
                    Toastr::warning('Meeting not scheduled due to an error. Communication saved.', 'Warning');
                }
            }

            $communication->save();

            Toastr::success('Communication added successfully :)', 'Success');
            DB::commit();
            return redirect()->route('communication/list');
        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('Failed to add communication :)', 'Error');
            return redirect()->back();
        }
    }

    // Show communication edit page
    public function communicationEdit($id)
    {
        $communication = Communication::findOrFail($id);
        return view('communication.edit-communication', compact('communication'));
    }

    // Update communication record
    public function communicationUpdate(Request $request)
    {
        $request->validate([
            'id'       => 'required|integer',
            'title'    => 'required|string',
            'message'  => 'required|string',
            'sender'   => 'required|string',
            'receiver' => 'required|string',
            'schedule_meeting' => 'nullable|boolean',
        ]);

        DB::beginTransaction();
        try {
            $communication = Communication::findOrFail($request->id);
            $communication->update([
                'title'    => $request->title,
                'message'  => $request->message,
                'sender'   => $request->sender,
                'receiver' => $request->receiver,
            ]);

            if ($request->schedule_meeting && !$communication->meeting_link) {
                $meetingLink = $this->generateMeetingLink($request->title);
                if ($meetingLink) {
                    $communication->update(['meeting_link' => $meetingLink]);
                } else {
                    Toastr::warning('Meeting not scheduled due to an error.', 'Warning');
                }
            }

            Toastr::success('Communication updated successfully :)', 'Success');
            DB::commit();
            return redirect()->route('communication/list');
        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('Failed to update communication :)', 'Error');
            return redirect()->back();
        }
    }

    // Show communication profile page
    public function communicationProfile($id)
    {
        $communication = Communication::findOrFail($id);
        return view('communication.communication-profile', compact('communication'));
    }

    // Delete communication record
    public function communicationDelete(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
        ]);

        DB::beginTransaction();
        try {
            $communication = Communication::findOrFail($request->id);
            $communication->delete();

            Toastr::success('Communication deleted successfully :)', 'Success');
            DB::commit();
            return redirect()->route('communication/list');
        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('Failed to delete communication :)', 'Error');
            return redirect()->back();
        }
    }
}
