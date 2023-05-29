@extends('layout')

@section('content')
    <div class="container">
        <h1>Student Details</h1>

        <h3>Name: {{ $student->name }}</h3>

        <h3>Enrolled Courses:</h3>
        <ul>
            @foreach ($student->courses as $course)
                <li>{{ $course->name }}</li>
            @endforeach
        </ul>

        <a href="{{ route('students.edit', $student->id) }}" class="btn btn-primary">Edit</a>
        <form action="{{ route('students.destroy', $student->id) }}" method="POST" style="display: inline-block;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
        </form>
    </div>
@endsection
