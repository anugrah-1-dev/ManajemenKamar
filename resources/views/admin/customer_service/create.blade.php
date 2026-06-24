@extends('adminlte::page')

@section('title', 'Tambah Kontak Customer Service')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Contact Service</h1>
    </div>

@stop

@section('content')
    <div class="row">
        <div class="col-md-6">
            <x-adminlte-card theme="lightblue" title="Form Tambah Kontak">

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <strong>Ups!</strong> Ada masalah pada input:
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.customer_services.store') }}" method="POST">
                    @csrf

                    <x-adminlte-input name="nama" label="Nama Kontak" placeholder="Contoh: Admin A / CS WA"
                        value="{{ old('nama') }}" required />

                    <x-adminlte-input name="nomor" label="Nomor WhatsApp / HP" placeholder="Contoh: 08123456789"
                        value="{{ old('nomor') }}" pattern="\d{10,15}" title="Minimal 10 digit dan maksimal 15 angka"
                        required />

                    <div class="mt-3">
                        <x-adminlte-button type="submit" theme="primary" icon="fas fa-save" label="Simpan Kontak" />
                        <a href="{{ route('admin.customer_services.index') }}" class="btn btn-secondary ml-2">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </form>

            </x-adminlte-card>
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
