@extends('layouts.admin')

@section('title', 'Buat Artikel')
@section('page-title', 'Buat Artikel Baru')

@section('content')

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <form action="{{ route('admin.blog.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    {{-- Judul --}}
                    <div class="mb-3">
                        <label for="judul" class="form-label fw-semibold">Judul Artikel</label>
                        <input type="text" class="form-control @error('judul') is-invalid @enderror"
                               id="judul" name="judul" value="{{ old('judul') }}"
                               placeholder="Masukkan judul artikel" required>
                        @error('judul')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Kategori --}}
                    <div class="mb-3">
                        <label for="kategori" class="form-label fw-semibold">Kategori</label>
                        <select class="form-select @error('kategori') is-invalid @enderror"
                                id="kategori" name="kategori" required>
                            <option value="" disabled selected>Pilih kategori</option>
                            <option value="blog" {{ old('kategori') === 'blog' ? 'selected' : '' }}>Blog</option>
                            <option value="berita" {{ old('kategori') === 'berita' ? 'selected' : '' }}>Berita</option>
                        </select>
                        @error('kategori')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Thumbnail --}}
                    <div class="mb-3">
                        <label for="thumbnail" class="form-label fw-semibold">Thumbnail</label>
                        <input type="file" class="form-control @error('thumbnail') is-invalid @enderror"
                               id="thumbnail" name="thumbnail" accept="image/*">
                        @error('thumbnail')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Format: JPG, PNG, WebP. Maksimal 2MB.</div>
                        <div id="thumbnailPreview" class="mt-2"></div>
                    </div>

                    {{-- Konten --}}
                    <div class="mb-3">
                        <label for="konten" class="form-label fw-semibold">Konten</label>
                        <textarea class="form-control @error('konten') is-invalid @enderror"
                                  id="konten" name="konten" rows="15"
                                  placeholder="Tulis konten artikel (mendukung HTML)">{{ old('konten') }}</textarea>
                        @error('konten')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Anda bisa menggunakan HTML untuk format teks.</div>
                    </div>

                    {{-- Status --}}
                    <div class="mb-4">
                        <label for="status" class="form-label fw-semibold">Status</label>
                        <select class="form-select @error('status') is-invalid @enderror"
                                id="status" name="status" required>
                            <option value="draft" {{ old('status', 'draft') === 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="published" {{ old('status') === 'published' ? 'selected' : '' }}>Published</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Buttons --}}
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.blog.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Kembali
                        </a>
                        <button type="submit" class="btn btn-gold">
                            <i class="fas fa-save me-2"></i>Simpan Artikel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    // Thumbnail preview
    document.getElementById('thumbnail').addEventListener('change', function(e) {
        const preview = document.getElementById('thumbnailPreview');
        preview.innerHTML = '';
        if (e.target.files && e.target.files[0]) {
            const reader = new FileReader();
            reader.onload = function(ev) {
                const img = document.createElement('img');
                img.src = ev.target.result;
                img.className = 'rounded shadow-sm';
                img.style.maxHeight = '200px';
                img.style.objectFit = 'contain';
                preview.appendChild(img);
            };
            reader.readAsDataURL(e.target.files[0]);
        }
    });
</script>
@endsection
