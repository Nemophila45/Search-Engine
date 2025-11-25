@php
    $currentUser = auth()->user();
@endphp

<nav class="fixed inset-x-0 top-0 z-20 bg-white text-emerald-900 shadow-md after:pointer-events-none after:absolute after:inset-x-0 after:bottom-0 after:h-px after:bg-emerald-100">
    <div class="mx-auto max-w-7xl px-2 sm:px-6 lg:px-8">
        <div class="relative flex h-16 items-center justify-between">
            <div class="flex flex-1 items-center justify-start">
                <a href="{{ route('patients.index') }}" class="flex shrink-0 items-center text-emerald-900 font-semibold tracking-wide hover:text-emerald-600 transition">
                    <span class="text-lg">Sistem RSUD</span>
                </a>
            </div>
            <div class="flex items-center gap-3">

                @auth
                    @if ($currentUser?->role)
                        <span class="hidden sm:inline-flex items-center rounded-full border border-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">
                            {{ $currentUser->role->label() }}
                        </span>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="hidden sm:inline-flex items-center rounded-full border border-emerald-200 px-4 py-1.5 text-sm font-semibold text-emerald-900 hover:bg-emerald-50 transition">
                        Login
                    </a>
                @endauth

                <el-dropdown class="relative ml-3">
                    <button class="relative flex rounded-full focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-emerald-300">
                        <span class="absolute -inset-1.5"></span>
                        <span class="sr-only">Open user menu</span>
                    </button>

                    <el-menu anchor="bottom end" popover class="w-48 origin-top-right rounded-md bg-white text-emerald-800 py-1 outline -outline-offset-1 outline-emerald-100 transition transition-discrete [--anchor-gap:--spacing(2)] data-closed:scale-95 data-closed:transform data-closed:opacity-0 data-enter:duration-100 data-enter:ease-out data-leave:duration-75 data-leave:ease-in">
                        <a href="{{ route('patients.index') }}" class="block px-4 py-2 text-sm focus:bg-emerald-50 focus:outline-hidden">Daftar Pasien</a>
                        @auth
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-sm text-rose-500 focus:bg-emerald-50 focus:outline-hidden">
                                    Logout
                                </button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="block px-4 py-2 text-sm text-emerald-700 focus:bg-emerald-50 focus:outline-hidden">
                                Login
                            </a>
                        @endauth
                    </el-menu>
                </el-dropdown>
            </div>
        </div>
    </div>
</nav>
