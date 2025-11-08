@extends('layouts.master')

@section('page')
    <div class="container mt-4">
        <h1 class="mb-4">Warehouse Details</h1>

        <div class="card">
            <div class="card-body">
                <p><strong>Warehouse Name:</strong> {{ $warehouse->name }}</p>
                <p><strong>City:</strong> {{ $warehouse->city }}</p>
                <p><strong>Contact:</strong> {{ $warehouse->contact }}</p>
            </div>
        </div>

        <div class="mt-3">
            <a href="{{ route('warehouses.index') }}" class="btn btn-primary">← Back to List</a>
        </div>
    </div>
@endsection

