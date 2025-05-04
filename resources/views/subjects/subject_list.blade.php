@extends('layouts.master')
@section('content')
<div class="page-wrapper">
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <div class="page-sub-header">
                        <h3 class="page-title">Subjects</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('subjects.index') }}">Subjects</a></li>
                            <li class="breadcrumb-item active">All Subjects</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        {!! Toastr::message() !!}
        <div class="row">
            <div class="col-sm-12">
                <div class="card card-table comman-shadow">
                    <div class="card-body">
                        <div class="page-header">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h3 class="page-title">Subjects by Grade</h3>
                                </div>
                                <div class="col-auto text-end float-end ms-auto download-grp">
                                    <a href="{{ route('subjects.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            @foreach ($subjects as $grade => $gradeSubjects)
                            <h4>{{ $grade }}</h4>
                            <table class="table border-0 star-student table-hover table-center mb-0 datatable table-striped">
                                <thead class="student-thread">
                                    <tr>
                                        <th>Name</th>
                                        <th>Category</th>
                                        <th>Mandatory</th>
                                        <th class="text-end">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $uniqueSubjects = $gradeSubjects->unique('name');
                                    @endphp
                                    @foreach ($uniqueSubjects as $subject)
                                    <tr>
                                        <td>{{ $subject->name }}</td>
                                        <td>{{ $subject->category }}</td>
                                        <td>{{ $subject->is_mandatory ? 'Yes' : 'No' }}</td>
                                        <td class="text-end">
                                            <div class="actions">
                                                <a href="{{ route('subjects.edit', $subject->id) }}" class="btn btn-sm bg-success-light">
                                                    <i class="far fa-edit me-2"></i> Edit
                                                </a>
                                                <a class="btn btn-sm bg-danger-light subject_delete" data-bs-toggle="modal" data-bs-target="#subjectDelete" data-id="{{ $subject->id }}">
                                                    <i class="far fa-trash-alt me-2"></i> Delete
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <br>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal custom-modal fade" id="subjectDelete" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="form-header">
                    <h3>Delete Subject</h3>
                    <p>Are you sure you want to delete?</p>
                </div>
                <div class="modal-btn delete-action">
                    <form action="{{ route('subjects.destroy', ':id') }}" method="POST" id="deleteForm">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="id" id="deleteId" value="">
                        <div class="row">
                            <div class="col-6">
                                <button type="submit" class="btn btn-primary continue-btn submit-btn">Delete</button>
                            </div>
                            <div class="col-6">
                                <a href="#" data-bs-dismiss="modal" class="btn btn-primary paid-cancel-btn">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@section('script')
<script>
    $(document).on('click', '.subject_delete', function() {
        var id = $(this).data('id');
        $('#deleteId').val(id);
        $('#deleteForm').attr('action', '{{ route('subjects.destroy', '') }}/' + id);
    });
</script>
@endsection