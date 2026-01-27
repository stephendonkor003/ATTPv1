@extends('layouts.app')
@section('title', 'Project Categories')

@section('content')
    <main class="nxl-container">
        <div class="nxl-content">
            <div class="page-header">
                <div class="page-header-left d-flex align-items-center">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Project Categories</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item">All Categories</li>
                    </ul>
                </div>
                <div class="page-header-right ms-auto">
                    <div class="d-flex align-items-center gap-2 page-header-right-items-wrapper">
                        <a href="{{ route('categories.create') }}" class="btn btn-light-brand">
                            <i class="feather-plus-circle me-2"></i>
                            <span>Add Category</span>
                        </a>
                    </div>
                </div>
            </div>

            <div class="main-content">
                <div class="card">
                    <div class="card-body table-responsive">
                        <table class="table table-hover" style="width:100%" id="proposalList1">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Created By</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($categories as $index => $category)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $category->name }}</td>
                                        <td>{{ Str::limit($category->description, 50) }}</td>
                                        <td>{{ $category->creator->name ?? 'N/A' }}</td>
                                        <td>
                                            <div class="d-flex gap-1">
                                                <a href="{{ route('categories.edit', $category->id) }}"
                                                    class="btn btn-sm btn-outline-primary">Edit</a>
                                                <form action="{{ route('categories.destroy', $category->id) }}"
                                                    method="POST" onsubmit="return confirm('Delete this category?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-sm btn-outline-danger">Delete</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">No categories found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="m-3">
                            {{ $categories->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
