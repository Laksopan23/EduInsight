<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;

class SubjectController extends Controller
{
    public function subjectList()
    {
        $subjects = Subject::all()->groupBy('grade');
        return view('subjects.subject_list', compact('subjects'));
    }

    public function subjectAdd()
    {
        $grades = ['Grade 6', 'Grade 7', 'Grade 8', 'Grade 9', 'Grade 10', 'Grade 11'];
        $categories = ['Core', 'Basket 1', 'Basket 2', 'Basket 3'];
        return view('subjects.subject_add', compact('grades', 'categories'));
    }

    public function saveRecord(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:subjects,name,NULL,id,grade,' . $request->grade,
            'grade' => 'required|in:Grade 6,Grade 7,Grade 8,Grade 9,Grade 10,Grade 11',
            'category' => 'required|in:Core,Basket 1,Basket 2,Basket 3',
            'is_mandatory' => 'required|boolean',
        ]);

        Subject::create([
            'name' => $request->name,
            'grade' => $request->grade,
            'category' => $request->category,
            'is_mandatory' => $request->is_mandatory,
        ]);

        Toastr::success('Subject added successfully', 'Success');
        return redirect()->route('subject/list/page');
    }

    public function subjectEdit($id)
    {
        $subject = Subject::findOrFail($id);
        $grades = ['Grade 6', 'Grade 7', 'Grade 8', 'Grade 9', 'Grade 10', 'Grade 11'];
        $categories = ['Core', 'Basket 1', 'Basket 2', 'Basket 3'];
        return view('subjects.subject_edit', compact('subject', 'grades', 'categories'));
    }

    public function updateRecord(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:subjects,id',
            'name' => 'required|string|max:255|unique:subjects,name,' . $request->id . ',id,grade,' . $request->grade,
            'grade' => 'required|in:Grade 6,Grade 7,Grade 8,Grade 9,Grade 10,Grade 11',
            'category' => 'required|in:Core,Basket 1,Basket 2,Basket 3',
            'is_mandatory' => 'required|boolean',
        ]);

        $subject = Subject::findOrFail($request->id);
        $subject->update([
            'name' => $request->name,
            'grade' => $request->grade,
            'category' => $request->category,
            'is_mandatory' => $request->is_mandatory,
        ]);

        Toastr::success('Subject updated successfully', 'Success');
        return redirect()->route('subject/list/page');
    }

    public function deleteRecord(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:subjects,id',
        ]);

        Subject::findOrFail($request->id)->delete();

        Toastr::success('Subject deleted successfully', 'Success');
        return redirect()->route('subject/list/page');
    }
}
