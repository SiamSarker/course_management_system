@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>View Student</h1>
        <p><strong>Name:</strong> {{ $user->name }}</p>
        <p><strong>Email:</strong> {{ $user->email }}</p>
        <p><strong>Enrolled Courses:</strong></p>
        <ul>
            @foreach ($user->courses as $course)
                <li>{{ $course->name }}</li>
            @endforeach
        </ul>
        <a href="{{ route('students.index') }}" class="btn btn-primary">Back</a>
    </div>
@endsection
