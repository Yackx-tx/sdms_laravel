@extends('layouts.app')
@include('layouts.topbar')
@section('content')
<div class="container-fluid" style="margin-top: 80px;">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Record Class Attendance</h5>
                    
                </div>
                <div class="card-body">
                    <form action="{{ route('attendance.store') }}" method="POST" id="attendanceForm">
                        @csrf
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="SectionId" class="form-label fw-bold">Section</label>
                                    <select name="SectionId" id="SectionId" class="form-control form-control-lg" required>
                                        <option value="">Select Section</option>
                                        @foreach($sections as $section)
                                        <option value="{{ $section->SectionId }}" {{ request('section') == $section->SectionId ? 'selected' : '' }}>
                                            {{ $section->SectionName }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="CourseId" class="form-label fw-bold">Course</label>
                                    <select name="CourseId" id="CourseId" class="form-control form-control-lg" required>
                                        <option value="">Select Course</option>
                                        @foreach($courses as $course)
                                        <option value="{{ $course->CourseId }}" {{ request('CourseId') == $course->CourseId ? 'selected' : '' }}>
                                            {{ $course->course_name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="date" class="form-label fw-bold">Date</label>
                                    <input type="date" name="date" id="date" class="form-control form-control-lg" value="{{ request('date', date('Y-m-d')) }}" required>
                                </div>
                            </div>
                        </div>

                        <div class="d-grid gap-2 mb-4">
                            <button type="button" id="loadStudents" class="btn btn-secondary btn-lg">
                                <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                <span class="button-text">Load Students</span>
                            </button>
                        </div>

                        <div id="loadStudents">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Student</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody id="studentTableBody">
                                        @if(isset($students) && $students->count() > 0)
                                        @foreach($students as $student)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-sm me-2">
                                                        <i class="fas fa-user-graduate"></i>
                                                    </div>
                                                    {{ $student->FirstName }} {{ $student->LastName }}
                                                    <input type="hidden" name="StudentId[]" value="{{ $student->StudentId }}">
                                                </div>
                                            </td>
                                            <td>
                                                <select name="status[]" class="form-select" required>
                                                    <option value="present">Present</option>
                                                    <option value="absent">Absent</option>
                                                    <option value="late">Late</option>
                                                </select>
                                            </td>
                                        </tr>
                                        @endforeach
                                        @else
                                        <tr>
                                            <td colspan="2" class="text-center py-4">
                                                <i class="fas fa-users fa-2x mb-3 d-block text-muted"></i>
                                                Select a section and click "Load Students"
                                            </td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                                <button type="submit" class="btn btn-primary btn-lg">Save Attendance</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.getElementById('loadStudents').addEventListener('click', function() {
        const spinner = document.querySelector('.spinner-border');
        const buttonText = document.querySelector('.button-text');
        spinner.classList.remove('d-none');
        buttonText.textContent = 'Loading...';

        const sectionId = document.getElementById('SectionId').value;
        const courseId = document.getElementById('CourseId').value;
        const date = document.getElementById('date').value;
        if (sectionId) {
            window.location.href = `{{ route('attendance.create') }}?section=${sectionId}&CourseId=${courseId}&date=${date}`;
        } else {
            alert('Please select a section first');
            spinner.classList.add('d-none');
            buttonText.textContent = 'Load Students';
        }
    });

    if (document.getElementById('SectionId').value) {
        document.getElementById('CourseId').focus();
    }
</script>
@endsection