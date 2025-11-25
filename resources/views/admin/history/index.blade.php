@extends('layouts.admin')

@section('title', 'History Aktivitas')

@php
    use Illuminate\Support\Str;
@endphp

@section('content')
    <div class="space-y-6" x-data="{ showConfirm: false }" x-cloak>
        <div class="rounded-3xl border border-emerald-100 bg-white/95 p-6 shadow-xl shadow-emerald-100">
            <div class="mb-6 flex flex-col gap-4 md:flex-row md:items-start md:justify-between">
                <div>
                    <p class="text-sm font-semibold uppercase tracking-[0.3em] text-emerald-500">Monitoring</p>
                    <h1 class="text-3xl font-semibold text-emerald-900 mt-1">History Aktivitas</h1>
                    <p class="text-sm text-slate-500 mt-2">Pantau aksi create, edit, hapus, serta unduh rekam medis yang dilakukan admin, dokter, maupun koas.</p>
                </div>
                <div class="self-stretch md:self-auto">
                    <button
                        type="button"
                        @click="showConfirm = true"
                        class="inline-flex items-center gap-2 rounded-xl bg-rose-500/90 px-4 py-2 text-sm font-semibold text-white shadow shadow-rose-200 hover:bg-rose-500 transition"
                    >
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="size-4">
                            <path d="M6 6h12m-9 0v-.5A1.5 1.5 0 0 1 10.5 4h3A1.5 1.5 0 0 1 15 5.5V6m3 0v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V6m3 4v6m4-6v6" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        Bersihkan History
                    </button>
                </div>
            </div>

            @if (session('status'))
                <div class="mb-6 rounded-xl border border-emerald-100 bg-emerald-50/70 px-4 py-3 text-sm font-medium text-emerald-800">
                    {{ session('status') }}
                </div>
            @endif

            <div class="overflow-x-auto rounded-2xl border border-emerald-100">
                <table class="min-w-full divide-y divide-emerald-50 text-sm">
                    <thead class="bg-emerald-50/70 text-emerald-700 text-xs font-semibold uppercase tracking-widest">
                        <tr>
                            <th class="px-4 py-3 text-left">Waktu</th>
                            <th class="px-4 py-3 text-left">Pengguna</th>
                            <th class="px-4 py-3 text-left">Aksi</th>
                            <th class="px-4 py-3 text-left">Detail</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-emerald-50">
                        @forelse ($logs as $log)
                            <tr class="hover:bg-emerald-50/50 transition">
                                <td class="px-4 py-3 text-slate-700">
                                    <span class="font-semibold">{{ $log->created_at->format('d M Y') }}</span>
                                    <span class="block text-xs text-slate-500">{{ $log->created_at->format('H:i') }} WIB</span>
                                </td>
                                <td class="px-4 py-3">
                                    <p class="font-semibold text-slate-800">{{ $log->user->name ?? 'Sistem' }}</p>
                                    <p class="text-xs uppercase tracking-wide text-emerald-600">{{ $log->user_role ?? 'N/A' }}</p>
                                </td>
                                <td class="px-4 py-3 text-slate-700 font-semibold">
                                    {{ Str::headline($log->action) }}
                                </td>
                                <td class="px-4 py-3 text-slate-600">
                                    <p>{{ $log->description }}</p>
                                    @if (!empty($log->metadata))
                                        <dl class="mt-2 grid gap-1 text-xs text-slate-500 sm:grid-cols-2">
                                            @foreach ($log->metadata as $key => $value)
                                                <div class="flex items-center gap-2">
                                                    <dt class="uppercase tracking-widest">{{ Str::of($key)->replace('_', ' ')->title() }}:</dt>
                                                    <dd>{{ $value }}</dd>
                                                </div>
                                            @endforeach
                                        </dl>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-8 text-center text-slate-500">
                                    Belum ada aktivitas yang tercatat.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-6">
                {{ $logs->links('vendor.pagination.patients') }}
            </div>
        </div>

        <!-- Modal konfirmasi -->
        <div
            x-show="showConfirm"
            x-transition.opacity
            class="fixed inset-0 z-40 flex items-center justify-center bg-slate-900/50"
        >
            <div
                x-show="showConfirm"
                x-transition.scale
                class="w-full max-w-md rounded-2xl bg-white p-6 shadow-2xl shadow-slate-700/20"
            >
                <h2 class="text-xl font-semibold text-emerald-900">Bersihkan history?</h2>
                <p class="mt-2 text-sm text-slate-600">Apakah anda yakin ingin membersihkan History.</p>
                <div class="mt-6 flex flex-col gap-3 sm:flex-row sm:justify-end">
                    <button
                        type="button"
                        class="rounded-xl border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50"
                        @click="showConfirm = false"
                    >Batalkan</button>
                    <form method="POST" action="{{ route('admin.history.destroy') }}">
                        @csrf
                        @method('DELETE')
                        <button
                            type="submit"
                            class="w-full rounded-xl bg-rose-500 px-4 py-2 text-sm font-semibold text-white shadow shadow-rose-200 hover:bg-rose-600"
                        >Ya, bersihkan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
