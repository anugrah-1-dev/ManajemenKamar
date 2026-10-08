@extends('adminlte::page')

@section('title', 'Activity Log')

@section('content_header')
    <h1>Activity Log</h1>
@endsection

@section('content')
    <x-adminlte-card title="Riwayat Aktivitas Sistem" theme="info" icon="fas fa-history">
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover mb-0">
                <thead class="thead-dark">
                    <tr>
                        <th>Waktu</th>
                        <th>User</th>
                        <th>Aktivitas</th>
                        <th>Deskripsi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($activityLogs as $log)
                        <tr>
                            <td style="white-space: nowrap;">{{ $log->created_at->format('d M Y, H:i') }}</td>
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
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">Belum ada riwayat aktivitas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3 d-flex justify-content-end">
            {{ $activityLogs->links() }}
        </div>
    </x-adminlte-card>
@endsection