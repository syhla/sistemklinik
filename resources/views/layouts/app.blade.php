<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Klinik Perusahaan</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#F5F5F5] text-gray-800 min-h-screen flex flex-col font-sans">

    {{-- Navbar --}}
    <nav class="bg-[#20B2AA] text-white shadow-md sticky top-0 z-50">
        <div class="container mx-auto flex justify-between items-center px-6 py-4">
            <h1 class="text-2xl font-extrabold tracking-wide">🏥 Sistem Klinik</h1>
            <div class="flex items-center gap-6">
                <a href="{{ route('resepsionis.dashboard') }}" 
                   class="hover:text-yellow-200 transition">Dashboard</a>
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" 
                            class="bg-red-500 hover:bg-red-600 px-4 py-2 rounded-lg text-sm shadow-md transition">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>

    {{-- Content --}}
    <main class="flex-1 container mx-auto px-6 py-10">
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="bg-white border-t py-6 text-center text-gray-600 text-sm shadow-inner">
        <p>&copy; {{ date('Y') }} <span class="font-semibold text-[#20B2AA]">Klinik Perusahaan</span>. 
        All rights reserved.</p>
    </footer>

</body>
</html>
