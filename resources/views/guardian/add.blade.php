@extends('layouts.master')
@section('content')
<div class="page-wrapper">
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-sm-12">
                    <div class="page-sub-header">
                        <h3 class="page-title">Add Guardian</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('guardian/list') }}">Guardian</a></li>
                            <li class="breadcrumb-item active">Add Guardian</li>
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
                        <form action="{{ route('guardian/save') }}" method="POST" id="guardian-form">
                            @csrf
                            <div class="row">
                                <div class="col-12">
                                    <h5 class="form-title student-info">Guardian Information</h5>
                                </div>
                                <div class="col-12 col-sm-4">
                                    <div class="form-group local-forms">
                                        <label>First Name <span class="login-danger">*</span></label>
                                        <input type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name') }}" placeholder="Enter First Name">
                                        @error('first_name')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4">
                                    <div class="form-group local-forms">
                                        <label>Last Name <span class="login-danger">*</span></label>
                                        <input type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name') }}" placeholder="Enter Last Name">
                                        @error('last_name')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4">
                                    <div class="form-group local-forms">
                                        <label>Email <span class="login-danger">*</span></label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="Enter Email Address">
                                        @error('email')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4">
                                    <div class="form-group local-forms">
                                        <label>Phone <span class="login-danger">*</span></label>
                                        <input type="text" class="form-control @error('phone_number') is-invalid @enderror" name="phone_number" value="{{ old('phone_number') }}" placeholder="Enter Phone Number">
                                        @error('phone_number')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4">
                                    <div class="form-group local-forms">
                                        <label>Password <span class="login-danger">*</span></label>
                                        <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Enter Password">
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
                                            <option value="Father" {{ old('relationship') == 'Father' ? 'selected' : '' }}>Father</option>
                                            <option value="Mother" {{ old('relationship') == 'Mother' ? 'selected' : '' }}>Mother</option>
                                            <option value="Other" {{ old('relationship') == 'Other' ? 'selected' : '' }}>Other</option>
                                        </select>
                                        @error('relationship')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <h5 class="form-title student-info">Select Students</h5>
                                </div>
                                <div class="col-12 col-sm-6">
                                    <div class="form-group local-forms">
                                        <label>Search Students</label>
                                        <input type="text" class="form-control" name="search" id="search" value="{{ old('search', $search) }}" placeholder="Search by Name or Admission ID">
                                        <button type="button" class="btn btn-primary mt-2" id="search-btn">Search</button>
                                    </div>
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
                                                            <input type="checkbox" name="students[]" value="{{ $student->id }}" class="student-checkbox" data-student='{"id": "{{ $student->id }}", "name": "{{ $student->first_name }} {{ $student->last_name }}", "admission_id": "{{ $student->admission_id }}", "roll_number": "{{ $student->roll_number ?? 'N/A' }}", "date_of_birth": "{{ $student->date_of_birth ?? 'N/A' }}"}'>
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
        const searchInput = $('#search');
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

        // Client-side search filter
        $('#search-btn').on('click', function() {
            const searchTerm = searchInput.val().toLowerCase();
            studentRows.each(function() {
                const name = $(this).data('name');
                const admissionId = $(this).data('admission-id');
                if (name.includes(searchTerm) || admissionId.includes(searchTerm)) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });

        // Trigger search on Enter key
        searchInput.on('keypress', function(e) {
            if (e.which === 13) {
                e.preventDefault();
                $('#search-btn').click();
            }
        });

        // Restore state after validation errors
        @if (old('students'))
            @foreach (old('students', []) as $studentId)
                $(`input[value="${{{ $studentId }}}}"]`).prop('checked', true).trigger('change');
            @endforeach
        @endif

        // Initial update
        updateSelectedStudents();
    });
</script>
@endsection