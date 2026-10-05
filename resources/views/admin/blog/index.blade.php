@extends('layouts.admin')

@section('title', 'Blog Posts')
@section('page-title', 'Blog Posts')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <p class="text-muted mb-0">Kelola semua artikel dan berita</p>
    <a href="{{ route('admin.blog.create') }}" class="btn btn-gold">
        <i class="fas fa-plus me-2"></i>Buat Artikel
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-3" style="width: 50px;">#</th>
                        <th>Judul</th>
                        <th style="width: 120px;">Kategori</th>
                        <th style="width: 100px;">Status</th>
                        <th style="width: 130px;">Tanggal</th>
                        <th style="width: 150px;" class="text-end pe-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($posts ?? [] as $index => $post)
                        <tr>
                            <td class="ps-3 text-muted">{{ $index + 1 }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    @if ($post->thumbnail)
                                        <img src="{{ asset('storage/' . $post->thumbnail) }}"
                                             alt="" class="rounded me-2"
                                             style="width: 40px; height: 40px; object-fit: cover;">
                                    @else
                                        <div class="rounded me-2 bg-light d-flex align-items-center justify-content-center"
                                             style="width: 40px; height: 40px;">
                                            <i class="fas fa-image text-muted small"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <div class="fw-semibold">{{ Str::limit($post->judul, 50) }}</div>
                                        <small class="text-muted">{{ $post->slug }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge rounded-pill"
                                      style="background-color: {{ $post->kategori === 'berita' ? '#0d1b2a' : '#f0c040' }};
                                             color: {{ $post->kategori === 'berita' ? '#f0c040' : '#0d1b2a' }};">
                                    {{ ucfirst($post->kategori) }}
                                </span>
                            </td>
                            <td>
                                @if ($post->status === 'published')
                                    <span class="badge bg-success">Published</span>
                                @else
                                    <span class="badge bg-secondary">Draft</span>
                                @endif
                            </td>
                            <td class="text-muted small">{{ $post->created_at->format('d M Y') }}</td>
                            <td class="text-end pe-3">
                                <a href="{{ route('admin.blog.edit', $post->id) }}"
                                   class="btn btn-sm btn-outline-primary me-1" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.blog.destroy', $post->id) }}" method="POST"
                                      class="d-inline" onsubmit="return confirm('Yakin ingin menghapus artikel ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="fas fa-inbox mb-2" style="font-size: 2rem;"></i>
                                <p class="mb-0">Belum ada artikel. <a href="{{ route('admin.blog.create') }}">Buat sekarang</a></p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Pagination --}}
@if (isset($posts) && $posts->hasPages())
    <div class="d-flex justify-content-center mt-4">
        {{ $posts->links() }}
    </div>
@endif

@endsection
