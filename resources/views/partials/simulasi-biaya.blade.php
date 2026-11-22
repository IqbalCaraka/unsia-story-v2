@php use App\Support\Referral as R; @endphp

{{-- Simulasi biaya kuliah, dengan dan tanpa kode referal.

     SELURUH angka di bawah dirender dari App\Support\Referral, yang membacanya
     dari config/referral.php. JavaScript di bagian bawah hanya menampilkan dan
     menyembunyikan panel — ia tidak menghitung apa pun. Dengan begitu angka di
     layar tidak mungkin berbeda dari angka di server. --}}

<style>
    .sim_tab {
        display: inline-block;
        padding: 10px 24px;
        border: 1px solid #d5d9e0;
        background: #fff;
        color: #0d1b2a;
        font-weight: 600;
        font-size: 15px;
        cursor: pointer;
    }
    .sim_tab:first-child { border-radius: 8px 0 0 8px; }
    .sim_tab:last-child { border-radius: 0 8px 8px 0; border-left: none; }
    .sim_tab[aria-selected="true"] { background: #0d1b2a; color: #f0c040; border-color: #0d1b2a; }

    .sim_kartu {
        background: #fff;
        border-radius: 14px;
        padding: 28px 26px;
        height: 100%;
        box-shadow: 0 5px 20px rgba(0,0,0,0.06);
    }
    .sim_kartu--hemat { border: 2px solid #2e7d32; }

    .sim_baris {
        display: flex;
        justify-content: space-between;
        gap: 12px;
        padding: 9px 0;
        border-bottom: 1px dashed #e3e6ea;
        font-size: 15px;
        color: #555;
    }
    .sim_baris:last-of-type { border-bottom: none; }
    .sim_baris strong { color: #0d1b2a; white-space: nowrap; }
    .sim_baris--potong strong { color: #2e7d32; }

    .sim_total {
        display: flex;
        justify-content: space-between;
        align-items: baseline;
        gap: 12px;
        margin-top: 14px;
        padding-top: 14px;
        border-top: 2px solid #0d1b2a;
    }
    .sim_total span { font-size: 14px; color: #666; text-transform: uppercase; letter-spacing: 1px; }
    .sim_total b { font-size: 26px; color: #0d1b2a; white-space: nowrap; }

    .sim_gembok {
        text-align: center;
        padding: 18px 10px;
        border: 2px dashed #d5d9e0;
        border-radius: 10px;
        color: #777;
        font-size: 14px;
        line-height: 1.8;
    }
</style>

<section class="section-padding" style="background: #f8f9fa;" id="simulasi-biaya">
    <div class="container">
        <div class="section-title text-center">
            <h4>Simulasi Biaya</h4>
            <h1>Hitung Sendiri Hematnya</h1>
        </div>

        {{-- Isian kode --}}
        <div class="row justify-content-center">
            <div class="col-lg-8 col-12">
                <div style="background: #fff; border-radius: 14px; padding: 26px; box-shadow: 0 5px 20px rgba(0,0,0,0.06);">
                    <label for="simKode" style="font-weight: 600; display: block; margin-bottom: 10px;">
                        Punya kode referal? Coba masukkan di sini:
                    </label>

                    <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                        <input type="text" id="simKode" autocomplete="off" spellcheck="false"
                               placeholder="ketik kode referal"
                               style="flex: 1 1 220px; padding: 12px 15px; border: 1px solid #d5d9e0; border-radius: 8px; font-size: 16px;">
                        <button type="button" id="simTerapkan"
                                style="padding: 12px 26px; border: none; border-radius: 8px; background: #0d1b2a; color: #f0c040; font-weight: 700; font-size: 15px; cursor: pointer;">
                            Terapkan
                        </button>
                    </div>

                    <p id="simPesan" role="status" aria-live="polite"
                       style="margin: 12px 0 0; font-size: 14px; color: #666;">
                        Belum ada kode. Kolom kanan masih memakai biaya normal.
                    </p>
                </div>
            </div>
        </div>

        {{-- Pemilih skema pembayaran --}}
        <div class="text-center" style="margin: 32px 0 24px;">
            <div role="tablist" aria-label="Skema pembayaran">
                <button type="button" class="sim_tab" role="tab" data-sim-tab="lunas" aria-selected="true">
                    Bayar Lunas
                </button>
                <button type="button" class="sim_tab" role="tab" data-sim-tab="cicilan" aria-selected="false">
                    Cicil {{ R::jumlahCicilan() }}x
                </button>
            </div>
        </div>

        {{-- ============ PANEL: BAYAR LUNAS ============ --}}
        <div data-sim-panel="lunas">
            <div class="row">
                <div class="col-lg-6 col-12" style="margin-bottom: 25px;">
                    <div class="sim_kartu">
                        <h4 style="font-weight: 700; margin-bottom: 4px;">Tanpa Kode Referal</h4>
                        <p style="color: #888; font-size: 14px; margin-bottom: 16px;">Biaya normal</p>

                        <div class="sim_baris">
                            <span>UKT semester 1</span>
                            <strong>{{ R::rupiah(R::ukt()) }}</strong>
                        </div>

                        <div class="sim_total">
                            <span>Total dibayar</span>
                            <b>{{ R::rupiah(R::ukt()) }}</b>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-12" style="margin-bottom: 25px;">
                    <div class="sim_kartu sim_kartu--hemat">
                        <h4 style="font-weight: 700; margin-bottom: 4px;">Dengan Kode Referal</h4>
                        <p style="color: #888; font-size: 14px; margin-bottom: 16px;">
                            Kode <strong style="color: #2c7aff;">{{ R::kode() }}</strong>
                        </p>

                        <div data-sim-terkunci>
                            <div class="sim_baris">
                                <span>UKT semester 1</span>
                                <strong>{{ R::rupiah(R::ukt()) }}</strong>
                            </div>
                            <div class="sim_gembok" style="margin-top: 14px;">
                                <i class="fa-solid fa-arrow-up" style="margin-right: 6px;"></i>
                                Masukkan kode referal di atas untuk melihat potongannya
                            </div>
                        </div>

                        <div data-sim-terbuka hidden>
                            <div class="sim_baris">
                                <span>UKT semester 1</span>
                                <strong>{{ R::rupiah(R::ukt()) }}</strong>
                            </div>
                            <div class="sim_baris sim_baris--potong">
                                <span>Potongan UKT dari UNSIA</span>
                                <strong>&minus; {{ R::rupiah(R::potongan()) }}</strong>
                            </div>
                            <div class="sim_baris">
                                <span>Dibayar ke UNSIA</span>
                                <strong>{{ R::rupiah(R::setelahPotongan()) }}</strong>
                            </div>
                            <div class="sim_baris sim_baris--potong">
                                <span>Cashback dari UNSIA Story</span>
                                <strong>&minus; {{ R::rupiah(R::cashback()) }}</strong>
                            </div>

                            <div class="sim_total">
                                <span>Biaya bersih</span>
                                <b style="color: #2e7d32;">{{ R::rupiah(R::biayaBersih()) }}</b>
                            </div>

                            <p style="margin: 14px 0 0; font-size: 14px; color: #2e7d32; font-weight: 600;">
                                <i class="fa-solid fa-circle-check" style="margin-right: 6px;"></i>
                                Hemat {{ R::rupiah(R::totalManfaat()) }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ============ PANEL: CICILAN ============ --}}
        <div data-sim-panel="cicilan" hidden>
            <div class="row">
                <div class="col-lg-6 col-12" style="margin-bottom: 25px;">
                    <div class="sim_kartu">
                        <h4 style="font-weight: 700; margin-bottom: 4px;">Tanpa Kode Referal</h4>
                        <p style="color: #888; font-size: 14px; margin-bottom: 16px;">
                            UKT {{ R::rupiah(R::ukt()) }} dibagi {{ R::jumlahCicilan() }} cicilan
                        </p>

                        @foreach (R::rincianCicilan() as $c)
                            <div class="sim_baris">
                                <span>Cicilan ke-{{ $c['ke'] }}</span>
                                <strong>{{ R::rupiah($c['tanpa_kode']) }}</strong>
                            </div>
                        @endforeach

                        <div class="sim_total">
                            <span>Total dibayar</span>
                            <b>{{ R::rupiah(R::ukt()) }}</b>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-12" style="margin-bottom: 25px;">
                    <div class="sim_kartu sim_kartu--hemat">
                        <h4 style="font-weight: 700; margin-bottom: 4px;">Dengan Kode Referal</h4>
                        <p style="color: #888; font-size: 14px; margin-bottom: 16px;">
                            Potongan UKT {{ R::rupiah(R::potongan()) }} dari UNSIA dan cashback
                            {{ R::rupiah(R::cashback()) }} dari UNSIA Story, keduanya diproses di
                            cicilan ke-{{ R::cicilanDiproses() }}
                        </p>

                        <div data-sim-terkunci>
                            @foreach (R::rincianCicilan() as $c)
                                <div class="sim_baris">
                                    <span>Cicilan ke-{{ $c['ke'] }}</span>
                                    <strong>{{ R::rupiah($c['tanpa_kode']) }}</strong>
                                </div>
                            @endforeach
                            <div class="sim_gembok" style="margin-top: 14px;">
                                <i class="fa-solid fa-arrow-up" style="margin-right: 6px;"></i>
                                Masukkan kode referal di atas untuk melihat potongannya
                            </div>
                        </div>

                        <div data-sim-terbuka hidden>
                            @foreach (R::rincianCicilan() as $c)
                                <div class="sim_baris {{ $c['potongan'] ? 'sim_baris--potong' : '' }}">
                                    <span>
                                        Cicilan ke-{{ $c['ke'] }}
                                        @if ($c['potongan'])
                                            <br>
                                            <small style="color: #888; line-height: 1.7; display: block;">
                                                {{ R::rupiah($c['sebelum_manfaat']) }}<br>
                                                &minus; potongan UKT {{ R::rupiah($c['potongan']) }}
                                                <strong style="color: #2e7d32;">dari UNSIA</strong><br>
                                                &minus; cashback {{ R::rupiah($c['cashback']) }}
                                                <strong style="color: #2e7d32;">dari UNSIA Story</strong>
                                            </small>
                                        @endif
                                    </span>
                                    <strong>{{ R::rupiah($c['dengan_kode']) }}</strong>
                                </div>
                            @endforeach

                            <div class="sim_total">
                                <span>Biaya bersih</span>
                                <b style="color: #2e7d32;">{{ R::rupiah(R::biayaBersih()) }}</b>
                            </div>

                            <p style="margin: 14px 0 0; font-size: 14px; color: #2e7d32; font-weight: 600;">
                                <i class="fa-solid fa-circle-check" style="margin-right: 6px;"></i>
                                Hemat {{ R::rupiah(R::totalManfaat()) }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-10 col-12">
                    <p style="font-size: 14px; color: #666; line-height: 1.8; margin: 0;">
                        <i class="fa-solid fa-circle-info" style="color: #f0c040; margin-right: 6px;"></i>
                        Pada skema cicilan, potongan dan cashback <strong>tidak dibagi rata</strong> ke setiap
                        cicilan. Keduanya baru diproses pada <strong>cicilan ke-{{ R::cicilanDiproses() }}</strong>,
                        sehingga dua cicilan pertama tetap {{ R::rupiah(R::rincianCicilan()[0]['tanpa_kode']) }}.
                        Potongan UKT {{ R::rupiah(R::potongan()) }} berasal <strong>dari UNSIA</strong>, sedangkan
                        cashback {{ R::rupiah(R::cashback()) }} <strong>dari UNSIA Story</strong> &mdash; dua pihak
                        yang berbeda. Totalnya sama saja dengan bayar lunas: {{ R::rupiah(R::biayaBersih()) }}.
                    </p>
                </div>
            </div>
        </div>

        <p class="text-center" style="margin: 10px 0 0; font-size: 14px; color: #666;">
            Kode dimasukkan saat mengisi biodata di
            <a href="https://pmb.unsia.ac.id" target="_blank" style="color: #2c7aff; font-weight: 600;">pmb.unsia.ac.id</a>,
            <strong>sebelum</strong> membayar UKT.
            <a href="{{ route('referral') }}" style="color: #2c7aff; font-weight: 600;">Pelajari kode referal</a>
        </p>
    </div>
</section>

<script>
// Hanya memindahkan tampilan: mengganti tab dan membuka panel "dengan kode".
// Tidak ada perhitungan di sini — semua angka sudah dirender dari server.
document.addEventListener('DOMContentLoaded', function () {
    var akar = document.getElementById('simulasi-biaya');
    if (!akar) return;

    var kodeBenar = @json(mb_strtolower(R::kode()));

    var isian = document.getElementById('simKode');
    var tombol = document.getElementById('simTerapkan');
    var pesan = document.getElementById('simPesan');
    var tabs = akar.querySelectorAll('[data-sim-tab]');
    var panels = akar.querySelectorAll('[data-sim-panel]');

    function pilihTab(nama) {
        tabs.forEach(function (t) {
            t.setAttribute('aria-selected', String(t.dataset.simTab === nama));
        });
        panels.forEach(function (p) {
            p.hidden = p.dataset.simPanel !== nama;
        });
    }

    tabs.forEach(function (t) {
        t.addEventListener('click', function () { pilihTab(t.dataset.simTab); });
    });

    function setTerbuka(terbuka) {
        // Kedua panel ikut berubah, supaya berganti tab tidak mengembalikan
        // keadaan terkunci setelah kode sudah diterapkan.
        akar.querySelectorAll('[data-sim-terkunci]').forEach(function (el) { el.hidden = terbuka; });
        akar.querySelectorAll('[data-sim-terbuka]').forEach(function (el) { el.hidden = !terbuka; });
    }

    function terapkan() {
        var diisi = isian.value.trim().toLowerCase();

        if (diisi === '') {
            setTerbuka(false);
            pesan.style.color = '#666';
            pesan.textContent = 'Belum ada kode. Kolom kanan masih memakai biaya normal.';
            return;
        }

        if (diisi === kodeBenar) {
            setTerbuka(true);
            pesan.style.color = '#2e7d32';
            pesan.textContent = 'Kode berlaku. Potongan dan cashback sudah dihitung di kolom kanan.';
            return;
        }

        setTerbuka(false);
        pesan.style.color = '#c62828';
        pesan.textContent = 'Kode "' + isian.value.trim() + '" tidak dikenali. Kode kami: ' + kodeBenar;
    }

    tombol.addEventListener('click', terapkan);

    isian.addEventListener('keydown', function (e) {
        if (e.key === 'Enter') { e.preventDefault(); terapkan(); }
    });
});
</script>
