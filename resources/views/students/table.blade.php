@php
    $sortedStudents = $students->sortBy(function ($student) {
        return optional($student->student)->rank;
    });
@endphp

@foreach ($sortedStudents as $student)
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
