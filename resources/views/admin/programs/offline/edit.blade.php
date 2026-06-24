@extends('adminlte::page')

@section('title', 'Edit Program Offline')

@section('content_header')
<h1 class="m-0 text-dark">Edit Program Offline: {{ $offline->nama }}</h1>
@stop

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Form Edit Program Offline</h3>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Ups!</strong> Ada kesalahan dalam input:
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.offline.update', $offline->id) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="card-body">
                    {{-- Informasi Dasar --}}
                    <h5 class="mb-3">Informasi Dasar</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nama">Nama Program</label>
                                <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama"
                                    name="nama" value="{{ old('nama', $offline->nama) }}">
                                @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="program_bahasa">Program Bahasa</label>
                                <select class="form-control @error('program_bahasa') is-invalid @enderror"
                                    id="program_bahasa" name="program_bahasa">
                                    <option value="" disabled>-- Pilih Bahasa --</option>
                                    <option value="inggris" {{ old('program_bahasa', $offline->program_bahasa) == 'inggris' ? 'selected' : '' }}>
                                        Bahasa Inggris</option>
                                    <option value="jerman" {{ old('program_bahasa', $offline->program_bahasa) == 'jerman' ? 'selected' : '' }}>Bahasa
                                        Jerman</option>
                                    <option value="mandarin" {{ old('program_bahasa', $offline->program_bahasa) == 'mandarin' ? 'selected' : '' }}>
                                        Bahasa Mandarin</option>
                                    <option value="arab" {{ old('program_bahasa', $offline->program_bahasa) == 'arab' ? 'selected' : '' }}>Bahasa
                                        Arab</option>
                                    <option value="nhc" {{ old('program_bahasa', $offline->program_bahasa) == 'nhc' ? 'selected' : '' }}>NHC

                                    </option>
                                </select>
                                @error('program_bahasa') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="slug">Slug</label>
                                <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug"
                                    name="slug" value="{{ old('slug', $offline->slug) }}">
                                @error('slug') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="lama_program">Lama Program</label>
                                <input type="text" class="form-control @error('lama_program') is-invalid @enderror"
                                    id="lama_program" name="lama_program"
                                    value="{{ old('lama_program', $offline->lama_program) }}">
                                @error('lama_program') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="kategori">Kategori</label>
                                <input type="text" class="form-control @error('kategori') is-invalid @enderror"
                                    id="kategori" name="kategori" value="{{ old('kategori', $offline->kategori) }}">
                                @error('kategori') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Harga & Lokasi --}}
                    <h5 class="mt-4 mb-3">Detail Program</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="harga">Harga (Rp)</label>
                                <input type="number" class="form-control @error('harga') is-invalid @enderror"
                                    id="harga" name="harga" value="{{ old('harga', $offline->harga) }}">
                                @error('harga') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="lokasi">Lokasi</label>
                                <input type="text" class="form-control @error('lokasi') is-invalid @enderror"
                                    id="lokasi" name="lokasi" value="{{ old('lokasi', $offline->lokasi) }}">
                                @error('lokasi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Jadwal & Kuota --}}
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="jadwal_mulai">Jadwal Mulai</label>
                                <input type="date" class="form-control" id="jadwal_mulai" name="jadwal_mulai"
                                    value="{{ old('jadwal_mulai', $offline->jadwal_mulai) }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="jadwal_selesai">Jadwal Selesai</label>
                                <input type="date" class="form-control" id="jadwal_selesai" name="jadwal_selesai"
                                    value="{{ old('jadwal_selesai', $offline->jadwal_selesai) }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="kuota">Kuota</label>
                                <input type="number" class="form-control" id="kuota" name="kuota"
                                    value="{{ old('kuota', $offline->kuota) }}">
                            </div>
                        </div>
                    </div>

                    {{-- Status --}}
                    <div class="form-group">
                        <label for="is_active">Status Program</label>
                        <select class="form-control" id="is_active" name="is_active">
                            <option value="1" {{ old('is_active', $offline->is_active) == 1 ? 'selected' : '' }}>Aktif
                            </option>
                            <option value="0" {{ old('is_active', $offline->is_active) == 0 ? 'selected' : '' }}>Nonaktif
                            </option>
                        </select>
                    </div>

                    {{-- Thumbnail --}}
                    <h5 class="mt-4 mb-3">Thumbnail Program</h5>
                    <div class="form-group">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="thumbnail" name="thumbnail"
                                accept="image/*">
                            <label class="custom-file-label" for="thumbnail">Pilih file</label>
                        </div>
                        <small class="form-text text-muted">Format: JPG, PNG, GIF. Maks 2MB.</small>

                        @if ($offline->thumbnail)
                            <div class="form-check mt-2">
                                <input class="form-check-input" type="checkbox" name="hapus_thumbnail" value="1"
                                    id="hapus_thumbnail">
                                <label class="form-check-label" for="hapus_thumbnail">Hapus thumbnail saat simpan</label>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <p class="font-weight-bold">Thumbnail Saat Ini:</p>
                                    <img src="{{ asset('storage/' . $offline->thumbnail) }}" class="img-thumbnail"
                                        width="200">
                                </div>
                                <div class="col-md-6" id="newThumbnailPreview" style="display:none;">
                                    <p class="font-weight-bold">Pratinjau Thumbnail Baru:</p>
                                    <img id="previewImage" class="img-thumbnail" src="#" width="200">
                                </div>
                            </div>
                        @endif
                    </div>

                    {{-- Fitur Program --}}
                    <h5 class="mt-4 mb-3">Fitur Program</h5>
                    <div class="form-group">
                       <textarea class="form-control" id="features_program" name="features_program" rows="4">{{ old('features_program', $offline->features_program ?? '') }}</textarea>


                        <small class="form-text text-muted">Gunakan ✅ dan Enter untuk setiap fitur baru</small>
                    </div>
                </div>


        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Simpan Perubahan
            </button>
            <a href="{{ route('admin.offline.index') }}" class="btn btn-secondary ml-2">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
        </form>
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

    .custom-file-label::after {
        content: "Browse";
    }
</style>
@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Preview uploaded image
    document.getElementById('thumbnail').addEventListener('change', function (e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                document.getElementById('previewImage').src = e.target.result;
                document.getElementById('newThumbnailPreview').style.display = 'block';
            }
            reader.readAsDataURL(file);

            // Update custom file label
            const fileName = file.name;
            const label = document.querySelector('.custom-file-label');
            label.textContent = fileName;
        }
    });

    // Auto generate slug from nama
    document.getElementById('nama').addEventListener('input', function () {
        const nama = this.value;
        const slug = nama.toLowerCase()
            .replace(/[^a-z0-9 -]/g, '') // Remove invalid chars
            .replace(/\s+/g, '-') // Replace spaces with -
            .replace(/-+/g, '-'); // Replace multiple - with single -

        document.getElementById('slug').value = slug;
    });
</script>

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
@stop