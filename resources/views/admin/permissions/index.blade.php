@extends('adminlte::page')

@section('title', 'Manajemen Permission')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="m-0">Daftar Permission</h1>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createPermissionModal">
            <i class="fas fa-plus"></i> Tambah Permission
        </button>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <x-adminlte-card theme="lightblue" theme-mode="outline" title="List Permission">

                <!-- Search and Filter Section -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-search"></i></span>
                            </div>
                            <input type="text" id="searchPermissionInput" class="form-control"
                                placeholder="Cari permission...">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <select class="form-control" id="guardFilter">
                            <option value="">Semua Guard</option>
                            @foreach ($permissions->pluck('guard_name')->unique() as $guard)
                                <option value="{{ $guard }}">{{ $guard }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Permission Table -->
                <div class="table-responsive">
                    <table class="table table-hover table-bordered table-striped" id="permissionsTable">
                        <thead class="bg-lightblue">
                            <tr>
                                <th width="5%">#</th>
                                <th>Nama Permission</th>
                                <th>Guard</th>
                                <th width="15%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($permissions as $permission)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $permission->name }}</td>
                                    <td>{{ $permission->guard_name }}</td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <!-- Tombol Edit -->
                                            <a href="{{ route('admin.permissions.edit', $permission->id) }}"
                                                class="btn btn-warning btn-action" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            <!-- Tombol Hapus -->
                                            <form method="POST"
                                                action="{{ route('admin.permissions.destroy', $permission->id) }}"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-action btn-delete"
                                                    title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>

                                        </div>
                                    </td>


                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">Tidak ada data permission.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if ($permissions instanceof \Illuminate\Pagination\LengthAwarePaginator && $permissions->hasPages())
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="dataTables_info">
                                Menampilkan {{ $permissions->firstItem() }} sampai {{ $permissions->lastItem() }} dari
                                {{ $permissions->total() }} entri
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="float-right">
                                {{ $permissions->links('pagination::bootstrap-5') }}
                            </div>
                        </div>
                    </div>
                @endif
            </x-adminlte-card>
        </div>
    </div>
    <!-- Create Permission Modal -->
    <div class="modal fade" id="createPermissionModal" tabindex="-1" aria-labelledby="createPermissionLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('admin.permissions.store') }}" method="POST" class="modal-content">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="createPermissionLabel">Tambah Permission Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Permission</label>
                        <input type="text" name="name" class="form-control" placeholder="Masukkan nama permission"
                            required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Guard</label>
                        <select name="guard_name" class="form-select" required>
                            <option value="web">web</option>

                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('css')
    <style>
        .table thead th {
            vertical-align: middle;
        }

        .table thead th {
            vertical-align: middle;
        }

        .btn-group-sm .btn {
            padding: 0.25rem 0.5rem;
            font-size: 0.765625rem;
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

<!-- Bootstrap 5 CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Font Awesome (untuk icon seperti fas fa-plus, fa-edit, dll) -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

<!-- Bootstrap 5 JS (wajib untuk modal, dropdown, dll) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            alert("Script jalan"); // TESTING

            document.querySelectorAll('.btn-delete').forEach((btn) => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    alert("Klik delete kepanggil"); // TESTING

                    const form = this.closest('form');
                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: "Permission ini akan dihapus permanen!",
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
                });
            });
        });
    </script>
@endpush


@push('scripts')

    <script>
        // Search & filter
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchPermissionInput');
            const guardFilter = document.getElementById('guardFilter');
            const rows = document.querySelectorAll('#permissionsTable tbody tr');

            function filterTable() {
                const searchValue = searchInput.value.toLowerCase();
                const guardValue = guardFilter.value;
                rows.forEach(row => {
                    const rowText = row.textContent.toLowerCase();
                    const guardMatch = guardValue === "" || row.cells[2].textContent.includes(guardValue);
                    const searchMatch = searchValue === "" || rowText.includes(searchValue);
                    row.style.display = (guardMatch && searchMatch) ? '' : 'none';
                });
            }

            searchInput.addEventListener('keyup', filterTable);
            guardFilter.addEventListener('change', filterTable);
        });
    </script>

    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                timer: 2000,
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
