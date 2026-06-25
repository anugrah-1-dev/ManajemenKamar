@extends('adminlte::page')

@section('title', 'Edit Bank')

@section('content_header')
    <h1 class="m-0 text-dark">Edit Bank</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-8">
            <x-adminlte-card theme="lightblue" title="Form Edit Bank">

                {{-- Tampilkan error validasi jika ada --}}
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <strong>Ups!</strong> Ada masalah dengan input Anda:
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.banks.update', $bank->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <x-adminlte-input name="name" label="Nama Bank" placeholder="Contoh: BRI, BCA"
                        value="{{ old('name', $bank->name) }}" required />

                    <x-adminlte-input name="owner" label="Nama Pemilik Rekening" placeholder="Atas nama rekening"
                        value="{{ old('owner', $bank->owner) }}" required />

                    <x-adminlte-input name="number" label="Nomor Rekening" placeholder="Masukkan nomor rekening"
                        value="{{ old('number', $bank->number) }}" pattern="\d{10,}" title="Minimal 10 digit angka"
                        required />

                    <x-adminlte-select name="status" label="Status" required>
                        <option value="active" {{ old('status', $bank->status) == 'active' ? 'selected' : '' }}>Aktif
                        </option>
                        <option value="inactive" {{ old('status', $bank->status) == 'inactive' ? 'selected' : '' }}>Tidak
                            Aktif</option>
                    </x-adminlte-select>

                    <div class="mt-3">
                        <x-adminlte-button type="submit" theme="primary" icon="fas fa-save" label="Perbarui Bank" />
                        <a href="{{ route('admin.banks.index') }}" class="btn btn-secondary ml-2">
                            <i class="fas fa-arrow-left"></i> Batal
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
