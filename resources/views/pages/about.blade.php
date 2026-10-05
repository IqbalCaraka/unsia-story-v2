@extends('layouts.app')

@section('title', 'Tentang Kami - UNSIA Story | Universitas Siber Asia')
@section('description', 'Tentang UNSIA Story - Official Marketing Representative Universitas Siber Asia. Panduan pendaftaran kuliah online, promo potongan UKT, dan info program studi UNSIA.')
@section('keywords', 'tentang unsia, universitas siber asia, kuliah online, marketing representative unsia, pendaftaran unsia, kuliah sambil kerja')

@section('hero')
    @include('partials.page-hero', ['title' => 'Tentang Kami', 'crumbs' => ['Tentang' => null]])
@endsection

@section('content')

<!-- SIAPA KAMI -->
<section class="section-padding">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 col-md-12 wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.1s">
                <div style="text-align:center;margin-bottom:30px;">
                    <img src="{{ asset('assets/images/mascot-unsiro.png') }}" class="img-fluid" alt="Maskot UNSIA - Unsiro" style="max-height:450px;">
                </div>
            </div>
            <div class="col-lg-6 col-md-12 wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.2s">
                <h4 style="color:#2c7aff;font-size:14px;letter-spacing:2px;text-transform:uppercase;margin-bottom:10px;">Siapa Kami?</h4>
                <h2 style="font-weight:700;font-size:32px;margin-bottom:20px;">UNSIA Story — Mitra Pemasaran Resmi Universitas Siber Asia</h2>
                <p style="color:#555;font-size:16px;line-height:1.8;margin-bottom:15px;"><strong>UNSIA Story</strong> adalah platform digital yang dikelola secara independen sebagai <strong>mitra pemasaran resmi</strong> Universitas Siber Asia (UNSIA). Kami <strong>bukan</strong> situs resmi universitas — situs resmi UNSIA dapat diakses di <a href="https://unsia.ac.id" target="_blank" style="color:#2c7aff;font-weight:600;">unsia.ac.id</a>.</p>
                <p style="color:#555;font-size:16px;line-height:1.8;margin-bottom:10px;">Peran kami adalah membantu calon mahasiswa yang ingin <strong>kuliah online</strong> dengan menyediakan informasi lengkap seputar program studi, biaya kuliah, panduan pendaftaran, dan promo potongan UKT melalui kode referral.</p>
                <p style="color:#555;font-size:16px;line-height:1.8;margin-bottom:10px;">Seluruh proses pendaftaran mahasiswa baru tetap dilakukan melalui portal resmi universitas di <a href="https://pmb.unsia.ac.id" target="_blank" style="color:#2c7aff;font-weight:600;">pmb.unsia.ac.id</a>. Kode referral <strong>unsia.my.id</strong> yang kami berikan dapat digunakan saat pendaftaran di portal resmi tersebut untuk mendapatkan potongan biaya UKT.</p>
                <div style="background:#fff3e0;padding:15px;border-radius:8px;border-left:4px solid #f0c040;margin-bottom:20px;">
                    <p style="margin:0;font-size:14px;color:#555;"><strong>Kontak Bisnis:</strong><br>
                    <i class="fa-solid fa-envelope" style="margin-right:5px;"></i> <a href="mailto:unsia.story@gmail.com" style="color:#2c7aff;">unsia.story@gmail.com</a><br>
                    <i class="fa-brands fa-whatsapp" style="margin-right:5px;"></i> <a href="https://wa.me/628133331686" style="color:#2c7aff;">0813-3333-1686</a><br>
                    <i class="fa-solid fa-location-dot" style="margin-right:5px;"></i> Jl. Monumen Pancasila Sakti 69, Lubang Buaya, Kec. Cipayung, Jakarta Timur, DKI Jakarta 13810</p>
                </div>
                <div style="display:flex;gap:15px;flex-wrap:wrap;">
                    <div style="background:#e3f2fd;padding:15px 20px;border-radius:10px;flex:1;min-width:140px;text-align:center;">
                        <i class="fa-solid fa-graduation-cap" style="font-size:24px;color:#2c7aff;margin-bottom:5px;"></i>
                        <h5 style="font-weight:700;margin:0;">6 Prodi</h5>
                        <small style="color:#666;">S1 - PJJ</small>
                    </div>
                    <div style="background:#e8f5e9;padding:15px 20px;border-radius:10px;flex:1;min-width:140px;text-align:center;">
                        <i class="fa-solid fa-laptop" style="font-size:24px;color:#2e7d32;margin-bottom:5px;"></i>
                        <h5 style="font-weight:700;margin:0;">100% Online</h5>
                        <small style="color:#666;">Dari mana aja</small>
                    </div>
                    <div style="background:#fff3e0;padding:15px 20px;border-radius:10px;flex:1;min-width:140px;text-align:center;">
                        <i class="fa-solid fa-certificate" style="font-size:24px;color:#e65100;margin-bottom:5px;"></i>
                        <h5 style="font-weight:700;margin:0;">Terakreditasi</h5>
                        <small style="color:#666;">BAN-PT &amp; EAHEA</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- KENAPA UNSIA -->
<section class="section-padding" style="background:#f8f9fa;">
    <div class="container">
        <div class="section-title text-center">
            <h4>Kenapa Pilih UNSIA?</h4>
            <h1>Kampus Online Pertama di Indonesia</h1>
        </div>
        <div class="row">
            @php
                $keunggulan = [
                    ['icon' => 'fa-clock', 'color' => '#2c7aff', 'judul' => 'Fleksibel 24/7', 'teks' => 'Akses materi kuliah kapan aja, di mana aja. Cocok buat kamu yang kerja, bisnis, atau punya kesibukan lain.'],
                    ['icon' => 'fa-wallet', 'color' => '#f0c040', 'judul' => 'Biaya Terjangkau', 'teks' => 'UKT Rp3 juta/semester, bisa dicicil 3x. Pakai kode referral <strong>unsia.my.id</strong>: potongan Rp500.000 (semester 1) + cashback Rp150.000 (semester 2). Lulus dalam <strong>3,5 tahun</strong>!'],
                    ['icon' => 'fa-award', 'color' => '#2e7d32', 'judul' => 'Ijazah Resmi', 'teks' => 'Terdaftar di Kemendikbud, terakreditasi BAN-PT, dan beberapa prodi terakreditasi internasional EAHEA.'],
                    ['icon' => 'fa-chalkboard-user', 'color' => '#e53935', 'judul' => 'Dosen Berpengalaman', 'teks' => 'Diajar oleh dosen praktisi dan akademisi yang berpengalaman di bidangnya masing-masing.'],
                    ['icon' => 'fa-briefcase', 'color' => '#7b1fa2', 'judul' => 'Kuliah Sambil Kerja', 'teks' => 'Jadwal fleksibel yang dirancang khusus untuk kamu yang ingin meningkatkan karir tanpa harus resign.'],
                    ['icon' => 'fa-headset', 'color' => '#00838f', 'judul' => 'Support 24 Jam', 'teks' => 'Tim kami siap membantu kamu kapan saja melalui WhatsApp di 0813-3333-1686.'],
                ];
            @endphp
            @foreach ($keunggulan as $i => $item)
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.{{ $i + 1 }}s" style="margin-bottom:25px;">
                    <div style="background:#fff;padding:30px;border-radius:12px;box-shadow:0 5px 20px rgba(0,0,0,0.06);height:100%;">
                        <i class="fa-solid {{ $item['icon'] }}" style="font-size:35px;color:{{ $item['color'] }};margin-bottom:15px;"></i>
                        <h4 style="font-weight:700;">{{ $item['judul'] }}</h4>
                        <p style="color:#555;">{!! $item['teks'] !!}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- PANDUAN PENDAFTARAN -->
<section class="section-padding">
    <div class="container">
        <div class="section-title text-center">
            <h4>Panduan Pendaftaran</h4>
            <h1>Cara Daftar Kuliah di UNSIA</h1>
        </div>
        <div class="row">
            <div class="col-lg-6 col-md-12 wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.1s">
                <div style="margin-bottom:20px;">
                    <div style="display:flex;align-items:flex-start;gap:15px;margin-bottom:20px;">
                        <div style="background:#2c7aff;color:#fff;width:40px;height:40px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:700;flex-shrink:0;">1</div>
                        <div><h5 style="font-weight:700;margin-bottom:5px;">Buka pmb.unsia.ac.id</h5><p style="color:#555;margin:0;">Kunjungi portal PMB dan klik tombol "Daftar" untuk membuat akun baru.</p></div>
                    </div>
                    <div style="display:flex;align-items:flex-start;gap:15px;margin-bottom:20px;">
                        <div style="background:#2c7aff;color:#fff;width:40px;height:40px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:700;flex-shrink:0;">2</div>
                        <div><h5 style="font-weight:700;margin-bottom:5px;">Isi Data Diri</h5><p style="color:#555;margin:0;">Lengkapi formulir pendaftaran dengan data diri kamu (nama, email, no HP, dll).</p></div>
                    </div>
                    <div style="display:flex;align-items:flex-start;gap:15px;margin-bottom:20px;">
                        <div style="background:#2c7aff;color:#fff;width:40px;height:40px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:700;flex-shrink:0;">3</div>
                        <div><h5 style="font-weight:700;margin-bottom:5px;">Bayar Biaya Pendaftaran</h5><p style="color:#555;margin:0;">Biaya pendaftaran hanya <strong>Rp175.000</strong> (sekali bayar).</p></div>
                    </div>
                    <div style="display:flex;align-items:flex-start;gap:15px;margin-bottom:20px;">
                        <div style="background:#2c7aff;color:#fff;width:40px;height:40px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:700;flex-shrink:0;">4</div>
                        <div><h5 style="font-weight:700;margin-bottom:5px;">Login ke Akun PMB</h5><p style="color:#555;margin:0;">Cek email kamu untuk mendapatkan ID dan PIN login.</p></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-12 wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.2s">
                <div style="margin-bottom:20px;">
                    <div style="display:flex;align-items:flex-start;gap:15px;margin-bottom:20px;">
                        <div style="background:#f0c040;color:#0d1b2a;width:40px;height:40px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:700;flex-shrink:0;">5</div>
                        <div><h5 style="font-weight:700;margin-bottom:5px;">Isi Biodata &amp; Masukkan Kode Referral</h5><p style="color:#555;margin:0;">Lengkapi biodata, lalu ketik <strong style="color:#2c7aff;font-size:18px;">unsia.my.id</strong> di kolom referral — potongan <strong>Rp500.000</strong> semester pertama + cashback <strong>Rp150.000</strong> semester kedua!</p></div>
                    </div>
                    <div style="display:flex;align-items:flex-start;gap:15px;margin-bottom:20px;">
                        <div style="background:#f0c040;color:#0d1b2a;width:40px;height:40px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:700;flex-shrink:0;">6</div>
                        <div><h5 style="font-weight:700;margin-bottom:5px;">Ikuti Tes Online (CBT)</h5><p style="color:#555;margin:0;">Lakukan tes seleksi secara online dari rumah.</p></div>
                    </div>
                    <div style="display:flex;align-items:flex-start;gap:15px;margin-bottom:20px;">
                        <div style="background:#f0c040;color:#0d1b2a;width:40px;height:40px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:700;flex-shrink:0;">7</div>
                        <div><h5 style="font-weight:700;margin-bottom:5px;">Tunggu Hasil Seleksi</h5><p style="color:#555;margin:0;">Hasil keluar dalam 2-5 hari kerja.</p></div>
                    </div>
                    <div style="display:flex;align-items:flex-start;gap:15px;margin-bottom:20px;">
                        <div style="background:#f0c040;color:#0d1b2a;width:40px;height:40px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:700;flex-shrink:0;">8</div>
                        <div><h5 style="font-weight:700;margin-bottom:5px;">Daftar Ulang &amp; Bayar UKT</h5><p style="color:#555;margin:0;">UKT <strong>Rp3.000.000/semester</strong>, bisa dicicil 3x. Dengan referral: semester 1 jadi <strong>Rp2.500.000</strong> + cashback <strong>Rp150.000</strong> di semester 2!</p></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- PROMO REFERRAL -->
<section class="section-padding" style="background:linear-gradient(135deg,#0d1b2a,#1a2d4a);">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-7 col-md-12 wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.1s">
                <h4 style="color:#f0c040;font-size:14px;letter-spacing:2px;text-transform:uppercase;margin-bottom:10px;">Promo Spesial</h4>
                <h2 style="color:#fff;font-size:32px;font-weight:700;margin-bottom:15px;">Dapatkan Potongan UKT Rp500.000!</h2>
                <p style="color:rgba(255,255,255,0.75);font-size:16px;line-height:1.8;margin-bottom:20px;">Gunakan kode referral di bawah ini saat mendaftar di <strong style="color:#fff;">pmb.unsia.ac.id</strong> untuk mendapatkan potongan biaya UKT di <strong style="color:#fff;">semester pertama</strong>. Masukkan kode <strong style="color:#fff;">sebelum</strong> melakukan pembayaran UKT agar potongan langsung berlaku.</p>
                <ul style="list-style:none;padding:0;color:rgba(255,255,255,0.8);font-size:15px;line-height:2.2;">
                    <li><i class="fa-solid fa-check-circle" style="color:#f0c040;margin-right:10px;"></i> UKT normal: <strong style="color:#fff;">Rp3.000.000/semester</strong></li>
                    <li><i class="fa-solid fa-check-circle" style="color:#f0c040;margin-right:10px;"></i> Potongan semester 1 (cicilan ke-3): <strong style="color:#f0c040;">- Rp500.000</strong> → bayar <strong style="color:#fff;font-size:18px;">Rp2.500.000</strong></li>
                    <li><i class="fa-solid fa-check-circle" style="color:#f0c040;margin-right:10px;"></i> Cashback semester 2 (cicilan ke-3): <strong style="color:#f0c040;">Rp150.000</strong> → bayar <strong style="color:#fff;font-size:18px;">Rp2.850.000</strong></li>
                    <li><i class="fa-solid fa-check-circle" style="color:#f0c040;margin-right:10px;"></i> Semester selanjutnya: <strong style="color:#fff;">Rp3.000.000</strong> (bisa cicil 3x)</li>
                    <li><i class="fa-solid fa-check-circle" style="color:#f0c040;margin-right:10px;"></i> Kesempatan lulus dalam <strong style="color:#fff;">3,5 tahun!</strong></li>
                </ul>
            </div>
            <div class="col-lg-5 col-md-12 text-center wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.2s">
                <div style="background:rgba(255,255,255,0.08);border:2px solid rgba(255,255,255,0.15);border-radius:16px;padding:40px 30px;margin-top:20px;">
                    <p style="color:rgba(255,255,255,0.6);font-size:13px;text-transform:uppercase;letter-spacing:2px;margin-bottom:10px;">Kode Referral</p>
                    <div style="background:linear-gradient(135deg,#f0c040,#e6a817);color:#0d1b2a;padding:20px;border-radius:12px;font-size:32px;font-weight:800;letter-spacing:3px;margin-bottom:20px;">unsia.my.id</div>
                    <p style="color:rgba(255,255,255,0.6);font-size:13px;margin-bottom:20px;">Masukkan kode ini di formulir pendaftaran PMB</p>
                    <a href="https://pmb.unsia.ac.id" target="_blank" style="display:inline-block;background:#f0c040;color:#0d1b2a;padding:14px 30px;border-radius:30px;text-decoration:none;font-weight:700;font-size:15px;"><i class="fa-solid fa-arrow-right"></i> Daftar Sekarang</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- PROGRAM STUDI -->
<section class="section-padding">
    <div class="container">
        <div class="section-title text-center">
            <h4>Program Studi</h4>
            <h1>6 Jurusan S1 yang Bisa Kamu Pilih</h1>
        </div>
        <div class="row">
            @php
                $prodiList = [
                    ['slug' => 'sistem-informasi', 'nama' => 'Sistem Informasi', 'icon' => 'fa-database', 'desc' => 'E-Business & Business Intelligence'],
                    ['slug' => 'informatika', 'nama' => 'Informatika', 'icon' => 'fa-code', 'desc' => 'Data Science & Network Specialist'],
                    ['slug' => 'manajemen', 'nama' => 'Manajemen', 'icon' => 'fa-chart-line', 'desc' => 'Pemasaran, Keuangan, Operasi, SDM'],
                    ['slug' => 'akuntansi', 'nama' => 'Akuntansi', 'icon' => 'fa-calculator', 'desc' => 'Keuangan, Perpajakan, Auditing'],
                    ['slug' => 'komunikasi', 'nama' => 'Komunikasi', 'icon' => 'fa-bullhorn', 'desc' => 'Broadcasting & Corporate Comm'],
                    ['slug' => 'teknologi-informasi', 'nama' => 'Teknologi Informasi', 'icon' => 'fa-network-wired', 'desc' => 'Infrastruktur IT & Keamanan Siber'],
                ];
            @endphp
            @foreach ($prodiList as $i => $prodi)
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.{{ $i + 1 }}s" style="margin-bottom:20px;">
                    <a href="{{ route('prodi', $prodi['slug']) }}" style="text-decoration:none;">
                        <div style="background:#f8f9fa;padding:25px;border-radius:12px;text-align:center;transition:transform 0.3s;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                            <i class="fa-solid {{ $prodi['icon'] }}" style="font-size:30px;color:#2c7aff;margin-bottom:10px;"></i>
                            <h5 style="font-weight:700;color:#0d1b2a;">{{ $prodi['nama'] }}</h5>
                            <p style="color:#666;font-size:14px;margin:0;">{{ $prodi['desc'] }}</p>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- CTA -->
<section class="section-padding" style="background:#f8f9fa;">
    <div class="container text-center">
        <h2 style="font-weight:700;margin-bottom:15px;">Ada Pertanyaan?</h2>
        <p style="color:#555;margin-bottom:25px;font-size:16px;">Tim UNSIA Story siap bantu kamu 24/7. Hubungi kami sekarang!</p>
        <a href="https://pmb.unsia.ac.id" target="_blank" style="display:inline-block;background:#2c7aff;color:#fff;padding:15px 35px;border-radius:30px;text-decoration:none;font-weight:700;font-size:16px;"><i class="fa-solid fa-arrow-right"></i> Daftar di PMB UNSIA</a>
        <a href="https://wa.me/628133331686?text=Halo%2C%20saya%20ingin%20bertanya%20tentang%20kuliah%20di%20UNSIA" target="_blank" style="display:inline-block;background:#25D366;color:#fff;padding:15px 35px;border-radius:30px;text-decoration:none;font-weight:700;font-size:16px;margin-left:10px;"><i class="fa-brands fa-whatsapp"></i> Chat WhatsApp</a>
        <a href="{{ route('faq') }}" style="display:inline-block;background:#0d1b2a;color:#fff;padding:15px 35px;border-radius:30px;text-decoration:none;font-weight:700;font-size:16px;margin-left:10px;"><i class="fa-solid fa-circle-question"></i> Lihat FAQ</a>
    </div>
</section>

<!-- SEO SECTION -->
<section style="padding:30px 0;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <h3 style="font-size:18px;font-weight:700;margin-bottom:10px;text-align:center;">Promo Kuliah UNSIA — Kode Referral unsia.my.id</h3>
                <p style="color:#666;font-size:12px;line-height:2;text-align:center;">
                    Cari <strong>kode referral UNSIA</strong>? Gunakan <strong>kode referal unsia.my.id</strong> untuk mendapatkan <strong>potongan biaya kuliah UNSIA</strong> di semester pertama. <strong>Promo UNSIA</strong> ini berlaku untuk semua program studi S1 PJJ. <strong>Potongan biaya UNSIA</strong> diberikan langsung saat pendaftaran di pmb.unsia.ac.id. Masukkan <strong>referral code unsia.my.id</strong> di formulir pendaftaran untuk aktivasi <strong>promo kuliah UNSIA</strong>. Kuliah online murah, terakreditasi, dan bisa sambil kerja — hanya di Universitas Siber Asia.
                </p>
            </div>
        </div>
    </div>
</section>

@endsection
