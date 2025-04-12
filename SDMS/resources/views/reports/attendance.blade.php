@extends('layouts.app')
@include('layouts.topbar')
@section('content')
<div class="container-fluid" style="margin-top: 80px;">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <!-- Header section -->
                <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                    <h5 class="mb-0 text-success fw-bold">
                        <i class="fas fa-calendar-check me-2"></i>Attendance Summary
                    </h5>
                    <div>
                        <button class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#filterModal">
                            <i class="fas fa-filter me-1"></i>Filter
                        </button>
                        <a href="{{ route('reports.export.attendance') }}" class="btn btn-success me-2">
                            <i class="fas fa-file-excel me-1"></i>Export
                        </a>
                        <a href="{{ route('reports.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-1"></i>Back
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <!-- Statistics Cards Row -->
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <div class="card bg-success text-white">
                                <div class="card-body text-center">
                                    <h6>Overall Attendance Rate</h6>
                                    <h2>{{ $attendanceRate }}%</h2>
                                </div>
                            </div>
                        </div>
                        <!-- Other stat cards remain unchanged -->
                    </div>

                    <!-- Interactive Data Table -->
                    <div class="table-responsive">
                        <table class="table table-hover" id="attendanceTable">
                            <thead class="table-light">
                                <tr>
                                    <th>Course</th>
                                    <th>Section</th>
                                    <th>Total Classes</th>
                                    <th>Present</th>
                                    <th>Absent</th>
                                    <th>Attendance Rate</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($attendanceData as $data)
                                <tr>
                                    <td>{{ $data->course_name }}</td>
                                    <td>{{ $data->section_name }}</td>
                                    <td>{{ $data->total_records }}</td>
                                    <td>{{ $data->present_count }}</td>
                                    <td>{{ $data->absent_count }}</td>
                                    <td>
                                        @php
                                        $rate = $data->total_records > 0 ?
                                        round(($data->present_count / $data->total_records) * 100, 2) :
                                        0;
                                        $colorClass = $rate >= 75 ? 'bg-success' : ($rate >= 50 ? 'bg-warning' : 'bg-danger');
                                        @endphp
                                        <div class="progress">
                                            <div class="progress-bar {{ $colorClass }}"
                                                role="progressbar"
                                                style="width:' {{ $rate }}%;'"
                                                aria-valuenow="{{ $rate }}"
                                                aria-valuemin="0"
                                                aria-valuemax="100">
                                                {{ $rate }}%
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-info" onclick="viewDetails('{{ $data->id }}')" data-bs-toggle="tooltip" title="View Details">
                                            <span class="spinner-border spinner-border-sm d-none" role="status"></span>
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="btn btn-sm btn-primary" onclick="printReport('{{ $data->id }}')" data-bs-toggle="tooltip" title="Print Report">
                                            <span class="spinner-border spinner-border-sm d-none" role="status"></span>
                                            <i class="fas fa-print"></i>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
</div>

<!-- Filter Modal -->
<div class="modal fade" id="filterModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Filter Attendance</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="filterForm">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Date Range</label>
                        <input type="date" class="form-control" name="start_date" id="start_date" max="{{ date('Y-m-d') }}">
                        <input type="date" class="form-control mt-2" name="end_date" id="end_date" max="{{ date('Y-m-d') }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Course</label>
                        <select class="form-select" name="course_id">
                            <option value="">All Courses</option>
                            @foreach($courses as $course)
                            <option value="{{ $course->id }}" {{ request('course_id') == $course->id ? 'selected' : '' }}>
                                {{ $course->course_name }}
                            </option>
                            @endforeach
                        </select>

                    </div>
                    <div class="mb-3">
                        <label class="form-label">Section</label>
                        <select class="form-select" name="section_id">
                            <option value="">All Sections</option>
                            <!-- Add section options dynamically -->
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="applyFilters()">Apply Filters</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        // Date range validation
        $('#end_date').change(function() {
            const startDate = $('#start_date').val();
            const endDate = $(this).val();

            if (startDate && endDate < startDate) {
                alert('End date cannot be before start date');
                $(this).val('');
            }
        });

        // Enhanced filter application
        function applyFilters() {
            const startDate = $('#start_date').val();
            const endDate = $('#end_date').val();
            const courseId = $('select[name="course_id"]').val();
            const sectionId = $('select[name="section_id"]').val();

            if (startDate && !endDate) {
                alert('Please select an end date');
                return;
            }

            const formData = new FormData(document.getElementById('filterForm'));
            const params = new URLSearchParams(formData);
            window.location.href = `/attendance/filter?${params}`;
        }
    });
</script>
@endpush
@endsection
