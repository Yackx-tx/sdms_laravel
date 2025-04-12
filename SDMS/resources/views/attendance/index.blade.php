@extends('layouts.app')
@include('layouts.topbar')
@section('content')
<div class="container-fluid" style="margin-top:80px">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center bg-white p-4 rounded shadow-sm">
                <div>
                    <h2 class="text-primary mb-0">
                        <i class="fas fa-calendar-check me-2"></i>Attendance Records
                    </h2>
                    <p class="text-muted mb-0">View and manage student attendance records</p>
                </div>
                <a href="{{ route('attendance.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus-circle me-2"></i>Record Attendance
                </a>
            </div>
        </div>
    </div>

    <!-- Main Content Card -->
    <div class="card shadow">
        <div class="card-header bg-primary py-3">
            <h5 class="mb-0 text-light fw-bold">Attendance Records</h5>
        </div>
        <div class="card-body">
            <form class="row g-3 mb-4" method="GET" action="{{ route('attendance.index') }}">
                <div class="col-md-3">
                    <label class="form-label fw-bold">Section</label>
                    <select class="form-select form-select-lg" name="SectionId">
                        <option value="">All Sections</option>
                        @foreach($sections as $section)
                        <option value="{{ $section->SectionId }}" {{ request('SectionId') == $section->SectionId ? 'selected' : '' }}>
                            {{ $section->SectionName }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold">Course</label>
                    <select class="form-select form-select-lg" name="CourseId">
                        <option value="">All Courses</option>
                        @foreach($courses as $course)
                        <option value="{{ $course->CourseId }}" {{ request('CourseId') == $course->CourseId ? 'selected' : '' }}>
                            {{ $course->course_name }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold">Date</label>
                    <input type="date" class="form-control form-control-lg" name="date" value="{{ request('date') }}">
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-filter gap-1"></i>Filter
                        </button>
                        <a href="{{ route('attendance.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-redo gap-1"></i>Reset
                        </a>
                    </div>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-hover border">
                    <thead class="bg-light">
                        <tr>
                            <th class="fw-bold">Student</th>
                            <th class="fw-bold">Section</th>
                            <th class="fw-bold">Course</th>
                            <th class="fw-bold">Date</th>
                            <th class="fw-bold">Status</th>
                            <th class="fw-bold">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($attendances as $attendance)
                        <tr>
                            <td>{{ $attendance->student->FirstName }} {{ $attendance->student->LastName }}</td>
                            <td>{{ $attendance->section->SectionName ?? 'N/A' }}</td>
                            <td>{{ $attendance->course->course_name ?? 'N/A' }}</td>
                            <td>{{ date('M d, Y', strtotime($attendance->date)) }}</td>
                            <td>
                                <span class="badge rounded-pill {{ $attendance->status === 'present' ? 'bg-success' : ($attendance->status === 'late' ? 'bg-warning' : 'bg-danger') }}">
                                    {{ ucfirst($attendance->status) }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('attendance.edit', $attendance->id) }}" class="btn btn-sm btn-primary me-2">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('attendance.destroy', $attendance->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">
                                <i class="fas fa-inbox fa-2x mb-3 d-block"></i>
                                No attendance records found
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .form-label { font-weight: 500; }
    .form-control, .form-select { padding: 0.75rem; }
    .btn-lg { padding: 0.75rem 1.5rem; }
</style>
@endpush
@endsection
