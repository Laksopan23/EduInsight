@extends('layouts.master')

@section('content')
<div class="page-wrapper">
    <div class="content container-fluid">
        <div class="page-header">
            <h3 class="page-title">Create New Exam</h3>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="card card-table">
                    <div class="card-body">
                        <!-- Create Exam Form -->
                        <form action="{{ route('exams.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="name">Exam Name</label>
                                <input type="text" class="form-control" name="name" id="name" required>
                            </div>

                            <div class="form-group">
                                <label for="exam_date">Exam Date</label>
                                <input type="date" class="form-control" name="exam_date" id="exam_date" required>
                            </div>

                            <button type="submit" class="btn btn-success mt-4">Create Exam</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection