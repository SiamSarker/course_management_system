@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Students</h1>

        <a href="{{ route('students.create') }}" class="btn btn-primary mb-3">Add New Student</a>

        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Enrolled Courses</th>
                <th>Rank</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($students as $student)
                <tr>
                    <td>{{ $student->name }}</td>
                    <td>{{ $student->email }}</td>
                    <td>
                        <ul>
                            @foreach ($student->courses as $course)
                                <li>{{ $course->name }}</li>
                            @endforeach
                        </ul>
                    </td>
                    <td>
                        <input type="number" name="rank" value="{{ optional($student->student)->rank }}" class="form-control rank-input" data-student-id="{{ $student->student->id }}" />
                    </td>
                    <td>
                        <a href="{{ route('students.show', $student->id) }}" class="btn btn-info">View</a>
                        <a href="{{ route('students.edit', $student->id) }}" class="btn btn-primary">Edit</a>
                        <form action="{{ route('students.destroy', $student->id) }}" method="POST" style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection

@section('scripts')
    <script>
        $('.rank-input').on('change', function () {
            var rank = $(this).val();
            var studentId = $(this).data('student-id');

            console.log(rank, studentId);

            $.ajax({
                url: "/students/" + studentId + "/update-rank",
                method: 'PUT',
                data: {
                    rank: rank,
                    _token: "{{ csrf_token() }}"
                },
                success: function (response) {
                    // Handle success response if needed
                    console.log("success");
                    location.reload();
                },
                error: function (xhr, status, error) {
                    // Handle error response if needed
                    console.log("Error and error");
                }
            });
        });
    </script>
@endsection
