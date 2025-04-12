@extends('layouts.master')

@section('content')
<div class="page-wrapper">
    <div class="content container-fluid">
        <div class="page-header">
            <h3 class="page-title">{{ $exam->name }} Results</h3>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="card card-table">
                    <div class="card-body">
                        <form action="{{ route('exams.addResult', $exam->id) }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="student_id">Student</label>
                                <select name="student_id" class="form-control" required>
                                    <option value="">Select Student</option>
                                    @foreach ($students as $student)
                                    <option value="{{ $student->id }}">{{ $student->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="marks_obtained">Marks Obtained</label>
                                <input type="number" name="marks_obtained" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="status">Status</label>
                                <select name="status" class="form-control" required>
                                    <option value="Passed">Passed</option>
                                    <option value="Failed">Failed</option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-success">Save Result</button>
                        </form>

                        <table class="table table-bordered mt-4">
                            <thead>
                                <tr>
                                    <th>Student</th>
                                    <th>Marks Obtained</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($examResults as $result)
                                <tr>
                                    <td>{{ $result->student->name }}</td>
                                    <td>{{ $result->marks_obtained }}</td>
                                    <td>{{ $result->status }}</td>
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
@endsection