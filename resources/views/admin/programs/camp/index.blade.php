@extends('adminlte::page')

@section('title', 'Manajemen Program Camp')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="m-0">Daftar Program Camp</h1>

        <div class="d-flex" style="gap: 1rem;">
            <button id="btn-sync-stok" class="btn btn-success mt-3">
                <i class="fas fa-sync-alt"></i> Sync kapasitas stok Rooms
            </button>

            <button id="btn-sync-stok-penghuni" class="btn btn-warning mt-3">
                <i class="fas fa-sync-alt"></i> Sync Stok (Kapasitas - Penghuni)
            </button>

        </div>
    </div>
@endsection


@section('content')
    <div class="row">
        <div class="col-12">
            <x-adminlte-card theme="lightblue" theme-mode="outline" title="List Program Camp">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-search"></i></span>
                            </div>
                            <input type="text" id="searchInput" class="form-control"
                                placeholder="Cari berdasarkan nama program...">
                        </div>
                    </div>
                    <div class="col-md-6 text-right">
                        <span class="text-muted">
                            Menampilkan {{ $programs->firstItem() }} - {{ $programs->lastItem() }} dari
                            {{ $programs->total() }} program
                        </span>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover table-bordered table-striped" id="programTable">
                        <thead class="bg-lightblue">
                            <tr>
                                <th width="5%">No</th>
                                <th width="10%">Thumbnail</th>
                                <th width="15%">Nama Program</th>
                                {{-- <th width="10%">Kategori</th> --}}
                                <th width="5%">Stok</th>
                                <th width="15%">Harga</th>
                                <th width="25%">Fasilitas</th>
                                <th width="15%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($programs as $index => $program)
                                <tr>
                                    <td class="text-center">
                                        {{ ($programs->currentPage() - 1) * $programs->perPage() + $index + 1 }}</td>
                                    <td class="text-center">
                                        @if ($program->thumbnails->count() > 0)
                                            <div id="thumb-grid-{{ $program->id }}"
                                                style="display: grid; grid-template-columns: repeat(auto-fill, minmax(100px, 1fr)); gap: 5px;">
                                                @foreach ($program->thumbnails as $index => $thumb)
                                                    <div
                                                        class="{{ $index >= 1 ? 'extra-thumb-' . $program->id . ' d-none' : '' }}">
                                                        <img src="{{ asset($thumb->image) }}" alt="Thumbnail"
                                                            class="img-thumbnail"
                                                            style="width: 100%; height: 80px; object-fit: cover;">
                                                    </div>
                                                @endforeach
                                            </div>

                                            @if ($program->thumbnails->count() > 1)
                                                <button class="btn btn-link p-0 mt-2"
                                                    onclick="toggleThumbnails({{ $program->id }}, this)">
                                                    Lihat Selengkapnya
                                                </button>
                                            @endif
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif




                                    </td>

                                    <script>
                                        function toggleThumbnails(id, btn) {
                                            const extraThumbs = document.querySelectorAll('.extra-thumb-' + id);
                                            const hidden = [...extraThumbs].some(el => el.classList.contains('d-none'));
                                            extraThumbs.forEach(el => el.classList.toggle('d-none', !hidden));
                                            btn.textContent = hidden ? 'Sembunyikan' : 'Lihat Selengkapnya';
                                        }
                                    </script>





                                    <td>
                                        <strong>{{ $program->nama }}</strong><br>
                                        <small class="text-muted">Slug: {{ $program->slug ?? '-' }}</small>
                                    </td>
                                    {{-- <td>{{ $program->kategori ?? '-' }}</td> --}}
                                    <td class="text-center">
                                        <span id="stok-{{ $program->id }}">{{ $program->stok ?? 0 }}</span>
                                    </td>

                                    <td>
                                        <div class="price-info">
                                            <small>Per Hari: Rp
                                                {{ number_format($program->harga_perhari, 0, ',', '.') }}</small><br>
                                            <small>1 Minggu: Rp
                                                {{ number_format($program->harga_satu_minggu, 0, ',', '.') }}</small><br>
                                            <small>1 Bulan: Rp
                                                {{ number_format($program->harga_satu_bulan, 0, ',', '.') }}</small>
                                            <a href="#" class="show-more-prices"
                                                data-program-id="{{ $program->id }}">Lihat lebih banyak...</a>
                                            <div class="more-prices" id="more-prices-{{ $program->id }}"
                                                style="display:none;">
                                                <small>2 Minggu: Rp
                                                    {{ number_format($program->harga_dua_minggu, 0, ',', '.') }}</small><br>
                                                <small>3 Minggu: Rp
                                                    {{ number_format($program->harga_tiga_minggu, 0, ',', '.') }}</small><br>
                                                <small>2 Bulan: Rp
                                                    {{ number_format($program->harga_dua_bulan, 0, ',', '.') }}</small><br>
                                                <small>3 Bulan: Rp
                                                    {{ number_format($program->harga_tiga_bulan, 0, ',', '.') }}</small><br>
                                               
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="facilities-container" style="max-height: 100px; overflow: hidden;">
                                            {!! nl2br(e($program->fasilitas)) !!}
                                        </div>
                                        @if (strlen($program->fasilitas) > 100)
                                            <a href="#" class="show-more-facilities"
                                                data-program-id="{{ $program->id }}">Lihat selengkapnya</a>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center align-items-center" style="gap: 0.5rem;">
                                            <a href="{{ route('admin.programs.camp.edit', $program->id) }}"
                                                class="btn btn-sm btn-warning d-inline-flex align-items-center justify-content-center"
                                                style="min-width: 80px;" title="Edit">
                                                <i class="fas fa-edit mr-1"></i> Edit
                                            </a>

                                            {{-- <form action="{{ route('admin.programs.camp.destroy', $program->id) }}"
                                                method="POST" onsubmit="return confirmDelete(event)">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="btn btn-sm btn-danger d-inline-flex align-items-center justify-content-center"
                                                    style="min-width: 80px;" title="Hapus">
                                                    <i class="fas fa-trash-alt mr-1"></i> Hapus
                                                </button>
                                            </form> --}}
                                        </div>
                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">Tidak ada data program camp.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                </div>

                @if ($programs->hasPages())
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div>
                            <select class="form-control form-control-sm" id="perPageSelect" style="width: 80px;">
                                <option value="10" {{ $programs->perPage() == 10 ? 'selected' : '' }}>10</option>
                                <option value="25" {{ $programs->perPage() == 25 ? 'selected' : '' }}>25</option>
                                <option value="50" {{ $programs->perPage() == 50 ? 'selected' : '' }}>50</option>
                                <option value="100" {{ $programs->perPage() == 100 ? 'selected' : '' }}>100</option>
                            </select>
                        </div>
                        <div>
                            {{ $programs->links('vendor.pagination.bootstrap-5') }}
                        </div>
                    </div>
                @endif
            </x-adminlte-card>
        </div>
    </div>
@stop

@section('css')
    <style>
        .limited-scroll {
            max-height: 350px;
            overflow-y: auto;
        }

        /* Scrollbar lebih cantik */
        .limited-scroll::-webkit-scrollbar {
            width: 6px;
        }

        .limited-scroll::-webkit-scrollbar-thumb {
            background-color: #ccc;
            border-radius: 6px;
        }

        .price-info small {
            display: block;
            line-height: 1.3;
        }

        .show-more-prices,
        .show-more-facilities {
            font-size: 0.8rem;
            color: #007bff;
            cursor: pointer;
        }

        .table th {
            white-space: nowrap;
        }

        .facilities-container {
            font-size: 0.9rem;
        }

        .img-thumbnail {
            padding: 0.25rem;
            background-color: #fff;
            border: 1px solid #dee2e6;
            border-radius: 0.25rem;
        }

        .pagination {
            margin: 0;
        }

        .page-item.active .page-link {
            background-color: #3c8dbc;
            border-color: #367fa9;
        }

        .page-link {
            color: #3c8dbc;
        }

        .page-link:hover {
            color: #2a6496;
        }

        .btn-sm {
            min-width: 70px;
        }

        .btn-icon-only {
            width: 40px;
            height: 40px;
            font-size: 1rem;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }


        td .d-flex {
            padding-left: 0.25rem;
            padding-right: 0.25rem;
        }
    </style>
@stop


@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmDelete(event) {
            event.preventDefault();
            const form = event.target.closest('form');

            Swal.fire({
                title: 'Yakin ingin menghapus data ini?',
                text: "Data akan dihapus secara permanen dari database.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e3342f',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, hapus',
                cancelButtonText: 'Tidak'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                } else {
                    Swal.fire({
                        title: 'Dibatalkan',
                        text: 'Data tidak jadi dihapus.',
                        icon: 'info',
                        timer: 1500,
                        showConfirmButton: false
                    });
                }
            });
        }

        $(document).ready(function() {
            // Search Functionality
            $('#searchInput').on('keyup', function() {
                // Tambahkan logika pencarian jika perlu
            });

            // Show More Prices
            $(document).on('click', '.show-more-prices', function(e) {
                e.preventDefault();
                const programId = $(this).data('program-id');
                $(this).hide();
                $('#more-prices-' + programId).show();
            });

            // Show More Facilities
            $(document).on('click', '.show-more-facilities', function(e) {
                e.preventDefault();
                const programId = $(this).data('program-id');
                $(this).closest('td').find('.facilities-container').css('max-height', 'none');
                $(this).remove();
            });

            // Per Page Selection
            $('#perPageSelect').change(function() {
                const perPage = $(this).val();
                const url = new URL(window.location.href);
                url.searchParams.set('per_page', perPage);
                window.location.href = url.toString();
            });

            // SYNC STOK FUNCTION
            $('#btn-sync-stok').on('click', function() {
                $.ajax({
                    url: '{{ route('admin.programs.camp.syncAllStokFromRoomsAjax') }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    beforeSend: function() {
                        $('#btn-sync-stok').prop('disabled', true).html(
                            '<i class="fas fa-spinner fa-spin"></i> Syncing...');
                    },
                    success: function(response) {
                        if (response.success) {
                            $.each(response.programs, function(index, program) {
                                $('#stok-' + program.id).text(program.stok);
                            });
                            Swal.fire({
                                title: 'Berhasil!',
                                text: 'Stok berhasil disinkronkan!',
                                icon: 'success',
                                timer: 1500,
                                showConfirmButton: false
                            });
                        } else {
                            Swal.fire({
                                title: 'Gagal!',
                                text: 'Gagal sync stok.',
                                icon: 'error'
                            });
                        }
                    },
                    complete: function() {
                        $('#btn-sync-stok').prop('disabled', false).html(
                            '<i class="fas fa-sync-alt"></i> Sync Stok dari Rooms');
                    }
                });
            });
        });

        $(function() {
            $('#btn-sync-stok-penghuni').click(function() {
                Swal.fire({
                    title: 'Konfirmasi',
                    text: 'Yakin ingin sinkronisasi stok dari penghuni yang aktif sekarang?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, sinkronkan',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // disable tombol dan ubah icon
                        $('#btn-sync-stok-penghuni').prop('disabled', true).html(
                            '<i class="fas fa-spinner fa-spin"></i> Syncing...'
                        );

                        $.ajax({
                            url: "{{ route('admin.programs.camp.syncStokWithPenghuni') }}",
                            method: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                if (response.success) {
                                    Swal.fire({
                                        title: 'Berhasil!',
                                        text: 'Stok berhasil disinkronkan berdasarkan kapasitas dan penghuni.',
                                        icon: 'success',
                                        timer: 1500,
                                        showConfirmButton: false
                                    }).then(() => {
                                        location.reload();
                                    });
                                } else {
                                    Swal.fire({
                                        title: 'Gagal',
                                        text: 'Gagal sinkronisasi stok.',
                                        icon: 'error'
                                    });
                                }
                            },
                            error: function(xhr) {
                                Swal.fire({
                                    title: 'Error',
                                    text: 'Terjadi kesalahan saat sinkronisasi: ' +
                                        xhr.responseText,
                                    icon: 'error'
                                });
                            },
                            complete: function() {
                                $('#btn-sync-stok-penghuni').prop('disabled', false)
                                    .html(
                                        '<i class="fas fa-sync-alt"></i> Sync Stok (Kapasitas - Penghuni)'
                                    );
                            }
                        });
                    }
                });
            });
        });

        @if (session('alert'))
            Swal.fire(@json(session('alert')));
        @endif
    </script>


@endsection



<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
