@extends('layouts.admin')

@section('title', 'Bantuan Pendanaan')
@section('page-title', 'Pengajuan Bantuan Pendanaan')

@section('content')

<div class="mb-4">
    <p class="text-muted mb-0">Daftar pengajuan bantuan pendanaan beserta berkas administrasi pemohon</p>
</div>

{{-- Ringkasan --}}
<div class="row g-3 mb-4">
    @php
        $kartu = [
            ['label' => 'Total Pengajuan', 'nilai' => $jumlah['total'], 'warna' => 'primary', 'icon' => 'fa-file-lines', 'status' => null],
            ['label' => 'Menunggu Verifikasi', 'nilai' => $jumlah['pending'], 'warna' => 'warning', 'icon' => 'fa-hourglass-half', 'status' => 'pending'],
            ['label' => 'Terverifikasi', 'nilai' => $jumlah['verified'], 'warna' => 'success', 'icon' => 'fa-circle-check', 'status' => 'verified'],
            ['label' => 'Ditolak', 'nilai' => $jumlah['rejected'], 'warna' => 'danger', 'icon' => 'fa-circle-xmark', 'status' => 'rejected'],
        ];
    @endphp
    @foreach ($kartu as $k)
        <div class="col-6 col-lg-3">
            <a href="{{ route('admin.bantuan.index', array_filter(['status' => $k['status'], 'urut' => $urutan])) }}"
               class="text-decoration-none">
                <div class="card border-0 shadow-sm h-100 {{ $statusAktif === $k['status'] && $k['status'] ? 'border-start border-4 border-' . $k['warna'] : '' }}">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                            <div class="text-muted small">{{ $k['label'] }}</div>
                            <div class="fs-4 fw-bold text-dark">{{ $k['nilai'] }}</div>
                        </div>
                        <i class="fas {{ $k['icon'] }} fa-2x text-{{ $k['warna'] }} opacity-50"></i>
                    </div>
                </div>
            </a>
        </div>
    @endforeach
</div>

{{-- Urutan --}}
<div class="d-flex align-items-center gap-2 mb-3">
    <span class="text-muted small">Urutkan:</span>
    <a href="{{ route('admin.bantuan.index', array_filter(['status' => $statusAktif, 'urut' => 'ip'])) }}"
       class="btn btn-sm {{ $urutan === 'ip' ? 'btn-primary' : 'btn-outline-secondary' }}">
        <i class="fas fa-ranking-star me-1"></i>Peringkat IP
    </a>
    <a href="{{ route('admin.bantuan.index', array_filter(['status' => $statusAktif, 'urut' => 'terbaru'])) }}"
       class="btn btn-sm {{ $urutan !== 'ip' ? 'btn-primary' : 'btn-outline-secondary' }}">
        <i class="fas fa-clock me-1"></i>Terbaru
    </a>
    @if ($statusAktif)
        <a href="{{ route('admin.bantuan.index', ['urut' => $urutan]) }}" class="btn btn-sm btn-outline-dark ms-auto">
            <i class="fas fa-times me-1"></i>Hapus filter status
        </a>
    @endif
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-3" style="width: 60px;">{{ $urutan === 'ip' ? 'Rank' : '#' }}</th>
                        <th>Pemohon</th>
                        <th>Prodi</th>
                        <th style="width: 90px;" class="text-center">IP Sem 1</th>
                        <th style="width: 170px;">Berkas</th>
                        <th style="width: 150px;">Status</th>
                        <th style="width: 130px;">Masuk</th>
                        <th style="width: 90px;" class="text-end pe-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pengajuan as $index => $p)
                        <tr>
                            <td class="ps-3 text-muted fw-semibold">
                                {{ $pengajuan->firstItem() + $index }}
                            </td>
                            <td>
                                <div class="fw-semibold">{{ $p->nama_lengkap }}</div>
                                <div class="small text-muted">NIM {{ $p->nim }}</div>
                                <div class="small">
                                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $p->whatsapp) }}" target="_blank"
                                       rel="noopener noreferrer" class="text-decoration-none">
                                        <i class="fab fa-whatsapp text-success me-1"></i>{{ $p->whatsapp }}
                                    </a>
                                    <span class="text-muted mx-1">·</span>
                                    <a href="mailto:{{ $p->email }}" class="text-decoration-none text-muted">{{ $p->email }}</a>
                                </div>
                                @if ($p->catatan)
                                    <div class="small text-muted fst-italic mt-1">"{{ \Illuminate\Support\Str::limit($p->catatan, 90) }}"</div>
                                @endif
                            </td>
                            <td class="small">{{ $p->prodi }}</td>
                            <td class="text-center fw-bold">{{ number_format((float) $p->ip_semester_1, 2) }}</td>
                            <td>
                                <a href="{{ route('admin.bantuan.berkas', [$p->id, 'transkrip']) }}"
                                   class="btn btn-sm btn-outline-primary mb-1" title="{{ $p->transkrip_nama }}">
                                    <i class="fas fa-file-lines me-1"></i>Transkrip
                                </a>
                                <a href="{{ route('admin.bantuan.berkas', [$p->id, 'motivasi']) }}"
                                   class="btn btn-sm btn-outline-warning" title="{{ $p->motivasi_nama }}">
                                    <i class="fas fa-pen-fancy me-1"></i>Motivasi
                                </a>
                            </td>
                            <td>
                                <form action="{{ route('admin.bantuan.status', $p->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                                        <option value="pending" @selected($p->status === 'pending')>Menunggu Verifikasi</option>
                                        <option value="verified" @selected($p->status === 'verified')>Terverifikasi</option>
                                        <option value="rejected" @selected($p->status === 'rejected')>Ditolak</option>
                                    </select>
                                </form>
                            </td>
                            <td class="text-muted small">{{ $p->created_at->format('d M Y H:i') }}</td>
                            <td class="text-end pe-3">
                                <form action="{{ route('admin.bantuan.destroy', $p->id) }}" method="POST"
                                      class="d-inline" onsubmit="return confirm('Hapus pengajuan ini beserta berkasnya?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-5 text-muted">
                                <i class="fas fa-inbox mb-2" style="font-size: 2rem;"></i>
                                <p class="mb-0">Belum ada pengajuan bantuan pendanaan.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@if ($pengajuan->hasPages())
    <div class="d-flex justify-content-center mt-4">
        {{ $pengajuan->links() }}
    </div>
@endif

@endsection
