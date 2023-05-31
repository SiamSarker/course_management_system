@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Edit Student</h1>

        <form action="{{ route('students.update', $student->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $student->name }}" required>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ $student->email }}" required>
            </div>

            <div class="form-group">
                <label for="courses">Courses</label>
                <br>
                @foreach ($courses as $course)
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="{{ $course->id }}" id="course{{ $course->id }}" name="courses[]"
                            {{ in_array($course->id, $student->courses->pluck('id')->toArray()) ? 'checked' : '' }}>
                        <label class="form-check-label" for="course{{ $course->id }}">
                            {{ $course->name }}
                        </label>
                    </div>
                @endforeach
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
@endsection
