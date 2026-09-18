@extends('adminlte::page')

@section('title', 'Manajemen Customer Service')
@section('plugins.Datatables', true)
@section('plugins.Sweetalert2', true)

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1><i class="fas fa-headset"></i> Customer Service</h1>
        <a href="{{ route('admin.customer_services.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Contact
        </a>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <x-adminlte-card title="Daftar Customer Service" theme="lightblue" icon="fas fa-users" collapsible>
                <table id="table_customer_service" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th style="width: 5%;">No</th>
                            <th>Nama</th>
                            <th>Nomor Telepon</th>
                            <th style="width: 120px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($customerServices as $cs)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $cs->nama }}</td>
                                <td>{{ $cs->nomor }}</td>
                                <td>
                                    <a href="{{ route('admin.customer_services.edit', $cs->id) }}"
                                        class="btn btn-sm btn-warning text-white" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <form id="delete-form-{{ $cs->id }}"
                                        action="{{ route('admin.customer_services.destroy', $cs->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')

                                        <button type="button" class="btn btn-sm btn-danger" title="Hapus"
                                            onclick="confirmDelete({{ $cs->id }})">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted">Tidak ada data customer service.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </x-adminlte-card>
        </div>
    </div>
@stop

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmDelete(id) {
            Swal.fire({
                title: 'Yakin ingin menghapus?',
                text: "Data yang dihapus tidak dapat dikembalikan.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        }
    </script>

    {{-- Inisialisasi DataTables --}}
    <script>
        $(function() {
            $('#table_customer_service').DataTable({
                responsive: true,
                autoWidth: false,
                language: {
                    search: "Cari:",
                    lengthMenu: "Tampilkan _MENU_ entri",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                    infoEmpty: "Tidak ada data yang tersedia",
                    emptyTable: "Tidak ada data yang tersedia",
                    zeroRecords: "Tidak ditemukan data yang cocok",
                    paginate: {
                        first: "Pertama",
                        last: "Terakhir",
                        next: "Berikutnya",
                        previous: "Sebelumnya"
                    }
                }
            });
        });
    </script>
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
