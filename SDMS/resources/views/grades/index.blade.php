@extends('layouts.app')
@include('layouts.topbar')
@section('content')
<div class="container-fluid" style="margin-top:80px;">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                    <h5 class="mb-0 text-primary fw-bold">Grade Management</h5>
                    <a href="{{ route('grades.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus-circle me-1"></i> Add New Grades
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th class="fw-bold">Student Name</th>
                                    <th class="fw-bold">Section</th>
                                    <th class="fw-bold">Course</th>
                                    <th class="fw-bold">Score</th>
                                    <th class="fw-bold">Grade Letter</th>
                                    <th class="fw-bold">Semester</th>
                                    <th class="fw-bold">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($grades as $grade)
                                <tr>
                                    <td>{{ $grade->student_name }}</td>
                                    <td>{{ $grade->student->section->SectionName }}</td>
                                    <td>{{ $grade->course->course_name }}</td>
                                    <td><span class="badge bg-info">{{ $grade->score }}</span></td>
                                    <td><span class="badge bg-primary">{{ $grade->grade_letter }}</span></td>
                                    <td>{{ $grade->semester }}</td>
                                    <td>
                                        <a href="{{ route('grades.edit', $grade->id) }}" class="btn btn-sm btn-outline-info me-1">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('grades.destroy', $grade->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this grade?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-muted">No grades found</td>
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
@endsection
