@extends('adminlte::page')

@section('title', 'Tambah Sosial Media')

@section('content_header')
    <h1 class="m-0">Tambah Sosial Media Baru</h1>
@stop

@section('content')
    <x-adminlte-card title="Form Tambah Sosial Media" theme="lightblue" theme-mode="outline">
        <form action="{{ route('admin.sosmed.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <x-adminlte-input name="nama" label="Nama Sosial Media" placeholder="Contoh: Instagram" required />
                </div>
                <div class="col-md-6">
                    <x-adminlte-input name="url" label="URL" placeholder="Contoh: https://instagram.com/akunmu"
                        required />
                </div>

                <div class="col-md-12 mt-2">
                    <x-adminlte-input-file name="image_path" label="Icon / Logo (opsional)" igroup-size="md"
                        id="imageInputCreate" />
                    <small id="fileNameCreate" class="form-text text-muted mt-1"></small>
                    <img id="imagePreviewCreate" src="#" alt="Preview" class="mt-2 d-none img-thumbnail"
                        style="max-height: 150px;">
                </div>
            </div>

            <div class="d-flex justify-content-end mt-4">
                <a href="{{ route('admin.sosmed.index') }}" class="btn btn-secondary mr-2">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan
                </button>
            </div>
        </form>
    </x-adminlte-card>
@stop

@section('js')
    <script>
        document.getElementById('imageInputCreate').addEventListener('change', function(event) {
            const input = event.target;
            const fileNameText = document.getElementById('fileNameCreate');
            const previewImg = document.getElementById('imagePreviewCreate');

            if (input.files && input.files[0]) {
                fileNameText.textContent = "File dipilih: " + input.files[0].name;
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    previewImg.classList.remove('d-none');
                };
                reader.readAsDataURL(input.files[0]);
            } else {
                fileNameText.textContent = '';
                previewImg.src = '#';
                previewImg.classList.add('d-none');
            }
        });
    </script>
@endsection

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
