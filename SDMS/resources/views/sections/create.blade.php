@extends('layouts.app')
@include('layouts.topbar')
@section('content')
<div class="container-fluid" style="margin-top:80px;">
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center bg-white p-3 rounded shadow-sm">
                <div>
                    <h2 class="text-primary mb-0">
                        <i class="fas fa-plus me-2"></i>Create New Section
                    </h2>
                    <p class="text-muted mb-0">Add a new section to your system</p>
                </div>
                <a href="{{ route('sections.index') }}" class="btn btn-secondary btn">
                    <i class="fas fa-arrow-left me-2"></i>Back to Sections
                </a>
            </div>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-body p-4">
            <form action="{{ route('sections.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="SectionName" class="form-label fw-bold">Section Name</label>
                    <input type="text" class="form-control form-control-lg @error('SectionName') is-invalid @enderror"
                           id="SectionName" name="SectionName" value="{{ old('SectionName') }}" required>
                    @error('SectionName')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <a href="{{ route('sections.index') }}" class="btn btn-secondary btn me-2">Cancel</a>
                    <button type="submit" class="btn btn-primary btn">Create Section</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('styles')
<style>
    .btn {
        transition: all 0.3s ease;
    }
    .btn:hover {
        transform: translateY(-2px);
    }
    .form-control-lg {
        padding: 1rem 0.75rem;
    }
    .card {
        border: none;
        border-radius: 0.5rem;
    }
    .card-body {
        background-color: #fff;
    }
</style>
@endpush
@endsection
