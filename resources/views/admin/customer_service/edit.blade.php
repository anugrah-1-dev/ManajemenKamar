@extends('adminlte::page')

@section('title', 'Edit Kontak Customer Service')

@section('content_header')
    <h1>Edit Customer Service</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.customer_services.update', $contact->id) }}" method="POST">
            @csrf
            @method('PUT')

            <x-adminlte-input
                name="nama"
                label="Nama Kontak"
                value="{{ old('nama', $contact->nama) }}"
                required
            />

            <x-adminlte-input
                name="nomor"
                label="Nomor WhatsApp"
                value="{{ old('nomor', $contact->nomor) }}"
                required
                placeholder="08xxxxxxxxxx"
            />

            <div class="form-group mt-3">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan Perubahan
                </button>
                <a href="{{ route('admin.customer_services.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </form>
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
