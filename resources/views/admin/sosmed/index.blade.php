@extends('adminlte::page')

@section('title', 'Manajemen Sosial Media')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="m-0">Daftar Sosial Media</h1>
        <a href="{{ route('admin.sosmed.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Sosmed
        </a>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <x-adminlte-card theme="lightblue" theme-mode="outline" title="List Sosial Media">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-search"></i></span>
                            </div>
                            <input type="text" id="searchInput" class="form-control"
                                placeholder="Cari berdasarkan nama sosial media...">
                        </div>
                    </div>
                </div>

                <div class="table-responsive scrollable-table-wrapper">
                    <table class="table table-hover table-bordered table-striped" id="sosmedTable">
                        <thead class="bg-lightblue text-center">
                            <tr>
                                <th width="5%">No</th>
                                <th>Nama</th>
                                <th>URL</th>
                                <th>Gambar/Ikon</th>
                                <th width="15%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($sosmeds as $index => $sosmed)
                                <tr class="text-center">
                                    <td>{{ $index + 1 }}</td>
                                    <td class="text-left">
                                        <strong>{{ $sosmed->nama }}</strong>
                                    </td>
                                    <td class="text-left">
                                        <a href="{{ $sosmed->url }}" target="_blank">{{ $sosmed->url }}</a>
                                    </td>
                                    <td>
                                        @if ($sosmed->image_path)
                                            <img src="{{ asset('storage/' . $sosmed->image_path) }}" alt="Icon"
                                                height="32">
                                        @else
                                            <i class="fas fa-share-alt text-lightblue fa-lg"></i>
                                        @endif
                                    </td>
                                   <td>
    <div class="d-flex justify-content-center gap-1">
        <a href="{{ route('admin.sosmed.edit', $sosmed->id) }}"
            class="btn btn-warning btn-action mr-1" title="Edit">
            <i class="fas fa-edit"></i>
        </a>
        <form action="{{ route('admin.sosmed.destroy', $sosmed->id) }}" method="POST"
            onsubmit="confirmDelete(event)">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger btn-action" title="Hapus">
                <i class="fas fa-trash-alt"></i>
            </button>
        </form>
    </div>
</td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">Tidak ada data sosial media.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($sosmeds instanceof \Illuminate\Pagination\LengthAwarePaginator && $sosmeds->hasPages())
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="dataTables_info">
                                Menampilkan {{ $sosmeds->firstItem() }} sampai {{ $sosmeds->lastItem() }} dari
                                {{ $sosmeds->total() }} entri
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="float-right">
                                {{ $sosmeds->links('pagination::bootstrap-4') }}
                            </div>
                        </div>
                    </div>
                @endif
            </x-adminlte-card>
        </div>
    </div>
@stop

@section('css')
    <style>
        .scrollable-table-wrapper {
            max-height: 350px;
            overflow-y: auto;
        }

         .btn-action {
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0;
    }
    </style>
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmDelete(event) {
            event.preventDefault();
            const form = event.target.closest('form');
            Swal.fire({
                title: 'Yakin ingin menghapus?',
                text: "Data ini akan dihapus secara permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        }

        $(document).ready(function() {
            $('#searchInput').on('keyup', function() {
                const searchValue = $(this).val().toLowerCase();
                $('#sosmedTable tbody tr').each(function() {
                    const rowText = $(this).text().toLowerCase();
                    $(this).toggle(rowText.includes(searchValue));
                });
            });
        });
    </script>

    @if (session('alert'))
        <script>
            Swal.fire(@json(session('alert')));
        </script>
    @endif
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
