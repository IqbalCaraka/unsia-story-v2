@extends('layouts.admin')

@section('title', 'Pengguna')
@section('page-title', 'Manajemen Pengguna')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <p class="text-muted mb-0">Kelola akun admin dan mahasiswa</p>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.users.import') }}" class="btn btn-outline-secondary">
            <i class="fas fa-file-excel me-2"></i>Impor Massal
        </a>
        <a href="{{ route('admin.users.create') }}" class="btn btn-gold">
            <i class="fas fa-user-plus me-2"></i>Tambah Pengguna
        </a>
    </div>
</div>

{{-- Filter --}}
<div class="card border-0 shadow-sm mb-3">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.users.index') }}" class="row g-2 align-items-end">
            <div class="col-md-5">
                <label for="q" class="form-label small fw-semibold mb-1">Cari</label>
                <input type="text" class="form-control" id="q" name="q" value="{{ request('q') }}"
                       placeholder="Nama, NIM, atau email">
            </div>
            <div class="col-md-3">
                <label for="filterRole" class="form-label small fw-semibold mb-1">Role</label>
                <select class="form-select" id="filterRole" name="role">
                    <option value="">Semua role</option>
                    <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="mahasiswa" {{ request('role') === 'mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                </select>
            </div>
            <div class="col-md-3">
                <label for="filterProdi" class="form-label small fw-semibold mb-1">Program Studi</label>
                <select class="form-select" id="filterProdi" name="prodi_id">
                    <option value="">Semua prodi</option>
                    @foreach ($prodiList as $prodi)
                        <option value="{{ $prodi->id }}"
                            {{ (int) request('prodi_id') === $prodi->id ? 'selected' : '' }}>
                            {{ $prodi->nama_prodi }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-1 d-grid">
                <button type="submit" class="btn btn-outline-secondary" title="Terapkan filter">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </form>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-3" style="width: 50px;">#</th>
                        <th>Nama</th>
                        <th style="width: 140px;">NIM</th>
                        <th style="width: 160px;">Program Studi</th>
                        <th style="width: 150px;">Tahun Ajar</th>
                        <th style="width: 110px;">Role</th>
                        <th style="width: 110px;" class="text-end pe-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $index => $user)
                        <tr>
                            <td class="ps-3 text-muted">{{ $users->firstItem() + $index }}</td>
                            <td>
                                <div class="fw-semibold">{{ $user->nama ?? $user->name }}</div>
                                <small class="text-muted">{{ $user->email ?? '—' }}</small>
                            </td>
                            <td class="text-muted">{{ $user->nim ?? '—' }}</td>
                            <td class="text-muted">{{ $user->prodi->nama_prodi ?? '—' }}</td>
                            <td class="text-muted small">{{ $user->tahunAjar->label ?? '—' }}</td>
                            <td>
                                @if ($user->isAdmin())
                                    <span class="badge rounded-pill"
                                          style="background-color: #0d1b2a; color: #f0c040;">Admin</span>
                                @else
                                    <span class="badge rounded-pill bg-light text-dark border">Mahasiswa</span>
                                @endif
                            </td>
                            <td class="text-end pe-3">
                                <a href="{{ route('admin.users.edit', $user->id) }}"
                                   class="btn btn-sm btn-outline-primary me-1" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @if ($user->id !== auth()->id())
                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                                          class="d-inline"
                                          onsubmit="return confirm('Hapus pengguna {{ $user->nama ?? $user->name }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                @else
                                    <button class="btn btn-sm btn-outline-secondary" disabled
                                            title="Akun Anda sendiri">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <i class="fas fa-users mb-2" style="font-size: 2rem;"></i>
                                <p class="mb-0">
                                    Belum ada pengguna yang cocok.
                                    <a href="{{ route('admin.users.create') }}">Tambah sekarang</a>
                                </p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@if ($users->hasPages())
    <div class="d-flex justify-content-center mt-4">
        {{ $users->links() }}
    </div>
@endif

@endsection
