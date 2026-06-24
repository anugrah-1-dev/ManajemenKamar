@extends('adminlte::page')

@section('title', 'Galeri')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1>Gallery</h1>
    <a href="{{ route('admin.galleries.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Tambah Galerry
    </a>
</div>
@stop

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card card-outline card-primary">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Daftar Galeri</h3>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="icon fas fa-check mr-2"></i> {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                    @endif

                    <div class="table-responsive table-container">
                        <table class="table table-bordered table-hover">
                            <thead class="thead-light">
                                <tr>
                                    <th width="5%">No</th>
                                    <th>Judul</th>
                                    <th>Gambar</th>
                                    <th>Tanggal Event</th>
                                    <th>Status</th>
                                    <th width="20%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($galleries as $index => $gallery)
                                    <tr>
                                        <td class="text-center">{{ $index + $galleries->firstItem() }}</td>
                                        <td>{{ $gallery->title }}</td>
                                        <td class="text-center">{{ $gallery->images_count }} foto</td>
                                        <td class="text-center">{{ $gallery->event_date ?? '-' }}</td>
                                        <td class="text-center">
                                            @if ($gallery->status)
                                                <span class="badge badge-success">Aktif</span>
                                            @else
                                                <span class="badge badge-secondary">Nonaktif</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group btn-group-sm" role="group">
                                                <a href="{{ route('admin.galleries.show', $gallery->id) }}"
                                                    class="btn btn-primary" title="Lihat">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.galleries.edit', $gallery->id) }}"
                                                    class="btn btn-info" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('admin.galleries.destroy', $gallery->id) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Yakin ingin menghapus galeri ini?')"
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
                                        <td colspan="6" class="text-center py-4">
                                            <i class="fas fa-images mr-2"></i> Belum ada data galeri.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card-footer clearfix">
                    <div class="float-right">
                        {{ $galleries->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('css')
<style>
    .table-hover tbody tr:hover {
        background-color: rgba(0, 0, 0, 0.03);
    }

    .table-container {
        max-height: 400px;
        overflow-y: auto;
        overflow-x: auto;
    }

    .table-container thead {
        position: sticky;
        top: 0;
        z-index: 1;
        background-color: #f8f9fa;
    }

    .btn-group .btn {
        width: 35px;
        padding: 0.375rem 0.5rem;
        text-align: center;
    }

    .btn-group form {
        margin: 0;
    }
</style>
@stop


@section('js')
<script>
    $(document).ready(function () {
        $('.btn-group .btn').hover(
            function () {
                $(this).addClass('shadow-sm');
            },
            function () {
                $(this).removeClass('shadow-sm');
            }
        );

        setTimeout(function () {
            $('.alert').alert('close');
        }, 5000);
    });
</script>
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