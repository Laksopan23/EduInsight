<?php

namespace App\Http\Controllers;

use App\Models\Communication;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\DB;

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

    // Save the new communication
    public function communicationSave(Request $request)
    {
        $request->validate([
            'title'    => 'required|string',
            'message'  => 'required|string',
            'sender'   => 'required|string',
            'receiver' => 'required|string',
        ]);

        DB::beginTransaction();
        try {
            $communication = new Communication();
            $communication->title    = $request->title;
            $communication->message  = $request->message;
            $communication->sender   = $request->sender;
            $communication->receiver = $request->receiver;
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
        DB::beginTransaction();
        try {
            $communication = Communication::findOrFail($request->id);
            $communication->update([
                'title'   => $request->title,
                'message' => $request->message,
                'sender'  => $request->sender,
                'receiver' => $request->receiver,
            ]);

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
}
