    @extends('adminlte::page')

    @section('title', 'Dashboard')

    @section('content_header')
        <h1>Dashboard Admin</h1>
    @endsection

    @section('content')
        {{-- Ringkasan --}}
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4 mt-4">
            <div class="col">
                <x-adminlte-info-box title="Kursus Terjual" :text="$totalKursus" icon="fas fa-shopping-cart" theme="success" />
            </div>
            <div class="col">
                <x-adminlte-info-box title="Keuntungan" :text="'Rp ' . number_format($totalKeuntungan, 0, ',', '.')"
                    icon="fas fa-money-bill" theme="warning" />
            </div>
            <div class="col">
                <x-adminlte-info-box title="Media Sosial" :text="$totalMediaSosial . ' Upload'" icon="fas fa-photo-video"
                    theme="primary" />
            </div>
        </div>

        {{-- Grafik --}}
        <div class="row mt-4">
            <div class="col-md-6">
                <x-adminlte-card title="Keuntungan Bulanan" theme="info" icon="fas fa-chart-line">
                    <canvas id="profitChart" height="180"></canvas>
                </x-adminlte-card>
            </div>
            <div class="col-md-6">
                <x-adminlte-card title="Penjualan Kursus" theme="success" icon="fas fa-chart-bar">
                    <canvas id="salesChart" height="180"></canvas>
                </x-adminlte-card>
            </div>
        </div>
        <div class="card shadow-sm">
            <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0 text-white">Data Stok Kamar</h5>
    
                {{-- Filter Form --}}
                <form method="GET" class="d-flex align-items-center" style="gap: 0.5rem;">
                    <select name="program_camp_nama" class="form-control form-control-sm" required>
                        <option value="" disabled {{ !request('program_camp_nama') ? 'selected' : '' }}>-- Pilih Program Camp --</option>
                        @foreach ($programCamps as $program)
                            <option value="{{ $program->nama }}" {{ request('program_camp_nama') == $program->nama ? 'selected' : '' }}>
                                {{ $program->nama }}
                            </option>
                        @endforeach
                    </select>
    
                    <select name="gender" class="form-control form-control-sm" required>
                        <option value="" disabled {{ !request('gender') ? 'selected' : '' }}>-- Pilih Gender --</option>
                        <option value="putra" {{ request('gender') == 'putra' ? 'selected' : '' }}>Putra</option>
                        <option value="putri" {{ request('gender') == 'putri' ? 'selected' : '' }}>Putri</option>
                    </select>
    
                    <button type="submit" class="btn btn-orange btn-sm" id="filterBtn" style="white-space: nowrap;">
                        <span id="btnText">Filter</span>
                        <span id="btnSpinner" class="spinner-border spinner-border-sm ms-2 d-none" role="status" aria-hidden="true"></span>
                    </button>
                </form>
            </div>
    
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped mb-0">
                        <thead class="table-primary">
                            <tr>
                                <th>Nama Program</th>
                                <th>Nomor Kamar</th>
                                <th>Ketersediaan</th>
                                <th>Gender</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($stokData as $stok)
                                <tr>
                                    <td>{{ $stok['program'] }}</td>
                                    <td>{{ $stok['nama_kamar'] }}</td>
                                    <td>{{ $stok['stok'] }}</td>
                                    <td>{{ ucfirst($stok['gender']) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    
    
        {{-- Grafik Stok --}}
        {{-- Galeri Media Sosial --}}
        <div class="row mt-4 justify-content-center">
            <div class="col-12">
                <x-adminlte-card title="Galeri Media Sosial" theme="light" icon="fas fa-photo-video">
                    <div class="d-flex flex-wrap justify-content-center align-items-center gap-3">
                        @foreach ($sosmedList as $sosmed)
                            @php
                                // Ambil ID video dari URL YouTube
                                // Deteksi ID YouTube secara langsung (tanpa mendefinisikan fungsi)
                                preg_match('/(?:youtu\.be\/|youtube\.com\/(?:watch\?v=|embed\/|shorts\/))([^\?\&]+)/', $sosmed->url, $matches);

                                $youtubeId = $matches[1] ?? null;
                                $isYoutube = $youtubeId !== null;

                                $imgSrc = $isYoutube
                                    ? "https://img.youtube.com/vi/{$youtubeId}/hqdefault.jpg"
                                    : ($sosmed->image_path ? asset('storage/' . $sosmed->image_path) : 'https://via.placeholder.com/100x100?text=No+Image');
                            @endphp

                            <div class="d-flex flex-column align-items-center m-2">
                                <a href="{{ $sosmed->url }}" target="_blank">
                                    <img src="{{ $imgSrc }}" class="shadow"
                                        style="width: 100px; height: 100px; object-fit: cover; border-radius: 16px;"
                                        alt="{{ $sosmed->nama }}">
                                </a>
                                <small class="mt-2 text-muted">
                                    <i class="fas fa-link"></i> {{ $sosmed->nama }}
                                </small>
                            </div>
                        @endforeach
                    </div>
                </x-adminlte-card>
            </div>
        </div>

    @endsection


    @section('css')
        <style>
            .gap-2 {
                gap: 0.5rem;
            }

            @media (max-width: 768px) {
                canvas {
                    max-width: 100%;
                }
            }
        </style>
    @endsection

    @section('js')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            // Data dari Controller
            const monthlyProfit = @json($monthlyProfit);
            const salesData = @json($salesData);

            // Profit Chart
            const ctxProfit = document.getElementById('profitChart').getContext('2d');
            const colors = ['#17a2b8', '#28a745', '#ffc107', '#dc3545', '#6f42c1']; // Tambah jika perlu
            const monthLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];

            const datasets = Object.entries(monthlyProfit).map(([year, data], index) => ({
                label: `Tahun ${year}`,
                data: Object.values(data),
                borderColor: colors[index % colors.length],
                backgroundColor: colors[index % colors.length] + '33', // transparan
                fill: false,
                tension: 0.4
            }));

            new Chart(ctxProfit, {
                type: 'line',
                data: {
                    labels: monthLabels,
                    datasets: datasets
                },
                options: {
                    responsive: true,
                    plugins: {
                        title: {
                            display: true,
                            text: 'Keuntungan Bulanan per Tahun'
                        },
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });


            // Sales Chart
            new Chart(document.getElementById('salesChart'), {
                type: 'bar',
                data: {
                    labels: Object.keys(salesData),
                    datasets: [{
                        label: 'Total Penjualan Berdasarkan Kuota',
                        data: Object.values(salesData),
                        backgroundColor: ['#007bff', '#28a745']
                    }]
                }
            });

            console.log('Dashboard dengan data real dimuat.');
        </script>
        <script>
            const form = document.querySelector('form');
            const filterBtn = document.getElementById('filterBtn');
            const btnText = document.getElementById('btnText');
            const btnSpinner = document.getElementById('btnSpinner');
          
            form.addEventListener('submit', function(e) {
              // Disable tombol dan show spinner
              filterBtn.disabled = true;
              btnText.textContent = 'Loading...';
              btnSpinner.classList.remove('d-none');
            });
          </script>
          
        <style>
            /* Warna biru tua untuk header card */
            .card-header.bg-primary {
                background-color: #0d3b66 !important; /* biru tua */
                color: white;
            }
        
            /* Warna biru muda pudar untuk header tabel */
            .table-primary {
                background-color: #74a9d8 !important; /* biru muda pudar */
                color: #0d3b66;
            }
        
            /* Warna orange untuk baris tabel ganjil */
            .table-striped > tbody > tr:nth-of-type(odd) {
                background-color: #ffd8b1; /* orange pudar */
            }
        
            /* Hover efek oranye lebih gelap */
            .table-striped > tbody > tr:hover {
                background-color: #ffa726 !important; /* orange cerah */
                color: #fff;
            }
        
            /* Button filter warna orange */
            .btn-orange {
                background-color: #f57c00;
                border-color: #f57c00;
                color: white;
            }
        
            .btn-orange:hover {
                background-color: #ef6c00;
                border-color: #ef6c00;
                color: white;
            }
            .spinner-border {
            transition: opacity 0.3s ease;
            }
        </style>
        
    @endsection
