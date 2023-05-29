@extends('layout')

@section('content')
    <div class="container mt-5">
        <h2>{{ $course->name }}</h2>
        <p><strong>Description:</strong> {{ $course->description }}</p>
        <p><strong>Duration:</strong> {{ $course->duration }}</p>
        <a href="{{ route('courses.edit', $course) }}" class="btn btn-secondary">Edit</a>
        <form action="{{ route('courses.destroy', $course) }}" method="POST" class="d-inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this course?')">Delete</button>
        </form>
    </div>
@endsection
