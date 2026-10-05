@extends('layouts.admin')

@section('title', 'Pengajuan Ubah NIM')
@section('page-title', 'Pengajuan Ubah NIM')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <p class="text-muted mb-0">Permintaan perubahan NIM yang diajukan mahasiswa</p>

    <ul class="nav nav-pills">
        @foreach (['menunggu' => 'Menunggu', 'disetujui' => 'Disetujui', 'ditolak' => 'Ditolak'] as $nilai => $label)
            <li class="nav-item">
                <a class="nav-link py-1 px-3 {{ $status === $nilai ? 'active' : '' }}"
                   style="{{ $status === $nilai ? 'background-color:#0d1b2a;' : 'color:#6c7a90;' }}"
                   href="{{ route('admin.pengajuan-nim.index', ['status' => $nilai]) }}">
                    {{ $label }}
                    @if ($nilai === 'menunggu' && $jumlahMenunggu)
                        <span class="badge rounded-pill bg-danger ms-1">{{ $jumlahMenunggu }}</span>
                    @endif
                </a>
            </li>
        @endforeach
    </ul>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-3">Mahasiswa</th>
                        <th style="width: 200px;">Perubahan NIM</th>
                        <th>Alasan</th>
                        <th style="width: 130px;">Diajukan</th>
                        <th style="width: 150px;" class="text-end pe-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pengajuanList as $p)
                        <tr>
                            <td class="ps-3">
                                <div class="fw-semibold">{{ $p->user->nama ?? $p->user->name }}</div>
                                <small class="text-muted">{{ $p->user->prodi->nama_prodi ?? '—' }}</small>
                            </td>
                            <td>
                                <span class="text-muted">{{ $p->nim_lama ?? '—' }}</span>
                                <i class="fas fa-arrow-right mx-1 text-muted small"></i>
                                <strong>{{ $p->nim_baru }}</strong>
                            </td>
                            <td class="small">
                                {{ $p->alasan }}
                                @if ($p->catatan_admin)
                                    <div class="text-muted mt-1">
                                        <i class="fas fa-reply fa-flip-vertical me-1"></i>{{ $p->catatan_admin }}
                                    </div>
                                @endif
                            </td>
                            <td class="text-muted small">{{ $p->created_at->format('d M Y') }}</td>
                            <td class="text-end pe-3">
                                @if ($p->isMenunggu())
                                    <form action="{{ route('admin.pengajuan-nim.setujui', $p->id) }}" method="POST"
                                          class="d-inline"
                                          onsubmit="return confirm('Setujui perubahan NIM menjadi {{ $p->nim_baru }}?')">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-sm btn-outline-success" title="Setujui">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </form>
                                    <button type="button" class="btn btn-sm btn-outline-danger"
                                            data-bs-toggle="modal" data-bs-target="#tolak{{ $p->id }}"
                                            title="Tolak">
                                        <i class="fas fa-times"></i>
                                    </button>
                                @else
                                    <div class="small">
                                        @if ($p->status === 'disetujui')
                                            <span class="badge bg-success">Disetujui</span>
                                        @else
                                            <span class="badge bg-danger">Ditolak</span>
                                        @endif
                                        <div class="text-muted mt-1">
                                            {{ $p->pemroses->nama ?? $p->pemroses->name ?? 'sistem' }}
                                        </div>
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="fas fa-inbox mb-2" style="font-size: 2rem;"></i>
                                <p class="mb-0">Tidak ada pengajuan berstatus "{{ $status }}".</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@if ($pengajuanList->hasPages())
    <div class="d-flex justify-content-center mt-4">
        {{ $pengajuanList->links() }}
    </div>
@endif

{{-- Modal tolak: alasan wajib diisi --}}
@foreach ($pengajuanList->where('status', 'menunggu') as $p)
    <div class="modal fade" id="tolak{{ $p->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form class="modal-content" action="{{ route('admin.pengajuan-nim.tolak', $p->id) }}" method="POST">
                @csrf
                @method('PATCH')

                <div class="modal-header">
                    <h6 class="modal-title fw-bold">Tolak Pengajuan</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>

                <div class="modal-body">
                    <p class="small text-muted">
                        {{ $p->user->nama ?? $p->user->name }} mengajukan
                        {{ $p->nim_lama ?? '—' }} &rarr; <strong>{{ $p->nim_baru }}</strong>.
                    </p>

                    <label for="catatan{{ $p->id }}" class="form-label fw-semibold">Alasan Penolakan</label>
                    <textarea class="form-control" id="catatan{{ $p->id }}" name="catatan_admin"
                              rows="3" required
                              placeholder="Alasan ini ditampilkan ke mahasiswa"></textarea>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Tolak Pengajuan</button>
                </div>
            </form>
        </div>
    </div>
@endforeach

@endsection
