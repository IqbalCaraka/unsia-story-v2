@extends('layouts.app')

@section('title', 'FAQ - UNSIA Story | Pertanyaan Seputar Kuliah Online')
@section('description', 'FAQ UNSIA - Cara daftar kuliah online, biaya UKT, kode referral, potongan semester pertama, dan info pendaftaran mahasiswa baru Universitas Siber Asia.')
@section('keywords', 'faq unsia, cara daftar unsia, biaya kuliah unsia, ukt unsia, kode referral unsia, kuliah online murah, pendaftaran mahasiswa baru')
@section('og_image', asset('assets/images/logo-unsia-story.png'))

@section('meta')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "FAQPage",
  "mainEntity": [
    {"@@type": "Question", "name": "Bagaimana cara mendaftar di UNSIA?", "acceptedAnswer": {"@@type": "Answer", "text": "Pendaftaran dilakukan secara online melalui pmb.unsia.ac.id. Buka pmb.unsia.ac.id, isi data diri, bayar biaya pendaftaran Rp175.000, login ke akun PMB, masukkan kode referral unsia.my.id untuk potongan UKT Rp650.000, ikuti tes online, tunggu hasil seleksi 2-5 hari, lalu daftar ulang dan bayar UKT Rp3.000.000/semester (bisa cicil 3x)."}},
    {"@@type": "Question", "name": "Berapa biaya pendaftaran UNSIA?", "acceptedAnswer": {"@@type": "Answer", "text": "Biaya pendaftaran hanya Rp175.000 (sekali bayar). Pembayaran bisa melalui transfer bank atau virtual account yang tersedia di portal PMB."}},
    {"@@type": "Question", "name": "Berapa biaya UKT per semester di UNSIA?", "acceptedAnswer": {"@@type": "Answer", "text": "Biaya UKT adalah Rp3.000.000 per semester dan bisa dicicil 3 kali. Dengan kode referral unsia.my.id, semester pertama dapat potongan Rp500.000 (bayar Rp2.500.000) dan semester kedua cashback Rp150.000 (bayar Rp2.850.000)."}},
    {"@@type": "Question", "name": "Apa itu kode referral UNSIA dan bagaimana cara menggunakannya?", "acceptedAnswer": {"@@type": "Answer", "text": "Kode referral adalah kode khusus yang memberikan potongan UKT Rp500.000 di semester pertama dan cashback Rp150.000 di semester kedua. Gunakan kode: unsia.my.id. Masukkan di formulir pendaftaran PMB sebelum pembayaran UKT."}},
    {"@@type": "Question", "name": "Apakah UNSIA benar-benar 100% online?", "acceptedAnswer": {"@@type": "Answer", "text": "Ya! UNSIA adalah universitas siber pertama di Indonesia. Semua perkuliahan dilakukan secara online melalui platform LMS. Kamu bisa kuliah dari mana saja, kapan saja."}},
    {"@@type": "Question", "name": "Apakah ijazah UNSIA diakui negara?", "acceptedAnswer": {"@@type": "Answer", "text": "Ya, 100% diakui. UNSIA terdaftar resmi di Kemendikbud dan terakreditasi BAN-PT. Beberapa prodi juga terakreditasi internasional oleh EAHEA."}},
    {"@@type": "Question", "name": "Apakah bisa kuliah sambil kerja di UNSIA?", "acceptedAnswer": {"@@type": "Answer", "text": "Tentu! Jadwal fleksibel dan materi bisa diakses 24 jam. Banyak mahasiswa UNSIA yang bekerja full-time sambil kuliah."}},
    {"@@type": "Question", "name": "Program studi apa saja yang tersedia di UNSIA?", "acceptedAnswer": {"@@type": "Answer", "text": "UNSIA menyediakan 6 program studi S1 (PJJ): Sistem Informasi, Informatika, Manajemen, Akuntansi, Komunikasi, dan Teknologi Informasi."}}
  ]
}
</script>
@endsection

@section('styles')
<style>
.faq-item { background:#fff; border-radius:12px; padding:25px 30px; margin-bottom:15px; box-shadow:0 2px 15px rgba(0,0,0,0.06); cursor:pointer; transition:all 0.3s ease; }
.faq-item:hover { box-shadow:0 5px 25px rgba(0,0,0,0.1); }
.faq-item h4 { font-weight:600; font-size:17px; margin:0; display:flex; justify-content:space-between; align-items:center; }
.faq-item h4 i { color:#2c7aff; transition:transform 0.3s; }
.faq-item.active h4 i { transform:rotate(180deg); }
.faq-answer { max-height:0; overflow:hidden; transition:max-height 0.4s ease, padding 0.3s ease; padding-top:0; }
.faq-item.active .faq-answer { max-height:600px; padding-top:15px; }
.faq-answer p, .faq-answer ol, .faq-answer ul { color:#555; font-size:15px; line-height:1.8; }
.faq-answer ol li, .faq-answer ul li { margin-bottom:8px; }
.faq-answer strong { color:#0d1b2a; }
.faq-category { color:#2c7aff; font-weight:700; font-size:13px; letter-spacing:2px; text-transform:uppercase; margin-bottom:20px; margin-top:40px; }
.ref-code-box { background:linear-gradient(135deg,#f0c040,#e6a817); color:#0d1b2a; padding:20px 30px; border-radius:12px; text-align:center; font-size:24px; font-weight:800; letter-spacing:2px; margin:15px 0; }
.step-number { display:inline-flex; width:28px; height:28px; background:#2c7aff; color:#fff; border-radius:50%; align-items:center; justify-content:center; font-weight:700; font-size:13px; margin-right:8px; flex-shrink:0; }
</style>
@endsection

@section('hero')
    @include('partials.page-hero', ['title' => 'FAQ', 'crumbs' => ['FAQ' => null]])
@endsection

@section('content')

<!-- FAQ CONTENT -->
<section class="section-padding" style="background:#f8f9fa;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10 col-12">

                <div class="section-title text-center" style="margin-bottom:30px;">
                    <h4>Pertanyaan Umum</h4>
                    <h1>Yang Sering Ditanyakan</h1>
                </div>

                <p class="faq-category"><i class="fa-solid fa-clipboard-list" style="margin-right:8px;"></i> Pendaftaran</p>

                <div class="faq-item active">
                    <h4>Bagaimana cara mendaftar di UNSIA? <i class="fa-solid fa-chevron-down"></i></h4>
                    <div class="faq-answer">
                        <p>Pendaftaran dilakukan secara online melalui <strong><a href="https://pmb.unsia.ac.id" target="_blank" style="color:#2c7aff;">pmb.unsia.ac.id</a></strong>. Berikut langkah-langkahnya:</p>
                        <ol>
                            <li><span class="step-number">1</span> Buka <strong>pmb.unsia.ac.id</strong> dan klik "Daftar"</li>
                            <li><span class="step-number">2</span> Isi data diri lengkap (nama, email, no HP, dll)</li>
                            <li><span class="step-number">3</span> Bayar biaya pendaftaran <strong>Rp175.000</strong></li>
                            <li><span class="step-number">4</span> Login ke akun PMB — cek ID &amp; PIN dari email</li>
                            <li><span class="step-number">5</span> Masukkan kode referral <strong>unsia.my.id</strong> — total benefit <strong>Rp650.000</strong> (potongan + cashback)</li>
                            <li><span class="step-number">6</span> Ikuti tes online (CBT)</li>
                            <li><span class="step-number">7</span> Tunggu hasil seleksi (2-5 hari)</li>
                            <li><span class="step-number">8</span> Daftar ulang &amp; bayar UKT — <strong>Rp3.000.000/semester</strong> (cicil 3x). Semester pertama: potongan <strong>Rp500.000</strong> → bayar <strong>Rp2.500.000</strong>. Semester kedua: cashback <strong>Rp150.000</strong> → bayar <strong>Rp2.850.000</strong></li>
                        </ol>
                    </div>
                </div>

                <div class="faq-item">
                    <h4>Kapan jadwal pendaftaran terbaru? <i class="fa-solid fa-chevron-down"></i></h4>
                    <div class="faq-answer">
                        <p>Pendaftaran <strong>Gelombang 10 (Gelombang Terakhir) Jalur Reguler</strong> dibuka mulai <strong>4 - 17 September 2026</strong>. Segera daftar sebelum kuota penuh!</p>
                    </div>
                </div>

                <div class="faq-item">
                    <h4>Berapa biaya pendaftaran? <i class="fa-solid fa-chevron-down"></i></h4>
                    <div class="faq-answer">
                        <p>Biaya pendaftaran hanya <strong>Rp175.000</strong> (sekali bayar). Pembayaran bisa melalui transfer bank atau virtual account yang tersedia di portal PMB.</p>
                    </div>
                </div>

                <div class="faq-item">
                    <h4>Berapa biaya UKT per semester? <i class="fa-solid fa-chevron-down"></i></h4>
                    <div class="faq-answer">
                        <p>Biaya UKT adalah <strong>Rp3.000.000 per semester</strong> dan bisa <strong>dicicil 3 kali</strong>. Dengan kode referral <strong>unsia.my.id</strong>:<br>- Semester pertama: potongan <strong>Rp500.000</strong> → bayar <strong>Rp2.500.000</strong><br>- Semester kedua: cashback <strong>Rp150.000</strong> → bayar <strong>Rp2.850.000</strong><br>- Semester selanjutnya: <strong>Rp3.000.000</strong> (bisa cicil 3x)</p>
                    </div>
                </div>

                <p class="faq-category"><i class="fa-solid fa-gift" style="margin-right:8px;"></i> Kode Referral &amp; Potongan UKT</p>

                <div class="faq-item">
                    <h4>Apa itu kode referral dan bagaimana cara menggunakannya? <i class="fa-solid fa-chevron-down"></i></h4>
                    <div class="faq-answer">
                        <p>Kode referral adalah kode khusus yang memberikan <strong>potongan UKT Rp500.000 di semester pertama</strong> dan <strong>cashback Rp150.000 di semester kedua</strong>. Kode referral kami:</p>
                        <div class="ref-code-box">unsia.my.id</div>
                        <p><strong>Cara memasukkan kode referral:</strong></p>
                        <ol>
                            <li><span class="step-number">1</span> Login ke akun PMB kamu di <strong>pmb.unsia.ac.id</strong></li>
                            <li><span class="step-number">2</span> Masuk ke menu <strong>"Formulir Pendaftaran"</strong> atau <strong>"Data Pendaftaran"</strong></li>
                            <li><span class="step-number">3</span> Cari kolom bertuliskan <strong>"Kode Referral"</strong> atau <strong>"Referral Code"</strong></li>
                            <li><span class="step-number">4</span> Ketik: <strong>unsia.my.id</strong></li>
                            <li><span class="step-number">5</span> Klik <strong>Simpan</strong> — potongan otomatis berlaku saat bayar UKT</li>
                        </ol>
                        <p style="background:#e8f5e9;padding:12px 15px;border-radius:8px;margin-top:10px;"><i class="fa-solid fa-circle-check" style="color:#2e7d32;margin-right:5px;"></i> <strong>Penting:</strong> Masukkan kode referral <strong>sebelum</strong> melakukan pembayaran UKT.</p>
                    </div>
                </div>

                <div class="faq-item">
                    <h4>Apakah kode referral bisa digunakan setelah bayar UKT? <i class="fa-solid fa-chevron-down"></i></h4>
                    <div class="faq-answer">
                        <p><strong>Tidak bisa.</strong> Kode referral harus dimasukkan <strong>sebelum</strong> pembayaran UKT. Pastikan kamu memasukkan kode <strong>unsia.my.id</strong> di formulir pendaftaran terlebih dahulu.</p>
                    </div>
                </div>

                <p class="faq-category"><i class="fa-solid fa-laptop" style="margin-right:8px;"></i> Perkuliahan</p>

                <div class="faq-item">
                    <h4>Apakah UNSIA benar-benar 100% online? <i class="fa-solid fa-chevron-down"></i></h4>
                    <div class="faq-answer">
                        <p><strong>Ya!</strong> UNSIA adalah universitas siber pertama di Indonesia. Semua perkuliahan dilakukan secara online melalui platform LMS. Kamu bisa kuliah dari mana saja, kapan saja.</p>
                    </div>
                </div>

                <div class="faq-item">
                    <h4>Apakah ijazah UNSIA diakui negara? <i class="fa-solid fa-chevron-down"></i></h4>
                    <div class="faq-answer">
                        <p><strong>Ya, 100% diakui.</strong> UNSIA terdaftar resmi di Kemendikbud dan terakreditasi BAN-PT. Beberapa prodi juga terakreditasi internasional oleh EAHEA.</p>
                    </div>
                </div>

                <div class="faq-item">
                    <h4>Apakah bisa kuliah sambil kerja? <i class="fa-solid fa-chevron-down"></i></h4>
                    <div class="faq-answer">
                        <p><strong>Tentu!</strong> Justru ini keunggulan utama UNSIA. Jadwal fleksibel dan materi bisa diakses 24 jam. Banyak mahasiswa UNSIA yang bekerja full-time sambil kuliah.</p>
                    </div>
                </div>

                <div class="faq-item">
                    <h4>Program studi apa saja yang tersedia? <i class="fa-solid fa-chevron-down"></i></h4>
                    <div class="faq-answer">
                        <p>UNSIA menyediakan 6 program studi S1 (PJJ):</p>
                        <ul>
                            <li><a href="{{ route('prodi', 'sistem-informasi') }}" style="color:#2c7aff;">Sistem Informasi</a></li>
                            <li><a href="{{ route('prodi', 'informatika') }}" style="color:#2c7aff;">Informatika</a></li>
                            <li><a href="{{ route('prodi', 'manajemen') }}" style="color:#2c7aff;">Manajemen</a></li>
                            <li><a href="{{ route('prodi', 'akuntansi') }}" style="color:#2c7aff;">Akuntansi</a></li>
                            <li><a href="{{ route('prodi', 'komunikasi') }}" style="color:#2c7aff;">Komunikasi</a></li>
                            <li><a href="{{ route('prodi', 'teknologi-informasi') }}" style="color:#2c7aff;">Teknologi Informasi</a></li>
                        </ul>
                    </div>
                </div>

                <p class="faq-category"><i class="fa-solid fa-circle-question" style="margin-right:8px;"></i> Bantuan</p>

                <div class="faq-item">
                    <h4>Saya masih bingung, bisa tanya langsung? <i class="fa-solid fa-chevron-down"></i></h4>
                    <div class="faq-answer">
                        <p>Tentu! Hubungi kami via WhatsApp di <a href="https://wa.me/628133331686" target="_blank" style="color:#25D366;font-weight:600;">0813-3333-1686</a>. Tim kami siap bantu!</p>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="section-padding text-center" style="background:linear-gradient(135deg,#0d1b2a,#1a2d4a);">
    <div class="container">
        <h2 style="color:#fff;font-weight:700;margin-bottom:15px;">Siap Daftar?</h2>
        <p style="color:rgba(255,255,255,0.7);margin-bottom:25px;font-size:16px;">Jangan lupa pakai kode referral <strong style="color:#f0c040;">unsia.my.id</strong> untuk total keuntungan <strong style="color:#f0c040;">Rp650.000</strong></p>
        <a href="https://pmb.unsia.ac.id" target="_blank" style="display:inline-block;background:#f0c040;color:#0d1b2a;padding:15px 35px;border-radius:30px;text-decoration:none;font-weight:700;font-size:16px;"><i class="fa-solid fa-arrow-right"></i> Daftar di PMB UNSIA</a>
        <a href="https://wa.me/628133331686" target="_blank" style="display:inline-block;background:#25D366;color:#fff;padding:15px 35px;border-radius:30px;text-decoration:none;font-weight:700;font-size:16px;margin-left:10px;"><i class="fa-brands fa-whatsapp"></i> Tanya via WA</a>
    </div>
</section>

<!-- SEO SECTION -->
<section style="background:#f8f9fa;padding:30px 0;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <p style="color:#888;font-size:12px;line-height:2;text-align:center;">
                    Pertanyaan seputar <strong>kode referral UNSIA</strong>, <strong>kode referal unsia.my.id</strong>, <strong>potongan biaya kuliah UNSIA</strong>, <strong>promo kuliah UNSIA</strong>, <strong>promo UNSIA</strong>, cara daftar kuliah online, biaya UKT, <strong>referral code unsia.my.id</strong>, dan <strong>potongan biaya UNSIA</strong>? Semua jawabannya ada di halaman FAQ ini. Gunakan kode referral <strong>unsia.my.id</strong> saat mendaftar di pmb.unsia.ac.id untuk mendapatkan potongan biaya kuliah. UNSIA — Universitas Siber Asia, kampus online pertama di Indonesia.
                </p>
            </div>
        </div>
    </div>
</section>

@endsection

@section('scripts')
<script>
document.querySelectorAll('.faq-item').forEach(function(item) {
  item.addEventListener('click', function() { this.classList.toggle('active'); });
});
</script>
@endsection
