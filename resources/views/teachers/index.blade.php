@extends('layout')

@section('content')
    <div class="container mt-5">
        <h2>Teachers</h2>
        <a href="{{ route('teachers.create') }}" class="btn btn-primary mb-3">Create Teacher</a>
        <table class="table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($teachers as $teacher)
                <tr>
                    <td>{{ $teacher->id }}</td>
                    <td>{{ $teacher->name }}</td>
                    <td>
                        <a href="{{ route('teachers.show', $teacher) }}" class="btn btn-primary btn-sm">View</a>
                        <a href="{{ route('teachers.edit', $teacher) }}" class="btn btn-secondary btn-sm">Edit</a>
                        <form action="{{ route('teachers.destroy', $teacher) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this teacher?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
