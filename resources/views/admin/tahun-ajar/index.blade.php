@extends('layouts.admin')

@section('title', 'Tahun Ajar')
@section('page-title', 'Manajemen Tahun Ajar')

@section('content')

<p class="text-muted">Kelola periode tahun ajar yang bisa dipilih pada data mahasiswa</p>

<div class="row g-3">
    {{-- Form tambah --}}
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <h6 class="fw-bold mb-3"><i class="fas fa-plus me-2"></i>Tambah Tahun Ajar</h6>

                <form action="{{ route('admin.tahun-ajar.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="tahun_ajar" class="form-label fw-semibold">Tahun Ajar</label>
                        <input type="text" class="form-control @error('tahun_ajar') is-invalid @enderror"
                               id="tahun_ajar" name="tahun_ajar" value="{{ old('tahun_ajar') }}"
                               placeholder="2025/2026" required>
                        @error('tahun_ajar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Format: 2025/2026</div>
                    </div>

                    <div class="mb-3">
                        <label for="ganjil_genap" class="form-label fw-semibold">Semester</label>
                        <select class="form-select @error('ganjil_genap') is-invalid @enderror"
                                id="ganjil_genap" name="ganjil_genap" required>
                            <option value="ganjil" {{ old('ganjil_genap') === 'ganjil' ? 'selected' : '' }}>Ganjil</option>
                            <option value="genap" {{ old('ganjil_genap') === 'genap' ? 'selected' : '' }}>Genap</option>
                        </select>
                        @error('ganjil_genap')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="nominal_cashback" class="form-label fw-semibold">Nominal Cashback</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" min="0" step="1000"
                                   class="form-control @error('nominal_cashback') is-invalid @enderror"
                                   id="nominal_cashback" name="nominal_cashback"
                                   value="{{ old('nominal_cashback', 150000) }}" required>
                            @error('nominal_cashback')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-text">Isi 0 kalau periode ini tidak membuka cashback.</div>
                    </div>

                    <button type="submit" class="btn btn-gold w-100">
                        <i class="fas fa-save me-2"></i>Simpan
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- Daftar --}}
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-3" style="width: 50px;">#</th>
                                <th>Tahun Ajar</th>
                                <th style="width: 100px;">Semester</th>
                                <th style="width: 130px;">Cashback</th>
                                <th style="width: 90px;">Pengguna</th>
                                <th style="width: 110px;" class="text-end pe-3">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($tahunAjarList as $index => $ta)
                                <tr>
                                    <td class="ps-3 text-muted">{{ $tahunAjarList->firstItem() + $index }}</td>
                                    <td class="fw-semibold">{{ $ta->tahun_ajar }}</td>
                                    <td>
                                        <span class="badge rounded-pill
                                            {{ $ta->ganjil_genap === 'ganjil' ? 'bg-primary' : 'bg-info text-dark' }}">
                                            {{ ucfirst($ta->ganjil_genap) }}
                                        </span>
                                    </td>
                                    <td>
                                        @if ($ta->cashbackDibuka())
                                            <span class="fw-semibold">{{ $ta->nominal_rupiah }}</span>
                                            @if ($ta->pengajuan_cashback_count)
                                                <div class="text-muted small">
                                                    {{ $ta->pengajuan_cashback_count }} pengajuan
                                                </div>
                                            @endif
                                        @else
                                            <span class="text-muted small">Tidak dibuka</span>
                                        @endif
                                    </td>
                                    <td class="text-muted">{{ $ta->users_count }}</td>
                                    <td class="text-end pe-3">
                                        <button type="button" class="btn btn-sm btn-outline-primary me-1"
                                                data-bs-toggle="modal" data-bs-target="#editTa{{ $ta->id }}"
                                                title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <form action="{{ route('admin.tahun-ajar.destroy', $ta->id) }}" method="POST"
                                              class="d-inline"
                                              onsubmit="return confirm('Hapus tahun ajar {{ $ta->label }}?')">
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
                                        <i class="fas fa-calendar-alt mb-2" style="font-size: 2rem;"></i>
                                        <p class="mb-0">Belum ada tahun ajar. Tambahkan lewat form di samping.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        @if ($tahunAjarList->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $tahunAjarList->links() }}
            </div>
        @endif
    </div>
</div>

{{-- Modal edit per baris, masing-masing pakai error bag sendiri --}}
@foreach ($tahunAjarList as $ta)
    @php $bag = $errors->getBag('tahunAjar' . $ta->id); @endphp
    <div class="modal fade" id="editTa{{ $ta->id }}" tabindex="-1" aria-hidden="true"
         @if ($bag->any()) data-autoshow @endif>
        <div class="modal-dialog modal-dialog-centered">
            <form class="modal-content" action="{{ route('admin.tahun-ajar.update', $ta->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="modal-header">
                    <h6 class="modal-title fw-bold">Edit Tahun Ajar</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label for="tahun_ajar{{ $ta->id }}" class="form-label fw-semibold">Tahun Ajar</label>
                        <input type="text" class="form-control {{ $bag->has('tahun_ajar') ? 'is-invalid' : '' }}"
                               id="tahun_ajar{{ $ta->id }}" name="tahun_ajar"
                               value="{{ old('tahun_ajar', $ta->tahun_ajar) }}" required>
                        @if ($bag->has('tahun_ajar'))
                            <div class="invalid-feedback">{{ $bag->first('tahun_ajar') }}</div>
                        @endif
                        <div class="form-text">Format: 2025/2026</div>
                    </div>

                    <div class="mb-3">
                        <label for="ganjil_genap{{ $ta->id }}" class="form-label fw-semibold">Semester</label>
                        <select class="form-select {{ $bag->has('ganjil_genap') ? 'is-invalid' : '' }}"
                                id="ganjil_genap{{ $ta->id }}" name="ganjil_genap" required>
                            @foreach (['ganjil', 'genap'] as $semester)
                                <option value="{{ $semester }}"
                                    {{ old('ganjil_genap', $ta->ganjil_genap) === $semester ? 'selected' : '' }}>
                                    {{ ucfirst($semester) }}
                                </option>
                            @endforeach
                        </select>
                        @if ($bag->has('ganjil_genap'))
                            <div class="invalid-feedback">{{ $bag->first('ganjil_genap') }}</div>
                        @endif
                    </div>

                    <div class="mb-1">
                        <label for="nominal{{ $ta->id }}" class="form-label fw-semibold">Nominal Cashback</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" min="0" step="1000"
                                   class="form-control {{ $bag->has('nominal_cashback') ? 'is-invalid' : '' }}"
                                   id="nominal{{ $ta->id }}" name="nominal_cashback"
                                   value="{{ old('nominal_cashback', (int) $ta->nominal_cashback) }}" required>
                            @if ($bag->has('nominal_cashback'))
                                <div class="invalid-feedback">{{ $bag->first('nominal_cashback') }}</div>
                            @endif
                        </div>
                        <div class="form-text">
                            Isi 0 untuk menutup cashback periode ini. Perubahan nominal
                            tidak mengubah pengajuan yang sudah berjalan.
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-gold">
                        <i class="fas fa-save me-2"></i>Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endforeach

@endsection

@section('scripts')
<script>
    // Buka kembali modal yang validasinya gagal.
    document.addEventListener('DOMContentLoaded', function () {
        const gagal = document.querySelector('.modal[data-autoshow]');

        if (gagal) {
            new bootstrap.Modal(gagal).show();
        }
    });
</script>
@endsection
