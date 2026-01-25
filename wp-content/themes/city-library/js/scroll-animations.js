document.addEventListener('DOMContentLoaded', function() {
    const observerOptions = {
        root: null,
        rootMargin: '0px',
        threshold: 0.1
    };

    const observer = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
            entry.target.classList.add('aos-animate');
                observer.unobserve(entry.target); // Only animate once
            }
        });
    }, observerOptions);

const elements = document.querySelectorAll('.animate-on-scroll');
    elements.forEach(el => observer.observe(el));
});
