@extends('layouts.admin')

@section('title', 'Cashback')
@section('page-title', 'Pengajuan Cashback')

@section('content')

{{-- Ringkasan --}}
<div class="row g-3 mb-3">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="text-muted small">Menunggu verifikasi</div>
                <div class="fs-4 fw-bold">{{ $jumlah['menunggu'] }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="text-muted small">Siap dibayar</div>
                <div class="fs-4 fw-bold">{{ $jumlah['diverifikasi'] }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="text-muted small">Belum dibayar</div>
                <div class="fs-5 fw-bold text-warning">
                    Rp {{ number_format($totalTerutang, 0, ',', '.') }}
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="text-muted small">Total sudah dibayar</div>
                <div class="fs-5 fw-bold text-success">
                    Rp {{ number_format($totalDibayar, 0, ',', '.') }}
                </div>
            </div>
        </div>
    </div>
</div>

<div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
    <ul class="nav nav-pills">
        @foreach (['menunggu' => 'Menunggu', 'diverifikasi' => 'Siap Dibayar', 'dibayar' => 'Dibayar', 'ditolak' => 'Ditolak'] as $nilai => $label)
            <li class="nav-item">
                <a class="nav-link py-1 px-3 {{ $status === $nilai ? 'active' : '' }}"
                   style="{{ $status === $nilai ? 'background-color:#0d1b2a;' : 'color:#6c7a90;' }}"
                   href="{{ route('admin.cashback.index', array_filter([
                        'status' => $nilai,
                        'tahun_ajar_id' => $periode,
                        'q' => request('q'),
                   ])) }}">
                    {{ $label }}
                    @if ($jumlah[$nilai] > 0 && in_array($nilai, ['menunggu', 'diverifikasi'], true))
                        <span class="badge rounded-pill bg-danger ms-1">{{ $jumlah[$nilai] }}</span>
                    @endif
                </a>
            </li>
        @endforeach
    </ul>

    <form method="GET" action="{{ route('admin.cashback.index') }}" class="d-flex gap-2">
        <input type="hidden" name="status" value="{{ $status }}">

        <select class="form-select form-select-sm" name="tahun_ajar_id" style="width: 190px;"
                onchange="this.form.submit()">
            <option value="">Semua periode</option>
            @foreach ($periodeList as $p)
                <option value="{{ $p->id }}" {{ (int) $periode === $p->id ? 'selected' : '' }}>
                    {{ $p->label }}
                </option>
            @endforeach
        </select>

        <input type="text" class="form-control form-control-sm" name="q" value="{{ request('q') }}"
               placeholder="Cari nama atau NIM" style="width: 200px;">

        <button type="submit" class="btn btn-sm btn-outline-secondary" title="Terapkan filter">
            <i class="fas fa-search"></i>
        </button>

        @if ($periode || request('q'))
            <a href="{{ route('admin.cashback.index', ['status' => $status]) }}"
               class="btn btn-sm btn-outline-secondary" title="Bersihkan filter">
                <i class="fas fa-xmark"></i>
            </a>
        @endif
    </form>
</div>

@if ($periode && $periodeList->firstWhere('id', (int) $periode))
    <p class="text-muted small mb-3">
        <i class="fas fa-filter me-1"></i>
        Angka ringkasan dan jumlah di tiap tab dihitung hanya untuk periode
        <strong>{{ $periodeList->firstWhere('id', (int) $periode)->label }}</strong>.
    </p>
@endif

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-3">Mahasiswa</th>
                        <th style="width: 150px;">Periode</th>
                        <th style="width: 120px;">Jumlah</th>
                        <th>Tujuan Transfer</th>
                        <th style="width: 170px;" class="text-end pe-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pengajuanList as $p)
                        <tr>
                            <td class="ps-3">
                                <div class="fw-semibold">{{ $p->user->nama ?? $p->user->name }}</div>
                                <small class="text-muted">
                                    {{ $p->user->nim ?? '—' }} · {{ $p->user->prodi->nama_prodi ?? '—' }}
                                </small>
                            </td>
                            <td class="small">{{ $p->tahunAjar->label }}</td>
                            <td class="fw-semibold">{{ $p->jumlah_rupiah }}</td>
                            <td class="small">
                                <span class="badge bg-light text-dark border me-1">
                                    {{ $p->metode === 'ewallet' ? 'E-Wallet' : 'Bank' }}
                                </span>
                                <strong>{{ $p->penyedia }}</strong> {{ $p->nomor }}
                                <div class="text-muted">a.n. {{ $p->atas_nama }}</div>

                                @if ($p->catatan)
                                    <div class="text-muted mt-1"><em>{{ $p->catatan }}</em></div>
                                @endif
                                @if ($p->catatan_admin)
                                    <div class="text-muted mt-1">
                                        <i class="fas fa-reply fa-flip-vertical me-1"></i>{{ $p->catatan_admin }}
                                    </div>
                                @endif
                            </td>
                            <td class="text-end pe-3">
                                @if ($p->isMenunggu())
                                    <form action="{{ route('admin.cashback.verifikasi', $p->id) }}" method="POST"
                                          class="d-inline"
                                          onsubmit="return confirm('Data rekening sudah dicek dan benar?')">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-sm btn-outline-primary"
                                                title="Verifikasi data rekening">
                                            <i class="fas fa-user-check"></i>
                                        </button>
                                    </form>
                                    <button type="button" class="btn btn-sm btn-outline-danger"
                                            data-bs-toggle="modal" data-bs-target="#tolak{{ $p->id }}" title="Tolak">
                                        <i class="fas fa-times"></i>
                                    </button>
                                @elseif ($p->isDiverifikasi())
                                    <button type="button" class="btn btn-sm btn-success"
                                            data-bs-toggle="modal" data-bs-target="#bayar{{ $p->id }}">
                                        <i class="fas fa-upload me-1"></i>Bukti
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-danger"
                                            data-bs-toggle="modal" data-bs-target="#tolak{{ $p->id }}" title="Tolak">
                                        <i class="fas fa-times"></i>
                                    </button>
                                @elseif ($p->isDibayar())
                                    <a href="{{ route('admin.cashback.bukti', $p->id) }}"
                                       class="btn btn-sm btn-outline-success">
                                        <i class="fas fa-file-invoice-dollar me-1"></i>Bukti
                                    </a>
                                    <div class="text-muted small mt-1">
                                        {{ $p->dibayar_pada?->format('d M Y') }}
                                    </div>
                                @else
                                    <span class="badge bg-danger">Ditolak</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="fas fa-receipt mb-2" style="font-size: 2rem;"></i>
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

{{-- Modal unggah bukti pembayaran --}}
@foreach ($pengajuanList->where('status', 'diverifikasi') as $p)
    <div class="modal fade" id="bayar{{ $p->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form class="modal-content" action="{{ route('admin.cashback.bayar', $p->id) }}"
                  method="POST" enctype="multipart/form-data">
                @csrf

                <div class="modal-header">
                    <h6 class="modal-title fw-bold">Unggah Bukti Pembayaran</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>

                <div class="modal-body">
                    <div class="alert alert-light border small">
                        <div><strong>{{ $p->user->nama ?? $p->user->name }}</strong> · {{ $p->tahunAjar->label }}</div>
                        <div class="mt-1">Transfer <strong>{{ $p->jumlah_rupiah }}</strong> ke:</div>
                        <div class="mt-1">{{ $p->tujuan }}</div>
                    </div>

                    <div class="mb-3">
                        <label for="bukti{{ $p->id }}" class="form-label fw-semibold">Bukti Transfer</label>
                        <input type="file" class="form-control" id="bukti{{ $p->id }}" name="bukti"
                               accept=".jpg,.jpeg,.png,.webp,.pdf" required>
                        <div class="form-text">JPG, PNG, WebP, atau PDF. Maksimal 4 MB.</div>
                    </div>

                    <div class="mb-1">
                        <label for="catatanBayar{{ $p->id }}" class="form-label fw-semibold">
                            Catatan <span class="badge bg-light text-muted fw-normal">opsional</span>
                        </label>
                        <textarea class="form-control" id="catatanBayar{{ $p->id }}"
                                  name="catatan_admin" rows="2"></textarea>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-check me-1"></i>Tandai Sudah Dibayar
                    </button>
                </div>
            </form>
        </div>
    </div>
@endforeach

{{-- Modal tolak --}}
@foreach ($pengajuanList->whereIn('status', ['menunggu', 'diverifikasi']) as $p)
    <div class="modal fade" id="tolak{{ $p->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form class="modal-content" action="{{ route('admin.cashback.tolak', $p->id) }}" method="POST">
                @csrf
                @method('PATCH')

                <div class="modal-header">
                    <h6 class="modal-title fw-bold">Tolak Pengajuan</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>

                <div class="modal-body">
                    <p class="small text-muted">
                        {{ $p->user->nama ?? $p->user->name }} · {{ $p->jumlah_rupiah }} · {{ $p->tahunAjar->label }}
                    </p>

                    <label for="catatanTolak{{ $p->id }}" class="form-label fw-semibold">Alasan Penolakan</label>
                    <textarea class="form-control" id="catatanTolak{{ $p->id }}" name="catatan_admin"
                              rows="3" required
                              placeholder="Alasan ini ditampilkan ke mahasiswa"></textarea>
                    <div class="form-text">Mahasiswa bisa mengajukan ulang untuk periode yang sama setelah ditolak.</div>
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
