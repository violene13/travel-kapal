<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login | Sealine</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <style>
    body {
      margin: 0;
      padding: 0;
      height: 100vh;
      background: linear-gradient(135deg, #0099cc, #003b5c);
      display: flex;
      justify-content: center;
      align-items: center;
      font-family: 'Poppins', sans-serif;
      color: #fff;
    }

    .login-box {
      background: rgba(255, 255, 255, 0.15);
      backdrop-filter: blur(10px);
      border-radius: 16px;
      padding: 40px 35px;
      width: 400px;
      box-shadow: 0 8px 25px rgba(0,0,0,0.2);
      animation: fadeIn 0.7s ease-in-out;
    }

    .login-box h2 {
      text-align: center;
      font-weight: 700;
      margin-bottom: 25px;
      color: #ffffff;
    }

    .form-control {
      background: rgba(255,255,255,0.2);
      border: none;
      color: #fff;
      height: 48px;
      border-radius: 10px;
      padding-left: 40px;
    }

    .form-control::placeholder {
      color: rgba(255,255,255,0.8);
    }

    .input-group-text {
      position: absolute;
      top: 12px;
      left: 12px;
      background: transparent;
      border: none;
      color: #00d4ff;
      font-size: 1.1rem;
    }

    .btn-login {
      background: linear-gradient(45deg, #00c6ff, #0072ff);
      border: none;
      width: 100%;
      height: 48px;
      border-radius: 10px;
      font-weight: 600;
      transition: 0.3s;
    }

    .btn-login:hover {
      transform: translateY(-2px);
      background: linear-gradient(45deg, #00e4ff, #0055cc);
      box-shadow: 0 5px 15px rgba(0,200,255,0.3);
    }

    .text-small {
      text-align: center;
      margin-top: 15px;
      font-size: 0.9rem;
      color: rgba(255,255,255,0.8);
    }

    .text-small a {
      color: #00d4ff;
      text-decoration: none;
      font-weight: 500;
    }

    .text-small a:hover {
      text-decoration: underline;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(-15px); }
      to { opacity: 1; transform: translateY(0); }
    }
  </style>
</head>

<body>
  <div class="login-box">
    <h2><i class="fa-solid fa-ship me-2"></i> Login Sealine</h2>

    {{-- Pesan Error --}}
    @if($errors->has('login_error'))
      <div class="alert alert-danger text-center py-2">{{ $errors->first('login_error') }}</div>
    @endif
    @if(session('success'))
      <div class="alert alert-success text-center py-2">{{ session('success') }}</div>
    @endif

    <form action="{{ route('login') }}" method="POST">
      @csrf
      <div class="mb-3 position-relative">
        <span class="input-group-text"><i class="fa fa-user"></i></span>
        <input type="text" name="username" class="form-control" placeholder="Masukkan Username atau Email" required>
      </div>

      <div class="mb-3 position-relative">
        <span class="input-group-text"><i class="fa fa-lock"></i></span>
        <input type="password" name="password" class="form-control" placeholder="Masukkan Password" required>
      </div>

      <button type="submit" class="btn btn-login mt-2">
        <i class="fa fa-sign-in-alt me-2"></i> Masuk
      </button>

      <div class="text-small mt-3">
        Belum punya akun? <a href="{{ route('register') }}">Daftar di sini</a>
      </div>
    </form>
  </div>
</body>
</html>
