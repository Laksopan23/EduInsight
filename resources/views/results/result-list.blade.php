@extends('layouts.master')

@section('content')
{!! Toastr::message() !!}
<div class="page-wrapper">
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Results</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Results</li>
                    </ul>
                </div>
                <div class="col-auto text-end float-end ms-auto download-grp">
                    <a href="{{ route('results.download.list') }}" class="btn btn-outline-primary me-2">
                        <i class="fas fa-download"></i> Download
                    </a>
                    <a href="{{ route('results.add') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Add New Result
                    </a>
                </div>
                
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="card card-table">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table border-0 star-student table-hover table-center mb-0 datatable table-striped">
                                <thead class="student-thread">
                                    <tr>
                                        <th>Teacher</th>
                                        <th>Student</th>
                                        <th>Subject</th>
                                        <th>Marks</th>
                                        <th class="text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($results as $result)
                                    <tr>
                                        <td hidden class="result_id">{{ $result->id }}</td>
                                        <td>{{ $result->teacher->name }}</td>
                                        <td>{{ $result->student->name }}</td>
                                        <td>{{ $result->subject->name }}</td>
                                        <td>{{ $result->marks }}</td>
                                        <td class="text-end">
                                            <div class="actions">
                                                <a href="{{ route('results.show', $result->id) }}" class="btn btn-sm bg-info-light">
                                                    <i class="far fa-eye me-2"></i> View
                                                </a>
                                                @if(Auth::user()->role_name === 'Admin' || Auth::user()->role_name === 'Teachers')
                                                <a href="{{ route('results.edit', $result->id) }}" class="btn btn-sm bg-success-light">
                                                    <i class="far fa-edit me-2"></i> Edit
                                                </a>
                                                <a href="#" class="btn btn-sm bg-danger-light result_delete" data-bs-toggle="modal" data-bs-target="#resultDelete" data-id="{{ $result->id }}">
                                                    <i class="far fa-trash-alt me-2"></i>
                                                </a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal custom-modal fade" id="resultDelete" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="form-header">
                        <h3>Delete Result</h3>
                        <p>Are you sure you want to delete?</p>
                    </div>
                    <div class="modal-btn delete-action">
                        <form action="{{ route('results.delete', ':id') }}" method="POST" id="deleteForm">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="id" id="deleteId">
                            <div class="row">
                                <div class="col-6">
                                    <button type="submit" class="btn btn-primary continue-btn submit-btn" style="border-radius: 5px !important;">Delete</button>
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
</div>
@endsection

@section('script')
<script>
    $(document).on('click', '.result_delete', function() {
        var id = $(this).data('id');
        $('#deleteId').val(id);
        $('#deleteForm').attr('action', '{{ route("results.delete", "") }}/' + id);
    });
</script>
@endsection