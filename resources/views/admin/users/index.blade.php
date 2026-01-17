@extends('layouts.admin')

@section('title', 'Manajemen Pengguna')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 fw-bold text-dark mb-0">Daftar Pengguna</h1>
        <span class="badge bg-primary px-3 py-2 rounded-pill">{{ $users->total() }} Total Pengguna</span>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger border-0 shadow-sm">{{ session('error') }}</div>
    @endif

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 py-3">User</th>
                            <th class="py-3">Kontak</th>
                            <th class="py-3">Role</th>
                            <th class="py-3 text-center">Bergabung</th>
                            <th class="py-3 text-end pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center">
                                        {{-- Gunakan Accessor AvatarUrl yang kamu buat --}}
                                        <img src="{{ $user->avatar_url }}" 
                                             class="rounded-circle me-3 border" 
                                             width="45" height="45" style="object-fit: cover;">
                                        <div>
                                            <div class="fw-bold text-dark">{{ $user->name }}</div>
                                            <small class="text-muted">ID: #{{ $user->id }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="small"><i class="bi bi-envelope me-1"></i> {{ $user->email }}</div>
                                    <div class="small text-muted"><i class="bi bi-telephone me-1"></i> {{ $user->phone ?? '-' }}</div>
                                </td>
                                <td>
                                    @if($user->isAdmin())
                                        <span class="badge bg-danger-subtle text-danger px-3">Admin</span>
                                    @else
                                        <span class="badge bg-info-subtle text-info px-3">Customer</span>
                                    @endif
                                </td>
                                <td class="text-center small text-muted">
                                    {{ $user->created_at->format('d M Y') }}
                                </td>
                                <td class="text-end pe-4">
                                    {{-- Tombol Hapus --}}
                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill" 
                                                onclick="return confirm('Hapus pengguna ini?')"
                                                {{ auth()->id() === $user->id ? 'disabled' : '' }}>
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">Belum ada pengguna terdaftar.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($users->hasPages())
            <div class="card-footer bg-white py-3">
                {{ $users->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>
</div>
@endsection