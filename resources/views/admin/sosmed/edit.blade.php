@extends('adminlte::page')

@section('title', 'Edit Sosial Media')

@section('content_header')
    <h1 class="m-0">Edit Sosial Media</h1>
@stop

@section('content')
    <x-adminlte-card title="Form Edit Sosial Media" theme="lightblue" theme-mode="outline">
        <form action="{{ route('admin.sosmed.update', $sosmed->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-6">
                    <x-adminlte-input name="nama" label="Nama Sosial Media" value="{{ $sosmed->nama }}" required />
                </div>
                <div class="col-md-6">
                    <x-adminlte-input name="url" label="URL" value="{{ $sosmed->url }}" required />
                </div>

                <div class="col-md-12 mt-2">
                    <x-adminlte-input-file name="image_path" label="Ganti Icon (opsional)" id="imageInputEdit" />
                    <small id="fileNameEdit" class="form-text text-muted mt-1"></small>

                    {{-- Icon lama --}}
                    @if ($sosmed->image_path)
                        <small id="currentIconLabel" class="form-text text-muted">Icon saat ini:</small>
                        <img id="imagePreviewEditExisting" src="{{ asset('storage/' . $sosmed->image_path) }}"
                            alt="Icon" class="img-thumbnail mt-2" style="max-height: 150px;">
                    @endif

                    {{-- Preview icon baru --}}
                    <img id="imagePreviewEdit" src="#" alt="Preview Baru" class="mt-2 d-none img-thumbnail"
                        style="max-height: 150px;">
                </div>
            </div>

            <div class="d-flex justify-content-end mt-4">
                <a href="{{ route('admin.sosmed.index') }}" class="btn btn-secondary mr-2">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </x-adminlte-card>
@stop

@section('js')
    <script>
        document.getElementById('imageInputEdit').addEventListener('change', function(event) {
            const input = event.target;
            const fileNameText = document.getElementById('fileNameEdit');
            const previewImg = document.getElementById('imagePreviewEdit');
            const existingImg = document.getElementById('imagePreviewEditExisting');
            const currentLabel = document.getElementById('currentIconLabel');

            if (input.files && input.files[0]) {
                fileNameText.textContent = "File dipilih: " + input.files[0].name;

                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    previewImg.classList.remove('d-none');

                    if (existingImg) {
                        existingImg.classList.add('d-none');
                    }

                    if (currentLabel) {
                        currentLabel.classList.add('d-none');
                    }
                };
                reader.readAsDataURL(input.files[0]);
            } else {
                fileNameText.textContent = '';
                previewImg.src = '#';
                previewImg.classList.add('d-none');

                if (existingImg) {
                    existingImg.classList.remove('d-none');
                }

                if (currentLabel) {
                    currentLabel.classList.remove('d-none');
                }
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
