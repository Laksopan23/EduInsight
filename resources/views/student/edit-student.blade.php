@extends('layouts.master')
@section('content')
<div class="page-wrapper">
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Edit Student</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('student/list') }}">Students</a></li>
                        <li class="breadcrumb-item active">Edit Student</li>
                    </ul>
                </div>
            </div>
        </div>
        {!! Toastr::message() !!}
        <div class="row">
            <div class="col-sm-12">
                <div class="card comman-shadow">
                    <div class="card-body">
                        <form action="{{ route('student/update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" value="{{ $studentEdit->id }}">
                            <input type="hidden" name="user_id" value="{{ $studentEdit->user_id_fk }}">
                            <div class="row">
                                <div class="col-12">
                                    <h5 class="form-title student-info">Student Information</h5>
                                </div>
                                <div class="col-12 col-sm-4">
                                    <div class="form-group local-forms">
                                        <label>First Name <span class="login-danger">*</span></label>
                                        <input type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name', $studentEdit->first_name) }}">
                                        @error('first_name')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4">
                                    <div class="form-group local-forms">
                                        <label>Last Name <span class="login-danger">*</span></label>
                                        <input type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name', $studentEdit->last_name) }}">
                                        @error('last_name')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4">
                                    <div class="form-group local-forms">
                                        <label>Email <span class="login-danger">*</span></label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', $studentEdit->user->email) }}">
                                        @error('email')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4">
                                    <div class="form-group local-forms">
                                        <label>Password</label>
                                        <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Enter New Password (Leave blank to keep current)">
                                        @error('password')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4">
                                    <div class="form-group local-forms">
                                        <label>Gender <span class="login-danger">*</span></label>
                                        <select class="form-control select @error('gender') is-invalid @enderror" name="gender">
                                            <option selected disabled>Select Gender</option>
                                            <option value="Female" {{ old('gender', $studentEdit->gender) == 'Female' ? 'selected' : '' }}>Female</option>
                                            <option value="Male" {{ old('gender', $studentEdit->gender) == 'Male' ? 'selected' : '' }}>Male</option>
                                            <option value="Others" {{ old('gender', $studentEdit->gender) == 'Others' ? 'selected' : '' }}>Others</option>
                                        </select>
                                        @error('gender')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4">
                                    <div class="form-group local-forms">
                                        <label>Date Of Birth <span class="login-danger">*</span></label>
                                        <input type="date" class="form-control @error('date_of_birth') is-invalid @enderror" name="date_of_birth" value="{{ old('date_of_birth', $studentEdit->date_of_birth) }}">
                                        @error('date_of_birth')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4">
                                    <div class="form-group local-forms">
                                        <label>Roll <span class="login-danger">*</span></label>
                                        <input type="text" class="form-control @error('roll') is-invalid @enderror" name="roll" value="{{ old('roll', $studentEdit->roll) }}">
                                        @error('roll')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4">
                                    <div class="form-group local-forms">
                                        <label>Blood Group <span class="login-danger">*</span></label>
                                        <select class="form-control select @error('blood_group') is-invalid @enderror" name="blood_group">
                                            <option selected disabled>Please Select Group</option>
                                            <option value="A+" {{ old('blood_group', $studentEdit->blood_group) == 'A+' ? 'selected' : '' }}>A+</option>
                                            <option value="B+" {{ old('blood_group', $studentEdit->blood_group) == 'B+' ? 'selected' : '' }}>B+</option>
                                            <option value="O+" {{ old('blood_group', $studentEdit->blood_group) == 'O+' ? 'selected' : '' }}>O+</option>
                                            <option value="A-" {{ old('blood_group', $studentEdit->blood_group) == 'A-' ? 'selected' : '' }}>A-</option>
                                            <option value="B-" {{ old('blood_group', $studentEdit->blood_group) == 'B-' ? 'selected' : '' }}>B-</option>
                                            <option value="O-" {{ old('blood_group', $studentEdit->blood_group) == 'O-' ? 'selected' : '' }}>O-</option>
                                            <option value="AB+" {{ old('blood_group', $studentEdit->blood_group) == 'AB+' ? 'selected' : '' }}>AB+</option>
                                            <option value="AB-" {{ old('blood_group', $studentEdit->blood_group) == 'AB-' ? 'selected' : '' }}>AB-</option>
                                        </select>
                                        @error('blood_group')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4">
                                    <div class="form-group local-forms">
                                        <label>Religion <span class="login-danger">*</span></label>
                                        <select class="form-control select @error('religion') is-invalid @enderror" name="religion">
                                            <option selected disabled>Please Select Religion</option>
                                            <option value="Hindu" {{ old('religion', $studentEdit->religion) == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                                            <option value="Christian" {{ old('religion', $studentEdit->religion) == 'Christian' ? 'selected' : '' }}>Christian</option>
                                            <option value="Others" {{ old('religion', $studentEdit->religion) == 'Others' ? 'selected' : '' }}>Others</option>
                                        </select>
                                        @error('religion')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4">
                                    <div class="form-group local-forms">
                                        <label>Class <span class="login-danger">*</span></label>
                                        <select class="form-control select @error('class') is-invalid @enderror" name="class">
                                            <option selected disabled>Please Select Class</option>
                                            <option value="12" {{ old('class', $studentEdit->class) == '12' ? 'selected' : '' }}>12</option>
                                            <option value="11" {{ old('class', $studentEdit->class) == '11' ? 'selected' : '' }}>11</option>
                                            <option value="10" {{ old('class', $studentEdit->class) == '10' ? 'selected' : '' }}>10</option>
                                        </select>
                                        @error('class')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4">
                                    <div class="form-group local-forms">
                                        <label>Section <span class="login-danger">*</span></label>
                                        <select class="form-control select @error('section') is-invalid @enderror" name="section">
                                            <option selected disabled>Please Select Section</option>
                                            <option value="A" {{ old('section', $studentEdit->section) == 'A' ? 'selected' : '' }}>A</option>
                                            <option value="B" {{ old('section', $studentEdit->section) == 'B' ? 'selected' : '' }}>B</option>
                                            <option value="C" {{ old('section', $studentEdit->section) == 'C' ? 'selected' : '' }}>C</option>
                                        </select>
                                        @error('section')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4">
                                    <div class="form-group local-forms">
                                        <label>Admission ID <span class="login-danger">*</span></label>
                                        <input type="text" class="form-control @error('admission_id') is-invalid @enderror" name="admission_id" value="{{ old('admission_id', $studentEdit->admission_id) }}">
                                        @error('admission_id')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4">
                                    <div class="form-group local-forms">
                                        <label>Phone <span class="login-danger">*</span></label>
                                        <input type="text" class="form-control @error('phone_number') is-invalid @enderror" name="phone_number" value="{{ old('phone_number', $studentEdit->phone_number) }}">
                                        @error('phone_number')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4">
                                    <div class="form-group students-up-files">
                                        <label>Upload Student Photo (150px X 150px)</label>
                                        <div class="uplod">
                                            <label class="file-upload image-upbtn mb-0 @error('upload') is-invalid @enderror">
                                                Choose File <input type="file" name="upload">
                                            </label>
                                            @error('upload')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                            @if($studentEdit->upload)
                                                <img src="{{ Storage::url('student-photos/' . $studentEdit->upload) }}" alt="Current Photo" width="50">
                                            @endif
                                        </div>
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