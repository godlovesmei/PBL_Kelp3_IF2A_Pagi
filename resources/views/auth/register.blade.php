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
        @if ($role === 'customer')
    <p>Sign up now & find your dream car!</p> 
    @endif
                <p style="display: none;">Register as a {{ ucfirst($role) }}</p>

        
                <form action="{{ $role === 'customer' ? route('customer.register.process') : route('dealer.register.process') }}" method="POST">
                    @csrf
                    <div>
                        <input type="email" name="email" placeholder="Email" required>
                    </div>
                    <div>
                        <input type="text" name="name" placeholder="Name" required>
                    </div>
                    <div>
                        <input type="password" name="password" placeholder="Password" required>
                    </div>
                    <div>
                        <input type="password" name="password_confirmation" placeholder="Confirm Password" required>
                    </div>
        
                    <button type="submit">Sign Up</button>
                </form>
        

        <div class="success-message" id="successMessage" style="display: none;">Welcome to VenusCars</div>
        <br>
        <br>
        <p>Have an account? 
            <a href="{{ $role == 'dealer' ? route('dealer.login') : route('customer.login') }}">Log in</a>
        </p>               
    </div>
</body>
</html>
