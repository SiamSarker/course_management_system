@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Create Student</h1>

        @if ($errors->any())
            <div class="alert alert-danger">

                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach

            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('students.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" class="form-control" required>
                <span id="email-exists" class="text-danger" style="display: none;">The email already exists.</span>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="courses">Courses</label>
                @foreach ($courses as $course)
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="courses[]" value="{{ $course->id }}">
                        <label class="form-check-label" for="course{{ $course->id }}">
                            {{ $course->name }}
                        </label>
                    </div>
                @endforeach
            </div>
            <button type="submit" class="btn btn-primary">Create</button>
        </form>
    </div>
@endsection
