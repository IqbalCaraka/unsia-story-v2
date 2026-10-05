{{-- Canonical URL --}}
<link rel="canonical" href="{{ url()->current() }}">

{{-- Open Graph Tags --}}
<meta property="og:type" content="@yield('og_type', 'website')">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:title" content="@yield('title', 'UNSIA Story - Kuliah Online Universitas Siber Asia')">
<meta property="og:description" content="@yield('description', 'Portal informasi lengkap seputar kuliah online di UNSIA. Temukan program studi, biaya kuliah, dan cara pendaftaran.')">
<meta property="og:image" content="@yield('og_image', asset('assets/images/logo-unsia-story.png'))">
<meta property="og:site_name" content="UNSIA Story">
<meta property="og:locale" content="id_ID">

{{-- Twitter Card --}}
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="@yield('title', 'UNSIA Story - Kuliah Online Universitas Siber Asia')">
<meta name="twitter:description" content="@yield('description', 'Portal informasi lengkap seputar kuliah online di UNSIA. Temukan program studi, biaya kuliah, dan cara pendaftaran.')">
<meta name="twitter:image" content="@yield('og_image', asset('assets/images/logo-unsia-story.png'))">

{{-- General Meta --}}
<meta name="description" content="@yield('description', 'Portal informasi lengkap seputar kuliah online di UNSIA. Temukan program studi, biaya kuliah, dan cara pendaftaran.')">

{{-- JSON-LD EducationalOrganization --}}
<script type="application/ld+json">
{
    "@@context": "https://schema.org",
    "@@type": "EducationalOrganization",
    "name": "UNSIA Story",
    "alternateName": "Universitas Siber Asia",
    "url": "{{ url('/') }}",
    "logo": "{{ asset('assets/images/logo-unsia-story.png') }}",
    "description": "Portal informasi lengkap seputar kuliah online di Universitas Siber Asia (UNSIA). Temukan program studi, biaya kuliah terjangkau, dan cara pendaftaran.",
    "sameAs": [
        "https://facebook.com/unsia.story",
        "https://instagram.com/unsia.story",
        "https://tiktok.com/@unsia.story"
    ],
    "contactPoint": {
        "@@type": "ContactPoint",
        "telephone": "+62-813-3331-686",
        "contactType": "customer service",
        "availableLanguage": "Indonesian"
    }
}
</script>

{{-- JSON-LD WebSite with SearchAction --}}
<script type="application/ld+json">
{
    "@@context": "https://schema.org",
    "@@type": "WebSite",
    "name": "UNSIA Story",
    "url": "{{ url('/') }}",
    "potentialAction": {
        "@@type": "SearchAction",
        "target": "{{ url('/blog') }}?q={search_term_string}",
        "query-input": "required name=search_term_string"
    }
}
</script>
