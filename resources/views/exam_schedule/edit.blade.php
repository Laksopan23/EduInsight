@extends('layouts.master')
@section('content')
<div class="page-wrapper">
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <div class="page-sub-header">
                        <h3 class="page-title">Edit Exam Schedule</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('exam_schedule/list') }}">Exam Schedule</a></li>
                            <li class="breadcrumb-item active">Edit</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        {!! Toastr::message() !!}
        <div class="row">
            <div class="col-sm-12">
                <div class="card comman-shadow">
                    <div class="card-body">
                        <form action="{{ route('exam_schedule/update', $examSchedule->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-12">
                                    <h5 class="form-title student-info">Exam Schedule Information</h5>
                                </div>
                                <div class="col-12 col-sm-4">
                                    <div class="form-group local-forms">
                                        <label>Grade <span class="login-danger">*</span></label>
                                        <select name="grade" class="form-control select @error('grade') is-invalid @enderror" required>
                                            <option value="">Select Grade</option>
                                            @for ($i = 1; $i <= 13; $i++)
                                                <option value="Grade {{ $i }}" {{ $examSchedule->grade == 'Grade '.$i ? 'selected' : '' }}>Grade {{ $i }}</option>
                                            @endfor
                                        </select>
                                        @error('grade')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4">
                                    <div class="form-group local-forms">
                                        <label>Category <span class="login-danger">*</span></label>
                                        <select name="category" class="form-control select @error('category') is-invalid @enderror" required>
                                            <option value="">Select Category</option>
                                            <option value="Term Test" {{ $examSchedule->category == 'Term Test' ? 'selected' : '' }}>Term Test</option>
                                            <option value="Scholarship Exam" {{ $examSchedule->category == 'Scholarship Exam' ? 'selected' : '' }}>Scholarship Exam</option>
                                            <option value="GCE O-Level" {{ $examSchedule->category == 'GCE O-Level' ? 'selected' : '' }}>GCE O-Level</option>
                                            <option value="GCE A-Level" {{ $examSchedule->category == 'GCE A-Level' ? 'selected' : '' }}>GCE A-Level</option>
                                        </select>
                                        @error('category')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4">
                                    <div class="form-group local-forms">
                                        <label>Subject <span class="login-danger">*</span></label>
                                        <input type="text" name="subject" class="form-control @error('subject') is-invalid @enderror" value="{{ $examSchedule->subject }}" required>
                                        @error('subject')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4">
                                    <div class="form-group local-forms">
                                        <label>Exam Date <span class="login-danger">*</span></label>
                                        <input type="date" name="exam_date" class="form-control @error('exam_date') is-invalid @enderror" value="{{ $examSchedule->exam_date }}" required>
                                        @error('exam_date')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4">
                                    <div class="form-group local-forms">
                                        <label>Exam Time <span class="login-danger">*</span></label>
                                        <input type="time" name="exam_time" class="form-control @error('exam_time') is-invalid @enderror" value="{{ $examSchedule->exam_time }}" required>
                                        @error('exam_time')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4">
                                    <div class="form-group local-forms">
                                        <label>Venue</label>
                                        <input type="text" name="venue" class="form-control @error('venue') is-invalid @enderror" value="{{ $examSchedule->venue }}" placeholder="Enter Venue (Optional)">
                                        @error('venue')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="student-submit">
                                        <button type="submit" class="btn btn-primary">Update</button>
                                    </div>
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