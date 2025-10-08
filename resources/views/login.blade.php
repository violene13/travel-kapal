<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Sistem</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #003B5C, #007B9E);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .login-card {
            max-width: 420px;
            width: 100%;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.25);
            background: #fff;
            padding: 2rem;
            animation: fadeIn 0.6s ease-in-out;
        }
        .login-card h2 {
            font-weight: 700;
            color: #003B5C;
        }
        .btn-custom {
            background-color: #003B5C;
            border: none;
            transition: 0.3s;
        }
        .btn-custom:hover {
            background-color: #005580;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
    <div class="login-card">
        <h2 class="text-center mb-4">Login Admin</h2>
        <form action="{{ route('login.submit') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" name="username" class="form-control" required placeholder="Masukkan username">
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required placeholder="Masukkan password">
            </div>
            @error('login_error')
                <div class="alert alert-danger py-2">{{ $message }}</div>
            @enderror
            <button type="submit" class="btn btn-custom w-100 text-white">Login</button>
        </form>
    </div>
</body>
</html>
