@extends('adminlte::page')

@section('title', 'Tambah Galeri')

@section('content_header')
    <h1>Tambah Galeri</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.galeri.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label for="title">Judul</label>
                    <input type="text" name="title" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="image_path">Gambar</label>
                    <input type="file" name="image_path[]" class="form-control-file" multiple accept="image/*"
                        id="imageInput">
                    <div id="preview" class="mt-2 d-flex flex-wrap gap-2"></div>
                </div>

                <div class="form-group">
                    <label for="status">Status</label>
                    <select name="status" class="form-control">
                        <option value="1">Aktif</option>
                        <option value="0">Tidak Aktif</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('admin.galeri.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
@stop

@section('js')
    <script>
        document.getElementById('imageInput').addEventListener('change', function(event) {
            const preview = document.getElementById('preview');
            preview.innerHTML = ''; // Clear previous preview

            for (const file of event.target.files) {
                // Validasi file
                if (!file.type.startsWith('image/')) {
                    alert('File bukan gambar: ' + file.name);
                    continue;
                }

                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.setAttribute('src', e.target.result);
                    img.setAttribute('width', '100');
                    img.setAttribute('class', 'mr-2 mb-2 rounded shadow-sm');
                    preview.appendChild(img);
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
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
