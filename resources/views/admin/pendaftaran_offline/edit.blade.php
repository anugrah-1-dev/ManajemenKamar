@extends('adminlte::page')

@section('title', 'Edit Pendaftaran')

@section('content_header')
    <h1 class="m-0">Edit Status Pendaftaran: {{ $pendaftaran->trx_id }}</h1>
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

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card card-outline card-primary">
                <div class="card-body">
                    <div class="row">
                        {{-- Kolom Informasi Pendaftar --}}
                        <div class="col-md-6">
                            <h4>Informasi Pendaftar</h4>
                            <table class="table table-bordered">
                                <tr>
                                    <th style="width: 30%;">TRX ID</th>
                                    <td>{{ $pendaftaran->trx_id }}</td>
                                </tr>
                                <tr>
                                    <th>Nama Lengkap</th>
                                    <td>{{ $pendaftaran->nama_lengkap }}</td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td>{{ $pendaftaran->email }}</td>
                                </tr>
                                <tr>
                                    <th>Program</th>
                                    <td>{{ $pendaftaran->program->nama ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Periode</th>
                                    <td>
                                        @if ($pendaftaran->program->program_bahasa === 'nhc' && $pendaftaran->periodNHC)
                                            {{ $pendaftaran->periodNHC->start_date->translatedFormat('d F Y') }}
                                            -
                                            {{ $pendaftaran->periodNHC->end_date->translatedFormat('d F Y') }}
                                        @else
                                            {{ optional($pendaftaran->period?->date)->translatedFormat('d F Y') ?? '-' }}
                                        @endif
                                    </td>



                                </tr>


                            </table>

                            <h4 class="mt-4">Ubah Status</h4>
                            <form action="{{ route('admin.pendaftaran.offline.update', $pendaftaran->id) }}"
                                method="POST">
                                @csrf
                                @method('PUT')

                                <div class="form-group">
                                    <label for="status">Status Pembayaran</label>
                                    <select name="status" id="status"
                                        class="form-control @error('status') is-invalid @enderror">
                                        <option value="pending" {{ $pendaftaran->status == 'pending' ? 'selected' : '' }}>
                                            Pending</option>
                                        <option value="approved"
                                            {{ $pendaftaran->status == 'diterima' ? 'selected' : '' }}>
                                            Approved (Diterima)
                                        </option>
                                        <option value="rejected" {{ $pendaftaran->status == 'ditolak' ? 'selected' : '' }}>
                                            Rejected (Ditolak)
                                        </option>
                                    </select>
                                    @error('status')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                <a href="{{ route('admin.pendaftaran.offline.index') }}"
                                    class="btn btn-secondary">Batal</a>
                            </form>
                        </div>

                        {{-- Kolom Bukti Pembayaran --}}
                        <div class="col-md-6">
                            <h4>Bukti Pembayaran</h4>
                            @if ($pendaftaran->bukti_pembayaran)
                                <a href="{{ asset('storage/' . $pendaftaran->bukti_pembayaran) }}" target="_blank">
                                    <img src="{{ asset('storage/' . $pendaftaran->bukti_pembayaran) }}"
                                        alt="Bukti Pembayaran" class="img-fluid rounded border">
                                </a>
                            @else
                                <div class="alert alert-warning">
                                    Pendaftar belum mengunggah bukti pembayaran.
                                </div>
                            @endif
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
