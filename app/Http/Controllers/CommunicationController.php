<?php

namespace App\Http\Controllers;

use App\Models\Communication;
use App\Models\User;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class CommunicationController extends Controller
{
    // Show the communication list
    public function communicationList()
    {
        $communicationList = Communication::with('receivers')->get();
        Log::info('Communication list loaded', ['count' => $communicationList->count()]);
        return view('communication.communication-list', compact('communicationList'));
    }

    // Show the communication grid
    public function communicationGrid()
    {
        $communicationList = Communication::with('receivers')->get();
        return view('communication.communication-grid', compact('communicationList'));
    }

    // Show add communication page with pre-filled sender and receiver search
    public function communicationAdd()
    {
        $loggedInUser = Auth::user();
        $guardians = User::where('role_name', 'Guardian')->get();
        return view('communication.add-communication', compact('loggedInUser', 'guardians'));
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
            Log::error('Zoom authorization failed: No code received.');
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
                Log::info('Zoom token stored successfully', ['access_token' => $tokenData['access_token']]);
                Toastr::success('Zoom authorization successful!', 'Success');
            } else {
                Toastr::error('Failed to get Zoom access token: ' . $response->body(), 'Error');
                Log::error('Failed to get Zoom access token', ['response' => $response->body()]);
            }
        } catch (\Exception $e) {
            Toastr::error('Error during Zoom authorization: ' . $e->getMessage(), 'Error');
            Log::error('Error during Zoom authorization', ['message' => $e->getMessage()]);
        }

        return redirect()->route('communication/add/page')->with('zoom_authorized', true);
    }

    // Refresh Zoom access token if expired
    private function refreshAccessToken()
    {
        $refreshToken = Session::get('zoom_refresh_token');
        if (!$refreshToken) {
            Log::warning('No refresh token available for Zoom.');
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
                Log::info('Zoom token refreshed successfully', ['access_token' => $tokenData['access_token']]);
                return $tokenData['access_token'];
            } else {
                Toastr::error('Failed to refresh Zoom token: ' . $response->body(), 'Error');
                Log::error('Failed to refresh Zoom token', ['response' => $response->body()]);
                return null;
            }
        } catch (\Exception $e) {
            Toastr::error('Error refreshing Zoom token: ' . $e->getMessage(), 'Error');
            Log::error('Error refreshing Zoom token', ['message' => $e->getMessage()]);
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
    private function generateMeetingLink($title, $date, $time)
    {
        $accessToken = $this->getAccessToken();
        if (!$accessToken) {
            Toastr::error('Zoom authentication required. Please authorize Zoom first.', 'Error');
            Log::warning('No valid Zoom access token available.');
            return null;
        }

        try {
            $startTime = Carbon::createFromFormat('Y-m-d H:i', $date . ' ' . $time)->toIso8601String();
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type' => 'application/json',
            ])->post('https://api.zoom.us/v2/users/me/meetings', [
                'topic' => $title,
                'type' => 2, // Scheduled meeting
                'start_time' => $startTime,
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
                Log::info('Meeting link generated successfully', ['join_url' => $data['join_url']]);
                return $data['join_url'];
            } else {
                Toastr::error('Failed to create meeting: ' . $response->body(), 'Error');
                Log::error('Failed to create meeting', ['response' => $response->body()]);
                return null;
            }
        } catch (\Exception $e) {
            Toastr::error('Error connecting to Zoom API: ' . $e->getMessage(), 'Error');
            Log::error('Error connecting to Zoom API', ['message' => $e->getMessage()]);
            return null;
        }
    }

    // Save the new communication with logged-in sender and multiple receivers
    public function communicationSave(Request $request)
    {
        $request->validate([
            'title'          => 'required|string',
            'message'        => 'required|string',
            'receiver'       => 'required|array',
            'schedule_date'  => 'nullable|date',
            'schedule_time'  => 'nullable|date_format:H:i',
            'schedule_meeting' => 'nullable|boolean',
        ]);

        DB::beginTransaction();
        try {
            $loggedInUser = Auth::user()->name; // Assuming name is stored in users table
            $communication = new Communication();
            $communication->title = $request->title;
            $communication->message = $request->message;
            $communication->sender = $loggedInUser; // Set sender as logged-in user
            $communication->schedule_date = $request->schedule_date;
            $communication->schedule_time = $request->schedule_time;

            if ($request->schedule_meeting) {
                $meetingLink = $this->generateMeetingLink($request->title, $request->schedule_date, $request->schedule_time);
                if ($meetingLink) {
                    $communication->meeting_link = $meetingLink;
                    Log::info('Meeting link saved with communication', ['communication_id' => $communication->id, 'meeting_link' => $meetingLink]);
                } else {
                    Toastr::warning('Meeting not scheduled due to an error. Communication saved.', 'Warning');
                    Log::warning('Failed to schedule meeting for communication', ['communication_id' => $communication->id]);
                }
            }

            $communication->save();
            $communication->receivers()->sync($request->receiver); // Sync multiple receivers

            Log::info('Communication saved successfully', ['communication_id' => $communication->id]);

            Toastr::success('Communication added successfully :)', 'Success');
            DB::commit();
            return redirect()->route('communication/list');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Failed to save communication', ['message' => $e->getMessage(), 'request' => $request->all()]);
            Toastr::error('Failed to add communication : ' . $e->getMessage(), 'Error');
            return redirect()->back()->withInput();
        }
    }

    // Show communication edit page
    public function communicationEdit($id)
    {
        $communication = Communication::with('receivers')->findOrFail($id);
        $guardians = User::where('role_name', 'Guardian')->get();
        return view('communication.edit-communication', compact('communication', 'guardians'));
    }

    // Update communication record
    public function communicationUpdate(Request $request)
    {
        $request->validate([
            'id'             => 'required|integer',
            'title'          => 'required|string',
            'message'        => 'required|string',
            'receiver'       => 'required|array',
            'schedule_date'  => 'nullable|date',
            'schedule_time'  => 'nullable|date_format:H:i',
            'schedule_meeting' => 'nullable|boolean',
        ]);

        DB::beginTransaction();
        try {
            $loggedInUser = Auth::user()->name;
            $communication = Communication::findOrFail($request->id);
            $communication->update([
                'title'          => $request->title,
                'message'        => $request->message,
                'sender'         => $loggedInUser, // Keep sender as logged-in user
                'schedule_date'  => $request->schedule_date,
                'schedule_time'  => $request->schedule_time,
            ]);

            if ($request->schedule_meeting && !$communication->meeting_link) {
                $meetingLink = $this->generateMeetingLink($request->title, $request->schedule_date, $request->schedule_time);
                if ($meetingLink) {
                    $communication->update(['meeting_link' => $meetingLink]);
                    Log::info('Meeting link updated for communication', ['communication_id' => $communication->id, 'meeting_link' => $meetingLink]);
                } else {
                    Toastr::warning('Meeting not scheduled due to an error.', 'Warning');
                    Log::warning('Failed to schedule meeting for communication update', ['communication_id' => $communication->id]);
                }
            }

            $communication->receivers()->sync($request->receiver); // Sync multiple receivers

            Toastr::success('Communication updated successfully :)', 'Success');
            DB::commit();
            return redirect()->route('communication/list');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Failed to update communication', ['message' => $e->getMessage(), 'request' => $request->all()]);
            Toastr::error('Failed to update communication : ' . $e->getMessage(), 'Error');
            return redirect()->back()->withInput();
        }
    }

    // Show communication profile page
    public function communicationProfile($id)
    {
        $communication = Communication::with('receivers')->findOrFail($id);
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
            Log::info('Communication deleted successfully', ['communication_id' => $request->id]);

            Toastr::success('Communication deleted successfully :)', 'Success');
            DB::commit();
            return redirect()->route('communication/list');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Failed to delete communication', ['message' => $e->getMessage()]);
            Toastr::error('Failed to delete communication :)', 'Error');
            return redirect()->back();
        }
    }
}
