document.addEventListener('DOMContentLoaded', () => {
    // Smooth scrolling for navigation links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // Accordion functionality
    const accordionButtons = document.querySelectorAll('.accordion-btn');
    
    accordionButtons.forEach(button => {
        button.addEventListener('click', () => {
            // Toggle active class on the clicked button
            button.classList.toggle('active');
            
            // Get the content panel
            const content = button.nextElementSibling;
            
            // Toggle the content visibility
            if (button.classList.contains('active')) {
                content.style.display = 'block';
            } else {
                content.style.display = 'none';
            }
            
            // Close other accordions
            accordionButtons.forEach(otherButton => {
                if (otherButton !== button && otherButton.classList.contains('active')) {
                    otherButton.classList.remove('active');
                    otherButton.nextElementSibling.style.display = 'none';
                }
            });
        });
    });

    // Carousel functionality
    const carousel = document.querySelector('.carousel');
    const slides = document.querySelectorAll('.carousel-slide');
    const prevButton = document.querySelector('.carousel-button.prev');
    const nextButton = document.querySelector('.carousel-button.next');
    let currentSlide = 0;
    const totalSlides = slides.length;

    function updateCarousel() {
        carousel.style.transform = `translateX(-${currentSlide * 100}%)`;
    }

    prevButton.addEventListener('click', () => {
        currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
        updateCarousel();
    });

    nextButton.addEventListener('click', () => {
        currentSlide = (currentSlide + 1) % totalSlides;
        updateCarousel();
    });

    // Auto-advance every 5 seconds
    setInterval(() => {
        currentSlide = (currentSlide + 1) % totalSlides;
        updateCarousel();
    }, 5000);
}); 