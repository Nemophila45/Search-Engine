@extends('layouts.admin')

@section('title', 'Kelola Akun Petugas')

@section('content')
    <div class="space-y-6">
        <div class="flex flex-col gap-2">
            <p class="text-xs font-semibold uppercase tracking-[0.3em] text-emerald-500">Manajemen User</p>
            <h1 class="text-3xl font-semibold text-emerald-800">Kelola Akun Dokter & Koas</h1>
            <p class="text-sm text-slate-600">Admin dapat membuat akun baru untuk dokter atau koas yang akan menginput diagnosa.</p>
        </div>

        @if (session('status'))
            <div class="rounded-2xl border border-emerald-100 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-800">
                {{ session('status') }}
            </div>
        @endif

        <div class="grid gap-6 lg:grid-cols-2">
            <div class="rounded-3xl border border-emerald-100 bg-white/95 p-6 shadow-xl shadow-emerald-100">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-semibold text-emerald-800">Daftar Akun</h2>
                    <span class="rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-700">
                        {{ $staff->count() }} akun
                    </span>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-emerald-100 text-sm">
                        <thead class="bg-emerald-50/60 text-emerald-600">
                            <tr>
                                <th class="px-4 py-2 text-left font-semibold">Nama</th>
                                <th class="px-4 py-2 text-left font-semibold">Email</th>
                                <th class="px-4 py-2 text-left font-semibold">Role</th>
                                <th class="px-4 py-2 text-right font-semibold">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-emerald-50">
                            @forelse ($staff as $member)
                                <tr>
                                    <td class="px-4 py-3 font-semibold text-slate-800">{{ $member->name }}</td>
                                    <td class="px-4 py-3 text-slate-600">{{ $member->email }}</td>
                                    <td class="px-4 py-3">
                                        <span class="inline-flex items-center rounded-full border border-emerald-100 bg-emerald-50 px-3 py-1 text-xs font-semibold uppercase tracking-wider text-emerald-700">
                                            {{ $member->role?->label() }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-right">
                                        <button type="button"
                                                class="inline-flex items-center gap-2 rounded-full border border-rose-200 bg-rose-50 px-3 py-1 text-xs font-semibold uppercase tracking-wide text-rose-600 transition hover:bg-rose-100"
                                                onclick="openDeleteModal('{{ $member->id }}')">
                                            Hapus
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-4 py-6 text-center text-slate-500">
                                        Belum ada akun dokter/koas.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="rounded-3xl border border-emerald-100 bg-white/95 p-6 shadow-xl shadow-emerald-100">
                <h2 class="text-xl font-semibold text-emerald-800 mb-4">Tambah Akun Baru</h2>
                <form method="POST" action="{{ route('admin.users.store') }}" class="space-y-4">
                    @csrf
                    <label class="block text-sm font-semibold text-emerald-700">
                        Nama Lengkap
                        <input type="text" name="name" value="{{ old('name') }}"
                               class="mt-1 w-full rounded-2xl border border-emerald-200 px-4 py-2 focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100">
                        @error('name')
                            <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                        @enderror
                    </label>

                    <label class="block text-sm font-semibold text-emerald-700">
                        Email
                        <input type="email" name="email" value="{{ old('email') }}"
                               class="mt-1 w-full rounded-2xl border border-emerald-200 px-4 py-2 focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100">
                        @error('email')
                            <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                        @enderror
                    </label>

                    <label class="block text-sm font-semibold text-emerald-700">
                        Password
                        <div class="relative mt-1">
                            <input id="admin-create-password" type="password" name="password"
                                   class="w-full rounded-2xl border border-emerald-200 px-4 py-2 pr-12 focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100">
                            <button type="button" id="toggle-admin-password"
                                    aria-label="Tampilkan password"
                                    class="absolute inset-y-0 right-3 flex items-center justify-center rounded-full p-2 text-emerald-500 transition hover:bg-emerald-50 focus:outline-none focus:ring-2 focus:ring-emerald-100">
                                <svg id="icon-admin-eye-open" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.25 12s3.75-6 9.75-6 9.75 6 9.75 6-3.75 6-9.75 6-9.75-6-9.75-6z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9a3 3 0 100 6 3 3 0 000-6z" />
                                </svg>
                                <svg id="icon-admin-eye-off" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3l18 18M10.477 10.477A3 3 0 0113.5 13.5m-3-3L6.53 6.53m6.97 6.97L17.47 17.47M6.228 6.228C4.34 7.412 2.98 9.035 2.25 12c1.5 2.5 4.5 6 9.75 6 1.526 0 2.893-.283 4.1-.77m-7.872-7.872C8.46 9.05 9.63 8 12 8c.438 0 .843.055 1.218.16" />
                                </svg>
                            </button>
                        </div>
                        @error('password')
                            <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                        @enderror
                    </label>

                    <label class="block text-sm font-semibold text-emerald-700">
                        Role
                        <select name="role"
                                class="mt-1 w-full rounded-2xl border border-emerald-200 px-4 py-2 focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100">
                            <option value="" disabled {{ old('role') ? '' : 'selected' }}>Pilih role</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->value }}" @selected(old('role') === $role->value)>
                                    {{ $role->label() }}
                                </option>
                            @endforeach
                        </select>
                        @error('role')
                            <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                        @enderror
                    </label>

                    <button type="submit"
                            class="w-full rounded-2xl bg-emerald-500 px-4 py-3 text-sm font-semibold uppercase tracking-wide text-white shadow-lg shadow-emerald-200 hover:bg-emerald-600 transition">
                        Buat Akun
                    </button>
                </form>
            </div>
        </div>
    </div>

    @foreach ($staff as $member)
        <div id="delete-modal-{{ $member->id }}" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-900/50 backdrop-blur-sm px-4">
            <div class="w-full max-w-md rounded-3xl bg-white shadow-2xl shadow-emerald-100">
                <div class="flex items-start justify-between px-6 pt-6">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.3em] text-emerald-500">Konfirmasi</p>
                        <h3 class="mt-1 text-xl font-semibold text-emerald-800">Hapus akun?</h3>
                    </div>
                    <button type="button"
                            class="text-slate-400 hover:text-slate-600"
                            aria-label="Tutup"
                            onclick="closeDeleteModal('{{ $member->id }}')">
                        &times;
                    </button>
                </div>
                <div class="px-6 py-4 text-slate-600">
                    <p>Apakah Anda yakin ingin menghapus akun <strong class="font-semibold text-emerald-700">{{ $member->name }}</strong> ({{ $member->email }})?</p>
                    <p class="mt-2 text-sm text-slate-500">Tindakan ini tidak dapat dibatalkan.</p>
                </div>
                <div class="flex items-center justify-end gap-3 px-6 pb-6 pt-2">
                    <button type="button"
                            class="rounded-full border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50"
                            onclick="closeDeleteModal('{{ $member->id }}')">
                        Batalkan
                    </button>
                    <form method="POST" action="{{ route('admin.users.destroy', $member) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="rounded-full bg-rose-500 px-4 py-2 text-sm font-semibold text-white shadow-lg shadow-rose-200 transition hover:bg-rose-600">
                            Ya, hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @endforeach

    @push('scripts')
        <script>
            function openDeleteModal(id) {
                const modal = document.getElementById(`delete-modal-${id}`);
                if (!modal) return;
                modal.classList.remove('hidden');
                modal.classList.add('flex');
                document.body.classList.add('overflow-hidden');
            }

            function closeDeleteModal(id) {
                const modal = document.getElementById(`delete-modal-${id}`);
                if (!modal) return;
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                document.body.classList.remove('overflow-hidden');
            }

            (function () {
                const input = document.getElementById('admin-create-password');
                const toggle = document.getElementById('toggle-admin-password');
                const eyeOpen = document.getElementById('icon-admin-eye-open');
                const eyeOff = document.getElementById('icon-admin-eye-off');

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
    @endpush
@endsection
