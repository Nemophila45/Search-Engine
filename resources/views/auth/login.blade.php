<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Sistem RSUD</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gradient-to-br from-green-50 via-emerald-50 to-green-100 text-slate-800">
    <header class="bg-white/90 border-b border-emerald-100 shadow-sm">
        <div class="max-w-5xl mx-auto flex items-center justify-between px-6 py-4">
            <a href="{{ route('patients.index') }}" class="text-lg font-semibold text-emerald-700 hover:text-emerald-500 transition">
                Sistem RSUD
            </a>
        </div>
    </header>

    <main class="min-h-[calc(100vh-72px)] flex items-center justify-center px-4">
        <div class="w-full max-w-md px-6">
            <div class="rounded-3xl border border-emerald-100 bg-white/90 p-8 shadow-2xl shadow-emerald-100">
            <div class="text-center">
                <p class="text-xs font-semibold uppercase tracking-[0.5em] text-emerald-500">Sistem RSUD</p>
                <h1 class="mt-2 text-3xl font-bold text-emerald-800">Masuk Sistem</h1>
                <p class="mt-1 text-sm text-slate-500">Gunakan akun Admin, Dokter, atau Koas untuk mengelola data.</p>
            </div>

            @if (session('status'))
                <div class="mt-4 rounded-2xl bg-emerald-100 px-4 py-3 text-sm font-semibold text-emerald-800">
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mt-4 rounded-2xl bg-rose-100 px-4 py-3 text-sm font-semibold text-rose-800">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ url('/login') }}" class="mt-6 space-y-4">
                @csrf
                <label class="block text-sm font-semibold text-emerald-700">
                    Email
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                           class="mt-1 w-full rounded-2xl border border-emerald-200 bg-white px-4 py-2 focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100">
                </label>

                <label class="block text-sm font-semibold text-emerald-700">
                    Password
                    <div class="relative mt-1">
                        <input id="password" type="password" name="password" required
                               class="w-full rounded-2xl border border-emerald-200 bg-white px-4 py-2 pr-12 focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100">
                        <button type="button" id="toggle-password"
                                aria-label="Tampilkan password"
                                class="absolute inset-y-0 right-3 flex items-center justify-center rounded-full p-2 text-emerald-500 transition hover:bg-emerald-50 focus:outline-none focus:ring-2 focus:ring-emerald-100">
                            <svg id="icon-eye-open" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.25 12s3.75-6 9.75-6 9.75 6 9.75 6-3.75 6-9.75 6-9.75-6-9.75-6z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9a3 3 0 100 6 3 3 0 000-6z" />
                            </svg>
                            <svg id="icon-eye-off" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3l18 18M10.477 10.477A3 3 0 0113.5 13.5m-3-3L6.53 6.53m6.97 6.97L17.47 17.47M6.228 6.228C4.34 7.412 2.98 9.035 2.25 12c1.5 2.5 4.5 6 9.75 6 1.526 0 2.893-.283 4.1-.77m-7.872-7.872C8.46 9.05 9.63 8 12 8c.438 0 .843.055 1.218.16" />
                            </svg>
                        </button>
                    </div>
                </label>

                <label class="flex items-center gap-2 text-sm font-medium text-slate-600">
                    <input type="checkbox" name="remember" value="1" {{ old('remember') ? 'checked' : '' }}
                           class="h-4 w-4 rounded border-emerald-300 text-emerald-600 focus:ring-emerald-500">
                    Ingat saya
                </label>

                <button type="submit"
                        class="w-full rounded-2xl bg-emerald-500 px-4 py-3 text-sm font-semibold uppercase tracking-[0.3em] text-white shadow-lg shadow-emerald-200 hover:bg-emerald-600 transition">
                    Masuk
                </button>
            </form>
        </div>
        </div>
    </main>
</body>
<script>
    (function () {
        const input = document.getElementById('password');
        const toggle = document.getElementById('toggle-password');
        const eyeOpen = document.getElementById('icon-eye-open');
        const eyeOff = document.getElementById('icon-eye-off');

        if (!input || !toggle || !eyeOpen || !eyeOff) return;

        toggle.addEventListener('click', function () {
            const isHidden = input.getAttribute('type') === 'password';
            input.setAttribute('type', isHidden ? 'text' : 'password');
            eyeOpen.classList.toggle('hidden', !isHidden);
            eyeOff.classList.toggle('hidden', isHidden);
            toggle.setAttribute('aria-label', isHidden ? 'Sembunyikan password' : 'Tampilkan password');
        });
    })();
</script>
</html>
