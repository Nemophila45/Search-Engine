<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistem Rekam Medis')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindplus/elements@1" type="module"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="min-h-screen bg-white text-slate-800">
    @include('layouts.sidebar')

    <div class="min-h-screen bg-white transition-all duration-300 lg:ml-64 pt-16">
        @include('partials.admin-nav')

        <main class="max-w-6xl mx-auto px-4 pb-12 pt-4 [&>*:first-child]:mt-0">
            @yield('content')
        </main>
    </div>

    @stack('scripts')
</body>

</html>
