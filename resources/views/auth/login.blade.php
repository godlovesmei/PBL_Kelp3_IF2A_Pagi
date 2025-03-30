<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log in to the site | Venus Cars</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&amp;display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/login.css') }}" />
</head>

<body>
    <div class="form-container">
        <h1><img src="{{ asset('/images/venuscars1.png') }}" alt="Venus Cars Logo"></h1>
        <p>Login to see your dream car!</p>

        <!-- Form login -->
        <form method="POST" action="{{ route('login') }}" autocomplete="off">
            @csrf
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>

        @if (session('error'))
            <div class="error-message">{{ session('error') }}</div>
        @endif

        <br>
        <p>New here? <a href="{{ route('register') }}">Create an account</a></p>
    </div>
    <script src="{{ asset('js/login.js') }}"></script>
</body>

</html>
