@extends('layouts.app')
@include('layouts.topbar')
@section('content')
<div class="container-fluid" style="margin-top:80px">
    <!-- Header Section with improved styling -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center bg-white p-4 rounded shadow-sm">
                <div>
                    <h2 class="text-primary mb-0">
                        <i class="fas fa-plus-circle me-2"></i>Add New Course
                    </h2>
                    <p class="text-muted mb-0">Create a new course in the system</p>
                </div>
                <a href="{{ route('courses.index') }}" class="btn btn-primary btn">
                    <i class="fas fa-arrow-left me-2"></i>Back to Courses
                </a>
            </div>
        </div>
    </div>

    <!-- Main Content Card -->
    <div class="card shadow">
        <div class="card-header bg-primary py-3">
            <h5 class="mb-0 text-light fw-bold">Course Information Form</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('courses.store') }}" method="POST" class="p-3">
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="course_code" class="form-label fw-bold">Course Code</label>
                        <input type="text" class="form-control form-control-lg @error('course_code') is-invalid @enderror"
                            id="course_code" name="course_code" value="{{ old('course_code') }}"
                            placeholder="Enter course code" required>
                        @error('course_code')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="course_name" class="form-label fw-bold">Course Name</label>
                        <input type="text" class="form-control form-control-lg @error('course_name') is-invalid @enderror"
                            id="course_name" name="course_name" value="{{ old('course_name') }}"
                            placeholder="Enter course name" required>
                        @error('course_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-12">
                        <label for="section_id" class="form-label fw-bold">Section</label>
                        <select class="form-select form-select-lg @error('section_id') is-invalid @enderror"
                            id="section_id" name="section_id" required>
                            <option value="">Select Section</option>
                            @foreach($sections as $section)
                            <option value="{{ $section->SectionId }}" {{ old('section_id') == $section->SectionId ? 'selected' : '' }}>
                                {{ $section->SectionName }}
                            </option>
                            @endforeach
                        </select>
                        @error('section_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-12">
                        <label for="description" class="form-label fw-bold">Description</label>
                        <textarea class="form-control form-control-lg @error('description') is-invalid @enderror"
                            id="description" name="description" rows="4"
                            placeholder="Enter course description">{{ old('description') }}</textarea>
                        @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="credits" class="form-label fw-bold">Credits</label>
                        <input type="number" class="form-control form-control-lg @error('credits') is-invalid @enderror"
                            id="credits" name="credits" value="{{ old('credits') }}"
                            placeholder="Enter credits" required>
                        @error('credits')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="instructor" class="form-label fw-bold">Instructor</label>
                        <input type="text" class="form-control form-control-lg @error('instructor') is-invalid @enderror"
                            id="instructor" name="instructor" value="{{ old('instructor') }}"
                            placeholder="Enter instructor name" required>
                        @error('instructor')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12 mt-4">
                        <button type="submit" class="btn btn-primary btn px-5">
                            <i class="fas fa-save me-2"></i>Create Course
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@push('styles')
<style>
    .form-label {
        font-weight: 500;
    }

    .form-control,
    .form-select {
        padding: 0.75rem;
    }

    .btn-lg {
        padding: 0.75rem 1.5rem;
    }
</style>
@endpush

@endsection