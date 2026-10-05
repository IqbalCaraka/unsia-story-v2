<div class="footer section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-sm-6 col-xs-12">
                <div class="single_footer">
                    <a href="{{ route('home') }}"><img src="{{ asset('assets/images/logo-unsia-story.png') }}" alt="UNSIA Story" style="max-width:100px;"></a>
                    <p>UNSIA Story adalah platform digital resmi yang merupakan bagian dari Marketing Representative Universitas Siber Asia.</p>
                </div>
                <div class="foot_social">
                    <ul>
                        <li><a href="https://www.facebook.com/unsia.my.id" target="_blank" class="top_f_facebook"><i class="fa-brands fa-facebook"></i></a></li>
                        <li><a href="https://www.instagram.com/unsia.my.id" target="_blank" class="top_f_instagram"><i class="fa-brands fa-instagram"></i></a></li>
                        <li><a href="https://www.tiktok.com/@unsia.my.id" target="_blank" class="top_f_linkedin"><i class="fa-brands fa-tiktok"></i></a></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-2 col-sm-6 col-xs-12">
                <div class="single_footer">
                    <h4>Program Studi</h4>
                    <ul>
                        <li><a href="{{ route('prodi', 'sistem-informasi') }}">Sistem Informasi</a></li>
                        <li><a href="{{ route('prodi', 'informatika') }}">Informatika</a></li>
                        <li><a href="{{ route('prodi', 'manajemen') }}">Manajemen</a></li>
                        <li><a href="{{ route('prodi', 'akuntansi') }}">Akuntansi</a></li>
                        <li><a href="{{ route('prodi', 'komunikasi') }}">Komunikasi</a></li>
                        <li><a href="{{ route('prodi', 'teknologi-informasi') }}">Teknologi Informasi</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-2 col-sm-6 col-xs-12">
                <div class="single_footer">
                    <h4>Menu</h4>
                    <ul>
                        <li><a href="{{ route('about') }}">Tentang</a></li>
                        <li><a href="{{ route('bantuan') }}">Bantuan Pendanaan</a></li>
                        <li><a href="{{ route('bantuan.ajukan') }}">Ajukan Bantuan</a></li>
                        <li><a href="{{ route('konversi') }}">Konversi Mata Kuliah</a></li>
                        <li><a href="{{ route('faq') }}">FAQ</a></li>
                        <li><a href="https://pmb.unsia.ac.id" target="_blank">Daftar PMB</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 col-xs-12">
                <div class="single_footer">
                    <h4>Hubungi Kami</h4>
                    <div class="sf_contact"><span class="ti-mobile"></span><h3>WhatsApp</h3><p><a href="https://wa.me/628133331686" style="color:inherit;">0813-3333-1686</a></p></div>
                    <div class="sf_contact"><span class="ti-email"></span><h3>Website Resmi</h3><p><a href="https://unsia.ac.id" target="_blank" style="color:inherit;">unsia.ac.id</a></p></div>
                    <div class="sf_contact"><span class="ti-map"></span><h3>Pendaftaran</h3><p><a href="https://pmb.unsia.ac.id" target="_blank" style="color:inherit;">pmb.unsia.ac.id</a></p></div>
                </div>
            </div>
            <div class="col-lg-2 col-sm-6 col-xs-12">
                <div class="single_footer">
                    <h4>Kode Referral</h4>
                    <p>Masukkan kode <strong style="color:#f0c040;font-size:18px;">unsia.my.id</strong> saat mengisi biodata di pmb.unsia.ac.id</p>
                    <p style="font-size:13px;margin-top:8px;">Potongan UKT <strong style="color:#f0c040;">Rp650.000</strong></p>
                </div>
            </div>
        </div>

        <div class="row" style="margin-top:20px;">
            <div class="col-12">
                <div style="background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.1);border-radius:8px;padding:15px 20px;">
                    <p style="font-size:12px;color:#999;margin:0 0 10px 0;line-height:1.8;"><strong>Disclaimer:</strong> Situs web ini (unsia.my.id) dikelola secara independen sebagai mitra pemasaran resmi Universitas Siber Asia. Situs ini <strong>bukan</strong> situs resmi universitas. Situs web utama universitas dapat diakses di <a href="https://unsia.ac.id" target="_blank" style="color:#f0c040;">unsia.ac.id</a>. Seluruh proses pendaftaran mahasiswa baru dilakukan melalui portal resmi <a href="https://pmb.unsia.ac.id" target="_blank" style="color:#f0c040;">pmb.unsia.ac.id</a>. Kode referral yang kami sediakan memberikan potongan biaya UKT bagi calon mahasiswa yang mendaftar melalui portal resmi universitas.</p>
                    <p style="font-size:12px;color:#999;margin:0;line-height:1.8;"><strong>Alamat:</strong> Jl. Monumen Pancasila Sakti 69, Lubang Buaya, Kec. Cipayung, Kota Jakarta Timur, DKI Jakarta 13810 | <strong>Email:</strong> <a href="mailto:unsia.story@gmail.com" style="color:#f0c040;">unsia.story@gmail.com</a> | <strong>WhatsApp:</strong> <a href="https://wa.me/628133331686" style="color:#f0c040;">0813-3333-1686</a></p>
                </div>
            </div>
        </div>

        <div class="row fc">
            <div class="col-lg-6 col-sm-6 col-xs-12">
                <div class="footer_copyright">
                    <p>&copy; {{ date('Y') }} UNSIA Story &mdash; Mitra Pemasaran Resmi <a href="https://unsia.ac.id" class="text-dark" target="_blank">Universitas Siber Asia</a></p>
                </div>
            </div>
            <div class="col-lg-6 col-sm-6 col-xs-12">
                <div class="footer_menu">
                    <ul>
                        <li><a href="https://unsia.ac.id" target="_blank">unsia.ac.id</a></li>
                        <li><a href="https://pmb.unsia.ac.id" target="_blank">pmb.unsia.ac.id</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('assets/js/jquery-1.12.4.min.js') }}"></script>
<script src="{{ asset('assets/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/owlcarousel/js/owl.carousel.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery-simple-mobilemenu.js') }}"></script>
<script src="{{ asset('assets/js/jquery.magnific-popup.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.mixitup.js') }}"></script>
<script src="{{ asset('assets/js/gsap.min.js') }}"></script>
<script src="{{ asset('assets/js/ScrollTrigger.min.js') }}"></script>
<script src="{{ asset('assets/js/scrolltopcontrol.js') }}"></script>
<script src="{{ asset('assets/js/jquery.inview.min.js') }}"></script>
<script src="{{ asset('assets/js/wow.min.js') }}"></script>
<script src="{{ asset('assets/js/scripts.js') }}"></script>

{{-- WhatsApp & Brosur Click Tracking for Google Ads Conversion --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
  document.addEventListener('click', function(e) {
    var link = e.target.closest('a');
    if (link && link.href && link.href.indexOf('wa.me') !== -1) {
      if (typeof gtag === 'function') {
        gtag('event', 'manual_event_CONTACT', { event_category: 'WhatsApp', event_label: link.href });
      }
    }
  });
});
</script>

<a href="https://wa.me/628133331686?text=Halo%2C%20saya%20ingin%20bertanya%20tentang%20kuliah%20di%20UNSIA" target="_blank" style="position:fixed;top:50%;right:25px;transform:translateY(-50%);background:#25D366;color:#fff;width:60px;height:60px;display:flex;align-items:center;justify-content:center;border-radius:50%;text-decoration:none;box-shadow:0 4px 15px rgba(37,211,102,0.4);z-index:9999;"><i class="fa-brands fa-whatsapp" style="font-size:30px;"></i></a>

<a href="{{ asset('assets/document/BROSUR UNSIA TERBARU 2026.pdf') }}" download style="position:fixed;top:calc(50% + 75px);right:25px;transform:translateY(-50%);background:#e53935;color:#fff;width:60px;height:60px;display:flex;align-items:center;justify-content:center;border-radius:50%;text-decoration:none;box-shadow:0 4px 15px rgba(229,57,53,0.4);z-index:9999;" title="Download Brosur"><i class="fa-solid fa-file-pdf" style="font-size:26px;"></i></a>
