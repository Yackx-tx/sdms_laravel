@extends('layouts.app')
@include('layouts.topbar')
@section('content')
<div class="container-fluid" style="margin-top:80px;">
    <div class="row">
        <div class="col-md-9">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Edit Grade</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('grades.update', $grade->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="student_name" class="form-label">Student Name</label>
                            <input type="text" class="form-control @error('student_name') is-invalid @enderror"
                                id="student_name" name="student_name" value="{{ old('student_name', $grade->student_name) }}">
                            @error('student_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="course_id" class="form-label">Course</label>
                            <select class="form-control @error('course_name') is-invalid @enderror"
                                id="course_id" name="course_id">
                                @foreach($courses as $course)
                                    <option value="{{ $course->id }}"
                                        {{ old('course_id', $grade->course_id) == $course->id ? 'selected' : '' }}>
                                        {{ $course->course_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('course_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="score" class="form-label">Score</label>
                            <input type="number" class="form-control @error('score') is-invalid @enderror"
                                id="score" name="score" value="{{ old('score', $grade->score) }}">
                            @error('score')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="grade_letter" class="form-label">Grade Letter</label>
                            <input type="text" class="form-control @error('grade_letter') is-invalid @enderror"
                                id="grade_letter" name="grade_letter" value="{{ old('grade_letter', $grade->grade_letter) }}">
                            @error('grade_letter')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="semester" class="form-label">Semester</label>
                            <input type="text" class="form-control @error('semester') is-invalid @enderror"
                                id="semester" name="semester" value="{{ old('semester', $grade->semester) }}">
                            @error('semester')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">Update Grade</button>
                            <a href="{{ route('grades.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
