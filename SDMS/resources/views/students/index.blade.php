@extends('layouts.app')
@include('layouts.topbar')
@section('content')
<div class="container-fluid" style="margin-top:80px">
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center bg-white p-4 rounded shadow-sm">
                <div>
                    <h2 class="text-primary mb-0">
                        <i class="fas fa-user-graduate me-2"></i>Student Management
                    </h2>
                    <p class="text-muted mb-0">Manage and organize your students</p>
                </div>
                <a href="{{ route('students.create') }}" class="btn btn-primary btn">
                    <i class="fas fa-plus me-2"></i>Add New Student
                </a>
            </div>
        </div>
    </div>

    <!-- Main Content Card -->
    <div class="card shadow">
        <div class="card-header bg-white py-3">
            <div class="row align-items-center">
                <div class="col">
                    <h5 class="mb-0 text-primary">All Students</h5>
                </div>
                <div class="col-auto">
                    <div class="input-group">
                        <input type="text" class="form-control" id="studentSearch" placeholder="Search students...">
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
                            <th scope="col" class="text-nowrap">#</th>
                            <th scope="col" class="text-nowrap">First Name</th>
                            <th scope="col" class="text-nowrap">Last Name</th>
                            <th scope="col" class="text-nowrap">Section</th>
                            <th scope="col" class="text-nowrap">Gender</th>
                            <th scope="col" class="text-nowrap">Date of Birth</th>
                            <th scope="col" class="text-nowrap">Contact</th>
                            <th scope="col">Email</th>
                            <th scope="col">Address</th>
                            <th scope="col" class="text-nowrap">Enrollment Date</th>
                            <th scope="col" class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($students as $student)
                        <tr>
                            <td class="fw-bold text-primary">{{ $student->StudentId }}</td>
                            <td>{{ $student->FirstName }}</td>
                            <td>{{ $student->LastName }}</td>
                            <td>{{ $student->section ? $student->section->SectionName : 'No Section Assigned' }}</td>
                            <td>{{ $student->Gender }}</td>
                            <td>{{ date('Y-m-d', strtotime($student->DateOfBirth)) }}</td>
                            <td>{{ $student->ContactNumber }}</td>
                            <td>{{ $student->Email }}</td>
                            <td>{{ Str::limit($student->Address, 30) }}</td>
                            <td>{{ date('Y-m-d', strtotime($student->EnrollmentDate)) }}</td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <a href="{{ route('students.show', $student) }}" class="btn btn-sm btn-primary me-2">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('students.edit', $student) }}" class="btn btn-sm btn-info me-2">
                                        <i class="fas fa-edit text-white"></i>
                                    </a>
                                    <form action="{{ route('students.destroy', $student) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"
                                            onclick="return confirm('Are you sure you want to delete this student?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="11" class="text-center py-5">
                                <div class="empty-state">
                                    <i class="fas fa-user-graduate fa-3x text-muted mb-3"></i>
                                    <h5 class="text-muted">No Students Found</h5>
                                    <p class="text-muted mb-0">Start by adding your first student</p>
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

    .table> :not(caption)>*>* {
        padding: 1rem 0.75rem;
    }
</style>
@endpush

<script>
    document.getElementById('studentSearch').addEventListener('keyup', function() {
        const searchValue = this.value.toLowerCase();
        const tableRows = document.querySelectorAll('tbody tr');

        tableRows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(searchValue) ? '' : 'none';
        });
    });
</script>

@endsection