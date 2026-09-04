(function () {
  'use strict';

  var body = document.body;

  var header = document.querySelector('.header');
  var navToggle = document.querySelector('.nav-toggle');
  if (header && navToggle) {
    navToggle.addEventListener('click', function () {
      var isOpen = header.classList.toggle('is-open');
      navToggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
      navToggle.setAttribute('aria-label', isOpen ? 'Закрыть меню' : 'Открыть меню');
    });
  }

  document.querySelectorAll('.dropdown > .nav-link').forEach(function (link) {
    link.addEventListener('click', function (e) {
      if (window.innerWidth <= 768) {
        e.preventDefault();
        link.parentElement.classList.toggle('is-expanded');
      }
    });
  });

  var phone = body.getAttribute('data-phone') || '+7 (927) 154-09-50';
  var phoneRaw = body.getAttribute('data-phone-raw') || phone.replace(/\D/g, '');
  document.addEventListener('click', function (e) {
    var button = e.target.closest('.cta-button, .service-button, .btn-order');
    if (!button) return;
    if (button.tagName === 'A' && button.getAttribute('href')) return;
    e.preventDefault();
    if (window.confirm('Позвонить по номеру ' + phone + '?')) {
      window.location.href = 'tel:' + phoneRaw;
    }
  });

  if ('IntersectionObserver' in window) {
    var observer = new IntersectionObserver(
      function (entries) {
        entries.forEach(function (entry) {
          if (entry.isIntersecting) {
            entry.target.classList.add('is-visible');
          }
        });
      },
      { threshold: 0.1, rootMargin: '0px 0px -50px 0px' }
    );
    document.querySelectorAll('.service-card').forEach(function (card, index) {
      card.style.transitionDelay = (index * 0.1) + 's';
      observer.observe(card);
    });
  } else {
    document.querySelectorAll('.service-card').forEach(function (card) {
      card.classList.add('is-visible');
    });
  }
})();
