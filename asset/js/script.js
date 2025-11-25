document.addEventListener('DOMContentLoaded', () => {
    const parallaxLayer = document.querySelector('.parallax-layer');
    const prevArrow = document.querySelector('.parallax-arrow.prev');
    const nextArrow = document.querySelector('.parallax-arrow.next');
    const images = document.querySelectorAll('.parallax-layer img');
    const imagesPerView = 2; 
    const totalImages = images.length;

    // Set width layer theo tổng số ảnh
    parallaxLayer.style.width = `${totalImages * 50}vw`;

    let currentIndex = 0;

    function updateParallax() {
        // Dịch chuyển đúng theo số ảnh * 50vw
        const translateX = -(currentIndex * 50); 
        parallaxLayer.style.transform = `translateX(${translateX}vw)`;
    }

    nextArrow.addEventListener('click', () => {
        currentIndex += imagesPerView;
        if (currentIndex >= totalImages) {
            currentIndex = 0; // quay về đầu
        }
        updateParallax();
    });

    prevArrow.addEventListener('click', () => {
        currentIndex -= imagesPerView;
        if (currentIndex < 0) {
            // quay về cặp cuối
            currentIndex = totalImages - (totalImages % imagesPerView || imagesPerView);
        }
        updateParallax();
    });
});
