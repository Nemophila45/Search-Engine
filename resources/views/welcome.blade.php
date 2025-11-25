<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Sistem Klinik') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gradient-to-br from-green-50 via-emerald-50 to-white text-slate-800 antialiased">
    <header class="bg-white/90 border-b border-emerald-100 shadow-sm">
        <div class="max-w-6xl mx-auto flex items-center justify-between px-6 py-4">
            <div class="flex items-center gap-8">
                <a href="/" class="text-xl font-semibold text-emerald-700 hover:text-emerald-500 transition">Sistem Klinik</a>
                <nav class="hidden md:flex items-center gap-6 text-sm font-semibold text-emerald-600">
                    <span class="rounded-full bg-emerald-50 px-4 py-1 text-emerald-700">Dashboard</span>
                    <span class="cursor-not-allowed text-emerald-300">Pasien</span>
                    <span class="cursor-not-allowed text-emerald-300">Riwayat</span>
                </nav>
            </div>
            <div class="flex items-center gap-4">
                <span class="text-emerald-400">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.876 18.148a2.25 2.25 0 0 1-3.752 0M18 9a6 6 0 0 0-12 0c0 1.498-.44 2.956-1.268 4.206-.43.66-.645.99-.638 1.342.007.352.237.665.699 1.29A10.108 10.108 0 0 0 7.5 17.25h9a10.11 10.11 0 0 0 2.707-1.412c.462-.625.692-.938.699-1.29.007-.352-.208-.682-.638-1.342A7.99 7.99 0 0 1 18 9Z" />
                    </svg>
                </span>
                @if (Route::has('login'))
                    <a href="{{ route('login') }}" class="rounded-full border border-emerald-500 px-5 py-1.5 text-sm font-semibold text-emerald-600 hover:bg-emerald-500 hover:text-white transition">
                        Login
                    </a>
                @endif
            </div>
        </div>
    </header>

    <main class="max-w-6xl mx-auto px-6 py-14 space-y-10">
        <section class="rounded-[32px] bg-white shadow-[0_25px_60px_rgba(16,185,129,0.15)] border border-emerald-100 px-8 py-10">
            <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.4em] text-emerald-500">Sistem Klinik</p>
                    <h1 class="text-4xl font-bold text-emerald-900 mt-2">Daftar Pasien</h1>
                    <p class="text-base text-slate-500 mt-3 max-w-2xl">
                        Tampilan ini meniru dashboard admin. Untuk mengaktifkan pencarian dan melihat data asli, silakan masuk menggunakan akun admin.
                    </p>
                </div>
            </div>

            <form class="mt-6 space-y-2 opacity-60 pointer-events-none">
                <label class="text-sm font-semibold text-emerald-700">Cari berdasarkan Nama / NIK / No RM</label>
                <div class="flex flex-col gap-3 sm:flex-row">
                    <input type="text" class="w-full rounded-2xl border border-emerald-200 bg-white px-4 py-3 text-sm" placeholder="contoh: Siti / 3201xxxxx / RM-0001" disabled>
                    <button type="button" class="inline-flex items-center justify-center rounded-2xl bg-emerald-400 px-6 py-3 text-sm font-semibold text-white">Cari</button>
                </div>
            </form>
            <p class="mt-4 text-sm font-semibold text-emerald-700">Login diperlukan untuk menggunakan fitur pencarian.</p>
        </section>

        <section class="rounded-[28px] border border-emerald-100 bg-white shadow-[0_20px_50px_rgba(15,118,110,0.08)] overflow-hidden">
            <div class="px-6 py-4">
                <p class="text-xs uppercase tracking-[0.4em] text-emerald-500">Pratinjau</p>
                <h2 class="text-2xl font-semibold text-emerald-900 mt-1">Daftar Pasien</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-emerald-100">
                    <thead class="bg-emerald-50 text-emerald-700 text-xs font-semibold uppercase tracking-widest">
                        <tr>
                            <th class="px-6 py-4 text-left">No. Rekam Medis</th>
                            <th class="px-6 py-4 text-left">NIK</th>
                            <th class="px-6 py-4 text-left">Nama</th>
                            <th class="px-6 py-4 text-left">Tanggal Lahir</th>
                            <th class="px-6 py-4 text-left">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm divide-y divide-emerald-50">
                        <tr>
                            <td colspan="5" class="px-6 py-16 text-center text-slate-400">
                                Data pasien akan tampil setelah login.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
    </main>
</body>
</html>
