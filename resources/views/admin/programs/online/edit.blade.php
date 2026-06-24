@extends('adminlte::page')

@section('title', 'Edit Program Online')

@section('content_header')
    <h1 class="m-0 text-dark">Edit Program Online: {{ $online->nama }}</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Form Edit Program Online</h3>
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

                <form action="{{ route('admin.online.update', $online) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nama">Nama Program</label>
                                    <input type="text" class="form-control" id="nama" name="nama"
                                        placeholder="Contoh: Kelas Online Intensif" value="{{ old('nama', $online->nama) }}"
                                        required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="program_bahasa">Program Bahasa</label>
                                    <select class="form-control" id="program_bahasa" name="program_bahasa" required>
                                        <option value="" disabled selected>-- Pilih Bahasa --</option>
                                        <option value="inggris"
                                            {{ old('program_bahasa', $online->program_bahasa) == 'inggris' ? 'selected' : '' }}>
                                            Bahasa Inggris</option>
                                        <option value="jerman"
                                            {{ old('program_bahasa', $online->program_bahasa) == 'jerman' ? 'selected' : '' }}>
                                            Bahasa Jerman</option>
                                        <option value="mandarin"
                                            {{ old('program_bahasa', $online->program_bahasa) == 'mandarin' ? 'selected' : '' }}>
                                            Bahasa Mandarin</option>
                                        <option value="arab"
                                            {{ old('program_bahasa', $online->program_bahasa) == 'arab' ? 'selected' : '' }}>
                                            Bahasa Arab</option>
                                        <option value="nhc"
                                            {{ old('program_bahasa', $online->program_bahasa) == 'nhc' ? 'selected' : '' }}>
                                            NHC</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="slug">Slug</label>
                                    <input type="text" class="form-control" id="slug" name="slug"
                                        placeholder="contoh-program-online" value="{{ old('slug', $online->slug) }}"
                                        required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="lama_program">Durasi Program</label>
                                    <input type="text" class="form-control" id="lama_program" name="lama_program"
                                        placeholder="Contoh: 4 minggu"
                                        value="{{ old('lama_program', $online->lama_program) }}" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="kategori">Kategori Program</label>
                                    <input type="text" class="form-control" id="kategori" name="kategori"
                                        placeholder="Contoh: Webinar / Intensif"
                                        value="{{ old('kategori', $online->kategori) }}" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="harga">Harga (Rp)</label>
                                    <input type="number" class="form-control" id="harga" name="harga"
                                        placeholder="Contoh: 1000000" value="{{ old('harga', $online->harga) }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="is_active">Status Program</label>
                                    <select class="form-control" id="is_active" name="is_active" required>
                                        <option value="1"
                                            {{ old('is_active', $online->is_active) == '1' ? 'selected' : '' }}>Aktif
                                        </option>
                                        <option value="0"
                                            {{ old('is_active', $online->is_active) == '0' ? 'selected' : '' }}>Nonaktif
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="features_program">Fitur Program (Pisahkan dengan Enter)</label>
                                   <textarea class="form-control @error('features_program') is-invalid @enderror"
    id="features_program" name="features_program" rows="4">{{ old('features_program', $online->features_program) }}</textarea>

<small class="form-text text-muted">
    Gunakan emoji ✅ untuk menandai fitur. Setiap fitur pada baris baru.
</small>

                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="thumbnail">Thumbnail Program (Gambar)</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="thumbnail" name="thumbnail"
                                            accept="image/*">
                                        <label class="custom-file-label" for="thumbnail">Pilih file</label>
                                    </div>
                                    <small class="form-text text-muted">
                                        Format: JPG, PNG, GIF. Maksimal 2MB.
                                    </small>
                                </div>

                                @if ($online->thumbnail)
                                    <div class="form-check mt-2">
                                        <input type="checkbox" name="hapus_thumbnail" id="hapus_thumbnail"
                                            class="form-check-input">
                                        <label for="hapus_thumbnail" class="form-check-label">Hapus thumbnail saat
                                            disimpan</label>
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-6">
                                @if ($online->thumbnail)
                                    <div class="thumbnail-preview-container">
                                        <p class="font-weight-bold">Thumbnail Saat Ini:</p>
                                        <img src="{{ asset('storage/' . $online->thumbnail) }}" class="img-thumbnail"
                                            id="currentThumbnail" width="200">
                                    </div>
                                @endif
                                <div id="newThumbnailPreview" class="mt-2" style="display:none;">
                                    <p class="font-weight-bold">Pratinjau Thumbnail Baru:</p>
                                    <img id="previewImage" class="img-thumbnail" src="#"
                                        alt="Pratinjau thumbnail" width="200">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Perbarui Program
                        </button>
                        <a href="{{ route('admin.online.index') }}" class="btn btn-secondary ml-2">
                            <i class="fas fa-arrow-left"></i> Batal
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
        document.getElementById('thumbnail').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
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
        document.getElementById('nama').addEventListener('input', function() {
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
