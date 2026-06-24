@extends('adminlte::page')

@section('title', 'Edit Galeri')

@section('content_header')
    <h1>Edit Galeri</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.galeri.update', $galeri->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="title">Judul</label>
                    <input type="text" name="title" class="form-control" value="{{ $galeri->title }}" required>
                </div>

                <div class="form-group">
                    <label for="image_path">Gambar (opsional)</label>
                    <input type="file" name="image_path" class="form-control-file" accept="image/*">
                    @if($galeri->image_path)
                        <div class="mt-2">
                            <img src="{{ asset('storage/' . $galeri->image_path) }}" width="120">
                        </div>
                    @endif
                </div>

                <div class="form-group">
                    <label for="status">Status</label>
                    <select name="status" class="form-control">
                        <option value="1" {{ $galeri->status ? 'selected' : '' }}>Aktif</option>
                        <option value="0" {{ !$galeri->status ? 'selected' : '' }}>Tidak Aktif</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-success">Update</button>
                <a href="{{ route('admin.galeri.index') }}" class="btn btn-secondary">Batal</a>
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
