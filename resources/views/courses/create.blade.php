@extends('layout')

@section('content')
    <div class="container mt-5">
        <h2>Create Course</h2>
        <form method="POST" action="{{ route('courses.store') }}">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">Course Name:</label>
                <input type="text" class="form-control" id="name" name="name">
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description:</label>
                <textarea class="form-control" id="description" name="description" rows="4"></textarea>
            </div>

            <div class="mb-3">
                <label for="duration" class="form-label">Duration:</label>
                <input type="text" class="form-control" id="duration" name="duration">
            </div>

            <button type="submit" class="btn btn-primary">Create Course</button>
        </form>
    </div>
@endsection
