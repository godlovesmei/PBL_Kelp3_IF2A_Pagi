<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Lupa Password - {{ ucfirst($role) }}</title>
</head>
<body>
    <h2>Forgot Password ({{ ucfirst($role) }})</h2>

    @if (session('status'))
        <p style="color:green">{{ session('status') }}</p>
    @else
        <p style="color:gray">Belum ada status / session status tidak muncul</p>
    @endif

    <form method="POST" action="{{ $role === 'dealer' ? route('dealer.password.email') : route('customer.password.email') }}">
        @csrf
        <input type="email" name="email" placeholder="Enter your email" required>
        @error('email')
            <p style="color:red">{{ $message }}</p>
        @enderror
        <button type="submit">Kirim Link Reset</button>
    </form>

    <p><a href="{{ $role === 'dealer' ? route('dealer.login') : route('customer.login') }}">← Back to Login</a></p>
</body>
</html>