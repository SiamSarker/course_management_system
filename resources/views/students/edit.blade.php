@extends('layout')

@section('content')
    <div class="container mt-5">
        <h2>Edit Student</h2>
        <form method="POST" action="{{ route('students.update', $student) }}">
            @csrf
            @method('PATCH')

            <div class="mb-3">
                <label for="name" class="form-label">Student Name:</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $student->name }}">
            </div>

            <button type="submit" class="btn btn-primary">Update Student</button>
        </form>
    </div>
@endsection
