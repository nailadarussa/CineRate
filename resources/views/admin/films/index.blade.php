@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold text-dark mb-1">Database Film</h4>
        <p class="text-muted small mb-0">Kelola data film dan konten website.</p>
    </div>
    
    <div class="d-flex gap-2">
        <a href="{{ route('admin.films.export_excel') }}" class="btn btn-success btn fw-bold px-3 py-2 shadow-sm">
            <i class="bi bi-file-earmark-excel me-2"></i> Export Excel
        </a>

        <a href="{{ route('admin.films.export') }}" class="btn btn-danger btn fw-bold px-3 py-2 shadow-sm">
            <i class="bi bi-file-earmark-pdf me-2"></i> Export PDF
        </a>

        <a href="{{ route('admin.films.create') }}" class="btn btn-primary btn fw-bold px-3 py-2 shadow-sm">
            <i class="bi bi-plus-lg me-2"></i> Tambah Film
        </a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success border-0 bg-success bg-opacity-10 text-success d-flex align-items-center mb-4">
        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
    </div>
@endif

<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light text-secondary">
                    <tr>
                        <th class="ps-4 py-3 text-uppercase small fw-bold">No</th>
                        <th class="py-3 text-uppercase small fw-bold">Poster</th>
                        <th class="py-3 text-uppercase small fw-bold">Judul Film</th>
                        <th class="py-3 text-uppercase small fw-bold">Tahun & Genre</th>
                        <th class="pe-4 py-3 text-end text-uppercase small fw-bold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="border-top-0">
                    @forelse($films as $index => $film)
                    <tr>
                        <td class="ps-4 text-muted small fw-bold">{{ $index + 1 }}</td>
                        <td>
                            <img src="{{ Str::startsWith($film->poster, 'http') ? $film->poster : asset('storage/' . $film->poster) }}" 
                                 alt="Poster"
                                 class="rounded shadow-sm"
                                 style="width: 50px; height: 75px; object-fit: cover;">
                        </td>
                        <td>
                            <span class="d-block fw-bold text-dark text-truncate" style="max-width: 250px;">{{ $film->title }}</span>
                            <small class="text-muted">Dir: {{ $film->director }}</small>
                            @if($film->is_popular)
                                <span class="badge bg-warning text-dark ms-2" style="font-size: 0.6rem;">POPULER</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex flex-column">
                                <span class="fw-bold text-dark">{{ $film->release_year }}</span>
                                <span class="badge bg-light text-secondary border mt-1 fw-normal">{{ Str::limit($film->genre, 15) }}</span>
                            </div>
                        </td>
                        <td class="pe-4 text-end">
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('admin.films.edit', $film->id) }}" 
                                   class="btn btn-sm btn-warning text-white shadow-sm" 
                                   data-bs-toggle="tooltip" title="Edit">
                                    <i class="bi bi-pencil-square"></i>
                                </a>

                                <form action="{{ route('admin.films.delete', $film->id) }}" method="POST" onsubmit="return confirm('Yakin hapus {{ $film->title }}?');">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger shadow-sm" data-bs-toggle="tooltip" title="Hapus">
                                        <i class="bi bi-trash-fill"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">
                            <i class="bi bi-film fs-1 d-block mb-2 text-secondary"></i>
                            Belum ada film di database.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    .btn-sm {
        width: 32px;
        height: 32px;
        padding: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 6px;
    }
    /* Kecuali tombol tambah film di atas */
    .d-flex .btn-primary.btn-sm {
        width: auto;
        height: auto;
        padding: 8px 16px;
    }
</style>
@endsection