@extends('layout')

@section('content')
    <div class="container mt-5">
        <h2>Create Student</h2>
        <form method="POST" action="{{ route('students.store') }}">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">Student Name:</label>
                <input type="text" class="form-control" id="name" name="name">
            </div>

            <button type="submit" class="btn btn-primary">Create Student</button>
        </form>
    </div>
@endsection
