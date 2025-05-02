@extends('layouts.master')

@section('content')
<div class="page-wrapper">
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Communication Details</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('communication/list') }}">Communications</a></li>
                        <li class="breadcrumb-item active">Details</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <p><strong>Title:</strong> {{ $communication->title }}</p>
                                <p><strong>Message:</strong> {{ $communication->message }}</p>
                                <p><strong>Sender:</strong> {{ $communication->sender }}</p>
                                <p><strong>Receiver:</strong> {{ $communication->receiver }}</p>
                                <p><strong>Schedule Date:</strong> {{ $communication->schedule_date ?? 'N/A' }}</p>
                                <p><strong>Schedule Time:</strong> {{ $communication->schedule_time ?? 'N/A' }}</p>
                                <p><strong>Meeting Link:</strong>
                                    @if($communication->meeting_link)
                                        <a href="{{ $communication->meeting_link }}" target="_blank" class="btn btn-sm btn-info">Join Meeting</a>
                                    @else
                                        <span class="text-muted">No Meeting Scheduled</span>
                                    @endif
                                </p>
                            </div>
                            <div class="col-lg-12 text-end">
                                <a href="{{ route('communication/list') }}" class="btn btn-primary">Back to List</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection