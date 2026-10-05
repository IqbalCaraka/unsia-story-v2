{{-- Hero halaman dalam (breadcrumb).
     $title  : judul halaman
     $crumbs : array [label => url|null] --}}
<section class="section-top">
    <div class="container">
        <div class="col-lg-10 offset-lg-1 text-center">
            <div class="section-top-title wow fadeInRight" data-wow-duration="1s" data-wow-delay="0.3s" data-wow-offset="0">
                <h1>{{ $title }}</h1>
                <ul>
                    <li><a href="{{ route('home') }}">Beranda</a></li>
                    @foreach ($crumbs ?? [] as $label => $url)
                        <li> / @if ($url)<a href="{{ $url }}">{{ $label }}</a>@else{{ $label }}@endif</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</section>
