@extends('layouts.app')
@include('layouts.topbar')
@section('content')
<div class="container-fluid" style="margin-top:80px">
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center bg-white p-4 rounded shadow-sm">
                <div>
                    <h2 class="text-primary mb-0">
                        <i class="fas fa-book me-2"></i>Course Management
                    </h2>
                    <p class="text-muted mb-0">Manage and organize your courses</p>
                </div>
                <a href="{{ route('courses.create') }}" class="btn btn-primary btn">
                    <i class="fas fa-plus me-2"></i>Add New Course
                </a>
            </div>
        </div>
    </div>

    <!-- Main Content Card -->
    <div class="card shadow">
        <div class="card-header bg-white py-3">
            <div class="row align-items-center">
                <div class="col">
                    <h5 class="mb-0 text-primary">All Courses</h5>
                </div>
                <div class="col-auto">
                    <div class="input-group">
                        <input type="text" class="form-control" id="courseSearch" placeholder="Search courses...">
                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th scope="col" class="text-nowrap">Code</th>
                            <th scope="col" class="text-nowrap">Name</th>
                            <th scope="col">Description</th>
                            <th scope="col" class="text-nowrap">Credits</th>
                            <th scope="col">Instructor</th>
                            <th scope="col" class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($courses as $course)
                        <tr>
                            <td class="fw-bold text-primary">{{ $course->course_code }}</td>
                            <td>{{ $course->course_name }}</td>
                            <td>{{ Str::limit($course->description, 50) }}</td>
                            <td class="text-center">{{ $course->credits }}</td>
                            <td>{{ $course->instructor }}</td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <a href="{{ route('courses.show', $course) }}" class="btn btn-sm btn-primary me-2">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('courses.edit', $course) }}" class="btn btn-sm btn-info me-2">
                                        <i class="fas fa-edit text-white"></i>
                                    </a>
                                    <form action="{{ route('courses.destroy', $course) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"
                                                onclick="return confirm('Are you sure you want to delete this course?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div class="empty-state">
                                    <i class="fas fa-book fa-3x text-muted mb-3"></i>
                                    <h5 class="text-muted">No Courses Found</h5>
                                    <p class="text-muted mb-0">Start by adding your first course</p>
                                </div>
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
    .empty-state {
        padding: 2rem;
    }
    .btn-group .btn {
        transition: all 0.3s ease;
    }
    .btn-group .btn:hover {
        transform: translateY(-2px);
    }
    .table > :not(caption) > * > * {
        padding: 1rem 0.75rem;
    }
</style>
@endpush

<script>
    document.getElementById('courseSearch').addEventListener('keyup', function() {
        const searchValue = this.value.toLowerCase();
        const tableRows = document.querySelectorAll('tbody tr');
        
        tableRows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(searchValue) ? '' : 'none';
        });
    });
</script>

@endsection
