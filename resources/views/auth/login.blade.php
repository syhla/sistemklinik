<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login Resepsionis</title>

  <style>
    :root {
      --tosca: #20B2AA;      
      --tosca-dark: #18908a; 
      --white: #ffffff;
      --gray: #f0fdfa;      
      --text: #1f2937;     
    }

    * { box-sizing: border-box; }
    body {
      margin: 0;
      font-family: "Poppins", system-ui, sans-serif;
      background: linear-gradient(135deg, #d2f4f2 0%, #f8ffff 100%);
      color: var(--text);
      display: grid;
      place-items: center;
      height: 100vh;
      overflow: hidden;
    }

    /* bubble background */
    .bubble {
      position: absolute;
      border-radius: 999px;
      filter: blur(80px);
      opacity: 0.25;
      animation: float 12s ease-in-out infinite;
      z-index: 0;
    }
    .b1 { width: 280px; height: 280px; background: var(--tosca); top: -70px; right: -40px; }
    .b2 { width: 200px; height: 200px; background: #9be7e2; bottom: -60px; left: -50px; animation-delay: 1.2s; }
    .b3 { width: 160px; height: 160px; background: #c8fffa; top: 35%; left: -60px; animation-delay: 0.6s; }

    @keyframes float {
      0%, 100% { transform: translateY(0) translateX(0) scale(1); }
      50%      { transform: translateY(-16px) translateX(8px) scale(1.04); }
    }

    /* card (glass effect) */
    .card {
      position: relative;
      z-index: 1;
      width: 100%;
      max-width: 420px;
      padding: 32px 28px;
      border-radius: 24px;
      backdrop-filter: blur(16px) saturate(180%);
      background: rgba(255, 255, 255, 0.72);
      border: 1px solid rgba(255, 255, 255, 0.35);
      box-shadow: 0 10px 30px rgba(32,178,170,0.15),
                  0 6px 18px rgba(0,0,0,0.06);
      animation: fadeIn 650ms ease-out forwards;
    }
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(16px); }
      to   { opacity: 1; transform: translateY(0); }
    }

    /* header */
    .logo {
      width: 60px; height: 60px;
      border-radius: 16px;
      background: var(--tosca);
      display: grid; place-items: center;
      color: var(--white);
      font-weight: 800;
      font-size: 20px;
      box-shadow: 0 6px 16px rgba(32,178,170,.35);
    }

    h1 { margin: 14px 0 6px; font-size: 24px; color: var(--tosca-dark); }
    p.subtitle { margin: 0 0 22px; color: #6b7280; font-size: 14px; }

    /* form */
    .form-group { margin-bottom: 18px; position: relative; }
    label { display: block; font-size: 13px; margin-bottom: 6px; color: #374151; }
    .input {
      width: 100%;
      padding: 12px 14px 12px 40px;
      border-radius: 14px;
      border: 1.5px solid #e5e7eb;
      background: #ffffffd9;
      outline: none;
      font-size: 14px;
      transition: border-color .2s, box-shadow .2s;
    }
    .input:focus {
      border-color: var(--tosca);
      box-shadow: 0 0 0 4px rgba(32,178,170,.15);
    }

    /* icon in input */
    .form-group i {
      position: absolute;
      top: 38px;
      left: 12px;
      font-size: 15px;
      color: #9ca3af;
    }

    .btn {
      width: 100%;
      padding: 12px 14px;
      border: none;
      border-radius: 14px;
      background: var(--tosca);
      color: var(--white);
      font-weight: 600;
      font-size: 15px;
      cursor: pointer;
      box-shadow: 0 8px 18px rgba(32,178,170,.35);
      transition: background .2s, transform .15s;
    }
    .btn:hover { background: var(--tosca-dark); transform: translateY(-1px); }
    .btn:active { transform: translateY(1px); }

    .footer { margin-top: 14px; font-size: 12px; color: #6b7280; text-align: center; }

    /* alert */
    .alert { padding: 10px 12px; border-radius: 12px; margin-bottom: 12px; font-size: 13px; }
    .alert-error { background: #fee2e2; color: #991b1b; border: 1px solid #fecaca; }
    .alert-success { background: #dcfce7; color: #166534; border: 1px solid #bbf7d0; }
  </style>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
</head>
<body>
  <div class="bubble b1"></div>
  <div class="bubble b2"></div>
  <div class="bubble b3"></div>

  <main class="card">
    <div style="display:grid;grid-template-columns:60px 1fr;align-items:center;gap:12px;">
      <div class="logo">K+</div>
      <div>
        <h1>Login</h1>
        <p class="subtitle">Klinik Perusahaan • Silakan masuk untuk melanjutkan</p>
      </div>
    </div>

    {{-- pesan sukses --}}
    @if(session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- pesan error --}}
    @if($errors->any())
      <div class="alert alert-error">{{ $errors->first() }}</div>
    @endif

    {{-- form login --}}
    <form method="POST" action="{{ route('login') }}" autocomplete="on">
      @csrf

      <div class="form-group">
        <label for="email">Email</label>
        <i class="fa-solid fa-envelope"></i>
        <input id="email" type="email" name="email" class="input"
               placeholder="masukkan email" value="{{ old('email') }}" required autofocus />
      </div>

      <div class="form-group">
        <label for="password">Kata Sandi</label>
        <i class="fa-solid fa-lock"></i>
        <input id="password" type="password" name="password" class="input"
               placeholder="••••••••" required />
      </div>

      <button type="submit" class="btn">Masuk</button>
      <div class="footer">© Klinik Perusahaan</div>
    </form>
  </main>
</body>
</html>
