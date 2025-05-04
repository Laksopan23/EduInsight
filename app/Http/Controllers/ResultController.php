<?php

namespace App\Http\Controllers;

use App\Models\Result;
use App\Models\User;
use App\Models\Subject;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ResultController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $results = Result::with(['teacher', 'student', 'subject'])->get();
        return view('results.result-list', compact('results'));
    }

    public function create()
    {
        if (Auth::user()->role_name !== 'Admin' && Auth::user()->role_name !== 'Teachers') {
            Toastr::error('You do not have permission to add results.', 'Error');
            return redirect()->route('results.list');
        }
        $teachers = User::whereIn('role_name', ['Admin', 'Teachers'])->get();
        $students = User::where('role_name', 'Student')->get();
        $subjects = Subject::all();
        return view('results.add-result', compact('teachers', 'students', 'subjects'));
    }

    public function store(Request $request)
    {
        if (Auth::user()->role_name !== 'Admin' && Auth::user()->role_name !== 'Teachers') {
            Toastr::error('You do not have permission to add results.', 'Error');
            return redirect()->route('results.list');
        }

        $request->validate([
            'teacher_id' => 'required|exists:users,id',
            'student_id' => 'required|exists:users,id',
            'subject_id' => 'required|exists:subjects,id',
            'marks' => 'required|numeric|min:0|max:100',
        ]);

        DB::beginTransaction();
        try {
            Result::create([
                'teacher_id' => $request->teacher_id,
                'student_id' => $request->student_id,
                'subject_id' => $request->subject_id,
                'marks' => $request->marks,
            ]);
            Toastr::success('Result added successfully :)', 'Success');
            DB::commit();
            return redirect()->route('results.list');
        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('Failed to add result : ' . $e->getMessage(), 'Error');
            return redirect()->back();
        }
    }

    public function edit($id)
    {
        if (Auth::user()->role_name !== 'Admin' && Auth::user()->role_name !== 'Teachers') {
            Toastr::error('You do not have permission to edit results.', 'Error');
            return redirect()->route('results.list');
        }
        $result = Result::findOrFail($id);
        $teachers = User::whereIn('role_name', ['Admin', 'Teachers'])->get();
        $students = User::where('role_name', 'Student')->get();
        $subjects = Subject::all();
        return view('results.edit-result', compact('result', 'teachers', 'students', 'subjects'));
    }

    public function update(Request $request, $id)
    {
        if (Auth::user()->role_name !== 'Admin' && Auth::user()->role_name !== 'Teachers') {
            Toastr::error('You do not have permission to update results.', 'Error');
            return redirect()->route('results.list');
        }

        $request->validate([
            'teacher_id' => 'required|exists:users,id',
            'student_id' => 'required|exists:users,id',
            'subject_id' => 'required|exists:subjects,id',
            'marks' => 'required|numeric|min:0|max:100',
        ]);

        DB::beginTransaction();
        try {
            $result = Result::findOrFail($id);
            $result->update([
                'teacher_id' => $request->teacher_id,
                'student_id' => $request->student_id,
                'subject_id' => $request->subject_id,
                'marks' => $request->marks,
            ]);
            Toastr::success('Result updated successfully :)', 'Success');
            DB::commit();
            return redirect()->route('results.list');
        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('Failed to update result : ' . $e->getMessage(), 'Error');
            return redirect()->back();
        }
    }

    public function show($id)
    {
        $result = Result::with(['teacher', 'student', 'subject'])->findOrFail($id);
        return view('results.result-profile', compact('result'));
    }

    public function destroy($id)
    {
        if (Auth::user()->role_name !== 'Admin' && Auth::user()->role_name !== 'Teachers') {
            Toastr::error('You do not have permission to delete results.', 'Error');
            return redirect()->route('results.list');
        }

        DB::beginTransaction();
        try {
            $result = Result::findOrFail($id);
            $result->delete();
            Toastr::success('Result deleted successfully :)', 'Success');
            DB::commit();
            return redirect()->route('results.list');
        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('Failed to delete result : ' . $e->getMessage(), 'Error');
            return redirect()->back();
        }
    }

    /** Download Results List Report as PDF */
    public function downloadListReport()
    {
        try {
            $results = Result::with(['teacher', 'student', 'subject'])->get();

            if ($results->isEmpty()) {
                Toastr::error('No results available to download :(', 'Error');
                return redirect()->back();
            }

            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('results.results_list_report', compact('results'));
            return $pdf->download('results_list_report_' . now()->format('Ymd_His') . '.pdf');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Exception while generating results list report: ' . $e->getMessage());
            Toastr::error('Failed to generate report :(', 'Error');
            return redirect()->back();
        }
    }

    /** Download Result Profile Report as PDF */
    public function downloadProfileReport($id)
    {
        try {
            $result = Result::with(['teacher', 'student', 'subject'])->findOrFail($id);
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('results.result_profile_report', compact('result'));
            return $pdf->download('result_profile_' . $result->id . '_' . now()->format('Ymd_His') . '.pdf');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Exception while generating result profile report: ' . $e->getMessage());
            Toastr::error('Failed to generate report :(', 'Error');
            return redirect()->back();
        }
    }
}
