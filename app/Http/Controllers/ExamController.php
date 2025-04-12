<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\ExamResult;
use App\Models\Student;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;

class ExamController extends Controller
{
    // Show list of exams
    public function index()
    {
        $exams = Exam::all(); // Retrieve all exams
        return view('exams.index', compact('exams')); // Pass exams to the view
    }

    // Show form to create a new exam
    public function create()
    {
        return view('exams.create');
    }

    // Store new exam
    public function store(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'exam_date' => 'required|date',
        ]);

        // Create a new exam record
        Exam::create($validated);

        // Redirect with success message
        Toastr::success('Exam created successfully!', 'Success');
        return redirect()->route('exams.index');
    }

    // Show specific exam results
    public function show(Exam $exam)
    {
        // Load related exam results
        $examResults = $exam->examResults;
        $students = Student::all(); // Get all students to populate the student selection dropdown
        return view('exams.show', compact('exam', 'examResults', 'students'));
    }

    // Add exam result
    public function addResult(Request $request, Exam $exam)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'marks_obtained' => 'required|integer',
            'status' => 'required|string',
        ]);

        // Create a new exam result
        $result = new ExamResult($validated);
        $result->exam_id = $exam->id;  // Associate the result with the exam
        $result->save();

        Toastr::success('Exam result added successfully!', 'Success');
        return redirect()->route('exams.show', $exam->id);
    }

    // Edit exam details
    public function edit(Exam $exam)
    {
        return view('exams.edit', compact('exam'));
    }

    // Update exam details
    public function update(Request $request, Exam $exam)
    {
        // Validate the request
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'exam_date' => 'required|date',
        ]);

        // Update the exam record
        $exam->update($validated);

        Toastr::success('Exam updated successfully!', 'Success');
        return redirect()->route('exams.index');
    }

    // Delete an exam
    public function destroy(Exam $exam)
    {
        $exam->delete(); // Delete the exam record

        Toastr::success('Exam deleted successfully!', 'Success');
        return redirect()->route('exams.index');
    }
}
