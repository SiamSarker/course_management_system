@extends('layout')

@section('content')
    <div class="container mt-5">
        <h2>{{ $student->name }}</h2>
        <a href="{{ route('students.edit', $student) }}" class="btn btn-secondary">Edit</a>
        <form action="{{ route('students.destroy', $student) }}" method="POST" class="d-inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this student?')">Delete</button>
        </form>
    </div>
@endsection
