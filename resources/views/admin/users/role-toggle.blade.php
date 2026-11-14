<script>
// Blok dan kewajiban field mengikuti role yang dipilih:
//
//   superadmin / admin : email
//   downline           : email + blok Data Downline
//   mahasiswa          : NIM, prodi, tahun ajar (email opsional)
//
// Aturan yang sama ditegakkan ulang di server oleh UserController::rules().
// Bagian ini hanya untuk kenyamanan pengisian, bukan pengaman.
document.addEventListener('DOMContentLoaded', function () {
    const role = document.getElementById('role');
    const blokAkademik = document.getElementById('blokAkademik');
    const blokDownline = document.getElementById('blokDownline');
    const email = document.getElementById('email');
    const statusDownline = document.getElementById('status_downline');
    const badgeEmail = document.querySelector('[data-opsional-email]');
    const akademik = ['nim', 'prodi_id', 'tahun_ajar_id'].map(id => document.getElementById(id));

    function terapkan() {
        const mahasiswa = role.value === 'mahasiswa';
        const downline = role.value === 'downline';

        // Hanya mahasiswa yang menyimpan data akademik.
        blokAkademik.hidden = !mahasiswa;
        // Wajib dilepas saat disembunyikan, kalau tidak browser menolak submit
        // dengan error "invalid form control is not focusable".
        akademik.forEach(el => el.required = mahasiswa);

        blokDownline.hidden = !downline;
        statusDownline.disabled = !downline;

        // Semua role selain mahasiswa masuk memakai email.
        email.required = !mahasiswa;
        badgeEmail.hidden = !mahasiswa;
    }

    role.addEventListener('change', terapkan);
    terapkan();

    // --- Baris sosial media: tambah & hapus ---
    const daftar = document.getElementById('daftarSosmed');
    const tombolTambah = document.getElementById('tambahSosmed');

    // Blok downline tidak ada di halaman lain yang memuat skrip ini.
    if (!daftar || !tombolTambah) return;

    // Indeks name="social_media[N]" harus unik, bukan sekadar jumlah baris —
    // kalau baris tengah dihapus lalu ditambah, jumlahnya bisa terulang dan
    // dua baris akan saling menimpa saat dikirim.
    let indeksBerikut = daftar.querySelectorAll('[data-baris-sosmed]').length;

    tombolTambah.addEventListener('click', function () {
        const contoh = daftar.querySelector('[data-baris-sosmed]');
        if (!contoh) return;

        const baris = contoh.cloneNode(true);

        baris.querySelectorAll('[name]').forEach(function (el) {
            el.name = el.name.replace(/social_media\[\d+\]/, 'social_media[' + indeksBerikut + ']');
            if (el.tagName === 'INPUT') el.value = '';
            el.classList.remove('is-invalid');
        });

        // Pesan error milik baris contoh jangan ikut tersalin.
        baris.querySelectorAll('.invalid-feedback').forEach(el => el.remove());

        daftar.appendChild(baris);
        indeksBerikut++;
    });

    daftar.addEventListener('click', function (e) {
        if (!e.target.closest('[data-hapus-sosmed]')) return;

        const baris = e.target.closest('[data-baris-sosmed]');
        const semua = daftar.querySelectorAll('[data-baris-sosmed]');

        // Baris terakhir dikosongkan saja, bukan dibuang — supaya selalu ada
        // satu baris siap diisi. Baris kosong tidak ikut disimpan.
        if (semua.length === 1) {
            baris.querySelectorAll('input').forEach(el => el.value = '');
            return;
        }

        baris.remove();
    });
});
</script>
