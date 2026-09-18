@extends('adminlte::page')

@section('title', 'Detail Pendaftaran Offline')

@section('content_header')
    <h1 class="m-0 text-dark">Detail Pendaftaran Offline</h1>
@stop

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            {{-- Informasi Peserta --}}
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-user-graduate mr-2"></i>
                        Data Peserta
                    </h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="info-box bg-light">
                                <span class="info-box-icon"><i class="fas fa-user text-primary"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Nama Lengkap</span>
                                    <span class="info-box-number">{{ $pendaftaran->nama_lengkap }}</span>
                                </div>
                            </div>
                            <div class="info-box bg-light">
                                <span class="info-box-icon"><i class="fas fa-phone text-primary"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">WhatsApp</span>
                                    <span class="info-box-number">{{ $pendaftaran->no_hp }}</span>
                                </div>
                            </div>
                            <div class="info-box bg-light">
                                <span class="info-box-icon"><i class="fas fa-envelope text-primary"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Email</span>
                                    <span class="info-box-number">{{ $pendaftaran->email }}</span>
                                </div>
                            </div>
                            <div class="info-box bg-light">
                                <span class="info-box-icon"><i class="fas fa-venus-mars text-primary"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Gender</span>
                                    <span class="info-box-number">{{ $pendaftaran->gender }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-box bg-light">
                                <span class="info-box-icon"><i class="fas fa-users text-primary"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">No Wali (WA)</span>
                                    <span class="info-box-number">{{ $pendaftaran->no_wali }}</span>
                                </div>
                            </div>
                            <div class="info-box bg-light">
                                <span class="info-box-icon"><i class="fas fa-book text-primary"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Program</span>
                                    <span class="info-box-number">{{ $pendaftaran->program?->nama ?? '-' }}</span>
                                </div>
                            </div>
                            <div class="info-box bg-light">
                                <span class="info-box-icon"><i class="fas fa-credit-card text-primary"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Metode Pembayaran</span>
                                    <span class="info-box-number">{{ ucfirst($pendaftaran->payment_method) }}</span>
                                </div>
                            </div>
                            <div class="info-box bg-light">
                                <span class="info-box-icon"><i class="fas fa-money-bill-wave text-primary"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">DP Amount</span>
                                    <span class="info-box-number">Rp {{ number_format($pendaftaran->dp_amount, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Cicilan Program Offline --}}
            <div class="card card-secondary card-outline">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-money-check-alt mr-2"></i>
                        Cicilan Program Offline
                    </h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered table-striped mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th class="align-middle">Bulan</th>
                                    <th class="align-middle">Jumlah</th>
                                    <th class="align-middle">Status</th>
                                    <th class="align-middle">Jatuh Tempo</th>
                                    <th class="align-middle">Tanggal Bayar</th>
                                    <th class="align-middle">Metode Pembayaran</th>
                                    <th class="align-middle text-center">Bukti Pembayaran</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pendaftaran->cicilan as $item)
                                    <tr>
                                        <td class="align-middle">Cicilan ke-{{ $item->bulan_ke }}</td>
                                        <td class="align-middle">Rp {{ number_format($item->jumlah, 0, ',', '.') }}</td>
                                        <td class="align-middle">
                                            @if ($item->status == 'paid')
                                                <span class="badge bg-success p-2"><i class="fas fa-check-circle mr-1"></i> Lunas</span>
                                            @elseif($item->status == 'pending')
                                                <span class="badge bg-warning p-2"><i class="fas fa-clock mr-1"></i> Belum Bayar</span>
                                            @else
                                                <span class="badge bg-danger p-2"><i class="fas fa-times-circle mr-1"></i> Terlambat</span>
                                            @endif
                                        </td>
                                        <td class="align-middle">{{ \Carbon\Carbon::parse($item->tanggal_jatuh_tempo)->format('d M Y') }}</td>
                                        <td class="align-middle">
                                            {{ $item->tanggal_dibayar ? \Carbon\Carbon::parse($item->tanggal_dibayar)->format('d M Y') : '-' }}
                                        </td>
                                        <td class="align-middle">{{ ucfirst($item->metode_pembayaran ?? '-') }}</td>
                                        <td class="align-middle text-center">
                                            @if ($item->bukti_pembayaran)
                                                <a href="{{ asset('storage/'.$item->bukti_pembayaran) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-file-image mr-1"></i> Lihat
                                                </a>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-muted py-4">
                                            <i class="fas fa-info-circle mr-2"></i> Belum ada cicilan
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if($pendaftaran->cicilan->isNotEmpty())
                <div class="card-footer clearfix">
                    <div class="row">
                        <div class="col-md-6">
                            <strong>Total Cicilan: {{ $pendaftaran->cicilan->count() }}</strong>
                        </div>
                        <div class="col-md-6 text-right">
                            @php
                                $totalPaid = $pendaftaran->cicilan->where('status', 'paid')->count();
                                $percentage = $pendaftaran->cicilan->count() > 0 ? ($totalPaid / $pendaftaran->cicilan->count()) * 100 : 0;
                            @endphp
                            <small class="text-muted">Progress: {{ number_format($percentage, 0) }}% lengkap</small>
                            <div class="progress progress-sm mt-1">
                                <div class="progress-bar bg-success" style="width: {{ $percentage }}%"></div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@stop

@section('css')
    <style>
        .info-box {
            box-shadow: 0 0 1px rgba(0,0,0,.125), 0 1px 3px rgba(0,0,0,.2);
            border-radius: .25rem;
            margin-bottom: 1rem;
            min-height: 80px;
        }
        .info-box-icon {
            border-top-left-radius: .25rem;
            border-bottom-left-radius: .25rem;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 70px;
            font-size: 1.875rem;
        }
        .table th {
            border-top: none;
        }
        .card-outline {
            border-top: 3px solid;
        }
        .card-primary.card-outline {
            border-top-color: #007bff;
        }
        .card-secondary.card-outline {
            border-top-color: #6c757d;
        }
    </style>
@stop

@section('js')
    <script>
        $(document).ready(function() {
            console.log("Halaman detail pendaftaran offline siap!");

            // Inisialisasi tooltip
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
@stop
