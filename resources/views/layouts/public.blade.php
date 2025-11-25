<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Catatan Pengunjung')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-emerald-50/40 text-slate-800">
    <nav class="bg-white shadow-sm">
        <div class="mx-auto flex max-w-6xl items-center justify-between px-4 py-4">
            <a href="{{ url('/') }}" class="text-lg font-semibold text-emerald-700">Sistem RSUD</a>
            <div class="flex items-center gap-3 text-sm">
                <a href="{{ route('visitor-notes.index') }}" class="text-emerald-600 font-semibold">Catatan Pengunjung</a>
                @auth
                    <a href="{{ route('patients.index') }}" class="rounded-full border border-emerald-200 px-4 py-1.5 font-semibold text-emerald-700">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="rounded-full border border-emerald-200 px-4 py-1.5 font-semibold text-emerald-700">
                        Login
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    <main class="mx-auto w-full max-w-5xl px-4 py-12">
        @yield('content')
    </main>

    <footer class="mt-16 border-t border-emerald-100 bg-white/80 py-6 text-center text-sm text-slate-500">
        &copy; {{ date('Y') }} Sistem RSUD. Semua hak dilindungi.
    </footer>
</body>
</html>
