<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Welcome</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    @keyframes fadeInUp {
      from { opacity: 0; transform: translateY(40px); }
      to { opacity: 1; transform: translateY(0); }
    }
    .fade-in-up { animation: fadeInUp 1s ease-out forwards; }

    @keyframes pulse {
      0%, 100% { transform: scale(1); }
      50% { transform: scale(1.05); }
    }
    .btn-animate:hover { animation: pulse 0.6s ease-in-out; }

    .bubble {
      position: absolute;
      border-radius: 999px;
      filter: blur(80px);
      opacity: 0.25;
      animation: float 12s ease-in-out infinite;
      z-index: 0;
    }
    .b1 { width: 260px; height: 260px; background: #20B2AA; top: -80px; right: -60px; }
    .b2 { width: 200px; height: 200px; background: #9be7e2; bottom: -70px; left: -50px; animation-delay: 1.2s; }
    .b3 { width: 160px; height: 160px; background: #c8fffa; top: 40%; left: -70px; animation-delay: 0.6s; }

    @keyframes float {
      0%, 100% { transform: translateY(0) translateX(0) scale(1); }
      50%      { transform: translateY(-14px) translateX(8px) scale(1.04); }
    }
  </style>
</head>
<body class="relative min-h-screen flex items-center justify-center bg-gradient-to-br from-[#f8faf9] to-[#e6f7f6] overflow-hidden">

  <div class="bubble b1"></div>
  <div class="bubble b2"></div>
  <div class="bubble b3"></div>

  <div class="relative text-center bg-white/90 backdrop-blur-md shadow-2xl rounded-2xl p-10 border-t-8 border-[#20B2AA] fade-in-up z-10">
    <h1 class="text-3xl font-extrabold text-[#20B2AA] mb-4">Selamat Datang di Klinik Perusahaan</h1>
    <p class="text-gray-600 mb-6">Silakan login untuk melanjutkan ke sistem.</p>
    <a href="{{ route('login') }}" 
       class="bg-[#20B2AA] text-white px-7 py-3 rounded-lg shadow-md hover:bg-[#1b9a92] transition duration-300 btn-animate inline-block">
      Login
    </a> 
  </div>

</body>
</html>
