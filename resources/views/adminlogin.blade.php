<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="{{secure_asset('css/styles_login.css')}}">
</head>
<body>
    <div class="login-container">

        <div class="logo">
                <img src="https://res.cloudinary.com/hqvikuhvf/image/upload/v1717955085/login%20icon/vavtm7kkv5no0lt9lv0f.png" alt="Laravel Logo">
            </div>

        <div class="login-box">

            <form id="loginForm" action="{{ route('login') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required>
                   <ul class="error-messages">
                        @foreach ($errors->all() as $error)
                         {{ $error }}
                            @endforeach
                    </ul>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <div class="form-group remember-me">
                    <input type="checkbox" id="remember" name="remember">
                    <label for="remember">Remember me</label>
                </div>
                <div class="form-group">
                    <button type="submit" class="login-button">LOG IN</button>
                </div>
            </form>
        </div>
    </div>
    <script src="{{secure_asset('js/scripts_login.js')}}"></script>
</body>
</html>
