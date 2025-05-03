@extends('layouts.master')

@section('content')
<div class="page-wrapper">
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Result Details</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('results.list') }}">Results</a></li>
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
                                <p><strong>Teacher:</strong> {{ $result->teacher->name }}</p>
                                <p><strong>Student:</strong> {{ $result->student->name }}</p>
                                <p><strong>Subject:</strong> {{ $result->subject->name }}</p>
                                <p><strong>Marks:</strong> {{ $result->marks }}</p>
                            </div>
                            <div class="col-lg-12 text-end">
                                <a href="{{ route('results.list') }}" class="btn btn-primary">Back to List</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection