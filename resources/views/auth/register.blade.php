<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&amp;display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/regist.css') }}">
    <title>Sign Up | VenusCars</title>
</head>

<body>
    <div class="form-container">
        <h1><img src="{{ asset('/images/venuscars1.png') }}" alt="Venus Cars Logo"></h1>
       <p>Sign up now & find your dream car!</p>

        <form id="signupForm" action="{{ route('register') }}" method="POST">
            @csrf
            <div>
                <input type="email" id="email" name="email" placeholder="Email" required>
                <div class="error-message" id="emailError" style="display: none;">Please enter a valid email</div>
            </div>
            <div>
                <input type="text" id="name" name="name" placeholder="Name" required>
                <div class="error-message" id="nameError" style="display: none;">Please enter your name</div>
            </div>
            <div>
                <input type="text" id="username" name="username" placeholder="Username" required>
                <div class="error-message" id="usernameError" style="display: none;">Please enter a username</div>
            </div>
            <div>
                <input type="password" id="password" name="password" placeholder="Password" required>
                <div class="error-message" id="passwordError" style="display: none;">Please enter a password of at least 6 characters</div>
            </div>
            <br>
            <button type="submit">Sign Up</button>
        </form>

        <div class="success-message" id="successMessage" style="display: none;">Welcome to PUREBEAUTY!</div>
        <br>
        <p>Have an account? <a href="{{ route('login') }}">Log in</a></p>
    </div>
</body>
</html>
