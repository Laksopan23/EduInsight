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

    public function add(Request $request)
    {
        $search = $request->input('search', '');
        $students = Student::query()
            ->where('first_name', 'LIKE', "%{$search}%")
            ->orWhere('last_name', 'LIKE', "%{$search}%")
            ->orWhere('admission_id', 'LIKE', "%{$search}%")
            ->get();
        return view('guardian.add', compact('students', 'search'));
    }

    public function save(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone_number' => 'required|string|max:15',
            'password' => 'required|string|min:6',
            'relationship' => 'required|string|in:Father,Mother,Other',
            'students' => 'required|array|min:1',
            'students.*' => 'exists:students,id',
        ], [
            'relationship.required' => 'Please select a relationship.',
            'relationship.in' => 'Relationship must be Father, Mother, or Other.',
        ]);

        DB::beginTransaction();
        try {
            $user = User::create([
                'name' => $request->first_name . ' ' . $request->last_name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role_name' => 'Guardian',
                'phone_number' => $request->phone_number,
            ]);

            $guardian = $user;
            $relationship = $request->relationship;
            $syncData = [];
            foreach ($request->students as $studentId) {
                $syncData[$studentId] = ['relationship' => $relationship];
            }
            $guardian->students()->attach($syncData);

            DB::commit();
            Toastr::success('Guardian added successfully', 'Success');
            return redirect()->route('guardian/list');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Guardian save failed: ' . $e->getMessage());
            Toastr::error('Failed to add guardian. Please try again.', 'Error');
            return redirect()->back()->withInput();
        }
    }

    public function edit($id)
    {
        $guardian = User::where('role_name', 'Guardian')->findOrFail($id);
        $students = Student::all();
        $selectedStudents = $guardian->students->pluck('id')->toArray();
        $relationships = $guardian->students()->pluck('relationship', 'students.id')->toArray();
        $relationship = !empty($relationships) ? reset($relationships) : '';
        return view('guardian.edit', compact('guardian', 'students', 'selectedStudents', 'relationship'));
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
            'relationship' => 'required|string|in:Father,Mother,Other',
            'students' => 'required|array|min:1',
            'students.*' => 'exists:students,id',
        ], [
            'relationship.required' => 'Please select a relationship.',
            'relationship.in' => 'Relationship must be Father, Mother, or Other.',
        ]);

        DB::beginTransaction();
        try {
            $guardian = User::findOrFail($request->id);
            $guardian->update([
                'name' => $request->first_name . ' ' . $request->last_name,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'password' => $request->password ? Hash::make($request->password) : $guardian->password,
            ]);

            $relationship = $request->relationship;
            $syncData = [];
            foreach ($request->students as $studentId) {
                $syncData[$studentId] = ['relationship' => $relationship];
            }
            $guardian->students()->sync($syncData);

            DB::commit();
            Toastr::success('Guardian updated successfully', 'Success');
            return redirect()->route('guardian/list');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Guardian update failed: ' . $e->getMessage());
            Toastr::error('Failed to update guardian. Please try again.', 'Error');
            return redirect()->back()->withInput();
        }
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
