@extends('layouts.app')

@section('title', 'S1 Manajemen - UNSIA | Kuliah Online Terakreditasi')
@section('description', 'S1 Manajemen UNSIA - Kuliah online PJJ terakreditasi BAN-PT & EAHEA. 4 konsentrasi: Pemasaran, Keuangan, Operasional, SDM. Daftar di pmb.unsia.ac.id')
@section('keywords', 'manajemen unsia, kuliah online manajemen, s1 manajemen, pjj manajemen, kuliah sambil kerja, kuliah online murah, universitas siber asia, kampus online, PJJ, pembelajaran jarak jauh')

@section('hero')
    @include('partials.page-hero', ['title' => 'S1 Manajemen', 'crumbs' => ['Program Studi' => null, 'Manajemen' => null]])
@endsection

@section('content')

<section class="section-padding">
    <div class="container">
        <div class="section-title text-center"><h4>Pendidikan Jarak Jauh (PJJ)</h4><h1>S1 Manajemen</h1></div>
        <div class="row justify-content-center" style="margin-bottom:40px;">
            <div class="col-lg-4 col-md-6 text-center"><div style="background:#e8f5e9;padding:25px;border-radius:12px;"><i class="fa-solid fa-award" style="font-size:40px;color:#2e7d32;margin-bottom:10px;"></i><h4 style="font-weight:700;">Akreditasi Nasional</h4><p style="font-size:18px;font-weight:600;color:#2e7d32;">BAN-PT</p></div></div>
            <div class="col-lg-4 col-md-6 text-center"><div style="background:#e3f2fd;padding:25px;border-radius:12px;"><i class="fa-solid fa-globe" style="font-size:40px;color:#1565c0;margin-bottom:10px;"></i><h4 style="font-weight:700;">Akreditasi Internasional</h4><p style="font-size:18px;font-weight:600;color:#1565c0;">EAHEA (Eropa)</p></div></div>
        </div>
    </div>
</section>

<section class="section-padding" style="background:#f8f9fa;">
    <div class="container">
        <div class="section-title text-center"><h4>Peminatan</h4><h1>4 Pilihan Konsentrasi</h1></div>
        <div class="row">
            @php
                $konsentrasi = [
                    ['icon' => 'fa-bullseye', 'color' => '#2c7aff', 'judul' => 'Manajemen Pemasaran', 'teks' => 'Strategi pemasaran digital dan konvensional'],
                    ['icon' => 'fa-coins', 'color' => '#f0c040', 'judul' => 'Manajemen Keuangan', 'teks' => 'Pengelolaan keuangan dan investasi'],
                    ['icon' => 'fa-industry', 'color' => '#e53935', 'judul' => 'Manajemen Operasional', 'teks' => 'Efisiensi proses produksi dan operasi'],
                    ['icon' => 'fa-users', 'color' => '#43a047', 'judul' => 'Manajemen SDM', 'teks' => 'Pengelolaan sumber daya manusia'],
                ];
            @endphp
            @foreach ($konsentrasi as $i => $k)
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.{{ $i + 1 }}s">
                    <div style="background:#fff;padding:30px;border-radius:12px;box-shadow:0 5px 20px rgba(0,0,0,0.08);margin-bottom:20px;text-align:center;">
                        <i class="fa-solid {{ $k['icon'] }}" style="font-size:35px;color:{{ $k['color'] }};margin-bottom:15px;"></i>
                        <h4 style="font-weight:700;">{{ $k['judul'] }}</h4>
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
                <p style="font-size:16px;line-height:1.8;color:rgba(255,255,255,0.8);">Kurikulum disesuaikan dengan tantangan Revolusi Industri 4.0, fokus pada manajemen berbasis teknologi informasi digital modern.</p>
                <ul style="list-style:none;padding:0;font-size:16px;line-height:2.2;margin-top:20px;">
                    <li><i class="fa-solid fa-check" style="color:#f0c040;margin-right:10px;"></i> Peluang besar di sektor industri nasional &amp; internasional</li>
                    <li><i class="fa-solid fa-check" style="color:#f0c040;margin-right:10px;"></i> Karir global dengan akreditasi EAHEA</li>
                    <li><i class="fa-solid fa-check" style="color:#f0c040;margin-right:10px;"></i> Akses melanjutkan S2 dalam dan luar negeri</li>
                    <li><i class="fa-solid fa-check" style="color:#f0c040;margin-right:10px;"></i> Manager, Konsultan Bisnis, Entrepreneur</li>
                    <li><i class="fa-solid fa-check" style="color:#f0c040;margin-right:10px;"></i> HRD, Marketing Manager, Financial Analyst</li>
                </ul>
            </div>
        </div>
    </div>
</section>

@include('partials.prodi-cta', ['judul' => 'Tertarik Kuliah Manajemen?'])

@endsection
