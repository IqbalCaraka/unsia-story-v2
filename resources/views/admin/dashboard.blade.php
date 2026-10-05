@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')

{{-- Stats Cards --}}
<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body d-flex align-items-center">
                <div class="rounded-3 p-3 me-3" style="background-color: rgba(13, 27, 42, 0.1);">
                    <i class="fas fa-newspaper fs-4" style="color: #0d1b2a;"></i>
                </div>
                <div>
                    <h3 class="fw-bold mb-0">{{ $totalPosts ?? 0 }}</h3>
                    <p class="text-muted small mb-0">Total Blog Posts</p>
                </div>
            </div>
            <div class="card-footer bg-transparent border-0 pt-0">
                <a href="{{ route('admin.blog.index') }}" class="text-decoration-none small">
                    Kelola Blog <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body d-flex align-items-center">
                <div class="rounded-3 p-3 me-3" style="background-color: rgba(240, 192, 64, 0.2);">
                    <i class="fas fa-phone-alt fs-4" style="color: #f0c040;"></i>
                </div>
                <div>
                    <h3 class="fw-bold mb-0">{{ $pendingCallbacks ?? 0 }}</h3>
                    <p class="text-muted small mb-0">Callback Pending</p>
                </div>
            </div>
            <div class="card-footer bg-transparent border-0 pt-0">
                <a href="{{ route('admin.callback.index') }}" class="text-decoration-none small">
                    Kelola Callback <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body d-flex align-items-center">
                <div class="rounded-3 p-3 me-3" style="background-color: rgba(25, 135, 84, 0.1);">
                    <i class="fas fa-calendar-check fs-4 text-success"></i>
                </div>
                <div>
                    <h3 class="fw-bold mb-0">{{ $totalEvents ?? 0 }}</h3>
                    <p class="text-muted small mb-0">Total Events</p>
                </div>
            </div>
            <div class="card-footer bg-transparent border-0 pt-0">
                <a href="{{ route('admin.events.index') }}" class="text-decoration-none small">
                    Kelola Events <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
    </div>
</div>

{{-- Quick Navigation --}}
<div class="row g-4">
    <div class="col-md-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white fw-bold border-0 pt-3">
                <i class="fas fa-bolt me-2 text-warning"></i>Aksi Cepat
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.blog.create') }}" class="btn btn-outline-primary text-start">
                        <i class="fas fa-plus me-2"></i>Buat Artikel Baru
                    </a>
                    <a href="{{ route('admin.callback.index') }}" class="btn btn-outline-warning text-start">
                        <i class="fas fa-phone me-2"></i>Lihat Callback Requests
                    </a>
                    <a href="{{ route('admin.events.create') }}" class="btn btn-outline-success text-start">
                        <i class="fas fa-calendar-plus me-2"></i>Buat Event Baru
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white fw-bold border-0 pt-3">
                <i class="fas fa-link me-2 text-primary"></i>Tautan Berguna
            </div>
            <div class="card-body">
                <ul class="list-unstyled mb-0">
                    <li class="mb-2">
                        <a href="{{ route('home') }}" target="_blank" class="text-decoration-none">
                            <i class="fas fa-globe me-2 text-muted"></i>Website Utama
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="https://pmb.unsia.ac.id" target="_blank" class="text-decoration-none">
                            <i class="fas fa-graduation-cap me-2 text-muted"></i>PMB UNSIA
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="https://wa.me/628133331686" target="_blank" class="text-decoration-none">
                            <i class="fab fa-whatsapp me-2 text-muted"></i>WhatsApp
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

@endsection
