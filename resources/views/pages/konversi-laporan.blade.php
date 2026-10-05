<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="robots" content="noindex">
<title>Laporan RPL - {{ $nama }}</title>
<link rel="stylesheet" href="{{ asset('assets/css/all.min.css') }}">
<style>
@media print {
    body { margin: 0; }
    .no-print { display: none !important; }
    .page-break { page-break-before: always; }
}
* { margin: 0; padding: 0; box-sizing: border-box; }
body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-size: 12px; color: #333; padding: 20px; }
.header { text-align: center; border-bottom: 3px solid #0d1b2a; padding-bottom: 15px; margin-bottom: 20px; }
.header h1 { font-size: 20px; color: #0d1b2a; margin-bottom: 5px; }
.header h2 { font-size: 14px; color: #2c7aff; font-weight: 400; }
.header p { font-size: 11px; color: #888; }
.info-table { width: 100%; margin-bottom: 20px; }
.info-table td { padding: 5px 10px; }
.info-table td:first-child { font-weight: 700; width: 200px; background: #f5f5f5; }
.prodi-section { margin-bottom: 25px; border: 1px solid #ddd; border-radius: 8px; overflow: hidden; }
.prodi-header { background: #0d1b2a; color: #fff; padding: 12px 15px; }
.prodi-header h3 { font-size: 16px; display: inline; }
.prodi-header .pct { float: right; font-size: 20px; font-weight: 800; }
.stats { display: flex; gap: 10px; padding: 10px 15px; background: #f8f9fa; flex-wrap: wrap; }
.stat { flex: 1; text-align: center; min-width: 100px; }
.stat .num { font-size: 18px; font-weight: 800; }
.stat .lbl { font-size: 10px; color: #666; }
table { width: 100%; border-collapse: collapse; font-size: 11px; }
th { background: #e8e8e8; padding: 6px 8px; text-align: left; font-weight: 600; }
td { padding: 6px 8px; border-bottom: 1px solid #eee; }
.exact-row { background: #f1f8e9; }
.similar-row { background: #fff8e1; }
.section-label { background: #2c7aff; color: #fff; padding: 6px 10px; font-weight: 700; font-size: 11px; }
.section-label-red { background: #e53935; color: #fff; padding: 6px 10px; font-weight: 700; font-size: 11px; }
.footer-note { margin-top: 30px; padding: 15px; background: #f8f9fa; border-radius: 8px; font-size: 11px; color: #666; }
.footer-note strong { color: #333; }
.btn-print { display: inline-block; background: #2c7aff; color: #fff; padding: 12px 30px; border-radius: 30px; text-decoration: none; font-weight: 700; font-size: 14px; cursor: pointer; border: none; margin: 5px; }
.btn-back { display: inline-block; background: #666; color: #fff; padding: 12px 30px; border-radius: 30px; text-decoration: none; font-weight: 700; font-size: 14px; margin: 5px; }
</style>
</head>
<body>

@php $tanggal = now()->format('d/m/Y H:i'); @endphp

<div class="no-print" style="text-align:center;margin-bottom:20px;">
    <button onclick="window.print()" class="btn-print"><i class="fa-solid fa-print"></i> Cetak / Save as PDF</button>
    <a href="{{ route('konversi') }}" class="btn-back">Kembali</a>
    <p style="color:#888;font-size:12px;margin-top:10px;">Gunakan Ctrl+P atau tombol di atas. Pilih "Save as PDF" untuk menyimpan sebagai file PDF.</p>
</div>

<div class="header">
    <h1>LAPORAN ANALISIS RPL KONVERSI MATA KULIAH</h1>
    <h2>UNSIA Story - Mitra Pemasaran Resmi Universitas Siber Asia</h2>
    <p>Dokumen ini dibuat secara otomatis oleh sistem | {{ $tanggal }}</p>
</div>

<table class="info-table">
    <tr><td>Nama / Inisial</td><td>: {{ $nama }}</td></tr>
    <tr><td>Jenis RPL</td><td>: {{ $jenis }}</td></tr>
    <tr><td>Jumlah MK yang Diinput</td><td>: {{ count($input_mk) }} mata kuliah</td></tr>
    <tr><td>Target SKS Kelulusan</td><td>: 144 SKS</td></tr>
    <tr><td>Tanggal Analisis</td><td>: {{ $tanggal }}</td></tr>
</table>

<h3 style="margin-bottom:5px;">Daftar Mata Kuliah yang Diinput ({{ count($input_mk) }} MK):</h3>
<table style="width:100%;border-collapse:collapse;margin-bottom:15px;font-size:11px;">
    <tr style="background:#e8e8e8;"><th style="padding:5px 8px;text-align:center;width:30px;">No</th><th style="padding:5px 8px;text-align:left;">Nama Mata Kuliah</th></tr>
    @foreach ($input_mk as $i => $mk)
        <tr style="border-bottom:1px solid #eee;"><td style="padding:4px 8px;text-align:center;">{{ $i + 1 }}</td><td style="padding:4px 8px;">{{ $mk }}</td></tr>
    @endforeach
</table>

@if (! empty($freetext))
    <h3 style="margin-bottom:5px;margin-top:15px;">Analisis Mata Kuliah Manual (Free Text):</h3>
    <table style="width:100%;border-collapse:collapse;margin-bottom:15px;font-size:11px;">
        <tr style="background:#fff3e0;"><th style="padding:5px 8px;text-align:left;">Input</th><th style="padding:5px 8px;text-align:left;">MK Terdekat</th><th style="padding:5px 8px;text-align:center;">Score</th><th style="padding:5px 8px;text-align:center;">Status</th></tr>
        @foreach ($freetext as $ft)
            <tr style="border-bottom:1px solid #eee;">
                <td style="padding:4px 8px;">{{ $ft['input'] }}</td>
                <td style="padding:4px 8px;">{{ $ft['match'] ?: 'Tidak ditemukan' }}</td>
                <td style="padding:4px 8px;text-align:center;">{{ $ft['score'] }}%</td>
                <td style="padding:4px 8px;text-align:center;">{{ $ft['status'] === 'cocok' ? 'COCOK' : ($ft['status'] === 'mungkin_cocok' ? 'MUNGKIN' : 'TIDAK COCOK') }}</td>
            </tr>
        @endforeach
    </table>
@endif

@foreach ($results as $i => $r)
    @php
        $rank = $i + 1;
        $pctColor = $r['percentage'] >= 40 ? '#81c784' : ($r['percentage'] >= 20 ? '#ffb74d' : '#ef9a9a');
    @endphp

    @if ($rank > 1 && $rank % 2 === 1)
        <div class="page-break"></div>
    @endif

    <div class="prodi-section">
        <div class="prodi-header">
            <h3>#{{ $rank }} {{ $r['prodi'] }}</h3>
            <span class="pct" style="color:{{ $pctColor }};">{{ $r['percentage'] }}%</span>
        </div>

        <div class="stats">
            <div class="stat"><div class="num" style="color:#2e7d32;">{{ $r['sks_exact'] }}</div><div class="lbl">SKS Exact</div></div>
            <div class="stat"><div class="num" style="color:#ff9800;">{{ $r['sks_similar'] }}</div><div class="lbl">SKS Similar</div></div>
            <div class="stat"><div class="num" style="color:#2c7aff;">{{ $r['sks_total_matched'] }}</div><div class="lbl">Total Konversi</div></div>
            <div class="stat"><div class="num" style="color:#c62828;">{{ $r['sks_remaining'] }}</div><div class="lbl">Sisa dari 144</div></div>
        </div>

        @if (count($r['exact_matched']) > 0)
            <div class="section-label" style="background:#2e7d32;">EXACT MATCH ({{ count($r['exact_matched']) }} MK, {{ $r['sks_exact'] }} SKS)</div>
            <table>
                <tr><th>Mata Kuliah UNSIA</th><th>SKS</th><th>Sem</th><th>Cocok Dengan</th></tr>
                @foreach ($r['exact_matched'] as $m)
                    <tr class="exact-row"><td>{{ $m['mk'] }}</td><td>{{ $m['sks'] }}</td><td>{{ $m['semester'] }}</td><td>{{ $m['matched_with'] }}</td></tr>
                @endforeach
            </table>
        @endif

        @if (count($r['similar_matched']) > 0)
            <div class="section-label" style="background:#e65100;">SIMILAR MATCH ({{ count($r['similar_matched']) }} MK, {{ $r['sks_similar'] }} SKS)</div>
            <table>
                <tr><th>Mata Kuliah UNSIA</th><th>SKS</th><th>Sem</th><th>Cocok Dengan</th><th>Score</th></tr>
                @foreach ($r['similar_matched'] as $m)
                    <tr class="similar-row"><td>{{ $m['mk'] }}</td><td>{{ $m['sks'] }}</td><td>{{ $m['semester'] }}</td><td>{{ $m['matched_with'] }}</td><td>{{ $m['score'] }}%</td></tr>
                @endforeach
            </table>
        @endif

        @if (count($r['unmatched']) > 0)
            <div class="section-label-red">MK YANG HARUS DIAMBIL ({{ count($r['unmatched']) }} MK)</div>
            <table>
                <tr><th>Mata Kuliah</th><th>SKS</th><th>Semester</th></tr>
                @foreach ($r['unmatched'] as $u)
                    <tr><td>{{ $u['mk'] }}</td><td>{{ $u['sks'] }}</td><td>{{ $u['semester'] }}</td></tr>
                @endforeach
            </table>
        @endif
    </div>
@endforeach

<div class="footer-note">
    <strong>Disclaimer:</strong> Laporan ini dibuat secara otomatis oleh sistem UNSIA Story sebagai estimasi awal kecocokan mata kuliah untuk keperluan RPL (Rekognisi Pembelajaran Lampau). Hasil akhir konversi mata kuliah ditentukan oleh pihak Universitas Siber Asia melalui proses evaluasi resmi. Untuk informasi lebih lanjut, hubungi tim kami di <strong>0813-3333-1686</strong> (WhatsApp) atau kunjungi <strong>unsia.my.id</strong>.
    <br><br>
    <strong>UNSIA Story</strong> — Mitra Pemasaran Resmi Universitas Siber Asia | unsia.my.id
</div>

</body>
</html>
