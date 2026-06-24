@extends('adminlte::page')

@section('title', 'Edit Galeri')

@section('content_header')
    <h1>Edit Galeri: {{ $gallery->title }}</h1>
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

@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.galleries.update', $gallery->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="title">Judul Galeri</label>
                    <input type="text" name="title" class="form-control" value="{{ old('title', $gallery->title) }}"
                        required>
                </div>

                <div class="form-group">
                    <label for="description">Deskripsi</label>
                    <textarea name="description" class="form-control">{{ old('description', $gallery->description) }}</textarea>
                </div>

                <div class="form-group">
                    <label for="status">Status</label>
                    <select name="status" class="form-control">
                        <option value="1" {{ $gallery->status ? 'selected' : '' }}>Aktif</option>
                        <option value="0" {{ !$gallery->status ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="images">Upload Gambar Baru (Opsional)</label>
                    <input type="file" name="images[]" class="form-control" multiple accept="image/*">
                    <small class="text-muted">Kosongkan jika tidak ingin menambah gambar baru.</small>
                </div>

                <div class="card-footer px-0">
                    <button type="submit" class="btn btn-success">Update Galeri</button>
                    <a href="{{ route('admin.galleries.index') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </form>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-body">
            <h5>Gambar Saat Ini</h5>
            <div class="row">
                @forelse ($gallery->images as $image)
                    <div class="col-md-3 mb-3">
                        <div class="card shadow-sm">
                            <img src="{{ asset('storage/' . $image->image_path) }}" class="card-img-top rounded"
                                alt="Gambar Galeri">
                            <div class="card-body p-2 text-center">
                                <button class="btn btn-sm btn-danger btn-block btn-delete-image"
                                    data-id="{{ $image->id }}"
                                    data-url="{{ route('admin.galleries.images.destroy', $image->id) }}">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <p class="text-muted">Belum ada gambar yang ditambahkan.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <form id="delete-image-form" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deleteButtons = document.querySelectorAll('.btn-delete-image');
            const deleteForm = document.getElementById('delete-image-form');

            deleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const url = this.getAttribute('data-url');

                    Swal.fire({
                        title: 'Yakin hapus gambar ini?',
                        text: "Gambar akan dihapus permanen!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonColor: '#d33',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            deleteForm.setAttribute('action', url);
                            deleteForm.submit();
                        }
                    });
                });
            });
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
