@extends('layouts.admin')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold text-dark mb-1">Manajemen User</h4>
        <p class="text-muted small mb-0">Pantau dan kelola pengguna terdaftar.</p>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success border-0 rounded-3 mb-4"><i class="bi bi-check-circle me-2"></i>{{ session('success') }}</div>
@endif

<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
    <div class="card-body p-0">
        <table class="table table-hover align-middle mb-0">
            <thead class="bg-light text-secondary">
                <tr>
                    <th class="ps-4 py-3 small fw-bold text-uppercase">User Info</th>
                    <th class="py-3 small fw-bold text-uppercase">Role</th>
                    <th class="py-3 small fw-bold text-uppercase">Bergabung</th>
                    <th class="pe-4 py-3 text-end small fw-bold text-uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr id="user-row-{{ $user->id }}">
                    <td class="ps-4">
                        <div class="d-flex align-items-center">
                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px; font-weight: bold;">
                                {{ substr($user->name, 0, 1) }}
                            </div>
                            <div>
                                <span class="d-block fw-bold text-dark">{{ $user->name }}</span>
                                <small class="text-muted">{{ $user->email }}</small>
                            </div>
                        </div>
                    </td>
                    <td><span class="badge bg-secondary bg-opacity-10 text-secondary border">Member</span></td>
                    <td class="text-muted small">{{ $user->created_at->format('d M Y') }}</td>
                    <td class="pe-4 text-end">
                        <button class="btn btn-sm btn-danger shadow-sm px-3" 
                                title="Hapus User"
                                onclick="confirmDeleteUser({{ $user->id }}, '{{ $user->name }}')">
                            <i class="bi bi-person-x-fill me-1"></i> Ban
                        </button>
                        
                        <form id="delete-form-{{ $user->id }}" action="{{ route('admin.users.delete', $user->id) }}" method="POST" class="d-none">
                            @csrf @method('DELETE')
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center py-5 text-muted">Belum ada user member.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer bg-white border-0 py-3">
        {{ $users->links() }}
    </div>
</div>

<script>
    function confirmDeleteUser(userId, userName) {
        Swal.fire({
            title: 'Hapus User?',
            text: `Akun "${userName}" dan semua datanya akan dihapus permanen!`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33', // Merah Bahaya
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Ban User!',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                // Submit Form Hidden
                document.getElementById('delete-form-' + userId).submit();
            }
        })
    }
</script>
@endsection