@extends('adminlte::page')

@section('title', 'Tambah Bank')

@section('content_header')
    <h1 class="m-0 text-dark">Tambah Bank Baru</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Formulir Bank</h3>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <strong>Whoops!</strong> Ada kesalahan pada inputan Anda.<br><br>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.banks.store') }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label for="name">Nama Bank</label>
                            <input type="text" name="name" class="form-control"
                                placeholder="Contoh: BCA, BRI, Mandiri" value="{{ old('name') }}" required>
                        </div>

                        <div class="form-group">
                            <label for="owner">Nama Pemilik Rekening</label>
                            <input type="text" name="owner" class="form-control" placeholder="Nama sesuai rekening"
                                value="{{ old('owner') }}" required>
                        </div>

                        <div class="form-group">
                            <label for="number">Nomor Rekening</label>
                            <input type="text" name="number" class="form-control" placeholder="Masukkan nomor rekening"
                                pattern="\d{10,}" title="Minimal 10 digit angka" value="{{ old('number') }}" required>
                            <small class="form-text text-muted">Nomor rekening harus minimal 10 digit angka</small>
                        </div>

                        <div class="form-group">
                            <label for="status">Status</label>
                            <select name="status" class="form-control" required>
                                <option value="">-- Pilih Status --</option>
                                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                                <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Tidak Aktif
                                </option>
                            </select>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan
                            </button>
                            <a href="{{ route('admin.banks.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
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
