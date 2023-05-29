@extends('layout')

@section('content')
    <div class="container mt-5">
        <h2>Edit Course</h2>
        <form method="POST" action="{{ route('courses.update', $course) }}">
            @csrf
            @method('PATCH')

            <div class="mb-3">
                <label for="name" class="form-label">Course Name:</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $course->name }}">
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description:</label>
                <textarea class="form-control" id="description" name="description" rows="4">{{ $course->description }}</textarea>
            </div>

            <div class="mb-3">
                <label for="duration" class="form-label">Duration:</label>
                <input type="text" class="form-control" id="duration" name="duration" value="{{ $course->duration }}">
            </div>

            <button type="submit" class="btn btn-primary">Update Course</button>
        </form>
    </div>
@endsection
