@extends('layouts.app')
@include('layouts.topbar')
@section('content')
<div class="container-fluid" style="margin-top: 80px;">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-3">
                    <h5 class="mb-0 fw-bold">
                        <i class="fas fa-graduation-cap me-2"></i>Grade Distribution Report
                    </h5>
                    <a href="{{ route('reports.index') }}" class="btn btn-light">
                        <i class="fas fa-arrow-left me-1"></i>Back to Reports
                    </a>
                </div>
                <div class="card-body bg-light">
                    <div class="row g-4">
                        <!-- <div class="col-md-6">
                            <div class="card shadow-sm h-100">
                                <div class="card-body">
                                    <canvas id="gradeDistributionChart"></canvas>
                                </div>
                            </div>
                        </div> -->
                        <div class="col-md-12">
                            <div class="card shadow-sm mb-4">
                                <div class="card-header bg-white">
                                    <h6 class="mb-0 fw-bold">Grade Summary</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row g-3">
                                        @foreach($gradePercentages as $grade)
                                        <div class="col-4 text-center">
                                            <div class="p-3 rounded-3 bg-white shadow-sm">
                                                <h3 class="text-{{ $grade->grade_letter == 'A' ? 'success' : ($grade->grade_letter == 'B' ? 'primary' : 'warning') }} mb-2">
                                                    {{ $grade->grade_letter }}
                                                </h3>
                                                <p class="mb-0 fw-bold">{{ number_format($grade->percentage, 1) }}%</p>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>

                                </div>
                            </div>

                            <div class="card shadow-sm">
                                <div class="card-header bg-white">
                                    <h6 class="mb-0 fw-bold">Course Performance</h6>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover align-middle">
                                            <thead class="table-light">
                                                <tr>
                                                    <th class="fw-bold">Course</th>
                                                    <th class="fw-bold text-center">Average</th>
                                                    <th class="fw-bold text-center">Highest</th>
                                                    <th class="fw-bold text-center">Lowest</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($courseGrades as $course)
                                                <tr>
                                                    <td>{{ $course->course_name }}</td>
                                                    <td class="text-center">{{ number_format($course->average_grade, 1) }}</td>
                                                    <td class="text-center text-success">{{ $course->highest_grade }}</td>
                                                    <td class="text-center text-danger">{{ $course->lowest_grade }}</td>
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
</div>
@endsection
