// --- Kode Carousel ---
let currentSlide = 0;
let slides = [];
let totalSlides = 0;

function showSlide(index) {
    slides.forEach((slide, i) => {
        slide.classList.remove("active");
        if (i === index) {
            slide.classList.add("active");
        }
    });
}

function changeSlide(step) {
    if (totalSlides === 0) return;
    currentSlide = (currentSlide + step + totalSlides) % totalSlides;
    showSlide(currentSlide);
}

document.addEventListener("DOMContentLoaded", function () {
    // Ambil semua slide setelah halaman siap
    slides = document.querySelectorAll(".slide");
    totalSlides = slides.length;

    if (totalSlides > 0) {
        showSlide(currentSlide);

        // Autoplay setiap 5 detik
        if (totalSlides > 1) {
            setInterval(() => {
                changeSlide(1);
            }, 5000);
        }

        // Event tombol prev/next
        const prevBtn = document.querySelector(".prev");
        const nextBtn = document.querySelector(".next");

        if (prevBtn) {
            prevBtn.addEventListener("click", () => changeSlide(-1));
        }

        if (nextBtn) {
            nextBtn.addEventListener("click", () => changeSlide(1));
        }
    }

    // --- Kode Sticky Navbar ---
    const navbar = document.getElementById("navbar");
    const carousel = document.getElementById("carousel");

    if (navbar && carousel) {
        const logoImg = document.querySelector("#navbar .logo img");

        window.addEventListener("scroll", () => {
            const carouselBottom = carousel.offsetTop + carousel.offsetHeight;
            const hasScrolled = window.scrollY > carouselBottom - 80;

            if (hasScrolled) {
                navbar.classList.add("scrolled");
                if (logoImg) logoImg.src = logo2URL;
            } else {
                navbar.classList.remove("scrolled");
                if (logoImg) logoImg.src = logo1URL;
            }
        });
    }

    // --- Kode Scroll ke Atas Saat Logo Diklik ---
    const logo = document.querySelector("#navbar .logo");
    if (logo) {
        logo.addEventListener("click", function () {
            window.scrollTo({
                top: 0,
                behavior: "smooth",
            });
        });
    }

});

// Scroll ke atas saat logo diklik (redundan tapi aman kalau mau dibiarkan)
const logo = document.querySelector("#navbar .logo");
if (logo) {
    logo.addEventListener("click", function () {
        window.scrollTo({
            top: 0,
            behavior: "smooth",
        });
    });
}

function toggleNavbar() {
    const navLinks = document.getElementById("navLinks");
    navLinks.classList.toggle("active");
}
