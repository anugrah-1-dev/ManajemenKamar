@extends('adminlte::page')

@section('title', 'Tambah Program Camp')

@section('content_header')
    <h1>Tambah Program Camp</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Form Tambah Program Camp</h3>
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

                <form action="{{ route('admin.programs.camp.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <!-- Informasi Dasar -->
                        <h4 class="mt-3">Informasi Dasar</h4>
                        <div class="row">
                            <div class="col-md-6">
                                <x-adminlte-input name="nama" label="Nama Program" placeholder="Masukkan nama program"
                                    value="{{ old('nama') }}" />
                            </div>
                            <div class="col-md-6">
                                <x-adminlte-input name="slug" label="Slug" placeholder="program-camp-slug"
                                    value="{{ old('slug') }}" />
                            </div>
                            <div class="col-md-6">
                                <x-adminlte-select name="kategori" label="Kategori">
                                    <option value="" {{ old('kategori') ? '' : 'selected' }} disabled>Pilih Kategori
                                    </option>
                                    <option value="Putra" {{ old('kategori') == 'Putra' ? 'selected' : '' }}>Putra</option>
                                    <option value="Putri" {{ old('kategori') == 'Putri' ? 'selected' : '' }}>Putri</option>
                                    <option value="Campuran" {{ old('kategori') == 'Campuran' ? 'selected' : '' }}>Campuran
                                    </option>
                                </x-adminlte-select>
                            </div>
                            <div class="col-md-6">
                                <x-adminlte-input name="stok" label="Stok" type="number" min="0"
                                    placeholder="Jumlah kuota" value="{{ old('stok') }}" />
                            </div>
                        </div>

                        <!-- Harga -->
                        <h4 class="mt-4">Harga</h4>
                        <div class="row">
                            @foreach ([
            'harga_perhari' => 'Per Hari',
            'harga_satu_minggu' => '1 Minggu',
            'harga_dua_minggu' => '2 Minggu',
            'harga_tiga_minggu' => '3 Minggu',
            'harga_satu_bulan' => '1 Bulan',
            'harga_dua_bulan' => '2 Bulan',
            'harga_tiga_bulan' => '3 Bulan',
            'harga_enam_bulan' => '6 Bulan',
            'harga_satu_tahun' => '1 Tahun',
        ] as $field => $label)
                                <div class="col-md-4 col-sm-6">
                                    <x-adminlte-input name="{{ $field }}" label="Harga {{ $label }}"
                                        type="number" min="0" placeholder="0" value="{{ old($field) }}" />
                                </div>
                            @endforeach
                        </div>

                        <!-- Fasilitas -->
                        <h4 class="mt-4">Fasilitas</h4>
                        <div class="row">
                            <div class="col-md-12">
                                <x-adminlte-textarea name="fasilitas" label="Fasilitas"
                                    placeholder="Pisahkan dengan koma (contoh: WiFi, Makan 3x, Transportasi)"
                                    rows="4">
                                    {{ old('fasilitas') }}
                                </x-adminlte-textarea>
                            </div>
                        </div>

                        <!-- Thumbnail -->
                        <h4 class="mt-4">Thumbnail</h4>
                        <div class="row">
                            <div class="col-md-6">
                                <x-adminlte-input type="file" name="thumbnail[]" label="Thumbnail" multiple />
                                <div class="mt-2 d-flex flex-wrap gap-2" id="preview-thumbnails"></div>
                            </div>
                        </div>


                    </div>
                    <div class="card-footer">
                        <x-adminlte-button label="Simpan" theme="success" icon="fas fa-save" type="submit" />
                        <x-adminlte-button label="Batal" theme="secondary" icon="fas fa-times"
                            onclick="window.history.back()" />
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop


@section('js')
    <script>
        document.querySelector('input[name="thumbnail[]"]').addEventListener('change', function(e) {
            const files = e.target.files;
            const previewContainer = document.getElementById('preview-thumbnails');
            previewContainer.innerHTML = ''; // Hapus preview lama

            if (files.length > 5) {
                alert("Maksimal 5 gambar saja!");
                e.target.value = ""; // Reset input
                return;
            }

            Array.from(files).forEach(file => {
                const img = document.createElement('img');
                img.src = URL.createObjectURL(file);
                img.classList.add('img-fluid', 'rounded', 'border');
                img.style.maxHeight = '150px';
                img.style.objectFit = 'cover';
                previewContainer.appendChild(img);
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
