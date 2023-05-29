@extends('layout')

@section('content')
    <div class="container">
        <h1>Create Student</h1>

        <form method="POST" action="{{ route('students.store') }}">
            @csrf

            <div class="form-group">
                <label for="name">Student Name</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Enter student name" value="{{ old('name') }}" required>
            </div>

            <div class="form-group">
                <label for="course_id">Course</label>
                <select class="form-control" id="course_id" name="course_id" required>
                    <option value="">Select a course</option>
                    @foreach ($courses as $course)
                        <option value="{{ $course->id }}">{{ $course->name }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Create</button>
        </form>
    </div>
@endsection
