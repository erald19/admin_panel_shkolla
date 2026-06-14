<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Shkolla Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', sans-serif; background: #1e1b4b; display: flex;
               align-items: center; justify-content: center; min-height: 100vh; }
        .card { background: #fff; border-radius: 20px; padding: 40px; width: 100%; max-width: 380px; }
        h2 { font-size: 22px; font-weight: 700; color: #1e293b; margin-bottom: 4px; }
        p  { color: #94a3b8; font-size: 14px; margin-bottom: 28px; }
        .form-group { margin-bottom: 16px; }
        label { display: block; font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 6px; }
        input {
            width: 100%; border: 1px solid #e2e8f0; border-radius: 8px;
            padding: 11px 14px; font-size: 14px; font-family: inherit;
            color: #1e293b; background: #f8fafc; outline: none;
        }
        input:focus { border-color: #4f46e5; background: #fff; }
        .btn {
            width: 100%; background: #4f46e5; color: #fff; border: none;
            border-radius: 8px; padding: 13px; font-size: 15px; font-weight: 600;
            cursor: pointer; margin-top: 6px; font-family: inherit;
        }
        .btn:hover { background: #4338ca; }
        .alert { background: #fef2f2; color: #991b1b; border: 1px solid #fecaca;
                 border-radius: 8px; padding: 12px 14px; font-size: 13px; margin-bottom: 16px; }
    </style>
</head>
<body>
<div class="card">
    <h2>Shkolla Admin</h2>
    <p>Sign in to manage your school</p>

    @if($errors->any())
        <div class="alert">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('admin.login') }}">
        @csrf
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required autofocus>
        </div>
        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" required>
        </div>
        <button type="submit" class="btn">Sign In</button>
    </form>
</div>
</body>
</html>
