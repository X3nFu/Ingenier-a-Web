const slides = document.querySelector('.slides');
const images = document.querySelectorAll('.slides img');

let currentIndex = 0;
const items = document.querySelectorAll(".carousel-item");
const totalItems = items.length;

function showNextSlide() {
    // quitar la imagen activa
    items[currentIndex].classList.remove("active");

    // cambiar al siguiente índice
    currentIndex = (currentIndex + 1) % totalItems;

    // mostrar la nueva imagen
    items[currentIndex].classList.add("active");
}

// cambiar cada 3 segundos (3000 ms)
setInterval(showNextSlide, 3000);

