@extends('layouts.app')

@php
    $plain = strip_tags($post->konten);
    $metaDesc = mb_substr($plain, 0, 160);
@endphp

@section('title', $post->judul . ' - UNSIA Story')
@section('description', $metaDesc)
@section('keywords', 'unsia, ' . $post->kategori . ', kuliah online, universitas siber asia')
@section('og_type', 'article')
@section('og_image', $post->thumbnail ? url($post->thumbnail) : asset('assets/images/logo-unsia-story.png'))

@section('meta')
<script type="application/ld+json">
{!! json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'Article',
    'headline' => $post->judul,
    'description' => mb_substr($plain, 0, 200),
    'image' => $post->thumbnail ? url($post->thumbnail) : asset('assets/images/logo-unsia-story.png'),
    'datePublished' => $post->created_at->toIso8601String(),
    'dateModified' => $post->updated_at->toIso8601String(),
    'author' => ['@type' => 'Organization', 'name' => 'UNSIA Story', 'url' => url('/')],
    'publisher' => [
        '@type' => 'Organization',
        'name' => 'UNSIA Story',
        'logo' => ['@type' => 'ImageObject', 'url' => asset('assets/images/logo-unsia-story.png')],
    ],
    'mainEntityOfPage' => ['@type' => 'WebPage', '@id' => route('blog.show', $post->slug)],
    'articleSection' => ucfirst($post->kategori),
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
</script>
@endsection

@section('styles')
<style>
.blog-detail { max-width:800px; margin:0 auto; }
.blog-detail-header { margin-bottom:30px; }
.blog-detail-header .blog-cat { font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:1.5px; padding:4px 12px; border-radius:20px; display:inline-block; margin-bottom:12px; }
.cat-blog { background:#e3f2fd; color:#1565c0; }
.cat-berita { background:#fce4ec; color:#c62828; }
.blog-detail-header h1 { font-size:28px; font-weight:800; color:#0d1b2a; line-height:1.4; margin-bottom:12px; }
.blog-detail-header .meta { font-size:13px; color:#999; display:flex; align-items:center; gap:15px; flex-wrap:wrap; }
.blog-detail-thumb { width:100%; border-radius:14px; margin-bottom:30px; max-height:500px; object-fit:contain; background:#f0f4ff; padding:10px; }
.blog-detail-content { font-size:16px; line-height:2; color:#444; }
.blog-detail-content h2 { font-size:22px; font-weight:700; color:#0d1b2a; margin:30px 0 15px; }
.blog-detail-content h3 { font-size:18px; font-weight:700; color:#0d1b2a; margin:25px 0 12px; }
.blog-detail-content p { margin-bottom:15px; }
.blog-detail-content img { max-width:100%; border-radius:10px; margin:15px 0; }
.blog-detail-content ul, .blog-detail-content ol { padding-left:25px; margin-bottom:15px; }
.blog-detail-content li { margin-bottom:8px; }
.blog-detail-content a { color:#2c7aff; font-weight:600; }
.blog-detail-content blockquote { border-left:4px solid #2c7aff; padding:15px 20px; background:#f0f4ff; border-radius:0 8px 8px 0; margin:20px 0; font-style:italic; color:#555; }
.blog-nav { display:flex; justify-content:space-between; align-items:center; margin-top:40px; padding-top:25px; border-top:2px solid #f0f0f0; }
.blog-nav a { color:#2c7aff; text-decoration:none; font-weight:600; font-size:14px; }
.blog-share { margin-top:30px; padding:20px; background:#f8f9fa; border-radius:12px; display:flex; align-items:center; gap:15px; flex-wrap:wrap; }
.blog-share span { font-weight:600; font-size:14px; color:#666; }
.blog-share a { display:inline-flex; width:36px; height:36px; border-radius:50%; align-items:center; justify-content:center; color:#fff; font-size:14px; text-decoration:none; transition:opacity 0.3s; }
.blog-share a:hover { opacity:0.8; }
@media(max-width:576px) { .blog-detail-header h1 { font-size:22px; } .blog-detail-content { font-size:15px; } }
</style>
@endsection

@section('hero')
    @include('partials.page-hero', [
        'title' => ucfirst($post->kategori),
        'crumbs' => ['Blog' => route('blog.index'), mb_substr($post->judul, 0, 40) . '...' => null],
    ])
@endsection

@section('content')

<section class="section-padding" style="background:#f8f9fa;">
    <div class="container">
        <div class="blog-detail">

            <div class="blog-detail-header">
                <span class="blog-cat cat-{{ $post->kategori }}">{{ ucfirst($post->kategori) }}</span>
                <h1>{{ $post->judul }}</h1>
                <div class="meta">
                    <span><i class="fa-solid fa-calendar" style="margin-right:5px;"></i> {{ $post->created_at->format('d M Y') }}</span>
                    @if ($post->updated_at->ne($post->created_at))
                        <span><i class="fa-solid fa-pen" style="margin-right:5px;"></i> Diperbarui: {{ $post->updated_at->format('d M Y') }}</span>
                    @endif
                </div>
            </div>

            @if ($post->thumbnail)
                <img src="{{ $post->thumbnail }}" alt="{{ $post->judul }}" class="blog-detail-thumb">
            @endif

            <div class="blog-detail-content">
                {!! $post->konten !!}
            </div>

            @php $shareUrl = route('blog.show', $post->slug); @endphp
            <div class="blog-share">
                <span><i class="fa-solid fa-share-nodes"></i> Bagikan:</span>
                <a href="https://wa.me/?text={{ urlencode($post->judul . ' - ' . $shareUrl) }}" target="_blank" style="background:#25D366;" title="WhatsApp"><i class="fa-brands fa-whatsapp"></i></a>
                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($shareUrl) }}" target="_blank" style="background:#1877F2;" title="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
                <a href="https://twitter.com/intent/tweet?text={{ urlencode($post->judul) }}&url={{ urlencode($shareUrl) }}" target="_blank" style="background:#1DA1F2;" title="Twitter"><i class="fa-brands fa-twitter"></i></a>
            </div>

            <div class="blog-nav">
                <a href="{{ route('blog.index') }}"><i class="fa-solid fa-arrow-left" style="margin-right:5px;"></i> Kembali ke Blog</a>
            </div>

        </div>
    </div>
</section>

@endsection
