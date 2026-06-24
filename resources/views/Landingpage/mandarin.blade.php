<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mandarin Center Pare</title>
    <link rel="stylesheet" href="{{ asset('css/mandarinlandingpage.css') }}">
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"> --}}
    {{-- PENAMBAHAN: Pastikan link CSS untuk AOS sudah ada (di kode Anda sudah ada) --}}
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
</head>

<body>
    @include('navbar.nav')
    <section class="hero">
        <div class="carousel">
            <div class="slides">
                <div class="slide active">
                    <img src={{ asset('asset/img/mandarin1.jpg') }} alt="Belajar Bahasa Mandarin 1">
                </div>
                <div class="slide">
                    <img src={{ asset('asset/img/mandarin1.jpg') }} alt="Belajar Bahasa Mandarin 2">
                </div>
                <div class="slide">
                    <img src={{ asset('asset/img/brilliant2.jpg') }} alt="Belajar Bahasa Mandarin 3">
                </div>
                <div class="slide">
                    <img src={{ asset('asset/img/brilliant3.jpg') }} alt="Belajar Bahasa Mandarin 4">
                    <img src={{ asset('asset/img/brilliantclass4.jpg') }} alt="Belajar Bahasa Mandarin 1">
                </div>
                <div class="slide">
                    <img src={{ asset('asset/img/brilliantclass5.jpg') }} alt="Belajar Bahasa Mandarin 2">
                </div>
                <div class="slide">
                    <img src={{ asset('asset/img/brilliantclass3.jpg') }} alt="Belajar Bahasa Mandarin 3">
                </div>
            </div>
            <button class="prev">&#10094;</button>
            <button class="next">&#10095;</button>
        </div>

        <div class="hero-text">
            {{-- PENAMBAHAN: Atribut data-aos untuk animasi pada teks hero --}}
            <h1 data-aos="fade-up">MANDARIN CENTER PARE</h1>
            <h2 data-aos="fade-up" data-aos-delay="100">(Kursus Bahasa Mandarin)</h2>
            <p data-aos="fade-up" data-aos-delay="200">Kuasai bahasa Mandarin dengan metode interaktif dan pengajar berpengalaman.</p>
        </div>
    </section>

    <section class="program-section bg-light py-5" id="program">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <h2>PROGRAM MANDARIN CENTER PARE</h2>
                <p class="lead text-muted">Temukan program yang sesuai dengan tujuan Anda.</p>
            </div>
            {{-- Tombol Filter --}}
            <div class="filter-buttons-wrapper" data-aos="fade-up" data-aos-delay="100">
                <button class="filter-btn active" data-filter="offline">Offline Programs</button>
                <button class="filter-btn" data-filter="online">Online Programs</button>
            </div>

            <div class="program-grid">
                @if($offlinePrograms->isEmpty() && $onlinePrograms->isEmpty())
                <div style="grid-column: 1 / -1; text-align: center; padding: 3rem 0;">
                    <p class="text-muted fs-5">Belum ada program yang tersedia saat ini.</p>
                </div>
                @else
                {{-- ======================== --}}
                {{-- == PROGRAM OFFLINE  == --}}
                {{-- ======================== --}}
                @foreach ($offlinePrograms as $index => $program)
                <div class="program-item offline" data-aos="fade-up" data-aos-delay="{{ 100 * ($index + 1) }}">
                    <div class="program-card h-100 d-flex flex-column">
                        <div class="program-card-image-wrapper">
                            <img src="{{ asset('storage/' . $program->thumbnail) }}" class="program-card-img" alt="{{ $program->nama }}">
                        </div>
                        <div class="program-card-content d-flex flex-column flex-grow-1">
                            <h4 class="program-title">{{ $program->nama }}</h4>
                            <p class="program-price">Rp {{ number_format($program->harga, 0, ',', '.') }}</p>
                            <hr class="my-3">
                            <p class="features-heading"><strong>Fasilitas Program:</strong></p>
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
                                @foreach ($features as $fitur)
                                    <li>
                                        {!! \App\Helpers\FeatureHelper::getFeatureIcon($fitur) !!}
                                        {{ trim($fitur) }}
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <small class="text-muted">Tidak ada fasilitas tersedia</small>
                        @endif
                            <a href="{{ route('public.program.offline.show', $program->slug) }}" class="program-btn w-100 mt-auto">
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach

                {{-- ======================== --}}
                {{-- ==  PROGRAM ONLINE  == --}}
                {{-- ======================== --}}
                @foreach ($onlinePrograms as $index => $program)
                <div class="program-item online" data-aos="fade-up" data-aos-delay="{{ 100 * ($index + 1) }}">
                    <div class="program-card h-100 d-flex flex-column">
                        <div class="program-card-image-wrapper">
                            <img src="{{ asset('storage/' . $program->thumbnail) }}" class="program-card-img" alt="{{ $program->nama }}">
                        </div>
                        <div class="program-card-content d-flex flex-column flex-grow-1">
                            <h4 class="program-title">{{ $program->nama }}</h4>
                            <p class="program-price">Rp {{ number_format($program->harga, 0, ',', '.') }}</p>
                            <hr class="my-3">
                            <p class="features-heading"><strong>Fasilitas Program:</strong></p>
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
                                     @foreach ($features as $fitur)
                                    <li>
                                        {!! \App\Helpers\FeatureHelper::getFeatureIcon($fitur) !!}
                                        {{ trim($fitur) }}
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <small class="text-muted">Tidak ada fasilitas tersedia</small>
                        @endif
                            <a href="{{ route('public.program.online.show', $program->slug) }}" class="program-btn w-100 mt-auto">
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
                @endif
            </div>
        </div>
    </section>

    {{-- About Section --}}
    <section class="about py-5" id="tentang">
        <div class="container text-center" data-aos="fade-up">
            <h2 class="mb-4">Mengapa Memilih Kami?</h2>
            <p class="mb-5">
                Di <strong>MANDARIN CENTER PARE</strong>, kami percaya bahwa belajar Bahasa Mandarin adalah
                sebuah petualangan seru. Kami menggabungkan metode pengajaran <span class="highlight">terbaik</span>
                dengan pendekatan interaktif untuk menciptakan pengalaman belajar yang efektif dan tak terlupakan.
            </p>
            <div class="about-grid">
                <div class="about-card" data-aos="fade-up" data-aos-delay="100">
                    <div class="icon-wrapper"><i class="fas fa-rocket"></i></div>
                    <h3>Kurikulum Terstruktur</h3>
                    <p>Materi kami disusun sesuai standar internasional (HSK) untuk memastikan kemajuan Anda terukur.
                    </p>
                </div>
                <div class="about-card" data-aos="fade-up" data-aos-delay="200">
                    <div class="icon-wrapper"><i class="fas fa-user-tie"></i></div>
                    <h3>Pengajar Profesional</h3>
                    <p>Belajar dari instruktur (Laoshi) berpengalaman, baik native speaker maupun lokal yang
                        bersertifikasi.</p>
                </div>
                <div class="about-card" data-aos="fade-up" data-aos-delay="300">
                    <div class="icon-wrapper"><i class="fas fa-users"></i></div>
                    <h3>Komunitas Aktif</h3>
                    <p>Bergabung dengan komunitas suportif untuk berlatih percakapan dan mendalami budaya bersama.</p>
                </div>
            </div>
        </div>
    </section>

    <div class="wave-divider">
        <svg viewBox="0 0 1440 320" preserveAspectRatio="none">
            <path class="shape-fill" d="M0,224L48,208C96,192,192,160,288,154.7C384,149,480,171,576,186.7C672,203,768,213,864,197.3C960,181,1056,139,1152,122.7C1248,107,1344,117,1392,122.7L1440,128L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z">
            </path>
        </svg>
    </div>

    <section class="alur-mandarin" id="alur-mandarin">
        <div class="container" data-aos="fade-up"> {{-- PENAMBAHAN: Animasi untuk kontainer utama --}}
            <h2>Alur Pendaftaran</h2>
            <p>Silakan ikuti langkah-langkah berikut untuk menyelesaikan pendaftaran di <strong>Mandarin Center
                    Pare</strong>:</p>

            <div class="alur-timeline-mandarin">
                {{-- PENAMBAHAN: Atribut data-aos untuk setiap langkah --}}
                <div class="step-mandarin" data-aos="fade-up" data-aos-delay="100">
                    <div class="circle-mandarin">1</div>
                    <h3>Mengisi Formulir Pendaftaran</h3>
                    <p>Isi data diri Anda secara lengkap melalui formulir online yang tersedia di website kami.</p>
                </div>
                <div class="step-mandarin" data-aos="fade-up" data-aos-delay="200">
                    <div class="circle-mandarin">2</div>
                    <h3>Verifikasi dan Konfirmasi</h3>
                    <p>Tim kami akan menghubungi Anda untuk melakukan verifikasi dan memberikan informasi lebih lanjut.
                    </p>
                </div>
                <div class="step-mandarin" data-aos="fade-up" data-aos-delay="300">
                    <div class="circle-mandarin">3</div>
                    <h3>Pembayaran dan Upload Bukti</h3>
                    <p>Lakukan pembayaran sesuai instruksi, kemudian unggah bukti transfer pada halaman konfirmasi.</p>
                </div>
                <div class="step-mandarin" data-aos="fade-up" data-aos-delay="400">
                    <div class="circle-mandarin">4</div>
                    <h3>Konfirmasi di Tempat</h3>
                    <p>Selesaikan konfirmasi secara langsung dengan admin di kantor Brilliant Mandarin Course.</p>
                </div>
                <div class="step-mandarin" data-aos="fade-up" data-aos-delay="500">
                    <div class="circle-mandarin">5</div>
                    <h3>Siap Belajar!</h3>
                    <p>Selamat! Anda telah berhasil mendaftar dan siap mengikuti kursus.</p>
                </div>
            </div>
            <div class="contact-card mt-5" data-aos="fade-up" data-aos-delay="600">
                <h3>Hubungi Kami</h3>
                <p>Tim kami siap membantu Anda.</p>
                <div class="contact-links">
                    <a href="https://wa.me/6282143120833?text=Halo%2C%20saya%20tertarik%20dengan%20kursus%20Mandarin%20di%20Pare." class="contact-link"  >
                        <i class="fab fa-whatsapp"></i> WhatsApp CS 1
                    </a>
                    <a href="https://wa.me/6282143120833?text=Halo%2C%20saya%20tertarik%20dengan%20kursus%20Mandarin%20di%20Pare." class="contact-link" >
                        <i class="fab fa-whatsapp"></i> WhatsApp CS 2
                    </a>
                </div>
            </div>
        </div>
    </section>
    <style>
            /* --- Contact Card Styling --- */
        .contact-card {
            background: white;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            max-width: 600px;
            margin: 0 auto;
        }

        .contact-card h3 {
            color: #054707;
            margin-bottom: 1rem;
        }

        .contact-links {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 1.5rem;
            margin-top: 1rem;
        }

        .contact-link {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.5rem;
            background-color: #25D366; /* WhatsApp Green */
            color: white;
            border-radius: 50px;
            text-decoration: none;
            font-weight: bold;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        .contact-link:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
            color: white;
        }

        .contact-link i {
            font-size: 1.2rem;
        }

        /* --- Responsive Adjustments --- */
        @media (max-width: 768px) {
            .contact-links {
                flex-direction: column;
                align-items: center;
            }
        }
    </style>

    {{-- JS for Carousel --}}
    <script>
        const slides = document.querySelectorAll(".slide");
        const prevBtn = document.querySelector(".prev");
        const nextBtn = document.querySelector(".next");
        let current = 0;

        function showSlide(index) {
            slides.forEach((s, i) => s.classList.toggle("active", i === index));
        }

        if (prevBtn && nextBtn) {
            nextBtn.addEventListener("click", () => {
                current = (current + 1) % slides.length;
                showSlide(current);
            });

            prevBtn.addEventListener("click", () => {
                current = (current - 1 + slides.length) % slides.length;
                showSlide(current);
            });

            // Auto-slide
            setInterval(() => {
                current = (current + 1) % slides.length;
                showSlide(current);
            }, 5000);
        }
    </script>

    {{-- Filter Program JS --}}
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const filterButtons = document.querySelectorAll('.filter-btn');
        const programItems = document.querySelectorAll('.program-item');

        function filterPrograms(filterValue) {
            programItems.forEach(item => {
                if (item.classList.contains(filterValue)) {
                    item.style.display = 'grid';
                } else {
                    item.style.display = 'none';
                }
            });
        }

        const defaultFilter = 'offline';
        const defaultButton = document.querySelector(`.filter-btn[data-filter="${defaultFilter}"]`);
        if (defaultButton) {
            defaultButton.classList.add('active');
        }

        programItems.forEach(item => item.style.display = 'none');
        filterPrograms(defaultFilter);

        filterButtons.forEach(button => {
            button.addEventListener('click', function() {
                const filterValue = this.getAttribute('data-filter');
                filterButtons.forEach(btn => btn.classList.remove('active'));
                this.classList.add('active');
                filterPrograms(filterValue);
            });
        });
    });
    </script>

    {{-- Bootstrap & AOS JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        AOS.init({
            once: true, // Animasi hanya terjadi sekali
            duration: 800, // Durasi animasi
        });
    </script>



    <footer class="footer text-center">
        <p>© 2025 Mandarin Center Pare | Program Bahasa Mandarin</p>
    </footer>
    <style>
    .footer {
        background-color: #054707;
        color: white;
        padding: 15px 0;
        bottom: 0;
        left: 0;
        width: 100%;
        font-size: 14px;
        text-align: center;
    }
    </style>

</body>

</html>
