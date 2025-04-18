<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Venus Cars</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&amp;display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/login.css') }}" />
</head>

<body>
    <div class="form-container">
        <h1><img src="{{ asset('/images/venuscars1.png') }}" alt="Venus Cars Logo"></h1>
        @if ($role === 'customer')
    <p>Login to find your dream car!</p>
@endif

        <!-- Form login -->
        <form method="POST" action="{{ $role == 'dealer' ? route('dealer.login.process') : route('customer.login.process') }}" autocomplete="off">
            @csrf
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
        <br>
        <br>
        <div class="forgot-password">
            <a href="{{ $role == 'dealer' ? route('dealer.password.request') : route('customer.password.request') }}">
                Lost password?
            </a>
        </div>      
        <!-- Separator -->
<div class="separator">Or</div>
  

        @if (session('error'))
            <div class="error-message">{{ session('error') }}</div>
        @endif

        <p>New here? <a href="{{ $role == 'dealer' ? route('dealer.register') : route('customer.register') }}">Create an account</a></p>
    </div>
    <script src="{{ asset('js/login.js') }}"></script>
</body>

</html>
