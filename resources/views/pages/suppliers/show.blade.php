@extends('layouts.master')

@section('page')
    <h2>Supplier Details</h2>

    <div class="card">
        <div class="card-body">
            <p><strong>Name:</strong> {{ $supplier->name }}</p>
            <p><strong>Mobile:</strong> {{ $supplier->mobile }}</p>
            <p><strong>Email:</strong> {{ $supplier->email }}</p>
        </div>
    </div>

    <div class="mt-3">
        <a href="{{ route('suppliers.index') }}" class="btn btn-success">Back</a>
        <a href="{{ route('suppliers.edit', $supplier) }}" class="btn btn-primary">Edit</a>
    </div>
@endsection
