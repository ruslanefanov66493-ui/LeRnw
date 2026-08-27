// Появление карточек услуг при прокрутке (главная страница).
// Примечание: логика выпадающего меню и клика по кнопкам «Заказать»
// вынесена в js/chrome.js, чтобы работать на всех страницах сайта
// и не вызывать двойное подтверждение звонка.
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
