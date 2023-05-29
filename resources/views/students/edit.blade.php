@extends('layout')

@section('content')
    <div class="container">
        <h1>Edit Student</h1>

        <form method="POST" action="{{ route('students.update', $student->id) }}">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Student Name</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Enter student name" value="{{ old('name', $student->name) }}" required>
            </div>

            <div class="form-group">
                <label for="course_id">Enrolled Courses</label>
                <ul>
                    @foreach ($student->courses as $course)
                        <li>{{ $course->name }}</li>
                    @endforeach
                </ul>
            </div>

            <div class="form-group">
                <label for="new_course_id">Add More Courses</label>
                <select class="form-control" id="new_course_id" name="new_course_id[]" multiple>
                    @foreach ($availableCourses as $course)
                        <option value="{{ $course->id }}">{{ $course->name }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
@endsection
