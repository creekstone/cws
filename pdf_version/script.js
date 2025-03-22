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

    // Form submission handling
    const leadCaptureForm = document.getElementById('leadCaptureForm');
    const formMessage = document.getElementById('formMessage');
    const submitButton = document.querySelector('.submit-btn');

    if (leadCaptureForm) {
        leadCaptureForm.addEventListener('submit', async (e) => {
            e.preventDefault();

            // Disable the submit button and show loading state
            submitButton.disabled = true;
            submitButton.textContent = 'Sending...';

            // Simulate network delay for local testing
            await new Promise(resolve => setTimeout(resolve, 1000));

            try {
                // For local testing, just simulate a successful submission
                const formData = new FormData(leadCaptureForm);
                const name = formData.get('name');
                const email = formData.get('email');
                
                console.log('Form submitted with:', { name, email });
                
                // Success state
                submitButton.textContent = 'Thank you!';
                submitButton.classList.add('success');
                leadCaptureForm.reset();
                
                // Optional: Reset button after 5 seconds
                setTimeout(() => {
                    submitButton.textContent = 'Subscribe';
                    submitButton.classList.remove('success');
                    submitButton.disabled = false;
                }, 5000);
                
            } catch (error) {
                console.error('Form submission error:', error);
                formMessage.textContent = 'An error occurred. Please try again later.';
                formMessage.classList.add('error');
                formMessage.style.display = 'block';
                submitButton.textContent = 'Subscribe';
                submitButton.disabled = false;
            }
        });
    }
}); 