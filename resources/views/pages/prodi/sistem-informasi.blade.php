@extends('layouts.app')

@section('title', 'S1 Sistem Informasi - UNSIA | Kuliah Online Terakreditasi')
@section('description', 'S1 Sistem Informasi UNSIA - Kuliah online PJJ terakreditasi BAN-PT & EAHEA. Peminatan E-Business dan Business Intelligence. Daftar di pmb.unsia.ac.id')
@section('keywords', 'sistem informasi unsia, kuliah online sistem informasi, s1 sistem informasi, pjj sistem informasi, kuliah online murah, universitas siber asia, kampus online, PJJ, pembelajaran jarak jauh')

@section('hero')
    @include('partials.page-hero', ['title' => 'S1 Sistem Informasi', 'crumbs' => ['Program Studi' => null, 'Sistem Informasi' => null]])
@endsection

@section('content')

<!-- AKREDITASI -->
<section class="section-padding">
    <div class="container">
        <div class="section-title text-center">
            <h4>Pendidikan Jarak Jauh (PJJ)</h4>
            <h1>S1 Sistem Informasi</h1>
        </div>
        <div class="row justify-content-center" style="margin-bottom:40px;">
            <div class="col-lg-4 col-md-6 text-center"><div style="background:#e8f5e9;padding:25px;border-radius:12px;"><i class="fa-solid fa-award" style="font-size:40px;color:#2e7d32;margin-bottom:10px;"></i><h4 style="font-weight:700;">Akreditasi Nasional</h4><p style="font-size:18px;font-weight:600;color:#2e7d32;">Baik Sekali (BAN-PT)</p></div></div>
            <div class="col-lg-4 col-md-6 text-center"><div style="background:#e3f2fd;padding:25px;border-radius:12px;"><i class="fa-solid fa-globe" style="font-size:40px;color:#1565c0;margin-bottom:10px;"></i><h4 style="font-weight:700;">Akreditasi Internasional</h4><p style="font-size:18px;font-weight:600;color:#1565c0;">EAHEA (Eropa)</p></div></div>
        </div>
    </div>
</section>

<!-- PEMINATAN -->
<section class="section-padding" style="background:#f8f9fa;">
    <div class="container">
        <div class="section-title text-center"><h4>Peminatan</h4><h1>Pilihan Konsentrasi</h1></div>
        <div class="row">
            <div class="col-lg-6 col-md-6 wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.1s">
                <div style="background:#fff;padding:30px;border-radius:12px;box-shadow:0 5px 20px rgba(0,0,0,0.08);margin-bottom:20px;">
                    <i class="fa-solid fa-cart-shopping" style="font-size:35px;color:#2c7aff;margin-bottom:15px;"></i>
                    <h3 style="font-weight:700;">E-Business</h3>
                    <p>Fokus pada strategi e-commerce, analisis data pelanggan, pengembangan platform online, dan keamanan siber untuk bisnis digital.</p>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.2s">
                <div style="background:#fff;padding:30px;border-radius:12px;box-shadow:0 5px 20px rgba(0,0,0,0.08);margin-bottom:20px;">
                    <i class="fa-solid fa-chart-pie" style="font-size:35px;color:#f0c040;margin-bottom:15px;"></i>
                    <h3 style="font-weight:700;">Business Intelligence</h3>
                    <p>Mengembangkan kemampuan mengumpulkan dan menganalisis data bisnis untuk pengambilan keputusan strategis.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- PROFIL LULUSAN -->
<section class="section-padding">
    <div class="container">
        <div class="section-title text-center"><h4>Prospek Karir</h4><h1>Profil Lulusan</h1></div>
        <div class="row">
            @php
                $profil = [
                    ['icon' => 'fa-user-tie', 'nama' => 'Chief Information Officer'],
                    ['icon' => 'fa-server', 'nama' => 'IT Director'],
                    ['icon' => 'fa-database', 'nama' => 'Big Data Scientist'],
                    ['icon' => 'fa-chart-bar', 'nama' => 'BI Manager'],
                    ['icon' => 'fa-magnifying-glass-chart', 'nama' => 'System Analyst'],
                    ['icon' => 'fa-store', 'nama' => 'E-Business Specialist'],
                    ['icon' => 'fa-diagram-project', 'nama' => 'IT Planning Director'],
                    ['icon' => 'fa-rocket', 'nama' => 'Business Dev Manager'],
                ];
            @endphp
            @foreach ($profil as $p)
                <div class="col-lg-3 col-sm-6" style="margin-bottom:20px;">
                    <div style="text-align:center;padding:20px;">
                        <i class="fa-solid {{ $p['icon'] }}" style="font-size:30px;color:#2c7aff;margin-bottom:10px;"></i>
                        <h5 style="font-weight:600;">{{ $p['nama'] }}</h5>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- KOMPETENSI -->
<section class="section-padding" style="background:linear-gradient(135deg,#0d1b2a,#1a2d4a);color:#fff;">
    <div class="container">
        <div class="text-center" style="margin-bottom:40px;"><h4 style="color:#f0c040;">Kompetensi Lulusan</h4><h1 style="color:#fff;">Yang Akan Kamu Kuasai</h1></div>
        <div class="row">
            @php
                $kompetensi = [
                    ['icon' => 'fa-gears', 'nama' => 'Manajemen Sistem Informasi'],
                    ['icon' => 'fa-chart-line', 'nama' => 'Analisis Data & Business Intelligence'],
                    ['icon' => 'fa-cart-shopping', 'nama' => 'Pengembangan E-Business'],
                    ['icon' => 'fa-shield-halved', 'nama' => 'Keamanan Siber'],
                    ['icon' => 'fa-list-check', 'nama' => 'Manajemen Proyek IT'],
                    ['icon' => 'fa-brain', 'nama' => 'Pengambilan Keputusan Berbasis Data'],
                ];
            @endphp
            @foreach ($kompetensi as $k)
                <div class="col-lg-4 col-md-6" style="margin-bottom:20px;">
                    <div style="border:1px solid rgba(255,255,255,0.15);padding:25px;border-radius:12px;">
                        <i class="fa-solid {{ $k['icon'] }}" style="font-size:28px;color:#f0c040;margin-bottom:10px;"></i>
                        <h5 style="color:#fff;">{{ $k['nama'] }}</h5>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

@include('partials.prodi-cta', ['judul' => 'Tertarik Kuliah Sistem Informasi?'])

@endsection
