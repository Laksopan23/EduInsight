@extends('layouts.master')

@section('content')
{!! Toastr::message() !!}
<div class="page-wrapper">
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Edit Result</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('results.list') }}">Results</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <form method="POST" action="{{ route('results.update', $result->id) }}">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="teacher_id">Teacher <span class="text-danger">*</span></label>
                                        <select name="teacher_id" id="teacher_id" class="form-control" required>
                                            @foreach($teachers as $teacher)
                                                <option value="{{ $teacher->id }}" {{ $result->teacher_id == $teacher->id ? 'selected' : '' }}>
                                                    {{ $teacher->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="student_id">Student <span class="text-danger">*</span></label>
                                        <select name="student_id" id="student_id" class="form-control" required>
                                            @foreach($students as $student)
                                                <option value="{{ $student->id }}" {{ $result->student_id == $student->id ? 'selected' : '' }}>
                                                    {{ $student->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="subject_id">Subject <span class="text-danger">*</span></label>
                                        <select name="subject_id" id="subject_id" class="form-control" required>
                                            @foreach($subjects as $subject)
                                                <option value="{{ $subject->id }}" {{ $result->subject_id == $subject->id ? 'selected' : '' }}>
                                                    {{ $subject->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="marks">Marks <span class="text-danger">*</span></label>
                                        <input type="number" name="marks" id="marks" class="form-control" value="{{ $result->marks }}" step="0.01" min="0" max="100" required>
                                    </div>
                                </div>
                                <div class="col-lg-12 text-end">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection