@extends('layouts.app')

@section('title', 'UNSIA Story - Kuliah Online Universitas Siber Asia | Kode Referral unsia.my.id')
@section('description', 'Mitra pemasaran resmi UNSIA. Gunakan kode referral unsia.my.id untuk potongan UKT Rp650.000. Info pendaftaran, prodi, dan promo kuliah online.')
@section('og_image', asset('assets/images/logo-unsia-story.png'))

@section('hero')
<section id="home" class="home_bg">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-sm-6 col-xs-12">
                <div class="home_content">
                    <span style="background: #f0c040; color: #0d1b2a; font-weight: 700; font-size: 12px; letter-spacing: 2px; padding: 5px 15px; border-radius: 20px; text-transform: uppercase; display: inline-block; margin-bottom: 15px;">UNSIA Story</span>
                    <h1>Kuliah Online? Seru Kok, Gas!</h1>
                    <p>Semua yang kamu butuh soal kehidupan kampus UNSIA ada di sini — dari info kuliah jarak jauh, promo UKT, sampai cara daftar. No ribet, langsung action!</p>
                </div>
                <div class="home_btn">
                    <a href="{{ route('about') }}" class="cta"><span>Info Selengkapnya</span>
                        <svg width="13px" height="10px" viewBox="0 0 13 10">
                            <path d="M1,5 L11,5"></path>
                            <polyline points="8 1 12 5 8 9"></polyline>
                        </svg>
                    </a>
                </div>
            </div>
            <div class="col-lg-6 col-sm-6 col-xs-12">
                <div class="home_me_img">
                    <img src="{{ asset('assets/images/mascot-unsiro.png') }}" class="img-fluid" alt="Maskot UNSIA" style="max-height: 650px; width: auto; margin-left: 150px;" />
                    <div class="home_ps">
                        <img src="{{ asset('assets/images/icon/user2.svg') }}" alt="" />
                        <h2>7500+</h2>
                        <span>Active student</span>
                    </div>
                    <div class="home_ps2">
                        <img src="{{ asset('assets/images/icon/file2.svg') }}" alt="" />
                        <h2>4500+</h2>
                        <span>Online Course</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('content')

<!-- START OFFICIAL DIGITAL REPRESENTATIVE -->
<section style="padding: 60px 0;">
    <div class="container">
        <div class="row align-items-center justify-content-center text-center">
            <div class="col-lg-8 col-md-10 col-12">
                <div style="border: 2px solid rgba(0,0,0,0.1); border-radius: 12px; padding: 30px; background: rgba(0,0,0,0.03);">
                    <span style="display: inline-block; background: #f0c040; color: #0d1b2a; font-weight: 700; font-size: 13px; letter-spacing: 2px; padding: 5px 18px; border-radius: 20px; margin-bottom: 15px; text-transform: uppercase;">Mitra Pemasaran Resmi</span>
                    <h2 style="color: #0d1b2a; font-size: 28px; font-weight: 700; margin-bottom: 10px;">UNSIA Story — Universitas Siber Asia</h2>
                    <p style="color: rgba(0,0,0,0.6); font-size: 16px; margin: 0;">Situs ini dikelola secara independen sebagai mitra pemasaran resmi Universitas Siber Asia. Situs resmi universitas: <a href="https://unsia.ac.id" target="_blank" style="color:#2c7aff;font-weight:600;">unsia.ac.id</a></p>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- END OFFICIAL DIGITAL REPRESENTATIVE -->

<!-- START DOWNLOAD BROSUR -->
<section style="background: linear-gradient(135deg, #1a2d4a 0%, #0d1f3c 100%); padding: 40px 0;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8 col-md-7 col-12">
                <h4 style="color: #f0c040; font-size: 14px; letter-spacing: 2px; text-transform: uppercase; margin-bottom: 10px;">Brosur UNSIA</h4>
                <h2 style="color: #fff; font-size: 32px; font-weight: 700; margin-bottom: 15px;">Download Brosur Lengkap UNSIA 2026</h2>
                <p style="color: rgba(255,255,255,0.65); font-size: 16px; line-height: 1.7;">Dapatkan informasi lengkap mengenai program studi, biaya kuliah, fasilitas, dan keunggulan UNSIA dalam satu file brosur.</p>
            </div>
            <div class="col-lg-4 col-md-5 col-12 text-center text-md-end" style="margin-top: 20px;">
                <a href="{{ asset('assets/document/BROSUR UNSIA TERBARU 2026.pdf') }}" download style="display: inline-flex; align-items: center; gap: 12px; background: #f0c040; color: #0d1b2a; padding: 16px 32px; border-radius: 50px; text-decoration: none; font-weight: 700; font-size: 16px;">
                    <i class="fa-solid fa-file-pdf" style="font-size: 22px;"></i>
                    Download Brosur
                </a>
            </div>
        </div>
    </div>
</section>
<!-- END DOWNLOAD BROSUR -->

<!-- START ABOUT US HOME ONE -->
<section class="ab_one section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-sm-12 col-xs-12 wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.2s" data-wow-offset="0">
                <div class="ab_img">
                    <img src="{{ asset('assets/images/Poster-pendaftaran-UNSIA.png') }}" class="img-fluid" alt="Pendaftaran UNSIA" style="border-radius: 10px;">
                </div>
            </div>
            <div class="col-lg-6 col-sm-12 col-xs-12 wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.1s" data-wow-offset="0">
                <div class="ab_content">
                    <h2>Kuliah Online dari Mana Aja, Cocok Buat Kamu yang Kerja!</h2>
                    <p>UNSIA (Universitas Siber Asia) adalah kampus yang mendukung pembelajaran jarak jauh secara penuh. Cocok banget buat kamu yang ingin kuliah sambil kerja, tanpa harus datang ke kampus.</p>
                </div>
                <div class="abmv">
                    <i class="fa-solid fa-calendar-check"></i>
                    <h4>Gelombang 10 — Gelombang Terakhir!</h4>
                    <p>Pendaftaran Gel 10 Jalur Reguler: <strong>4 - 17 September 2026</strong>. Daftar sekarang di <a href="https://pmb.unsia.ac.id" target="_blank" style="color: #2c7aff; font-weight: 600;">pmb.unsia.ac.id</a></p>
                </div>
                <div class="abmv">
                    <i class="fa-solid fa-tags"></i>
                    <h4>UKT Rp3 Juta/Semester — Bisa Cicil 3x!</h4>
                    <p>Gunakan kode referral: <strong style="color: #2c7aff; font-size: 18px;">unsia.my.id</strong> untuk potongan UKT <strong>Rp650.000</strong>!</p>
                </div>
                <div class="abmv">
                    <i class="fa-brands fa-whatsapp"></i>
                    <h4>Ada Pertanyaan?</h4>
                    <p>Hubungi kami langsung via WhatsApp di <a href="https://wa.me/628133331686" target="_blank" style="color: #25D366; font-weight: 600;">0813-3333-1686</a>, siap bantu kamu!</p>
                </div>
                <div class="cta_two">
                    <a href="https://pmb.unsia.ac.id" target="_blank" class="cta"><span>Daftar Sekarang</span>
                        <svg width="13px" height="10px" viewBox="0 0 13 10">
                            <path d="M1,5 L11,5"></path>
                            <polyline points="8 1 12 5 8 9"></polyline>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- END ABOUT US HOME ONE -->

<!-- START KEUNGGULAN UNSIA -->
<section class="tp_feature section-padding">
    <div class="container">
        <div class="section-title text-center">
            <h4>Kenapa UNSIA?</h4>
            <h1>Keunggulan Kuliah di UNSIA</h1>
        </div>
        <div class="row">
            <div class="col-lg-3 col-sm-6 col-xs-12 wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.1s" data-wow-offset="0">
                <div class="single_tp">
                    <h3>100% Online</h3>
                    <i class="fa-solid fa-laptop"></i>
                    <p>Kuliah dari mana aja tanpa harus datang ke kampus. Fleksibel dan praktis.</p>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 col-xs-12 wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.2s" data-wow-offset="0">
                <div class="single_tp st_one">
                    <h3>Terakreditasi</h3>
                    <i class="fa-solid fa-certificate"></i>
                    <p>Kampus resmi terdaftar di Kemendikbud dengan ijazah yang diakui negara.</p>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 col-xs-12 wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.3s" data-wow-offset="0">
                <div class="single_tp st_two">
                    <h3>Biaya Terjangkau</h3>
                    <i class="fa-solid fa-wallet"></i>
                    <p>UKT Rp3 juta/semester, cicil 3x. Potongan Rp500rb semester pertama + cashback Rp150rb semester kedua!</p>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 col-xs-12 wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.4s" data-wow-offset="0">
                <div class="single_tp st_three">
                    <h3>Sambil Kerja</h3>
                    <i class="fa-solid fa-briefcase"></i>
                    <p>Jadwal fleksibel, cocok buat kamu yang kuliah sambil kerja atau berbisnis.</p>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- END KEUNGGULAN UNSIA -->

<!-- START LAYANAN UNSIA -->
<section class="topic_content_p2 section-padding">
    <div class="container">
        <div class="section-title">
            <h4>Layanan Universitas Siber Asia</h4>
            <h1>Akses Layanan UNSIA dengan Mudah</h1>
        </div>
        <div class="row">
            <div class="col-lg-3 col-sm-6 col-xs-12">
                <div class="single_tca sc_one">
                    <i class="fa-solid fa-laptop-code" style="font-size: 30px; margin-bottom: 10px;"></i>
                    <h2><a href="http://kuliah.unsia.ac.id/" target="_blank">LMS</a></h2>
                    <span>Pembelajaran Online</span>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 col-xs-12">
                <div class="single_tca sc_two">
                    <i class="fa-solid fa-graduation-cap" style="font-size: 30px; margin-bottom: 10px;"></i>
                    <h2><a href="https://akademik.unsia.ac.id/gate/login" target="_blank">SIAKAD</a></h2>
                    <span>Sistem Akademik</span>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 col-xs-12">
                <div class="single_tca sc_three">
                    <i class="fa-solid fa-book-open" style="font-size: 30px; margin-bottom: 10px;"></i>
                    <h2><a href="https://cyberlibrary.unsia.ac.id/" target="_blank">Digital Library</a></h2>
                    <span>Perpustakaan Digital</span>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 col-xs-12">
                <div class="single_tca sc_four">
                    <i class="fa-solid fa-comments" style="font-size: 30px; margin-bottom: 10px;"></i>
                    <h2><a href="http://konseling.unsia.ac.id/" target="_blank">E-Counseling</a></h2>
                    <span>Konsultasi Psikolog</span>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 col-xs-12">
                <div class="single_tca sc_five">
                    <i class="fa-solid fa-file-lines" style="font-size: 30px; margin-bottom: 10px;"></i>
                    <h2><a href="http://jurnas.unsia.ac.id/" target="_blank">OJS</a></h2>
                    <span>Jurnal Penelitian</span>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 col-xs-12">
                <div class="single_tca sc_six">
                    <i class="fa-solid fa-microscope" style="font-size: 30px; margin-bottom: 10px;"></i>
                    <h2><a href="https://sippm.unsia.ac.id/" target="_blank">SIPPM</a></h2>
                    <span>Penelitian &amp; PKM</span>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 col-xs-12">
                <div class="single_tca sc_seven">
                    <i class="fa-solid fa-calendar-days" style="font-size: 30px; margin-bottom: 10px;"></i>
                    <h2><a href="https://unsia.ac.id/kalender-akademik/" target="_blank">Kalender</a></h2>
                    <span>Kalender Akademik</span>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 col-xs-12">
                <div class="single_tca sc_eight">
                    <i class="fa-solid fa-calendar-check" style="font-size: 30px; margin-bottom: 10px;"></i>
                    <h2><a href="http://event.unsia.ac.id/" target="_blank">Event</a></h2>
                    <span>Event &amp; Webinar</span>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- END LAYANAN UNSIA -->

<!-- START ALUR PENDAFTARAN -->
<section class="section-padding" style="background: linear-gradient(135deg, #0d1b2a 0%, #1a2d4a 100%);">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-5 col-md-6 col-12 text-center wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.1s" data-wow-offset="0" style="margin-bottom: 30px;">
                <img src="{{ asset('assets/images/alur-pendaftaran-web.png') }}" class="img-fluid" alt="Alur Pendaftaran Mahasiswa Baru UNSIA" style="border-radius: 12px; box-shadow: 0 10px 40px rgba(0,0,0,0.3); max-height: 600px;">
            </div>
            <div class="col-lg-7 col-md-6 col-12 wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.2s" data-wow-offset="0">
                <h4 style="color: #f0c040; font-size: 14px; letter-spacing: 2px; text-transform: uppercase; margin-bottom: 10px;">Alur Pendaftaran</h4>
                <h2 style="color: #fff; font-size: 32px; font-weight: 700; margin-bottom: 20px;">Langkah Mudah Jadi Mahasiswa Baru UNSIA</h2>
                <div style="color: rgba(255,255,255,0.75); font-size: 15px; line-height: 2;">
                    <p><span style="background: #f0c040; color: #0d1b2a; font-weight: 700; padding: 2px 10px; border-radius: 5px; margin-right: 10px;">1</span> Pilih jalur pendaftaran di <strong>pmb.unsia.ac.id</strong></p>
                    <p><span style="background: #f0c040; color: #0d1b2a; font-weight: 700; padding: 2px 10px; border-radius: 5px; margin-right: 10px;">2</span> Isi data diri &amp; lengkapi informasi kamu</p>
                    <p><span style="background: #f0c040; color: #0d1b2a; font-weight: 700; padding: 2px 10px; border-radius: 5px; margin-right: 10px;">3</span> Bayar biaya pendaftaran <strong>Rp175.000</strong></p>
                    <p><span style="background: #f0c040; color: #0d1b2a; font-weight: 700; padding: 2px 10px; border-radius: 5px; margin-right: 10px;">4</span> Login ke akun PMB, cek ID &amp; PIN dari email</p>
                    <p><span style="background: #f0c040; color: #0d1b2a; font-weight: 700; padding: 2px 10px; border-radius: 5px; margin-right: 10px;">5</span> Isi biodata lengkap, lalu masukkan kode referral <strong style="color: #f0c040;">unsia.my.id</strong> — potongan UKT <strong>Rp650.000</strong>!</p>
                    <p><span style="background: #f0c040; color: #0d1b2a; font-weight: 700; padding: 2px 10px; border-radius: 5px; margin-right: 10px;">6</span> Ikuti tes online (CBT)</p>
                    <p><span style="background: #f0c040; color: #0d1b2a; font-weight: 700; padding: 2px 10px; border-radius: 5px; margin-right: 10px;">7</span> Tunggu hasil seleksi 2–5 hari</p>
                    <p><span style="background: #f0c040; color: #0d1b2a; font-weight: 700; padding: 2px 10px; border-radius: 5px; margin-right: 10px;">8</span> Daftar ulang &amp; bayar UKT — sebesar <strong>Rp3.000.000/semester</strong> (bisa dicicil 3x)</p>
                </div>
                <div style="margin-top: 25px; display: flex; gap: 15px; flex-wrap: wrap;">
                    <a href="https://pmb.unsia.ac.id" target="_blank" style="display: inline-flex; align-items: center; gap: 8px; background: #f0c040; color: #0d1b2a; padding: 14px 28px; border-radius: 50px; text-decoration: none; font-weight: 700; font-size: 15px;">
                        <i class="fa-solid fa-arrow-right"></i> Daftar Sekarang
                    </a>
                    <a href="https://wa.me/628133331686?text=Halo%2C%20saya%20ingin%20bertanya%20tentang%20pendaftaran%20UNSIA" target="_blank" style="display: inline-flex; align-items: center; gap: 8px; background: #25D366; color: #fff; padding: 14px 28px; border-radius: 50px; text-decoration: none; font-weight: 700; font-size: 15px;">
                        <i class="fa-brands fa-whatsapp"></i> Tanya via WA
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- END ALUR PENDAFTARAN -->

<!-- START PROGRAM STUDI -->
<section class="marketing_content_area section-padding">
    <div class="container">
        <div class="section-title">
            <h4>Program Studi</h4>
            <h1>Pilih Jurusan yang Cocok Buat Kamu</h1>
        </div>
        <div class="row">
            @php
                $prodiList = [
                    ['slug' => 'sistem-informasi', 'nama' => 'Sistem <br />Informasi', 'icon' => 'fa-database', 'desc' => 'Pelajari cara mengelola data dan teknologi informasi untuk mendukung keputusan bisnis.'],
                    ['slug' => 'informatika', 'nama' => 'Informatika', 'icon' => 'fa-code', 'desc' => 'Kuasai pemrograman, algoritma, dan pengembangan software dari nol sampai mahir.'],
                    ['slug' => 'manajemen', 'nama' => 'Manajemen', 'icon' => 'fa-chart-line', 'desc' => 'Bangun skill kepemimpinan, strategi bisnis, dan manajemen organisasi modern.'],
                    ['slug' => 'akuntansi', 'nama' => 'Akuntansi', 'icon' => 'fa-calculator', 'desc' => 'Pelajari akuntansi keuangan, audit, dan perpajakan untuk karir profesional.'],
                    ['slug' => 'komunikasi', 'nama' => 'Komunikasi', 'icon' => 'fa-bullhorn', 'desc' => 'Dalami ilmu komunikasi, media digital, dan public relations di era modern.'],
                    ['slug' => 'teknologi-informasi', 'nama' => 'Teknologi <br />Informasi', 'icon' => 'fa-network-wired', 'desc' => 'Kuasai jaringan, keamanan siber, dan infrastruktur IT untuk dunia kerja.'],
                ];
            @endphp
            @foreach ($prodiList as $i => $prodi)
                <div class="col-lg-4 col-sm-6 col-xs-12 wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.{{ $i + 1 }}s" data-wow-offset="0">
                    <div class="single_feature_one">
                        <div class="sf_top">
                            <i class="fa-solid {{ $prodi['icon'] }}"></i>
                            <h2><a href="{{ route('prodi', $prodi['slug']) }}">{!! $prodi['nama'] !!}</a></h2>
                        </div>
                        <p>{{ $prodi['desc'] }}</p>
                        <a href="{{ route('prodi', $prodi['slug']) }}">Info Selengkapnya <i class="fa-solid fa-arrow-right"></i></a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
<!-- END PROGRAM STUDI -->

<!-- START VIDEO -->
<section class="section-padding" style="background: #f8f9fa;">
    <div class="container">
        <div class="section-title text-center">
            <h4>Platform Kuliah Online Terbaik</h4>
            <h1>Kenalan Lebih Dekat dengan UNSIA</h1>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-10 col-md-12 wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.2s" data-wow-offset="0">
                <div style="position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden; border-radius: 12px; box-shadow: 0 5px 30px rgba(0,0,0,0.15);">
                    <iframe src="https://www.youtube-nocookie.com/embed/vV8lFCaQaAY?rel=0&origin=null" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; border: none;" allowfullscreen></iframe>
                </div>
            </div>
        </div>
        <div class="row justify-content-center" style="margin-top: 30px;">
            <div class="col-lg-8 text-center">
                <p style="color: #555; font-size: 16px; line-height: 1.7;">UNSIA adalah universitas siber pertama di Indonesia yang menyelenggarakan perkuliahan 100% online. Kuliah dari mana saja, kapan saja, dengan ijazah resmi diakui negara.</p>
                <a href="https://pmb.unsia.ac.id" target="_blank" class="cta" style="margin-top: 10px;"><span>Daftar Sekarang</span>
                    <svg width="13px" height="10px" viewBox="0 0 13 10">
                        <path d="M1,5 L11,5"></path>
                        <polyline points="8 1 12 5 8 9"></polyline>
                    </svg>
                </a>
            </div>
        </div>
    </div>
</section>
<!-- END VIDEO -->

<!-- START HUBUNGI KAMI -->
<section class="newsletter_area section-padding" id="minta-dihubungi">
    <div class="container">
        <div class="row align-items-center justify-content-center">
            <div class="col-lg-10 col-md-12">
                <div style="display:flex;gap:30px;align-items:stretch;flex-wrap:wrap;">
                    <!-- FORM MINTA DIHUBUNGI -->
                    <div style="flex:1;min-width:300px;background:#fff;border-radius:14px;padding:30px 35px;box-shadow:0 5px 25px rgba(0,0,0,0.08);">
                        <h3 style="font-size:20px;font-weight:700;color:#0d1b2a;margin-bottom:5px;">Minta Dihubungi</h3>
                        <p style="color:#888;font-size:13px;margin-bottom:20px;">Isi form di bawah, tim kami akan menghubungi kamu!</p>
                        <form id="callbackForm">
                            <div style="margin-bottom:12px;">
                                <input type="text" name="nama" placeholder="Nama Lengkap" required style="width:100%;padding:12px 16px;border:2px solid #e0e0e0;border-radius:10px;font-size:14px;font-family:'Lexend',sans-serif;outline:none;transition:border 0.3s;" onfocus="this.style.borderColor='#2c7aff'" onblur="this.style.borderColor='#e0e0e0'">
                            </div>
                            <div style="margin-bottom:12px;">
                                <input type="text" name="kontak" placeholder="No. WhatsApp atau Email" required style="width:100%;padding:12px 16px;border:2px solid #e0e0e0;border-radius:10px;font-size:14px;font-family:'Lexend',sans-serif;outline:none;transition:border 0.3s;" onfocus="this.style.borderColor='#2c7aff'" onblur="this.style.borderColor='#e0e0e0'">
                            </div>
                            <div style="display:flex;gap:10px;margin-bottom:12px;">
                                <div style="flex:1;">
                                    <label style="font-size:12px;color:#888;font-weight:600;display:block;margin-bottom:4px;">Tanggal dihubungi</label>
                                    <input type="date" name="tanggal_hubungi" required style="width:100%;padding:12px 16px;border:2px solid #e0e0e0;border-radius:10px;font-size:14px;font-family:'Lexend',sans-serif;outline:none;transition:border 0.3s;" onfocus="this.style.borderColor='#2c7aff'" onblur="this.style.borderColor='#e0e0e0'">
                                </div>
                                <div style="flex:1;">
                                    <label style="font-size:12px;color:#888;font-weight:600;display:block;margin-bottom:4px;">Rentang waktu</label>
                                    <select name="waktu_hubungi" required style="width:100%;padding:12px 16px;border:2px solid #e0e0e0;border-radius:10px;font-size:14px;font-family:'Lexend',sans-serif;outline:none;background:#fff;transition:border 0.3s;" onfocus="this.style.borderColor='#2c7aff'" onblur="this.style.borderColor='#e0e0e0'">
                                        <option value="">Pilih waktu</option>
                                        <option value="08:00 - 10:00">08:00 - 10:00</option>
                                        <option value="10:00 - 12:00">10:00 - 12:00</option>
                                        <option value="12:00 - 14:00">12:00 - 14:00</option>
                                        <option value="14:00 - 16:00">14:00 - 16:00</option>
                                        <option value="16:00 - 18:00">16:00 - 18:00</option>
                                        <option value="18:00 - 20:00">18:00 - 20:00</option>
                                        <option value="20:00 - 22:00">20:00 - 22:00</option>
                                    </select>
                                </div>
                            </div>
                            <button type="submit" id="cbBtn" style="width:100%;padding:13px;background:#2c7aff;color:#fff;border:none;border-radius:10px;font-size:15px;font-weight:700;font-family:'Lexend',sans-serif;cursor:pointer;transition:background 0.3s;">
                                <i class="fa-solid fa-paper-plane" style="margin-right:6px;"></i> Kirim
                            </button>
                        </form>
                        <div id="cbMsg" style="display:none;margin-top:12px;padding:10px 15px;border-radius:8px;font-size:13px;font-weight:600;"></div>
                    </div>
                    <!-- TOMBOL WA -->
                    <div style="flex:1;min-width:300px;background:linear-gradient(135deg,#0d1b2a,#1a2d4a);border-radius:14px;padding:35px;display:flex;flex-direction:column;justify-content:center;align-items:center;text-align:center;">
                        <i class="fa-brands fa-whatsapp" style="font-size:50px;color:#25D366;margin-bottom:15px;"></i>
                        <h3 style="color:#fff;font-size:20px;font-weight:700;margin-bottom:8px;">Mau Langsung Chat?</h3>
                        <p style="color:rgba(255,255,255,0.7);font-size:14px;margin-bottom:20px;line-height:1.7;">Tim kami siap bantu jawab semua pertanyaan kamu seputar pendaftaran &amp; promo UNSIA.</p>
                        <a href="https://wa.me/628133331686?text=Halo%2C%20saya%20ingin%20bertanya%20tentang%20kuliah%20di%20UNSIA" target="_blank" style="display:inline-flex;align-items:center;gap:10px;background:#25D366;color:#fff;text-decoration:none;padding:15px 35px;font-size:16px;border-radius:50px;font-weight:700;transition:opacity 0.3s;" onmouseover="this.style.opacity='0.85'" onmouseout="this.style.opacity='1'">
                            <i class="fa-brands fa-whatsapp" style="font-size:20px;"></i> Chat WhatsApp
                        </a>
                        <p style="color:rgba(255,255,255,0.5);font-size:12px;margin-top:12px;">081 3333 1686 — Buka 24/7</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- END HUBUNGI KAMI -->

<!-- SEO SECTION -->
<section style="background:#f8f9fa;padding:40px 0;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <h2 style="font-size:22px;font-weight:700;margin-bottom:15px;text-align:center;">Kuliah Online di UNSIA — Universitas Siber Asia</h2>
                <p style="color:#555;font-size:13px;line-height:2;text-align:center;">
                    <strong>UNSIA Story</strong> adalah mitra pemasaran resmi <strong>Universitas Siber Asia (UNSIA)</strong>, universitas online pertama di Indonesia dengan sistem <strong>Pembelajaran Jarak Jauh (PJJ)</strong>. Dapatkan <strong>potongan biaya kuliah UNSIA</strong> dengan menggunakan <strong>kode referral unsia.my.id</strong> saat mendaftar di pmb.unsia.ac.id. <strong>Promo kuliah UNSIA</strong> ini memberikan <strong>potongan biaya UNSIA</strong> sebesar Rp500.000 pada semester pertama dan cashback Rp150.000 di semester kedua. Gunakan <strong>kode referal unsia.my.id</strong> atau <strong>referral code unsia.my.id</strong> untuk mendapatkan <strong>promo UNSIA</strong> ini. UNSIA menyediakan 6 program studi S1: Sistem Informasi, Informatika, Manajemen, Akuntansi, Komunikasi, dan Teknologi Informasi. Semua program studi terakreditasi BAN-PT dan sebagian terakreditasi internasional EAHEA. Dengan <strong>kuliah online murah</strong> di <strong>kampus online terbaik</strong>, kamu bisa <strong>kuliah sambil kerja</strong> dari mana saja. Daftar sekarang di pmb.unsia.ac.id dengan <strong>kode referral UNSIA</strong>: <strong>unsia.my.id</strong>.
                </p>
            </div>
        </div>
    </div>
</section>
<!-- END SEO SECTION -->

@endsection

@section('scripts')
<script>
document.getElementById('callbackForm').addEventListener('submit', function(e) {
    e.preventDefault();
    var form = this;
    var btn = document.getElementById('cbBtn');
    var msg = document.getElementById('cbMsg');
    var payload = {
        nama: form.nama.value.trim(),
        kontak: form.kontak.value.trim(),
        tanggal_hubungi: form.tanggal_hubungi.value,
        waktu_hubungi: form.waktu_hubungi.value
    };
    if (!payload.nama || !payload.kontak || !payload.tanggal_hubungi || !payload.waktu_hubungi) return;
    btn.disabled = true;
    btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Mengirim...';
    fetch('{{ route('api.callback') }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify(payload)
    })
    .then(function(r) { return r.json().then(function(d) { return {ok: r.ok, data: d}; }); })
    .then(function(res) {
        msg.style.display = 'block';
        if (res.ok && res.data.success) {
            msg.style.background = '#e8f5e9'; msg.style.color = '#2e7d32';
            msg.innerHTML = '<i class="fa-solid fa-check-circle"></i> Terima kasih! Tim kami akan segera menghubungi kamu.';
            form.reset();
        } else {
            msg.style.background = '#fce4ec'; msg.style.color = '#c62828';
            msg.innerHTML = '<i class="fa-solid fa-exclamation-circle"></i> ' + (res.data.message || 'Terjadi kesalahan.');
        }
    })
    .catch(function() {
        msg.style.display = 'block'; msg.style.background = '#fce4ec'; msg.style.color = '#c62828';
        msg.innerHTML = '<i class="fa-solid fa-exclamation-circle"></i> Gagal mengirim. Coba lagi.';
    })
    .finally(function() {
        btn.disabled = false;
        btn.innerHTML = '<i class="fa-solid fa-paper-plane" style="margin-right:6px;"></i> Kirim';
    });
});

// Tanggal minimal = hari ini
(function() {
    var d = document.querySelector('#callbackForm input[name="tanggal_hubungi"]');
    if (d) d.setAttribute('min', new Date().toISOString().split('T')[0]);
})();
</script>
@endsection
