<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Models\Teacher;
use Illuminate\Support\Str;

class TeacherController extends Controller
{
    public function teacherAdd()
    {
        return view('teacher.add-teacher');
    }

    public function teacherList()
    {
        $teacherList = Teacher::with('user')->get();
        return view('teacher.list-teachers', compact('teacherList'));
    }

    public function teacherGrid()
    {
        $teacherGrid = Teacher::with('user')->get();
        return view('teacher.teachers-grid', compact('teacherGrid'));
    }

    public function saveRecord(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'gender' => 'required|string|in:Male,Female,Others',
            'experience' => 'required|string',
            'date_of_birth' => 'required|date',
            'qualification' => 'required|string',
            'phone_number' => 'required|string|regex:/^[0-9]{10}$/',
            'address' => 'required|string',
            'city' => 'required|string',
            'state' => 'required|string',
            'zip_code' => 'required|string',
            'country' => 'required|string',
        ]);

        if (Session::get('role_name') !== 'Admin') {
            Toastr::error('Unauthorized access!', 'Error');
            return redirect()->back();
        }

        DB::beginTransaction();
        try {
            $user = User::create([
                'user_id' => 'USR' . Str::random(8),
                'name' => $request->full_name,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'date_of_birth' => $request->date_of_birth,
                'role_name' => 'Teachers',
                'status' => 'Active',
                'password' => Hash::make($request->password),
                'avatar' => 'photo_defaults.jpg',
            ]);

            Teacher::create([
                'user_id' => $user->user_id,
                'user_id_fk' => $user->id,
                'full_name' => $request->full_name,
                'gender' => $request->gender,
                'experience' => $request->experience,
                'qualification' => $request->qualification,
                'date_of_birth' => $request->date_of_birth,
                'phone_number' => $request->phone_number,
                'address' => $request->address,
                'city' => $request->city,
                'state' => $request->state,
                'zip_code' => $request->zip_code,
                'country' => $request->country,
            ]);

            DB::commit();
            Toastr::success('Teacher added successfully!', 'Success');
            return redirect()->route('teacher/list');
        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('Failed to add teacher: ' . $e->getMessage(), 'Error');
            return redirect()->back()->withInput();
        }
    }

    public function editRecord($id)
    {
        $teacher = Teacher::with('user')->findOrFail($id);
        return view('teacher.edit-teacher', compact('teacher'));
    }

    public function updateRecordTeacher(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:teachers,id',
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $request->user_id . ',user_id',
            'password' => 'nullable|string|min:8',
            'gender' => 'required|string|in:Male,Female,Others',
            'experience' => 'required|string',
            'date_of_birth' => 'required|date',
            'qualification' => 'required|string',
            'phone_number' => 'required|string|regex:/^[0-9]{10}$/',
            'address' => 'required|string',
            'city' => 'required|string',
            'state' => 'required|string',
            'zip_code' => 'required|string',
            'country' => 'required|string',
        ]);

        if (Session::get('role_name') !== 'Admin') {
            Toastr::error('Unauthorized access!', 'Error');
            return redirect()->back();
        }

        DB::beginTransaction();
        try {
            $teacher = Teacher::findOrFail($request->id);
            $user = $teacher->user;

            $userData = [
                'name' => $request->full_name,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'date_of_birth' => $request->date_of_birth,
            ];

            if ($request->filled('password')) {
                $userData['password'] = Hash::make($request->password);
            }

            $user->update($userData);

            $teacher->update([
                'full_name' => $request->full_name,
                'gender' => $request->gender,
                'experience' => $request->experience,
                'qualification' => $request->qualification,
                'date_of_birth' => $request->date_of_birth,
                'phone_number' => $request->phone_number,
                'address' => $request->address,
                'city' => $request->city,
                'state' => $request->state,
                'zip_code' => $request->zip_code,
                'country' => $request->country,
            ]);

            DB::commit();
            Toastr::success('Teacher updated successfully!', 'Success');
            return redirect()->route('teacher/list');
        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('Failed to update teacher: ' . $e->getMessage(), 'Error');
            return redirect()->back()->withInput();
        }
    }

    public function teacherDelete(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:teachers,id',
        ]);

        if (Session::get('role_name') !== 'Admin') {
            Toastr::error('Unauthorized access!', 'Error');
            return redirect()->back();
        }

        DB::beginTransaction();
        try {
            $teacher = Teacher::findOrFail($request->id);
            $user = $teacher->user;

            // Explicitly delete the user record if cascade isn't working
            if ($user) {
                $user->delete();
            }

            $teacher->delete();

            DB::commit();
            Toastr::success('Teacher deleted successfully!', 'Success');
            return redirect()->route('teacher/list');
        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('Failed to delete teacher: ' . $e->getMessage(), 'Error');
            return redirect()->back();
        }
    }
}
