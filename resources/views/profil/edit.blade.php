{{-- Admin tetap di dalam panel admin (lengkap dengan sidebar); mahasiswa pakai layout akun. --}}
@extends(auth()->user()->isAdmin() ? 'layouts.admin' : 'layouts.akun')

@section('title', 'Profil Saya')
@section('page-title', 'Profil Saya')

@section('styles')
<style>
    /* Avatar: foto kalau ada, kalau tidak inisial di atas latar gelap. */
    .avatar {
        width: 96px;
        height: 96px;
        border-radius: 50%;
        object-fit: cover;
        background-color: #0d1b2a;
        color: #f0c040;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        font-weight: 600;
        flex-shrink: 0;
    }
</style>
@endsection

@section('content')

<div class="row g-3">
    {{-- Ringkasan akun --}}
    <div class="col-lg-4">
        <div class="card border-0 mb-3">
            <div class="card-body p-4 text-center">
                @if ($user->foto_url)
                    <img src="{{ $user->foto_url }}" alt="Foto profil" class="avatar mx-auto mb-3">
                @else
                    <div class="avatar mx-auto mb-3">{{ $user->inisial }}</div>
                @endif

                <h6 class="fw-bold mb-1">{{ $user->nama ?? $user->name }}</h6>
                <p class="text-muted small mb-2">{{ $user->email ?? 'Tanpa email' }}</p>

                @if ($user->isAdmin())
                    <span class="badge rounded-pill" style="background-color:#0d1b2a;color:#f0c040;">Admin</span>
                @else
                    <span class="badge rounded-pill bg-light text-dark border">Mahasiswa</span>
                @endif

                @if ($user->foto_profil)
                    <form action="{{ route('profil.foto.hapus') }}" method="POST" class="mt-3"
                          onsubmit="return confirm('Hapus foto profil?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger">
                            <i class="fas fa-trash-alt me-1"></i>Hapus Foto
                        </button>
                    </form>
                @endif
            </div>
        </div>

        {{-- Data akademik, read-only --}}
        @if ($user->isMahasiswa())
            <div class="card border-0">
                <div class="card-body p-4">
                    <h6 class="fw-bold text-uppercase text-muted small mb-3">Data Akademik</h6>

                    <dl class="row small mb-0">
                        <dt class="col-5 text-muted fw-normal">NIM</dt>
                        <dd class="col-7 fw-semibold">{{ $user->nim ?? '—' }}</dd>

                        <dt class="col-5 text-muted fw-normal">Program Studi</dt>
                        <dd class="col-7">{{ $user->prodi->nama_prodi ?? '—' }}</dd>

                        <dt class="col-5 text-muted fw-normal">Tahun Ajar</dt>
                        <dd class="col-7 mb-0">{{ $user->tahunAjar->label ?? '—' }}</dd>
                    </dl>

                    <div class="alert alert-light border small mt-3 mb-0">
                        <i class="fas fa-lock me-1 text-muted"></i>
                        Data akademik hanya bisa diubah oleh admin.
                    </div>
                </div>
            </div>
        @endif
    </div>

    {{-- Form ubah profil --}}
    <div class="col-lg-8">
        <div class="card border-0 mb-3">
            <div class="card-body p-4">
                <h6 class="fw-bold mb-3">Ubah Profil</h6>

                <form action="{{ route('profil.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="nama" class="form-label fw-semibold">Nama Lengkap</label>
                        <input type="text" class="form-control @error('nama') is-invalid @enderror"
                               id="nama" name="nama"
                               value="{{ old('nama', $user->nama ?? $user->name) }}" required>
                        @error('nama')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label fw-semibold">
                            Email
                            @unless ($user->isAdmin())
                                <span class="badge bg-light text-muted fw-normal">opsional</span>
                            @endunless
                        </label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                               id="email" name="email" value="{{ old('email', $user->email) }}"
                               {{ $user->isAdmin() ? 'required' : '' }}>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        @if ($user->isAdmin())
                            <div class="form-text">Email ini yang Anda pakai untuk login.</div>
                        @endif
                    </div>

                    <div class="mb-4">
                        <label for="foto_profil" class="form-label fw-semibold">Foto Profil</label>
                        <input type="file" class="form-control @error('foto_profil') is-invalid @enderror"
                               id="foto_profil" name="foto_profil" accept="image/*">
                        @error('foto_profil')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">JPG, PNG, atau WebP. Maksimal 2 MB.</div>
                        <div id="pratinjauFoto" class="mt-2"></div>
                    </div>

                    <hr class="my-4">

                    <h6 class="fw-bold mb-1">Ganti Password</h6>
                    <p class="text-muted small mb-3">Kosongkan seluruhnya jika tidak ingin mengganti password.</p>

                    <div class="mb-3">
                        <label for="password_lama" class="form-label fw-semibold">Password Saat Ini</label>
                        <input type="password" class="form-control @error('password_lama') is-invalid @enderror"
                               id="password_lama" name="password_lama" autocomplete="current-password">
                        @error('password_lama')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="password" class="form-label fw-semibold">Password Baru</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                   id="password" name="password" autocomplete="new-password">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Minimal 8 karakter.</div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="password_confirmation" class="form-label fw-semibold">
                                Konfirmasi Password Baru
                            </label>
                            <input type="password" class="form-control" id="password_confirmation"
                                   name="password_confirmation" autocomplete="new-password">
                        </div>
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-gold">
                            <i class="fas fa-save me-2"></i>Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Pengajuan ubah NIM, khusus mahasiswa --}}
        @if ($user->isMahasiswa())
            <div class="card border-0">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-1">Pengajuan Perubahan NIM</h6>
                    <p class="text-muted small mb-3">
                        NIM tidak bisa Anda ubah sendiri. Ajukan perubahan di sini, admin yang akan memutuskan.
                    </p>

                    @if ($pengajuanMenunggu)
                        <div class="alert alert-warning mb-0">
                            <div class="d-flex justify-content-between align-items-start gap-3">
                                <div>
                                    <div class="fw-semibold mb-1">
                                        <i class="fas fa-hourglass-half me-1"></i>Menunggu keputusan admin
                                    </div>
                                    <div class="small">
                                        {{ $pengajuanMenunggu->nim_lama ?? '—' }}
                                        <i class="fas fa-arrow-right mx-1"></i>
                                        <strong>{{ $pengajuanMenunggu->nim_baru }}</strong>
                                    </div>
                                    <div class="small text-muted mt-1">
                                        Diajukan {{ $pengajuanMenunggu->created_at->format('d M Y H:i') }}
                                    </div>
                                </div>

                                <form action="{{ route('profil.ubah-nim.batal', $pengajuanMenunggu->id) }}"
                                      method="POST" onsubmit="return confirm('Batalkan pengajuan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Batalkan</button>
                                </form>
                            </div>
                        </div>
                    @else
                        <form action="{{ route('profil.ubah-nim') }}" method="POST">
                            @csrf

                            <div class="row">
                                <div class="col-md-5 mb-3">
                                    <label class="form-label fw-semibold">NIM Sekarang</label>
                                    <input type="text" class="form-control" value="{{ $user->nim ?? '—' }}" disabled>
                                </div>

                                <div class="col-md-7 mb-3">
                                    <label for="nim_baru" class="form-label fw-semibold">NIM Baru</label>
                                    <input type="text" class="form-control @error('nim_baru') is-invalid @enderror"
                                           id="nim_baru" name="nim_baru" value="{{ old('nim_baru') }}"
                                           placeholder="NIM yang diinginkan" required>
                                    @error('nim_baru')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="alasan" class="form-label fw-semibold">Alasan</label>
                                <textarea class="form-control @error('alasan') is-invalid @enderror"
                                          id="alasan" name="alasan" rows="3"
                                          placeholder="Jelaskan kenapa NIM perlu diubah">{{ old('alasan') }}</textarea>
                                @error('alasan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="text-end">
                                <button type="submit" class="btn btn-outline-primary">
                                    <i class="fas fa-paper-plane me-2"></i>Kirim Pengajuan
                                </button>
                            </div>
                        </form>
                    @endif

                    {{-- Riwayat --}}
                    @if ($riwayatPengajuan->isNotEmpty())
                        <hr class="my-4">
                        <h6 class="fw-bold text-uppercase text-muted small mb-3">Riwayat Pengajuan</h6>

                        <div class="table-responsive">
                            <table class="table table-sm align-middle mb-0 small">
                                <thead class="table-light">
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Perubahan</th>
                                        <th>Status</th>
                                        <th>Catatan Admin</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($riwayatPengajuan as $p)
                                        <tr>
                                            <td class="text-muted">{{ $p->created_at->format('d M Y') }}</td>
                                            <td>{{ $p->nim_lama ?? '—' }} &rarr; <strong>{{ $p->nim_baru }}</strong></td>
                                            <td>
                                                @if ($p->status === 'disetujui')
                                                    <span class="badge bg-success">Disetujui</span>
                                                @elseif ($p->status === 'ditolak')
                                                    <span class="badge bg-danger">Ditolak</span>
                                                @else
                                                    <span class="badge bg-warning text-dark">Menunggu</span>
                                                @endif
                                            </td>
                                            <td class="text-muted">{{ $p->catatan_admin ?? '—' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        @endif
    </div>
</div>

@endsection

@section('scripts')
<script>
    document.getElementById('foto_profil').addEventListener('change', function (e) {
        const pratinjau = document.getElementById('pratinjauFoto');
        pratinjau.innerHTML = '';

        if (e.target.files && e.target.files[0]) {
            const reader = new FileReader();
            reader.onload = function (ev) {
                const img = document.createElement('img');
                img.src = ev.target.result;
                img.className = 'rounded-circle shadow-sm';
                img.style.width = '96px';
                img.style.height = '96px';
                img.style.objectFit = 'cover';
                pratinjau.appendChild(img);
            };
            reader.readAsDataURL(e.target.files[0]);
        }
    });
</script>
@endsection
