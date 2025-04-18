<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Reset Password - {{ ucfirst($role) }}</title>
</head>
<body>
    <h2>Reset Password ({{ ucfirst($role) }})</h2>

    <form method="POST" action="{{ $role === 'dealer' ? route('dealer.password.update') : route('customer.password.update') }}">
        @csrf

        <input type="hidden" name="token" value="{{ $token }}">
        <input type="hidden" name="email" value="{{ $email }}">

        <input type="password" name="password" placeholder="New Password" required>
        <input type="password" name="password_confirmation" placeholder="Confirm New Password" required>

        @error('password')
            <p style="color:red">{{ $message }}</p>
        @enderror

        <button type="submit">Reset Password</button>
    </form>

    <p><a href="{{ $role === 'dealer' ? route('dealer.login') : route('customer.login') }}">← Back to Login</a></p>
</body>
</html>
