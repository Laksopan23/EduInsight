<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FeesType;
use App\Models\User;
use App\Models\FeesInformation;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AccountsController extends Controller
{
    /** index page */
    public function index()
    {
        $feesInformation = FeesInformation::join('users', 'fees_information.student_id', '=', DB::raw('CAST(users.id AS CHAR)'))
            ->select('fees_information.*', 'users.avatar')
            ->get();
        return view('accounts.feescollections', compact('feesInformation'));
    }

    /** add Fees Collection */
    public function addFeesCollection()
    {
        $users = User::whereIn('role_name', ['Student'])->get();
        $feesType = FeesType::all();
        return view('accounts.add-fees-collection', compact('users', 'feesType'));
    }

    /** edit Fees Collection */
    public function edit($id)
    {
        $feesInfo = FeesInformation::findOrFail($id);
        $users = User::whereIn('role_name', ['Student'])->get();
        $feesType = FeesType::all();
        return view('accounts.edit-fees-collection', compact('feesInfo', 'users', 'feesType'));
    }

    /** save record */
    public function saveRecord(Request $request)
    {
        $request->validate([
            'student_id'   => 'required|string',
            'student_name' => 'required|string',
            'gender'       => 'required|string',
            'fees_type'    => 'required|string',
            'fees_amount'  => 'required|string',
            'paid_date'    => 'required|string',
        ]);

        try {
            $saveRecord = new FeesInformation;
            $saveRecord->student_id   = $request->student_id;
            $saveRecord->student_name = $request->student_name;
            $saveRecord->gender       = $request->gender;
            $saveRecord->fees_type    = $request->fees_type;
            $saveRecord->fees_amount  = $request->fees_amount;
            $saveRecord->paid_date    = $request->paid_date;

            $isSaved = $saveRecord->save();

            if ($isSaved) {
                Log::info('Fees record saved successfully: ' . json_encode($saveRecord));
                Toastr::success('Has been added successfully :)', 'Success');
            } else {
                Log::error('Failed to save fees record: ' . json_encode($saveRecord));
                Toastr::error('Failed to save record :(', 'Error');
            }

            return redirect()->back();
        } catch (\Exception $e) {
            Log::error('Exception while saving fees record: ' . $e->getMessage());
            Toastr::error('Failed to add new record :(', 'Error');
            return redirect()->back();
        }
    }

    /** update record */
    public function updateRecord(Request $request, $id)
    {
        $request->validate([
            'student_id'   => 'required|string',
            'student_name' => 'required|string',
            'gender'       => 'required|string',
            'fees_type'    => 'required|string',
            'fees_amount'  => 'required|string',
            'paid_date'    => 'required|string',
        ]);

        try {
            $updateRecord = FeesInformation::findOrFail($id);
            $updateRecord->student_id   = $request->student_id;
            $updateRecord->student_name = $request->student_name;
            $updateRecord->gender       = $request->gender;
            $updateRecord->fees_type    = $request->fees_type;
            $updateRecord->fees_amount  = $request->fees_amount;
            $updateRecord->paid_date    = $request->paid_date;

            $isUpdated = $updateRecord->save();

            if ($isUpdated) {
                Log::info('Fees record updated successfully: ' . json_encode($updateRecord));
                Toastr::success('Has been updated successfully :)', 'Success');
            } else {
                Log::error('Failed to update fees record: ' . json_encode($updateRecord));
                Toastr::error('Failed to update record :(', 'Error');
            }

            return redirect()->route('account/fees/collections/page');
        } catch (\Exception $e) {
            Log::error('Exception while updating fees record: ' . $e->getMessage());
            Toastr::error('Failed to update record :(', 'Error');
            return redirect()->back();
        }
    }

    /** delete record */
    public function deleteRecord(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
        ]);

        try {
            $feesInfo = FeesInformation::findOrFail($request->id);
            $isDeleted = $feesInfo->delete();

            if ($isDeleted) {
                Log::info('Fees record deleted successfully: ' . json_encode($feesInfo));
                Toastr::success('Has been deleted successfully :)', 'Success');
            } else {
                Log::error('Failed to delete fees record: ' . json_encode($feesInfo));
                Toastr::error('Failed to delete record :(', 'Error');
            }

            return redirect()->route('account/fees/collections/page');
        } catch (\Exception $e) {
            Log::error('Exception while deleting fees record: ' . $e->getMessage());
            Toastr::error('Failed to delete record :(', 'Error');
            return redirect()->back();
        }
    }
}
