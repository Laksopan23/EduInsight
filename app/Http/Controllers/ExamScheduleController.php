<?php

namespace App\Http\Controllers;

use App\Models\ExamSchedule;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class ExamScheduleController extends Controller
{
    // Display the list of exam schedules and tutorials
    public function index()
    {
        $examSchedules = ExamSchedule::whereNotNull('exam_date')->get();
        $tutorials = ExamSchedule::whereNull('exam_date')->get();
        return view('exam_schedule.list', compact('examSchedules', 'tutorials'));
    }

    // Show the form to add a new exam schedule and tutorials (Admins and Teachers only)
    public function create()
    {
        if (Session::get('role_name') === 'Admin' || Session::get('role_name') === 'Teachers') {
            return view('exam_schedule.add');
        }
        return redirect()->route('exam_schedule/list')->with('error', 'Unauthorized access');
    }

    // Fetch subjects for a given grade (AJAX)
    public function getSubjects(Request $request)
    {
        $grade = $request->input('grade');
        $subjects = Subject::where('grade', $grade)->get();
        return response()->json($subjects);
    }

    // Store new exam schedules (Admins and Teachers only)
    public function storeSchedule(Request $request)
    {
        if (Session::get('role_name') === 'Admin' || Session::get('role_name') === 'Teachers') {
            $request->validate([
                'grade' => 'required|string',
                'category' => 'required|string',
                'subjects' => 'required|array',
                'subjects.*.subject' => 'required|string',
                'subjects.*.exam_date' => 'required|date',
                'subjects.*.exam_time' => 'required',
                'subjects.*.venue' => 'nullable|string',
            ]);

            $index = 0;
            foreach ($request->subjects as $subjectData) {
                ExamSchedule::create([
                    'grade' => $request->grade,
                    'category' => $request->category,
                    'subject' => $subjectData['subject'],
                    'exam_date' => $subjectData['exam_date'],
                    'exam_time' => $subjectData['exam_time'],
                    'venue' => $subjectData['venue'],
                    'pdf_path' => null,
                ]);
                $index++;
            }

            return redirect()->route('exam_schedule/list')->with('success', 'Exam schedules added successfully');
        }
        return redirect()->route('exam_schedule/list')->with('error', 'Unauthorized access');
    }

    // Store new tutorials (Admins and Teachers only)
    public function storeTutorial(Request $request)
    {
        if (Session::get('role_name') === 'Admin' || Session::get('role_name') === 'Teachers') {
            $request->validate([
                'tutorials' => 'required|array',
                'tutorials.*.grade' => 'required|string',
                'tutorials.*.subject' => 'required|string',
                'tutorials.*.pdf' => 'required|file|mimes:pdf|max:2048',
            ]);

            $index = 0;
            foreach ($request->tutorials as $tutorialData) {
                $pdfPath = $request->file("tutorials.{$index}.pdf")->store('exam_schedules', 'public');

                ExamSchedule::create([
                    'grade' => $tutorialData['grade'],
                    'subject' => $tutorialData['subject'],
                    'pdf_path' => $pdfPath,
                    'exam_date' => null,
                    'exam_time' => null,
                    'venue' => null,
                    'category' => 'Tutorial',
                ]);
                $index++;
            }

            return redirect()->route('exam_schedule/list')->with('success', 'Tutorials added successfully');
        }
        return redirect()->route('exam_schedule/list')->with('error', 'Unauthorized access');
    }

    // Show the form to edit an exam schedule or tutorial (Admins and Teachers only)
    public function edit($id)
    {
        if (Session::get('role_name') === 'Admin' || Session::get('role_name') === 'Teachers') {
            $examSchedule = ExamSchedule::findOrFail($id);
            return view('exam_schedule.edit', compact('examSchedule'));
        }
        return redirect()->route('exam_schedule/list')->with('error', 'Unauthorized access');
    }

    // Update an exam schedule or tutorial (Admins and Teachers only)
    public function update(Request $request, $id)
    {
        if (Session::get('role_name') === 'Admin' || Session::get('role_name') === 'Teachers') {
            $examSchedule = ExamSchedule::findOrFail($id);

            if ($examSchedule->exam_date) {
                // Updating an exam schedule
                $request->validate([
                    'grade' => 'required|string',
                    'category' => 'required|string',
                    'subject' => 'required|string',
                    'exam_date' => 'required|date',
                    'exam_time' => 'required',
                    'venue' => 'nullable|string',
                ]);
                $data = $request->all();
                $data['pdf_path'] = null; // Ensure PDF is not updated for schedules
            } else {
                // Updating a tutorial
                $request->validate([
                    'grade' => 'required|string',
                    'subject' => 'required|string',
                    'pdf' => 'nullable|file|mimes:pdf|max:2048',
                ]);
                $data = $request->all();
                $data['category'] = 'Tutorial';
                $data['exam_date'] = null;
                $data['exam_time'] = null;
                $data['venue'] = null;

                if ($request->hasFile('pdf')) {
                    if ($examSchedule->pdf_path && Storage::disk('public')->exists($examSchedule->pdf_path)) {
                        Storage::disk('public')->delete($examSchedule->pdf_path);
                    }
                    $data['pdf_path'] = $request->file('pdf')->store('exam_schedules', 'public');
                }
            }

            $examSchedule->update($data);
            return redirect()->route('exam_schedule/list')->with('success', 'Exam schedule or tutorial updated successfully');
        }
        return redirect()->route('exam_schedule/list')->with('error', 'Unauthorized access');
    }

    // Delete an exam schedule or tutorial (Admins and Teachers only)
    public function destroy(Request $request)
    {
        if (Session::get('role_name') === 'Admin' || Session::get('role_name') === 'Teachers') {
            $id = $request->input('id');
            $examSchedule = ExamSchedule::findOrFail($id);

            if ($examSchedule->pdf_path && Storage::disk('public')->exists($examSchedule->pdf_path)) {
                Storage::disk('public')->delete($examSchedule->pdf_path);
            }

            $examSchedule->delete();
            return redirect()->route('exam_schedule/list')->with('success', 'Exam schedule or tutorial deleted successfully');
        }
        return redirect()->route('exam_schedule/list')->with('error', 'Unauthorized access');
    }
}
