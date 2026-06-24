@extends('adminlte::page')

@section('title', 'Tambah Pamflet Baru')

@section('content_header')
    <h1 class="m-0 text-dark">Tambah Pamflet Baru</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Formulir Program</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <strong>Whoops!</strong> Terdapat masalah dengan inputan Anda.<br><br>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.pamflet_programs.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="judul">Judul Program</label>
                                    <input type="text" id="judul" name="judul" class="form-control"
                                        value="{{ old('judul') }}" placeholder="Masukkan judul program" required>
                                </div>

                                <div class="form-group">
                                    <label for="deskripsi">Deskripsi Lengkap Program</label>
                                    <textarea id="deskripsi" name="deskripsi" class="form-control" rows="5"
                                        placeholder="Deskripsi detail tentang program" required>{{ old('deskripsi') }}</textarea>
                                </div>

                                <div class="form-group">
                                    <label for="keunggulan">Keunggulan Program</label>
                                    <small class="form-text text-muted d-block mb-2">Gunakan titik atau enter untuk
                                        memisahkan poin keunggulan</small>
                                    <textarea id="keunggulan" name="keunggulan" class="form-control" rows="5"
                                        placeholder="Masukkan keunggulan program" required>{{ old('keunggulan') }}</textarea>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="gambar">Gambar Program</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="gambar" name="gambar"
                                                required>
                                            <label class="custom-file-label" for="gambar">Pilih file</label>
                                        </div>
                                    </div>
                                    <small class="form-text text-muted">Format: JPG, PNG. Maksimal 2MB</small>
                                    <div class="mt-2 text-center">
                                        <img id="preview-image"
                                            src="https://via.placeholder.com/300x200?text=Preview+Gambar"
                                            alt="Preview Gambar" class="img-fluid img-thumbnail" style="max-height: 200px;">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="status">Status Program</label>
                                    <select id="status" name="status" class="form-control" required>
                                        <option value="aktif" {{ old('status') == 'aktif' ? 'selected' : '' }}>Aktif
                                        </option>
                                        <option value="nonaktif" {{ old('status') == 'nonaktif' ? 'selected' : '' }}>
                                            Nonaktif</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan Program
                            </button>
                            <a href="{{ route('admin.pamflet_programs.index') }}" class="btn btn-default">
                                <i class="fas fa-times"></i> Batal
                            </a>
                        </div>
                    </form>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
@stop

@section('js')
    <script>
        // Preview image before upload
        document.getElementById('gambar').addEventListener('change', function(event) {
            const output = document.getElementById('preview-image');
            if (event.target.files && event.target.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    output.src = e.target.result;
                };
                reader.readAsDataURL(event.target.files[0]);
            }
        });

        // Show the file name in the custom file input
        document.querySelector('.custom-file-input').addEventListener('change', function(e) {
            var fileName = document.getElementById('gambar').files[0].name;
            var nextSibling = e.target.nextElementSibling;
            nextSibling.innerText = fileName;
        });
    </script>
@stop

@section('css')
    <style>
        .custom-file-label::after {
            content: "Browse";
        }

        #preview-image {
            border: 1px dashed #ddd;
            padding: 5px;
            background-color: #f8f9fa;
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
