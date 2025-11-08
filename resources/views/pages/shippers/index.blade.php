@extends('layouts.master')

@section('page')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Shippers</h2>
        <a href="{{ route('shippers.create') }}" class="btn btn-primary">+ Add Shipper</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Contact Person</th>
                <th>Contact No</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($shippers as $shipper)
                <tr>
                    <td>{{ $shipper->id }}</td>
                    <td>{{ $shipper->name }}</td>
                    <td>{{ $shipper->contact_person }}</td>
                    <td>{{ $shipper->contact_no ?? '-' }}</td>
                    <td>
                        <a href="{{ route('shippers.show', $shipper) }}" class="btn btn-sm btn-info">View</a>
                        <a href="{{ route('shippers.edit', $shipper) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('shippers.destroy', $shipper) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('Delete this shipper?')" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5">No shippers found.</td></tr>
            @endforelse
        </tbody>
    </table>
@endsection
