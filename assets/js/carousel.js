document.addEventListener("DOMContentLoaded", () => {
    const carouselImages = document.querySelector(".carousel-images");
    const images = document.querySelectorAll(".carousel-images img");
    const prevButton = document.getElementById("prev");
    const nextButton = document.getElementById("next");

    let currentIndex = 0;

    // Función para actualizar la posición del carrusel
    const updateCarousel = () => {
        const offset = -currentIndex * 100; // Desplaza el carrusel en base al índice
        carouselImages.style.transform = `translateX(${offset}%)`;
    };

    // Evento para botón "anterior"
    prevButton.addEventListener("click", () => {
        if (currentIndex > 0) {
            currentIndex--;
            updateCarousel();
        }
    });

    // Evento para botón "siguiente"
    nextButton.addEventListener("click", () => {
        if (currentIndex < images.length - 1) {
            currentIndex++;
            updateCarousel();
        }
    });
});
