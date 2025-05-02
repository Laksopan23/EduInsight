@extends('layouts.master')
@section('content')
<div class="page-wrapper">
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-sm-12">
                    <div class="page-sub-header">
                        <h3 class="page-title">Add Subject</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('subject/list/page') }}">Subjects</a></li>
                            <li class="breadcrumb-item active">Add Subject</li>
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
                        <form action="{{ route('subject/save') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-12">
                                    <h5 class="form-title student-info">Subject Information</h5>
                                </div>
                                <div class="col-12 col-sm-4">
                                    <div class="form-group local-forms">
                                        <label>Name <span class="login-danger">*</span></label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" placeholder="Enter Subject Name">
                                        @error('name')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4">
                                    <div class="form-group local-forms">
                                        <label>Grade <span class="login-danger">*</span></label>
                                        <select class="form-control @error('grade') is-invalid @enderror" name="grade">
                                            @foreach ($grades as $grade)
                                                <option value="{{ $grade }}" {{ old('grade') == $grade ? 'selected' : '' }}>{{ $grade }}</option>
                                            @endforeach
                                        </select>
                                        @error('grade')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4">
                                    <div class="form-group local-forms">
                                        <label>Category <span class="login-danger">*</span></label>
                                        <select class="form-control @error('category') is-invalid @enderror" name="category">
                                            @foreach ($categories as $category)
                                                <option value="{{ $category }}" {{ old('category') == $category ? 'selected' : '' }}>{{ $category }}</option>
                                            @endforeach
                                        </select>
                                        @error('category')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4">
                                    <div class="form-group local-forms">
                                        <label>Mandatory <span class="login-danger">*</span></label>
                                        <select class="form-control @error('is_mandatory') is-invalid @enderror" name="is_mandatory">
                                            <option value="1" {{ old('is_mandatory') == '1' ? 'selected' : '' }}>Yes</option>
                                            <option value="0" {{ old('is_mandatory') == '0' ? 'selected' : '' }}>No</option>
                                        </select>
                                        @error('is_mandatory')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="student-submit">
                                        <button type="submit" class="btn btn-primary">Submit</button>
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