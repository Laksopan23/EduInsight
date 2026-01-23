<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Barryvdh\DomPDF\Facade\PDF;

class SubjectController extends Controller
{
    public function index(Request $request)
    {
        $query = Subject::query();

        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('grade', 'like', '%' . $search . '%')
                    ->orWhere('category', 'like', '%' . $search . '%');
            });
        }

        $subjects = $query->get()->groupBy('grade');
        return view('subjects.subject_list', compact('subjects'));
    }

    public function create()
    {
        $grades = ['Grade 6', 'Grade 7', 'Grade 8', 'Grade 9', 'Grade 10', 'Grade 11'];
        $categories = ['Core', 'Basket 1', 'Basket 2', 'Basket 3'];
        return view('subjects.subject_add', compact('grades', 'categories'));
    }

    public function store(Request $request)
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
        return redirect()->route('subjects.index');
    }

    public function edit($id)
    {
        $subject = Subject::findOrFail($id);
        $grades = ['Grade 6', 'Grade 7', 'Grade 8', 'Grade 9', 'Grade 10', 'Grade 11'];
        $categories = ['Core', 'Basket 1', 'Basket 2', 'Basket 3'];
        return view('subjects.subject_edit', compact('subject', 'grades', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:subjects,name,' . $id . ',id,grade,' . $request->grade,
            'grade' => 'required|in:Grade 6,Grade 7,Grade 8,Grade 9,Grade 10,Grade 11',
            'category' => 'required|in:Core,Basket 1,Basket 2,Basket 3',
            'is_mandatory' => 'required|boolean',
        ]);

        $subject = Subject::findOrFail($id);
        $subject->update([
            'name' => $request->name,
            'grade' => $request->grade,
            'category' => $request->category,
            'is_mandatory' => $request->is_mandatory,
        ]);

        Toastr::success('Subject updated successfully', 'Success');
        return redirect()->route('subjects.index');
    }

    public function destroy($id)
    {
        $subject = Subject::findOrFail($id);
        $subject->delete();

        Toastr::success('Subject deleted successfully', 'Success');
        return redirect()->route('subjects.index');
    }

    public function downloadSubjectsPDF()
    {
        $subjects = Subject::all()->groupBy('grade');
        $pdf = PDF::loadView('subjects.subjects-pdf', compact('subjects'));
        return $pdf->download('subjects_list.pdf');
    }
}
