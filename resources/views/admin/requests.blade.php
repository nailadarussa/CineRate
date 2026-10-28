@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-md-3">
        <div class="card p-3 border-start border-4 border-primary">
            <small class="text-muted fw-bold">TOTAL REQUEST</small>
            <h3 class="fw-bold mb-0">{{ $requests->count() }}</h3>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card p-3 border-start border-4 border-warning">
            <small class="text-muted fw-bold">PENDING</small>
            <h3 class="fw-bold mb-0">{{ $requests->where('status', 'pending')->count() }}</h3>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span>Daftar Permintaan Film</span>
        <button class="btn btn-sm btn-light border"><i class="bi bi-filter"></i> Filter</button>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th class="ps-4">User</th>
                        <th>Judul Film</th>
                        <th>Tahun</th>
                        <th>Tanggal Request</th>
                        <th>Status</th>
                        <th class="text-end pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($requests as $req)
                    <tr>
                        <td class="ps-4">
                            <div class="d-flex align-items-center">
                                <div class="bg-light rounded-circle d-flex align-items-center justify-content-center me-2" style="width:30px; height:30px; font-size:12px; font-weight:bold;">
                                    {{ substr($req->user->name, 0, 1) }}
                                </div>
                                <div>
                                    <span class="d-block fw-bold text-dark" style="font-size: 0.9rem;">{{ $req->user->name }}</span>
                                    <small class="text-muted" style="font-size: 0.75rem;">{{ $req->user->email }}</small>
                                </div>
                            </div>
                        </td>
                        <td class="fw-bold text-primary">{{ $req->title }}</td>
                        <td>{{ $req->year ?? '-' }}</td>
                        <td>{{ $req->created_at->format('d M Y') }}</td>
                        <td>
                            @if($req->status == 'pending')
                                <span class="badge bg-warning text-dark"><i class="bi bi-clock"></i> Pending</span>
                            @elseif($req->status == 'approved')
                                <span class="badge bg-success"><i class="bi bi-check-circle"></i> Approved</span>
                            @else
                                <span class="badge bg-danger"><i class="bi bi-x-circle"></i> Rejected</span>
                            @endif
                        </td>
                        <td class="text-end pe-4">
                            @if($req->status == 'pending')
                                <form action="{{ route('admin.requests.approve', $req->id) }}" method="POST" class="d-inline">
                                    @csrf @method('PATCH')
                                    <button class="btn btn-sm btn-success" title="Terima">
                                        <i class="bi bi-check-lg"></i>
                                    </button>
                                </form>
                                <form action="{{ route('admin.requests.reject', $req->id) }}" method="POST" class="d-inline">
                                    @csrf @method('PATCH')
                                    <button class="btn btn-sm btn-danger" title="Tolak">
                                        <i class="bi bi-x-lg"></i>
                                    </button>
                                </form>
                            @else
                                <span class="text-muted small fst-italic">Selesai</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection