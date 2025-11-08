@extends('layouts.master')

@section('page')
<div class="container">
    <h1>Categories</h1>
    <a href="{{ route('categories.create') }}" class="btn btn-primary mb-3">Add Category</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th><th>Name</th><th>Description</th><th>Action</th>
            </tr>
        </thead>
        <tbody>
        @forelse($categories as $category)
            <tr>
                <td>{{ $category->id }}</td>
                <td>{{ $category->name }}</td>
                <td>{{ $category->description }}</td>
                <td>
                    <a href="{{ route('categories.show',$category) }}" class="btn btn-info btn-sm">View</a>
                    <a href="{{ route('categories.edit',$category) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('categories.destroy',$category) }}" method="POST" style="display:inline">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger btn-sm" onclick="return confirm('Delete this category?')">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="4">No categories found.</td></tr>
        @endforelse
        </tbody>
    </table>

    {{ $categories->links() }}
</div>
@endsection
