@extends('layouts.app')

@section('title', 'Konversi Mata Kuliah - UNSIA Story')
@section('description', 'Konversi Mata Kuliah UNSIA - Cek kecocokan mata kuliah kamu dengan program studi di UNSIA. Alih Jenjang Diploma / Transfer Kuliah Belum Selesai.')
@section('keywords', 'konversi mata kuliah, alih jenjang, transfer kredit, pindahan, kuliah online, universitas siber asia, konversi sks')

@section('styles')
<style>
.mk-input-area { background:#fff; border:2px solid #e0e0e0; border-radius:12px; padding:20px; margin-bottom:15px; transition:border-color 0.3s; }
.mk-input-area:focus-within { border-color:#2c7aff; }
.mk-input-area input[type="text"] { border:none; outline:none; width:100%; font-size:16px; font-family:'Lexend',sans-serif; }
.mk-tag { display:inline-flex; align-items:center; background:#e3f2fd; color:#0d1b2a; padding:6px 14px; border-radius:20px; margin:4px; font-size:13px; font-weight:500; }
.mk-tag .remove { margin-left:8px; cursor:pointer; color:#e53935; font-weight:700; font-size:16px; }
.mk-tag .remove:hover { color:#b71c1c; }
.result-card { background:#fff; border-radius:12px; padding:25px; margin-bottom:20px; box-shadow:0 3px 15px rgba(0,0,0,0.08); }
.result-card h3 { font-weight:700; margin-bottom:5px; }
.match-bar { height:20px; border-radius:10px; background:#f0f0f0; overflow:hidden; margin:10px 0; }
.match-fill { height:100%; border-radius:10px; transition:width 0.5s ease; }
.match-high { background:linear-gradient(90deg,#4caf50,#81c784); }
.match-medium { background:linear-gradient(90deg,#ff9800,#ffb74d); }
.match-low { background:linear-gradient(90deg,#f44336,#e57373); }
.suggestion-list { position:absolute; background:#fff; border:1px solid #e0e0e0; border-radius:8px; max-height:200px; overflow-y:auto; z-index:100; width:calc(100% - 44px); box-shadow:0 4px 15px rgba(0,0,0,0.1); display:none; }
.suggestion-item { padding:8px 15px; font-size:14px; border-bottom:1px solid #f5f5f5; }
.suggestion-item:hover { background:#e3f2fd; }
.suggestion-item label:hover { background:transparent; }
.suggestion-item small { color:#888; }
.input-wrapper { position:relative; }
.how-it-works { background:#f8f9fa; border-radius:12px; padding:25px; margin-bottom:30px; }
.how-it-works h4 { font-weight:700; margin-bottom:15px; }
.how-it-works ol li { margin-bottom:8px; color:#555; }
.info-form { background:#fff; border:2px solid #e0e0e0; border-radius:12px; padding:20px; margin-bottom:20px; }
.info-form label { font-weight:600; font-size:14px; color:#333; display:block; margin-bottom:5px; }
.info-form input, .info-form select { width:100%; padding:10px 15px; border:1px solid #ddd; border-radius:8px; font-size:15px; font-family:'Lexend',sans-serif; margin-bottom:15px; }
.info-form select { appearance:auto; }
.stat-box { display:inline-block; background:#f8f9fa; border-radius:8px; padding:10px 20px; margin:5px; text-align:center; }
.stat-box .num { font-size:24px; font-weight:800; }
.stat-box .label { font-size:12px; color:#666; }
.exact-badge { background:#4caf50; color:#fff; padding:2px 8px; border-radius:10px; font-size:11px; font-weight:600; }
.similar-badge { background:#ff9800; color:#fff; padding:2px 8px; border-radius:10px; font-size:11px; font-weight:600; }
</style>
@endsection

@section('hero')
    @include('partials.page-hero', ['title' => 'Konversi Mata Kuliah', 'crumbs' => ['Konversi Mata Kuliah' => null]])
@endsection

@section('content')

<section class="section-padding">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10 col-12">

                <div style="text-align:center;margin-bottom:20px;">
                    <h4 style="color:#2c7aff;font-size:14px;letter-spacing:2px;text-transform:uppercase;">Rekognisi Pembelajaran Lampau</h4>
                    <h2 style="font-weight:700;font-size:24px;">Cek Kecocokan Mata Kuliah Kamu</h2>
                </div>

                <div class="how-it-works">
                    <h4><i class="fa-solid fa-circle-info" style="color:#2c7aff;margin-right:8px;"></i> Cara Kerja</h4>
                    <ol>
                        <li>Isi <strong>nama lengkap</strong> dan pilih <strong>jenis konversi</strong> (Transfer Kuliah Belum Selesai atau Alih Jenjang Diploma)</li>
                        <li>Ketik nama mata kuliah yang pernah kamu ambil — pilih dari saran atau ketik manual</li>
                        <li>Sistem akan menghitung 2 jenis kecocokan: <strong>Exact Match</strong> (nama persis sama) dan <strong>Similar Match</strong> (nama mirip/relevan)</li>
                        <li>Lihat ranking prodi berdasarkan % kecocokan, SKS terkonversi, dan sisa SKS yang harus diambil</li>
                        <li><strong>Cetak laporan</strong> untuk konsultasi lebih lanjut</li>
                    </ol>
                </div>

                @if (session('konversi_error'))
                    <div style="margin:20px 0;padding:15px;background:#fff3e0;border-radius:12px;text-align:center;border-left:4px solid #e65100;">
                        <p style="margin:0;color:#e65100;font-weight:600;"><i class="fa-solid fa-exclamation-circle" style="margin-right:5px;"></i> {{ session('konversi_error') }}</p>
                    </div>
                @endif

                @if ($step === 'lead')
                    {{-- STEP 2: FORM DATA DIRI --}}
                    <div style="text-align:center;margin-bottom:20px;">
                        <span style="display:inline-block;background:#f0c040;color:#0d1b2a;font-weight:700;font-size:12px;letter-spacing:2px;padding:5px 15px;border-radius:20px;text-transform:uppercase;">Satu Langkah Lagi</span>
                        <h2 style="font-weight:700;font-size:24px;margin-top:10px;">Isi Data Diri untuk Lihat Hasil</h2>
                        <p style="color:#666;">Masukkan data kamu untuk melihat hasil analisis konversi dan rekomendasi prodi.</p>
                    </div>

                    @isset($errorMessage)
                        <div style="margin:20px 0;padding:15px;background:#fff3e0;border-radius:12px;text-align:center;border-left:4px solid #e65100;">
                            <p style="margin:0;color:#e65100;font-weight:600;"><i class="fa-solid fa-exclamation-circle" style="margin-right:5px;"></i> {{ $errorMessage }}</p>
                        </div>
                    @endisset

                    <div class="info-form">
                        <form method="POST" action="{{ route('konversi.process') }}">
                            @csrf
                            <input type="hidden" name="step" value="lead_submitted">
                            <input type="hidden" name="jenis_rpl" value="{{ $jenis_rpl }}">
                            <input type="hidden" name="mata_kuliah" value="{{ $mata_kuliah }}">

                            <div class="row">
                                <div class="col-md-12" style="margin-bottom:15px;">
                                    <label><i class="fa-solid fa-user" style="margin-right:5px;color:#2c7aff;"></i> Nama atau Inisial</label>
                                    <input type="text" name="nama" value="{{ old('nama') }}" placeholder="Masukkan nama atau inisial" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label><i class="fa-solid fa-envelope" style="margin-right:5px;color:#2c7aff;"></i> Email</label>
                                    <input type="email" name="email" value="{{ old('email') }}" placeholder="Masukkan email aktif" required>
                                </div>
                                <div class="col-md-6">
                                    <label><i class="fa-brands fa-whatsapp" style="margin-right:5px;color:#25D366;"></i> Nomor WhatsApp</label>
                                    <input type="tel" name="whatsapp" value="{{ old('whatsapp') }}" placeholder="Contoh: 08123456789" required pattern="[0-9]{10,15}" title="Hanya angka, minimal 10 digit" oninput="this.value=this.value.replace(/[^0-9]/g,'')">
                                </div>
                            </div>
                            <p style="color:#888;font-size:12px;margin-top:10px;"><i class="fa-solid fa-lock" style="margin-right:5px;"></i> Data kamu aman dan hanya digunakan untuk keperluan konsultasi konversi mata kuliah.</p>
                            <div style="text-align:center;margin-top:20px;">
                                <button type="submit" style="display:inline-block;background:#2e7d32;color:#fff;padding:15px 40px;border-radius:30px;border:none;font-weight:700;font-size:16px;cursor:pointer;font-family:'Lexend',sans-serif;">
                                    <i class="fa-solid fa-check-circle"></i> Lihat Hasil Analisis
                                </button>
                            </div>
                        </form>
                    </div>

                @elseif ($step === 'input')
                    {{-- STEP 1: PILIH JENIS RPL + MATA KULIAH --}}
                    <form id="rplForm" method="POST" action="{{ route('konversi.process') }}">
                        @csrf
                        <input type="hidden" name="step" value="mk_selected">

                        <div class="info-form">
                            <label><i class="fa-solid fa-graduation-cap" style="margin-right:5px;"></i> Jenis Konversi</label>
                            <select name="jenis_rpl" required style="width:100%;padding:10px 15px;border:1px solid #ddd;border-radius:8px;font-size:15px;font-family:'Lexend',sans-serif;">
                                <option value="">-- Pilih Jenis Konversi --</option>
                                <option value="pindahan">Transfer Kuliah Belum Selesai (Pindahan S1)</option>
                                <option value="alih_jenjang">Alih Jenjang Diploma (dari D3)</option>
                            </select>
                        </div>

                        <div class="mk-input-area">
                            <div id="mkTags"></div>
                            <div class="input-wrapper">
                                <input type="text" id="mkInput" placeholder="Ketik nama mata kuliah, misal: Pemrograman Web..." autocomplete="off">
                                <div id="suggestions" class="suggestion-list"></div>
                            </div>
                        </div>
                        <input type="hidden" id="mkHidden" name="mata_kuliah" value="">
                        <p style="color:#888;font-size:13px;margin-bottom:5px;"><i class="fa-solid fa-lightbulb" style="color:#f0c040;margin-right:5px;"></i> Ketik minimal 3 huruf → centang mata kuliah dari daftar yang muncul.</p>
                        <p style="color:#888;font-size:13px;margin-bottom:5px;"><i class="fa-solid fa-keyboard" style="color:#2c7aff;margin-right:5px;"></i> Tidak ditemukan? Tekan <strong>Enter</strong> untuk menambahkan manual — sistem akan mencocokannya otomatis.</p>
                        <p style="color:#888;font-size:13px;margin-bottom:20px;"><i class="fa-solid fa-list" style="color:#2e7d32;margin-right:5px;"></i> Mau input banyak sekaligus? Pisahkan dengan titik koma <strong>(;)</strong> lalu tekan Enter. Contoh: <em>Bahasa Indonesia; Matematika; Pemrograman Web</em></p>

                        <div class="text-center">
                            <button type="submit" style="display:inline-block;background:#2c7aff;color:#fff;padding:15px 40px;border-radius:30px;border:none;font-weight:700;font-size:16px;cursor:pointer;font-family:'Lexend',sans-serif;">
                                <i class="fa-solid fa-arrow-right"></i> Lanjutkan
                            </button>
                            <button type="button" onclick="clearAll()" style="display:inline-block;background:#e0e0e0;color:#333;padding:15px 30px;border-radius:30px;border:none;font-weight:600;font-size:14px;cursor:pointer;margin-left:10px;font-family:'Lexend',sans-serif;">
                                <i class="fa-solid fa-trash"></i> Reset
                            </button>
                        </div>
                    </form>
                @endif

                @if ($step === 'result')
                    <div style="margin-top:40px;">
                        <div class="section-title text-center" style="margin-bottom:10px;">
                            <h4>Hasil Analisis Konversi</h4>
                            <h1>Kecocokan Mata Kuliah</h1>
                        </div>
                        <div style="text-align:center;margin-bottom:30px;">
                            <p style="color:#666;"><strong>Nama:</strong> {{ $nama }} | <strong>Jenis:</strong> {{ $jenisLabel }} | <strong>Input:</strong> {{ count($inputMk) }} mata kuliah ({{ count($selectedMk) }} dari daftar, {{ count($freetextMk) }} manual)</p>
                        </div>

                        @if (! empty($freetextAnalysis))
                            <div class="result-card" style="border-left:4px solid #ff9800;">
                                <h3 style="margin-bottom:15px;"><i class="fa-solid fa-wand-magic-sparkles" style="color:#e65100;margin-right:8px;"></i>Analisis Mata Kuliah Manual (Free Text)</h3>
                                <div style="overflow-x:auto;">
                                    <table style="width:100%;font-size:13px;border-collapse:collapse;">
                                        <tr style="background:#fff3e0;">
                                            <th style="padding:8px;text-align:left;">Input Kamu</th>
                                            <th style="padding:8px;text-align:left;">Rekomendasi MK Terdekat</th>
                                            <th style="padding:8px;text-align:center;">Score</th>
                                            <th style="padding:8px;text-align:center;">Status</th>
                                        </tr>
                                        @foreach ($freetextAnalysis as $ft)
                                            @php
                                                $badge = match ($ft['status']) {
                                                    'cocok' => ['#4caf50', 'Cocok'],
                                                    'mungkin_cocok' => ['#ff9800', 'Mungkin Cocok'],
                                                    default => ['#f44336', 'Tidak Cocok'],
                                                };
                                            @endphp
                                            <tr style="border-bottom:1px solid #eee;">
                                                <td style="padding:8px;">{{ $ft['input'] }}</td>
                                                <td style="padding:8px;">
                                                    @if ($ft['match'])
                                                        {{ $ft['match'] }}
                                                    @else
                                                        <em style="color:#999;">Tidak ditemukan MK yang mirip</em>
                                                    @endif
                                                </td>
                                                <td style="padding:8px;text-align:center;">{{ $ft['score'] }}%</td>
                                                <td style="padding:8px;text-align:center;"><span style="background:{{ $badge[0] }};color:#fff;padding:2px 8px;border-radius:10px;font-size:11px;">{{ $badge[1] }}</span></td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>
                                <p style="margin-top:10px;font-size:12px;color:#888;"><i class="fa-solid fa-info-circle" style="margin-right:5px;"></i>MK manual yang "Cocok" sudah diperhitungkan dalam analisis. MK "Tidak Cocok" berarti tidak ada padanan di kurikulum UNSIA.</p>
                            </div>
                        @endif

                        @foreach ($results as $i => $r)
                            @php
                                $barClass = $r['percentage'] >= 40 ? 'match-high' : ($r['percentage'] >= 20 ? 'match-medium' : 'match-low');
                                $warna = $r['percentage'] >= 40 ? '#2e7d32' : ($r['percentage'] >= 20 ? '#e65100' : '#c62828');
                                $medal = [0 => '🥇 ', 1 => '🥈 ', 2 => '🥉 '][$i] ?? '';
                            @endphp
                            <div class="result-card">
                                <div style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;">
                                    <h3>{{ $medal }}{{ $r['prodi'] }}</h3>
                                    <span style="font-size:28px;font-weight:800;color:{{ $warna }};">{{ $r['percentage'] }}%</span>
                                </div>
                                <div class="match-bar"><div class="match-fill {{ $barClass }}" style="width:{{ min($r['percentage'], 100) }}%;"></div></div>

                                <div style="margin:15px 0;">
                                    <div class="stat-box"><div class="num" style="color:#2e7d32;">{{ $r['sks_exact'] }}</div><div class="label">SKS Exact Match</div></div>
                                    <div class="stat-box"><div class="num" style="color:#ff9800;">{{ $r['sks_similar'] }}</div><div class="label">SKS Similar Match</div></div>
                                    <div class="stat-box"><div class="num" style="color:#2c7aff;">{{ $r['sks_total_matched'] }}</div><div class="label">Total SKS Konversi</div></div>
                                    <div class="stat-box"><div class="num" style="color:#c62828;">{{ $r['sks_remaining'] }}</div><div class="label">Sisa SKS (dari 144)</div></div>
                                </div>

                                @if (count($r['exact_matched']) > 0)
                                    <details style="margin-top:10px;">
                                        <summary style="cursor:pointer;font-weight:600;color:#2e7d32;"><i class="fa-solid fa-check-double" style="margin-right:5px;"></i> Exact Match - Nama Persis Sama ({{ count($r['exact_matched']) }} MK, {{ $r['sks_exact'] }} SKS)</summary>
                                        <div style="margin-top:10px;overflow-x:auto;">
                                            <table style="width:100%;font-size:13px;border-collapse:collapse;">
                                                <tr style="background:#e8f5e9;"><th style="padding:8px;text-align:left;">Mata Kuliah UNSIA</th><th style="padding:8px;">SKS</th><th style="padding:8px;">Sem</th><th style="padding:8px;text-align:left;">Input Kamu</th><th style="padding:8px;">Status</th></tr>
                                                @foreach ($r['exact_matched'] as $m)
                                                    <tr style="border-bottom:1px solid #eee;">
                                                        <td style="padding:8px;">{{ $m['mk'] }}</td>
                                                        <td style="padding:8px;text-align:center;">{{ $m['sks'] }}</td>
                                                        <td style="padding:8px;text-align:center;">{{ $m['semester'] }}</td>
                                                        <td style="padding:8px;">{{ $m['matched_with'] }}</td>
                                                        <td style="padding:8px;text-align:center;"><span class="exact-badge">EXACT</span></td>
                                                    </tr>
                                                @endforeach
                                            </table>
                                        </div>
                                    </details>
                                @endif

                                @if (count($r['similar_matched']) > 0)
                                    <details style="margin-top:10px;">
                                        <summary style="cursor:pointer;font-weight:600;color:#e65100;"><i class="fa-solid fa-check-circle" style="margin-right:5px;"></i> Similar Match - Nama Mirip ({{ count($r['similar_matched']) }} MK, {{ $r['sks_similar'] }} SKS)</summary>
                                        <div style="margin-top:10px;overflow-x:auto;">
                                            <table style="width:100%;font-size:13px;border-collapse:collapse;">
                                                <tr style="background:#fff3e0;"><th style="padding:8px;text-align:left;">Mata Kuliah UNSIA</th><th style="padding:8px;">SKS</th><th style="padding:8px;">Sem</th><th style="padding:8px;text-align:left;">Input Kamu</th><th style="padding:8px;">Score</th></tr>
                                                @foreach ($r['similar_matched'] as $m)
                                                    <tr style="border-bottom:1px solid #eee;">
                                                        <td style="padding:8px;">{{ $m['mk'] }}</td>
                                                        <td style="padding:8px;text-align:center;">{{ $m['sks'] }}</td>
                                                        <td style="padding:8px;text-align:center;">{{ $m['semester'] }}</td>
                                                        <td style="padding:8px;">{{ $m['matched_with'] }}</td>
                                                        <td style="padding:8px;text-align:center;"><span class="similar-badge">{{ $m['score'] }}%</span></td>
                                                    </tr>
                                                @endforeach
                                            </table>
                                        </div>
                                    </details>
                                @endif

                                @if (count($r['unmatched']) > 0)
                                    <details style="margin-top:10px;">
                                        <summary style="cursor:pointer;font-weight:600;color:#c62828;"><i class="fa-solid fa-times-circle" style="margin-right:5px;"></i> MK yang Harus Diambil ({{ count($r['unmatched']) }})</summary>
                                        <div style="margin-top:10px;overflow-x:auto;">
                                            <table style="width:100%;font-size:13px;border-collapse:collapse;">
                                                <tr style="background:#fce4ec;"><th style="padding:8px;text-align:left;">Mata Kuliah</th><th style="padding:8px;">SKS</th><th style="padding:8px;">Semester</th></tr>
                                                @foreach ($r['unmatched'] as $u)
                                                    <tr style="border-bottom:1px solid #eee;">
                                                        <td style="padding:8px;">{{ $u['mk'] }}</td>
                                                        <td style="padding:8px;text-align:center;">{{ $u['sks'] }}</td>
                                                        <td style="padding:8px;text-align:center;">{{ $u['semester'] }}</td>
                                                    </tr>
                                                @endforeach
                                            </table>
                                        </div>
                                    </details>
                                @endif
                            </div>
                        @endforeach

                        <div style="text-align:center;margin-top:30px;">
                            <a href="{{ route('konversi.laporan') }}" target="_blank" style="display:inline-block;background:#e53935;color:#fff;padding:15px 35px;border-radius:30px;text-decoration:none;font-weight:700;font-size:16px;"><i class="fa-solid fa-file-pdf"></i> Cetak Laporan</a>
                            <a href="{{ route('konversi') }}" style="display:inline-block;background:#e0e0e0;color:#333;padding:15px 30px;border-radius:30px;text-decoration:none;font-weight:600;font-size:14px;margin-left:10px;"><i class="fa-solid fa-rotate-left"></i> Cek Ulang</a>
                        </div>

                        <div style="text-align:center;margin-top:20px;padding:30px;background:linear-gradient(135deg,#0d1b2a,#1a2d4a);border-radius:12px;">
                            <h3 style="color:#fff;margin-bottom:10px;">Tertarik Melanjutkan Kuliah di UNSIA?</h3>
                            <p style="color:rgba(255,255,255,0.7);margin-bottom:20px;">Konsultasikan hasil konversi kamu dengan tim kami</p>
                            <a href="https://wa.me/628133331686?text={{ urlencode('Halo, saya ' . $nama . ' ingin konsultasi konversi mata kuliah ' . $jenisLabel . ' di UNSIA') }}" target="_blank" style="display:inline-block;background:#25D366;color:#fff;padding:14px 30px;border-radius:30px;text-decoration:none;font-weight:700;"><i class="fa-brands fa-whatsapp"></i> Konsultasi via WA</a>
                            <a href="https://pmb.unsia.ac.id" target="_blank" style="display:inline-block;background:#f0c040;color:#0d1b2a;padding:14px 30px;border-radius:30px;text-decoration:none;font-weight:700;margin-left:10px;"><i class="fa-solid fa-arrow-right"></i> Daftar PMB</a>
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </div>
</section>

@endsection

@section('scripts')
@if ($step === 'input')
<script>
var mkList = [];
// Track: {name: string, type: 'selected'|'freetext'}
var mkData = [];
var allMataKuliah = [];

var mkInput = document.getElementById('mkInput');
var suggestions = document.getElementById('suggestions');
var mkTags = document.getElementById('mkTags');
var mkHidden = document.getElementById('mkHidden');
var searchUrl = '{{ route('api.mata-kuliah') }}';

fetch(searchUrl + '?all=1')
    .then(function(r) { return r.json(); })
    .then(function(data) { allMataKuliah = data; });

renderTags();

var fuzzyTimer = null;

mkInput.addEventListener('input', function() {
    var val = this.value.trim().toLowerCase();
    if (val.length < 3) { suggestions.style.display = 'none'; return; }

    // Step 1: pencarian lokal — kelompokkan per nama, kumpulkan prodi
    var raw = allMataKuliah.filter(function(mk) {
        return (mk.nama.toLowerCase().indexOf(val) !== -1 || (mk.keywords || '').toLowerCase().indexOf(val) !== -1) && mkList.indexOf(mk.nama) === -1;
    });
    var grouped = {};
    raw.forEach(function(mk) {
        if (!grouped[mk.nama]) grouped[mk.nama] = {nama: mk.nama, sks: mk.sks, keywords: mk.keywords, prodis: []};
        if (grouped[mk.nama].prodis.indexOf(mk.prodi) === -1) grouped[mk.nama].prodis.push(mk.prodi);
    });
    var filtered = Object.values(grouped).map(function(g) {
        return {nama: g.nama, prodi: g.prodis.length > 1 ? g.prodis.length + ' prodi' : g.prodis[0], sks: g.sks, keywords: g.keywords};
    });

    if (filtered.length > 0) {
        renderSuggestions(filtered.slice(0, 15), false);
    } else {
        // Step 2: tidak ketemu lokal → smart match via API
        if (fuzzyTimer) clearTimeout(fuzzyTimer);
        fuzzyTimer = setTimeout(function() {
            fetch(searchUrl + '?fuzzy=' + encodeURIComponent(val))
            .then(function(r) { return r.json(); })
            .then(function(data) {
                var fuzzyFiltered = data.filter(function(mk) { return mkList.indexOf(mk.nama) === -1; });
                if (fuzzyFiltered.length > 0) {
                    renderSuggestions(fuzzyFiltered, true);
                } else {
                    suggestions.innerHTML = '<div class="suggestion-item" style="color:#888;text-align:center;"><i class="fa-solid fa-plus-circle" style="margin-right:5px;color:#2c7aff;"></i> Tekan <strong>Enter</strong> untuk menambahkan "<strong>' + val + '</strong>" secara manual</div>';
                    suggestions.style.display = 'block';
                }
            });
        }, 300);
    }
});

function renderSuggestions(list, isFuzzy) {
    suggestions.innerHTML = '';
    if (isFuzzy) {
        var header = document.createElement('div');
        header.style.cssText = 'padding:8px 15px;background:#fff3e0;font-size:12px;color:#e65100;font-weight:600;';
        header.innerHTML = '<i class="fa-solid fa-wand-magic-sparkles" style="margin-right:5px;"></i> Smart Match — mata kuliah terdekat yang ditemukan:';
        suggestions.appendChild(header);
    }
    list.forEach(function(mk) {
        var div = document.createElement('div');
        div.className = 'suggestion-item';
        var isChecked = mkList.indexOf(mk.nama) !== -1;
        var scoreHtml = (isFuzzy && mk.score) ? ' <small style="color:#e65100;font-weight:600;">' + mk.score + '% cocok</small>' : '';
        div.innerHTML = '<label style="display:flex;align-items:center;gap:10px;cursor:pointer;margin:0;">'
            + '<input type="checkbox" class="mk-checkbox" data-nama="' + mk.nama.replace(/"/g, '&quot;') + '" ' + (isChecked ? 'checked disabled' : '') + ' style="width:18px;height:18px;cursor:pointer;flex-shrink:0;">'
            + '<span>' + mk.nama + ' <small style="color:#888;">(' + mk.prodi + ' - ' + mk.sks + ' SKS)</small>' + scoreHtml + '</span>'
            + '</label>';
        div.querySelector('.mk-checkbox').addEventListener('change', function() {
            if (this.checked) {
                addMK(this.dataset.nama, 'selected');
                this.disabled = true;
                mkInput.value = '';
                mkInput.dispatchEvent(new Event('input'));
            }
        });
        suggestions.appendChild(div);
    });
    suggestions.style.display = 'block';
}

mkInput.addEventListener('keydown', function(e) {
    if (e.key === 'Enter') {
        e.preventDefault();
        var val = this.value.trim();
        if (val.length > 0) {
            // Multi MK dipisah titik koma (;)
            if (val.indexOf(';') !== -1) {
                var added = 0;
                val.split(';').forEach(function(item) {
                    var mk = item.trim();
                    if (mk.length >= 3) { addMK(mk, 'freetext'); added++; }
                });
                if (added > 0) showBulkNotif(added);
            } else {
                addMK(val, 'freetext');
            }
            this.value = '';
            suggestions.style.display = 'none';
        }
    }
});

function showBulkNotif(count) {
    var notif = document.createElement('div');
    notif.style.cssText = 'position:fixed;top:20px;right:20px;background:#2e7d32;color:#fff;padding:12px 20px;border-radius:10px;font-size:14px;font-weight:600;z-index:99999;box-shadow:0 5px 20px rgba(0,0,0,0.2);font-family:Lexend,sans-serif;';
    notif.innerHTML = '<i class="fa-solid fa-check-circle" style="margin-right:8px;"></i>' + count + ' mata kuliah berhasil ditambahkan';
    document.body.appendChild(notif);
    setTimeout(function() { notif.style.opacity = '0'; notif.style.transition = 'opacity 0.3s'; setTimeout(function() { notif.remove(); }, 300); }, 2500);
}

document.addEventListener('click', function(e) {
    if (!e.target.closest('.input-wrapper') && !e.target.closest('.suggestion-list')) suggestions.style.display = 'none';
});

function addMK(name, type) {
    type = type || 'selected';
    if (mkList.indexOf(name) !== -1) return;
    mkList.push(name);
    mkData.push({name: name, type: type});
    renderTags();
    updateHidden();
}

function removeMK(index) {
    mkList.splice(index, 1);
    mkData.splice(index, 1);
    renderTags();
    updateHidden();
}

function renderTags() {
    mkTags.innerHTML = '';
    mkData.forEach(function(item, i) {
        var span = document.createElement('span');
        span.className = 'mk-tag';
        if (item.type === 'freetext') {
            span.style.cssText = 'background:#fff3e0;border:1px solid #ff9800;';
            span.innerHTML = '<i class="fa-solid fa-pen" style="font-size:10px;color:#e65100;margin-right:5px;"></i>' + item.name + ' <small style="color:#e65100;">(manual)</small> <span class="remove" onclick="removeMK(' + i + ')">&times;</span>';
        } else {
            span.innerHTML = item.name + ' <span class="remove" onclick="removeMK(' + i + ')">&times;</span>';
        }
        mkTags.appendChild(span);
    });
}

function updateHidden() {
    mkHidden.value = JSON.stringify(mkData.map(function(item) { return {name: item.name, type: item.type}; }));
}

function clearAll() { mkList = []; mkData = []; renderTags(); updateHidden(); mkInput.value = ''; }
</script>
@endif
@endsection
