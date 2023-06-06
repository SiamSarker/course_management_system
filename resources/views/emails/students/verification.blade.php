<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Student Verification</title>
</head>
<body>
    <h1>Student Verification</h1>
    <p>Hello {{ $user->name }},</p>
    <p>Please click the button below to verify your student account:</p>
    <a href="{{ route('students.verify', ['token' => $user->verification_token]) }}">Verify Account</a>
    <p>Thanks,</p>
    <p>Siam Sarker</p>
</body>
</html>
