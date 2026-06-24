@extends('adminlte::page')

@section('title', 'Pamflet Program')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Pamflet Program</h1>
        <a href="{{ route('admin.pamflet_programs.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Program
        </a>
    </div>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
        </div>
        <div class="card-body">
            <div class="mb-4">
                <form action="{{ route('admin.pamflet_programs.index') }}" method="GET">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control"
                            placeholder="Cari berdasarkan judul program..." value="{{ request('search') }}">
                        <button class="btn btn-primary" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>
            </div>

            <div class="table-responsive scrollable-table-wrapper" style="max-height: 350px; overflow: auto;">
                <table class="table table-bordered table-hover">
                    <thead class="table-custom-header">
                        <tr>
                            <th style="width: 10px;">No</th>
                            <th>Judul</th>
                            <th>Deskripsi</th>
                            <th>Keunggulan</th>
                            <th style="width: 150px;">Gambar</th>
                            <th>Status</th>
                            <th style="width: 150px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($programs as $program)
                            <tr>
                                <td>{{ ($programs->currentPage() - 1) * $programs->perPage() + $loop->iteration }}</td>


                                <td>{{ $program->judul }}</td>
                                <td>{{ Str::limit($program->deskripsi, 50, '...') }}</td>
                                <td>{{ Str::limit($program->keunggulan, 50, '...') }}</td>
                                <td>
                                    <img src="{{ asset('uploads/programs/' . $program->gambar) }}"
                                        alt="{{ $program->judul }}" class="img-thumbnail" width="100">
                                </td>
                                <td>
                                    @if ($program->status === 'aktif')
                                        <span class="badge bg-success">Aktif</span>
                                    @else
                                        <span class="badge bg-secondary">Nonaktif</span>
                                    @endif
                                </td>
                                <td class="text-center">
    <div class="btn-group btn-group-sm" role="group">
        <a href="{{ route('admin.pamflet_programs.edit', $program->id) }}"
            class="btn btn-warning" title="Edit">
            <i class="fas fa-edit"></i>
        </a>
        <form action="{{ route('admin.pamflet_programs.destroy', $program->id) }}"
            method="POST"
            onsubmit="return confirm('Anda yakin ingin menghapus program ini?')"
            style="display: inline-block;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger" title="Hapus">
                <i class="fas fa-trash-alt"></i>
            </button>
        </form>
    </div>
</td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Tidak ada data program.</td>
                            </tr>
                        @endforelse
                    </tbody>
                    @if ($programs instanceof \Illuminate\Pagination\LengthAwarePaginator && $programs->hasPages())
                    @endif

                </table>

            </div>

        </div>

    </div>
    <div class="d-flex justify-content-center mt-3">
        <ul class="pagination">
            {{-- Tombol Sebelumnya --}}
            <li class="page-item {{ $programs->onFirstPage() ? 'disabled' : '' }}">
                <a class="page-link" href="{{ $programs->onFirstPage() ? '#' : $programs->previousPageUrl() }}">«</a>
            </li>

            {{-- Nomor Halaman --}}
            @foreach ($programs->getUrlRange(1, $programs->lastPage()) as $page => $url)
                <li class="page-item {{ $programs->currentPage() == $page ? 'active' : '' }}">
                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                </li>
            @endforeach

            {{-- Tombol Berikutnya --}}
            <li class="page-item {{ !$programs->hasMorePages() ? 'disabled' : '' }}">
                <a class="page-link" href="{{ $programs->hasMorePages() ? $programs->nextPageUrl() : '#' }}">»</a>
            </li>
        </ul>
    </div>
@stop

@push('css')
    <style>
        .table-custom-header {
            background-color: #3c8dbc;
            color: white;
        }

        .scrollable-table-wrapper {
            max-height: 400px;
            overflow-y: auto;
        }

        /* Atur lebar minimum kolom */
        table th:nth-child(1),
        table td:nth-child(1) {
            min-width: 40px;
            /* No */
        }

        table th:nth-child(2),
        table td:nth-child(2) {
            min-width: 180px;
            /* Judul */
        }

        table th:nth-child(3),
        table td:nth-child(3),
        table th:nth-child(4),
        table td:nth-child(4) {
            min-width: 200px;
            /* Deskripsi, Keunggulan */
        }

        table th:nth-child(5),
        table td:nth-child(5) {
            min-width: 130px;
            /* Gambar */
        }

        table th:nth-child(6),
        table td:nth-child(6) {
            min-width: 100px;
            /* Status */
        }

        table th:nth-child(7),
        table td:nth-child(7) {
            min-width: 130px;
            /* Aksi */
        }

        .pagination {
            list-style: none;
            padding-left: 0;
            display: flex;
            gap: 4px;
        }

        .pagination .page-item {
            display: inline-block;
        }

        .pagination .page-link {
            display: block;
            padding: 6px 12px;
            border: 1px solid #dee2e6;
            border-radius: 4px;
            color: #007bff;
            text-decoration: none;
            background-color: #fff;
        }

        .pagination .page-item.active .page-link {
            background-color: #007bff;
            color: #fff;
            border-color: #007bff;
        }

        .pagination .page-item.disabled .page-link {
            color: #6c757d;
            pointer-events: none;
            background-color: #f8f9fa;
        }

        .btn-group .btn,
.btn-group form button {
    width: 35px;
    height: 35px;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 0;
}

    </style>
@endpush

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
