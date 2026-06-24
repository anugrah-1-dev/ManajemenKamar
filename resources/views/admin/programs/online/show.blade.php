<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>{{ $program->nama }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f0f2f5;
            font-family: 'Segoe UI', sans-serif;
        }

        .program-detail {
            max-width: 800px;
            margin: 50px auto;
            background: #fff;
            border-radius: 12px;
            padding: 35px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }

        .program-title {
            text-align: center;
            margin-bottom: 25px;
        }

        .program-title h1 {
            font-size: 2rem;
            font-weight: 700;
            color: #333;
        }

        .program-img {
            text-align: center;
            margin-bottom: 25px;
        }

        .program-img img {
            max-width: 100%;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .program-section {
            margin-bottom: 25px;
        }

        .program-section h4 {
            font-size: 1.2rem;
            margin-bottom: 12px;
            color: #333;
            border-bottom: 2px solid #ffa500;
            padding-bottom: 6px;
        }

        .badge {
            font-size: 0.9rem;
        }

        .btn-back {
            display: block;
            width: 100%;
            text-align: center;
            margin-top: 30px;
        }

        .table-custom {
            width: 100%;
            border-collapse: collapse;
        }

        .table-custom th,
        .table-custom td {
            border: 1px solid #ffa500;
            padding: 12px 16px;
            font-size: 0.95rem;
        }

        .table-custom th {
            background-color: #fff3e0;
            color: #333;
            font-weight: 600;
        }

        .table-custom td {
            background-color: #fff;
            color: #333;
        }

        ul {
            padding-left: 20px;
        }

        ul li {
            font-size: 0.95rem;
            margin-bottom: 6px;
        }

        p {
            font-size: 0.95rem;
            line-height: 1.6;
        }
    </style>
</head>

<body>

    <div class="program-detail">
        <div class="program-title">
            <h1>{{ $program->nama }}</h1>
        </div>

        @if ($program->thumbnail)
            <div class="program-img">
                <img src="{{ asset('storage/' . $program->thumbnail) }}" alt="{{ $program->nama }}">
            </div>
        @endif

        <div class="program-section">
            <h4>Informasi Program</h4>
            <table class="table-custom">
                <tr>
                    <th>Harga</th>
                    <td>Rp {{ number_format($program->harga, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <th>Jadwal</th>
                    <td>
                        {{ \Carbon\Carbon::parse($program->jadwal_mulai)->format('d M Y') }} -
                        {{ \Carbon\Carbon::parse($program->jadwal_selesai)->format('d M Y') }}
                    </td>
                </tr>
                <tr>
                    <th>Fasilitas</th>
                    <td>
                        @if (is_string($program->features_program) && !empty($program->features_program))
                            <ul style="padding-left: 18px; margin-bottom: 0;">
                                @foreach (explode("\n", $program->features_program) as $feature)
                                    <li>{{ $feature }}</li>
                                @endforeach
                            </ul>
                        @elseif (is_array($program->features_program) && count($program->features_program) > 0)
                            <ul style="padding-left: 18px; margin-bottom: 0;">
                                @foreach ($program->features_program as $feature)
                                    <li>{{ $feature }}</li>
                                @endforeach
                            </ul>
                        @else
                            <em>Tidak ada fasilitas tersedia.</em>
                        @endif
                    </td>
                </tr>

                <tr>
                    <th>Status</th>
                    <td>
                        @if ($program->is_active)
                            <span class="badge bg-success">Aktif</span>
                        @else
                            <span class="badge bg-danger">Tidak Aktif</span>
                        @endif
                    </td>
                </tr>
            </table>
        </div>

        <a href="{{ url('/') }}" class="btn btn-primary btn-back">⬅ Kembali ke Beranda</a>
    </div>

</body>

</html>

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
