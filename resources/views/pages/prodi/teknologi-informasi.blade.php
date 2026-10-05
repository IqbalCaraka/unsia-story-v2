@extends('layouts.app')

@section('title', 'S1 Teknologi Informasi - UNSIA | Kuliah Online Terakreditasi')
@section('description', 'S1 Teknologi Informasi UNSIA - Kuliah online PJJ gelar S.Kom. Fokus Infrastruktur IT dan Keamanan Siber. Daftar di pmb.unsia.ac.id')
@section('keywords', 'teknologi informasi unsia, kuliah online ti, s1 teknologi informasi, pjj ti, keamanan siber, cloud computing, kuliah online murah, universitas siber asia, kampus online, PJJ')

@section('hero')
    @include('partials.page-hero', ['title' => 'S1 Teknologi Informasi', 'crumbs' => ['Program Studi' => null, 'Teknologi Informasi' => null]])
@endsection

@section('content')

<section class="section-padding">
    <div class="container">
        <div class="section-title text-center"><h4>Pendidikan Jarak Jauh (PJJ) - Gelar S.Kom</h4><h1>S1 Teknologi Informasi</h1></div>
        <div class="row justify-content-center" style="margin-bottom:40px;">
            <div class="col-lg-5 col-md-6 text-center"><div style="background:#e3f2fd;padding:25px;border-radius:12px;"><i class="fa-solid fa-shield-halved" style="font-size:40px;color:#1565c0;margin-bottom:10px;"></i><h4 style="font-weight:700;">Fokus Utama</h4><p style="font-size:18px;font-weight:600;color:#1565c0;">Infrastruktur IT &amp; Keamanan Siber</p></div></div>
        </div>
    </div>
</section>

<section class="section-padding" style="background:#f8f9fa;">
    <div class="container">
        <div class="section-title text-center"><h4>Profil Lulusan</h4><h1>4 Profil Profesional</h1></div>
        <div class="row">
            @php
                $profil = [
                    ['icon' => 'fa-magnifying-glass-chart', 'color' => '#2c7aff', 'judul' => 'Profesional Analitis', 'teks' => 'Computing untuk menyelesaikan permasalahan kompleks infrastruktur TI dan keamanan siber'],
                    ['icon' => 'fa-gears', 'color' => '#f0c040', 'judul' => 'Profesional Implementatif', 'teks' => 'Merancang dan mengintegrasikan solusi teknologi industri 4.0'],
                    ['icon' => 'fa-handshake', 'color' => '#43a047', 'judul' => 'Profesional Etis', 'teks' => 'Tanggung jawab, kewirausahaan, dan menghargai keberagaman budaya'],
                    ['icon' => 'fa-lightbulb', 'color' => '#e53935', 'judul' => 'Profesional Inovatif', 'teks' => 'Pemikiran logis, kritis, dan ilmiah dengan dokumentasi data'],
                ];
            @endphp
            @foreach ($profil as $i => $p)
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.{{ $i + 1 }}s">
                    <div style="background:#fff;padding:30px;border-radius:12px;box-shadow:0 5px 20px rgba(0,0,0,0.08);margin-bottom:20px;text-align:center;">
                        <i class="fa-solid {{ $p['icon'] }}" style="font-size:35px;color:{{ $p['color'] }};margin-bottom:15px;"></i>
                        <h4 style="font-weight:700;">{{ $p['judul'] }}</h4>
                        <p>{{ $p['teks'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<section class="section-padding">
    <div class="container">
        <div class="section-title text-center"><h4>Kompetensi</h4><h1>Yang Akan Kamu Kuasai</h1></div>
        <div class="row justify-content-center">
            @php
                $kompetensi = [
                    ['icon' => 'fa-server', 'nama' => 'Infrastruktur TI'],
                    ['icon' => 'fa-shield-halved', 'nama' => 'Keamanan Siber'],
                    ['icon' => 'fa-network-wired', 'nama' => 'Jaringan Komputer'],
                    ['icon' => 'fa-cloud', 'nama' => 'Cloud Computing'],
                    ['icon' => 'fa-lock', 'nama' => 'Kriptografi'],
                    ['icon' => 'fa-clipboard-check', 'nama' => 'Audit Keamanan'],
                ];
            @endphp
            @foreach ($kompetensi as $k)
                <div class="col-lg-4 col-sm-6" style="margin-bottom:20px;">
                    <div style="text-align:center;padding:25px;background:#f8f9fa;border-radius:12px;">
                        <i class="fa-solid {{ $k['icon'] }}" style="font-size:30px;color:#2c7aff;margin-bottom:10px;"></i>
                        <h5 style="font-weight:600;">{{ $k['nama'] }}</h5>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<section class="section-padding" style="background:linear-gradient(135deg,#0d1b2a,#1a2d4a);color:#fff;">
    <div class="container">
        <div class="text-center" style="margin-bottom:40px;"><h4 style="color:#f0c040;">Prospek Karir</h4><h1 style="color:#fff;">Peluang Setelah Lulus</h1></div>
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <ul style="list-style:none;padding:0;font-size:16px;line-height:2.2;">
                    <li><i class="fa-solid fa-check" style="color:#f0c040;margin-right:10px;"></i> Arsitek Jaringan — merancang infrastruktur enterprise</li>
                    <li><i class="fa-solid fa-check" style="color:#f0c040;margin-right:10px;"></i> Pengembang Cloud Computing — aplikasi &amp; infrastruktur cloud</li>
                    <li><i class="fa-solid fa-check" style="color:#f0c040;margin-right:10px;"></i> Analis Keamanan Siber — Security Operation Center</li>
                    <li><i class="fa-solid fa-check" style="color:#f0c040;margin-right:10px;"></i> Auditor Keamanan Informasi — audit &amp; penilaian risiko</li>
                    <li><i class="fa-solid fa-check" style="color:#f0c040;margin-right:10px;"></i> DevOps Engineer &amp; System Administrator</li>
                </ul>
            </div>
        </div>
    </div>
</section>

@include('partials.prodi-cta', ['judul' => 'Tertarik Kuliah Teknologi Informasi?'])

@endsection
