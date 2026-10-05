@extends('layouts.admin')

@section('title', 'Impor Peserta')
@section('page-title', 'Impor Peserta dari Excel')

@section('content')

{{-- Daftar kesalahan per baris --}}
@if (session('importErrors'))
    @php $galat = session('importErrors'); @endphp
    <div class="card border-0 shadow-sm mb-3 border-start border-danger border-4">
        <div class="card-body">
            <h6 class="fw-bold text-danger mb-2">
                <i class="fas fa-triangle-exclamation me-2"></i>{{ count($galat) }} baris bermasalah
            </h6>
            <p class="text-muted small mb-2">
                Tidak ada data yang tersimpan. Perbaiki baris berikut lalu unggah ulang berkasnya.
            </p>
            <ul class="small mb-0" style="max-height: 320px; overflow-y: auto;">
                @foreach ($galat as $pesan)
                    <li>{{ $pesan }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif

<div class="row g-3">
    {{-- Langkah 1: unduh template --}}
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body p-4">
                <h6 class="fw-bold mb-3">
                    <span class="badge rounded-pill me-2"
                          style="background-color:#0d1b2a;color:#f0c040;">1</span>
                    Unduh Template
                </h6>

                <p class="text-muted small">
                    Template berisi dropdown Program Studi dan Tahun Ajar yang diambil langsung dari data sistem
                    saat ini, jadi isiannya dijamin cocok.
                </p>

                @if ($tahunAjarList->isEmpty())
                    <div class="alert alert-warning small mb-3">
                        <i class="fas fa-triangle-exclamation me-1"></i>
                        Belum ada tahun ajar, dropdown-nya akan kosong.
                        <a href="{{ route('admin.tahun-ajar.index') }}" class="fw-semibold">Tambahkan dulu</a>.
                    </div>
                @endif

                <a href="{{ route('admin.users.import.template') }}"
                   class="btn btn-gold w-100 mb-3 {{ $tahunAjarList->isEmpty() ? 'disabled' : '' }}">
                    <i class="fas fa-file-excel me-2"></i>Unduh Template .xlsx
                </a>

                <div class="small">
                    <div class="fw-semibold mb-1">Program Studi ({{ $prodiList->count() }})</div>
                    <p class="text-muted mb-3">{{ $prodiList->pluck('nama_prodi')->join(', ') ?: '—' }}</p>

                    <div class="fw-semibold mb-1">Tahun Ajar ({{ $tahunAjarList->count() }})</div>
                    <p class="text-muted mb-0">
                        {{ $tahunAjarList->map(fn ($ta) => $ta->label)->join(', ') ?: '—' }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    {{-- Langkah 2: unggah --}}
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body p-4 d-flex flex-column">
                <h6 class="fw-bold mb-3">
                    <span class="badge rounded-pill me-2"
                          style="background-color:#0d1b2a;color:#f0c040;">2</span>
                    Unggah Berkas Terisi
                </h6>

                <form action="{{ route('admin.users.import.store') }}" method="POST"
                      enctype="multipart/form-data" class="d-flex flex-column flex-grow-1">
                    @csrf

                    <div class="mb-3">
                        <label for="file" class="form-label fw-semibold">Berkas</label>
                        <input type="file" class="form-control @error('file') is-invalid @enderror"
                               id="file" name="file" accept=".xlsx,.xls,.csv" required>
                        @error('file')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Format .xlsx, .xls, atau .csv. Maksimal 5 MB.</div>
                    </div>

                    <ul class="small text-muted ps-3 mb-4">
                        <li>Semua peserta diimpor dengan role <strong>mahasiswa</strong>.</li>
                        <li>Password kosong berarti <strong>NIM dipakai sebagai password awal</strong>.</li>
                        <li>Baris kosong diabaikan. Maksimal 2.000 baris sekali impor.</li>
                        <li>
                            Bersifat <strong>semua-atau-tidak</strong>: satu baris salah membatalkan
                            seluruh impor, dan semua kesalahan dilaporkan sekaligus.
                        </li>
                    </ul>

                    <div class="mt-auto d-flex justify-content-between">
                        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Kembali
                        </a>
                        <button type="submit" class="btn btn-gold">
                            <i class="fas fa-upload me-2"></i>Impor Sekarang
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
