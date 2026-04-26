<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CAMPLORE – Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;600;700&family=Jost:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }
        :root {
            --green: #22543D; --green-mid: #2d6b50; --green-light: #38856a;
            --gray-bg: #f7f7f5; --border: #e2e2de;
            --text: #1a1a18; --text-sub: #999990;
        }
        html, body { height: 100%; font-family: 'Jost', sans-serif; background: #fff; color: var(--text); }
        .navbar {
            position: fixed; top: 0; left: 0; right: 0; height: 58px;
            display: flex; align-items: center; justify-content: center;
            border-bottom: 1px solid var(--border); background: #fff; z-index: 100;
        }
        .nav-logo img { height: 50px; width: auto; display: block; }
        .page {
            min-height: 100vh; display: flex; align-items: center; justify-content: center;
            padding: 90px 20px 60px;
        }
        .card { width: 100%; max-width: 380px; }
        .card-title {
            font-family: 'Cormorant Garamond', serif;
            font-size: 26px; font-weight: 600;
            letter-spacing: 3px; text-transform: uppercase;
            color: var(--green); text-align: center; margin-bottom: 6px;
        }
        .card-subtitle {
            text-align: center; font-size: 11px; font-weight: 300;
            color: var(--text-sub); letter-spacing: 2px; text-transform: uppercase;
            margin-bottom: 28px;
        }
        .field { margin-bottom: 12px; }
        .field input {
            width: 100%; padding: 13px 16px;
            border: 1px solid var(--border); border-radius: 3px;
            font-family: 'Jost', sans-serif; font-size: 14px; font-weight: 300;
            color: var(--text); background: var(--gray-bg);
            outline: none; transition: border-color 0.2s, background 0.2s;
        }
        .field input::placeholder { color: #bebebA; }
        .field input:focus { border-color: var(--green-light); background: #fff; }
        .pw-wrap { position: relative; }
        .pw-wrap input { padding-right: 42px; }
        .pw-btn {
            position: absolute; right: 12px; top: 50%; transform: translateY(-50%);
            background: none; border: none; cursor: pointer; color: #ccc; display: flex; padding: 0;
        }
        .btn-login {
            width: 100%; padding: 14px; margin-top: 6px;
            background: var(--green); color: #fff;
            border: none; border-radius: 3px;
            font-family: 'Jost', sans-serif; font-size: 12px; font-weight: 500;
            letter-spacing: 3px; text-transform: uppercase;
            cursor: pointer; transition: background 0.2s;
        }
        .btn-login:hover { background: var(--green-mid); }
        .alert-error {
            background: #fff5f5; color: #c53030; border: 1px solid #fed7d7;
            border-radius: 3px; padding: 10px 14px; font-size: 13px;
            margin-bottom: 14px; text-align: center;
        }
        .footer-bar {
            position: fixed; bottom: 0; left: 0; right: 0; height: 3px;
            background: linear-gradient(90deg, var(--green) 65%, #ED64A6 100%);
        }
    </style>
</head>
<body>

<nav class="navbar">
    <a href="/" class="nav-logo">
        <img src="{{ asset('images/Black_Summer_Camp_Adventure_Logo-removebg-preview.png') }}" alt="Camplore Logo">
    </a>
</nav>

<div class="page">
    <div class="card">

        <h1 class="card-title">Admin</h1>
        <p class="card-subtitle">Panel Pengelola</p>

        @if($errors->any())
            <div class="alert-error">{{ $errors->first() }}</div>
        @endif

        <form action="{{ route('admin.login.post') }}" method="POST">
            @csrf
            <div class="field">
                <input type="text" name="username" placeholder="Username"
                    value="{{ old('username') }}" required>
            </div>
            <div class="field">
                <div class="pw-wrap">
                    <input type="password" name="password" id="password"
                        placeholder="Kata sandi" required>
                    <button type="button" class="pw-btn" onclick="togglePw()">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                            <circle cx="12" cy="12" r="3"/>
                        </svg>
                    </button>
                </div>
            </div>
            <button type="submit" class="btn-login">Masuk</button>
        </form>

    </div>
</div>

<div class="footer-bar"></div>

<script>
function togglePw() {
    const el = document.getElementById('password');
    el.type = el.type === 'password' ? 'text' : 'password';
}
</script>
</body>
</html>