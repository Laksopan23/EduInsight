@extends('layouts.master')
@section('content')
    {{-- message --}}
    {!! Toastr::message() !!}
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Fees Collections</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                            <li class="breadcrumb-item active">Fees Collections</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="card card-table">
                        <div class="card-body">
                            <div class="page-header">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h3 class="page-title">Fees Collections</h3>
                                    </div>
                                    <div class="col-auto text-end float-end ms-auto download-grp">
                                        <a href="{{ route('fees/collection/download') }}" class="btn btn-outline-primary me-2">
                                            <i class="fas fa-download"></i> Download
                                        </a>
                                        <a href="{{ route('add/fees/collection/page') }}" class="btn btn-primary">
                                            <i class="fas fa-plus"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <!-- Debug: Check if data is being passed -->
                                @if ($feesInformation->isEmpty())
                                    <p>No fees information found.</p>
                                @else
                                    <p>Found {{ $feesInformation->count() }} records.</p>
                                @endif

                                <table class="table border-0 star-student table-hover table-center mb-0 datatable table-striped">
                                    <thead class="student-thread">
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Gender</th>
                                            <th>Fees Type</th>
                                            <th>Amount</th>
                                            <th>Paid Date</th>
                                            <th class="text-end">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($feesInformation as $key => $value)
                                            <tr>
                                                <td hidden class="fees_info_id">{{ $value->id }}</td>
                                                <td>ST-{{ $value->student_id }}</td>
                                                <td>
                                                    <h2 class="table-avatar">
                                                        <a class="avatar avatar-sm me-2">
                                                            <img class="avatar-img rounded-circle" src="{{ URL::to('/images/'. $value->avatar) }}" alt="{{ $value->student_name }}">
                                                        </a>
                                                        <a>{{ $value->student_name }}</a>
                                                    </h2>
                                                </td>
                                                <td>{{ $value->gender }}</td>
                                                <td>{{ $value->fees_type }}</td>
                                                <td>${{ $value->fees_amount }}</td>
                                                <td>{{ $value->paid_date }}</td>
                                                <td class="text-end">
                                                    <div class="actions">
                                                        <a href="{{ route('fees/collection/edit', $value->id) }}" class="btn btn-sm bg-danger-light">
                                                            <i class="far fa-edit me-2"></i> Edit
                                                        </a>
                                                        <a class="btn btn-sm bg-danger-light fees_delete" data-bs-toggle="modal" data-bs-target="#feesDelete">
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

    <div class="modal custom-modal fade" id="feesDelete" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="form-header">
                        <h3>Delete Fees Record</h3>
                        <p>Are you sure you want to delete?</p>
                    </div>
                    <div class="modal-btn delete-action">
                        <form action="{{ route('fees/collection/delete') }}" method="POST">
                            @csrf
                            <div class="row">
                                <input type="hidden" name="id" class="e_fees_info_id" value="">
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
    $(document).on('click', '.fees_delete', function() {
        var _this = $(this).parents('tr');
        $('.e_fees_info_id').val(_this.find('.fees_info_id').text());
    });
</script>
@endsection