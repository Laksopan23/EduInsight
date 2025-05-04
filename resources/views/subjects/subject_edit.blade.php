@extends('layouts.master')

@section('content')
<div class="page-wrapper">
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <div class="page-sub-header">
                        <h3 class="page-title">Edit Subject</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('subjects.index') }}">Subjects</a></li>
                            <li class="breadcrumb-item active">Edit Subject</li>
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
                        <form action="{{ route('subjects.update', $subject->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Name</label>
                                        <input type="text" name="name" class="form-control" value="{{ $subject->name }}" required>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Grade</label>
                                        <select name="grade" class="form-control" required>
                                            @foreach($grades as $grade)
                                                <option value="{{ $grade }}" {{ $subject->grade == $grade ? 'selected' : '' }}>{{ $grade }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Category</label>
                                        <select name="category" class="form-control" required>
                                            @foreach($categories as $category)
                                                <option value="{{ $category }}" {{ $subject->category == $category ? 'selected' : '' }}>{{ $category }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Mandatory</label>
                                        <select name="is_mandatory" class="form-control" required>
                                            <option value="1" {{ $subject->is_mandatory ? 'selected' : '' }}>Yes</option>
                                            <option value="0" {{ !$subject->is_mandatory ? 'selected' : '' }}>No</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                    <a href="{{ route('subjects.index') }}" class="btn btn-secondary">Cancel</a>
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