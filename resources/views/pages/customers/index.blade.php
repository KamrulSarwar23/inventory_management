@extends('layouts.master')

@section('page')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Customers</h2>
    <a href="{{ route('customers.create') }}" class="btn btn-primary">+ Add Customer</a>
</div

    <div class="container mt-4">


@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Mobile</th>
            <th>Email</th>
            <th>Photo</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($customers as $customer)
        <tr>
            <td>{{ $customer->id }}</td>
            <td>{{ $customer->name }}</td>
            <td>{{ $customer->mobile }}</td>
            <td>{{ $customer->email }}</td>
            <td>
                @if($customer->photo)
                <img src="{{ asset('storage/' . $customer->photo) }}" width="100">
                @endif
            </td>
            <td>
                <a href="{{ route('customers.show', $customer) }}" class="btn btn-info btn-sm">View</a>
                <a href="{{ route('customers.edit', $customer) }}" class="btn btn-warning btn-sm">Edit</a>
                <form action="{{ route('customers.destroy', $customer) }}" method="POST" style="display:inline-block">
                    @csrf @method('DELETE')
                    <button onclick="return confirm('Delete this customer?')" class="btn btn-danger btn-sm">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
</div>
@endsection