@php
    use App\Enums\UserRole;
    use Illuminate\Support\Facades\Route;

    $role = auth()->user()?->role;
    $hasDiseaseIndex = Route::has('diseases.index');
    $hasDiseaseCreate = Route::has('diseases.create');
    $showDiseaseMenu = in_array($role, [UserRole::DOCTOR, UserRole::KOAS], true)
        && ($hasDiseaseIndex || $hasDiseaseCreate);
    $historyUrl = Route::has('admin.history.index') ? route('admin.history.index') : '#';
    $diseaseChartUrl = Route::has('admin.reports.disease-chart') ? route('admin.reports.disease-chart') : '#';
@endphp

<style>
    [x-cloak] {
        display: none !important;
    }
</style>

<div x-data="{ openSidebar: true, openDisease: false }" class="relative">
    <aside
        class="fixed inset-y-0 left-0 z-30 flex h-screen flex-col bg-emerald-900 text-white shadow-xl transition-all duration-300"
        :class="openSidebar ? 'w-64' : 'w-16'">
        <div class="flex items-center justify-between px-3 py-4">
            <div class="flex items-center gap-2">
                <span
                    class="font-semibold tracking-wide"
                    x-show="openSidebar"
                    x-transition
                    x-cloak
                >
                    Sistem RSUD
                </span>
            </div>
            <button
                type="button"
                class="rounded-md border border-white/10 p-2 text-white hover:bg-white/10"
                @click="openSidebar = !openSidebar"
            >
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="size-5">
                    <path d="M4 7h16M4 12h16M4 17h16" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </button>
        </div>

        <nav class="mt-4 flex-1 space-y-1 px-2">
            @if ($role === UserRole::ADMIN)
                <div class="space-y-1">
                    <a
                        href="{{ route('admin.users.index') }}"
                        class="flex items-center gap-3 rounded-xl px-3 py-2 text-sm font-medium hover:bg-white/10"
                    >
                        <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-white/10">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="size-5">
                                <path d="M7 7h10M7 12h10M7 17h6" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </span>
                        <span x-show="openSidebar" x-transition x-cloak>Kelola Akun</span>
                    </a>

                    @if ($historyUrl !== '#')
                        <a
                            href="{{ $historyUrl }}"
                            class="flex items-center gap-3 rounded-xl px-3 py-2 text-sm font-medium hover:bg-white/10"
                        >
                            <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-white/10">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="size-5">
                                    <path d="M12 6v6l3 3" stroke-linecap="round" stroke-linejoin="round" />
                                    <circle cx="12" cy="12" r="8" />
                                </svg>
                            </span>
                            <div x-show="openSidebar" x-transition x-cloak class="leading-tight">
                                <div>History</div>
                            </div>
                        </a>
                    @endif

                    @if ($diseaseChartUrl !== '#')
                        <a
                            href="{{ $diseaseChartUrl }}"
                            @class([
                                'flex items-center gap-3 rounded-xl px-3 py-2 text-sm font-medium hover:bg-white/10',
                                request()->routeIs('admin.reports.disease-chart') ? 'bg-white/10' : '',
                            ])
                        >
                            <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-white/10">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="size-5">
                                    <path d="M4 19v-6m5 6V5m5 14V9m5 10V3" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </span>
                            <span x-show="openSidebar" x-transition x-cloak>Grafik Penyakit</span>
                        </a>
                    @endif
                </div>
            @elseif ($showDiseaseMenu)
                <div>
                    <button
                        type="button"
                        class="flex w-full items-center gap-3 rounded-xl px-3 py-2 text-sm font-medium hover:bg-white/10"
                        @click="openDisease = !openDisease"
                    >
                        <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-white/10">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="size-5">
                                <path d="M12 6v12m-6-6h12" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </span>
                        <span class="flex flex-1 items-center justify-between" x-show="openSidebar" x-transition x-cloak>
                            Jenis Penyakit
                            <svg
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.5"
                                class="size-4 transition-transform duration-300"
                                :class="openDisease ? 'rotate-90' : ''"
                            >
                                <path d="M9 6l6 6-6 6" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </span>
                    </button>
                    <div
                        class="ml-12 mt-1 space-y-1 text-sm"
                        x-show="openSidebar && openDisease"
                        x-transition.origin-top
                        x-cloak
                    >
                        @if ($hasDiseaseIndex)
                            <a
                                href="{{ route('diseases.index') }}"
                                class="block rounded-lg px-3 py-2 hover:bg-white/10"
                            >
                                Daftar Jenis Penyakit
                            </a>
                        @endif
                        @if ($hasDiseaseCreate)
                            <a
                                href="{{ route('diseases.create') }}"
                                class="block rounded-lg px-3 py-2 hover:bg-white/10"
                            >
                                Tambah Jenis Penyakit
                            </a>
                        @endif
                    </div>
                </div>
            @endif
        </nav>

        <div class="mt-auto px-3 pb-4">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button
                    type="submit"
                    class="flex w-full items-center gap-3 rounded-xl bg-white/10 px-3 py-2 text-sm font-semibold text-white hover:bg-white/20"
                >
                    <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-white/20">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="size-5">
                            <path d="M15 16l4-4-4-4m4 4H9m6 4v1a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v1" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </span>
                    <span x-show="openSidebar" x-transition x-cloak>Log Out</span>
                </button>
            </form>
        </div>
    </aside>
</div>
