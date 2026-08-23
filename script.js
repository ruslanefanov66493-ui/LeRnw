// Dropdown: click outside closes (mobile)
const dropdowns = document.querySelectorAll('.dropdown');

dropdowns.forEach(dropdown => {
    dropdown.addEventListener('click', function (e) {
        if (window.innerWidth <= 768) {
            e.preventDefault();
            const menu = this.querySelector('.dropdown-menu');
            menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
        }
    });
});

document.addEventListener('click', function (e) {
    if (!e.target.closest('.dropdown')) {
        dropdowns.forEach(dropdown => {
            const menu = dropdown.querySelector('.dropdown-menu');
            if (menu) menu.style.display = 'none';
        });
    }
});

// CTA / order buttons → phone
document.querySelectorAll('.cta-button, .service-button').forEach(button => {
    button.addEventListener('click', function () {
        const phoneNumber = '+7 (927) 154-09-50';
        if (confirm(`Позвонить по номеру ${phoneNumber}?`)) {
            window.location.href = `tel:${phoneNumber.replace(/\D/g, '')}`;
        }
    });
});

// Cards appear on scroll
document.addEventListener('DOMContentLoaded', () => {
    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                }
            });
        },
        { threshold: 0.1, rootMargin: '0px 0px -50px 0px' }
    );

    document.querySelectorAll('.service-card').forEach((card, index) => {
        card.style.transitionDelay = `${index * 0.1}s`;
        observer.observe(card);
    });
});
