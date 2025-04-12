<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Student;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class StudentController extends Controller
{
    public function student()
    {
        $studentList = Student::with('user')->get();
        return view('student.student', compact('studentList'));
    }

    public function studentGrid()
    {
        $studentList = Student::with('user')->get();
        return view('student.student-grid', compact('studentList'));
    }

    public function studentAdd()
    {
        return view('student.add-student');
    }

    public function studentSave(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'gender' => 'required|string|in:Male,Female,Others',
            'date_of_birth' => 'required|date',
            'roll' => 'required|string',
            'blood_group' => 'required|string|in:A+,B+,O+,A-,B-,O-,AB+,AB-',
            'religion' => 'required|string',
            'class' => 'required|string',
            'section' => 'required|string',
            'admission_id' => 'required|string|unique:students,admission_id',
            'phone_number' => 'required|string|regex:/^[0-9]{10}$/',
            'upload' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if (Session::get('role_name') !== 'Admin') {
            Toastr::error('Only Admins can add students!', 'Error');
            return redirect()->back();
        }

        DB::beginTransaction();
        try {
            $user = User::create([
                'user_id' => 'USR' . Str::random(8),
                'name' => $request->first_name . ' ' . $request->last_name,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'date_of_birth' => $request->date_of_birth,
                'role_name' => 'Student',
                'status' => 'Active',
                'password' => Hash::make('default123'),
                'avatar' => 'photo_defaults.jpg',
            ]);

            if (!$user->id) {
                Log::error('Failed to create user for student: ' . $request->email);
                throw new \Exception('User creation failed');
            }

            $upload_file = Str::uuid() . '.' . $request->upload->extension();
            $request->upload->storeAs('public/student-photos', $upload_file);

            $student = Student::create([
                'user_id' => $user->user_id,
                'user_id_fk' => $user->id,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'gender' => $request->gender,
                'date_of_birth' => $request->date_of_birth,
                'roll' => $request->roll,
                'blood_group' => $request->blood_group,
                'religion' => $request->religion,
                'email' => $request->email,
                'class' => $request->class,
                'section' => $request->section,
                'admission_id' => $request->admission_id,
                'phone_number' => $request->phone_number,
                'upload' => $upload_file,
            ]);

            DB::commit();
            Toastr::success('Student added successfully!', 'Success');
            return redirect()->route('student/list');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Student save failed: ' . $e->getMessage());
            Toastr::error('Failed to add student. Please try again.', 'Error');
            return redirect()->back()->withInput();
        }
    }

    public function studentEdit($id)
    {
        $studentEdit = Student::with('user')->where('id', $id)->firstOrFail();
        return view('student.edit-student', compact('studentEdit'));
    }

    public function studentUpdate(Request $request)
    {
        $student = Student::findOrFail($request->id);

        $request->validate([
            'id' => 'required|exists:students,id',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $student->user_id_fk . ',id',
            'gender' => 'required|string|in:Male,Female,Others',
            'date_of_birth' => 'required|date',
            'roll' => 'required|string',
            'blood_group' => 'required|string|in:A+,B+,O+,A-,B-,O-,AB+,AB-',
            'religion' => 'required|string',
            'class' => 'required|string',
            'section' => 'required|string',
            'admission_id' => 'required|string|unique:students,admission_id,' . $request->id,
            'phone_number' => 'required|string|regex:/^[0-9]{10}$/',
            'upload' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if (Session::get('role_name') !== 'Admin') {
            Toastr::error('Only Admins can update students!', 'Error');
            return redirect()->back();
        }

        DB::beginTransaction();
        try {
            $student = Student::findOrFail($request->id);
            $user = $student->user;

            $upload_file = $student->upload;
            if ($request->hasFile('upload')) {
                if ($upload_file && Storage::exists('public/student-photos/' . $upload_file)) {
                    Storage::delete('public/student-photos/' . $upload_file);
                }
                $upload_file = Str::uuid() . '.' . $request->upload->extension();
                $request->upload->storeAs('public/student-photos', $upload_file);
            }

            $user->update([
                'name' => $request->first_name . ' ' . $request->last_name,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'date_of_birth' => $request->date_of_birth,
            ]);

            $student->update([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'gender' => $request->gender,
                'date_of_birth' => $request->date_of_birth,
                'roll' => $request->roll,
                'blood_group' => $request->blood_group,
                'religion' => $request->religion,
                'email' => $request->email,
                'class' => $request->class,
                'section' => $request->section,
                'admission_id' => $request->admission_id,
                'phone_number' => $request->phone_number,
                'upload' => $upload_file,
            ]);

            DB::commit();
            Toastr::success('Student updated successfully!', 'Success');
            return redirect()->route('student/list');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Student update failed: ' . $e->getMessage());
            Toastr::error('Failed to update student. Please try again.', 'Error');
            return redirect()->back()->withInput();
        }
    }

    public function studentDelete(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:students,id',
        ]);

        if (Session::get('role_name') !== 'Admin') {
            Toastr::error('Only Admins can delete students!', 'Error');
            return redirect()->back();
        }

        DB::beginTransaction();
        try {
            $student = Student::findOrFail($request->id);
            $upload_file = $student->upload;

            if ($upload_file && Storage::exists('public/student-photos/' . $upload_file)) {
                Storage::delete('public/student-photos/' . $upload_file);
            }

            $student->delete(); // Cascade deletes user due to foreign key

            DB::commit();
            Toastr::success('Student deleted successfully!', 'Success');
            return redirect()->route('student/list');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Student delete failed: ' . $e->getMessage());
            Toastr::error('Failed to delete student. Please try again.', 'Error');
            return redirect()->back();
        }
    }

    public function studentProfile($id)
    {
        $studentProfile = Student::with('user')->where('id', $id)->firstOrFail();
        return view('student.student-profile', compact('studentProfile'));
    }
}
