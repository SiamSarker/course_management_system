@extends('layout')

@section('content')
    <div class="container mt-5">
        <h2>Edit Teacher</h2>
        <form method="POST" action="{{ route('teachers.update', $teacher) }}">
            @csrf
            @method('PATCH')

            <div class="mb-3">
                <label for="name" class="form-label">Teacher Name:</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $teacher->name }}">
            </div>

            <button type="submit" class="btn btn-primary">Update Teacher</button>
        </form>
    </div>
@endsection
