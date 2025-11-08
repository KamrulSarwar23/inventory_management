@extends('layouts.master')

@section('page')
<h2>Edit Shipper</h2>

@if($errors->any())
<div class="alert alert-danger">
    <strong>Please fix the errors:</strong>
    <ul>
        @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form action="{{ route('shippers.update', $shipper) }}" method="POST">
    @method('PUT')
    @csrf

    <div class="mb-3">
        <label class="form-label">Shipper Name</label>
        <input type="text" name="name" value="{{ old('name', $shipper->name ?? '') }}" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Contact Person</label>
        <input type="text" name="contact_person" value="{{ old('contact_person', $shipper->contact_person ?? '') }}" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Contact No</label>
        <input type="text" name="contact_no" value="{{ old('contact_no', $shipper->contact_no ?? '') }}" class="form-control">
    </div>

    <button type="submit" class="btn btn-success">Save</button>
    <a href="{{ route('shippers.index') }}" class="btn btn-secondary">Cancel</a>

</form>
@endsection