<script>
// Field akademik hanya wajib untuk mahasiswa; admin justru wajib punya email.
document.addEventListener('DOMContentLoaded', function () {
    const role = document.getElementById('role');
    const blokAkademik = document.getElementById('blokAkademik');
    const email = document.getElementById('email');
    const badgeEmail = document.querySelector('[data-opsional-email]');
    const akademik = ['nim', 'prodi_id', 'tahun_ajar_id'].map(id => document.getElementById(id));

    function terapkan() {
        const admin = role.value === 'admin';

        blokAkademik.hidden = admin;
        // Wajib dilepas saat disembunyikan, kalau tidak browser menolak submit
        // dengan error "invalid form control is not focusable".
        akademik.forEach(el => el.required = !admin);

        email.required = admin;
        badgeEmail.hidden = admin;
    }

    role.addEventListener('change', terapkan);
    terapkan();
});
</script>
