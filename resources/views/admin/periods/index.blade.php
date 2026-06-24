@extends('adminlte::page')

@section('title', 'Manajemen Periode')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1 class="m-0">Manajemen Periode</h1>
    <x-adminlte-button label="Tambah Periode" theme="primary" icon="fas fa-plus" data-toggle="modal"
        data-target="#createPeriodModal" />
</div>
@stop

@section('content')
<x-adminlte-card theme="lightblue" theme-mode="outline" title="Daftar Periode">
    <div class="row mb-3">
        <div class="col-md-4">
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                </div>
                <input type="text" id="searchInput" class="form-control" placeholder="Cari tanggal...">
            </div>
        </div>
    </div>

    <div class="table-responsive scrollable-table-wrapper">
        <table class="table table-hover table-bordered table-striped" id="periodTable">
            <thead class="bg-lightblue text-center">
                <tr>
                    <th width="5%">#</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                    <th>Dibuat</th>
                    <th width="15%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($periods as $index => $period)
                    <tr class="text-center align-middle">
                        <td>{{ $index + $periods->firstItem() }}</td>
                        <td>{{ \Carbon\Carbon::parse($period->date)->format('d-m-Y') }}</td>
                        <td>
                            <span class="badge {{ $period->is_active ? 'badge-success' : 'badge-secondary' }}">
                                {{ $period->is_active ? 'Aktif' : 'Tidak Aktif' }}
                            </span>
                        </td>
                        <td>{{ $period->created_at->diffForHumans() }}</td>
                        <td>
                            <div class="btn-group btn-group-sm" role="group">
                                <button type="button" class="btn btn-warning btn-sm btn-action btn-edit-period"
                                    data-toggle="modal" data-target="#editPeriodModal" data-id="{{ $period->id }}"
                                    data-date="{{ $period->date->format('Y-m-d') }}"
                                    data-is_active="{{ $period->is_active }}">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form action="{{ route('admin.periods.destroy', $period->id) }}" method="POST"
                                    onsubmit="return confirm('Yakin ingin menghapus periode ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm btn-action" title="Hapus">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>


                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted">Tidak ada data periode.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($periods->hasPages())
        <div class="d-flex justify-content-between mt-3">
            <small class="text-muted">Menampilkan {{ $periods->firstItem() }} - {{ $periods->lastItem() }} dari
                {{ $periods->total() }} data</small>
            <div>{{ $periods->links('pagination::bootstrap-4') }}</div>
        </div>
    @endif
</x-adminlte-card>

{{-- Modal Create --}}
<x-adminlte-modal id="createPeriodModal" title="Tambah Periode Baru" theme="lightblue" size="md" static-backdrop>
    <form action="{{ route('admin.periods.store') }}" method="POST">
        @csrf
        <x-adminlte-input name="date" label="Tanggal" type="date" required :value="old('date')"
            class="{{ $errors->has('date') ? 'is-invalid' : '' }}" />

        @if (session('_modal') === 'create' && $errors->has('date'))
            <div class="alert alert-danger mt-2">{{ $errors->first('date') }}</div>
        @endif

        <x-adminlte-input-switch name="is_active" label="Jadikan Aktif" data-on-text="Ya" data-off-text="Tidak"
            :checked="old('is_active')" />

        <div class="d-flex justify-content-end mt-3">
            <button type="button" class="btn btn-secondary btn-sm mr-2" data-dismiss="modal">
                <i class="fas fa-times"></i> Batal
            </button>
            <button type="submit" class="btn btn-primary btn-sm">
                <i class="fas fa-save"></i> Simpan
            </button>
        </div>
    </form>
    <x-slot name="footerSlot">
        <style>
            #createPeriodModal .modal-footer {
                display: none;
            }
        </style>
    </x-slot>
</x-adminlte-modal>

{{-- Modal Edit --}}
<x-adminlte-modal id="editPeriodModal" title="Edit Periode" theme="lightblue" size="md" static-backdrop>
    <form id="editPeriodForm" method="POST">
        @csrf
        @method('PUT')
        <input type="hidden" name="id" id="editId">

        <x-adminlte-input name="date" label="Tanggal" id="editDate" type="date" required />
        <x-adminlte-input-switch name="is_active" label="Jadikan Aktif" id="editIsActiveSwitch" data-on-text="Ya"
            data-off-text="Tidak" />

        <div class="d-flex justify-content-end mt-3">
            <button type="button" class="btn btn-secondary btn-sm mr-2" data-dismiss="modal">
                <i class="fas fa-times"></i> Batal
            </button>
            <button type="submit" class="btn btn-primary btn-sm">
                <i class="fas fa-save"></i> Simpan Perubahan
            </button>
        </div>
    </form>
    <x-slot name="footerSlot">
        <style>
            #editPeriodModal .modal-footer {
                display: none;
            }
        </style>
    </x-slot>
</x-adminlte-modal>
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
@section('css')
<style>
    .scrollable-table-wrapper {
        max-height: 350px;
        overflow-y: auto;

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
    }
</style>
@stop

@section('js')
<script>
    $(document).ready(function () {
        // Isi form edit dan buka modal
        $('.btn-edit-period').on('click', function () {
            const id = $(this).data('id');
            const date = $(this).data('date');
            const isActive = $(this).data('is_active') == 1;

            $('#editId').val(id);
            $('#editDate').val(date);
            $('#editIsActiveSwitch').prop('checked', isActive);

            const actionUrl = `/admin/periods/${id}`;
            $('#editPeriodForm').attr('action', actionUrl);
        });

        // Filter table berdasarkan pencarian
        $('#searchInput').on('keyup', function () {
            const value = $(this).val().toLowerCase();
            $('#periodTable tbody tr').each(function () {
                $(this).toggle($(this).text().toLowerCase().includes(value));
            });
        });

        // Reset form create saat modal ditutup
        $('#createPeriodModal').on('hidden.bs.modal', function () {
            const form = $(this).find('form')[0];
            form.reset();
            $(form).find('.is-invalid').removeClass('is-invalid');
            $(form).find('.alert-danger').remove();
        });

        // Tampilkan kembali modal create jika gagal validasi
        @if ($errors->any() && session('_modal') === 'create')
            $('#createPeriodModal').modal('show');
        @endif
        });
</script>
@stop