@extends('layouts.app')

@section('content')
    <div class="container py-5" id="TrackingTrx">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-8">
                <div id="tracking-section"
                    class="text-center mb-5 text-white d-flex flex-column justify-content-center align-items-center"
                    style="height: 300px; background-size: cover; background-position: center; transition: background-image 1s ease-in-out;">

                    <h1 class="display-5 fw-bold">Tracking Transaksi</h1>
                    <p class="lead">Cek status transaksi dan program Anda dengan mudah</p>
                </div>

                <script>
                    document.addEventListener("DOMContentLoaded", function() {
                        let images = [
                            "{{ asset('asset/gif/a.gif') }}",
                            "{{ asset('asset/gif/b.gif') }}",
                            "{{ asset('asset/gif/c.gif') }}",

                        ];
                        let index = 0;
                        let section = document.getElementById("tracking-section");

                        // Set awal
                        section.style.backgroundImage = `url('${images[index]}')`;

                        // Ganti tiap 5 detik
                        setInterval(() => {
                            index = (index + 1) % images.length;
                            section.style.backgroundImage = `url('${images[index]}')`;
                        }, 5000);
                    });
                </script>

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show text-center">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="card shadow-sm mb-5">
                    <div class="card-body p-4">
                        <form action="{{ route('tracking.search') }}" method="POST" class="row g-3">
                            @csrf
                            <div class="col-md-8">
                                <input type="text" name="trx_id" class="form-control form-control-lg"
                                    placeholder="Masukkan Kode Transaksi (TRX-XXXXXX)" required
                                    value="{{ old('trx_id', $trx_id ?? '') }}">
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary btn-lg w-100">
                                    <i class="bi bi-search me-2"></i> Cari
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- Hasil Tracking --}}
                @isset($camp)
                    <div class="card shadow-sm mb-4 border-primary">
                        <div class="card-header bg-primary text-white fw-bold">
                            <i class="bi bi-house-door me-2"></i> Program Camp
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <h5 class="text-muted">Nama Peserta</h5>
                                    <p class="fs-5">{{ $camp->nama_lengkap }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <h5 class="text-muted">Status </h5>
                                    <span
                                        class="badge fs-6
                                                                                                            @if ($camp->status == 'diterima') bg-success
                                                                                                            @elseif($camp->status == 'pending' || $camp->status == 'diproses') bg-warning text-dark
                                                                                                            @elseif($camp->status == 'ditolak') bg-danger
                                                                                                            @else bg-secondary @endif">
                                        {{ ucfirst($camp->status) }}
                                    </span>

                                </div>
                                <div class="col-md-6 mb-3">
                                    <h5 class="text-muted">Nama Program</h5>
                                    @if ($camp)
                                        <p class="fs-5">{{ $camp->program->nama ?? '-' }}</p>
                                    @endif
                                </div>

                                <div class="col-md-6 mb-3">
                                    <h5 class="text-muted">Kamar</h5>
                                    @if ($camp->status === 'diterima')
                                        <p class="fs-5">{{ $camp->nama_kamar }}</p>
                                    @else
                                        <p class="fs-5 text-muted"><em>Kamar sedang diproses oleh admin</em></p>
                                    @endif
                                </div>
                                @if ($camp->bukti_pembayaran)
                                    <div class="col-md-12 mb-3">
                                        <h5 class="text-muted">Bukti Pembayaran</h5>
                                        <a href="{{ asset('storage/' . $camp->bukti_pembayaran) }}" target="_blank">
                                            <img src="{{ asset('storage/' . $camp->bukti_pembayaran) }}" alt="Bukti Pembayaran"
                                                class="img-fluid rounded shadow-sm" style="max-height: 300px;">
                                        </a>
                                    </div>
                                @endif

                            </div>
                        </div>

                    </div>
                @endisset

                @isset($offline)
                    <div class="card shadow-sm mb-4 border-info">
                        <div class="card-header bg-info text-white fw-bold">
                            <i class="bi bi-building me-2"></i> Program Offline
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <h5 class="text-muted">Nama Peserta</h5>
                                    <p class="fs-5">{{ $offline->nama_lengkap }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <h5 class="text-muted">Status Pendaftaran</h5>
                                    <span
                                        class="badge fs-6
                                                                                                                @if ($offline->status == 'diterima') bg-success
                                                                                                                @elseif($offline->status == 'pending' || $offline->status == 'diproses') bg-warning text-dark
                                                                                                                @elseif($offline->status == 'ditolak') bg-danger
                                                                                                                @else bg-secondary @endif">
                                        {{ ucfirst($offline->status) }}
                                    </span>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <h5 class="text-muted">Nama Program</h5>
                                    <p class="fs-5">{{ $offline->program->nama ?? '-' }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <h5 class="text-muted">Transportasi</h5>
                                    <p class="fs-5">{{ $offline->transport->name ?? '-' }}</p>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <h5 class="text-muted">Total Harga</h5>

                                    @if ($offline->payment_method === 'DP')
                                        <p class="fs-5 mb-1">
                                            <span class="text-decoration-line-through text-muted">
                                                Rp. {{ number_format($offline->subtotal, 0, ',', '.') }}
                                            </span>
                                        </p>
                                        <p class="fs-5 fw-bold text-warning">
                                            Sisa Bayar: Rp.
                                            {{ number_format($offline->subtotal - $offline->dp_amount, 0, ',', '.') }}
                                        </p>
                                        <small class="d-block mt-1 px-2 py-1 rounded"
                                            style="background-color: #fff9c4; color: #7a6b00;">
                                            💡 Sisa pembayaran dapat dilunasi di office Bieplus
                                        </small>
                                    @else
                                        <p class="fs-5">
                                            Rp. {{ number_format($offline->subtotal, 0, ',', '.') }}
                                        </p>
                                    @endif
                                </div>


                                <div class="col-md-6 mb-3">
                                    <h5 class="text-muted">Status Pembayaran</h5>

                                    @if ($offline->payment_method === 'cicilan')
                                        {{-- CICILAN --}}
                                        @if ($offline->cicilan_lunas)
                                            <!-- accessor -->
                                            <span class="badge bg-success fs-6">Pembayaran cicilan Anda telah lunas</span>
                                        @else
                                            <span class="badge bg-warning text-dark fs-6">Pembayaran cicilan belum lunas</span>
                                            <br>
                                            <small class="text-muted">* Silakan lakukan pelunasan cicilan tepat waktu</small>
                                        @endif

                                        <br>
                                        <a href="{{ route('tracking.show', $offline->trx_id) }}"
                                            class="btn btn-sm btn-warning fw-bold">
                                            <i class="bi bi-credit-card me-1"></i> Lihat Detail Pembayaran
                                        </a>
                                    @elseif (strtolower($offline->payment_method) === 'dp')
                                        {{-- DP --}}
                                        @if ($offline->dp_lunas ?? false)
                                            <!-- accessor atau manual check -->
                                            <span class="badge bg-success fs-6">DP sudah dibayar, transaksi lunas</span>
                                        @else
                                            <span class="badge bg-info text-dark fs-6">
                                                DP dibayar Rp {{ number_format($offline->dp_amount, 0, ',', '.') }}
                                            </span>
                                            <br>
                                            {{-- <small class="d-block mt-2 p-2 rounded fw-semibold text-dark"
                                                style="background-color: #fff; border: 2px solid #ffc107;">
                                                Sisa pembayaran dapat dilunasi di office Bieplus
                                            </small> --}}
                                        @endif

                                        <br>
                                        {{-- <a href="{{ route('tracking.show', $offline->trx_id) }}"
                                            class="btn btn-sm btn-primary fw-bold">
                                            <i class="bi bi-cash-coin me-1"></i> Lihat Detail DP & Pelunasan
                                        </a> --}}
                                    @else
                                        {{-- FULL PAYMENT --}}
                                        <span class="badge bg-success fs-6">Lunas</span>
                                    @endif
                                </div>







                            </div>

                            {{-- Bukti Pembayaran ditaruh full width di bawah dan center --}}
                            @if ($offline->bukti_pembayaran)
                                <div class="row">
                                    <div class="col-12 text-center mt-4">
                                        <h5 class="text-muted">Bukti Pembayaran</h5>
                                        <a href="{{ asset('storage/' . $offline->bukti_pembayaran) }}" target="_blank">
                                            <img src="{{ asset('storage/' . $offline->bukti_pembayaran) }}"
                                                alt="Bukti Pembayaran" class="img-fluid rounded shadow-sm d-block mx-auto"
                                                style="max-height: 300px;">
                                        </a>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                @endisset


                @isset($online)
                    <div class="card shadow-sm mb-4 border-success">
                        <div class="card-header bg-success text-white fw-bold">
                            <i class="bi bi-laptop me-2"></i> Program Online
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <h5 class="text-muted">Nama Peserta</h5>
                                    <p class="fs-5">{{ $online->nama_lengkap }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <h5 class="text-muted">Status</h5>
                                    <span
                                        class="badge
                                                                                                              @if ($online->status == 'aktif') bg-success
                                                                                                               @elseif($online->status == 'ditolak') bg-danger
                                                                                                               @else bg-warning @endif fs-6">
                                        {{ ucfirst($online->status) }}
                                    </span>
                                </div>

                                <div class="col-md-12 mb-3">
                                    <h5 class="text-muted">Program</h5>
                                    @if ($online)
                                        <p class="fs-5">{{ $online->program->nama ?? '-' }}</p>
                                    @endif

                                </div>

                                <div class="col-md-12 mb-3">
                                    <h5 class="text-muted">Total Harga</h5>
                                    <p class="fs-5">
                                        Rp. {{ number_format($online->subtotal, 0, ',', '.') }}
                                    </p>
                                </div>

                            </div>
                            @if ($online->bukti_pembayaran)
                                <div class="col-md-12 mb-3">
                                    <h5 class="text-muted">Bukti Pembayaran</h5>
                                    <a href="{{ asset('storage/bukti_pembayaran/' . $online->bukti_pembayaran) }}"
                                        target="_blank">
                                        <img src="{{ asset('storage/bukti_pembayaran/' . $online->bukti_pembayaran) }}"
                                            alt="Bukti Pembayaran" class="img-fluid rounded shadow-sm"
                                            style="max-height: 300px;">
                                    </a>
                                </div>
                            @endif

                        </div>
                    </div>
                @endisset

                @if (isset($camp) || isset($offline) || isset($online))
                    <div class="text-center mt-4">
                        <a href="{{ route('tracking.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left me-2"></i> Cari Transaksi Lain
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
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
