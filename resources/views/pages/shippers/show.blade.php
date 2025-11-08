@extends('layouts.master')

@section('page')
    <h2>Shipper Details</h2>

    <div class="card">
        <div class="card-body">
            <p><strong>Name:</strong> {{ $shipper->name }}</p>
            <p><strong>Contact Person:</strong> {{ $shipper->contact_person }}</p>
            <p><strong>Contact No:</strong> {{ $shipper->contact_no ?? '-' }}</p>
        </div>
    </div>

    <div class="mt-3">
        <a href="{{ route('shippers.index') }}" class="btn btn-secondary">Back</a>
        <a href="{{ route('shippers.edit', $shipper) }}" class="btn btn-primary">Edit</a>
    </div>
@endsection
