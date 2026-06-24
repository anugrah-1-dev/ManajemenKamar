@extends('adminlte::page')

@section('title', 'Manajemen Role')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="m-0">Daftar Role</h1>
        <!-- Tombol Tambah Role -->
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createRoleModal">
            <i class="fas fa-plus"></i> Tambah Role
        </button>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <x-adminlte-card theme="lightblue" theme-mode="outline" title="List Role">

                <!-- Search and Filter Section -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-search"></i></span>
                            </div>
                            <input type="text" id="searchInput" class="form-control"
                                placeholder="Cari berdasarkan nama role...">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <select class="form-control" id="guardFilter">
                            <option value="">Semua Guard</option>
                            <option value="web">Web</option>
                        </select>
                    </div>
                </div>

                <!-- Role Table -->
                <div class="table-responsive">
                    <table class="table table-hover table-bordered table-striped" id="rolesTable">
                        <thead class="bg-lightblue">
                            <tr>
                                <th width="5%">ID</th>
                                <th>Nama Role</th>
                                <th width="10%">Guard</th>
                                {{-- <th width="15%">Jumlah Permission</th> --}}
                                <th width="15%">Dibuat</th>
                                <th width="15%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($roles as $role)
                                <tr>
                                    <td>{{ $role->id }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-user-tag mr-2 text-lightblue"></i>
                                            <strong>{{ $role->name }}</strong>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge badge-{{ $role->guard_name == 'web' ? 'success' : 'info' }}">
                                            {{ $role->guard_name }}
                                        </span>
                                    </td>

                                    <td>
                                        <i class="far fa-calendar-alt mr-1"></i>
                                        {{ $role->created_at->format('d M Y') }}
                                        <br>
                                        <small class="text-muted">
                                            {{ $role->created_at->diffForHumans() }}
                                        </small>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group btn-group-sm" role="group">
                                            {{-- Tombol Edit --}}
                                            <a href="{{ route('admin.roles.edit', $role->id) }}"
                                                class="btn btn-warning btn-sm d-inline-flex align-items-center justify-content-center"
                                                style="width:36px; height:30px;" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            {{-- Tombol Hapus --}}
                                            <form action="{{ route('admin.roles.destroy', $role->id) }}" method="POST"
                                                class="d-inline" onsubmit="return confirmDelete(event)">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="btn btn-danger btn-sm d-inline-flex align-items-center justify-content-center"
                                                    style="width:36px; height:30px;" title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>



                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">Tidak ada data role</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if ($roles->hasPages())
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="dataTables_info">
                                Menampilkan {{ $roles->firstItem() }} sampai {{ $roles->lastItem() }} dari
                                {{ $roles->total() }} entri
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="float-right">
                                {{ $roles->links('pagination::bootstrap-4') }}
                            </div>
                        </div>
                    </div>
                @endif
            </x-adminlte-card>
        </div>
    </div>


    <!-- Create Role Modal -->
    <div class="modal fade" id="createRoleModal" tabindex="-1" aria-labelledby="createRoleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header bg-lightblue">
                    <h5 class="modal-title" id="createRoleModalLabel">Tambah Role Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form action="{{ route('admin.roles.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="roleName" class="form-label">Nama Role</label>
                                <input type="text" class="form-control" id="roleName" name="name"
                                    placeholder="Masukkan nama role" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="guardName" class="form-label">Guard Name</label>
                                <select class="form-select" id="guardName" name="guard_name">
                                    <option value="web" selected>Web</option>
                                    <option value="api">API</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Permissions</label>
                            <div class="row">
                                @foreach ($permissions as $permission)
                                    <div class="col-md-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox"
                                                id="permission{{ $permission->id }}" name="permissions[]"
                                                value="{{ $permission->id }}">
                                            <label class="form-check-label" for="permission{{ $permission->id }}">
                                                {{ $permission->name }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

<!-- Bootstrap 5 CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">


<!-- Bootstrap 5 JS Bundle (dengan Popper) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


@section('css')
    <style>
        .progress-group {
            display: flex;
            flex-direction: column;
        }

        .progress-number {
            font-size: 0.8rem;
            margin-top: 2px;
        }

        .table thead th {
            vertical-align: middle;
        }

        .badge {
            font-size: 90%;
            padding: 5px 8px;
        }

        .btn-group-sm .btn {
            padding: 0.25rem 0.5rem;
            font-size: 0.765625rem;
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
        // Confirm delete
        function confirmDelete(event) {
            event.preventDefault();
            const form = event.target.closest('form');

            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Role ini akan dihapus permanen!",
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

        // Search and filter functionality
        $(document).ready(function() {
            $('#searchInput, #guardFilter, #permissionFilter').on('keyup change', function() {
                const searchValue = $('#searchInput').val().toLowerCase();
                const guardValue = $('#guardFilter').val();
                const permissionValue = $('#permissionFilter').val();

                $('#rolesTable tbody tr').each(function() {
                    const rowText = $(this).text().toLowerCase();
                    const rowGuard = $(this).find('td:eq(2)').text().trim();
                    const permissionCount = parseInt($(this).find('td:eq(3) b').text());

                    const searchMatch = searchValue === '' || rowText.includes(searchValue);
                    const guardMatch = guardValue === '' || rowGuard === guardValue;
                    let permissionMatch = true;

                    if (permissionValue === '0') {
                        permissionMatch = permissionCount === 0;
                    } else if (permissionValue === '1-5') {
                        permissionMatch = permissionCount >= 1 && permissionCount <= 5;
                    } else if (permissionValue === '5+') {
                        permissionMatch = permissionCount > 5;
                    }

                    $(this).toggle(searchMatch && guardMatch && permissionMatch);
                });
            });
        });
    </script>
@stop
