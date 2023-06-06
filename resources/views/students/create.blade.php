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

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form id="create-student-form" action="{{ route('students.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email-input" class="form-control" required>
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

@section('scripts')
    <script>

        console.log("jQuery is working");

        $('#email-input').on('input', function() {

            var email = $(this).val();

            $.ajax({
                url: "{{ route('checkEmail') }}",
                method: 'POST',
                data: {
                    email: email,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    if (response.exists) {
                        $('#email-exists').show();
                        $('#email-input').addClass('is-invalid');
                    } else {
                        $('#email-exists').hide();
                        $('#email-input').removeClass('is-invalid');
                    }
                }
            });
        });

        $('#create-student-form').on('submit', function(e) {
            if ($('#email-input').hasClass('is-invalid')) {
                e.preventDefault();
                alert('Please fix the validation errors.');
                return false;
            }
        });
    </script>
@endsection
