<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BIEPLUS Kampung Inggris Pare</title>

    <link rel="stylesheet" href="{{ asset('css/landingpage.css') }}">
    <script src="{{ asset('js/landingpage.js') }}?v={{ time() }}"></script>
    <script src="{{ asset('js/gallery.js') }}"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />

    <link rel="icon" href="{{ asset('favicon-v2.png') }}" type="image/png">

</head>

<body>

    @include('navbar.navbar')

    @if ($programsgambar)
        <div id="pamflet-popup" class="pamflet-popup" style="display:none;">
            <div class="pamflet-content position-relative">
                <!-- Tombol silang -->
                <button id="closePamflet" class="btn-close-custom" aria-label="Close">&times;</button>

                <img src="{{ asset('uploads/programs/' . $programsgambar->gambar) }}" alt="{{ $programsgambar->judul }}"
                    class="img-fluid rounded shadow mb-2">
            </div>
        </div>
    @endif


    <style>
        .pamflet-popup {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            padding: 15px;
            /* biar ada jarak di pinggir hp kecil */
        }

        .pamflet-content {
            /* background: #fff; */
            padding: 12px;
            /* agak tipis biar nggak jauh dari poster */
            border-radius: 12px;
            text-align: center;
            width: 450px;
            /* lebih kecil dari 595px */
            height: 620px;
            /* lebih kecil dari 842px */
            max-width: 100%;
            max-height: 100%;
            position: relative;
            overflow: hidden;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.4);
        }

        .pamflet-content img {
            max-width: 100%;
            max-height: 100%;
            height: auto;
            border-radius: 8px;
            display: block;
            margin: 0 auto;
        }

        .btn-close-custom {
            position: absolute;
            top: 5px;
            right: 19px;
            background: none;
            border: none;
            font-size: 38px;
            font-weight: bold;
            color: #444;
            cursor: pointer;
            line-height: 1;
        }

        .btn-close-custom:hover {
            color: red;
        }
    </style>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const pamfletPopup = document.getElementById("pamflet-popup");
            if (pamfletPopup) {
                if (!sessionStorage.getItem("pamfletShown")) {
                    pamfletPopup.style.display = "flex";
                }

                const closeBtn = document.getElementById("closePamflet");
                if (closeBtn) {
                    closeBtn.addEventListener("click", function() {
                        pamfletPopup.style.display = "none";
                        sessionStorage.setItem("pamfletShown", "true");
                    });
                }
            }
        });
    </script>



    <section class="carousel" id="carousel">
        <div class="carousel-container">
            <div class="slides">
                <img src="{{ asset('asset/img/BIE1.jpg') }}" class="slide" alt="Slide 1">
                <img src="{{ asset('asset/img/BIE2.jpg') }}" class="slide" alt="Slide 2">
                <img src="{{ asset('asset/img/BIE3.jpg') }}" class="slide" alt="Slide 3">
                <img src="{{ asset('asset/img/BIE4.jpg') }}" class="slide active" alt="Slide 4">
                <img src="{{ asset('asset/img/BIE5.jpg') }}" class="slide" alt="Slide 5">
                <img src="{{ asset('asset/img/BIE6.jpg') }}" class="slide" alt="Slide 6">
            </div>
            <div class="overlay"></div>
            <div class="carousel-text">
                <h1 data-aos="fade-left" data-aos-delay="200">
                    <span style="color: #007bff;">BRILLIANT INTERNATIONAL EDUCATION</span> <span style="color: #FFD700;">PLUS</span>
                </h1>

                <p data-aos="fade-right" data-aos-delay="200">
                    Tingkatkan kemampuan Bahasa Inggris Anda dan rasakan pengalaman belajar yang berkualitas di Brilliant International Education PLUS 
                    serta nikmati tempat tinggal atau CAMP dengan kenyamanan, fasilitas lengkap untuk mendukung pengalaman belajar terbaik Anda. Nikmati tempat di mana potensi Anda menjadi lebih gemilang!
                </p>


                <a href="#" id="openPopupBtn" class="cta-button" data-aos="fade-up" data-aos-delay="200">
                    DAFTAR PROGRAM
                </a>
            </div>
            <button class="nav prev">&#10094;</button>
            <button class="nav next">&#10095;</button>
        </div>
        <div id="programPopup" class="popup1-overlay">
            <div class="popup1-content">
                <div class="popup1-header">
                    <h2>Pilih Program Kursus Anda</h2>
                    <button id="closePopupBtn" class="close1-button">&times;</button>
                </div>

               <div class="program1-grid">
    <a href="{{ route('program.inggris') }}" class="program1-card inggris">
        <div class="program1-icon icon-inggris">
            <img src="{{ asset('asset/img/bendera inggris.jpg') }}" alt="Bendera Inggris" class="program1-img">
        </div>
        <h3>Kursus Bahasa Inggris</h3>
        <span class="pilih1-button">Pilih</span>
    </a>

    <a href="{{ route('program.arab') }}" class="program1-card arab">
        <div class="program1-icon icon-arab">
            <img src="{{ asset('asset/img/bendera arab.jpg') }}" alt="Bendera Arab" class="program1-img">
        </div>
        <h3>Kursus Bahasa Arab</h3>
        <span class="pilih1-button">Pilih</span>
    </a>

    <a href="{{ route('landing.nhc') }}" class="program1-card nhc">
        <div class="program1-icon icon-nhc">
            <img src="{{ asset('asset/img/logonhc.png') }}" alt="Logo NHC" class="program1-img">
        </div>
        <h3>Program Perhotelan (NHC)</h3>
        <span class="pilih1-button">Pilih</span>
    </a>

    <a href="{{ route('program.jerman') }}" class="program1-card jerman">
        <div class="program1-icon icon-jerman">
            <img src="{{ asset('asset/img/bendera jerman.jpg') }}" alt="Bendera Jerman" class="program1-img">
        </div>
        <h3>Kursus Bahasa Jerman</h3>
        <span class="pilih1-button">Pilih</span>
    </a>

    <a href="{{ route('program.mandarin') }}" class="program1-card mandarin">
        <div class="program1-icon icon-mandarin">
            <img src="{{ asset('asset/img/bendera mandarin.jpg') }}" alt="Bendera Mandarin" class="program1-img">
        </div>
        <h3>Kursus Bahasa Mandarin</h3>
        <span class="pilih1-button">Pilih</span>
    </a>
</div>

<style>
/* Grid */
.program1-grid {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr;
    grid-template-rows: auto auto auto;
    gap: 14px;
    max-width: clamp(500px, 80%, 700px);  /* responsif */
    margin: 0 auto;
    grid-template-areas:
        "inggris . arab"
        ". nhc ."
        "jerman . mandarin";
}

.inggris { grid-area: inggris; }
.arab { grid-area: arab; }
.nhc { grid-area: nhc; }
.jerman { grid-area: jerman; }
.mandarin { grid-area: mandarin; }

/* Card */
.program1-card {
    display: block;
    text-decoration: none;
    color: inherit;
    padding: 14px;
    border-radius: 9px;  /* ada typo sebelumnya: 9x → 9px */
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    background: #f8f9fa;
    text-align: center;
    font-size: 14px;
}

.program1-card h3 {
    font-size: 16px;
    margin: 10px 0 6px;
}

.program1-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 6px 16px rgba(0, 0, 0, 0.1);
}

.pilih1-button {
    display: inline-block;
    margin-top: 8px;
    padding: 6px 12px;
    background: #007bff;
    color: #fff;
    border-radius: 5px;
    font-size: 13px;
    transition: background 0.2s;
}

.pilih1-button:hover {
    background: #0056b3;
}

/* Overlay */
.popup1-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.6);
    display: none;
    align-items: center;   /* tengah layar */
    justify-content: center;
    z-index: 9999;
    padding: 0;
    box-sizing: border-box;
}

.popup1-overlay.show {
    display: flex;
}

/* Popup Content */
.popup1-content {
    background: #fff;
    border-radius: 10px;
    padding: 20px;
    width: 90%;                  /* lebar popup lebih besar */
    max-width: 900px;
    height: auto;                /* menyesuaikan konten */
    overflow: hidden;            /* hilangkan scroll */
    box-shadow: 0 6px 18px rgba(0,0,0,0.2);
    position: fixed;             /* posisi tetap */
    animation: popupFade 0.25s ease;
}

/* Grid */
.program1-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);  /* 3 kolom */
    grid-template-rows: repeat(2, 1fr);     /* 2 baris */
    gap: 10px;                              /* lebih rapat */
    width: 100%;
}

/* Card */
.program1-card {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    color: inherit;
    padding: 10px;
    border-radius: 9px;
    background: #f8f9fa;
    font-size: 13px;
    text-align: center;
}

.program1-card h3 {
    font-size: 14px;
    margin: 6px 0 4px;
}

.pilih1-button {
    display: inline-block;
    margin-top: 6px;
    padding: 5px 10px;
    background: #007bff;
    color: #fff;
    border-radius: 5px;
    font-size: 12px;
    transition: background 0.2s;
}

.pilih1-button:hover {
    background: #0056b3;
}

/* Icon Image */
.program1-img {
    width: 60px;
    height: 60px;
    object-fit: cover;
    border-radius: 5px;
}

/* ===== Responsif untuk Mobile ===== */
@media (max-width: 600px) {

    /* Popup Content */
    .popup1-content {
        width: 95%;          /* hampir full-width di layar kecil */
        max-width: none;     /* hapus batas max-width */
        padding: 15px;       /* dikurangi sedikit agar muat */
    }

    /* Grid */
    .program1-grid {
        grid-template-columns: 1fr;   /* 1 kolom supaya muat di layar sempit */
        grid-template-rows: auto;     /* baris mengikuti konten */
        gap: 8px;                     /* jarak lebih kecil */
    }

    /* Card */
    .program1-card {
        padding: 8px;                 /* lebih ringkas */
        font-size: 12px;
    }

    .program1-card h3 {
        font-size: 13px;
        margin: 5px 0 3px;
    }

    .pilih1-button {
        padding: 4px 8px;
        font-size: 11px;
        margin-top: 4px;
    }

    /* Gambar */
    .program1-img {
        width: 50px;
        height: 50px;
    }
}
    
</style>




            </div>

        </div>
        </div>
        </div>

        <script>
            // Get the necessary elements
            const openPopupButton = document.getElementById('openPopupBtn');
            const closePopupButton = document.getElementById('closePopupBtn');
            const programPopup = document.getElementById('programPopup');
            const pilihButtons = document.querySelectorAll('.pilih-button');

            // Function to show the popup
            function showPopup() {
                programPopup.classList.add('show');
            }

            // Function to hide the popup
            function hidePopup() {
                programPopup.classList.remove('show');
            }

            // --- Event Listeners ---

            // Open popup when "DAFTAR SEKARANG" is clicked
            openPopupButton.addEventListener('click', function(event) {
                event.preventDefault(); // Prevents the page from jumping to the top
                showPopup();
            });

            // Close popup when the 'X' button is clicked
            closePopupButton.addEventListener('click', hidePopup);

            // Close popup when clicking on the dark overlay background
            programPopup.addEventListener('click', function(event) {
                if (event.target === programPopup) {
                    hidePopup();
                }
            });

            // Close popup when any of the "Pilih" buttons are clicked
            pilihButtons.forEach(function(button) {
                button.addEventListener('click', hidePopup);
            });
        </script>
    </section>

    {{-- ✅ Section "Tentang Kami" dengan animasi --}}
    <section class="about-us-section" id="tentang" data-aos="fade-up">
        <div class="container" data-aos="fade-up" data-aos-delay="100">
            <h2 class="about-section-title" data-aos="fade-up">TENTANG KAMI</h2>

            <div class="about-grid">
                <div class="about-intro" data-aos="fade-left" data-aos-delay="200">
                    <h2>Brilliant International Education PLUS</h2>
                    <p>
                        Berlokasi di jantung Kampung Inggris Pare, Brilliant International Education PLUS menyediakan pengalaman belajar yang berkualitas di
                        Brilliant International Education PLUS serta nikmati tempat tinggal atau CAMP dengan kenyamanan, fasilitas lengkap, dan lokasi
                        strategis untuk mendukung pengalaman belajar terbaik Anda di Kampung Inggris Pare. Nikmati tempat di mana potensi Anda menjadi lebih gemilang!
                    </p>
                </div>

                <div class="features-grid" data-aos="fade-up" data-aos-delay="300">
                    <div class="feature-item" data-aos="fade-up" data-aos-delay="400">
                        <div class="icon"><i class="fas fa-comments"></i></div>
                        <h3>Lingkungan Imersif 24/7</h3>
                        <p>Dengan sistem asrama (camp) berbasis "English Area", Anda akan terbiasa berpikir dan
                            berbicara dalam bahasa Inggris setiap hari. Metode ini terbukti mempercepat kelancaran Anda
                            secara signifikan.</p>
                    </div>

                    <div class="feature-item" data-aos="fade-up" data-aos-delay="500">
                        <div class="icon"><i class="fas fa-lightbulb"></i></div>
                        <h3>Metode Belajar Praktis</h3>
                        <p>Kami fokus pada 80% praktik dan 20% teori. Kelas interaktif, simulasi dunia nyata, dan materi
                            yang relevan membuat proses belajar menjadi efektif, anti-bosan, dan menyenangkan.</p>
                    </div>

                    <div class="feature-item" data-aos="fade-up" data-aos-delay="600">
                        <div class="icon"><i class="fas fa-chalkboard-teacher"></i></div>
                        <h3>Tutor Profesional & Suportif</h3>
                        <p>Tutor kami bukan hanya pengajar, tapi juga mentor yang ramah dan berpengalaman. Mereka siap
                            membimbing Anda langkah demi langkah untuk mencapai target belajar Anda.</p>
                    </div>

                    <div class="feature-item" data-aos="fade-up" data-aos-delay="700">
                        <div class="icon"><i class="fas fa-book-open-reader"></i></div>
                        <h3>Program Terstruktur & Komunitas</h3>
                        <p>Pilih program yang sesuai tujuan Anda, mulai dari Speaking, TOEFL, hingga IELTS. Bergabunglah
                            dengan komunitas pembelajar yang solid dan saling mendukung untuk sukses bersama.</p>
                    </div>
                </div>
            </div>
        </div>

    </section>
    <div class="wave-divider">
        <svg viewBox="0 0 1440 320" preserveAspectRatio="none">
            <path class="shape-fill"
                d="M0,224L48,208C96,192,192,160,288,154.7C384,149,480,171,576,186.7C672,203,768,213,864,197.3C960,181,1056,139,1152,122.7C1248,107,1344,117,1392,122.7L1440,128L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z">
            </path>
        </svg>
    </div>

    <section class="registration-flow-section" id="alur-pendaftaran">
        <div class="container">
            <h2 class="registration-section-title">ALUR PENDAFTARAN</h2>
            <p class="registration-section-subtitle">Ikuti langkah-langkah berikut untuk mendaftar di Brilliant International Education PLUS:</p>

            <div class="flow-steps">
                {{-- Setiap langkah diberi animasi fade-up dengan delay yang meningkat --}}
                <div class="flow-step" data-aos="fade-up" data-aos-delay="100">
                    <div class="step-number">1</div>
                    <div class="step-content">
                        <h3>Isi Formulir Pendaftaran</h3>
                        <p>Isi data diri Anda secara lengkap melalui formulir online yang tersedia di website kami.</p>
                    </div>
                </div>

                <div class="flow-step" data-aos="fade-up" data-aos-delay="200">
                    <div class="step-number">2</div>
                    <div class="step-content">
                        <h3>Verifikasi & Konfirmasi</h3>
                        <p>Tim kami akan menghubungi Anda untuk verifikasi dan memberikan informasi lebih lanjut.</p>
                    </div>
                </div>

                <div class="flow-step" data-aos="fade-up" data-aos-delay="300">
                    <div class="step-number">3</div>
                    <div class="step-content">
                        <h3>Pembayaran & Bukti Transfer</h3>
                        <p>Lakukan pembayaran sesuai instruksi, lalu unggah bukti transfer melalui halaman konfirmasi.
                        </p>
                    </div>
                </div>

                <div class="flow-step" data-aos="fade-up" data-aos-delay="400">
                    <div class="step-number">4</div>
                    <div class="step-content">
                        <h3>Daftar Ulang</h3>
                        <p>Melakukan daftar ulang secara langsung melalui Admin kami yang berada di Ruang Office
                            Brilliant International Education PLUS.</p>
                    </div>
                </div>

                <div class="flow-step" data-aos="fade-up" data-aos-delay="500">
                    <div class="step-number">5</div>
                    <div class="step-content">
                        <h3>Siap Belajar!</h3>
                        <p>Selamat! Anda resmi terdaftar dan siap mengikuti program pembelajaran di Brilliant International Education PLUS.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="wave-divider2">
        <svg viewBox="0 0 1440 320" preserveAspectRatio="none">
            <path class="shape-fill2"
                d="M0,224L48,208C96,192,192,160,288,154.7C384,149,480,171,576,186.7C672,203,768,213,864,197.3C960,181,1056,139,1152,122.7C1248,107,1344,117,1392,122.7L1440,128L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z">
            </path>
        </svg>
    </div>
    <div class="container">
        @foreach ($programs->where('status', 'aktif') as $index => $program)
            {{-- Container utama diberi animasi 'fade-up' --}}
            <div class="program-detail @if ($index % 2 == 0) layout-left @else layout-right @endif"
                data-aos="fade-up">

                <div class="program-content-container">

                    {{-- Kartu teks diberi animasi berdasarkan posisi genap/ganjil --}}
                    <div class="card-info" data-aos="{{ $index % 2 == 0 ? 'fade-right' : 'fade-left' }}"
                        data-aos-delay="200">
                        <div class="content-text content-structured">
                            <h3
                                style="font-weight: bold; text-align: center; font-family: 'Poppins', 'Times New Roman', serif;">
                                {{ $program->judul }}
                            </h3>
                            <p class="description" style="text-align: justify;">
                                {!! nl2br(e($program->deskripsi)) !!}
                            </p>
                            <div class="benefits-container">
                                <p class="benefits-title"><strong>Keunggulan Program:</strong></p>
                                <div class="benefits-grid">
                                    @php
                                        $benefits = explode("\n", $program->keunggulan);
                                    @endphp
                                    @foreach ($benefits as $item)
                                        @if (trim($item) != '')
                                            <div class="benefit-item">
                                                <i class="fas fa-check-circle"></i> {{ trim($item) }}
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Gambar diberi animasi berdasarkan posisi genap/ganjil --}}
                    <div class="content-image card-image"
                        data-aos="{{ $index % 2 == 0 ? 'fade-left' : 'fade-right' }}" data-aos-delay="200">
                        <img src="{{ asset('uploads/programs/' . $program->gambar) }}" alt="{{ $program->judul }}"
                            onclick="openLightbox(this)">
                    </div>

                </div>
            </div>
        @endforeach
    </div>


    <div class="wave-divider4">
        <svg viewBox="0 0 1440 320" preserveAspectRatio="none">
            <path class="shape-fill4"
                d="M0,224L48,208C96,192,192,160,288,154.7C384,149,480,171,576,186.7C672,203,768,213,864,197.3C960,181,1056,139,1152,122.7C1248,107,1344,117,1392,122.7L1440,128L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z">
            </path>
        </svg>
    </div>


    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const filterButtons = document.querySelectorAll('.filter-btn');
            const programItems = document.querySelectorAll('.program-item');
            const noProgramMessage = document.getElementById('no-program-message');

            function filterItems(filterValue) {
                let visibleCount = 0;
                programItems.forEach(item => {
                    if (item.dataset.filter === filterValue) {
                        item.classList.remove('hidden');
                        visibleCount++;
                    } else {
                        item.classList.add('hidden');
                    }
                });

                if (visibleCount === 0) {
                    if (noProgramMessage) noProgramMessage.style.display = 'block';
                } else {
                    if (noProgramMessage) noProgramMessage.style.display = 'none';
                }
            }

            filterButtons.forEach(button => {
                button.addEventListener('click', function() {

                    filterButtons.forEach(btn => btn.classList.remove('active'));
                    this.classList.add('active');
                    const filterValue = this.dataset.filter;
                    filterItems(filterValue);
                });
            });

            const initialActiveButton = document.querySelector('.filter-btn.active');
            if (initialActiveButton) {
                filterItems(initialActiveButton.dataset.filter);
            } else {
                // Jika tidak ada yang aktif, tampilkan yang pertama secara default
                if (filterButtons.length > 0) {
                    filterButtons[0].classList.add('active');
                    filterItems(filterButtons[0].dataset.filter);
                }
            }
        });
    </script>



    <link rel="stylesheet" href="{{ asset('css/program.css') }}">

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tabs = document.querySelectorAll('.program-tabs .tab-button');
            const contents = document.querySelectorAll('.program-detail');

            tabs.forEach(tab => {
                tab.addEventListener('click', () => {
                    const targetId = tab.dataset.tab;

                    tabs.forEach(t => t.classList.remove('active'));
                    tab.classList.add('active');

                    contents.forEach(content => content.classList.remove('active'));
                    const targetContent = document.getElementById(targetId);
                    if (targetContent) {
                        targetContent.classList.add('active');
                    }
                });
            });
        });
    </script>
    <div class="wave-divider7">
        <svg viewBox="0 0 1440 320" preserveAspectRatio="none">
            <path class="shape-fill7"
                d="M0,224L48,208C96,192,192,160,288,154.7C384,149,480,171,576,186.7C672,203,768,213,864,197.3C960,181,1056,139,1152,122.7C1248,107,1344,117,1392,122.7L1440,128L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z">
            </path>
        </svg>
    </div>
    <section class="camp-section" id="camp">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <h2 class="section-title-camp">CAMP BIEPLUS</h2>
                <p class="section-subtitle-camp">CAMP BIEPLUS menawarkan kenyamanan, fasilitas lengkap, dan lokasi
                    strategis untuk mendukung pengalaman belajar terbaik Anda di Kampung Inggris Pare.</p>
            </div>

            <div class="camp-grid">
                {{-- Loop data dari controller --}}
                @forelse ($camps as $index => $camp)
                    {{-- Setiap kartu diberi animasi fade-up dengan delay yang meningkat --}}
                    <div class="camp-card" data-aos="fade-up" data-aos-delay="{{ 100 * ($index + 1) }}">
                        {{-- <div class="camp-card-image">
                                <img src="{{ asset('upload/camp/' . $camp->thumbnail) }}" alt="{{ $camp->nama }}">
                            </div> --}}
                        <div class="camp-card-images">
                            @foreach ($camp->thumbnail_urls->take(6) as $index => $url)
                                <div class="camp-card-image item-{{ $index + 1 }}">
                                    <img src="{{ $url }}" alt="{{ $camp->nama }}">
                                </div>
                            @endforeach
                        </div>

                        <style>
                            .camp-card-images {
                                display: grid;
                                gap: 10px;
                                grid-template-areas:
                                    "main main side1"
                                    "main main side2"
                                    "side3 side4 side5";
                                grid-template-columns: repeat(3, 1fr);
                                grid-auto-rows: 150px;
                            }

                            .camp-card-image img {
                                width: 100%;
                                height: 100%;
                                object-fit: cover;
                                border-radius: 8px;
                            }

                            /* Area besar untuk gambar pertama */
                            .item-1 {
                                grid-area: main;
                            }

                            .item-2 {
                                grid-area: side1;
                            }

                            .item-3 {
                                grid-area: side2;
                            }

                            .item-4 {
                                grid-area: side3;
                            }

                            .item-5 {
                                grid-area: side4;
                            }

                            .item-6 {
                                grid-area: side5;
                            }

                            /* Responsif */
                            @media (max-width: 768px) {
                                .camp-card-images {
                                    grid-template-areas:
                                        "main"
                                        "side1"
                                        "side2"
                                        "side3"
                                        "side4"
                                        "side5";
                                    grid-template-columns: 1fr;
                                    grid-auto-rows: 200px;
                                }
                            }

                            @media (max-width: 768px) {
                                .camp-card-images {
                                    display: flex;
                                    overflow-x: auto;
                                    gap: 10px;
                                    scroll-snap-type: x mandatory;
                                    padding-bottom: 10px;
                                }

                                .camp-card-image {
                                    flex: 0 0 80%;
                                    /* tiap item 80% lebar layar */
                                    scroll-snap-align: start;
                                }

                                .camp-card-image img {
                                    height: 250px;
                                    object-fit: cover;
                                    border-radius: 8px;
                                }
                            }
                        </style>
                        {{--
                        <style>
                            .camp-card-images {
                                display: grid;
                                gap: 10px;
                                /* jarak antar gambar */
                                grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
                            }

                            .camp-card-image img {
                                width: 100%;
                                height: 150px;
                                object-fit: cover;
                                border-radius: 8px;
                            }
                        </style> --}}


                        <div class="camp-card-body">
                            <h3 class="camp-card-title text-center fw-bold text-decoration-underline fs-4"
                                style="color: #0d47a1;">
                                {{ $camp->nama }}
                            </h3>
                            <div class="camp-card-description">

                                {{-- ============================== --}}
                                {{-- Deskripsi Berdasarkan Urutan Index --}}
                                {{-- ============================== --}}
                                @php
                                    $posisi = $loop->index % 3; // 0,1,2 berulang
                                @endphp

                                @switch($posisi)
                                    @case(0)
                                        <p style="text-align: justify;">
                                            <strong>BIE+ Camp (VVIP)</strong> adalah pilihan premium kami yang dirancang khusus
                                            untuk memberikan privasi dan kenyamanan maksimal bagi peserta. Cocok bagi Anda yang
                                            ingin fokus belajar dengan fasilitas terbaik.
                                        </p>
                                    @break

                                    @case(1)
                                        <p style="text-align: justify;">
                                            <strong>BIE+ Camp (VIP)</strong> menawarkan perpaduan ideal antara fasilitas modern
                                            dan kenyamanan. Pilihan ini cocok bagi peserta yang ingin belajar secara intensif
                                            dengan suasana nyaman.
                                        </p>
                                    @break

                                    @case(2)
                                        <p style="text-align: justify;">
                                            <strong>BIE+ Camp (Barack)</strong> adalah solusi ekonomis bagi peserta yang
                                            mengutamakan kebersamaan dan efisiensi. Fasilitas memadai untuk menunjang proses
                                            belajar di Kampung Inggris.
                                        </p>
                                    @break
                                @endswitch

                                {{-- ============================== --}}
                                {{-- Fasilitas Dinamis --}}
                                {{-- ============================== --}}
                                <strong>Fasilitas:</strong>
                                @php
                                    $fasilitasList = json_decode($camp->fasilitas, true) ?? [];
                                @endphp

                                <ul class="list-unstyled">
                                    @foreach ($fasilitasList as $fasilitas)
                                        <li>✅ {{ $fasilitas }}</li>
                                    @endforeach
                                </ul>





                            </div>

                            <div class="promo-banner">
                                <i class="fas fa-star"></i> Special Promo Available <i class="fas fa-fire"></i>
                            </div>
                            <a href="{{ route('camps.show', $camp->slug) }}" class="btn-details">Lihat
                                Selengkapnya →</a>
                        </div>
                    </div>
                    @empty
                        <div class="col-12 text-center">
                            <p class="text-muted">Belum ada informasi camp yang tersedia.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </section>

        <div class="wave-divider5">
            <svg viewBox="0 0 1440 320" preserveAspectRatio="none">
                <path class="shape-fill5"
                    d="M0,224L48,208C96,192,192,160,288,154.7C384,149,480,171,576,186.7C672,203,768,213,864,197.3C960,181,1056,139,1152,122.7C1248,107,1344,117,1392,122.7L1440,128L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z">
                </path>
            </svg>
        </div>

        <section id="galeri" class="gallery">
            <div class="container" data-aos="fade-up">
                <h2 class="section-title">GALERI</h2>
                <p class="section-subtitle text-center mb-4">
                    Dokumentasi kegiatan dan momen-momen seru bersama Brilliant International Education PLUS.
                </p>

                <div class="gallery-slider-wrapper">
                    <button class="gallery-nav left" onclick="slideGalleryGrid(-1)">
                        <i class="fas fa-chevron-left"></i>
                    </button>

                    <div class="gallery-scroll-outer">
                        <div class="gallery-scroll-inner" id="gallerySlider">
                            @php $index = 0; @endphp
                            @foreach ($galleries as $gallery)
                                @if ($gallery->images->isNotEmpty())
                                    {{-- Setiap frame galeri diberi animasi fade-up dengan delay --}}
                                    <div class="gallery-frame text-center" data-index="{{ $index }}"
                                        data-aos="fade-up" data-aos-delay="{{ 100 * ($index + 1) }}">
                                        <img src="{{ $gallery->images->first()->image_url }}"
                                            onerror="this.onerror=null; this.src='{{ asset('images/placeholder.jpg') }}';"
                                            alt="{{ $gallery->title }}" class="gallery-thumbnail"
                                            onclick="openGalleryModal({{ $gallery->id }})">

                                        <div class="gallery-caption">
                                            <h5>{{ $gallery->title }}</h5>
                                            <p>{{ Str::limit($gallery->deskripsi ?? 'Galeri kegiatan Brilliant', 50) }}</p>
                                        </div>
                                    </div>

                                    <div id="modal-{{ $gallery->id }}" class="gallery-modal">
                                        <div class="modal-content">
                                            <span class="close-btn"
                                                onclick="closeGalleryModal({{ $gallery->id }})">&times;</span>
                                            <h3>{{ $gallery->title }}</h3>
                                            <div class="modal-slider-wrapper">
                                                <button class="nav-btn left"
                                                    onclick="slideGallery({{ $gallery->id }}, -1)">&#8592;</button>
                                                <div class="modal-slider" id="slider-{{ $gallery->id }}">
                                                    @foreach ($gallery->images as $image)
                                                        <img src="{{ $image->image_url }}" onerror="this.onerror=null; this.src='{{ asset('images/placeholder.jpg') }}';" alt="Image">
                                                    @endforeach
                                                </div>
                                                <button class="nav-btn right"
                                                    onclick="slideGallery({{ $gallery->id }}, 1)">&#8594;</button>
                                            </div>
                                        </div>
                                    </div>
                                    @php $index++; @endphp
                                @endif
                            @endforeach
                        </div>
                    </div>

                    <button class="gallery-nav right" onclick="slideGalleryGrid(1)">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            </div>
        </section>


        <script>
            function openGalleryModal(id) {
                document.getElementById('modal-' + id).classList.add('active');
                document.body.style.overflow = 'hidden';
            }

            function closeGalleryModal(id) {
                document.getElementById('modal-' + id).classList.remove('active');
                document.body.style.overflow = 'auto';
            }

            // Geser slider ke kiri atau kanan
            function slideGallery(id, direction) {
                const slider = document.getElementById('slider-' + id);
                const scrollAmount = 300; // px
                slider.scrollBy({
                    left: scrollAmount * direction,
                    behavior: 'smooth'
                });
            }
        </script>


        <style>
            /* Transisi hanya untuk opacity */
            .gallery-frame img {
                opacity: 1;
                transition: opacity 0.5s ease-in-out;
                /* Durasi transisi diperpanjang sedikit biar lebih halus */
            }

            /* Kelas untuk gambar yang sedang memudar keluar */
            .gallery-frame img.fade-out-only {
                opacity: 0;
            }
        </style>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const galleries = @json($galleries->map(fn($g) => $g->images->pluck('image_url')));

                galleries.forEach((images, galleryIndex) => {
                    if (images.length <= 1) return; // skip kalau cuma 1 gambar

                    let currentIndex = 0;
                    const galleryFrame = document.querySelectorAll('.gallery-frame')[galleryIndex];
                    const imgElement = galleryFrame.querySelector('img');

                    // Fungsi utama untuk mengganti gambar dengan efek fade
                    function changeImageFadeOnly() {
                        // 1. Tambahkan kelas agar gambar lama memudar keluar
                        imgElement.classList.add('fade-out-only');

                        // 2. Tunggu sampai animasi fade-out selesai (800ms sesuai CSS)
                        setTimeout(() => {
                            // Ganti source gambar
                            currentIndex = (currentIndex + 1) % images.length;
                            imgElement.src = images[currentIndex];

                            imgElement.classList.remove('fade-out-only');
                        }, 500); // Harus sama dengan durasi transition di CSS
                    }

                    // Atur interval pergantian gambar
                    // Diberi delay awal agar setiap galeri tidak mulai bersamaan
                    const startDelay = galleryIndex * 2500; // Jeda 1 detik antar galeri
                    setTimeout(() => {
                        setInterval(changeImageFadeOnly, 5000); // Ganti gambar setiap 3 detik
                    }, startDelay);
                });
            });
        </script>

        <div class="lightbox" id="lightbox" onclick="closeLightbox()">
            <span class="lightbox-close" onclick="closeLightbox()">x</span>
            <img class="lightbox-content" id="lightboxImg">
        </div>

        <div class="wave-divider6">
            <svg viewBox="0 0 1440 320" preserveAspectRatio="none">
                <path class="shape-fill6"
                    d="M0,224L48,208C96,192,192,160,288,154.7C384,149,480,171,576,186.7C672,203,768,213,864,197.3C960,181,1056,139,1152,122.7C1248,107,1344,117,1392,122.7L1440,128L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z">
                </path>
            </svg>
        </div>

        <link rel="stylesheet" href="{{ asset('css/sosmed.css') }}">

        <section id="sosmed" class="sosmed-section">
            <div class="container">
                <h2 class="section-title">Sosial Media Kami</h2>
                @if (!$hasSosmed)
                    <p class="text-center">Belum ada data yang ditambahkan. Stay tuned!</p>
                @else
                    @foreach ($groupedSosmed as $platform => $items)
                        @if (count($items) > 0)
                            <div class="mb-5">
                                <h4 class="section-subtitle fw-semibold mb-4">{{ $platform }}</h4>
                                <div class="sosmed-grid">
                                    @foreach ($items as $item)
                                        <div class="sosmed-card" data-platform="{{ strtolower($platform) }}">
                                            <div class="sosmed-card-image">
                                                @if (strtolower($platform) === 'youtube')
                                                    <div class="sosmed-card-video">
                                                        <iframe width="100%" height="200"
                                                            src="https://www.youtube.com/embed/{{ getYoutubeVideoId($item->url) }}"
                                                            title="YouTube video player" frameborder="0"
                                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                                            allowfullscreen>
                                                        </iframe>
                                                    </div>
                                                @elseif (strtolower($platform) === 'instagram')
                                                    <a href="{{ $item->url }}" target="_blank"
                                                        rel="noopener noreferrer">
                                                        <img src="{{ $item->thumbnail_url }}" onerror="this.onerror=null; this.src='{{ asset('images/placeholder.jpg') }}';" alt="Instagram Image">
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    @endforeach
                @endif
            </div>
        </section>

        <link rel="stylesheet" href="{{ asset('css/kontak.css') }}">

        <div class="wave-dividerkontak">
            <svg viewBox="0 0 1440 320" preserveAspectRatio="none">
                <path class="shape-fillkontak"
                    d="M0,224L48,208C96,192,192,160,288,154.7C384,149,480,171,576,186.7C672,203,768,213,864,197.3C960,181,1056,139,1152,122.7C1248,107,1344,117,1392,122.7L1440,128L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z">
                </path>
            </svg>
        </div>

        <section id="kontak" class="kontak-section">
            <div class="container">
                <h2 class="section-title">Kontak Kami</h2>
                <p class="kontak-subtitle">
                    Ingin terhubung dengan kami? Silakan hubungi lewat email atau sosial media berikut.
                </p>

                <div class="kontak-info">
                    <p><strong>Instagram:</strong> <a
                            href="https://www.instagram.com/biecast_brilliankampunginggris?igsh=bzdhMGVyemIxZGQ="
                            target="_blank">@biecast_brilliankampunginggris</a></p>
                    <p><strong>YouTube:</strong> <a
                            href="https://youtube.com/@bieplusbrilliantenglishcourse?si=VxZw3YfiD4t5LciM"
                            target="_blank">BIECAST Brilliant English Course</a></p>
                </div>

                <div class="kontak-maps">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3953.299223137717!2d112.1899974!3d-7.758055899999999!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e785db5d1b27adb%3A0xa8f77ed278eedc6!2sBrilliant%20English%20Course%20Kampung%20Inggris%20Pare!5e0!3m2!1sen!2sid!4v1753597882357!5m2!1sen!2sid"
                        width="100%" height="250" style="border:0;" allowfullscreen="" loading="lazy">
                    </iframe>
                </div>
            </div>
        </section>



        <footer>
            © 2025 Brilliant International Education PLUS. Hak Cipta Dilindungi Oleh Undang-Undang
        </footer>


        @include('partials.whatsapp-floating')

    </body>
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>

    <script>
        AOS.init({
            duration: 800, // Durasi animasi
            once: true, // Animasi hanya berjalan sekali
        });
    </script>

    </html>
