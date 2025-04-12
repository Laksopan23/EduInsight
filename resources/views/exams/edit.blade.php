{{-- exam/edit.blade.php --}}
@extends('layouts.master')

@section('content')
<div class="page-wrapper">
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <div class="page-sub-header">
                        <h3 class="page-title">Edit Exam</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('exam.list') }}">Exam List</a></li>
                            <li class="breadcrumb-item active">Edit Exam</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="card card-table comman-shadow">
                    <div class="card-body pb-0">
                        <form action="{{ route('exam.update') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id" value="{{ $exam->id }}">
                            <div class="form-group">
                                <label for="name">Exam Name</label>
                                <input type="text" class="form-control" name="name" value="{{ $exam->name }}" required>
                            </div>
                            <div class="form-group">
                                <label for="subject">Subject</label>
                                <input type="text" class="form-control" name="subject" value="{{ $exam->subject }}" required>
                            </div>
                            <div class="form-group">
                                <label for="exam_date">Exam Date</label>
                                <input type="date" class="form-control" name="exam_date" value="{{ $exam->exam_date }}" required>
                            </div>
                            <button type="submit" class="btn btn-success">Save Changes</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection