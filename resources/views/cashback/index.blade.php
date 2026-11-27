@extends('layouts.admin')

@section('title', 'Cashback')
@section('page-title', 'Cashback')

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

                {{-- Cashback hanya bisa diterima sekali. Saat sudah disetujui atau masih
                     diproses, formulirnya tidak ditampilkan sama sekali — menampilkan
                     formulir yang pasti ditolak hanya membuat mahasiswa mengisi sia-sia. --}}
                @if ($klaimPengunci && in_array($klaimPengunci->status, \App\Models\PengajuanCashback::STATUS_DISETUJUI, true))
                    <div class="alert alert-success border-0 small mb-0">
                        <i class="fas fa-circle-check me-1"></i>
                        <strong>Cashback Anda sudah disetujui.</strong>
                        Cashback hanya dapat diterima satu kali, jadi pengajuan baru tidak diperlukan lagi.
                        Rinciannya ada di daftar di bawah.
                    </div>
                @elseif ($klaimPengunci)
                    <div class="alert alert-warning border-0 small mb-0">
                        <i class="fas fa-hourglass-half me-1"></i>
                        <strong>Pengajuan Anda sedang diproses.</strong>
                        Tunggu keputusan admin dulu sebelum mengajukan lagi. Statusnya bisa dilihat di bawah.
                    </div>
                @elseif (! $periode)
                    <div class="alert alert-light border small mb-0">
                        <i class="fas fa-circle-info me-1 text-muted"></i>
                        Data tahun ajar Anda belum terisi, sehingga cashback belum bisa diajukan.
                        Hubungi admin untuk melengkapinya.
                    </div>
                @elseif (! $periodeDibuka)
                    <div class="alert alert-light border small mb-0">
                        <i class="fas fa-circle-info me-1 text-muted"></i>
                        Cashback untuk periode <strong>{{ $periode->label }}</strong> belum dibuka.
                        Hubungi admin bila Anda merasa seharusnya sudah bisa mengajukan.
                    </div>
                @else
                    {{-- Konfirmasinya lewat modal, bukan dialog bawaan peramban:
                         dialog bawaan tidak bisa diatur tampilannya, memotong teks
                         panjang di sebagian peramban, dan terlihat asing dibanding
                         sisa panel. Isinya menyangkut jumlah uang, jadi harus terbaca. --}}
                    <form id="formCashback" action="{{ route('cashback.store') }}" method="POST">
                        @csrf

                        {{-- Periode ditampilkan, bukan dipilih. Ia sudah tertentu dari data
                             pendaftaran mahasiswa, jadi dropdown hanya membuka peluang salah
                             pilih tanpa memberi manfaat apa pun. --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Periode</label>
                            <div class="form-control bg-light d-flex justify-content-between align-items-center">
                                <span>{{ $periode->label }}</span>
                                <strong class="text-success">{{ $periode->nominal_rupiah }}</strong>
                            </div>
                            <div class="form-text">
                                Diambil dari periode pendaftaran Anda. Kalau keliru, hubungi admin.
                            </div>
                        </div>

                        {{-- Pencairan hanya lewat e-wallet, jadi tidak ada lagi pilihan
                             metode: menanyakan sesuatu yang jawabannya cuma satu hanya
                             menambah langkah tanpa memberi pilihan apa pun. --}}
                        <div class="mb-3">
                            <label for="penyedia" class="form-label fw-semibold">E-Wallet</label>
                            <select class="form-select @error('penyedia') is-invalid @enderror"
                                    id="penyedia" name="penyedia" required>
                                <option value="">— Pilih —</option>
                                @foreach ($daftarEwallet as $nama)
                                    <option value="{{ $nama }}" {{ old('penyedia') === $nama ? 'selected' : '' }}>
                                        {{ $nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('penyedia')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                Pencairan hanya melalui {{ implode(', ', $daftarEwallet) }}.
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="nomor" class="form-label fw-semibold">Nomor E-Wallet</label>
                            {{-- inputmode hanya memunculkan papan angka di ponsel, ia tidak
                                 menghalangi pengetikan huruf. Penyaringnya ada di skrip
                                 bawah, dan aturan sebenarnya ditegakkan di server. --}}
                            <input type="text" inputmode="numeric" autocomplete="tel"
                                   class="form-control @error('nomor') is-invalid @enderror"
                                   id="nomor" name="nomor" value="{{ old('nomor') }}"
                                   placeholder="08xxxxxxxxxx" maxlength="20" required
                                   data-hanya-angka>
                            @error('nomor')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                Nomor HP yang terdaftar di e-wallet tersebut. Angka saja.
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="atas_nama" class="form-label fw-semibold">Atas Nama</label>
                            <input type="text" class="form-control @error('atas_nama') is-invalid @enderror"
                                   id="atas_nama" name="atas_nama" value="{{ old('atas_nama') }}" required>
                            @error('atas_nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                Harus sama dengan nama Anda sendiri. Pengajuan dengan nama berbeda akan ditolak.
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

                        {{-- Nominalnya diambil dari periode, bukan ditulis tetap: besaran
                             cashback berbeda antarperiode, dan angka yang ditulis tetap
                             akan menyesatkan begitu periodenya berganti. --}}
                        <div class="alert alert-warning border-0 small d-flex gap-2 mb-3">
                            <i class="fas fa-circle-exclamation mt-1"></i>
                            <div>
                                <strong>Biaya transfer ditanggung penerima.</strong>
                                Cashback periode ini {{ $periode->nominal_rupiah }}, dan biaya
                                transfer dipotong dari jumlah itu — jadi yang masuk ke e-wallet
                                Anda sedikit lebih kecil, besarnya tergantung tarif penyedia.
                            </div>
                        </div>

                        {{-- Tombolnya membuka modal, bukan langsung mengirim. Pengiriman
                             sebenarnya dilakukan tombol di dalam modal, supaya pesan
                             tentang potongan biaya transfer pasti terbaca dulu. --}}
                        <button type="button" class="btn btn-gold w-100"
                                data-bs-toggle="modal" data-bs-target="#konfirmasiCashback">
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
                                    {{-- Membuka pratinjau, bukan mengunduh. Unduhan tetap
                                         tersedia dari dalam modalnya. --}}
                                    <button type="button" class="btn btn-sm btn-outline-success"
                                            data-bs-toggle="modal" data-bs-target="#bukti{{ $p->id }}">
                                        <i class="fas fa-file-invoice-dollar me-1"></i>Bukti Transfer
                                    </button>
                                @endif

                                @if ($p->isMenunggu())
                                    <button type="button" class="btn btn-sm btn-outline-danger"
                                            data-bs-toggle="modal" data-bs-target="#batal{{ $p->id }}">
                                        Batalkan
                                    </button>
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

{{-- Modal pratinjau bukti transfer.

     Gambar ditampilkan apa adanya; PDF lewat <object> yang punya penampil
     bawaan peramban. Kalau peramban tidak sanggup menampilkannya, isi
     cadangan di dalam <object> yang muncul, bukan halaman kosong. --}}
@foreach ($pengajuanList->where('status', 'dibayar')->where('bukti_path', '!=', null) as $p)
    <div class="modal fade" id="bukti{{ $p->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <div>
                        <h6 class="modal-title fw-bold">Bukti Transfer</h6>
                        <small class="text-muted">
                            {{ $p->jumlah_rupiah }} · {{ $p->dibayar_pada?->format('d M Y') }}
                        </small>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>

                <div class="modal-body text-center bg-light">
                    @if ($p->buktiGambar())
                        <img src="{{ route('cashback.bukti', $p->id) }}"
                             alt="Bukti transfer {{ $p->jumlah_rupiah }}"
                             class="img-fluid rounded" style="max-height: 70vh;">
                    @elseif ($p->buktiPdf())
                        <object data="{{ route('cashback.bukti', $p->id) }}"
                                type="application/pdf"
                                style="width: 100%; height: 70vh;">
                            <p class="text-muted small mb-0 py-4">
                                Peramban Anda tidak bisa menampilkan PDF di sini.
                                Gunakan tombol Unduh di bawah.
                            </p>
                        </object>
                    @else
                        <p class="text-muted small mb-0 py-4">
                            Berkas {{ $p->bukti_nama }} tidak bisa ditampilkan langsung.
                            Gunakan tombol Unduh di bawah.
                        </p>
                    @endif
                </div>

                <div class="modal-footer">
                    <a href="{{ route('cashback.bukti', [$p->id, 'unduh' => 1]) }}"
                       class="btn btn-outline-secondary">
                        <i class="fas fa-download me-1"></i>Unduh
                    </a>
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endforeach

{{-- Modal pembatalan, satu per pengajuan yang masih menunggu. --}}
@foreach ($pengajuanList->where('status', 'menunggu') as $p)
    <div class="modal fade" id="batal{{ $p->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <form class="modal-content" action="{{ route('cashback.batal', $p->id) }}" method="POST">
                @csrf
                @method('DELETE')

                <div class="modal-header">
                    <h6 class="modal-title fw-bold">Batalkan Pengajuan?</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>

                <div class="modal-body small">
                    Pengajuan <strong>{{ $p->jumlah_rupiah }}</strong> ke {{ $p->tujuan }} akan dibatalkan.
                    Anda masih bisa mengajukan lagi setelah ini.
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tidak</button>
                    <button type="submit" class="btn btn-danger">Ya, Batalkan</button>
                </div>
            </form>
        </div>
    </div>
@endforeach

{{-- Modal konfirmasi pengajuan.

     Diletakkan di luar form di atas, dan tombol kirimnya menunjuk ke form itu
     lewat atribut form="formCashback". Dengan begitu modal boleh berada di
     mana saja pada halaman tanpa membuat form bersarang. --}}
@if (! $klaimPengunci && $periode && $periodeDibuka)
    <div class="modal fade" id="konfirmasiCashback" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title fw-bold">Konfirmasi Pengajuan Cashback</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>

                <div class="modal-body">
                    <div class="d-flex justify-content-between align-items-baseline mb-3">
                        <span class="text-muted">Cashback periode {{ $periode->label }}</span>
                        <strong class="fs-5 text-success">{{ $periode->nominal_rupiah }}</strong>
                    </div>

                    <div class="alert alert-warning border-0 small mb-0 d-flex gap-2">
                        <i class="fas fa-circle-exclamation mt-1"></i>
                        <div>
                            <strong>Biaya transfer ditanggung penerima.</strong>
                            Jumlah yang masuk ke e-wallet Anda sedikit lebih kecil dari
                            {{ $periode->nominal_rupiah }}, besarnya tergantung tarif penyedia.
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" form="formCashback" class="btn btn-gold">
                        <i class="fas fa-paper-plane me-1"></i>Ya, Ajukan
                    </button>
                </div>
            </div>
        </div>
    </div>
@endif

@endsection

@section('scripts')
<script>
// Menyaring isian nomor agar hanya angka yang tersisa saat diketik maupun
// ditempel. Ini sekadar kenyamanan — aturan sebenarnya ditegakkan di server,
// karena penyaring di sisi peramban selalu bisa dilewati.
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('[data-hanya-angka]').forEach(function (isian) {
        isian.addEventListener('input', function () {
            // Posisi kursor dijaga, kalau tidak ia melompat ke ujung setiap
            // kali ada karakter yang dibuang di tengah.
            var posisi = isian.selectionStart;
            var sebelum = isian.value;
            var sesudah = sebelum.replace(/[^0-9]/g, '');

            if (sebelum === sesudah) return;

            isian.value = sesudah;
            isian.setSelectionRange(posisi - (sebelum.length - sesudah.length), posisi - (sebelum.length - sesudah.length));
        });
    });
});
</script>
@endsection
