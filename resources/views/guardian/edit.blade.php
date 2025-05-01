@extends('layouts.master')
@section('content')
<div class="page-wrapper">
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Edit Guardian</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('guardian/list') }}">Guardians</a></li>
                        <li class="breadcrumb-item active">Edit Guardian</li>
                    </ul>
                </div>
            </div>
        </div>
        {!! Toastr::message() !!}
        <div class="row">
            <div class="col-sm-12">
                <div class="card comman-shadow">
                    <div class="card-body">
                        <form action="{{ route('guardian/update') }}" method="POST" id="guardian-form">
                            @csrf
                            <input type="hidden" name="id" value="{{ $guardian->id }}">
                            <div class="row">
                                <div class="col-12">
                                    <h5 class="form-title student-info">Guardian Information</h5>
                                </div>
                                <div class="col-12 col-sm-4">
                                    <div class="form-group local-forms">
                                        <label>First Name <span class="login-danger">*</span></label>
                                        <input type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name', explode(' ', $guardian->name)[0]) }}">
                                        @error('first_name')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4">
                                    <div class="form-group local-forms">
                                        <label>Last Name <span class="login-danger">*</span></label>
                                        <input type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name', explode(' ', $guardian->name)[1] ?? '') }}">
                                        @error('last_name')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4">
                                    <div class="form-group local-forms">
                                        <label>Email <span class="login-danger">*</span></label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', $guardian->email) }}">
                                        @error('email')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4">
                                    <div class="form-group local-forms">
                                        <label>Phone <span class="login-danger">*</span></label>
                                        <input type="text" class="form-control @error('phone_number') is-invalid @enderror" name="phone_number" value="{{ old('phone_number', $guardian->phone_number) }}">
                                        @error('phone_number')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4">
                                    <div class="form-group local-forms">
                                        <label>Password</label>
                                        <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Enter New Password (Optional)">
                                        @error('password')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4">
                                    <div class="form-group local-forms">
                                        <label>Relationship <span class="login-danger">*</span></label>
                                        <select name="relationship" id="relationship" class="form-control @error('relationship') is-invalid @enderror">
                                            <option value="">Select Relationship</option>
                                            <option value="Father" {{ old('relationship', $relationship) == 'Father' ? 'selected' : '' }}>Father</option>
                                            <option value="Mother" {{ old('relationship', $relationship) == 'Mother' ? 'selected' : '' }}>Mother</option>
                                            <option value="Other" {{ old('relationship', $relationship) == 'Other' ? 'selected' : '' }}>Other</option>
                                        </select>
                                        @error('relationship')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <h5 class="form-title student-info">Select Students</h5>
                                </div>
                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover student-table" id="student-table">
                                            <thead>
                                                <tr>
                                                    <th style="width: 10%;">Select</th>
                                                    <th style="width: 25%;">Name</th>
                                                    <th style="width: 20%;">Admission ID</th>
                                                    <th style="width: 20%;">Roll Number</th>
                                                    <th style="width: 25%;">Date of Birth</th>
                                                </tr>
                                            </thead>
                                            <tbody id="student-table-body">
                                                @forelse ($students as $student)
                                                    <tr class="student-row" data-name="{{ strtolower($student->first_name . ' ' . $student->last_name) }}" data-admission-id="{{ strtolower($student->admission_id) }}">
                                                        <td>
                                                            <input type="checkbox" name="students[]" value="{{ $student->id }}" class="student-checkbox" data-student='{"id": "{{ $student->id }}", "name": "{{ $student->first_name }} {{ $student->last_name }}", "admission_id": "{{ $student->admission_id }}", "roll_number": "{{ $student->roll_number ?? 'N/A' }}", "date_of_birth": "{{ $student->date_of_birth ?? 'N/A' }}"}' {{ in_array($student->id, $selectedStudents) ? 'checked' : '' }}>
                                                        </td>
                                                        <td>{{ $student->first_name }} {{ $student->last_name }}</td>
                                                        <td>{{ $student->admission_id }}</td>
                                                        <td>{{ $student->roll_number ?? 'N/A' }}</td>
                                                        <td>{{ $student->date_of_birth ?? 'N/A' }}</td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="5" class="text-center">No students found.</td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <h5 class="form-title student-info">Selected Students</h5>
                                    <div id="selected-students" class="table-responsive">
                                        <table class="table table-bordered selected-student-table">
                                            <thead>
                                                <tr>
                                                    <th>Details</th>
                                                </tr>
                                            </thead>
                                            <tbody id="selected-students-body"></tbody>
                                        </table>
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

@section('script')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<style>
    .student-table th, .student-table td {
        padding: 12px;
        text-align: left;
        vertical-align: middle;
    }
    .selected-student-table th, .selected-student-table td {
        padding: 12px;
        text-align: left;
        vertical-align: top;
    }
    .selected-student-table .student-details div {
        margin-bottom: 8px;
        font-size: 14px;
    }
    .selected-student-table .student-details strong {
        display: inline-block;
        width: 120px;
    }
</style>
<script>
    $(document).ready(function() {
        const selectedStudentsBody = $('#selected-students-body');
        const studentTableBody = $('#student-table-body');
        const studentRows = $('.student-row');

        function updateSelectedStudents() {
            selectedStudentsBody.empty();
            const relationship = $('#relationship').val() || 'Not selected';
            $('.student-checkbox:checked').each(function() {
                const student = $(this).data('student');
                selectedStudentsBody.append(`
                    <tr>
                        <td>
                            <div class="student-details">
                                <div><strong>Name:</strong> ${student.name}</div>
                                <div><strong>Admission ID:</strong> ${student.admission_id}</div>
                                <div><strong>Roll Number:</strong> ${student.roll_number}</div>
                                <div><strong>Date of Birth:</strong> ${student.date_of_birth}</div>
                                <div><strong>Relationship:</strong> ${relationship}</div>
                            </div>
                        </td>
                    </tr>
                `);
            });
        }

        $('.student-checkbox').on('change', function() {
            updateSelectedStudents();
        });

        $('#relationship').on('change', function() {
            updateSelectedStudents();
        });

        // Initial update
        updateSelectedStudents();
    });
</script>
@endsection