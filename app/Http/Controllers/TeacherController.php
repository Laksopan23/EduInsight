<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Teacher;

class TeacherController extends Controller
{
    /** add teacher page */
    public function teacherAdd()
    {
        // No need for users since we're not linking to User model
        return view('teacher.add-teacher');
    }

    /** teacher list */
    public function teacherList()
    {
        // Fetch all teachers
        $teacherList = Teacher::all();
        return view('teacher.list-teachers', compact('teacherList'));
    }

    /** teacher Grid */
    public function teacherGrid()
    {
        // Same as teacherList, but for grid
        $teacherGrid = Teacher::all();
        return view('teacher.teachers-grid', compact('teacherGrid'));
    }

    /** save record */
    public function saveRecord(Request $request)
    {
        $request->validate([
            'full_name'     => 'required|string',
            'gender'        => 'required|string',
            'experience'    => 'required|string',
            'date_of_birth' => 'required|string',
            'qualification' => 'required|string',
            'phone_number'  => 'required|string',
            'address'       => 'required|string',
            'city'          => 'required|string',
            'state'         => 'required|string',
            'zip_code'      => 'required|string',
            'country'       => 'required|string',
        ]);

        try {
            // Create and save the teacher record
            $saveRecord = new Teacher;
            $saveRecord->full_name     = $request->full_name;
            $saveRecord->gender        = $request->gender;
            $saveRecord->experience    = $request->experience;
            $saveRecord->qualification = $request->qualification;
            $saveRecord->date_of_birth = $request->date_of_birth;
            $saveRecord->phone_number  = $request->phone_number;
            $saveRecord->address       = $request->address;
            $saveRecord->city          = $request->city;
            $saveRecord->state         = $request->state;
            $saveRecord->zip_code      = $request->zip_code;
            $saveRecord->country       = $request->country;
            $saveRecord->save();

            Toastr::success('Teacher has been added successfully!', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            Log::info($e);
            DB::rollback();
            Toastr::error('Failed to add new teacher.', 'Error');
            return redirect()->back();
        }
    }

    /** edit record */
    public function editRecord($id) // Changed to use teacher id
    {
        // Fetch teacher by ID
        $teacher = Teacher::findOrFail($id);
        return view('teacher.edit-teacher', compact('teacher'));
    }

    /** update record teacher */
    public function updateRecordTeacher(Request $request)
    {
        $request->validate([
            'full_name'     => 'required|string',
            'gender'        => 'required|string',
            'experience'    => 'required|string',
            'date_of_birth' => 'required|string',
            'qualification' => 'required|string',
            'phone_number'  => 'required|string',
            'address'       => 'required|string',
            'city'          => 'required|string',
            'state'         => 'required|string',
            'zip_code'      => 'required|string',
            'country'       => 'required|string',
        ]);

        DB::beginTransaction();
        try {
            $updateRecord = [
                'full_name'     => $request->full_name,
                'gender'        => $request->gender,
                'date_of_birth' => $request->date_of_birth,
                'qualification' => $request->qualification,
                'experience'    => $request->experience,
                'phone_number'  => $request->phone_number,
                'address'       => $request->address,
                'city'          => $request->city,
                'state'         => $request->state,
                'zip_code'      => $request->zip_code,
                'country'       => $request->country,
            ];

            Teacher::where('id', $request->id)->update($updateRecord);

            Toastr::success('Teacher record has been updated successfully!', 'Success');
            DB::commit();
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            Log::info($e);
            Toastr::error('Failed to update teacher record.', 'Error');
            return redirect()->back();
        }
    }

    /** delete record */
    public function teacherDelete(Request $request)
    {
        DB::beginTransaction();
        try {
            Teacher::destroy($request->id);
            DB::commit();
            Toastr::success('Teacher record has been deleted successfully!', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            Log::info($e);
            Toastr::error('Failed to delete teacher record.', 'Error');
            return redirect()->back();
        }
    }
}
