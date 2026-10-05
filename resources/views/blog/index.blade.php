@extends('layouts.app')

@section('title', 'Blog & Berita - UNSIA Story')
@section('description', 'Blog & Berita UNSIA Story - Info terbaru seputar kuliah online, tips mahasiswa, dan berita Universitas Siber Asia.')
@section('keywords', 'blog unsia, berita unsia, kuliah online, universitas siber asia, tips mahasiswa')

@section('styles')
<style>
.blog-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(340px,1fr)); gap:25px; }
.blog-card { background:#fff; border-radius:14px; overflow:hidden; box-shadow:0 2px 15px rgba(0,0,0,0.06); transition:all 0.3s ease; }
.blog-card:hover { transform:translateY(-5px); box-shadow:0 8px 30px rgba(0,0,0,0.12); }
.blog-card img { width:100%; height:200px; object-fit:contain; background:#f0f4ff; padding:10px; }
.blog-card .no-img { width:100%; height:200px; background:linear-gradient(135deg,#2c7aff,#0d1b2a); display:flex; align-items:center; justify-content:center; color:#fff; font-size:40px; }
.blog-card-body { padding:20px 25px 25px; }
.blog-card-body .blog-cat { font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:1.5px; padding:4px 12px; border-radius:20px; display:inline-block; margin-bottom:10px; }
.blog-cat.cat-blog { background:#e3f2fd; color:#1565c0; }
.blog-cat.cat-berita { background:#fce4ec; color:#c62828; }
.blog-card-body h3 { font-size:18px; font-weight:700; margin-bottom:10px; line-height:1.4; }
.blog-card-body h3 a { color:#0d1b2a; text-decoration:none; }
.blog-card-body h3 a:hover { color:#2c7aff; }
.blog-card-body .blog-meta { font-size:12px; color:#999; display:flex; align-items:center; gap:8px; }
.blog-card-body .blog-excerpt { font-size:14px; color:#666; line-height:1.7; margin-top:10px; display:-webkit-box; -webkit-line-clamp:3; -webkit-box-orient:vertical; overflow:hidden; }
.blog-filter { display:flex; gap:10px; margin-bottom:30px; flex-wrap:wrap; }
.blog-filter a { padding:8px 20px; border-radius:25px; font-weight:600; font-size:13px; text-decoration:none; border:2px solid #e0e0e0; color:#666; transition:all 0.3s; }
.blog-filter a.active, .blog-filter a:hover { background:#2c7aff; color:#fff; border-color:#2c7aff; }
.blog-empty { text-align:center; padding:60px 20px; color:#999; font-size:16px; }
.blog-pagination { margin-top:40px; }
.blog-pagination .pagination { justify-content:center; }
@media(max-width:576px) { .blog-grid { grid-template-columns:1fr; } }
</style>
@endsection

@section('hero')
    @include('partials.page-hero', ['title' => 'Blog & Berita', 'crumbs' => ['Blog' => null]])
@endsection

@section('content')

<section class="section-padding" style="background:#f8f9fa;">
    <div class="container">

        @php $filter = request('kategori', 'semua'); @endphp

        <div class="blog-filter">
            <a href="{{ route('blog.index') }}" class="{{ $filter === 'semua' ? 'active' : '' }}">Semua</a>
            <a href="{{ route('blog.index', ['kategori' => 'blog']) }}" class="{{ $filter === 'blog' ? 'active' : '' }}">Blog</a>
            <a href="{{ route('blog.index', ['kategori' => 'berita']) }}" class="{{ $filter === 'berita' ? 'active' : '' }}">Berita</a>
        </div>

        @if ($posts->isEmpty())
            <div class="blog-empty">
                <i class="fa-solid fa-newspaper" style="font-size:50px;color:#ddd;display:block;margin-bottom:15px;"></i>
                Belum ada artikel. Nantikan info menarik dari kami!
            </div>
        @else
            <div class="blog-grid">
                @foreach ($posts as $post)
                    @php
                        $excerpt = strip_tags($post->konten);
                        $excerpt = mb_strlen($excerpt) > 150 ? mb_substr($excerpt, 0, 150) . '...' : $excerpt;
                    @endphp
                    <div class="blog-card">
                        <a href="{{ route('blog.show', $post->slug) }}">
                            @if ($post->thumbnail)
                                <img src="{{ $post->thumbnail }}" alt="{{ $post->judul }}">
                            @else
                                <div class="no-img"><i class="fa-solid fa-newspaper"></i></div>
                            @endif
                        </a>
                        <div class="blog-card-body">
                            <span class="blog-cat cat-{{ $post->kategori }}">{{ ucfirst($post->kategori) }}</span>
                            <h3><a href="{{ route('blog.show', $post->slug) }}">{{ $post->judul }}</a></h3>
                            <div class="blog-meta"><i class="fa-solid fa-calendar"></i> {{ $post->created_at->format('d M Y') }}</div>
                            <p class="blog-excerpt">{{ $excerpt }}</p>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="blog-pagination">
                {{ $posts->withQueryString()->links() }}
            </div>
        @endif

    </div>
</section>

@endsection
