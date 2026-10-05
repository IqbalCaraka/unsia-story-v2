{{-- Google Tag Manager (noscript) --}}
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-PCN9L82G"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>

<div class="preloaders"><img src="{{ asset('assets/images/mascot-unsiro.png') }}" alt="Loading" style="width:120px;"></div>

<div class="top_header_banner">
    <section class="logo-contact">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="single-top-contact">
                        <i class="ti-mobile"></i>
                        <h4><a href="https://wa.me/628133331686?text=Halo%2C%20saya%20ingin%20bertanya%20tentang%20kuliah%20di%20UNSIA" target="_blank">081 3333 1686</a></h4>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="single-top-contact">
                        <i class="fa-solid fa-file-pdf"></i>
                        <h4><a href="{{ asset('assets/document/BROSUR UNSIA TERBARU 2026.pdf') }}" download>Download Brosur</a></h4>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="single-top-contact">
                        <i class="ti-alarm-clock"></i>
                        <h4>Buka 24 Jam / 7 Hari</h4>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="top_social_profile">
                        <ul>
                            <li><a href="https://www.facebook.com/unsia.my.id" target="_blank" class="top_f_facebook"><i class="fa-brands fa-facebook"></i></a></li>
                            <li><a href="https://www.instagram.com/unsia.my.id" target="_blank" class="top_f_instagram"><i class="fa-brands fa-instagram"></i></a></li>
                            <li><a href="https://www.tiktok.com/@unsia.my.id" target="_blank" class="top_f_linkedin"><i class="fa-brands fa-tiktok"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div id="navigation" class="navbar-light bg-faded site-navigation">
        <div class="container">
            <div class="row">
                <div id="nav-logo" style="width:12%;flex-shrink:0;padding-right:10px;" class="align-self-center">
                    <div class="site-logo">
                        <a href="{{ route('home') }}"><img src="{{ asset('assets/images/logo-unsia-horizontal.jpg') }}" alt="UNSIA Story"></a>
                    </div>
                </div>
                <div id="nav-menu" style="width:75%;flex-grow:1;" class="d-flex">
                    <nav id="main-menu">
                        <ul>
                            <li><a href="{{ route('home') }}">Beranda</a></li>
                            <li><a href="{{ route('about') }}">Tentang</a></li>
                            <li class="menu-item-has-children"><a href="#">Program Studi</a>
                                <ul>
                                    <li><a href="{{ route('prodi', 'sistem-informasi') }}">Sistem Informasi</a></li>
                                    <li><a href="{{ route('prodi', 'informatika') }}">Informatika</a></li>
                                    <li><a href="{{ route('prodi', 'manajemen') }}">Manajemen</a></li>
                                    <li><a href="{{ route('prodi', 'akuntansi') }}">Akuntansi</a></li>
                                    <li><a href="{{ route('prodi', 'komunikasi') }}">Komunikasi</a></li>
                                    <li><a href="{{ route('prodi', 'teknologi-informasi') }}">Teknologi Informasi</a></li>
                                </ul>
                            </li>
                            <li class="menu-item-has-children"><a href="{{ route('bantuan') }}">Bantuan Pendanaan</a>
                                <ul>
                                    <li><a href="{{ route('bantuan') }}">Info Bantuan Pendanaan</a></li>
                                    <li><a href="{{ route('bantuan.ajukan') }}">Ajukan Bantuan Pendanaan</a></li>
                                </ul>
                            </li>
                            <li class="menu-item-has-children"><a href="#">Tools</a>
                                <ul>
                                    <li><a href="{{ route('konversi') }}">Konversi Mata Kuliah</a></li>
                                </ul>
                            </li>
                            <li class="menu-item-has-children"><a href="{{ route('blog.index') }}">Artikel</a>
                                <ul>
                                    <li><a href="{{ route('blog.index', ['kategori' => 'berita']) }}">Berita</a></li>
                                    <li><a href="{{ route('blog.index', ['kategori' => 'blog']) }}">Blog</a></li>
                                </ul>
                            </li>
                            <li><a href="{{ route('faq') }}">FAQ</a></li>
                        </ul>
                    </nav>
                </div>
                <div id="nav-cta" style="width:13%;flex-shrink:0;white-space:nowrap;" class="d-none d-xl-block text-end align-self-center">
                    <div class="call_to_action">
                        <a class="btn_two" href="https://pmb.unsia.ac.id" target="_blank">Daftar <i class="fa-solid fa-arrow-right"></i></a>
                    </div>
                </div>
                <ul class="mobile_menu">
                    <li><a href="{{ route('home') }}">Beranda</a></li>
                    <li><a href="{{ route('about') }}">Tentang</a></li>
                    <li><a href="#">Program Studi</a>
                        <ul class="sub-menu">
                            <li><a href="{{ route('prodi', 'sistem-informasi') }}">Sistem Informasi</a></li>
                            <li><a href="{{ route('prodi', 'informatika') }}">Informatika</a></li>
                            <li><a href="{{ route('prodi', 'manajemen') }}">Manajemen</a></li>
                            <li><a href="{{ route('prodi', 'akuntansi') }}">Akuntansi</a></li>
                            <li><a href="{{ route('prodi', 'komunikasi') }}">Komunikasi</a></li>
                            <li><a href="{{ route('prodi', 'teknologi-informasi') }}">Teknologi Informasi</a></li>
                        </ul>
                    </li>
                    <li><a href="{{ route('bantuan') }}">Bantuan Pendanaan</a>
                        <ul class="sub-menu">
                            <li><a href="{{ route('bantuan') }}">Info Bantuan Pendanaan</a></li>
                            <li><a href="{{ route('bantuan.ajukan') }}">Ajukan Bantuan Pendanaan</a></li>
                        </ul>
                    </li>
                    <li><a href="#">Tools</a>
                        <ul class="sub-menu">
                            <li><a href="{{ route('konversi') }}">Konversi Mata Kuliah</a></li>
                        </ul>
                    </li>
                    <li><a href="{{ route('blog.index') }}">Artikel</a>
                        <ul class="sub-menu">
                            <li><a href="{{ route('blog.index', ['kategori' => 'berita']) }}">Berita</a></li>
                            <li><a href="{{ route('blog.index', ['kategori' => 'blog']) }}">Blog</a></li>
                        </ul>
                    </li>
                    <li><a href="{{ route('faq') }}">FAQ</a></li>
                </ul>
            </div>
        </div>
    </div>
