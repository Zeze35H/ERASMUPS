
<html>
<head>
    <meta charset="utf-8">
</head>

<body>
    <main id="recovery_email">
        <div>

            <h1>ERASMUPS</h1>
            <p></p>
            <h2>Password Recovery</h2><br>
            <p>Forgot your password? No problem, just reset it.</p>
            Your unique password reset token is: {{$token}}
            <a class="navbar-brand px-1" href={{ url('/login/reset/submit?token=' . $token) }}>
                <p>Or just click here link to reset your password</p>
            </a>
            <p></p>
            <p>If you didn't request this don't worry, just ignore this email.</p>
        </div>
    </main>
</body>
</html>

