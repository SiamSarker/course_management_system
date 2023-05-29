@extends('layout')

@section('content')
    <div class="container mt-5">
        <h2>Courses</h2>
        <a href="{{ route('courses.create') }}" class="btn btn-primary mb-3">Create Course</a>
        <table class="table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Duration</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($courses as $course)
                <tr>
                    <td>{{ $course->id }}</td>
                    <td>{{ $course->name }}</td>
                    <td>{{ $course->description }}</td>
                    <td>{{ $course->duration }}</td>
                    <td>
                        <a href="{{ route('courses.show', $course) }}" class="btn btn-primary btn-sm">View</a>
                        <a href="{{ route('courses.edit', $course) }}" class="btn btn-secondary btn-sm">Edit</a>
                        <form action="{{ route('courses.destroy', $course) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this course?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
