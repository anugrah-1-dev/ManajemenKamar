@extends('adminlte::page')

@section('title', 'Manajemen Bank')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1>Banks</h1>
    <a href="{{ route('admin.banks.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Tambah Rekening
    </a>
</div>

@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <x-adminlte-card theme="lightblue" theme-mode="outline" title="List Bank">

                <!-- Search Section -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-search"></i></span>
                            </div>
                            <input type="text" id="searchInput" class="form-control" placeholder="Cari berdasarkan nama bank/nomor rekening...">
                        </div>
                    </div>
                </div>

                <!-- Bank Table -->
                <div class="table-responsive">
                    <table class="table table-hover table-bordered table-striped" id="banksTable">
                        <thead class="bg-lightblue">
                            <tr>
                                <th width="5%">No</th>
                                <th>Nama Bank</th>
                                <th>Nomor Rekening</th>
                                <th>Atas Nama</th>
                                <th>Status</th>
                                <th width="15%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($banks as $index => $bank)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-university mr-2 text-lightblue"></i>
                                        <strong>{{ $bank->name }}</strong>
                                    </div>
                                </td>
                                <td>{{ $bank->number }}</td>
                                <td>{{ $bank->owner }}</td>
                                <td>
                                    @if($bank->status === 'active')
                                        <span class="badge badge-success">Aktif</span>
                                    @else
                                        <span class="badge badge-secondary">Tidak Aktif</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <x-adminlte-button theme="warning" icon="fas fa-edit"
                                            onclick="window.location='{{ route('admin.banks.edit', $bank->id) }}'" title="Edit"/>
                                        <form action="{{ route('admin.banks.destroy', $bank->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <x-adminlte-button theme="danger" icon="fas fa-trash"
                                                onclick="confirmDelete(event)" title="Hapus"/>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center">Tidak ada data bank.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($banks instanceof \Illuminate\Pagination\LengthAwarePaginator && $banks->hasPages())
                <div class="row mt-3">
                    <div class="col-md-6">
                        <div class="dataTables_info">
                            Menampilkan {{ $banks->firstItem() }} sampai {{ $banks->lastItem() }} dari {{ $banks->total() }} entri
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="float-right">
                            {{ $banks->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
                @endif
            </x-adminlte-card>
        </div>
    </div>

    <!-- Create Bank Modal -->
    <x-adminlte-modal id="createBankModal" title="Tambah Bank Baru" theme="lightblue" size="lg">
        {{-- <form action="{{ route('admin.banks.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-4">
                    <x-adminlte-input name="name" label="Nama Bank" placeholder="Masukkan nama bank" required/>
                </div>
                <div class="col-md-4">
                    <x-adminlte-input name="account_number" label="Nomor Rekening" placeholder="Masukkan nomor rekening" required/>
                </div>
                <div class="col-md-4">
                    <x-adminlte-input name="account_name" label="Atas Nama" placeholder="Masukkan nama pemilik rekening" required/>
                </div>
            </div>
            <x-slot name="footerSlot">
                <x-adminlte-button theme="secondary" label="Batal" data-dismiss="modal"/>
                <x-adminlte-button type="submit" theme="primary" label="Simpan" icon="fas fa-save"/>
            </x-slot>
        </form> --}}
    </x-adminlte-modal>
@stop

@section('css')
    <style>
        .table thead th {
            vertical-align: middle;
        }
        .btn-group-sm .btn {
            padding: 0.25rem 0.5rem;
            font-size: 0.765625rem;
        }
    </style>
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Confirm delete
        function confirmDelete(event) {
            event.preventDefault();
            const form = event.target.closest('form');
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Bank ini akan dihapus permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        }

        // Search functionality
        $(document).ready(function() {
            $('#searchInput').on('keyup', function() {
                const searchValue = $(this).val().toLowerCase();
                $('#banksTable tbody tr').each(function() {
                    const rowText = $(this).text().toLowerCase();
                    $(this).toggle(rowText.includes(searchValue));
                });
            });
        });
    </script>
    @if(session('sweetalert'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session("success") }}',
            showConfirmButton: false,
            timer: 2000
        });
    </script>
    @endif
@stop
