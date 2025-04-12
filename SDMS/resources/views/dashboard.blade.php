@extends('layouts.app')
@include('layouts.topbar')
@section('content')
<div class="container-fluid" style="margin-top:80px;">
    <div class="row">
        <!-- Main Content -->
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 text-primary fw-bold" style="font-size:25px;">{{ config('app.name', 'Laravel') }} Dashboard Overview</h5>
                </div>
                <div class="card-body">
                    <h4 class="mb-4">Welcome back, <span class="text-primary">{{ auth()->user()->name }}</span>!</h4>
                    <div class="row g-4">
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-primary text-white hover-shadow transition h-100">
                                <div class="card-body d-flex justify-content-between align-items-start">
                                    <div>
                                        <h5 class="card-title fw-light">Total Students</h5>
                                        <p class="card-text display-6 mb-0">{{ $totalStudents }}</p>
                                    </div>
                                    <i class="fas fa-users fa-2x opacity-50"></i>
                                </div>
                                <div class="card-footer bg-primary border-0">
                                    <a href="{{ route('students.index') }}" class="text-white text-decoration-none small">View Details <i class="fas fa-arrow-right ms-1"></i></a>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-success text-white hover-shadow transition h-100">
                                <div class="card-body d-flex justify-content-between align-items-start">
                                    <div>
                                        <h5 class="card-title fw-light">Active Courses</h5>
                                        <p class="card-text display-6 mb-0">{{ $activeCourses }}</p>
                                    </div>
                                    <i class="fas fa-book fa-2x opacity-50"></i>
                                </div>
                                <div class="card-footer bg-success border-0">
                                    <a href="{{ route('courses.index') }}" class="text-white text-decoration-none small">View Details <i class="fas fa-arrow-right ms-1"></i></a>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-info text-white hover-shadow transition h-100">
                                <div class="card-body d-flex justify-content-between align-items-start">
                                    <div>
                                        <h5 class="card-title fw-light">Today's Attendance</h5>
                                        <p class="card-text display-6 mb-0">{{ $attendancePercentage }}%</p>
                                    </div>
                                    <i class="fas fa-chart-line fa-2x opacity-50"></i>
                                </div>
                                <div class="card-footer bg-info border-0">
                                    <a href="{{ route('attendance.index') }}" class="text-white text-decoration-none small">View Details <i class="fas fa-arrow-right ms-1"></i></a>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-warning text-white hover-shadow transition h-100">
                                <div class="card-body d-flex justify-content-between align-items-start">
                                    <div>
                                        <h5 class="card-title fw-light">Average Grade</h5>
                                        <p class="card-text display-6 mb-0">{{ number_format($averageGrade, 1) }}</p>
                                    </div>
                                    <i class="fas fa-graduation-cap fa-2x opacity-50"></i>
                                </div>
                                <div class="card-footer bg-warning border-0">
                                    <a href="{{ route('grades.index') }}" class="text-white text-decoration-none small">View Details <i class="fas fa-arrow-right ms-1"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive" style="margin-top:20px;">
                        <div>
                            <h6 class="text-primary fw-bold"> <i class="fa fa-file"></i> Recent Activity</h6>
                        </div>
                        <table class="table table-hover align-middle">
                            <thead>
                                <tr>
                                    <th>Time</th>
                                    <th>User</th>
                                    <th>Activity</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentActivities as $activity)
                                <tr>
                                    <td>{{ $activity->created_at->diffForHumans() }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm me-2">
                                                {{ $activity->user->name }}
                                            </div>
                                        </div>
                                    </td>

                                    <td>
                                        <div class="d-flex align-items-center">
                                            <span class="badge bg-{{ $activity->status_color }} me-2">
                                                <i class="fas fa-circle-plus"></i>
                                            </span>
                                            {{ $activity->description }}
                                        </div>
                                    </td>

                                    <td>
                                        <span class="badge bg-{{ $activity->status_color }}">
                                            {{ ucfirst($activity->status) }}
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4">
                                        <i class="fas fa-inbox fa-2x mb-3 d-block text-muted"></i>
                                        No activities found
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .hover-shadow:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    }

    .transition {
        transition: all 0.3s ease;
    }

    .card {
        border-radius: 10px;
        border: none;
        margin-bottom: 1rem;
    }

    .card-header {
        border-radius: 10px 10px 0 0;
        padding: 1rem 1.5rem;
    }

    .opacity-50 {
        opacity: 0.5;
    }

    .table th {
        font-weight: 600;
        background-color: #f8f9fa;
    }

    .dropdown-menu {
        border: none;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
    }
</style>
@endsection