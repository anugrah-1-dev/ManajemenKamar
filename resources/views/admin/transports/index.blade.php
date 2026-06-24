@extends('adminlte::page')

@section('title', 'Manajemen Transportasi')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="m-0">Daftar Transportasi</h1>
        <x-adminlte-button label="Tambah Transportasi" theme="primary" icon="fas fa-plus" data-toggle="modal"
            data-target="#createTransportModal" />
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <x-adminlte-card theme="lightblue" theme-mode="outline" title="List Transportasi">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-search"></i></span>
                            </div>
                            <input type="text" id="searchInput" class="form-control"
                                placeholder="Cari berdasarkan nama transportasi...">
                        </div>
                    </div>
                </div>

                <div class="table-responsive scrollable-table-wrapper">
                    <table class="table table-hover table-bordered table-striped" id="transportTable">
                        <thead class="bg-lightblue text-center">
                            <tr>
                                <th width="5%">No</th>
                                <th>Nama Transportasi</th>
                                <th>Harga</th>
                                <th>Status</th>
                                <th width="15%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($transports as $index => $transport)
                                <tr class="text-center">
                                    <td>{{ $index + 1 }}</td>
                                    <td class="text-left">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-taxi mr-2 text-lightblue"></i>
                                            <strong>{{ $transport->name }}</strong>
                                        </div>
                                    </td>
                                    <td>Rp {{ number_format($transport->price, 0, ',', '.') }}</td>
                                    <td>
                                        @if ($transport->status === 'active')
                                            <span class="badge badge-success">Aktif</span>
                                        @else
                                            <span class="badge badge-secondary">Tidak Aktif</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center align-items-center">
                                            {{-- Tombol Edit --}}
                                            <button type="button" class="btn btn-warning btn-sm mr-1 btn-edit-transport"
                                                data-toggle="modal" data-target="#editTransportModal"
                                                data-id="{{ $transport->id }}" data-name="{{ $transport->name }}"
                                                data-price="{{ $transport->price }}" data-status="{{ $transport->status }}">
                                                <i class="fas fa-edit"></i>
                                            </button>

                                            {{-- Tombol Hapus --}}
                                            <form action="{{ route('admin.transports.destroy', $transport->id) }}"
                                                method="POST" onsubmit="confirmDelete(event)">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">Tidak ada data transportasi.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if ($transports instanceof \Illuminate\Pagination\LengthAwarePaginator && $transports->hasPages())
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="dataTables_info">
                                Menampilkan {{ $transports->firstItem() }} sampai {{ $transports->lastItem() }} dari
                                {{ $transports->total() }} entri
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="float-right">
                                {{ $transports->links('pagination::bootstrap-4') }}
                            </div>
                        </div>
                    </div>
                @endif
            </x-adminlte-card>
        </div>
    </div>

    {{-- Modal Create --}}
    <x-adminlte-modal id="createTransportModal" title="Tambah Transportasi Baru" theme="lightblue" size="lg"
        static-backdrop>
        <form action="{{ route('admin.transports.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <x-adminlte-input name="name" label="Nama Transportasi" placeholder="Contoh: Taksi Bandara"
                        required />
                </div>
                <div class="col-md-3">
                    <x-adminlte-input name="price" label="Harga" type="number" placeholder="Contoh: 50000" required />
                </div>
                <div class="col-md-3">
                    <x-adminlte-select name="status" label="Status">
                        <option value="active">Aktif</option>
                        <option value="inactive">Tidak Aktif</option>
                    </x-adminlte-select>
                </div>
            </div>
            <div class="d-flex justify-content-end mt-3 w-100">
                <button type="button" class="btn btn-secondary btn-sm mr-2" data-dismiss="modal">
                    <i class="fas fa-times"></i> Tutup
                </button>
                <button type="submit" class="btn btn-primary btn-sm">
                    <i class="fas fa-save"></i> Simpan
                </button>
            </div>
        </form>
        <x-slot name="footerSlot">
            <style>
                #createTransportModal .modal-footer {
                    display: none;
                }
            </style>
        </x-slot>
    </x-adminlte-modal>

    {{-- Modal Edit --}}
    <x-adminlte-modal id="editTransportModal" title="Edit Transportasi" theme="lightblue" size="lg" static-backdrop>
        <form id="editTransportForm" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" name="id" id="editId">
            <div class="row">
                <div class="col-md-6">
                    <x-adminlte-input name="name" label="Nama Transportasi" id="editName" required />
                </div>
                <div class="col-md-3">
                    <x-adminlte-input name="price" label="Harga" id="editPrice" type="number" required />
                </div>
                <div class="col-md-3">
                    <x-adminlte-select name="status" label="Status" id="editStatus">
                        <option value="active">Aktif</option>
                        <option value="inactive">Tidak Aktif</option>
                    </x-adminlte-select>
                </div>
            </div>
            <div class="d-flex justify-content-end mt-3 w-100">
                <button type="button" class="btn btn-secondary btn-sm mr-2" data-dismiss="modal">
                    <i class="fas fa-times"></i> Tutup
                </button>
                <button type="submit" class="btn btn-primary btn-sm">
                    <i class="fas fa-save"></i> Simpan Perubahan
                </button>
            </div>
        </form>
        <x-slot name="footerSlot">
            <style>
                #editTransportModal .modal-footer {
                    display: none;
                }
            </style>
        </x-slot>
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

        .scrollable-table-wrapper {
            max-height: 350px;
            overflow-y: auto;
        }

        #transportTable th:nth-child(1),
        #transportTable td:nth-child(1) {
            min-width: 40px;
        }

        #transportTable th:nth-child(2),
        #transportTable td:nth-child(2) {
            min-width: 200px;
        }

        #transportTable th:nth-child(3),
        #transportTable td:nth-child(3) {
            min-width: 150px;
        }

        #transportTable th:nth-child(4),
        #transportTable td:nth-child(4) {
            min-width: 120px;
        }

        #transportTable th:nth-child(5),
        #transportTable td:nth-child(5) {
            min-width: 130px;
        }
    </style>
@stop



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
                $('#transportTable tbody tr').each(function() {
                    const rowText = $(this).text().toLowerCase();
                    $(this).toggle(rowText.includes(searchValue));
                });
            });

            // Isi modal edit
            $('.btn-edit-transport').on('click', function() {
                const id = $(this).data('id');
                const name = $(this).data('name');
                const price = $(this).data('price');
                const status = $(this).data('status');

                $('#editId').val(id);
                $('#editName').val(name);
                $('#editPrice').val(price);
                $('#editStatus').val(status);

                const actionUrl = `/admin/transports/${id}`;
                $('#editTransportForm').attr('action', actionUrl);
            });
        });
    </script>

    @if (session('alert'))
        <script>
            Swal.fire(@json(session('alert')));
        </script>
    @endif
@stop
