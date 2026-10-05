@extends('layouts.app')

@section('title', 'S1 Akuntansi - UNSIA | Kuliah Online Terakreditasi')
@section('description', 'S1 Akuntansi UNSIA - Kuliah online PJJ terakreditasi Baik Sekali BAN-PT & EAHEA. Konsentrasi Akuntansi Keuangan, Perpajakan, Auditing. Daftar di pmb.unsia.ac.id')
@section('keywords', 'akuntansi unsia, kuliah online akuntansi, s1 akuntansi, pjj akuntansi, kuliah akuntansi online, kuliah online murah, universitas siber asia, kampus online, PJJ, pembelajaran jarak jauh')

@section('hero')
    @include('partials.page-hero', ['title' => 'S1 Akuntansi', 'crumbs' => ['Program Studi' => null, 'Akuntansi' => null]])
@endsection

@section('content')

<section class="section-padding">
    <div class="container">
        <div class="section-title text-center"><h4>Pendidikan Jarak Jauh (PJJ)</h4><h1>S1 Akuntansi</h1></div>
        <div class="row justify-content-center" style="margin-bottom:40px;">
            <div class="col-lg-4 col-md-6 text-center"><div style="background:#e8f5e9;padding:25px;border-radius:12px;"><i class="fa-solid fa-award" style="font-size:40px;color:#2e7d32;margin-bottom:10px;"></i><h4 style="font-weight:700;">Akreditasi Nasional</h4><p style="font-size:18px;font-weight:600;color:#2e7d32;">Baik Sekali (BAN-PT, 2022)</p></div></div>
            <div class="col-lg-4 col-md-6 text-center"><div style="background:#e3f2fd;padding:25px;border-radius:12px;"><i class="fa-solid fa-globe" style="font-size:40px;color:#1565c0;margin-bottom:10px;"></i><h4 style="font-weight:700;">Akreditasi Internasional</h4><p style="font-size:18px;font-weight:600;color:#1565c0;">EAHEA (Eropa)</p></div></div>
        </div>
    </div>
</section>

<section class="section-padding" style="background:#f8f9fa;">
    <div class="container">
        <div class="section-title text-center"><h4>Konsentrasi</h4><h1>3 Pilihan Peminatan</h1></div>
        <div class="row justify-content-center">
            @php
                $konsentrasi = [
                    ['icon' => 'fa-file-invoice-dollar', 'color' => '#2c7aff', 'judul' => 'Akuntansi Keuangan', 'teks' => 'Pencatatan dan pelaporan keuangan sesuai standar akuntansi'],
                    ['icon' => 'fa-receipt', 'color' => '#f0c040', 'judul' => 'Perpajakan', 'teks' => 'Pengelolaan pajak dan konsultasi perpajakan digital'],
                    ['icon' => 'fa-magnifying-glass-dollar', 'color' => '#e53935', 'judul' => 'Auditing', 'teks' => 'Pemeriksaan dan audit informasi keuangan perusahaan'],
                ];
            @endphp
            @foreach ($konsentrasi as $i => $k)
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.{{ $i + 1 }}s">
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

<section class="section-padding">
    <div class="container">
        <div class="section-title text-center"><h4>Profil Lulusan</h4><h1>Sarjana Akuntansi Berbasis Digital</h1></div>
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <p style="font-size:16px;line-height:1.8;color:#555;">Lulusan menjadi sarjana akuntansi yang menguasai bidang akuntansi dan perpajakan berbasis digital, dengan kemampuan pencatatan laporan keuangan secara digital, termasuk perpajakan dan pemeriksaan informasi keuangan perusahaan.</p>
                <div style="background:#fff3e0;padding:20px;border-radius:12px;border-left:4px solid #f0c040;margin-top:20px;">
                    <p style="margin:0;font-weight:600;"><i class="fa-solid fa-circle-info" style="color:#f0c040;margin-right:8px;"></i> Mahasiswa wajib mengikuti sertifikasi di bidang akuntansi atau perpajakan sebelum lulus untuk meningkatkan daya saing di dunia kerja.</p>
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
                    <li><i class="fa-solid fa-check" style="color:#f0c040;margin-right:10px;"></i> Perusahaan nasional dan swasta</li>
                    <li><i class="fa-solid fa-check" style="color:#f0c040;margin-right:10px;"></i> Sektor perbankan</li>
                    <li><i class="fa-solid fa-check" style="color:#f0c040;margin-right:10px;"></i> Konsultan pajak</li>
                    <li><i class="fa-solid fa-check" style="color:#f0c040;margin-right:10px;"></i> Lembaga pemerintah pusat dan daerah</li>
                    <li><i class="fa-solid fa-check" style="color:#f0c040;margin-right:10px;"></i> Akuntan publik dan auditor</li>
                    <li><i class="fa-solid fa-check" style="color:#f0c040;margin-right:10px;"></i> Financial Analyst dan Controller</li>
                </ul>
            </div>
        </div>
    </div>
</section>

@include('partials.prodi-cta', ['judul' => 'Tertarik Kuliah Akuntansi?'])

@endsection
