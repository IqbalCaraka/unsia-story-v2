<script>
// Field akademik hanya wajib untuk mahasiswa; admin justru wajib punya email.
document.addEventListener('DOMContentLoaded', function () {
    const role = document.getElementById('role');
    const blokAkademik = document.getElementById('blokAkademik');
    const email = document.getElementById('email');
    const badgeEmail = document.querySelector('[data-opsional-email]');
    const akademik = ['nim', 'prodi_id', 'tahun_ajar_id'].map(id => document.getElementById(id));

    function terapkan() {
        // superadmin dan admin sama-sama akun pengelola: tanpa data akademik,
        // dan emailnya wajib karena dipakai untuk login.
        const pengelola = role.value === 'admin' || role.value === 'superadmin';

        blokAkademik.hidden = pengelola;
        // Wajib dilepas saat disembunyikan, kalau tidak browser menolak submit
        // dengan error "invalid form control is not focusable".
        akademik.forEach(el => el.required = !pengelola);

        email.required = pengelola;
        badgeEmail.hidden = pengelola;
    }

    role.addEventListener('change', terapkan);
    terapkan();
});
</script>
