@extends('layouts.master')
@section('content')
<div class="page-wrapper">
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <div class="page-sub-header">
                        <h3 class="page-title">Exam Schedules</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('exam_schedule/list') }}">Exam Schedule</a></li>
                            <li class="breadcrumb-item active">All Exam Schedules</li>
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
                                    <h3 class="page-title">Exam Schedules</h3>
                                </div>
                                <div class="col-auto text-end float-end ms-auto download-grp">
                                    <!-- Placeholder for list view (not implemented) -->
                                    <a href="{{ route('exam_schedule/list') }}" class="btn btn-outline-gray me-2"><i class="fa fa-list"></i></a>
                                    <!-- Current grid view (active) -->
                                    <a href="{{ route('exam_schedule/list') }}" class="btn btn-outline-gray me-2 active"><i class="fa fa-th"></i></a>
                                    @if (Session::get('role_name') === 'Admin' || Session::get('role_name') === 'Teachers')
                                    <a href="{{ route('exam_schedule/add') }}" class="btn btn-primary"><i class="fas fa-plus"></i></a>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="student-pro-list">
                            <div class="row">
                                @forelse ($examSchedules as $schedule)
                                <div class="col-xl-3 col-lg-4 col-md-6 d-flex">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="student-box flex-fill">
                                                <div class="student-content pb-0">
                                                    <h5>{{ $schedule->grade }} - {{ $schedule->category }}</h5>
                                                    <h6>Subject: {{ $schedule->subject }}</h6>
                                                    <p>Date: {{ $schedule->exam_date }}</p>
                                                    <p>Time: {{ $schedule->exam_time }}</p>
                                                    <p>Venue: {{ $schedule->venue ?? 'N/A' }}</p>
                                                    @if (Session::get('role_name') === 'Admin' || Session::get('role_name') === 'Teachers')
                                                    <div class="actions">
                                                        <a href="{{ route('exam_schedule/edit', $schedule->id) }}" class="btn btn-sm bg-danger-light">
                                                            <i class="far fa-edit me-2"></i> Edit
                                                        </a>
                                                        <a class="btn btn-sm bg-danger-light exam_schedule_delete" data-bs-toggle="modal" data-bs-target="#examScheduleDelete" data-id="{{ $schedule->id }}">
                                                            <i class="far fa-trash-alt me-2"></i> 
                                                        </a>
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @empty
                                <p class="text-center text-muted mt-3">No exam schedules found.</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if (Session::get('role_name') === 'Admin' || Session::get('role_name') === 'Teachers')
<div class="modal custom-modal fade" id="examScheduleDelete" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="form-header">
                    <h3>Delete Exam Schedule</h3>
                    <p>Are you sure you want to delete?</p>
                </div>
                <div class="modal-btn delete-action">
                    <form action="{{ route('exam_schedule/delete') }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <div class="row">
                            <input type="hidden" name="id" class="e_id" value="">
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
    $(document).on('click', '.exam_schedule_delete', function() {
        var id = $(this).data('id');
        $('.e_id').val(id);
    });
</script>
@endsection
@endif
@endsection