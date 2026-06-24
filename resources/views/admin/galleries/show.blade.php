@extends('adminlte::page')

@section('title', 'Detail Galeri')

@section('content_header')
    <h1>Detail Galeri: {{ $gallery->title }}</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <h4>{{ $gallery->title }}</h4>
            <p>{{ $gallery->description }}</p>
            <p><strong>Status:</strong>
                <span class="badge {{ $gallery->status ? 'badge-success' : 'badge-secondary' }}">
                    {{ $gallery->status ? 'Aktif' : 'Nonaktif' }}
                </span>
            </p>
        </div>
    </div>

    <div class="row">
        @foreach ($gallery->images as $image)
            <div class="col-md-3 mb-4">
                <div class="card">
                    <img src="{{ asset('storage/' . $image->image_path) }}" class="card-img-top" alt="Foto Galeri">
                    <div class="card-body">
                        <p class="text-muted small">{{ $image->caption ?? '-' }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <a href="{{ route('admin.galleries.index') }}" class="btn btn-secondary">← Kembali</a>
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
