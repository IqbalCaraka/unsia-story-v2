@extends('layouts.app')

@section('title', 'S1 Informatika - UNSIA | Kuliah Online Terakreditasi')
@section('description', 'S1 Informatika UNSIA - Kuliah online PJJ terakreditasi BAN-PT & EAHEA. Peminatan Data Science dan Network Specialist. Daftar di pmb.unsia.ac.id')
@section('keywords', 'informatika unsia, kuliah online informatika, s1 informatika, pjj informatika, data science, kuliah online murah, universitas siber asia, kampus online, PJJ, pembelajaran jarak jauh')

@section('hero')
    @include('partials.page-hero', ['title' => 'S1 Informatika', 'crumbs' => ['Program Studi' => null, 'Informatika' => null]])
@endsection

@section('content')

<section class="section-padding">
    <div class="container">
        <div class="section-title text-center"><h4>Pendidikan Jarak Jauh (PJJ)</h4><h1>S1 Informatika</h1></div>
        <div class="row justify-content-center" style="margin-bottom:40px;">
            <div class="col-lg-4 col-md-6 text-center"><div style="background:#e8f5e9;padding:25px;border-radius:12px;"><i class="fa-solid fa-award" style="font-size:40px;color:#2e7d32;margin-bottom:10px;"></i><h4 style="font-weight:700;">Akreditasi Nasional</h4><p style="font-size:18px;font-weight:600;color:#2e7d32;">B (BAN-PT, 2022)</p></div></div>
            <div class="col-lg-4 col-md-6 text-center"><div style="background:#e3f2fd;padding:25px;border-radius:12px;"><i class="fa-solid fa-globe" style="font-size:40px;color:#1565c0;margin-bottom:10px;"></i><h4 style="font-weight:700;">Akreditasi Internasional</h4><p style="font-size:18px;font-weight:600;color:#1565c0;">EAHEA (Eropa)</p></div></div>
        </div>
    </div>
</section>

<section class="section-padding" style="background:#f8f9fa;">
    <div class="container">
        <div class="section-title text-center"><h4>Peminatan</h4><h1>Pilihan Konsentrasi</h1></div>
        <div class="row">
            <div class="col-lg-6 col-md-6 wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.1s">
                <div style="background:#fff;padding:30px;border-radius:12px;box-shadow:0 5px 20px rgba(0,0,0,0.08);margin-bottom:20px;">
                    <i class="fa-solid fa-brain" style="font-size:35px;color:#2c7aff;margin-bottom:15px;"></i>
                    <h3 style="font-weight:700;">Data Science</h3>
                    <p>Fokus pada kecerdasan buatan, pengelolaan data, algoritma supervised dan unsupervised untuk analisis data canggih.</p>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.2s">
                <div style="background:#fff;padding:30px;border-radius:12px;box-shadow:0 5px 20px rgba(0,0,0,0.08);margin-bottom:20px;">
                    <i class="fa-solid fa-network-wired" style="font-size:35px;color:#f0c040;margin-bottom:15px;"></i>
                    <h3 style="font-weight:700;">Network Specialist</h3>
                    <p>Fokus pada perancangan jaringan komputer, sistem operasi, dan konfigurasi keamanan informasi.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section-padding">
    <div class="container">
        <div class="section-title text-center"><h4>Kompetensi</h4><h1>Yang Akan Kamu Kuasai</h1></div>
        <div class="row">
            @php
                $kompetensi = [
                    ['icon' => 'fa-code', 'judul' => 'Pemrograman', 'teks' => 'Menguasai berbagai bahasa pemrograman modern'],
                    ['icon' => 'fa-server', 'judul' => 'Jaringan Komputer', 'teks' => 'Merancang dan mengelola infrastruktur jaringan'],
                    ['icon' => 'fa-shield-halved', 'judul' => 'Keamanan Cyber', 'teks' => 'Melindungi sistem dan data dari ancaman siber'],
                    ['icon' => 'fa-robot', 'judul' => 'Kecerdasan Buatan', 'teks' => 'Menerapkan AI dan machine learning'],
                    ['icon' => 'fa-database', 'judul' => 'Analisis Data', 'teks' => 'Mengolah dan menganalisis data dalam skala besar'],
                    ['icon' => 'fa-gears', 'judul' => 'Manajemen SI', 'teks' => 'Mengelola sistem informasi organisasi'],
                ];
            @endphp
            @foreach ($kompetensi as $k)
                <div class="col-lg-4 col-sm-6" style="margin-bottom:20px;">
                    <div style="text-align:center;padding:25px;background:#f8f9fa;border-radius:12px;">
                        <i class="fa-solid {{ $k['icon'] }}" style="font-size:30px;color:#2c7aff;margin-bottom:10px;"></i>
                        <h5 style="font-weight:600;">{{ $k['judul'] }}</h5>
                        <p>{{ $k['teks'] }}</p>
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
                    <li><i class="fa-solid fa-check" style="color:#f0c040;margin-right:10px;"></i> Peluang luas di sektor industri nasional &amp; internasional</li>
                    <li><i class="fa-solid fa-check" style="color:#f0c040;margin-right:10px;"></i> Kesempatan melanjutkan S2 di dalam dan luar negeri</li>
                    <li><i class="fa-solid fa-check" style="color:#f0c040;margin-right:10px;"></i> Software Developer &amp; Engineer</li>
                    <li><i class="fa-solid fa-check" style="color:#f0c040;margin-right:10px;"></i> Data Scientist &amp; Data Analyst</li>
                    <li><i class="fa-solid fa-check" style="color:#f0c040;margin-right:10px;"></i> Network Engineer &amp; Security Specialist</li>
                    <li><i class="fa-solid fa-check" style="color:#f0c040;margin-right:10px;"></i> AI/Machine Learning Engineer</li>
                </ul>
            </div>
        </div>
    </div>
</section>

@include('partials.prodi-cta', ['judul' => 'Tertarik Kuliah Informatika?'])

@endsection
