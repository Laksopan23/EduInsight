@extends('layouts.master')
@section('content')
<div class="page-wrapper">
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <div class="page-sub-header">
                        <h3 class="page-title">Student Details</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('student/list') }}">Student</a></li>
                            <li class="breadcrumb-item active">Student Details</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="about-info">
                            <h4>Profile</h4>
                        </div>
                        <div class="student-profile-head">
                            <div class="profile-bg-img">
                                <img src="{{ URL::to('assets/img/profile-bg.jpg') }}" alt="Profile">
                            </div>
                            <div class="row">
                                <div class="col-lg-4 col-md-4">
                                    <div class="profile-user-box">
                                        <div class="profile-user-img">
                                            <img src="{{ $studentProfile->upload ? Storage::url('student-photos/'.$studentProfile->upload) : URL::to('images/photo_defaults.jpg') }}" alt="Profile">
                                        </div>
                                        <div class="names-profiles">
                                            <h4>{{ $studentProfile->first_name }} {{ $studentProfile->last_name }}</h4>
                                            <h5>Class {{ $studentProfile->class }} - {{ $studentProfile->section }}</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 d-flex align-items-center">
                                    <div class="follow-btn-group">
                                        <a href="{{ url('student/edit/'.$studentProfile->id) }}" class="btn btn-info">Edit Profile</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="student-personals-grp">
                            <div class="card">
                                <div class="card-body">
                                    <div class="heading-detail">
                                        <h4>Personal Details</h4>
                                    </div>
                                    <div class="personal-activity">
                                        <div class="personal-icons">
                                            <i class="feather-user"></i>
                                        </div>
                                        <div class="views-personal">
                                            <h4>Name</h4>
                                            <h5>{{ $studentProfile->first_name }} {{ $studentProfile->last_name }}</h5>
                                        </div>
                                    </div>
                                    <div class="personal-activity">
                                        <div class="personal-icons">
                                            <i class="feather-mail"></i>
                                        </div>
                                        <div class="views-personal">
                                            <h4>Email</h4>
                                            <h5>{{ $studentProfile->user->email }}</h5>
                                        </div>
                                    </div>
                                    <div class="personal-activity">
                                        <div class="personal-icons">
                                            <i class="feather-phone-call"></i>
                                        </div>
                                        <div class="views-personal">
                                            <h4>Mobile</h4>
                                            <h5>{{ $studentProfile->phone_number }}</h5>
                                        </div>
                                    </div>
                                    <div class="personal-activity">
                                        <div class="personal-icons">
                                            <i class="feather-user"></i>
                                        </div>
                                        <div class="views-personal">
                                            <h4>Gender</h4>
                                            <h5>{{ $studentProfile->gender }}</h5>
                                        </div>
                                    </div>
                                    <div class="personal-activity">
                                        <div class="personal-icons">
                                            <i class="feather-calendar"></i>
                                        </div>
                                        <div class="views-personal">
                                            <h4>Date of Birth</h4>
                                            <h5>{{ $studentProfile->date_of_birth }}</h5>
                                        </div>
                                    </div>
                                    <div class="personal-activity">
                                        <div class="personal-icons">
                                            <i class="feather-hash"></i>
                                        </div>
                                        <div class="views-personal">
                                            <h4>Admission ID</h4>
                                            <h5>{{ $studentProfile->admission_id }}</h5>
                                        </div>
                                    </div>
                                    <div class="personal-activity mb-0">
                                        <div class="personal-icons">
                                            <i class="feather-droplet"></i>
                                        </div>
                                        <div class="views-personal">
                                            <h4>Blood Group</h4>
                                            <h5>{{ $studentProfile->blood_group }}</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="student-personals-grp">
                            <div class="card mb-0">
                                <div class="card-body">
                                    <div class="heading-detail">
                                        <h4>Academic Details</h4>
                                    </div>
                                    <div class="personal-activity">
                                        <div class="personal-icons">
                                            <i class="feather-book"></i>
                                        </div>
                                        <div class="views-personal">
                                            <h4>Class</h4>
                                            <h5>{{ $studentProfile->class }}</h5>
                                        </div>
                                    </div>
                                    <div class="personal-activity">
                                        <div class="personal-icons">
                                            <i class="feather-bookmark"></i>
                                        </div>
                                        <div class="views-personal">
                                            <h4>Section</h4>
                                            <h5>{{ $studentProfile->section }}</h5>
                                        </div>
                                    </div>
                                    <div class="personal-activity">
                                        <div class="personal-icons">
                                            <i class="feather-hash"></i>
                                        </div>
                                        <div class="views-personal">
                                            <h4>Roll Number</h4>
                                            <h5>{{ $studentProfile->roll }}</h5>
                                        </div>
                                    </div>
                                    <div class="personal-activity mb-0">
                                        <div class="personal-icons">
                                            <i class="feather-users"></i>
                                        </div>
                                        <div class="views-personal">
                                            <h4>Religion</h4>
                                            <h5>{{ $studentProfile->religion }}</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection