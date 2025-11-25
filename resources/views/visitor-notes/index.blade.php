@extends('layouts.public')

@section('title', 'Catatan Pengunjung')

@section('content')
    <div class="rounded-3xl border border-emerald-100 bg-white/90 p-8 shadow-2xl shadow-emerald-100">
        <div class="mb-8 space-y-2 text-center">
            <p class="text-sm font-semibold uppercase tracking-[0.25em] text-emerald-500">Publik</p>
            <h1 class="text-3xl font-semibold text-emerald-900">Catatan Pengunjung</h1>
            <p class="text-sm text-slate-500">
                Halaman ini menampilkan dokumen pendukung yang diunggah pada riwayat medis pasien.
                Silakan unduh untuk kebutuhan monitoring dan pelaporan eksternal.
            </p>
        </div>

        <div class="overflow-x-auto rounded-2xl border border-emerald-100">
            <table class="min-w-full divide-y divide-emerald-100 text-sm">
                <thead class="bg-emerald-50/80 text-emerald-700 uppercase tracking-widest text-xs font-semibold">
                    <tr>
                        <th class="px-4 py-3 text-left">Tanggal</th>
                        <th class="px-4 py-3 text-left">Nama Pasien</th>
                        <th class="px-4 py-3 text-left">Nomor RM</th>
                        <th class="px-4 py-3 text-left">Diagnosa</th>
                        <th class="px-4 py-3 text-left">Dokter</th>
                        <th class="px-4 py-3 text-left">File</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-emerald-50 text-slate-700">
                    @forelse ($records as $record)
                        <tr class="hover:bg-emerald-50/60 transition">
                            <td class="px-4 py-3 font-semibold">{{ $record->tanggal_kunjungan->format('d/m/Y') }}</td>
                            <td class="px-4 py-3">{{ $record->patient->nama }}</td>
                            <td class="px-4 py-3 text-slate-500">{{ $record->patient->no_rekam_medis }}</td>
                            <td class="px-4 py-3">{{ $record->diagnosa }}</td>
                            <td class="px-4 py-3">{{ $record->dokter }}</td>
                            <td class="px-4 py-3">
                                <a href="{{ asset('storage/' . ltrim($record->attachment_path, '/')) }}"
                                   class="inline-flex items-center rounded-full border border-emerald-200 px-3 py-1 text-xs font-semibold text-emerald-600 hover:bg-emerald-500 hover:text-white transition"
                                   download>
                                    Unduh
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-8 text-center text-slate-500">
                                Belum ada dokumen yang dapat ditampilkan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $records->links('vendor.pagination.patients') }}
        </div>
    </div>
@endsection
