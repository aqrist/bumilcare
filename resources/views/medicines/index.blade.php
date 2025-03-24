@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2><i class="bi bi-capsule"></i> Daftar Obat</h2>
            <a href="{{ route('medicines.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Tambah Obat
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Kode</th>
                                <th>Nama</th>
                                <th>Kategori</th>
                                <th>Harga</th>
                                <th>Stok</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($medicines as $medicine)
                                <tr>
                                    <td>{{ $medicine->code }}</td>
                                    <td>{{ $medicine->name }}</td>
                                    <td>{{ $medicine->category }}</td>
                                    <td>Rp {{ number_format($medicine->price, 0, ',', '.') }}</td>
                                    <td>
                                        <span class="badge {{ $medicine->stock > 10 ? 'bg-success' : 'bg-danger' }}">
                                            {{ $medicine->stock }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('medicines.show', $medicine) }}" class="btn btn-sm btn-info">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('medicines.edit', $medicine) }}"
                                                class="btn btn-sm btn-warning">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('medicines.destroy', $medicine) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Yakin ingin menghapus obat ini?')">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">Tidak ada data obat.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                {{ $medicines->links() }}
            </div>
        </div>
    </div>
@endsection
