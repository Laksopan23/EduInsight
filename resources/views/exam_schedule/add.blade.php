@extends('layouts.master')
@section('content')
<div class="page-wrapper">
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <div class="page-sub-header">
                        <h3 class="page-title">Add Exam Schedule & Tutorials</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('exam_schedule/list') }}">Exam Schedule</a></li>
                            <li class="breadcrumb-item active">Add</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        {!! Toastr::message() !!}
        <div class="row">
            <div class="col-sm-12">
                <div class="card comman-shadow">
                    <div class="card-body">
                        <!-- Exam Schedule Form -->
                        <form action="{{ route('exam_schedule.store_schedule') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-12">
                                    <h5 class="form-title student-info">Exam Schedule Information</h5>
                                </div>
                                <div class="col-12 col-sm-4">
                                    <div class="form-group local-forms">
                                        <label>Grade <span class="login-danger">*</span></label>
                                        <select name="grade" class="form-control select @error('grade') is-invalid @enderror" required>
                                            <option selected disabled>Select Grade</option>
                                            @for ($i = 1; $i <= 13; $i++)
                                                <option value="Grade {{ $i }}" {{ old('grade') == 'Grade '.$i ? 'selected' : '' }}>Grade {{ $i }}</option>
                                            @endfor
                                        </select>
                                        @error('grade')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4">
                                    <div class="form-group local-forms">
                                        <label>Category <span class="login-danger">*</span></label>
                                        <select name="category" class="form-control select @error('category') is-invalid @enderror" required>
                                            <option selected disabled>Select Category</option>
                                            <option value="Term Test" {{ old('category') == 'Term Test' ? 'selected' : '' }}>Term Test</option>
                                            <option value="Scholarship Exam" {{ old('category') == 'Scholarship Exam' ? 'selected' : '' }}>Scholarship Exam</option>
                                            <option value="GCE O-Level" {{ old('category') == 'GCE O-Level' ? 'selected' : '' }}>GCE O-Level</option>
                                            <option value="GCE A-Level" {{ old('category') == 'GCE A-Level' ? 'selected' : '' }}>GCE A-Level</option>
                                        </select>
                                        @error('category')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div id="subject_fields">
                                        <div class="row subject-row">
                                            <div class="col-12 col-sm-3">
                                                <div class="form-group local-forms">
                                                    <label>Subject <span class="login-danger">*</span></label>
                                                    <input type="text" name="subjects[0][subject]" class="form-control @error('subjects.0.subject') is-invalid @enderror" value="{{ old('subjects.0.subject') }}" placeholder="Enter Subject" required>
                                                    @error('subjects.0.subject')
                                                        <span class="invalid-feedback">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-3">
                                                <div class="form-group local-forms">
                                                    <label>Exam Date <span class="login-danger">*</span></label>
                                                    <input type="date" name="subjects[0][exam_date]" class="form-control @error('subjects.0.exam_date') is-invalid @enderror" value="{{ old('subjects.0.exam_date') }}" required>
                                                    @error('subjects.0.exam_date')
                                                        <span class="invalid-feedback">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-2">
                                                <div class="form-group local-forms">
                                                    <label>Exam Time <span class="login-danger">*</span></label>
                                                    <input type="time" name="subjects[0][exam_time]" class="form-control @error('subjects.0.exam_time') is-invalid @enderror" value="{{ old('subjects.0.exam_time') }}" required>
                                                    @error('subjects.0.exam_time')
                                                        <span class="invalid-feedback">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-2">
                                                <div class="form-group local-forms">
                                                    <label>Venue</label>
                                                    <input type="text" name="subjects[0][venue]" class="form-control @error('subjects.0.venue') is-invalid @enderror" value="{{ old('subjects.0.venue') }}" placeholder="Enter Venue (Optional)">
                                                    @error('subjects.0.venue')
                                                        <span class="invalid-feedback">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <button type="button" class="btn btn-secondary mb-3" id="add_subject">Add Another Subject</button>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="student-submit">
                                        <button type="submit" class="btn btn-primary">Submit Schedule</button>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <!-- Tutorials Form -->
                        <form action="{{ route('exam_schedule.store_tutorial') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-12 mt-4">
                                    <h5 class="form-title student-info">Tutorials</h5>
                                </div>
                                <div id="tutorial_fields">
                                    <div class="row tutorial-row">
                                        <div class="col-12 col-sm-3">
                                            <div class="form-group local-forms">
                                                <label>Grade <span class="login-danger">*</span></label>
                                                <select name="tutorials[0][grade]" class="form-control select @error('tutorials.0.grade') is-invalid @enderror" required>
                                                    <option selected disabled>Select Grade</option>
                                                    @for ($i = 1; $i <= 13; $i++)
                                                        <option value="Grade {{ $i }}" {{ old('tutorials.0.grade') == 'Grade '.$i ? 'selected' : '' }}>Grade {{ $i }}</option>
                                                    @endfor
                                                </select>
                                                @error('tutorials.0.grade')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-3">
                                            <div class="form-group local-forms">
                                                <label>Subject <span class="login-danger">*</span></label>
                                                <input type="text" name="tutorials[0][subject]" class="form-control @error('tutorials.0.subject') is-invalid @enderror" value="{{ old('tutorials.0.subject') }}" placeholder="Enter Subject" required>
                                                @error('tutorials.0.subject')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-3">
                                            <div class="form-group local-forms">
                                                <label>PDF Upload <span class="login-danger">*</span></label>
                                                <input type="file" name="tutorials[0][pdf]" class="form-control @error('tutorials.0.pdf') is-invalid @enderror" accept="application/pdf" required>
                                                @error('tutorials.0.pdf')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button type="button" class="btn btn-secondary mb-3" id="add_tutorial">Add Another Tutorial</button>
                                </div>
                                <div class="col-12">
                                    <div class="student-submit">
                                        <button type="submit" class="btn btn-primary">Submit Tutorial</button>
                                    </div>
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
    let subjectIndex = 1;
    $('#add_subject').click(function() {
        const newSubjectField = `
            <div class="row subject-row">
                <div class="col-12 col-sm-3">
                    <div class="form-group local-forms">
                        <label>Subject <span class="login-danger">*</span></label>
                        <input type="text" name="subjects[${subjectIndex}][subject]" class="form-control" placeholder="Enter Subject" required>
                    </div>
                </div>
                <div class="col-12 col-sm-3">
                    <div class="form-group local-forms">
                        <label>Exam Date <span class="login-danger">*</span></label>
                        <input type="date" name="subjects[${subjectIndex}][exam_date]" class="form-control" required>
                    </div>
                </div>
                <div class="col-12 col-sm-2">
                    <div class="form-group local-forms">
                        <label>Exam Time <span class="login-danger">*</span></label>
                        <input type="time" name="subjects[${subjectIndex}][exam_time]" class="form-control" required>
                    </div>
                </div>
                <div class="col-12 col-sm-2">
                    <div class="form-group local-forms">
                        <label>Venue</label>
                        <input type="text" name="subjects[${subjectIndex}][venue]" class="form-control" placeholder="Enter Venue (Optional)">
                    </div>
                </div>
                <div class="col-12 col-sm-2">
                    <div class="form-group local-forms">
                        <label>PDF Upload (Optional)</label>
                        <input type="file" name="subjects[${subjectIndex}][pdf]" class="form-control" accept="application/pdf">
                    </div>
                </div>
            </div>`;
        $('#subject_fields').append(newSubjectField);
        subjectIndex++;
    });

    let tutorialIndex = 1;
    $('#add_tutorial').click(function() {
        const newTutorialField = `
            <div class="row tutorial-row">
                <div class="col-12 col-sm-3">
                    <div class="form-group local-forms">
                        <label>Grade <span class="login-danger">*</span></label>
                        <select name="tutorials[${tutorialIndex}][grade]" class="form-control select" required>
                            <option selected disabled>Select Grade</option>
                            @for ($i = 1; $i <= 13; $i++)
                                <option value="Grade {{ $i }}">Grade {{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                </div>
                <div class="col-12 col-sm-3">
                    <div class="form-group local-forms">
                        <label>Subject <span class="login-danger">*</span></label>
                        <input type="text" name="tutorials[${tutorialIndex}][subject]" class="form-control" placeholder="Enter Subject" required>
                    </div>
                </div>
                <div class="col-12 col-sm-3">
                    <div class="form-group local-forms">
                        <label>PDF Upload <span class="login-danger">*</span></label>
                        <input type="file" name="tutorials[${tutorialIndex}][pdf]" class="form-control" accept="application/pdf" required>
                    </div>
                </div>
            </div>`;
        $('#tutorial_fields').append(newTutorialField);
        tutorialIndex++;
    });
</script>
@endsection