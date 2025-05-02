<?php

namespace App\Http\Controllers;

use App\Models\ExamSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ExamScheduleController extends Controller
{
    // Display the list of exam schedules
    public function index()
    {
        $examSchedules = ExamSchedule::all();
        return view('exam_schedule.list', compact('examSchedules'));
    }

    // Show the form to add a new exam schedule (Admins and Teachers only)
    public function create()
    {
        if (Session::get('role_name') === 'Admin' || Session::get('role_name') === 'Teachers') {
            return view('exam_schedule.add');
        }
        return redirect()->route('exam_schedule/list')->with('error', 'Unauthorized access');
    }

    // Store a new exam schedule (Admins and Teachers only)
    public function store(Request $request)
    {
        if (Session::get('role_name') === 'Admin' || Session::get('role_name') === 'Teachers') {
            $request->validate([
                'grade' => 'required|string',
                'category' => 'required|string',
                'subject' => 'required|string',
                'exam_date' => 'required|date',
                'exam_time' => 'required',
                'venue' => 'nullable|string',
            ]);

            ExamSchedule::create($request->all());
            return redirect()->route('exam_schedule/list')->with('success', 'Exam schedule added successfully');
        }
        return redirect()->route('exam_schedule/list')->with('error', 'Unauthorized access');
    }

    // Show the form to edit an exam schedule (Admins and Teachers only)
    public function edit($id)
    {
        if (Session::get('role_name') === 'Admin' || Session::get('role_name') === 'Teachers') {
            $examSchedule = ExamSchedule::findOrFail($id);
            return view('exam_schedule.edit', compact('examSchedule'));
        }
        return redirect()->route('exam_schedule/list')->with('error', 'Unauthorized access');
    }

    // Update an exam schedule (Admins and Teachers only)
    public function update(Request $request, $id)
    {
        if (Session::get('role_name') === 'Admin' || Session::get('role_name') === 'Teachers') {
            $request->validate([
                'grade' => 'required|string',
                'category' => 'required|string',
                'subject' => 'required|string',
                'exam_date' => 'required|date',
                'exam_time' => 'required',
                'venue' => 'nullable|string',
            ]);

            $examSchedule = ExamSchedule::findOrFail($id);
            $examSchedule->update($request->all());
            return redirect()->route('exam_schedule/list')->with('success', 'Exam schedule updated successfully');
        }
        return redirect()->route('exam_schedule/list')->with('error', 'Unauthorized access');
    }

    // Delete an exam schedule (Admins and Teachers only)
    public function destroy($id)
    {
        if (Session::get('role_name') === 'Admin' || Session::get('role_name') === 'Teachers') {
            $examSchedule = ExamSchedule::findOrFail($id);
            $examSchedule->delete();
            return redirect()->route('exam_schedule/list')->with('success', 'Exam schedule deleted successfully');
        }
        return redirect()->route('exam_schedule/list')->with('error', 'Unauthorized access');
    }
}
