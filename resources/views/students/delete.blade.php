@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Delete Student</h1>
        <p>Are you sure you want to delete the student: {{ $user->name }}?</p>
        <form action="{{ route('students.destroy', $user->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Delete</button>
            <a href="{{ route('students.index') }}" class="btn btn-primary">Cancel</a>
        </form>
    </div>
@endsection
