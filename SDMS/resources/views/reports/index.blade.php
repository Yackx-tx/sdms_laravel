@extends('layouts.app')
@include('layouts.topbar')
@section('content')
<div class="container-fluid" style="margin-top: 80px;">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                    <h5 class="mb-0 text-primary fw-bold">Report Management</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <div class="card h-100 shadow-sm">
                                <div class="card-body text-center">
                                    <i class="fas fa-calendar-check fa-3x mb-3 text-success"></i>
                                    <h5 class="fw-bold">Attendance Summary</h5>
                                    <p class="text-muted">View attendance statistics and patterns</p>
                                    <div class="mt-3">
                                        <a href="{{ route('reports.attendance') }}" class="btn btn-success btn-lg">
                                            <i class="fas fa-clipboard-check me-1"></i> View Report
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 mb-4">
                            <div class="card h-100 shadow-sm">
                                <div class="card-body text-center">
                                    <i class="fas fa-graduation-cap fa-3x mb-3 text-info"></i>
                                    <h5 class="fw-bold">Grade Distribution</h5>
                                    <p class="text-muted">Analyze grade distributions across courses</p>
                                    <div class="mt-3">
                                        <a href="{{ route('reports.grades') }}" class="btn btn-info btn-lg">
                                            <i class="fas fa-chart-pie me-1"></i> View Report
                                        </a>
                                    </div>
                                </div>
                            </div>
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
        transition: transform 0.2s ease-in-out;
    }
    .card:hover {
        transform: translateY(-5px);
    }
    .btn {
        padding: 0.5rem 1.5rem;
    }
    .fa-3x {
        margin-bottom: 1rem;
    }
</style>
@endpush
@endsection
