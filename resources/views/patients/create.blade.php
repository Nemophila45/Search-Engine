@extends('layouts.admin')

@section('title', 'Tambah Pasien')

@section('content')
    <div class="flex flex-col gap-6">
        <div class="rounded-2xl bg-white/90 shadow-xl shadow-slate-200 border border-emerald-100 p-6">
            <div class="flex flex-col gap-3 lg:flex-row lg:items-center lg:justify-between mb-2">
                <div>
                    <p class="text-sm font-semibold uppercase text-emerald-500 tracking-[0.3em]">Sistem RSUD</p>
                    <h1 class="text-3xl font-bold text-emerald-800 mt-1">Tambah Pasien</h1>
                    <p class="text-sm text-slate-500 mt-1">Isi data pasien baru untuk ditambahkan ke sistem.</p>
                </div>
                <a href="{{ route('patients.index') }}"
                   class="inline-flex items-center gap-2 rounded-xl border border-emerald-200 px-4 py-2 text-sm font-semibold text-emerald-700 hover:bg-emerald-500 hover:text-white transition">
                    Kembali
                </a>
            </div>

            @if ($errors->any())
                <div class="rounded-xl bg-rose-50 border border-rose-100 text-rose-700 px-4 py-3 text-sm mb-4">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('patients.store') }}" class="grid gap-4 md:grid-cols-2">
                @csrf
                <label class="flex flex-col gap-1 text-sm font-semibold text-emerald-700">
                    No. Rekam Medis
                    <input type="text" name="no_rekam_medis" value="{{ old('no_rekam_medis') }}"
                           class="rounded-xl border border-emerald-200 bg-white/70 px-4 py-2.5 text-sm focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100 transition" required>
                </label>
                <label class="flex flex-col gap-1 text-sm font-semibold text-emerald-700">
                    NIK
                    <input type="text" name="nik" value="{{ old('nik') }}"
                           class="rounded-xl border border-emerald-200 bg-white/70 px-4 py-2.5 text-sm focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100 transition" required>
                </label>
                <label class="flex flex-col gap-1 text-sm font-semibold text-emerald-700">
                    Nama
                    <input type="text" name="nama" value="{{ old('nama') }}"
                           class="rounded-xl border border-emerald-200 bg-white/70 px-4 py-2.5 text-sm focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100 transition" required>
                </label>
                <label class="flex flex-col gap-1 text-sm font-semibold text-emerald-700">
                    Tanggal Lahir
                    <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}"
                           class="rounded-xl border border-emerald-200 bg-white/70 px-4 py-2.5 text-sm focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100 transition">
                </label>
                <label class="flex flex-col gap-1 text-sm font-semibold text-emerald-700">
                    Jenis Kelamin
                    <select name="jenis_kelamin"
                            class="rounded-xl border border-emerald-200 bg-white/70 px-4 py-2.5 text-sm focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100 transition">
                        <option value="">Pilih</option>
                        <option value="Laki-laki" @selected(old('jenis_kelamin') === 'Laki-laki')>Laki-laki</option>
                        <option value="Perempuan" @selected(old('jenis_kelamin') === 'Perempuan')>Perempuan</option>
                    </select>
                </label>
                <label class="flex flex-col gap-1 text-sm font-semibold text-emerald-700">
                    No. HP
                    <input type="text" name="no_hp" value="{{ old('no_hp') }}"
                           class="rounded-xl border border-emerald-200 bg-white/70 px-4 py-2.5 text-sm focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100 transition">
                </label>
                <label class="flex flex-col gap-1 text-sm font-semibold text-emerald-700">
                    Provinsi
                    <input type="text" name="provinsi" value="{{ old('provinsi') }}"
                           class="rounded-xl border border-emerald-200 bg-white/70 px-4 py-2.5 text-sm focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100 transition">
                </label>
                <label class="flex flex-col gap-1 text-sm font-semibold text-emerald-700">
                    Kota/Kabupaten
                    <input type="text" name="kabupaten_kota" value="{{ old('kabupaten_kota') }}"
                           class="rounded-xl border border-emerald-200 bg-white/70 px-4 py-2.5 text-sm focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100 transition">
                </label>
                <label class="flex flex-col gap-1 text-sm font-semibold text-emerald-700">
                    Kecamatan
                    <input type="text" name="kecamatan" value="{{ old('kecamatan') }}"
                           class="rounded-xl border border-emerald-200 bg-white/70 px-4 py-2.5 text-sm focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100 transition">
                </label>
                <label class="flex flex-col gap-1 text-sm font-semibold text-emerald-700">
                    Kel/Desa
                    <input type="text" name="kelurahan_desa" value="{{ old('kelurahan_desa') }}"
                           class="rounded-xl border border-emerald-200 bg-white/70 px-4 py-2.5 text-sm focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100 transition">
                </label>
                <label class="flex flex-col gap-1 text-sm font-semibold text-emerald-700 md:col-span-2">
                    Alamat Lengkap
                    <input type="text" name="alamat" value="{{ old('alamat') }}"
                           class="rounded-xl border border-emerald-200 bg-white/70 px-4 py-2.5 text-sm focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100 transition">
                </label>

                <div class="md:col-span-2 flex justify-end gap-2 mt-2">
                    <a href="{{ route('patients.index') }}"
                       class="inline-flex items-center rounded-xl border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-50 transition">
                        Batal
                    </a>
                    <button type="submit"
                            class="inline-flex items-center rounded-xl bg-emerald-500 px-5 py-2 text-sm font-semibold text-white shadow-lg shadow-emerald-200 hover:bg-emerald-500/90 transition">
                        Simpan Pasien
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
