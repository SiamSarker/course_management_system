@extends('layouts.app')

@section('content')
    <h1>Account Activation</h1>
    <p>Hello {{ $user->name }},</p>
    <p>Please click the button below to activate your account:</p>
    <form action="{{ route('students.updateActivation', ['user' => $user->id]) }}" method="POST">
    @csrf
        @method('PUT')
        <button type="submit">Activate Account</button>
    </form>
@endsection
