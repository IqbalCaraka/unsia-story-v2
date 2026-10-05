@extends('layouts.app')

@section('title', 'Ajukan Bantuan Pendanaan - UNSIA Story')
@section('description', 'Formulir pengajuan Bantuan Pendanaan UNSIA Story, khusus mahasiswa pengguna kode referral unsia.my.id. Daftarkan diri dan unggah syarat administrasi: transkrip nilai semester 1 dan lembar motivasi.')
@section('keywords', 'ajukan bantuan pendanaan, formulir bantuan dana kuliah, pengajuan beasiswa unsia, universitas siber asia')

@section('styles')
<style>
.form-box { background:#fff; border:2px solid #e0e0e0; border-radius:12px; padding:30px; margin-bottom:20px; }
.form-box h3 { font-size:18px; font-weight:700; color:#0d1b2a; margin-bottom:5px; }
.form-box p.sub { color:#888; font-size:13px; margin-bottom:22px; }
.form-group { margin-bottom:18px; }
.form-group label { display:block; font-weight:600; font-size:14px; color:#333; margin-bottom:6px; }
.form-group label .wajib { color:#e53935; }
.form-group input[type="text"], .form-group input[type="email"], .form-group input[type="tel"],
.form-group input[type="number"], .form-group select, .form-group textarea {
    width:100%; padding:12px 16px; border:2px solid #e0e0e0; border-radius:10px; font-size:14px;
    font-family:'Lexend',sans-serif; outline:none; transition:border-color 0.3s; background:#fff;
}
.form-group input:focus, .form-group select:focus, .form-group textarea:focus { border-color:#2c7aff; }
.form-group input[type="file"] { width:100%; padding:10px; border:2px dashed #cfd8e3; border-radius:10px; font-size:13px; font-family:'Lexend',sans-serif; background:#f8f9fa; cursor:pointer; }
.form-group .hint { font-size:12px; color:#888; margin-top:5px; }
.form-group .err { font-size:12px; color:#c62828; font-weight:600; margin-top:5px; }
.form-group input.is-invalid, .form-group select.is-invalid, .form-group textarea.is-invalid { border-color:#e57373; }
.persetujuan { display:flex; gap:10px; align-items:flex-start; background:#f8f9fa; padding:15px; border-radius:10px; font-size:13px; color:#555; line-height:1.7; }
.persetujuan input { margin-top:3px; width:18px; height:18px; flex-shrink:0; cursor:pointer; }
.btn-kirim { width:100%; padding:15px; background:#2c7aff; color:#fff; border:none; border-radius:30px; font-size:16px; font-weight:700; font-family:'Lexend',sans-serif; cursor:pointer; transition:opacity 0.3s; }
.btn-kirim:hover { opacity:0.9; }
.alert-sukses { background:#e8f5e9; border-left:4px solid #2e7d32; border-radius:12px; padding:25px 30px; margin-bottom:25px; }
.alert-sukses h3 { color:#2e7d32; font-weight:700; font-size:20px; margin-bottom:8px; }
.alert-gagal { background:#fce4ec; border-left:4px solid #c62828; border-radius:12px; padding:15px 20px; margin-bottom:20px; color:#c62828; font-size:14px; font-weight:600; }
.syarat-mini { background:#fff3e0; border-radius:10px; padding:15px 20px; font-size:13px; color:#6d4c00; line-height:1.9; margin-bottom:15px; }
.khusus-referral { background:#fff; border:2px solid #f0c040; border-radius:12px; padding:20px 25px; margin-bottom:25px; }
.khusus-referral h4 { font-size:16px; font-weight:700; color:#0d1b2a; margin-bottom:8px; }
.khusus-referral p { color:#555; font-size:14px; line-height:1.8; margin:0; }
.khusus-referral .kode { display:inline-block; background:linear-gradient(135deg,#f0c040,#e6a817); color:#0d1b2a; padding:4px 14px; border-radius:20px; font-weight:800; letter-spacing:1px; }
</style>
@endsection

@section('hero')
    @include('partials.page-hero', [
        'title' => 'Ajukan Bantuan Pendanaan',
        'crumbs' => ['Bantuan Pendanaan' => route('bantuan'), 'Ajukan' => null],
    ])
@endsection

@section('content')

<section class="section-padding" style="background:#f8f9fa;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10 col-12">

                @if ($sukses = session('pengajuan_sukses'))
                    <div class="alert-sukses">
                        <h3><i class="fa-solid fa-circle-check" style="margin-right:8px;"></i> Pengajuan Berhasil Dikirim</h3>
                        <p style="color:#555;margin-bottom:10px;">Terima kasih, <strong>{{ $sukses['nama'] }}</strong>. Pengajuan bantuan pendanaan kamu sudah kami terima dengan nomor pengajuan <strong>#{{ $sukses['nomor'] }}</strong>.</p>
                        <p style="color:#555;margin:0;">Berkas kamu akan diverifikasi kelengkapannya terlebih dahulu. Seleksi dilakukan berdasarkan peringkat IP semester 1. Info lanjutan dikirim ke <strong>{{ $sukses['email'] }}</strong> atau via WhatsApp.</p>
                    </div>
                @endif

                <div style="text-align:center;margin-bottom:25px;">
                    <h4 style="color:#2c7aff;font-size:14px;letter-spacing:2px;text-transform:uppercase;">Formulir Pengajuan</h4>
                    <h2 style="font-weight:700;font-size:26px;">Daftarkan Diri &amp; Laporkan Syarat Administrasi</h2>
                    <p style="color:#666;">Total bantuan <strong>Rp15.000.000</strong> — seleksi berdasarkan peringkat IP semester 1. <a href="{{ route('bantuan') }}" style="color:#2c7aff;font-weight:600;">Lihat info program</a></p>
                </div>

                <div class="khusus-referral">
                    <h4><i class="fa-solid fa-ticket" style="color:#e6a817;margin-right:8px;"></i> Khusus Pengguna Kode Referral</h4>
                    <p>Pengajuan hanya dapat diproses untuk mahasiswa yang mendaftar di UNSIA menggunakan kode referral <span class="kode">unsia.my.id</span>. Pastikan kode tersebut sudah kamu masukkan saat mengisi biodata di pmb.unsia.ac.id sebelum mengajukan.</p>
                </div>

                <div class="syarat-mini">
                    <strong><i class="fa-solid fa-clipboard-check" style="margin-right:6px;"></i> Siapkan dulu:</strong><br>
                    1. Transkrip nilai semester 1 — PDF/JPG/PNG, maksimal 5 MB<br>
                    2. Lembar motivasi — PDF/DOC/DOCX, maksimal 5 MB
                </div>

                @if ($errors->any())
                    <div class="alert-gagal">
                        <i class="fa-solid fa-exclamation-circle" style="margin-right:5px;"></i> Periksa kembali isian kamu:
                        <ul style="margin:8px 0 0 18px;font-weight:500;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('bantuan.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="form-box">
                        <h3>Data Diri</h3>
                        <p class="sub">Isi sesuai data yang terdaftar di kampus.</p>

                        <div class="form-group">
                            <label for="nama_lengkap">Nama Lengkap <span class="wajib">*</span></label>
                            <input type="text" id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap') }}"
                                   class="@error('nama_lengkap') is-invalid @enderror" placeholder="Nama sesuai data kampus" required>
                            @error('nama_lengkap')<div class="err">{{ $message }}</div>@enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nim">NIM <span class="wajib">*</span></label>
                                    <input type="text" id="nim" name="nim" value="{{ old('nim') }}"
                                           class="@error('nim') is-invalid @enderror" placeholder="Nomor Induk Mahasiswa" required>
                                    @error('nim')<div class="err">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="prodi">Program Studi <span class="wajib">*</span></label>
                                    <select id="prodi" name="prodi" class="@error('prodi') is-invalid @enderror" required>
                                        <option value="">-- Pilih Program Studi --</option>
                                        @foreach ($daftarProdi as $prodi)
                                            <option value="{{ $prodi }}" @selected(old('prodi') === $prodi)>{{ $prodi }}</option>
                                        @endforeach
                                    </select>
                                    @error('prodi')<div class="err">{{ $message }}</div>@enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">Email Aktif <span class="wajib">*</span></label>
                                    <input type="email" id="email" name="email" value="{{ old('email') }}"
                                           class="@error('email') is-invalid @enderror" placeholder="nama@email.com" required>
                                    @error('email')<div class="err">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="whatsapp">Nomor WhatsApp <span class="wajib">*</span></label>
                                    <input type="tel" id="whatsapp" name="whatsapp" value="{{ old('whatsapp') }}"
                                           class="@error('whatsapp') is-invalid @enderror" placeholder="08123456789"
                                           pattern="[0-9]{10,15}" title="Hanya angka, 10-15 digit"
                                           oninput="this.value=this.value.replace(/[^0-9]/g,'')" required>
                                    @error('whatsapp')<div class="err">{{ $message }}</div>@enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-box">
                        <h3>Data Akademik &amp; Berkas</h3>
                        <p class="sub">Seleksi dilakukan berdasarkan peringkat IP semester 1, jadi pastikan transkrip yang diunggah sesuai.</p>

                        <div class="form-group">
                            <label for="ip_semester_1">IP Semester 1 <span class="wajib">*</span></label>
                            <input type="number" id="ip_semester_1" name="ip_semester_1" value="{{ old('ip_semester_1') }}"
                                   class="@error('ip_semester_1') is-invalid @enderror"
                                   step="0.01" min="0" max="4" placeholder="Contoh: 3.75" required>
                            <div class="hint">Skala 0.00 - 4.00, sesuai transkrip nilai yang kamu unggah.</div>
                            @error('ip_semester_1')<div class="err">{{ $message }}</div>@enderror
                        </div>

                        <div class="form-group">
                            <label for="transkrip">Transkrip Nilai Semester 1 <span class="wajib">*</span></label>
                            <input type="file" id="transkrip" name="transkrip" accept=".pdf,.jpg,.jpeg,.png"
                                   class="@error('transkrip') is-invalid @enderror" required>
                            <div class="hint">Format PDF, JPG, atau PNG — maksimal 5 MB.</div>
                            @error('transkrip')<div class="err">{{ $message }}</div>@enderror
                        </div>

                        <div class="form-group">
                            <label for="motivasi">Lembar Motivasi <span class="wajib">*</span></label>
                            <input type="file" id="motivasi" name="motivasi" accept=".pdf,.doc,.docx"
                                   class="@error('motivasi') is-invalid @enderror" required>
                            <div class="hint">Berisi alasan dan motivasi kamu mengajukan bantuan. Format PDF, DOC, atau DOCX — maksimal 5 MB.</div>
                            @error('motivasi')<div class="err">{{ $message }}</div>@enderror
                        </div>

                        <div class="form-group">
                            <label for="catatan">Catatan Tambahan <span style="color:#999;font-weight:500;">(opsional)</span></label>
                            <textarea id="catatan" name="catatan" rows="4" placeholder="Hal lain yang ingin kamu sampaikan">{{ old('catatan') }}</textarea>
                            @error('catatan')<div class="err">{{ $message }}</div>@enderror
                        </div>

                        <div class="form-group" style="margin-bottom:0;">
                            <div class="persetujuan">
                                <input type="checkbox" id="persetujuan" name="persetujuan" value="1" @checked(old('persetujuan')) required>
                                <label for="persetujuan" style="font-weight:500;margin:0;">Saya menyatakan bahwa saya mendaftar di UNSIA menggunakan kode referral <strong>unsia.my.id</strong>, data dan berkas yang saya kirimkan adalah benar, dan saya bersedia mengikuti proses seleksi berdasarkan peringkat IP semester 1.</label>
                            </div>
                            @error('persetujuan')<div class="err">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <button type="submit" class="btn-kirim"><i class="fa-solid fa-paper-plane" style="margin-right:8px;"></i> Kirim Pengajuan</button>

                    <p style="text-align:center;color:#888;font-size:12px;margin-top:15px;"><i class="fa-solid fa-lock" style="margin-right:5px;"></i> Berkas kamu disimpan secara privat dan hanya diakses tim verifikasi.</p>
                </form>

            </div>
        </div>
    </div>
</section>

@endsection
