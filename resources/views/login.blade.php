<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CAMPLORE – Masuk</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;600;700&family=Jost:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

        :root {
            --green:       #22543D;
            --green-mid:   #2d6b50;
            --green-light: #38856a;
            --pink:        #ED64A6;
            --pink-dark:   #d4528f;
            --gray-bg:     #f7f7f5;
            --border:      #e2e2de;
            --text:        #1a1a18;
            --text-sub:    #999990;
        }

        html, body {
            height: 100%;
            font-family: 'Jost', sans-serif;
            background: #fff;
            color: var(--text);
        }

        /* NAVBAR */
        .navbar {
            position: fixed; top: 0; left: 0; right: 0;
            height: 58px;
            display: flex; align-items: center; justify-content: center;
            border-bottom: 1px solid var(--border);
            background: #fff; z-index: 100;
        }

        .nav-logo {
            font-family: 'Cormorant Garamond', serif;
            font-size: 21px; font-weight: 700;
            letter-spacing: 6px; text-transform: uppercase;
            color: var(--green); text-decoration: none;
        }

        .nav-logo img {
            height: 200px;
            width: auto;
            display: block;
        }

        /* PAGE */
        .page {
            min-height: 100vh;
            display: flex; align-items: center; justify-content: center;
            padding: 90px 20px 60px;
        }

        .card { width: 100%; max-width: 380px; }

        .card-title {
            font-family: 'Cormorant Garamond', serif;
            font-size: 26px; font-weight: 600;
            letter-spacing: 3px; text-transform: uppercase;
            color: var(--green); text-align: center;
            margin-bottom: 30px;
        }

        /* INPUTS */
        .field { margin-bottom: 12px; }

        .field input {
            width: 100%; padding: 13px 16px;
            border: 1px solid var(--border); border-radius: 3px;
            font-family: 'Jost', sans-serif;
            font-size: 14px; font-weight: 300;
            color: var(--text); background: var(--gray-bg);
            outline: none; transition: border-color 0.2s, background 0.2s;
            letter-spacing: 0.3px;
        }

        .field input::placeholder { color: #bebebA; }

        .field input:focus {
            border-color: var(--green-light); background: #fff;
        }

        .pw-wrap { position: relative; }
        .pw-wrap input { padding-right: 42px; }

        .pw-btn {
            position: absolute; right: 12px; top: 50%;
            transform: translateY(-50%);
            background: none; border: none; cursor: pointer;
            color: #ccc; display: flex; padding: 0;
            transition: color 0.2s;
        }
        .pw-btn:hover { color: var(--green-mid); }

        /* SUBMIT */
        .btn-login {
            width: 100%; padding: 14px; margin-top: 6px;
            background: var(--green); color: #fff;
            border: none; border-radius: 3px;
            font-family: 'Jost', sans-serif;
            font-size: 12px; font-weight: 500;
            letter-spacing: 3px; text-transform: uppercase;
            cursor: pointer; transition: background 0.2s;
        }
        .btn-login:hover { background: var(--green-mid); }

        /* FORGOT */
        .forgot-row { text-align: center; margin-top: 16px; }
        .forgot-row a {
            font-size: 12px; font-weight: 300;
            color: var(--text-sub); text-decoration: underline;
            text-underline-offset: 3px; transition: color 0.2s;
        }
        .forgot-row a:hover { color: var(--green); }

        /* DIVIDER */
        .divider {
            display: flex; align-items: center; gap: 14px;
            margin: 26px 0;
        }
        .divider-line { flex: 1; height: 1px; background: var(--border); }
        .divider span { font-size: 11px; color: #d0d0cc; letter-spacing: 1.5px; text-transform: uppercase; }

        /* REGISTER */
        .register-note {
            text-align: center; font-size: 12px;
            font-weight: 300; color: var(--text-sub);
            margin-bottom: 10px; letter-spacing: 0.2px;
        }

        .btn-register {
            display: block; width: 100%; padding: 13px;
            background: transparent;
            border: 1.5px solid var(--pink);
            border-radius: 3px;
            font-family: 'Jost', sans-serif;
            font-size: 12px; font-weight: 500;
            letter-spacing: 3px; text-transform: uppercase;
            color: var(--pink); text-align: center;
            text-decoration: none;
            transition: background 0.2s, color 0.2s;
        }
        .btn-register:hover { background: var(--pink); color: #fff; }

        /* FOOTER BAR */
        .footer-bar {
            position: fixed; bottom: 0; left: 0; right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--green) 65%, var(--pink) 100%);
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

        <h1 class="card-title">Masuk</h1>

        <form action="/login" method="POST">
            @csrf

            <div class="field">
                <input type="text" name="username" id="username"
                    placeholder="Username"
                    value="{{ old('username') }}"
                    autocomplete="username">
            </div>

            <div class="field">
                <div class="pw-wrap">
                    <input type="password" name="password" id="password"
                        placeholder="Kata sandi"
                        autocomplete="current-password">
                    <button type="button" class="pw-btn" onclick="togglePw('password', this)">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                            <circle cx="12" cy="12" r="3"/>
                        </svg>
                    </button>
                </div>
            </div>

            <button type="submit" class="btn-login">Masuk</button>
        </form>

        <div class="forgot-row">
            <a href="#">Lupa kata sandi?</a>
        </div>

        <div class="divider">
            <div class="divider-line"></div>
            <span>atau</span>
            <div class="divider-line"></div>
        </div>

        <p class="register-note">Belum punya akun?</p>
        <a href="/registrasi" class="btn-register">Daftar Sekarang</a>

    </div>
</div>

<div class="footer-bar"></div>

<script>
function togglePw(id, btn) {
    const el = document.getElementById(id);
    const show = el.type === 'password';
    el.type = show ? 'text' : 'password';
    btn.innerHTML = show
        ? `<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></svg>`
        : `<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>`;
}
</script>
</body>
</html>