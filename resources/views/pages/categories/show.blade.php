@extends('layouts.master')

@section('page')
<div class="container">
    <h1>{{ $category->name }}</h1>
    <p><strong>Description:</strong> {{ $category->description }}</p>

    <a href="{{ route('categories.index') }}" class="btn btn-secondary">Back</a>
</div>
@endsection
