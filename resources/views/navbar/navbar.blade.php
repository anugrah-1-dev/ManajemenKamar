<!-- Navbar -->
<link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
<script>
    const logo1URL = "{{ asset('asset/img/bietest.png') }}";
    const logo2URL = "{{ asset('asset/img/bietest.png') }}";
</script>
<script src="{{ asset('js/landingpage.js') }}"></script>
<!-- Navbar css-->
<link rel="stylesheet" href="{{ asset('css/navbarblade.css') }}">



<nav id="navbar">
    <div class="logo">
        <img src="{{ asset('asset/img/bietest.png') }}" alt="Logo" id="navbarLogo" style="height: 90px;">

    </div>

    <div class="burger" onclick="toggleNavbar()">
        <span></span>
        <span></span>
        <span></span>
    </div>

    <div class="nav-links" id="navLinks">


        <div class="dropdown" id="programDropdown">
            <button class="dropbtn">
                PROGRAM <span class="arrow">▼</span>
            </button>
            <div class="dropdown-content">
                <a href="{{ route('program.inggris') }}">Bahasa Inggris</a>
                <a href="{{ route('program.jerman') }}">Bahasa Jerman</a>
                <a href="{{ route('program.mandarin') }}">Bahasa Mandarin</a>
                <a href="{{ route('program.arab') }}">Bahasa Arab</a>
                <a href="{{ route('landing.nhc') }}">NHC</a>


            </div>
        </div>

        <div class="dropdown" id="galleryDropdown">
            <button class="dropbtn">
                GALERI <span class="arrow">▼</span>
            </button>
            <div class="dropdown-content">
                <a href="{{ url('#galeri') }}">Galeri</a>
                <a href="{{ url('#sosmed') }}">Social Media</a>
            </div>
        </div>

        <a href="#camp">CAMP</a>
        {{-- <a href="#galeri">GALLERI</a>
        <a href="#sosmed">SOSMED</a> --}}
        <a href="#kontak">KONTAK</a>
        <a href="#">TENTANG KAMI</a>
        <a href="{{ route('tracking.index') }}" class="btn">Tracking Transaksi</a>
    </div>

</nav>
<script>
    // Navbar scroll effect
    window.addEventListener('scroll', function () {
        const navbar = document.getElementById('navbar');
        if (window.scrollY > 50) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    });

    // Dropdown functionality (support multiple dropdowns)
    document.addEventListener('DOMContentLoaded', function () {
        const dropdowns = document.querySelectorAll('.dropdown');

        dropdowns.forEach(dropdown => {
            const button = dropdown.querySelector('.dropbtn');

            if (button) {
                button.addEventListener('click', function (e) {
                    e.preventDefault();
                    e.stopPropagation();

                    // Tutup semua dropdown lain dulu
                    dropdowns.forEach(d => {
                        if (d !== dropdown) d.classList.remove('active');
                    });

                    // Toggle dropdown yang diklik
                    dropdown.classList.toggle('active');
                });
            }
        });

        // Close all dropdowns when clicking outside
        document.addEventListener('click', function (e) {
            dropdowns.forEach(dropdown => {
                if (!dropdown.contains(e.target)) {
                    dropdown.classList.remove('active');
                }
            });
        });

        // Close dropdown when item is selected
        document.querySelectorAll('.dropdown-content a').forEach(item => {
            item.addEventListener('click', function () {
                dropdowns.forEach(d => d.classList.remove('active'));
            });
        });
    });

    // Mobile navbar toggle
    function toggleNavbar() {
        const navLinks = document.getElementById('navLinks');
        navLinks.classList.toggle('active');
    }
</script>