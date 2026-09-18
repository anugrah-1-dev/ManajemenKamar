let currentPage = 0;
const itemsPerPage = 3;

function updateGalleryPagination() {
    const frames = document.querySelectorAll("#gallerySlider .gallery-frame");
    frames.forEach((frame, index) => {
        const start = currentPage * itemsPerPage;
        const end = start + itemsPerPage;
        if (index >= start && index < end) {
            frame.style.display = "block";
        } else {
            frame.style.display = "none";
        }
    });
}

function slideGalleryGrid(direction) {
    const frames = document.querySelectorAll("#gallerySlider .gallery-frame");
    const totalItems = frames.length;
    const totalPages = Math.ceil(totalItems / itemsPerPage);

    currentPage += direction;
    if (currentPage < 0) currentPage = 0;
    if (currentPage >= totalPages) currentPage = totalPages - 1;

    updateGalleryPagination();
}

document.addEventListener("DOMContentLoaded", () => {
    updateGalleryPagination(); // Tampilkan halaman pertama saat awal
});
    