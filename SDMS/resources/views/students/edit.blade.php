@extends('layouts.app')
@include('layouts.topbar')
@section('content')
<div class="container-fluid" style="margin-top:80px;">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Edit Student</h5>
                </div>

                <div class="card-body bg-light">
                    <form method="POST" action="{{ route('students.update', ['student' => $student]) }}" class="needs-validation">
                        @csrf
                        @method('PUT')
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="FirstName" class="form-label fw-bold">First Name</label>
                                    <input type="text" class="form-control form-control-lg @error('FirstName') is-invalid @enderror"
                                        id="FirstName" name="FirstName" value="{{ old('FirstName', $student->FirstName) }}"
                                        placeholder="Enter first name" required>
                                    @error('FirstName')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="LastName" class="form-label fw-bold">Last Name</label>
                                    <input type="text" class="form-control form-control-lg @error('LastName') is-invalid @enderror"
                                        id="LastName" name="LastName" value="{{ old('LastName', $student->LastName) }}"
                                        placeholder="Enter last name" required>
                                    @error('LastName')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="Gender" class="form-label fw-bold">Gender</label>
                                    <select class="form-select form-select-lg @error('Gender') is-invalid @enderror"
                                        id="Gender" name="Gender" required>
                                        <option value="">Select Gender</option>
                                        <option value="Male" {{ old('Gender', $student->Gender) == 'Male' ? 'selected' : '' }}>Male</option>
                                        <option value="Female" {{ old('Gender', $student->Gender) == 'Female' ? 'selected' : '' }}>Female</option>
                                        <option value="Other" {{ old('Gender', $student->Gender) == 'Other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                    @error('Gender')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="DateOfBirth" class="form-label fw-bold">Date of Birth</label>
                                    <input type="date" class="form-control form-control-lg @error('DateOfBirth') is-invalid @enderror"
                                        id="DateOfBirth" name="DateOfBirth" value="{{ old('DateOfBirth', $student->DateOfBirth) }}" required>
                                    @error('DateOfBirth')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="Email" class="form-label fw-bold">Email</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                <input type="email" class="form-control form-control-lg @error('Email') is-invalid @enderror"
                                    id="Email" name="Email" value="{{ old('Email', $student->Email) }}"
                                    placeholder="student@example.com" required>
                            </div>
                            @error('Email')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="ContactNumber" class="form-label fw-bold">Contact Number</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                <input type="tel" class="form-control form-control-lg @error('ContactNumber') is-invalid @enderror"
                                    id="ContactNumber" name="ContactNumber" value="{{ old('ContactNumber', $student->ContactNumber) }}"
                                    placeholder="Enter contact number" required>
                            </div>
                            @error('ContactNumber')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="Address" class="form-label fw-bold">Address</label>
                            <textarea class="form-control form-control-lg @error('Address') is-invalid @enderror"
                                id="Address" name="Address" rows="3"
                                placeholder="Enter full address">{{ old('Address', $student->Address) }}</textarea>
                            @error('Address')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-4">
                            <label for="EnrollmentDate" class="form-label fw-bold">Enrollment Date</label>
                            <input type="date" class="form-control form-control-lg @error('EnrollmentDate') is-invalid @enderror"
                                id="EnrollmentDate" name="EnrollmentDate" value="{{ old('EnrollmentDate', $student->EnrollmentDate) }}" required>
                            @error('EnrollmentDate')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('students.index') }}" class="btn btn-secondary btn-lg me-md-2">Cancel</a>
                            <button type="submit" class="btn btn-primary btn-lg">Update Student</button>
                        </div>
                    </form>
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

    .form-control:focus,
    .form-select:focus {
        border-color: #86b7fe;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, .25);
    }

    .input-group-text {
        background-color: #f8f9fa;
    }
</style>
@endpush
@endsection
