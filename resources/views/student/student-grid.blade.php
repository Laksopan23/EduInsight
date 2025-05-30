@extends('layouts.master')
@section('content')
<div class="page-wrapper">
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <div class="page-sub-header">
                        <h3 class="page-title">Students</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('student/list') }}">Student</a></li>
                            <li class="breadcrumb-item active">All Students</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="card card-table comman-shadow">
                    <div class="card-body pb-0">
                        <div class="page-header">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h3 class="page-title">Students</h3>
                                </div>
                                <div class="col-auto text-end float-end ms-auto download-grp">
                                    <a href="{{ route('student/list') }}" class="btn btn-outline-gray me-2"><i class="fa fa-list"></i></a>
                                    <a href="{{ route('student/grid') }}" class="btn btn-outline-gray me-2 active"><i class="fa fa-th"></i></a>
                                    <a href="{{ route('student/add/page') }}" class="btn btn-primary"><i class="fas fa-plus"></i></a>
                                </div>
                            </div>
                        </div>

                        <div class="student-pro-list">
                            <div class="row">
                                @foreach ($studentList as $list)
                                <div class="col-xl-3 col-lg-4 col-md-6 d-flex">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="student-box flex-fill">
                                                <div class="student-img">
                                                    <a href="{{ url('student/profile/'.$list->id) }}">
                                                        <img class="img-fluid" alt="Student Info" src="{{ $list->upload ? Storage::url('student-photos/'.$list->upload) : URL::to('images/photo_defaults.jpg') }}" width="20%" height="20%">
                                                    </a>
                                                </div>
                                                <div class="student-content pb-0">
                                                    <h5><a href="{{ url('student/profile/'.$list->id) }}">{{ $list->first_name }} {{ $list->last_name }}</a></h5>
                                                    <h6>{{ $list->user->email }}</h6>
                                                    <p>Class: {{ $list->class }} {{ $list->section }}</p>
                                                    <p>Admission ID: {{ $list->admission_id }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection