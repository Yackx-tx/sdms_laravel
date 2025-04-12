@extends('layouts.app')
@include('layouts.topbar')
@section('content')
<div class="container-fluid" style="margin-top:80px;">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Student Details</h5>
                    <div>
                        <a href="{{ route('students.edit', $student) }}" class="btn btn-light btn-sm me-2">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('students.index') }}" class="btn btn-light btn-sm">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                    </div>
                </div>

                <div class="card-body bg-light">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-4">
                                <h6 class="text-muted mb-2">Personal Information</h6>
                                <div class="p-3 bg-white rounded shadow-sm">
                                    <p><strong>Full Name:</strong> {{ $student->FirstName }} {{ $student->LastName }}</p>
                                    <p><strong>Gender:</strong> {{ $student->Gender }}</p>
                                    <p><strong>Date of Birth:</strong> {{ \Carbon\Carbon::parse($student->DateOfBirth)->format('F d, Y') }}</p>
                                </div>
                            </div>

                            <div class="mb-4">
                                <h6 class="text-muted mb-2">Contact Information</h6>
                                <div class="p-3 bg-white rounded shadow-sm">
                                    <p><strong>Email:</strong> {{ $student->Email }}</p>
                                    <p><strong>Phone:</strong> {{ $student->ContactNumber }}</p>
                                    <p><strong>Address:</strong> {{ $student->Address }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-4">
                                <h6 class="text-muted mb-2">Academic Information</h6>
                                <div class="p-3 bg-white rounded shadow-sm">
                                    <p><strong>Student ID:</strong> {{ $student->id }}</p>
                                    <p><strong>Enrollment Date:</strong> {{ \Carbon\Carbon::parse($student->EnrollmentDate)->format('F d, Y') }}</p>
                                    <p><strong>Status:</strong> <span class="badge bg-success">Active</span></p>
                                </div>
                            </div>

                            @if($student->courses && $student->courses->count() > 0)
                            <div class="mb-4">
                                <h6 class="text-muted mb-2">Enrolled Courses</h6>
                                <div class="p-3 bg-white rounded shadow-sm">
                                    <ul class="list-group list-group-flush">
                                        @foreach($student->courses as $course)
                                        <li class="list-group-item">
                                            {{ $course->CourseName }}
                                            <span class="badge bg-primary float-end">{{ $course->CourseCode }}</span>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .card {
        border-radius: 10px;
        border: none;
    }
    .card-header {
        border-radius: 10px 10px 0 0;
    }
    .shadow-sm {
        box-shadow: 0 .125rem .25rem rgba(0,0,0,.075)!important;
    }
    .list-group-item {
        border-left: none;
        border-right: none;
    }
    .list-group-item:first-child {
        border-top: none;
    }
    .list-group-item:last-child {
        border-bottom: none;
    }
</style>
@endpush
@endsection
