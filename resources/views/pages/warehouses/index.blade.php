@extends('layouts.master')

@section('page')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Warehouses</h2>
        <a href="{{ route('warehouses.create') }}" class="btn btn-primary">+ Add Warehouse</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>City</th>
                <th>Contact</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($warehouses as $warehouse)
                <tr>
                    <td>{{ $warehouse->id }}</td>
                    <td>{{ $warehouse->name }}</td>
                    <td>{{ $warehouse->city }}</td>
                    <td>{{ $warehouse->contact }}</td>
                    <td>
                        <a href="{{ route('warehouses.show', $warehouse) }}" class="btn btn-sm btn-info">View</a>
                        <a href="{{ route('warehouses.edit', $warehouse) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('warehouses.destroy', $warehouse) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this warehouse?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">No warehouses found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
