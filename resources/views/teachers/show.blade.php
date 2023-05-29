@extends('layout')

@section('content')
    <div class="container mt-5">
        <h2>{{ $teacher->name }}</h2>
        <a href="{{ route('teachers.edit', $teacher) }}" class="btn btn-secondary">Edit</a>
        <form action="{{ route('teachers.destroy', $teacher) }}" method="POST" class="d-inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this teacher?')">Delete</button>
        </form>
    </div>
@endsection
