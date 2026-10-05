@extends('layouts.app')

@section('title', 'S1 Komunikasi - UNSIA | Kuliah Online Terakreditasi')
@section('description', 'S1 Komunikasi UNSIA - Kuliah online PJJ terakreditasi BAN-PT. Konsentrasi Penyiaran Digital dan Corporate Communication. Daftar di pmb.unsia.ac.id')
@section('keywords', 'komunikasi unsia, kuliah online komunikasi, s1 komunikasi, pjj komunikasi, digital marketing, public relations, kuliah online murah, universitas siber asia, kampus online, PJJ')

@section('hero')
    @include('partials.page-hero', ['title' => 'S1 Komunikasi', 'crumbs' => ['Program Studi' => null, 'Komunikasi' => null]])
@endsection

@section('content')

<section class="section-padding">
    <div class="container">
        <div class="section-title text-center"><h4>Pendidikan Jarak Jauh (PJJ)</h4><h1>S1 Komunikasi</h1></div>
        <div class="row justify-content-center" style="margin-bottom:40px;">
            <div class="col-lg-4 col-md-6 text-center"><div style="background:#e8f5e9;padding:25px;border-radius:12px;"><i class="fa-solid fa-award" style="font-size:40px;color:#2e7d32;margin-bottom:10px;"></i><h4 style="font-weight:700;">Akreditasi Nasional</h4><p style="font-size:18px;font-weight:600;color:#2e7d32;">B (BAN-PT, 2022)</p></div></div>
        </div>
    </div>
</section>

<section class="section-padding" style="background:#f8f9fa;">
    <div class="container">
        <div class="section-title text-center"><h4>Konsentrasi</h4><h1>2 Pilihan Peminatan</h1></div>
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-6 wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.1s">
                <div style="background:#fff;padding:30px;border-radius:12px;box-shadow:0 5px 20px rgba(0,0,0,0.08);margin-bottom:20px;text-align:center;">
                    <i class="fa-solid fa-podcast" style="font-size:35px;color:#2c7aff;margin-bottom:15px;"></i>
                    <h4 style="font-weight:700;">Penyiaran &amp; Komunikasi Digital</h4>
                    <p>Broadcasting &amp; Digital Communication untuk era media modern</p>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.2s">
                <div style="background:#fff;padding:30px;border-radius:12px;box-shadow:0 5px 20px rgba(0,0,0,0.08);margin-bottom:20px;text-align:center;">
                    <i class="fa-solid fa-building" style="font-size:35px;color:#f0c040;margin-bottom:15px;"></i>
                    <h4 style="font-weight:700;">Komunikasi Perusahaan</h4>
                    <p>Corporate Communication untuk hubungan bisnis dan stakeholder</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section-padding">
    <div class="container">
        <div class="section-title text-center"><h4>Track Program</h4><h1>Penguatan Kompetensi</h1></div>
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-6 wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.1s">
                <div style="background:#e3f2fd;padding:30px;border-radius:12px;text-align:center;margin-bottom:20px;">
                    <i class="fa-solid fa-bullhorn" style="font-size:35px;color:#1565c0;margin-bottom:15px;"></i>
                    <h4 style="font-weight:700;">Digital Marketing Communication</h4>
                    <p>Strategi pemasaran dan komunikasi di platform digital</p>
                </div>
            </div>
            <div class="col-lg-5 col-md-6 wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.2s">
                <div style="background:#fce4ec;padding:30px;border-radius:12px;text-align:center;margin-bottom:20px;">
                    <i class="fa-solid fa-globe" style="font-size:35px;color:#c62828;margin-bottom:15px;"></i>
                    <h4 style="font-weight:700;">Cyber Public Relations</h4>
                    <p>Hubungan masyarakat di era digital dan media sosial</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section-padding" style="background:linear-gradient(135deg,#0d1b2a,#1a2d4a);color:#fff;">
    <div class="container">
        <div class="text-center" style="margin-bottom:40px;"><h4 style="color:#f0c040;">Prospek Karir</h4><h1 style="color:#fff;">Peluang Setelah Lulus</h1></div>
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <ul style="list-style:none;padding:0;font-size:16px;line-height:2.2;">
                    <li><i class="fa-solid fa-check" style="color:#f0c040;margin-right:10px;"></i> Content Creator &amp; Digital Strategist</li>
                    <li><i class="fa-solid fa-check" style="color:#f0c040;margin-right:10px;"></i> Public Relations Officer</li>
                    <li><i class="fa-solid fa-check" style="color:#f0c040;margin-right:10px;"></i> Social Media Manager</li>
                    <li><i class="fa-solid fa-check" style="color:#f0c040;margin-right:10px;"></i> Corporate Communication Specialist</li>
                    <li><i class="fa-solid fa-check" style="color:#f0c040;margin-right:10px;"></i> Digital Marketing Manager</li>
                    <li><i class="fa-solid fa-check" style="color:#f0c040;margin-right:10px;"></i> Jurnalis &amp; Broadcaster Digital</li>
                    <li><i class="fa-solid fa-check" style="color:#f0c040;margin-right:10px;"></i> Industri kreatif dan teknologi digital</li>
                </ul>
            </div>
        </div>
    </div>
</section>

@include('partials.prodi-cta', ['judul' => 'Tertarik Kuliah Komunikasi?'])

@endsection
