@extends('layouts.master')

@section('content')
{!! Toastr::message() !!}
<div class="page-wrapper">
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Communications</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Communications</li>
                    </ul>
                </div>
                <div class="col-auto text-end float-end ms-auto download-grp">
                    <a href="{{ route('communication/add/page') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Add New Communication</a>
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
                                        <th>Title</th>
                                        <th>Sender</th>
                                        <th>Receiver</th>
                                        <th>Schedule Date</th>
                                        <th>Schedule Time</th>
                                        <th>Meeting Link</th>
                                        <th class="text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($communicationList as $communication)
                                    <tr>
                                        <td hidden class="communication_id">{{ $communication->id }}</td>
                                        <td>{{ $communication->title }}</td>
                                        <td>{{ $communication->sender }}</td>
                                        <td>{{ $communication->receiver }}</td>
                                        <td>{{ $communication->schedule_date ?? 'N/A' }}</td>
                                        <td>{{ $communication->schedule_time ?? 'N/A' }}</td>
                                        <td>
                                            @if($communication->meeting_link)
                                                <a href="{{ $communication->meeting_link }}" target="_blank" class="btn btn-sm btn-info">Join Meeting</a>
                                            @else
                                                <span class="text-muted">No Meeting</span>
                                            @endif
                                        </td>
                                        <td class="text-end">
                                            <div class="actions">
                                                <a href="{{ route('communication/profile', $communication->id) }}" class="btn btn-sm bg-info-light">
                                                    <i class="far fa-eye me-2"></i> View
                                                </a>
                                                <a href="{{ route('communication/edit', $communication->id) }}" class="btn btn-sm bg-success-light">
                                                    <i class="far fa-edit me-2"></i> Edit
                                                </a>
                                                <a class="btn btn-sm bg-danger-light communication_delete" data-bs-toggle="modal" data-bs-target="#communicationDelete">
                                                    <i class="far fa-trash-alt me-2"></i>
                                                </a>
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
</div>

<div class="modal custom-modal fade" id="communicationDelete" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="form-header">
                    <h3>Delete Communication</h3>
                    <p>Are you sure you want to delete?</p>
                </div>
                <div class="modal-btn delete-action">
                    <form action="{{ route('communication/delete') }}" method="POST">
                        @csrf
                        <div class="row">
                            <input type="hidden" name="id" class="e_communication_id" value="">
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
@endsection

@section('script')
<script>
    $(document).on('click', '.communication_delete', function() {
        var _this = $(this).parents('tr');
        $('.e_communication_id').val(_this.find('.communication_id').text());
    });
</script>
@endsection