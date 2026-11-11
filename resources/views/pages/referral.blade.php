@extends('layouts.app')

@section('title', 'Tentang Kode Referral unsia.my.id - Potongan UKT & Cashback | UNSIA Story')
@section('description', 'Keuntungan memakai kode referral unsia.my.id saat daftar Universitas Siber Asia: potongan UKT Rp500.000, cashback Rp150.000, webinar rutin, dan pendampingan kuliah selama satu semester.')
@section('keywords', 'kode referral unsia, potongan ukt unsia, cashback unsia, referral unsia.my.id, diskon kuliah unsia, pendampingan kuliah unsia')

@section('hero')
    @include('partials.page-hero', [
        'title' => 'Tentang Kode Referral',
        'crumbs' => ['Tentang' => route('about'), 'Kode Referral' => null],
    ])
@endsection

@section('content')

<!-- APA ITU KODE REFERRAL -->
<section class="section-padding">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-7 col-md-12 wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.1s">
                <h4 style="color:#2c7aff;font-size:14px;letter-spacing:2px;text-transform:uppercase;margin-bottom:10px;">Apa Itu Kode Referral?</h4>
                <h2 style="font-weight:700;font-size:32px;margin-bottom:20px;">Satu Kode, Empat Keuntungan</h2>
                <p style="color:#555;font-size:16px;line-height:1.8;margin-bottom:15px;">Kode referral <strong style="color:#2c7aff;">unsia.my.id</strong> adalah kode yang kamu masukkan saat mengisi biodata pendaftaran di <a href="https://pmb.unsia.ac.id" target="_blank" style="color:#2c7aff;font-weight:600;">pmb.unsia.ac.id</a>. Kode ini menandakan bahwa kamu mendaftar melalui kami sebagai mitra pemasaran resmi Universitas Siber Asia.</p>
                <p style="color:#555;font-size:16px;line-height:1.8;margin-bottom:15px;">Memakai kode ini <strong>tidak menambah biaya apa pun</strong>. Proses pendaftaran, seleksi, dan status kemahasiswaanmu sama persis dengan pendaftar lain — bedanya kamu mendapat potongan biaya dari universitas, plus pendampingan dari kami.</p>
                <div style="background:#e3f2fd;padding:15px 20px;border-radius:8px;border-left:4px solid #2c7aff;">
                    <p style="margin:0;color:#555;font-size:14px;line-height:1.8;"><i class="fa-solid fa-triangle-exclamation" style="color:#e65100;margin-right:6px;"></i> <strong>Penting:</strong> kode harus dimasukkan <strong>sebelum</strong> kamu membayar UKT. Kode yang dimasukkan setelah pembayaran tidak bisa diproses mundur.</p>
                </div>
            </div>
            <div class="col-lg-5 col-md-12 text-center wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.2s">
                <div style="background:linear-gradient(135deg,#0d1b2a,#1a2d4a);border-radius:16px;padding:40px 30px;margin-top:30px;">
                    <p style="color:rgba(255,255,255,0.6);font-size:13px;text-transform:uppercase;letter-spacing:2px;margin-bottom:10px;">Kode Referral</p>
                    <h2 style="color:#f0c040;font-size:30px;font-weight:700;margin-bottom:15px;letter-spacing:1px;">unsia.my.id</h2>
                    <p style="color:rgba(255,255,255,0.75);font-size:14px;margin:0;">Ketik persis seperti di atas pada kolom referral</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- EMPAT KEUNTUNGAN -->
<section class="section-padding" style="background:#f8f9fa;">
    <div class="container">
        <div class="section-title text-center">
            <h4>Keuntungan</h4>
            <h1>Apa yang Kamu Dapat?</h1>
        </div>
        <div class="row">
            @php
                $keuntungan = [
                    [
                        'icon' => 'fa-tags',
                        'color' => '#2c7aff',
                        'judul' => 'Potongan UKT Rp500.000',
                        'teks' => 'Potongan langsung dari Universitas Siber Asia untuk <strong>semester pertama</strong>. UKT yang semula Rp3.000.000 menjadi <strong>Rp2.500.000</strong>.',
                    ],
                    [
                        'icon' => 'fa-hand-holding-dollar',
                        'color' => '#2e7d32',
                        'judul' => 'Cashback Rp150.000',
                        'teks' => 'Dana kembali sebesar Rp150.000, juga di <strong>semester pertama</strong>. Digabung dengan potongan di atas, total keuntungan tunai yang kamu terima <strong>Rp650.000</strong>.',
                    ],
                    [
                        'icon' => 'fa-video',
                        'color' => '#7b1fa2',
                        'judul' => 'Webinar Rutin',
                        'teks' => 'Akses ke kegiatan webinar yang kami adakan secara berkala — mulai dari tips belajar daring, pengembangan karier, sampai bahasan seputar perkuliahan di UNSIA.',
                    ],
                    [
                        'icon' => 'fa-user-group',
                        'color' => '#e65100',
                        'judul' => 'Pendampingan 1 Semester',
                        'teks' => 'Kami dampingi kamu selama <strong>satu semester penuh</strong>, sejak daftar ulang sampai selesai semester pertama. Bingung soal LMS, jadwal, atau cara bayar cicilan? Tinggal tanya.',
                    ],
                ];
            @endphp
            @foreach ($keuntungan as $i => $item)
                <div class="col-lg-6 col-md-6 wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.{{ $i + 1 }}s" style="margin-bottom:25px;">
                    <div style="background:#fff;padding:30px;border-radius:12px;box-shadow:0 5px 20px rgba(0,0,0,0.06);height:100%;display:flex;gap:18px;align-items:flex-start;">
                        <div style="background:{{ $item['color'] }}1a;width:52px;height:52px;border-radius:12px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                            <i class="fa-solid {{ $item['icon'] }}" style="font-size:22px;color:{{ $item['color'] }};"></i>
                        </div>
                        <div>
                            <h4 style="font-weight:700;margin-bottom:8px;font-size:19px;">{{ $item['judul'] }}</h4>
                            <p style="color:#555;margin:0;line-height:1.8;">{!! $item['teks'] !!}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- RINCIAN BIAYA -->
<section class="section-padding" style="background:linear-gradient(135deg,#0d1b2a,#1a2d4a);">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-7 col-md-12 wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.1s">
                <h4 style="color:#f0c040;font-size:14px;letter-spacing:2px;text-transform:uppercase;margin-bottom:10px;">Rincian Biaya</h4>
                <h2 style="color:#fff;font-size:32px;font-weight:700;margin-bottom:15px;">Berapa yang Benar-Benar Kamu Bayar?</h2>
                <p style="color:rgba(255,255,255,0.75);font-size:16px;line-height:1.8;margin-bottom:20px;">UKT Universitas Siber Asia adalah <strong style="color:#fff;">Rp3.000.000 per semester</strong> dan bisa dicicil hingga tiga kali. Dengan kode referral, semester pertamamu jadi seperti ini:</p>
                <ul style="list-style:none;padding:0;color:rgba(255,255,255,0.8);font-size:15px;line-height:2.2;">
                    <li><i class="fa-solid fa-check-circle" style="color:#f0c040;margin-right:10px;"></i> UKT normal: <strong style="color:#fff;">Rp3.000.000</strong></li>
                    <li><i class="fa-solid fa-check-circle" style="color:#f0c040;margin-right:10px;"></i> Potongan semester 1: <strong style="color:#f0c040;">&minus; Rp500.000</strong> → bayar <strong style="color:#fff;font-size:18px;">Rp2.500.000</strong></li>
                    <li><i class="fa-solid fa-check-circle" style="color:#f0c040;margin-right:10px;"></i> Cashback semester 1: <strong style="color:#f0c040;">&minus; Rp150.000</strong> → biaya bersih <strong style="color:#fff;font-size:18px;">Rp2.350.000</strong></li>
                    <li><i class="fa-solid fa-check-circle" style="color:#f0c040;margin-right:10px;"></i> Semester selanjutnya: <strong style="color:#fff;">Rp3.000.000</strong> (bisa dicicil 3x)</li>
                    <li><i class="fa-solid fa-check-circle" style="color:#f0c040;margin-right:10px;"></i> Kesempatan lulus dalam <strong style="color:#fff;">3,5 tahun</strong></li>
                </ul>
            </div>
            <div class="col-lg-5 col-md-12 wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.2s">
                <div style="background:rgba(255,255,255,0.08);border:2px solid rgba(255,255,255,0.15);border-radius:16px;padding:35px 30px;margin-top:20px;text-align:center;">
                    <p style="color:rgba(255,255,255,0.6);font-size:13px;text-transform:uppercase;letter-spacing:2px;margin-bottom:8px;">Total Keuntungan Tunai</p>
                    <h2 style="color:#f0c040;font-size:42px;font-weight:700;margin-bottom:8px;">Rp650.000</h2>
                    <p style="color:rgba(255,255,255,0.7);font-size:14px;margin-bottom:25px;">Rp500.000 potongan + Rp150.000 cashback</p>
                    <a href="https://pmb.unsia.ac.id" target="_blank" class="btn_two" style="display:inline-block;">Daftar Sekarang <i class="fa-solid fa-arrow-right"></i></a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CARA PAKAI -->
<section class="section-padding">
    <div class="container">
        <div class="section-title text-center">
            <h4>Cara Pakai</h4>
            <h1>Empat Langkah Saja</h1>
        </div>
        <div class="row">
            @php
                $langkah = [
                    ['judul' => 'Buka Portal PMB', 'teks' => 'Masuk ke <strong>pmb.unsia.ac.id</strong> dan mulai pendaftaran mahasiswa baru.'],
                    ['judul' => 'Isi Biodata', 'teks' => 'Lengkapi data diri sampai ke bagian yang meminta kode referral.'],
                    ['judul' => 'Ketik Kodenya', 'teks' => 'Masukkan <strong>unsia.my.id</strong> pada kolom referral, sebelum membayar UKT.'],
                    ['judul' => 'Kabari Kami', 'teks' => 'Hubungi kami lewat WhatsApp agar pendampingan dan akses webinar bisa segera dibuka.'],
                ];
            @endphp
            @foreach ($langkah as $i => $item)
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.{{ $i + 1 }}s" style="margin-bottom:25px;">
                    <div style="background:#fff;padding:28px 24px;border-radius:12px;box-shadow:0 5px 20px rgba(0,0,0,0.06);height:100%;text-align:center;">
                        <div style="background:#f0c040;color:#0d1b2a;width:44px;height:44px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:18px;margin:0 auto 15px;">{{ $i + 1 }}</div>
                        <h5 style="font-weight:700;margin-bottom:8px;">{{ $item['judul'] }}</h5>
                        <p style="color:#555;margin:0;font-size:15px;line-height:1.8;">{!! $item['teks'] !!}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- CTA -->
<section class="section-padding" style="background:#f8f9fa;padding-top:0;">
    <div class="container">
        <div class="row">
            <div class="col-12 wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.1s">
                <div style="background:#fff;border-radius:16px;padding:40px 30px;text-align:center;box-shadow:0 5px 20px rgba(0,0,0,0.06);">
                    <h3 style="font-weight:700;margin-bottom:10px;">Masih Ada yang Ingin Ditanyakan?</h3>
                    <p style="color:#555;font-size:16px;margin-bottom:25px;">Tanya langsung ke {{ config('kontak.cs.nama') }}, customer service kami, di {{ config('kontak.cs.telepon') }}.</p>
                    <a href="https://wa.me/{{ config('kontak.cs.wa') }}?text=Halo%2C%20saya%20ingin%20bertanya%20tentang%20kode%20referral%20unsia.my.id" target="_blank" class="btn_two" style="display:inline-block;margin-right:10px;">
                        <i class="fa-brands fa-whatsapp"></i> Tanya via WhatsApp
                    </a>
                    <a href="{{ route('faq') }}" class="btn_two" style="display:inline-block;background:transparent;border:1px solid #0d1b2a;color:#0d1b2a;">Lihat FAQ</a>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
