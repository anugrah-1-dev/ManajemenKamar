<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deutsch Brilliant - Kursus Bahasa Jerman</title>
    {{-- Link ke CSS --}}
    <link rel="stylesheet" href="{{ asset('css/jermanlandingpage.css') }}">
    {{-- Link ke Library Animasi AOS --}}
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    {{-- Link Font Awesome untuk Ikon (Opsional, tapi sangat direkomendasikan) --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>
    {{-- Navbar selalu muncul --}}
    @include('navbar.nav')

    {{-- Hero Section --}}
    <section class="hero">
        <div class="carousel">
            <div class="slides">
                <div class="slide active">

                    <img src="{{ asset('asset/img/brilliant1.jpg') }}" alt="Belajar Bahasa Jerman di Berlin">
                </div>
                <div class="slide">
                    <img src="{{ asset('asset/img/brilliant2.jpg') }}" alt="Kelas Bahasa Jerman yang Interaktif">
                </div>
                <div class="slide">
                    <img src="{{ asset('asset/img/brilliant3.jpg') }}" alt="Pemandangan Kastil Jerman">

                    <img src="{{ asset('asset/img/brilliantclass6.jpg') }}" alt="Belajar Bahasa Jerman di Berlin">
                </div>
                <div class="slide">
                    <img src="{{ asset('asset/img/brilliantclass7.jpg') }}" alt="Kelas Bahasa Jerman yang Interaktif">
                </div>
                <div class="slide">
                    <img src="{{ asset('asset/img/brilliantcourse8.jpg') }}" alt="Pemandangan Kastil Jerman">

                </div>
            </div>
            <button class="prev">&#10094;</button>
            <button class="next">&#10095;</button>
        </div>
        <div class="hero-text">
            <h1>BRILLIANT DEUTSCHE SPARCHE</h1>
            <p>Kuasai bahasa Jerman dengan metode interaktif dan pengajar berpengalaman.</p>
            <a href="#program" class="cta-button">Lihat Program Kami</a>
        </div>
    </section>
    <section class="program-section bg-light py-5" id="program">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <h2>PILIHAN PROGRAM DEUTSCH</h2>
                <p class="lead text-muted">Temukan program yang paling sesuai dengan tujuan Anda.</p>
            </div>

            <div class="filter-buttons-wrapper text-center mb-4" data-aos="fade-up" data-aos-delay="100">
                <button class="filter-btn active" data-filter="offline">Program Offline</button>
                <button class="filter-btn" data-filter="online">Program Online</button>
            </div>

            <div class="program-grid">
                @forelse ($offlinePrograms as $index => $program)
                    <div class="program-item offline" data-aos="fade-up" data-aos-delay="{{ 100 * ($index + 1) }}">
                        <div class="program-card">
                            <div class="program-card-image-wrapper">
                                <img src="{{ asset('storage/' . $program->thumbnail) }}" class="program-card-img"
                                    alt="{{ $program->nama }}">
                                @if ($program->is_active)
                                    <span class="badge bg-success program-badge">Tersedia</span>
                                @endif
                            </div>
                            <div class="card-body">
                                <h5 class="card-title program-card-title">{{ $program->nama }}</h5>
                                <p class="card-text text-muted small mb-2">
                                    <i class="fas fa-calendar-alt me-1"></i>
                                    {{ \Carbon\Carbon::parse($program->jadwal_mulai)->format('d M') }} -
                                    {{ \Carbon\Carbon::parse($program->jadwal_selesai)->format('d M, Y') }}
                                </p>
                                <p class="card-text program-card-price mb-3">
                                    Rp {{ number_format($program->harga, 0, ',', '.') }}
                                </p>
                                @php
                                $features = $program->features_program;
                                if (is_string($features)) {
                                    $decoded = json_decode($features, true);
                                    $features = json_last_error() === JSON_ERROR_NONE && is_array($decoded)
                                        ? $decoded
                                        : explode("\n", $features);
                                }
                            @endphp
                            
                            @if (!empty($features) && is_array($features))
                                {{-- Tambahkan text-align: left; di sini --}}
                                <ul class="small mb-2" style="list-style: none; padding-left: 0; text-align: left;">
                                    @foreach (array_slice($features, 0, 4) as $fitur)
                                        <li>
                                            {!! \App\Helpers\FeatureHelper::getFeatureIcon($fitur) !!}
                                            {{ trim($fitur) }}
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <small class="text-muted">Tidak ada fasilitas tersedia</small>
                            @endif
                        
                                <a href="{{ route('public.program.offline.show', $program->slug) }}"
                                    class="btn btn-primary mt-auto">Lihat Detail</a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="program-item offline">
                        <p class="text-muted">Belum ada program offline yang tersedia.</p>
                    </div>
                @endforelse

                @forelse ($onlinePrograms as $index => $program)
                    <div class="program-item online" data-aos="fade-up" data-aos-delay="{{ 100 * ($index + 1) }}">
                        <div class="program-card">
                            <div class="program-card-image-wrapper">
                                <img src="{{ asset('storage/' . $program->thumbnail) }}" class="program-card-img"
                                    alt="{{ $program->nama }}">
                                @if ($program->is_active)
                                    <span class="badge bg-success program-badge">Tersedia</span>
                                @endif
                            </div>
                            <div class="card-body">
                                <h5 class="card-title program-card-title">{{ $program->nama }}</h5>
                                <p class="card-text text-muted small mb-2">
                                    <i class="fas fa-tag me-1"></i>
                                    Level: {{ $program->kategori ?? '-' }}
                                </p>
                                <p class="card-text program-card-price mb-3">
                                    Rp {{ number_format($program->harga, 0, ',', '.') }}
                                </p>
                                @php
                                $features = $program->features_program;
                                if (is_string($features)) {
                                    $decoded = json_decode($features, true);
                                    $features = json_last_error() === JSON_ERROR_NONE && is_array($decoded)
                                        ? $decoded
                                        : explode("\n", $features);
                                }
                            @endphp
                            
                            @if (!empty($features) && is_array($features))
                                {{-- Tambahkan text-align: left; di sini --}}
                                <ul class="small mb-2" style="list-style: none; padding-left: 0; text-align: left;">
                                    @foreach (array_slice($features, 0, 4) as $fitur)
                                        <li>
                                            {!! \App\Helpers\FeatureHelper::getFeatureIcon($fitur) !!}
                                            {{ trim($fitur) }}
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <small class="text-muted">Tidak ada fasilitas tersedia</small>
                            @endif
                                <a href="{{ route('public.program.online.show', $program->slug) }}"
                                    class="btn btn-danger mt-auto">Lihat Detail</a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="program-item online">
                        <p class="text-muted">Belum ada program online yang tersedia.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const filterButtons = document.querySelectorAll('.filter-btn');
            const programItems = document.querySelectorAll('.program-item');

            // Show offline programs by default
            document.querySelector('.filter-btn[data-filter="offline"]').classList.add('active');
            document.querySelectorAll('.program-item.offline').forEach(item => {
                item.style.display = 'block';
            });

            // Filter functionality
            filterButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const filterValue = this.getAttribute('data-filter');

                    // Update active button
                    filterButtons.forEach(btn => btn.classList.remove('active'));
                    this.classList.add('active');

                    // Show/hide programs
                    programItems.forEach(item => {
                        if (item.classList.contains(filterValue)) {
                            item.style.display = 'block';
                        } else {
                            item.style.display = 'none';
                        }
                    });
                });
            });
        });
    </script>
    {{-- About Section --}}
    <section class="about" id="tentang">
        <div class="container" data-aos="fade-up">
            <h2>Mengapa Memilih Kami?</h2>
            <p>
                Di <strong>Deutsch Brilliant</strong>, kami percaya bahwa belajar bahasa adalah sebuah petualangan.
                Kami menggabungkan metode pengajaran <span class="highlight">terbaik</span>
                dengan teknologi untuk menciptakan pengalaman belajar yang tak terlupakan dan efektif bagi Anda.
            </p>
            <div class="about-grid">
                <div class="about-card" data-aos="fade-up" data-aos-delay="100">
                    <div class="icon-wrapper"><i class="fas fa-rocket"></i></div>
                    <h3>Kurikulum Modern</h3>
                    <p>Materi pembelajaran yang relevan dan selalu diperbarui sesuai standar CEFR (Common European
                        Framework of Reference for Languages).</p>
                </div>
                <div class="about-card" data-aos="fade-up" data-aos-delay="200">
                    <div class="icon-wrapper"><i class="fas fa-user-tie"></i></div>
                    <h3>Pengajar Profesional</h3>
                    <p>Instruktur kami adalah penutur asli atau bersertifikasi dengan pengalaman mengajar yang luas dan
                        penuh semangat.</p>
                </div>
                <div class="about-card" data-aos="fade-up" data-aos-delay="300">
                    <div class="icon-wrapper"><i class="fas fa-users"></i></div>
                    <h3>Komunitas Belajar</h3>
                    <p>Bergabunglah dengan komunitas yang suportif, tempat Anda bisa berlatih dan bertumbuh bersama
                        teman-teman baru.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Wave Divider 1 --}}
    <div class="wave-divider">
        <svg viewBox="0 0 1440 320" preserveAspectRatio="none">
            <path class="shape-fill"
                d="M0,224L48,208C96,192,192,160,288,154.7C384,149,480,171,576,186.7C672,203,768,213,864,197.3C960,181,1056,139,1152,122.7C1248,107,1344,117,1392,122.7L1440,128L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z">
            </path>
        </svg>
    </div>

    {{-- Alur Pendaftaran Section --}}
    <section class="alur" id="alur">
        <div class="container" data-aos="fade-up">
            <h2>Alur Pendaftaran Mudah</h2>
            <p>Hanya dalam 5 langkah, Anda siap memulai petualangan belajar Bahasa Jerman Anda!</p>
            <div class="alur-timeline">
                <div class="step" data-aos="fade-up" data-aos-delay="50">
                    <div class="circle">1</div>
                    <h3>Isi Formulir</h3>
                    <p>Lengkapi data diri Anda pada formulir online yang kami sediakan.</p>
                </div>
                <div class="step" data-aos="fade-up" data-aos-delay="150">
                    <div class="circle">2</div>
                    <h3>Konfirmasi Tim</h3>
                    <p>Tim kami akan segera menghubungi Anda untuk verifikasi data.</p>
                </div>
                <div class="step" data-aos="fade-up" data-aos-delay="250">
                    <div class="circle">3</div>
                    <h3>Lakukan Pembayaran</h3>
                    <p>Selesaikan pembayaran melalui metode yang Anda pilih.</p>
                </div>
                <div class="step" data-aos="fade-up" data-aos-delay="350">
                    <div class="circle">4</div>
                    <h3>Daftar Ulang</h3>
                    <p>Kunjungi admin kami di kantor untuk proses daftar ulang final.</p>
                </div>
                <div class="step" data-aos="fade-up" data-aos-delay="450">
                    <div class="circle">5</div>
                    <h3>Selamat Belajar!</h3>
                    <p>Anda resmi menjadi bagian dari Deutsch Brilliant. Viel Erfolg!</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Wave Divider 2 (dibalik) --}}
    <!-- <div class="wave-divider wave-flipped">
        <svg viewBox="0 0 1440 320" preserveAspectRatio="none">
            <path class="shape-fill" d="M0,224L48,208C96,192,192,160,288,154.7C384,149,480,171,576,186.7C672,203,768,213,864,197.3C960,181,1056,139,1152,122.7C1248,107,1344,117,1392,122.7L1440,128L1440,0L1392,0C1344,0,1248,0,1152,0C1056,0,960,0,864,0C768,0,672,0,576,0C480,0,384,0,288,0C192,0,96,0,48,0L0,0Z"></path>
        </svg>
    </div> -->
    <!-- Program ini -->



    {{-- Footer Section --}}
    
    <footer class="footer text-center">
        <p>© 2025 Deutsch Brilliant | Kursus Bahasa Jerman</p>
    </footer>
    <style>
    .footer {
        background-color: rgb(0, 0, 0);
        color: white;
        padding: 15px 0;
        bottom: 0;
        left: 0;
        width: 100%;
        font-size: 14px;
        text-align: center;
    }
    </style>

    {{-- Script untuk Carousel --}}
    <script>
        const slides = document.querySelectorAll(".slide");
        const prevBtn = document.querySelector(".prev");
        const nextBtn = document.querySelector(".next");
        let current = 0;

        function showSlide(index) {
            slides.forEach((s, i) => s.classList.toggle("active", i === index));
        }

        function nextSlide() {
            current = (current + 1) % slides.length;
            showSlide(current);
        }

        nextBtn.addEventListener("click", nextSlide);

        prevBtn.addEventListener("click", () => {
            current = (current - 1 + slides.length) % slides.length;
            showSlide(current);
        });

        // Auto-slide
        setInterval(nextSlide, 5000);
    </script>

    {{-- Script untuk Inisialisasi AOS --}}
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 800, // Durasi animasi
            once: true,    // Animasi hanya berjalan sekali
        });
    </script>

</body>

</html>