@extends('layouts.admin')

@section('title', 'Manajemen Kategori')

@push('styles')
<style>
    /* ===== CUSTOM THEME VORTEX WEAR ===== */
    :root {
        --vortex-orange: #fd7e14;
        --vortex-dark: #212529;
        --vortex-grey: #6c757d;
    }

    .bi {
        font-family: bootstrap-icons !important;
        font-style: normal;
    }

    /* Card Header Styling */
    .card-header.bg-vortex {
        background-color: var(--vortex-dark) !important;
        border-bottom: 3px solid var(--vortex-orange);
    }

    /* Button Styling */
    .btn-orange {
        background-color: var(--vortex-orange);
        color: white;
        border: none;
    }
    .btn-orange:hover {
        background-color: #e66e0d;
        color: white;
    }

    .btn-outline-orange {
        border-color: var(--vortex-orange);
        color: var(--vortex-orange);
    }
    .btn-outline-orange:hover {
        background-color: var(--vortex-orange);
        color: white;
    }

    /* Modal Styling */
    .modal-content {
        background-color: #fff !important;
        border-radius: 15px !important;
    }
    .modal-header.bg-vortex {
        background-color: var(--vortex-dark);
        color: white;
        border-bottom: 3px solid var(--vortex-orange);
    }

    /* Badge Custom */
    .bg-orange-subtle {
        background-color: rgba(253, 126, 20, 0.1);
        color: var(--vortex-orange);
    }

    /* ===== SMOOTH MODAL ANIMATION ===== */
    .modal.fade .modal-dialog {
        transform: scale(.95);
        transition: transform .2s ease-out;
    }
    .modal.show .modal-dialog {
        transform: scale(1);
    }
</style>
@endpush

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-12">

        {{-- FLASH MESSAGE --}}
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" style="border-left: 5px solid #198754 !important;">
            <i class="bi bi-check-circle me-1"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        <div class="card shadow-sm border-0 mb-4">

            {{-- CARD HEADER --}}
            <div class="card-header bg-vortex text-white d-flex justify-content-between align-items-center py-3">
                <div>
                    <h5 class="mb-0 fw-bold text-uppercase" style="letter-spacing: 1px;">
                        <i class="bi bi-tags me-2 text-warning"></i> Manajemen Kategori
                    </h5>
                </div>

                <button class="btn btn-orange btn-sm fw-bold px-3" data-bs-toggle="modal" data-bs-target="#createModal">
                    <i class="bi bi-plus-lg me-1"></i> Tambah Kategori
                </button>
            </div>

            {{-- TABLE --}}
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-dark">
                            <tr style="background-color: #343a40;">
                                <th class="ps-4 border-0">Kategori</th>
                                <th class="text-center border-0">Jumlah Produk</th>
                                <th class="text-center border-0">Status</th>
                                <th class="text-end pe-4 border-0">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($categories as $category)
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center">
                                        @if($category->image)
                                        <img src="{{ Storage::url($category->image) }}" class="rounded me-3 border shadow-sm"
                                            width="48" height="48" style="object-fit: cover;">
                                        @else
                                        <div class="bg-light rounded d-flex align-items-center justify-content-center me-3 border"
                                            style="width:48px;height:48px">
                                            <i class="bi bi-image text-muted"></i>
                                        </div>
                                        @endif
                                        <div>
                                            <div class="fw-bold text-dark">{{ $category->name }}</div>
                                            <small class="text-muted">Slug: {{ $category->slug }}</small>
                                        </div>
                                    </div>
                                </td>

                                <td class="text-center">
                                    <span class="badge bg-orange-subtle fw-bold px-3 py-2" style="font-size: 0.85rem;">
                                        <i class="bi bi-box-seam me-1"></i>
                                        {{ $category->products_count }}
                                    </span>
                                </td>

                                <td class="text-center">
                                    @if($category->is_active)
                                    <span class="badge bg-success px-3 py-2">
                                        <i class="bi bi-check-circle me-1"></i> Aktif
                                    </span>
                                    @else
                                    <span class="badge bg-secondary px-3 py-2">
                                        <i class="bi bi-x-circle me-1"></i> Nonaktif
                                    </span>
                                    @endif
                                </td>

                                <td class="text-end pe-4">
                                    <div class="btn-group">
                                        <button class="btn btn-sm btn-outline-dark" data-bs-toggle="modal"
                                            data-bs-target="#editModal{{ $category->id }}" title="Edit">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>

                                        <form action="{{ route('admin.categories.destroy', $category) }}" method="POST"
                                            onsubmit="return confirm('Hapus kategori ini akan berpengaruh pada produk terkait. Lanjutkan?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger ms-1" title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-5 text-muted">
                                    <i class="bi bi-folder-x fs-1 d-block mb-2 text-warning"></i>
                                    Belum ada kategori yang tersedia.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card-footer bg-white py-3">
                {{ $categories->links() }}
            </div>
        </div>
    </div>
</div>

{{-- ================= EDIT MODAL ================= --}}
@foreach($categories as $category)
<div class="modal fade" id="editModal{{ $category->id }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form class="modal-content border-0 shadow-lg"
            action="{{ route('admin.categories.update', $category) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="modal-header bg-vortex">
                <h5 class="modal-title fw-bold">
                    <i class="bi bi-pencil-square me-1"></i> Edit Kategori
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body p-4">
                <div class="mb-3">
                    <label class="form-label fw-bold">Nama Kategori</label>
                    <input type="text" name="name" class="form-control border-dark-subtle" value="{{ $category->name }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Update Gambar</label>
                    <input type="file" name="image" class="form-control">
                    <small class="text-muted">Biarkan kosong jika tidak ingin mengubah gambar.</small>
                </div>

                <div class="form-check form-switch mt-3">
                    <input class="form-check-input" type="checkbox" name="is_active" value="1" {{ $category->is_active ? 'checked' : '' }} id="activeSwitch{{$category->id}}">
                    <label class="form-check-label fw-semibold" for="activeSwitch{{$category->id}}">Status Aktif</label>
                </div>
            </div>

            <div class="modal-footer bg-light rounded-bottom-4">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-orange px-4 fw-bold">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endforeach

{{-- ================= CREATE MODAL ================= --}}
<div class="modal fade" id="createModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form class="modal-content border-0 shadow-lg" action="{{ route('admin.categories.store') }}"
            method="POST" enctype="multipart/form-data">
            @csrf

            <div class="modal-header bg-vortex">
                <h5 class="modal-title fw-bold">
                    <i class="bi bi-plus-circle me-1"></i> Buat Kategori Baru
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body p-4">
                <div class="mb-3">
                    <label class="form-label fw-bold">Nama Kategori</label>
                    <input type="text" name="name" class="form-control border-dark-subtle" placeholder="Misal: Oversized T-Shirt" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Upload Gambar</label>
                    <input type="file" name="image" class="form-control" required>
                </div>

                <div class="form-check form-switch mt-3">
                    <input class="form-check-input" type="checkbox" name="is_active" value="1" checked id="createActiveSwitch">
                    <label class="form-check-label fw-semibold" for="createActiveSwitch">Aktifkan Kategori</label>
                </div>
            </div>

            <div class="modal-footer bg-light rounded-bottom-4">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-orange px-4 fw-bold">Proses Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection