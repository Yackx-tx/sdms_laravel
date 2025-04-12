@extends('layouts.app')
@include('layouts.topbar')
@section('content')
<div class="container-fluid" style="margin-top:80px;">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                    <h5 class="mb-0 text-primary fw-bold">Create New Grade</h5>
                    <a href="{{ route('grades.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Back to Grades
                    </a>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('grades.store') }}" class="needs-validation" novalidate>
                        @csrf
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <label for="SectionId" class="form-label fw-bold">Section</label>
                                <select class="form-select form-select-lg @error('SectionId') is-invalid @enderror" name="SectionId" id="SectionId" required>
                                    <option value="">Select Section</option>
                                    @foreach($sections as $section)
                                    <option value="{{ $section->SectionId }}" {{ request('SectionId') == $section->SectionId ? 'selected' : '' }}>
                                        {{ $section->SectionName }}
                                    </option>
                                    @endforeach
                                </select>

                            </div>
                            <div class="col-md-4">
                                <label for="CourseId" class="form-label fw-bold">Course</label>
                                <select class="form-select form-select-lg @error('CourseId') is-invalid @enderror" name="CourseId" id="CourseId" required>
                                    <option value="">Select Course</option>
                                    @foreach($courses as $course)
                                    <option value="{{ $course->CourseId }}" {{ (old('CourseId') ?? request('CourseId')) == $course->CourseId ? 'selected' : '' }}>
                                        {{ $course->course_name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="semester" class="form-label fw-bold">Semester</label>
                                <select class="form-select form-select-lg @error('semester') is-invalid @enderror" id="semester" name="semester" required>
                                    <option value="">Select Semester</option>
                                    <option value="First Term" {{ (old('semester') ?? request('semester')) == 'First Term' ? 'selected' : '' }}>1st Semester</option>
                                    <option value="Second Term" {{ (old('semester') ?? request('semester')) == 'Second Term' ? 'selected' : '' }}>2nd Semester</option>
                                    <option value="Third Term" {{ (old('semester') ?? request('semester')) == 'Third Term' ? 'selected' : '' }}>3rd Semester</option>
                                </select>
                            </div>
                        </div>

                        <div class="d-grid gap-2 mb-4">
                            <button type="button" id="loadStudents" class="btn btn-secondary">
                                <span class="spinner-border spinner-border-sm d-none" role="status"></span>
                                <span class="button-text">Load Students</span>
                            </button>
                        </div>

                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Student Name</th>
                                        <th>Score</th>
                                        <th>Grade Letter</th>
                                    </tr>
                                </thead>
                                <tbody id="studentTableBody">
                                    @if(isset($students) && $students->count() > 0)
                                    @foreach($students as $student)
                                    <tr>
                                        <td>
                                            {{ $student->FirstName }} {{ $student->LastName }}
                                            <input type="hidden" name="StudentId[]" value="{{ $student->StudentId }}">
                                        </td>
                                        <td>
                                            <input type="number" step="0.01" class="form-control score-input"
                                                name="score[]" required>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control grade-letter"
                                                name="grade_letter[]" readonly>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr>
                                        <td colspan="3" class="text-center">Select a section and click "Load Students"</td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>

                        <div class="d-grid gap-2 mt-4">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-save me-1"></i> Save Grades
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
    document.getElementById('loadStudents').addEventListener('click', function() {
        const spinner = document.querySelector('.spinner-border');
        const buttonText = document.querySelector('.button-text');
        spinner.classList.remove('d-none');
        buttonText.textContent = 'Loading...';

        const sectionId = document.getElementById('SectionId').value;
        const courseId = document.getElementById('CourseId').value;
        const semester = document.getElementById('semester').value;

        if (sectionId) {
            let url = `{{ route('grades.create') }}?SectionId=${sectionId}`;
            if (courseId) url += `&CourseId=${courseId}`;
            if (semester) url += `&semester=${semester}`;
            window.location.href = url;
        } else {
            alert('Please select a section first');
            spinner.classList.add('d-none');
            buttonText.textContent = 'Load Students';
        }
    });

    // Maintain focus flow
    if (document.getElementById('SectionId').value) {
        if (!document.getElementById('CourseId').value) {
            document.getElementById('CourseId').focus();
        } else if (!document.getElementById('semester').value) {
            document.getElementById('semester').focus();
        }
    }

    // Score input handler remains the same
    document.querySelectorAll('.score-input').forEach(input => {
        input.addEventListener('input', function() {
            const score = parseFloat(this.value);
            let gradeLetter = '';

            if (score >= 90) gradeLetter = 'A';
            else if (score >= 80) gradeLetter = 'B';
            else if (score >= 70) gradeLetter = 'C';
            else if (score >= 60) gradeLetter = 'D';
            else gradeLetter = 'F';

            this.closest('tr').querySelector('.grade-letter').value = gradeLetter;
        });
    });
</script>
@endsection


@endsection
