@extends('adminlte::page')

@section('title', 'Edit Program Camp')

@section('content_header')
    <h1 class="m-0 text-dark">Edit Program Camp</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card card-primary">
                <div class="card-header bg-primary">
                    <h3 class="card-title">Form Edit Program Camp</h3>
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

                <form action="{{ route('admin.programs.camp.update', $program->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <!-- Informasi Dasar -->
                        <div class="section-header mb-4">
                            <h4><i class="fas fa-info-circle mr-2"></i>Informasi Dasar</h4>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <x-adminlte-input name="nama" label="Nama Program" placeholder="Masukkan nama program"
                                    value="{{ old('nama', $program->nama) }}" fgroup-class="mb-3" />
                            </div>
                            <div class="col-md-6">
                                <x-adminlte-input name="slug" label="Slug" placeholder="program-camp-slug"
                                    value="{{ old('slug', $program->slug) }}" fgroup-class="mb-3" />
                            </div>
                        </div>
                        {{-- <div class="row">
                            <div class="col-md-6">
                                <x-adminlte-select name="kategori" label="Kategori" fgroup-class="mb-3">
                                    <option value="" {{ old('kategori', $program->kategori) ? '' : 'selected' }} disabled>Pilih Kategori</option>
                                    <option value="Putra" {{ old('kategori', $program->kategori) == 'Putra' ? 'selected' : '' }}>Putra</option>
                                    <option value="Putri" {{ old('kategori', $program->kategori) == 'Putri' ? 'selected' : '' }}>Putri</option>
                                    <option value="Campuran" {{ old('kategori', $program->kategori) == 'Campuran' ? 'selected' : '' }}>Campuran</option>
                                </x-adminlte-select>
                            </div>
                        </div> --}}

                        <!-- Harga -->
                        <div class="section-header mb-4">
                            <h4><i class="fas fa-tags mr-2"></i>Harga</h4>
                        </div>
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
                                        type="number" min="0" placeholder="0" fgroup-class="mb-3"
                                        value="{{ old($field, $program->$field) }}" />
                                </div>
                            @endforeach
                        </div>

                        <!-- Fasilitas -->
                        <div class="section-header mb-4">
                            <h4><i class="fas fa-list-ul mr-2"></i>Fasilitas</h4>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <x-adminlte-textarea name="fasilitas" label="Fasilitas"
                                    placeholder="Pisahkan dengan koma (contoh: WiFi, Makan 3x, Transportasi)" rows="4"
                                    fgroup-class="mb-3">
                                    {{ old('fasilitas', $program->fasilitas) }}
                                </x-adminlte-textarea>
                            </div>
                        </div>

                        <div class="section-header mb-4">
                            <h4><i class="fas fa-image mr-2"></i>Thumbnail</h4>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                @if ($program->thumbnails->count())
                                    <div class="form-group">
                                        <label>Thumbnail Saat Ini</label>
                                        <div class="d-flex flex-wrap gap-3">
                                            @foreach ($program->thumbnails as $thumb)
                                                <div class="thumbnail-item text-center" id="thumb-{{ $thumb->id }}">
                                                    <img src="{{ asset($thumb->image) }}" class="img-thumbnail"
                                                        style="width: 300px; height: 150px; object-fit: contain; background-color: #f0f0f0; display: block; margin: 0 auto;">

                                                    <div class="mt-2">
                                                        <button type="button"
                                                            class="btn btn-danger btn-sm btn-delete-thumbnail"
                                                            data-thumbnail-id="{{ $thumb->id }}">
                                                            Hapus
                                                        </button>

                                                    </div>
                                                </div>
                                            @endforeach

                                        </div>
                                    </div>
                                @endif

                                <x-adminlte-input-file name="thumbnail[]" label="Ganti Thumbnail (opsional)"
                                    accept="image/*" fgroup-class="mb-3" igroup-size="sm" multiple />

                                <div id="preview-container" class="d-flex gap-2 mt-2 flex-wrap"></div>
                            </div>
                        </div>

                    </div>
                    <div class="card-footer text-right">
                        <x-adminlte-button label="Batal" theme="outline-danger" icon="fas fa-times"
                            onclick="window.history.back()" class="mr-2" />
                        <x-adminlte-button label="Perbarui" theme="primary" icon="fas fa-save" type="submit" />
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop



@section('css')
    <style>
        .section-header {
            padding: 10px 0;
            border-bottom: 1px solid #eee;
            margin-bottom: 20px;
        }

        .section-header h4 {
            color: #444;
            font-weight: 600;
        }

        .thumbnail-item {
            width: 120px;
        }

        .thumbnail-item img {
            border-radius: 5px;
        }

        .img-thumbnail {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
        }

        .preview-container {
            border: 2px dashed #ddd;
            padding: 10px;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
    </style>
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.querySelector('input[name="thumbnail[]"]').addEventListener('change', function(e) {
            const previewContainer = document.getElementById('preview-container');
            previewContainer.innerHTML = ''; // reset preview

            const files = e.target.files;
            if (files.length > 0) {
                Array.from(files).forEach(file => {
                    const img = document.createElement('img');
                    img.src = URL.createObjectURL(file);
                    img.classList.add('img-thumbnail');
                    img.style.maxHeight = '120px';
                    img.style.objectFit = 'cover';
                    previewContainer.appendChild(img);
                });
            }
        });

        $(document).on('click', '.btn-delete-thumbnail', function() {
            let thumbId = $(this).data('thumbnail-id');

            Swal.fire({
                title: 'Yakin hapus gambar ini?',
                text: "Data yang dihapus tidak bisa dikembalikan.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/admin/thumbnails/' + thumbId,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(res) {
                            if (res.success) {
                                $('#thumb-' + thumbId).remove();
                                Swal.fire('Berhasil', res.message, 'success');
                            }
                        }
                    });
                }
            });
        });

        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                timer: 3000,
                showConfirmButton: false
            });
        @endif

        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: '{{ session('error') }}',
                timer: 3000,
                showConfirmButton: false
            });
        @endif
    </script>
@stop
