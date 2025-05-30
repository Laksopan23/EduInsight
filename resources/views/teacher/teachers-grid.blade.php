@extends('layouts.master')
@section('content')
<div class="page-wrapper">
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <div class="page-sub-header">
                        <h3 class="page-title">Teachers</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('teacher/list') }}">Teacher</a></li>
                            <li class="breadcrumb-item active">All Teachers</li>
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
                                    <h3 class="page-title">Teachers</h3>
                                </div>
                                <div class="col-auto text-end float-end ms-auto download-grp">
                                    <a href="{{ route('teacher/list') }}" class="btn btn-outline-gray me-2"><i class="fa fa-list"></i></a>
                                    <a href="{{ route('teacher/grid') }}" class="btn btn-outline-gray me-2 active"><i class="fa fa-th"></i></a>
                                    <a href="{{ route('teacher/add') }}" class="btn btn-primary"><i class="fas fa-plus"></i></a>
                                </div>
                            </div>
                        </div>

                        <div class="student-pro-list">
                            <div class="row">
                                @foreach ($teacherGrid as $list)
                                <div class="col-xl-3 col-lg-4 col-md-6 d-flex">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="student-box flex-fill">
                                                <div class="student-img">
                                                    <a href="{{ url('teacher/profile/'.$list->id) }}">
                                                        <img class="img-fluid" alt="Teacher Info" src="{{ $list->user->avatar ? Storage::url('images/'.$list->user->avatar) : URL::to('images/photo_defaults.jpg') }}" width="20%" height="20%">
                                                    </a>
                                                </div>
                                                <div class="student-content pb-0">
                                                    <h5><a href="{{ url('teacher/profile/'.$list->id) }}">{{ $list->full_name }}</a></h5>
                                                    <h6>{{ $list->user->email }}</h6>
                                                    <p>Qualification: {{ $list->qualification }}</p>
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
@endsection