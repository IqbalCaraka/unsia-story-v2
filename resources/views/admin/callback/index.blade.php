@extends('layouts.admin')

@section('title', 'Callback Requests')
@section('page-title', 'Callback Requests')

@section('content')

<div class="mb-4">
    <p class="text-muted mb-0">Daftar permintaan untuk dihubungi dari pengunjung website</p>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-3" style="width: 50px;">#</th>
                        <th>Nama</th>
                        <th>Kontak</th>
                        <th>Tanggal Hubungi</th>
                        <th>Waktu</th>
                        <th style="width: 120px;">Status</th>
                        <th style="width: 130px;">Masuk</th>
                        <th style="width: 150px;" class="text-end pe-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($callbacks ?? [] as $index => $cb)
                        <tr class="{{ $cb->status === 'pending' ? '' : 'table-light' }}">
                            <td class="ps-3 text-muted">{{ $index + 1 }}</td>
                            <td class="fw-semibold">{{ $cb->nama }}</td>
                            <td>
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $cb->kontak) }}"
                                   target="_blank" rel="noopener noreferrer"
                                   class="text-decoration-none">
                                    <i class="fab fa-whatsapp text-success me-1"></i>{{ $cb->kontak }}
                                </a>
                            </td>
                            <td>{{ \Carbon\Carbon::parse($cb->tanggal_hubungi)->format('d M Y') }}</td>
                            <td>{{ $cb->waktu_hubungi }}</td>
                            <td>
                                @if ($cb->status === 'pending')
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @else
                                    <span class="badge bg-success">Contacted</span>
                                @endif
                            </td>
                            <td class="text-muted small">{{ $cb->created_at->format('d M Y H:i') }}</td>
                            <td class="text-end pe-3">
                                @if ($cb->status === 'pending')
                                    <form action="{{ route('admin.callback.contacted', $cb->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-sm btn-outline-success me-1"
                                                title="Tandai sudah dihubungi">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </form>
                                @endif
                                <form action="{{ route('admin.callback.destroy', $cb->id) }}" method="POST"
                                      class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
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
                            <td colspan="8" class="text-center py-5 text-muted">
                                <i class="fas fa-inbox mb-2" style="font-size: 2rem;"></i>
                                <p class="mb-0">Belum ada permintaan callback.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Pagination --}}
@if (isset($callbacks) && $callbacks->hasPages())
    <div class="d-flex justify-content-center mt-4">
        {{ $callbacks->links() }}
    </div>
@endif

@endsection
