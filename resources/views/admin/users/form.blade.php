@php
    $user = $user ?? null;
    $role = old('role', $user->role ?? 'mahasiswa');
@endphp

{{-- Role --}}
<div class="mb-3">
    <label for="role" class="form-label fw-semibold">Role</label>
    <select class="form-select @error('role') is-invalid @enderror" id="role" name="role" required>
        <option value="mahasiswa" {{ $role === 'mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
        <option value="admin" {{ $role === 'admin' ? 'selected' : '' }}>Admin</option>
    </select>
    @error('role')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
    <div class="form-text">
        Mahasiswa login memakai NIM. Admin login memakai email dan tidak menyimpan data akademik.
    </div>
</div>

{{-- Nama --}}
<div class="mb-3">
    <label for="nama" class="form-label fw-semibold">Nama Lengkap</label>
    <input type="text" class="form-control @error('nama') is-invalid @enderror"
           id="nama" name="nama" value="{{ old('nama', $user->nama ?? $user->name ?? '') }}"
           placeholder="Nama lengkap pengguna" required>
    @error('nama')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

{{-- Email --}}
<div class="mb-3">
    <label for="email" class="form-label fw-semibold">
        Email <span class="badge bg-light text-muted fw-normal" data-opsional-email>opsional</span>
    </label>
    <input type="email" class="form-control @error('email') is-invalid @enderror"
           id="email" name="email" value="{{ old('email', $user->email ?? '') }}"
           placeholder="nama@example.com">
    @error('email')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

{{-- Data akademik: hanya relevan untuk mahasiswa --}}
<div id="blokAkademik">
    <hr class="my-4">
    <h6 class="fw-bold text-uppercase text-muted small mb-3">Data Akademik</h6>

    {{-- NIM --}}
    <div class="mb-3">
        <label for="nim" class="form-label fw-semibold">NIM</label>
        <input type="text" class="form-control @error('nim') is-invalid @enderror"
               id="nim" name="nim" value="{{ old('nim', $user->nim ?? '') }}"
               placeholder="2201234567">
        @error('nim')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- Prodi --}}
    <div class="mb-3">
        <label for="prodi_id" class="form-label fw-semibold">Program Studi</label>
        <select class="form-select @error('prodi_id') is-invalid @enderror" id="prodi_id" name="prodi_id">
            <option value="">— Pilih program studi —</option>
            @foreach ($prodiList as $prodi)
                <option value="{{ $prodi->id }}"
                    {{ (int) old('prodi_id', $user->prodi_id ?? 0) === $prodi->id ? 'selected' : '' }}>
                    {{ $prodi->nama_prodi }}
                </option>
            @endforeach
        </select>
        @error('prodi_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- Tahun ajar --}}
    <div class="mb-3">
        <label for="tahun_ajar_id" class="form-label fw-semibold">Tahun Ajar</label>
        <select class="form-select @error('tahun_ajar_id') is-invalid @enderror"
                id="tahun_ajar_id" name="tahun_ajar_id">
            <option value="">— Pilih tahun ajar —</option>
            @foreach ($tahunAjarList as $ta)
                <option value="{{ $ta->id }}"
                    {{ (int) old('tahun_ajar_id', $user->tahun_ajar_id ?? 0) === $ta->id ? 'selected' : '' }}>
                    {{ $ta->label }}
                </option>
            @endforeach
        </select>
        @error('tahun_ajar_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
        @if ($tahunAjarList->isEmpty())
            <div class="form-text text-danger">
                Belum ada tahun ajar.
                <a href="{{ route('admin.tahun-ajar.index') }}">Tambahkan dulu di Manajemen Tahun Ajar</a>.
            </div>
        @endif
    </div>
</div>

<hr class="my-4">

{{-- Password --}}
<div class="row">
    <div class="col-md-6 mb-3">
        <label for="password" class="form-label fw-semibold">Password</label>
        <input type="password" class="form-control @error('password') is-invalid @enderror"
               id="password" name="password" autocomplete="new-password"
               {{ $user ? '' : 'required' }}>
        @error('password')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
        <div class="form-text">
            {{ $user ? 'Kosongkan jika tidak ingin mengganti password.' : 'Minimal 8 karakter.' }}
        </div>
    </div>

    <div class="col-md-6 mb-3">
        <label for="password_confirmation" class="form-label fw-semibold">Konfirmasi Password</label>
        <input type="password" class="form-control" id="password_confirmation"
               name="password_confirmation" autocomplete="new-password" {{ $user ? '' : 'required' }}>
    </div>
</div>
