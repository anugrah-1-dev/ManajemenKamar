@extends('layouts.app')

@section('title', 'Tagihan Cicilan')

@section('content')
    <div class="container my-4">
        <div class="row justify-content-center">
            <div class="col-md-10">

               {{-- Notifikasi Sukses / Error --}}
@if(session('success'))
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session("success") }}',
            confirmButtonText: 'OK'
        });
    });
</script>
@endif

@if(session('error'))
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: '{{ session("error") }}',
            confirmButtonText: 'OK'
        });
    });
</script>
@endif


                {{-- Judul --}}
                <div id="tracking-section"
                    class="text-center mb-5 text-white d-flex flex-column justify-content-center align-items-center"
                    style="height: 300px; background-size: cover; background-position: center; transition: background-image 1s ease-in-out;">

                    <h1 class="display-5 fw-bold">Tracking Transaksi</h1>
                    <p class="lead">Cek status transaksi cicilan anda</p>
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

                {{-- ID Transaksi --}}
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        Transaksi
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">ID Transaksi: {{ $offline->trx_id }}</h5>
                    </div>
                </div>

                <div class="row gy-4">
                    {{-- Tagihan Saat Ini --}}
                    <div class="col-md-6">
                        <div class="card shadow-sm h-100">
                            <div class="card-header bg-white pt-3">
                                <h5 class="mb-0 text-dark">Tagihan Saya</h5>
                            </div>
                            <div class="card-body">
                                @php
                                    $cicilan_aktif = $cicilan->where('status', 'pending')->sortBy('bulan_ke')->first();
                                @endphp

                                @if ($cicilan_aktif)
                                    <div class="text-center py-4">
                                        <i class="fas fa-exclamation-circle text-warning mb-3" style="font-size: 3rem;"></i>
                                        <h6 class="fw-bold text-warning">
                                            Cicilan ke-{{ $cicilan_aktif->bulan_ke }} belum dibayar
                                        </h6>
                                        <p class="text-muted mb-2">
                                            Jumlah tagihan: <strong>Rp
                                                {{ number_format($cicilan_aktif->jumlah, 0, ',', '.') }}</strong>
                                        </p>
                                        <small class="text-muted d-block">
                                            Jatuh tempo:
                                            {{ \Carbon\Carbon::parse($cicilan_aktif->tanggal_jatuh_tempo)->format('d M Y') }}
                                        </small>

                                        <div class="d-grid mt-4">
                                            <a href="{{ route('cicilan.pelunasan', $cicilan_aktif->id) }}" class="btn btn-primary">
                                                <i class="fas fa-credit-card me-2"></i>Bayar Sekarang
                                            </a>
                                        </div>
                                    </div>
                                @else
                                    <div class="text-center py-4">
                                        <i class="fas fa-check-circle text-success mb-3" style="font-size: 3rem;"></i>
                                        <h6 class="fw-bold text-success">Kamu telah membayar semua tagihan 🎉</h6>
                                        <p class="text-muted mb-0">Tidak ada cicilan yang belum dibayar.</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Riwayat Pembayaran --}}
                    <div class="col-md-6">
                        <div class="card shadow-sm h-100">
                            <div class="card-header bg-white pt-3">
                                <h5 class="mb-0 text-dark">Riwayat Pembayaran</h5>
                            </div>
                            <div class="card-body p-0">
                                <ul class="list-group list-group-flush">
                                    @forelse($cicilan->where('status','paid')->sortByDesc('bulan_ke') as $item)
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <div>
                                                <h6 class="mb-1">Cicilan ke-{{ $item->bulan_ke }}</h6>
                                                <small class="text-muted">
                                                    Dibayar:
                                                    {{ \Carbon\Carbon::parse($item->tanggal_dibayar)->format('d M Y') }}
                                                </small>
                                            </div>
                                            <span class="text-success fw-bold">
                                                Rp {{ number_format($item->jumlah, 0, ',', '.') }}
                                            </span>
                                        </li>
                                    @empty
                                        <li class="list-group-item text-center text-muted">Belum ada pembayaran</li>
                                    @endforelse
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Semua Transaksi --}}
                <div class="card shadow-sm mt-4">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Transaksi Anda</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table mb-0 table-sm">
                                <thead class="table-light">
                                    <tr>
                                        <th>Bulan</th>
                                        <th>Jumlah</th>
                                        <th>Status</th>
                                        <th>Jatuh Tempo</th>
                                        <th>Tanggal Bayar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($cicilan as $item)
                                        <tr>
                                            <td>Cicilan ke-{{ $item->bulan_ke }}</td>
                                            <td>Rp {{ number_format($item->jumlah, 0, ',', '.') }}</td>
                                            <td>
                                                @if ($item->status == 'paid')
                                                    <span class="badge bg-success">Lunas</span>
                                                @elseif($item->status == 'pending')
                                                    <span class="badge bg-warning">Belum Bayar</span>
                                                @else
                                                    <span class="badge bg-danger">Terlambat</span>
                                                @endif
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($item->tanggal_jatuh_tempo)->format('d M Y') }}
                                            </td>
                                            <td>
                                                {{ $item->tanggal_dibayar ? \Carbon\Carbon::parse($item->tanggal_dibayar)->format('d M Y') : '-' }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- CSS Khusus Mobile --}}
    <style>
        @media (max-width: 767px) {
            h4 {
                font-size: 1.2rem;
            }

            .card h5,
            .card h6 {
                font-size: 1rem;
            }

            .table th,
            .table td {
                font-size: 0.8rem;
                padding: 0.5rem;
            }
        }
    </style>
@endsection
