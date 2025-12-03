@extends('layouts.admin')

@section('title', 'Daftar Pasien')

@section('content')
    <div class="flex flex-col gap-6">
        <div class="rounded-2xl bg-white/90 shadow-xl shadow-slate-200 border border-emerald-100 p-6">
            <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between mb-2">
                <div>
                    <p class="text-sm font-semibold uppercase text-emerald-500 tracking-[0.3em]">Sistem RSUD</p>
                    <h1 class="text-3xl font-bold text-emerald-800 mt-1">Daftar Pasien</h1>
                    <p class="text-sm text-slate-500 mt-1">Cari pasien berdasarkan nama, NIK, atau nomor rekam medis.</p>
                </div>
                @if (auth()->user()?->hasAnyRole('admin', 'doctor'))
                    <a href="{{ route('patients.create') }}"
                       class="inline-flex items-center gap-2 rounded-xl bg-emerald-500 px-4 py-2 text-sm font-semibold text-white shadow-md shadow-emerald-200 hover:bg-emerald-500/90 transition">
                        + Tambah Pasien
                    </a>
                @endif
            </div>

            @if (session('status'))
                <div class="rounded-xl bg-emerald-100/80 px-4 py-2 text-sm font-medium text-emerald-900 mb-4">
                    {{ session('status') }}
                </div>
            @endif

            <form method="GET" action="{{ route('patients.index') }}" class="space-y-4">
                <div class="flex flex-col gap-3 md:flex-row md:items-end md:gap-4">
                    <label class="flex flex-col gap-1 text-sm font-semibold text-emerald-700 md:w-1/2">
                        Cari berdasarkan Nama / NIK / No RM
                        <input
                            type="text"
                            name="q"
                            id="q"
                            value="{{ $search }}"
                            placeholder="contoh: Siti / 3201xxxxx / RM-0001"
                            class="w-full rounded-xl border border-emerald-200 bg-white/70 px-4 py-2.5 text-sm focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100 transition"
                        >
                    </label>

                    <label class="flex flex-col gap-1 text-sm font-semibold text-emerald-700 md:w-1/4">
                        Dokter
                        <select
                            name="dokter"
                            class="rounded-xl border border-emerald-200 bg-white/70 px-4 py-2.5 text-sm focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100 transition"
                        >
                            <option value="">Semua Dokter</option>
                            @foreach ($doctorOptions as $doctor)
                                <option value="{{ $doctor }}" @selected($selectedDoctor === $doctor)>{{ $doctor }}</option>
                            @endforeach
                        </select>
                    </label>

                    <label class="flex flex-col gap-1 text-sm font-semibold text-emerald-700 md:w-1/4">
                        Diagnosa
                        <div class="flex gap-3">
                            <select
                                name="diagnosa"
                                class="w-full rounded-xl border border-emerald-200 bg-white/70 px-4 py-2.5 text-sm focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100 transition"
                            >
                                <option value="">Semua Diagnosa</option>
                                @foreach ($diagnosisOptions as $diagnosis)
                                    <option value="{{ $diagnosis }}" @selected($selectedDiagnosis === $diagnosis)>{{ $diagnosis }}</option>
                                @endforeach
                            </select>
                        </div>
                    </label>

                    <label class="flex flex-col gap-1 text-sm font-semibold text-emerald-700 md:w-1/4">
                        Umur
                        <div class="flex gap-3">
                            <select
                                name="umur"
                                class="w-full rounded-xl border border-emerald-200 bg-white/70 px-4 py-2.5 text-sm focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100 transition"
                            >
                                <option value="">Semua Umur</option>
                                @foreach ($ageOptions as $range)
                                    <option value="{{ $range['value'] }}" @selected($selectedAgeRange === $range['value'])>{{ $range['label'] }}</option>
                                @endforeach
                            </select>
                            <button
                                type="submit"
                                class="inline-flex shrink-0 items-center justify-center rounded-xl bg-emerald-500 px-5 py-2.5 text-sm font-semibold text-white shadow-lg shadow-emerald-200 hover:bg-emerald-500/90 transition"
                            >Cari</button>
                        </div>
                    </label>
                </div>
            </form>
        </div>

        <div class="overflow-hidden rounded-2xl border border-emerald-100 bg-white/95 shadow-xl shadow-slate-200">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-emerald-100">
                    <thead class="bg-emerald-50/70 text-emerald-700 text-xs font-semibold uppercase tracking-widest">
                        <tr>
                            <th class="px-6 py-3 text-left">No. Rekam Medis</th>
                            <th class="px-6 py-3 text-left">NIK</th>
                            <th class="px-6 py-3 text-left">Nama</th>
                            <th class="px-6 py-3 text-left">Tanggal Lahir</th>
                            <th class="px-6 py-3 text-left">Umur</th>
                            <th class="px-6 py-3 text-left">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-emerald-50 text-sm">
                        @forelse ($patients as $patient)
                            <tr class="hover:bg-emerald-50/50 transition">
                                <td class="px-6 py-4 font-semibold text-slate-800">{{ $patient->no_rekam_medis }}</td>
                                <td class="px-6 py-4 text-slate-600">{{ $patient->nik }}</td>
                                <td class="px-6 py-4 text-slate-700">{{ $patient->nama }}</td>
                                <td class="px-6 py-4 text-slate-600">{{ optional($patient->tanggal_lahir)?->format('d/m/Y') ?? '-' }}</td>
                                <td class="px-6 py-4 text-slate-700">{{ $patient->umur ? $patient->umur . ' th' : '-' }}</td>
                                <td class="px-6 py-4">
                                    <a href="{{ route('patients.show', $patient) }}"
                                       class="inline-flex items-center rounded-full border border-emerald-200 px-3 py-1.5 text-xs font-semibold uppercase tracking-wider text-emerald-600 hover:bg-emerald-500 hover:text-white transition">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-10 text-center text-slate-500">
                                    Belum ada data pasien.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{ $patients->links('vendor.pagination.patients') }}
        </div>
    </div>
@endsection
