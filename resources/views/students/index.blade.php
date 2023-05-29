@extends('layout')

@section('content')
    <div class="container mt-5">
        <h2>Students</h2>
        <a href="{{ route('students.create') }}" class="btn btn-primary mb-3">Create Student</a>
        <table class="table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($students as $student)
                <tr>
                    <td>{{ $student->id }}</td>
                    <td>{{ $student->name }}</td>
                    <td>
                        <a href="{{ route('students.show', $student) }}" class="btn btn-primary btn-sm">View</a>
                        <a href="{{ route('students.edit', $student) }}" class="btn btn-secondary btn-sm">Edit</a>
                        <form action="{{ route('students.destroy', $student) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this student?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
