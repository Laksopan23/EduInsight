<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class GuardianController extends Controller
{
    public function index()
    {
        $guardians = User::where('role_name', 'Guardian')->with('students')->get();
        return view('guardian.list', compact('guardians'));
    }

    public function add()
    {
        $students = Student::all();
        return view('guardian.add', compact('students'));
    }

    public function save(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone_number' => 'required|string|max:15',
            'password' => 'required|string|min:6',
            'students' => 'required|array|min:1',
            'students.*' => 'exists:students,id',
        ]);

        $user = User::create([
            'name' => $request->first_name . ' ' . $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_name' => 'Guardian',
            'phone_number' => $request->phone_number,
        ]);

        $guardian = $user;
        $guardian->students()->attach($request->students);

        Toastr::success('Guardian added successfully', 'Success');
        return redirect()->route('guardian/list');
    }

    public function edit($id)
    {
        $guardian = User::where('role_name', 'Guardian')->findOrFail($id);
        $students = Student::all();
        $selectedStudents = $guardian->students->pluck('id')->toArray();
        return view('guardian.edit', compact('guardian', 'students', 'selectedStudents'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:users,id',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $request->id,
            'phone_number' => 'required|string|max:15',
            'password' => 'nullable|string|min:6',
            'students' => 'required|array|min:1',
            'students.*' => 'exists:students,id',
        ]);

        $guardian = User::findOrFail($request->id);
        $guardian->update([
            'name' => $request->first_name . ' ' . $request->last_name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'password' => $request->password ? Hash::make($request->password) : $guardian->password,
        ]);

        $guardian->students()->sync($request->students);

        Toastr::success('Guardian updated successfully', 'Success');
        return redirect()->route('guardian/list');
    }

    public function delete(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:users,id',
        ]);

        DB::beginTransaction();
        try {
            $guardian = User::findOrFail($request->id);
            Log::info('Deleting guardian', ['guardian_id' => $guardian->id]);

            $guardian->students()->detach();
            $guardian->delete();

            DB::commit();
            Toastr::success('Guardian deleted successfully', 'Success');
            return redirect()->route('guardian/list');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Guardian delete failed: ' . $e->getMessage());
            Toastr::error('Failed to delete guardian. Please try again.', 'Error');
            return redirect()->back();
        }
    }
}
