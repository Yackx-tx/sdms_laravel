@extends('layouts.app')
@include('layouts.topbar')
@section('content')
<div class="container-fluid" style="margin-top:80px">
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center bg-white p-4 rounded shadow-sm">
                <div>
                    <h2 class="text-primary mb-0">
                        <i class="fas fa-layer-group me-2"></i>Sections Management
                    </h2>
                    <p class="text-muted mb-0">Manage and organize your sections</p>
                </div>
                <a href="{{ route('sections.create') }}" class="btn btn-primary btn">
                    <i class="fas fa-plus me-2"></i>Add New Section
                </a>
            </div>
        </div>
    </div>

    <!-- Main Content Card -->
    <div class="card shadow">
        <div class="card-header bg-white py-3">
            <div class="row align-items-center">
                <div class="col">
                    <h5 class="mb-0 text-primary ">All Sections</h5>
                </div>
                <div class="col-auto">
                    <div class="input-group">
                        <input type="text" class="form-control" id="searchSection" placeholder="Search sections...">
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
                            <th class="text-center">#</th>
                            <th>Section Name</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sections as $section)
                        <tr>
                            <td class="text-center">{{ $section->SectionId }}</td>
                            <td>
                                <span class="fw-medium">{{ $section->SectionName }}</span>
                            </td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <a href="{{ route('sections.edit', $section->SectionId) }}"
                                       class="btn btn-sm btn-info me-2" data-bs-toggle="tooltip" title="Edit Section">
                                        <i class="fas fa-edit text-white"></i>
                                    </a>
                                    <form action="{{ route('sections.destroy', $section->SectionId) }}"
                                          method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"
                                                data-bs-toggle="tooltip" title="Delete Section"
                                                onclick="return confirm('Are you sure you want to delete this section?')">
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
                                    <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>
                                    <h5 class="text-muted">No Sections Found</h5>
                                    <p class="text-muted mb-0">Start by adding your first section</p>
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

@endsection
