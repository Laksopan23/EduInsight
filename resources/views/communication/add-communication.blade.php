@extends('layouts.master')

@section('content')
{!! Toastr::message() !!}
<div class="page-wrapper">
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Add New Communication</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('communication/list') }}">Communications</a></li>
                        <li class="breadcrumb-item active">Add New</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <form method="POST" action="{{ route('communication/add/save') }}">
                            @csrf
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="title">Title <span class="text-danger">*</span></label>
                                        <input type="text" name="title" id="title" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Sender <span class="text-danger">*</span></label>
                                        <input type="text" name="sender" id="sender" class="form-control" value="{{ $loggedInUser->name }}" readonly>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="receiver">Receivers <span class="text-danger">*</span></label>
                                        <select name="receiver[]" id="receiver" class="form-control select2" multiple required>
                                            @foreach($guardians as $guardian)
                                                <option value="{{ $guardian->id }}">{{ $guardian->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="schedule_date">Schedule Date</label>
                                        <input type="date" name="schedule_date" id="schedule_date" class="form-control">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="schedule_time">Schedule Time</label>
                                        <input type="time" name="schedule_time" id="schedule_time" class="form-control">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="message">Message <span class="text-danger">*</span></label>
                                        <textarea name="message" id="message" class="form-control" rows="4" required></textarea>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="schedule_meeting">
                                            <input type="checkbox" name="schedule_meeting" id="schedule_meeting" value="1">
                                            Schedule a Live Meeting
                                        </label>
                                        @if (!Session::has('zoom_access_token') && !session()->has('zoom_authorized'))
                                        <p class="text-muted">
                                            (Requires Zoom authorization: <a href="{{ route('zoom.authorize') }}" class="btn btn-sm btn-info">Authorize Zoom</a>)
                                        </p>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-12 text-end">
                                    <button type="submit" class="btn btn-primary">Save</button>
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
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.select2').select2();
    });
</script>
@endsection