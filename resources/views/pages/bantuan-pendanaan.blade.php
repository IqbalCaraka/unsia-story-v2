@extends('layouts.app')

@section('title', 'Bantuan Pendanaan - UNSIA Story | Dana Bantuan Rp15 Juta')
@section('description', 'Program Bantuan Pendanaan UNSIA Story senilai Rp15 juta, khusus mahasiswa yang mendaftar dengan kode referral unsia.my.id. Seleksi setelah semester pertama berdasarkan peringkat IP, dengan syarat transkrip nilai dan lembar motivasi.')
@section('keywords', 'bantuan pendanaan unsia, beasiswa unsia, bantuan biaya kuliah, bantuan dana kuliah online, universitas siber asia, ip semester 1')
@section('og_image', asset('assets/images/logo-unsia-story.png'))

@section('hero')
    @include('partials.page-hero', ['title' => 'Bantuan Pendanaan', 'crumbs' => ['Bantuan Pendanaan' => null]])
@endsection

@section('content')

<!-- TOTAL BANTUAN -->
<section class="section-padding">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 col-md-12 wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.1s">
                <h4 style="color:#2c7aff;font-size:14px;letter-spacing:2px;text-transform:uppercase;margin-bottom:10px;">Program Bantuan</h4>
                <h2 style="font-weight:700;font-size:32px;margin-bottom:20px;">Bantuan Pendanaan untuk Mahasiswa Berprestasi</h2>
                <p style="color:#555;font-size:16px;line-height:1.8;margin-bottom:15px;">Program Bantuan Pendanaan disediakan untuk membantu meringankan biaya kuliah mahasiswa. Total dana bantuan yang disalurkan dalam program ini adalah <strong>Rp15.000.000</strong>.</p>
                <p style="color:#555;font-size:16px;line-height:1.8;margin-bottom:15px;">Seleksi penerima dilakukan <strong>setelah kamu menjalani semester pertama</strong>, dengan dasar penilaian berupa <strong>peringkat IP semester 1</strong>. Untuk ikut serta, kamu perlu mendaftarkan diri dan melaporkan syarat administrasi melalui halaman <a href="{{ route('bantuan.ajukan') }}" style="color:#2c7aff;font-weight:600;">Ajukan Bantuan Pendanaan</a>.</p>
                <div style="background:#fff3e0;border-left:4px solid #f0c040;border-radius:10px;padding:15px 20px;">
                    <p style="margin:0;color:#555;font-size:15px;line-height:1.8;"><strong><i class="fa-solid fa-circle-exclamation" style="color:#e65100;margin-right:6px;"></i>Khusus pengguna kode referral:</strong> program ini hanya bisa diajukan oleh mahasiswa yang mendaftar di UNSIA menggunakan kode referral <strong style="color:#2c7aff;">unsia.my.id</strong>.</p>
                </div>
                <div style="margin-top:25px;display:flex;gap:15px;flex-wrap:wrap;">
                    <a href="{{ route('bantuan.ajukan') }}" style="display:inline-flex;align-items:center;gap:8px;background:#2c7aff;color:#fff;padding:14px 28px;border-radius:50px;text-decoration:none;font-weight:700;font-size:15px;">
                        <i class="fa-solid fa-file-pen"></i> Ajukan Bantuan Pendanaan
                    </a>
                    <a href="https://wa.me/628133331686?text=Halo%2C%20saya%20ingin%20bertanya%20tentang%20Bantuan%20Pendanaan%20UNSIA" target="_blank" style="display:inline-flex;align-items:center;gap:8px;background:#25D366;color:#fff;padding:14px 28px;border-radius:50px;text-decoration:none;font-weight:700;font-size:15px;">
                        <i class="fa-brands fa-whatsapp"></i> Tanya via WA
                    </a>
                </div>
            </div>
            <div class="col-lg-6 col-md-12 text-center wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.2s">
                <div style="background:linear-gradient(135deg,#0d1b2a,#1a2d4a);border-radius:16px;padding:45px 30px;margin-top:25px;">
                    <p style="color:rgba(255,255,255,0.6);font-size:13px;text-transform:uppercase;letter-spacing:2px;margin-bottom:10px;">Total Bantuan</p>
                    <div style="background:linear-gradient(135deg,#f0c040,#e6a817);color:#0d1b2a;padding:22px 20px;border-radius:12px;font-size:38px;font-weight:800;letter-spacing:1px;margin-bottom:18px;">Rp15.000.000</div>
                    <p style="color:rgba(255,255,255,0.75);font-size:15px;line-height:1.8;margin:0;">Diseleksi setelah semester pertama<br>berdasarkan <strong style="color:#f0c040;">peringkat IP semester 1</strong></p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- SIAPA YANG BISA MENGAJUKAN -->
<section class="section-padding" style="background:#f8f9fa;">
    <div class="container">
        <div class="section-title text-center">
            <h4>Ketentuan Peserta</h4>
            <h1>Siapa yang Bisa Mengajukan?</h1>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10 wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.1s">
                <div style="background:#fff;border-radius:14px;padding:35px 30px;box-shadow:0 5px 20px rgba(0,0,0,0.06);text-align:center;">
                    <i class="fa-solid fa-ticket" style="font-size:38px;color:#f0c040;margin-bottom:15px;"></i>
                    <h3 style="font-weight:700;font-size:22px;margin-bottom:10px;">Mahasiswa Pengguna Kode Referral unsia.my.id</h3>
                    <p style="color:#555;font-size:16px;line-height:1.8;margin-bottom:20px;">Bantuan Pendanaan ini <strong>hanya berlaku bagi mahasiswa yang mendaftar di UNSIA menggunakan kode referral kami</strong>. Pastikan kode berikut sudah kamu masukkan saat mengisi biodata di pmb.unsia.ac.id:</p>
                    <div style="background:linear-gradient(135deg,#f0c040,#e6a817);color:#0d1b2a;padding:18px 25px;border-radius:12px;font-size:26px;font-weight:800;letter-spacing:2px;margin-bottom:20px;">unsia.my.id</div>
                    <div style="text-align:left;max-width:560px;margin:0 auto;">
                        <p style="color:#555;font-size:15px;line-height:2;margin:0;">
                            <i class="fa-solid fa-check" style="color:#2e7d32;margin-right:8px;"></i> Terdaftar sebagai mahasiswa UNSIA dengan kode referral <strong>unsia.my.id</strong><br>
                            <i class="fa-solid fa-check" style="color:#2e7d32;margin-right:8px;"></i> Telah menjalani semester pertama<br>
                            <i class="fa-solid fa-check" style="color:#2e7d32;margin-right:8px;"></i> Melengkapi syarat administrasi: transkrip nilai &amp; lembar motivasi
                        </p>
                    </div>
                    <p style="color:#888;font-size:13px;margin:20px 0 0;"><i class="fa-solid fa-circle-info" style="margin-right:5px;"></i> Pengajuan dari mahasiswa yang tidak menggunakan kode referral unsia.my.id tidak dapat diproses. Belum yakin? <a href="https://wa.me/628133331686?text=Halo%2C%20saya%20ingin%20cek%20apakah%20saya%20terdaftar%20dengan%20kode%20referral%20unsia.my.id" target="_blank" style="color:#2c7aff;font-weight:600;">Tanyakan ke tim kami</a>.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ALUR PROGRAM -->
<section class="section-padding">
    <div class="container">
        <div class="section-title text-center">
            <h4>Alur Program</h4>
            <h1>Cara Mendapatkan Bantuan Pendanaan</h1>
        </div>
        <div class="row">
            @php
                $alur = [
                    ['no' => 1, 'icon' => 'fa-graduation-cap', 'judul' => 'Daftar Pakai Kode Referral', 'teks' => 'Mendaftar di UNSIA dengan kode referral unsia.my.id, lalu menjalani semester pertama — karena penilaian memakai IP semester 1.'],
                    ['no' => 2, 'icon' => 'fa-file-pen', 'judul' => 'Daftarkan Diri', 'teks' => 'Isi formulir pengajuan di halaman Ajukan Bantuan Pendanaan dengan data diri dan data akademik kamu.'],
                    ['no' => 3, 'icon' => 'fa-folder-open', 'judul' => 'Laporkan Syarat Administrasi', 'teks' => 'Unggah transkrip nilai semester 1 dan lembar motivasi pada formulir pengajuan yang sama.'],
                    ['no' => 4, 'icon' => 'fa-ranking-star', 'judul' => 'Seleksi Peringkat IP', 'teks' => 'Seluruh pengajuan yang lengkap diseleksi berdasarkan peringkat IP semester 1 pemohon.'],
                ];
            @endphp
            @foreach ($alur as $i => $item)
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.{{ $i + 1 }}s" style="margin-bottom:25px;">
                    <div style="background:#fff;padding:30px 25px;border-radius:12px;box-shadow:0 5px 20px rgba(0,0,0,0.06);height:100%;text-align:center;">
                        <div style="width:46px;height:46px;border-radius:50%;background:#2c7aff;color:#fff;font-weight:800;display:flex;align-items:center;justify-content:center;margin:0 auto 15px;">{{ $item['no'] }}</div>
                        <i class="fa-solid {{ $item['icon'] }}" style="font-size:30px;color:#f0c040;margin-bottom:12px;"></i>
                        <h4 style="font-weight:700;font-size:18px;">{{ $item['judul'] }}</h4>
                        <p style="color:#555;margin:0;">{{ $item['teks'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- SYARAT ADMINISTRASI -->
<section class="section-padding" style="background:#f8f9fa;">
    <div class="container">
        <div class="section-title text-center">
            <h4>Syarat Administrasi</h4>
            <h1>Dokumen yang Perlu Diunggah</h1>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-6 wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.1s">
                <div style="background:#e3f2fd;padding:30px;border-radius:12px;margin-bottom:20px;height:100%;">
                    <i class="fa-solid fa-file-lines" style="font-size:35px;color:#1565c0;margin-bottom:15px;"></i>
                    <h3 style="font-weight:700;font-size:20px;">Transkrip Nilai</h3>
                    <p style="color:#555;margin-bottom:10px;">Transkrip nilai semester 1 sebagai bukti Indeks Prestasi yang menjadi dasar seleksi.</p>
                    <p style="color:#777;font-size:13px;margin:0;"><i class="fa-solid fa-circle-info" style="margin-right:5px;"></i> Format PDF, JPG, atau PNG — maksimal 5 MB.</p>
                </div>
            </div>
            <div class="col-lg-5 col-md-6 wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.2s">
                <div style="background:#fff3e0;padding:30px;border-radius:12px;margin-bottom:20px;height:100%;">
                    <i class="fa-solid fa-pen-fancy" style="font-size:35px;color:#e65100;margin-bottom:15px;"></i>
                    <h3 style="font-weight:700;font-size:20px;">Lembar Motivasi</h3>
                    <p style="color:#555;margin-bottom:10px;">Tulisan berisi alasan dan motivasi kamu mengajukan bantuan pendanaan ini.</p>
                    <p style="color:#777;font-size:13px;margin:0;"><i class="fa-solid fa-circle-info" style="margin-right:5px;"></i> Format PDF, DOC, atau DOCX — maksimal 5 MB.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- DASAR SELEKSI -->
<section class="section-padding" style="background:linear-gradient(135deg,#0d1b2a,#1a2d4a);color:#fff;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-7 col-md-12">
                <h4 style="color:#f0c040;font-size:14px;letter-spacing:2px;text-transform:uppercase;margin-bottom:10px;">Dasar Seleksi</h4>
                <h2 style="color:#fff;font-size:30px;font-weight:700;margin-bottom:20px;">Peringkat IP Semester 1</h2>
                <ul style="list-style:none;padding:0;font-size:16px;line-height:2.2;color:rgba(255,255,255,0.8);">
                    <li><i class="fa-solid fa-check" style="color:#f0c040;margin-right:10px;"></i> Hanya untuk mahasiswa yang mendaftar dengan kode referral <strong style="color:#f0c040;">unsia.my.id</strong></li>
                    <li><i class="fa-solid fa-check" style="color:#f0c040;margin-right:10px;"></i> Seleksi dilakukan setelah peserta menjalani semester pertama</li>
                    <li><i class="fa-solid fa-check" style="color:#f0c040;margin-right:10px;"></i> Penilaian berdasarkan peringkat Indeks Prestasi (IP) semester 1</li>
                    <li><i class="fa-solid fa-check" style="color:#f0c040;margin-right:10px;"></i> Pemohon wajib mendaftarkan diri melalui halaman pengajuan</li>
                    <li><i class="fa-solid fa-check" style="color:#f0c040;margin-right:10px;"></i> Syarat administrasi harus lengkap: transkrip nilai &amp; lembar motivasi</li>
                </ul>
            </div>
            <div class="col-lg-5 col-md-12 text-center">
                <div style="background:rgba(255,255,255,0.08);border:2px solid rgba(255,255,255,0.15);border-radius:16px;padding:35px 30px;margin-top:20px;">
                    <i class="fa-solid fa-ranking-star" style="font-size:45px;color:#f0c040;margin-bottom:15px;"></i>
                    <h3 style="color:#fff;font-weight:700;margin-bottom:10px;">Sudah Siap Mengajukan?</h3>
                    <p style="color:rgba(255,255,255,0.7);font-size:14px;margin-bottom:20px;">Siapkan transkrip nilai semester 1 dan lembar motivasi kamu, lalu isi formulir pengajuan.</p>
                    <a href="{{ route('bantuan.ajukan') }}" style="display:inline-block;background:#f0c040;color:#0d1b2a;padding:14px 30px;border-radius:30px;text-decoration:none;font-weight:700;font-size:15px;"><i class="fa-solid fa-arrow-right"></i> Ajukan Sekarang</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CATATAN -->
<section style="background:#f8f9fa;padding:40px 0;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div style="background:#fff;border-left:4px solid #f0c040;border-radius:12px;padding:20px 25px;">
                    <p style="margin:0;color:#555;font-size:14px;line-height:1.9;"><strong><i class="fa-solid fa-circle-info" style="color:#f0c040;margin-right:6px;"></i> Catatan:</strong> Pengajuan yang masuk akan diverifikasi kelengkapan administrasinya terlebih dahulu. Informasi lebih lanjut mengenai program ini dapat ditanyakan melalui WhatsApp <a href="https://wa.me/628133331686" target="_blank" style="color:#2c7aff;font-weight:600;">0813-3333-1686</a>.</p>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
