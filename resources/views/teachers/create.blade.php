@extends('layout')

@section('content')
    <div class="container mt-5">
        <h2>Create Teacher</h2>
        <form method="POST" action="{{ route('teachers.store') }}">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">Teacher Name:</label>
                <input type="text" class="form-control" id="name" name="name">
            </div>

            <button type="submit" class="btn btn-primary">Create Teacher</button>
        </form>
    </div>
@endsection
