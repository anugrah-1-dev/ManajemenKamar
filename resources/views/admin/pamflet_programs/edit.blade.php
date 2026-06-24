@extends('adminlte::page')

@section('title', 'Edit Pamflet Program')

@section('content_header')
    {{-- <h1 class="m-0 text-dark">Edit Program: {{ $program->judul_konten }}</h1> --}}
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.pamflet_programs.update', $program->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <label for="judul">Judul Program</label>
                        <input type="text" name="judul" id="judul"
                            class="form-control @error('judul') is-invalid @enderror"
                            value="{{ old('judul', $program->judul) }}">
                        @error('judul')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                        <div class="form-group">
                            <label for="deskripsi">Deskripsi Program</label>
                            <textarea name="deskripsi" id="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" rows="5">{{ old('deskripsi', $program->deskripsi) }}</textarea>
                            @error('deskripsi')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="keunggulan">Keunggulan Program</label>
                            <textarea name="keunggulan" id="keunggulan" class="form-control @error('keunggulan') is-invalid @enderror"
                                rows="5">{{ old('keunggulan', $program->keunggulan) }}</textarea>
                            @error('keunggulan')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="gambar">Gambar Pamflet</label>
                            @if ($program->gambar)
                                <div class="mb-2">
                                    <img src="{{ asset('uploads/programs/' . $program->gambar) }}" width="150"
                                        class="img-thumbnail">
                                    <div class="form-check mt-2">
                                        <input type="checkbox" name="hapus_gambar" id="hapus_gambar"
                                            class="form-check-input">
                                        <label for="hapus_gambar" class="form-check-label">
                                            Hapus gambar saat disimpan
                                        </label>
                                    </div>
                                </div>
                            @endif
                            <input type="file" name="gambar" id="gambar"
                                class="form-control-file @error('gambar') is-invalid @enderror">
                            <small class="form-text text-muted">
                                Format: jpeg,png,jpg,gif,svg | Maks: 5MB
                            </small>
                            @error('gambar')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="status">Status Program</label>
                            <select name="status" id="status"
                                class="form-control @error('status') is-invalid @enderror">
                                <option value="aktif" {{ $program->status == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="nonaktif" {{ $program->status == 'nonaktif' ? 'selected' : '' }}>Nonaktif
                                </option>
                            </select>
                            @error('status')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan Perubahan
                            </button>
                            <a href="{{ route('admin.pamflet_programs.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <style>
        .img-thumbnail {
            max-height: 200px;
            object-fit: cover;
        }
    </style>
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
