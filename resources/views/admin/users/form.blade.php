@php
    $user = $user ?? null;
    $role = old('role', $user->role ?? 'mahasiswa');
@endphp

{{-- Role --}}
<div class="mb-3">
    <label for="role" class="form-label fw-semibold">Role</label>
    <select class="form-select @error('role') is-invalid @enderror" id="role" name="role" required>
        <option value="mahasiswa" {{ $role === 'mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
        <option value="downline" {{ $role === 'downline' ? 'selected' : '' }}>Downline</option>
        <option value="admin" {{ $role === 'admin' ? 'selected' : '' }}>Admin</option>
        <option value="superadmin" {{ $role === 'superadmin' ? 'selected' : '' }}>Super Admin</option>
    </select>
    @error('role')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
    <div class="form-text">
        <strong>Mahasiswa</strong> login memakai NIM, hanya bisa membuka profil dan cashback-nya sendiri.
        Wajib mengisi program studi dan tahun ajar.<br>
        <strong>Downline</strong> login memakai email. ID dan kode downline-nya
        dibuat otomatis. Tidak punya akses panel dan tidak menyimpan data akademik.<br>
        <strong>Admin</strong> login memakai email, mengelola konten panel tapi
        <em>tidak bisa</em> mengelola pengguna.<br>
        <strong>Super Admin</strong> sama seperti admin, ditambah wewenang menambah,
        mengubah, dan menghapus pengguna.
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

{{-- Data downline: hanya relevan untuk role downline --}}
<div id="blokDownline">
    <hr class="my-4">
    <h6 class="fw-bold text-uppercase text-muted small mb-3">Data Downline</h6>

    @php $dl = $user->downline ?? null; @endphp

    {{-- ID dan kode digenerate sistem, jadi ditampilkan saja, tidak diisi. --}}
    <div class="row mb-3">
        <div class="col-md-6">
            <label class="form-label fw-semibold">ID Downline</label>
            <input type="text" class="form-control bg-light" value="{{ $dl->id_downline ?? '' }}"
                   placeholder="dibuat otomatis saat disimpan" readonly disabled>
        </div>
        <div class="col-md-6">
            <label class="form-label fw-semibold">Kode Downline</label>
            <input type="text" class="form-control bg-light" value="{{ $dl->kode_downline ?? '' }}"
                   placeholder="dibuat otomatis saat disimpan" readonly disabled>
        </div>
    </div>

    {{-- Status --}}
    <div class="mb-3">
        <label for="status_downline" class="form-label fw-semibold">Status</label>
        <select class="form-select @error('status_downline') is-invalid @enderror"
                id="status_downline" name="status_downline">
            @php $statusTerpilih = old('status_downline', $dl->status ?? 'aktif'); @endphp
            <option value="aktif" {{ $statusTerpilih === 'aktif' ? 'selected' : '' }}>Aktif</option>
            <option value="tidak_aktif" {{ $statusTerpilih === 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif</option>
        </select>
        @error('status_downline')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
        <div class="form-text">
            ID dan kode downline dibuat otomatis sekali saja, lalu tidak berubah.
            Menonaktifkan downline tidak menghapus ID-nya.
        </div>
    </div>

    {{-- Sosial media --}}
    @php
        use App\Models\DownlineSocialMedia;

        // Setelah validasi gagal, pakai isian lama; kalau tidak, pakai yang
        // tersimpan. Satu baris kosong disiapkan supaya admin bisa langsung
        // mengisi tanpa menekan tombol tambah lebih dulu.
        $barisSosmed = old('social_media', $dl
            ? $dl->socialMedia->map(fn ($m) => ['platform' => $m->platform, 'akun' => $m->akun])->all()
            : []);

        if (empty($barisSosmed)) {
            $barisSosmed = [['platform' => 'instagram', 'akun' => '']];
        }
    @endphp

    <label class="form-label fw-semibold">Sosial Media</label>

    <div id="daftarSosmed">
        @foreach ($barisSosmed as $i => $baris)
            <div class="row g-2 mb-2 align-items-start" data-baris-sosmed>
                <div class="col-4">
                    <select class="form-select form-select-sm" name="social_media[{{ $i }}][platform]">
                        @foreach (DownlineSocialMedia::PLATFORM as $kunci => $meta)
                            <option value="{{ $kunci }}"
                                {{ ($baris['platform'] ?? '') === $kunci ? 'selected' : '' }}>
                                {{ $meta['label'] }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-7">
                    <input type="text" class="form-control form-control-sm
                                  @error("social_media.$i.akun") is-invalid @enderror"
                           name="social_media[{{ $i }}][akun]"
                           value="{{ $baris['akun'] ?? '' }}"
                           placeholder="username tanpa @, atau URL penuh untuk Blog">
                    @error("social_media.$i.akun")
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-1">
                    <button type="button" class="btn btn-sm btn-outline-danger w-100"
                            data-hapus-sosmed title="Hapus baris">&times;</button>
                </div>
            </div>
        @endforeach
    </div>

    <button type="button" class="btn btn-sm btn-outline-secondary" id="tambahSosmed">
        <i class="fas fa-plus"></i> Tambah Sosial Media
    </button>

    <div class="form-text mt-2">
        Boleh lebih dari satu, termasuk beberapa akun di platform yang sama.
        Tautan yang ditempel utuh akan dirapikan otomatis jadi username.
        Baris yang dibiarkan kosong tidak disimpan.
    </div>

    @if ($dl && $dl->socialMedia->isNotEmpty())
        <div class="mt-3">
            @foreach ($dl->socialMedia as $m)
                <a href="{{ $m->url() }}" target="_blank" rel="noopener"
                   class="badge rounded-pill bg-light text-dark border text-decoration-none me-1">
                    <i class="{{ $m->ikon() }}"></i> {{ $m->label() }}
                </a>
            @endforeach
        </div>
    @endif
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
