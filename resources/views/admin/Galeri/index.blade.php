@extends('adminlte::page')

@section('title', 'Galeri')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Daftar Galeri</h1>
        <a href="{{ route('admin.galeri.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Galeri
        </a>
    </div>
@stop

@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        {{-- <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title">List Galeri</h3>
            <a href="{{ route('admin.galeri.create') }}" class="btn btn-primary">+ Tambah Galeri</a>
        </div> --}}
        <div class="card-body">
            <form method="GET">
                <div class="input-group mb-3">
                    <input type="text" name="q" class="form-control" placeholder="Cari berdasarkan judul...">
                    <div class="input-group-append">
                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                    </div>
                </div>
            </form>

            <table class="table table-bordered table-hover">
                <thead class="bg-primary text-white">
                    <tr>
                        <th>No</th>
                        <th>Judul</th>
                        <th>Gambar</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($galeris as $i => $galeri)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $galeri->title }}</td>
                            <td>
                                @if ($galeri->image_path)
                                    <img src="{{ asset('storage/' . $galeri->image_path) }}" width="80">
                                @else
                                    <span class="text-muted">Tidak ada gambar</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge badge-{{ $galeri->status ? 'success' : 'secondary' }}">
                                    {{ $galeri->status ? 'Aktif' : 'Tidak Aktif' }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('admin.galeri.edit', $galeri->id) }}"
                                    class="btn btn-sm btn-warning">Edit</a>

                                <form action="{{ route('admin.galeri.destroy', $galeri->id) }}" method="POST"
                                    class="d-inline" onsubmit="return confirm('Yakin ingin menghapus galeri ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">Tidak ada data galeri.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@stop

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if (session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            timer: 3000,
            showConfirmButton: false
        });
    </script>
@endif

@if (session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: '{{ session('error') }}',
            timer: 3000,
            showConfirmButton: false
        });
    </script>
@endif
