@extends('layouts.akun')

@section('title', 'Cashback')

@section('content')

<div class="row g-3">
    {{-- Form pengajuan --}}
    <div class="col-lg-5">
        <div class="card border-0">
            <div class="card-body p-4">
                <h6 class="fw-bold mb-1">Ajukan Cashback</h6>
                <p class="text-muted small mb-3">
                    Nominal cashback ditetapkan per periode oleh kampus, jadi Anda tidak perlu mengisi jumlahnya.
                </p>

                @if ($periodeTersedia->isEmpty())
                    <div class="alert alert-light border small mb-0">
                        <i class="fas fa-circle-info me-1 text-muted"></i>
                        Tidak ada periode yang bisa diajukan saat ini. Ini terjadi kalau belum ada periode
                        yang membuka cashback, atau Anda sudah mengajukan untuk semua periode yang tersedia.
                    </div>
                @else
                    <form action="{{ route('cashback.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="tahun_ajar_id" class="form-label fw-semibold">Periode</label>
                            <select class="form-select @error('tahun_ajar_id') is-invalid @enderror"
                                    id="tahun_ajar_id" name="tahun_ajar_id" required>
                                <option value="">— Pilih periode —</option>
                                @foreach ($periodeTersedia as $p)
                                    <option value="{{ $p->id }}" data-nominal="{{ $p->nominal_rupiah }}"
                                        {{ (int) old('tahun_ajar_id') === $p->id ? 'selected' : '' }}>
                                        {{ $p->label }} — {{ $p->nominal_rupiah }}
                                    </option>
                                @endforeach
                            </select>
                            @error('tahun_ajar_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="metode" class="form-label fw-semibold">Metode Pencairan</label>
                            <select class="form-select @error('metode') is-invalid @enderror"
                                    id="metode" name="metode" required>
                                <option value="bank" {{ old('metode', 'bank') === 'bank' ? 'selected' : '' }}>
                                    Transfer Bank
                                </option>
                                <option value="ewallet" {{ old('metode') === 'ewallet' ? 'selected' : '' }}>
                                    E-Wallet
                                </option>
                            </select>
                            @error('metode')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="penyedia" class="form-label fw-semibold">
                                <span data-label-penyedia>Nama Bank</span>
                            </label>
                            <select class="form-select @error('penyedia') is-invalid @enderror"
                                    id="penyedia" name="penyedia" required>
                                <option value="">— Pilih —</option>
                            </select>
                            @error('penyedia')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="nomor" class="form-label fw-semibold">
                                <span data-label-nomor>Nomor Rekening</span>
                            </label>
                            <input type="text" inputmode="numeric"
                                   class="form-control @error('nomor') is-invalid @enderror"
                                   id="nomor" name="nomor" value="{{ old('nomor') }}" required>
                            @error('nomor')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="atas_nama" class="form-label fw-semibold">Atas Nama</label>
                            <input type="text" class="form-control @error('atas_nama') is-invalid @enderror"
                                   id="atas_nama" name="atas_nama" value="{{ old('atas_nama') }}" required>
                            @error('atas_nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                Harus sesuai nama pemilik rekening, kalau tidak transfer bisa gagal.
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="catatan" class="form-label fw-semibold">
                                Catatan <span class="badge bg-light text-muted fw-normal">opsional</span>
                            </label>
                            <textarea class="form-control @error('catatan') is-invalid @enderror"
                                      id="catatan" name="catatan" rows="2">{{ old('catatan') }}</textarea>
                            @error('catatan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-gold w-100">
                            <i class="fas fa-paper-plane me-2"></i>Kirim Pengajuan
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>

    {{-- Riwayat --}}
    <div class="col-lg-7">
        <div class="card border-0">
            <div class="card-body p-4">
                <h6 class="fw-bold mb-3">Riwayat Pengajuan</h6>

                @forelse ($pengajuanList as $p)
                    <div class="border rounded p-3 mb-2">
                        <div class="d-flex justify-content-between align-items-start gap-3 mb-2">
                            <div>
                                <div class="fw-semibold">
                                    {{ $p->jumlah_rupiah }}
                                    <span class="text-muted fw-normal small">· {{ $p->tahunAjar->label }}</span>
                                </div>
                                <div class="small text-muted">{{ $p->tujuan }}</div>
                            </div>
                            <span class="badge bg-{{ $p->statusWarna() }} {{ $p->statusWarna() === 'warning' ? 'text-dark' : '' }}">
                                {{ $p->statusLabel() }}
                            </span>
                        </div>

                        @if ($p->catatan_admin)
                            <div class="small text-muted mb-2">
                                <i class="fas fa-reply fa-flip-vertical me-1"></i>{{ $p->catatan_admin }}
                            </div>
                        @endif

                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted">
                                Diajukan {{ $p->created_at->format('d M Y') }}
                                @if ($p->dibayar_pada)
                                    · dibayar {{ $p->dibayar_pada->format('d M Y') }}
                                @endif
                            </small>

                            <div class="d-flex gap-2">
                                @if ($p->isDibayar() && $p->bukti_path)
                                    <a href="{{ route('cashback.bukti', $p->id) }}"
                                       class="btn btn-sm btn-outline-success">
                                        <i class="fas fa-file-invoice-dollar me-1"></i>Bukti Transfer
                                    </a>
                                @endif

                                @if ($p->isMenunggu())
                                    <form action="{{ route('cashback.batal', $p->id) }}" method="POST"
                                          onsubmit="return confirm('Batalkan pengajuan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">Batalkan</button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-5 text-muted">
                        <i class="fas fa-receipt mb-2" style="font-size: 2rem;"></i>
                        <p class="mb-0">Belum ada pengajuan cashback.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
// Daftar penyedia mengikuti metode yang dipilih.
const PENYEDIA = {
    bank: @json($daftarBank),
    ewallet: @json($daftarEwallet),
};

document.addEventListener('DOMContentLoaded', function () {
    const metode = document.getElementById('metode');
    if (!metode) return;

    const penyedia = document.getElementById('penyedia');
    const labelPenyedia = document.querySelector('[data-label-penyedia]');
    const labelNomor = document.querySelector('[data-label-nomor]');
    const nomor = document.getElementById('nomor');
    const terpilih = @json(old('penyedia'));

    function isiPenyedia() {
        const ewallet = metode.value === 'ewallet';

        labelPenyedia.textContent = ewallet ? 'Nama E-Wallet' : 'Nama Bank';
        labelNomor.textContent = ewallet ? 'Nomor HP Terdaftar' : 'Nomor Rekening';
        nomor.placeholder = ewallet ? '08123456789' : '1234567890';

        penyedia.innerHTML = '<option value="">— Pilih —</option>';
        PENYEDIA[metode.value].forEach(function (nama) {
            const opt = document.createElement('option');
            opt.value = nama;
            opt.textContent = nama;
            if (nama === terpilih) opt.selected = true;
            penyedia.appendChild(opt);
        });
    }

    metode.addEventListener('change', isiPenyedia);
    isiPenyedia();
});
</script>
@endsection
