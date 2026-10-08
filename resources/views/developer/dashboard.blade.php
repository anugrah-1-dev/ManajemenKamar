@extends('adminlte::page')

@section('title', 'Dashboard Developer')

@section('content_header')
    <h1>Dashboard Developer</h1>
@endsection

@section('content')
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-4 mt-4">
        <div class="col">
            <x-adminlte-info-box title="Total Kamar" :text="$totalRooms" icon="fas fa-bed" theme="primary" />
        </div>
        <div class="col">
            <x-adminlte-info-box title="Kamar Aktif" :text="$activeRooms" icon="fas fa-check-circle" theme="success" />
        </div>
        <div class="col">
            <x-adminlte-info-box title="Total Penghuni" :text="$totalOccupied" icon="fas fa-users" theme="warning" />
        </div>
        <div class="col">
            <x-adminlte-info-box title="Total Activity Log" :text="$totalLogs" icon="fas fa-history" theme="info" />
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-6">
            <x-adminlte-card title="Manajemen Kamar" theme="primary" icon="fas fa-bed">
                <a href="{{ route('developer.rooms.index') }}" class="btn btn-primary">
                    <i class="fas fa-bed"></i> Buka Manajemen Kamar
                </a>
                <a href="{{ route('developer.rooms.create') }}" class="btn btn-success">
                    <i class="fas fa-plus"></i> Tambah Kamar
                </a>
            </x-adminlte-card>
        </div>
        <div class="col-md-6">
            <x-adminlte-card title="Activity Log" theme="info" icon="fas fa-history">
                <a href="{{ route('developer.activity-logs.index') }}" class="btn btn-info">
                    <i class="fas fa-history"></i> Lihat Riwayat Aktivitas
                </a>
            </x-adminlte-card>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12">
            <x-adminlte-card title="Aktivitas Terbaru" theme="secondary" icon="fas fa-clock">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped mb-0">
                        <thead class="thead-dark">
                            <tr>
                                <th>#</th>
                                <th>User</th>
                                <th>Aktivitas</th>
                                <th>Deskripsi</th>
                                <th>Waktu</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($recentLogs as $index => $log)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $log->user->name ?? 'System' }}</td>
                                    <td>
                                        @if ($log->action === 'CREATE')
                                            <span class="badge bg-success">CREATE</span>
                                        @elseif ($log->action === 'UPDATE')
                                            <span class="badge bg-primary">UPDATE</span>
                                        @elseif ($log->action === 'DELETE')
                                            <span class="badge bg-danger">DELETE</span>
                                        @else
                                            <span class="badge bg-secondary">{{ $log->action }}</span>
                                        @endif
                                    </td>
                                    <td>{{ $log->description }}</td>
                                    <td>{{ $log->created_at->format('d M Y, H:i') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted">Belum ada aktivitas.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </x-adminlte-card>
        </div>
    </div>
@endsection