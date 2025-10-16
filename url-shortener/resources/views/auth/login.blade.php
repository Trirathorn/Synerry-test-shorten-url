<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - URL Shortener</title>
    <style>
        body { font-family: Inter, system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial, sans-serif; margin: 0; padding: 24px; background: #f9fafb; }
        .container { max-width: 400px; margin: 60px auto; }
        .card { background: white; border: 1px solid #e5e7eb; border-radius: 8px; padding: 32px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
        h1 { text-align: center; margin-bottom: 24px; color: #111827; }
        input[type=text], input[type=password] { width: 100%; padding: 12px; border: 1px solid #d1d5db; border-radius: 6px; margin-bottom: 16px; }
        button { width: 100%; background: #ef4444; color: white; border: 0; padding: 12px; border-radius: 6px; cursor: pointer; font-size: 16px; }
        button:hover { background: #dc2626; }
        .error { color: #dc2626; font-size: 14px; margin-bottom: 16px; }
        .link { text-align: center; margin-top: 16px; }
        .link a { color: #2563eb; text-decoration: none; }
        .checkbox { display: flex; align-items: center; margin-bottom: 16px; }
        .checkbox input { width: auto; margin-right: 8px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <h1>Login</h1>
            
            @if ($errors->any())
                <div class="error">
                    @foreach ($errors->all() as $error)
                        {{ $error }}
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <input type="text" name="username" placeholder="Username" value="{{ old('username') }}" required>
                <input type="password" name="password" placeholder="Password" required>
                
                <div class="checkbox">
                    <input type="checkbox" name="remember" id="remember">
                    <label for="remember">Remember me</label>
                </div>
                
                <button type="submit">Login</button>
            </form>
            
            <div class="link">
                <a href="{{ route('register') }}">Don't have an account? Register</a>
            </div>
            <div class="link">
                <a href="{{ route('home') }}">← Back to Home</a>
            </div>
        </div>
    </div>
</body>
</html>
