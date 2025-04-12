@extends('layouts.master')

@section('content')
<div class="page-wrapper">
    <div class="content container-fluid">
        <div class="page-header">
            <h3 class="page-title">Exams</h3>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="card card-table comman-shadow">
                    <div class="card-body pb-0">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Exam Name</th>
                                    <th>Exam Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($exams as $exam)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $exam->name }}</td>
                                    <td>{{ $exam->exam_date }}</td>
                                    <td>
                                        <!-- Edit Exam Button -->
                                        <a href="{{ route('exams.edit', $exam->id) }}" class="btn btn-primary btn-sm">Edit</a>

                                        <!-- Delete Exam Button with Modal Trigger -->
                                        <button class="btn btn-danger btn-sm exam_delete" data-bs-toggle="modal" data-bs-target="#examDeleteModal" data-id="{{ $exam->id }}">Delete</button>
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

{{-- Delete Confirmation Modal --}}
<div class="modal custom-modal fade" id="examDeleteModal" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="form-header">
                    <h3>Delete Exam</h3>
                    <p>Are you sure you want to delete this exam?</p>
                </div>
                <div class="modal-btn delete-action">
                    <form action="{{ route('exams.destroy', ':id') }}" method="POST" id="deleteExamForm">
                        @csrf
                        @method('DELETE')
                        <div class="row">
                            <input type="hidden" name="id" id="examId" value="">
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
{{-- JavaScript for Handling Exam Deletion --}}
<script>
    // Listen for the delete button click
    $(document).on('click', '.exam_delete', function() {
        var examId = $(this).data('id'); // Get exam ID from the button's data-id attribute
        var actionUrl = "{{ route('exams.destroy', ':id') }}".replace(':id', examId); // Update the form action URL
        $('#examId').val(examId); // Set the exam ID to the hidden input field
        $('#deleteExamForm').attr('action', actionUrl); // Update the form's action URL with the correct exam ID
    });
</script>
@endsection