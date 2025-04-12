@extends('layouts.app')
@include('layouts.topbar')
@section('content')
<div class="container-fluid" style="margin-top:80px">
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center bg-white p-4 rounded shadow-sm">
                <div>
                    <h2 class="text-primary mb-0">
                        <i class="fas fa-user-plus me-2"></i>Add New Student
                    </h2>
                    <p class="text-muted mb-0">Enter student details to create a new record</p>
                </div>
                <a href="{{ route('students.index') }}" class="btn btn-primary btn">
                    <i class="fas fa-arrow-left me-2"></i>Back to Students
                </a>
            </div>
        </div>
    </div>

    <!-- Main Content Card -->
    <div class="card shadow">
        <div class="card-header bg-primary py-3">
            <h5 class="mb-0 text-light">Student Information Form</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('students.store') }}" method="POST">
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="FirstName" class="form-label fw-bold">First Name</label>
                        <input type="text" class="form-control @error('FirstName') is-invalid @enderror"
                            id="FirstName" name="FirstName" value="{{ old('FirstName') }}" required>
                        @error('FirstName')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="LastName" class="form-label fw-bold">Last Name</label>
                        <input type="text" class="form-control @error('LastName') is-invalid @enderror"
                            id="LastName" name="LastName" value="{{ old('LastName') }}" required>
                        @error('LastName')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="SectionId" class="form-label fw-bold">Section</label>
                        <select class="form-select @error('SectionId') is-invalid @enderror"
                            id="SectionId" name="SectionId" required>
                            <option value="">Select Section</option>
                            @foreach($sections as $section)
                            <option value="{{ $section->SectionId }}" {{ old('SectionId') == $section->SectionId ? 'selected' : '' }}>
                                {{ $section->SectionName }}
                            </option>
                            @endforeach
                        </select>
                        @error('SectionId')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="Gender" class="form-label fw-bold">Gender</label>
                        <select class="form-select @error('Gender') is-invalid @enderror"
                            id="Gender" name="Gender" required>
                            <option value="">Select Gender</option>
                            <option value="Male" {{ old('Gender') == 'Male' ? 'selected' : '' }}>Male</option>
                            <option value="Female" {{ old('Gender') == 'Female' ? 'selected' : '' }}>Female</option>
                        </select>
                        @error('Gender')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="DateOfBirth" class="form-label fw-bold">Date of Birth</label>
                        <input type="date" class="form-control @error('DateOfBirth') is-invalid @enderror"
                            id="DateOfBirth" name="DateOfBirth" value="{{ old('DateOfBirth') }}"
                            max="{{ date('Y-m-d', strtotime('-15 years')) }}" required>
                        @error('DateOfBirth')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="ContactNumber" class="form-label fw-bold">Contact Number</label>
                        <input type="tel" class="form-control @error('ContactNumber') is-invalid @enderror"
                            id="ContactNumber" name="ContactNumber" value="{{ old('ContactNumber') }}" required>
                        @error('ContactNumber')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="Email" class="form-label fw-bold">Email</label>
                        <input type="email" class="form-control @error('Email') is-invalid @enderror"
                            id="Email" name="Email" value="{{ old('Email') }}" required>
                        @error('Email')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="EnrollmentDate" class="form-label fw-bold">Enrollment Date</label>
                        <input type="date" class="form-control @error('EnrollmentDate') is-invalid @enderror"
                            id="EnrollmentDate" name="EnrollmentDate" value="{{ old('EnrollmentDate') }}" required>
                        @error('EnrollmentDate')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-12">
                        <label for="Address" class="form-label fw-bold">Address</label>
                        <textarea class="form-control @error('Address') is-invalid @enderror"
                            id="Address" name="Address" rows="3" required>{{ old('Address') }}</textarea>
                        @error('Address')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-12 mt-4">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-save me-2"></i>Save Student
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
