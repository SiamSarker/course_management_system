@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Error</h1>
        <p>An error occurred while retrieving the students: {{ $error }}</p>
    </div>
@endsection
