/**
 * Двухбрендовый chrome: Влата (ритуал) и Данила Мастер (памятники).
 * body[data-brand="vlata|danila"] data-base=""|../|../../ data-page="..."
 */
(function () {
  const body = document.body;
  const base = body.dataset.base || '';
  const page = body.dataset.page || '';
  const brand = body.dataset.brand || 'vlata';

  function href(path) {
    return base + path;
  }

  const isDanila = brand === 'danila';
  const funeralsOpen = ['funerals', 'coffins', 'church', 'hall', 'crosses', 'transport', 'wreaths'].includes(page);
  const danilaOpen = ['danila-home', 'danila-about', 'danila-works', 'danila-contacts', 'granite', 'metal', 'engraving', 'installation'].includes(page);

  const headerClass = 'header header-solid';

  const brandSwitch = `
    <div class="brand-switch" role="navigation" aria-label="Выбор организации">
      <a href="${href('index.html')}" class="brand-switch-item ${!isDanila ? 'is-active' : ''}" title="Центр ритуальных услуг Влата">Влата</a>
      <span class="brand-switch-sep" aria-hidden="true">|</span>
      <a href="${href('danila-master/index.html')}" class="brand-switch-item ${isDanila ? 'is-active' : ''}" title="Производство памятников Данила Мастер">Данила Мастер</a>
    </div>`;

  let logo, nav, phone, footerBrand, footerNav, footerServices, footerText, schemaOrg;

  if (isDanila) {
    logo = `
      <a href="${href('danila-master/index.html')}" class="logo logo-danila">
        <span class="logo-name">Данила Мастер</span>
        <span class="logo-tag">производство памятников</span>
      </a>`;
    nav = `
      <nav class="navbar" aria-label="Навигация Данила Мастер">
        <ul class="nav-menu">
          <li class="nav-item"><a href="${href('danila-master/index.html')}" class="nav-link ${page === 'danila-home' ? 'active' : ''}">Главная</a></li>
          <li class="nav-item"><a href="${href('danila-master/about.html')}" class="nav-link ${page === 'danila-about' ? 'active' : ''}">О компании</a></li>
          <li class="nav-item dropdown">
            <a href="${href('danila-master/index.html')}#catalog" class="nav-link ${danilaOpen && page !== 'danila-about' && page !== 'danila-works' && page !== 'danila-contacts' ? 'active' : ''}">Каталог <i class="fas fa-chevron-down"></i></a>
            <ul class="dropdown-menu">
              <li><a href="${href('danila-master/granite.html')}">Гранит и мрамор</a></li>
              <li><a href="${href('danila-master/metal.html')}">Металлические изделия</a></li>
              <li><a href="${href('danila-master/engraving.html')}">Гравировка</a></li>
              <li><a href="${href('danila-master/installation.html')}">Варианты установок</a></li>
            </ul>
          </li>
          <li class="nav-item"><a href="${href('danila-master/works.html')}" class="nav-link ${page === 'danila-works' ? 'active' : ''}">Наши работы</a></li>
          <li class="nav-item"><a href="${href('danila-master/contacts.html')}" class="nav-link ${page === 'danila-contacts' ? 'active' : ''}">Контакты</a></li>
        </ul>
      </nav>`;
    phone = `<a href="tel:+789093316877" class="header-phone"><i class="fas fa-phone"></i><span>Заказать расчёт</span></a>`;
    footerBrand = `
      <a href="${href('danila-master/index.html')}" class="logo logo-footer logo-danila">
        <span class="logo-name">Данила Мастер</span>
        <span class="logo-tag">производство памятников</span>
      </a>
      <p class="footer-text">Изготовление и установка памятников из гранита и мрамора. Более 25 лет. Собственное производство, цены от производителя.</p>
      <p class="footer-partner">Партнёр по ритуальным услугам: <a href="${href('index.html')}">центр «Влата»</a></p>`;
    footerNav = `
      <h4>Навигация</h4>
      <ul>
        <li><a href="${href('danila-master/index.html')}">Главная</a></li>
        <li><a href="${href('danila-master/about.html')}">О компании</a></li>
        <li><a href="${href('danila-master/works.html')}">Наши работы</a></li>
        <li><a href="${href('danila-master/contacts.html')}">Контакты</a></li>
        <li><a href="${href('index.html')}">← Ритуальная служба «Влата»</a></li>
      </ul>`;
    footerServices = `
      <h4>Продукция</h4>
      <ul>
        <li><a href="${href('danila-master/granite.html')}">Гранит и мрамор</a></li>
        <li><a href="${href('danila-master/metal.html')}">Металл</a></li>
        <li><a href="${href('danila-master/engraving.html')}">Гравировка</a></li>
        <li><a href="${href('danila-master/installation.html')}">Установки</a></li>
      </ul>`;
    footerText = 'Данила Мастер';
    schemaOrg = {
      "@context": "https://schema.org",
      "@type": "LocalBusiness",
      "name": "Данила Мастер",
      "description": "Производство и установка памятников из гранита и мрамора",
      "url": typeof location !== 'undefined' ? location.origin + '/' + base + 'danila-master/' : '',
      "image": typeof location !== 'undefined' ? location.origin + '/' + base + 'images/danila/monuments/01.jpg' : '',
      "areaServed": "Ершов, Саратовская область",
      "telephone": "+789093316877",
      "priceRange": "₽₽",
      "address": {
        "@type": "PostalAddress",
        "streetAddress": "ул. Кутузова, 38",
        "addressLocality": "Ершов",
        "addressRegion": "Саратовская область",
        "addressCountry": "RU"
      },
      "geo": {
        "@type": "GeoCoordinates",
        "latitude": 51.361894,
        "longitude": 48.268223
      },
      "hasMap": "https://yandex.ru/maps/org/danila_master/125287762138/",
      "openingHoursSpecification": {
        "@type": "OpeningHoursSpecification",
        "dayOfWeek": ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"],
        "opens": "08:00",
        "closes": "17:00"
      }
    };
  } else {
    logo = `
      <a href="${href('index.html')}" class="logo logo-vlata">
        <span class="logo-name">Влата</span>
        <span class="logo-tag">ритуальная служба</span>
      </a>`;
    nav = `
      <nav class="navbar" aria-label="Навигация Влата">
        <ul class="nav-menu">
          <li class="nav-item"><a href="${href('index.html')}" class="nav-link ${page === 'home' ? 'active' : ''}">Главная</a></li>
          <li class="nav-item"><a href="${href('about.html')}" class="nav-link ${page === 'about' ? 'active' : ''}">О компании</a></li>
          <li class="nav-item dropdown">
            <a href="${href('funerals.html')}" class="nav-link ${funeralsOpen ? 'active' : ''}">Похоронные услуги <i class="fas fa-chevron-down"></i></a>
            <ul class="dropdown-menu">
              <li><a href="${href('pages/coffins.html')}">Гробы</a></li>
              <li><a href="${href('pages/church.html')}">Церковные принадлежности</a></li>
              <li><a href="${href('pages/hall.html')}">Прощальный зал</a></li>
              <li><a href="${href('pages/crosses.html')}">Кресты</a></li>
              <li><a href="${href('pages/transport.html')}">Перевозка тел</a></li>
              <li><a href="${href('pages/wreaths.html')}">Венки и корзины</a></li>
            </ul>
          </li>
          <li class="nav-item"><a href="${href('works.html')}" class="nav-link ${page === 'works' ? 'active' : ''}">Наши работы</a></li>
          <li class="nav-item"><a href="${href('contacts.html')}" class="nav-link ${page === 'contacts' ? 'active' : ''}">Контакты</a></li>
        </ul>
      </nav>`;
    phone = `<a href="tel:+789271540950" class="header-phone"><i class="fas fa-phone"></i><span>Круглосуточно</span></a>`;
    footerBrand = `
      <a href="${href('index.html')}" class="logo logo-footer logo-vlata">
        <span class="logo-name">Влата</span>
        <span class="logo-tag">ритуальная служба</span>
      </a>
      <p class="footer-text">Центр ритуальных услуг «Влата» — организация похорон в г. Ершове и Ершовском районе более 27 лет. Работаем круглосуточно.</p>
      <p class="footer-partner">Памятники изготавливает партнёр: <a href="${href('danila-master/index.html')}">«Данила Мастер»</a></p>`;
    footerNav = `
      <h4>Навигация</h4>
      <ul>
        <li><a href="${href('index.html')}">Главная</a></li>
        <li><a href="${href('about.html')}">О компании</a></li>
        <li><a href="${href('funerals.html')}">Похоронные услуги</a></li>
        <li><a href="${href('works.html')}">Наши работы</a></li>
        <li><a href="${href('contacts.html')}">Контакты</a></li>
        <li><a href="${href('danila-master/index.html')}">Памятники «Данила Мастер» →</a></li>
      </ul>`;
    footerServices = `
      <h4>Услуги</h4>
      <ul>
        <li><a href="${href('pages/coffins.html')}">Гробы</a></li>
        <li><a href="${href('pages/wreaths.html')}">Венки и кресты</a></li>
        <li><a href="${href('pages/transport.html')}">Перевозка</a></li>
        <li><a href="${href('pages/hall.html')}">Прощальный зал</a></li>
        <li><a href="${href('funerals.html')}">Все услуги</a></li>
      </ul>`;
    footerText = 'Центр ритуальных услуг «Влата»';
    schemaOrg = {
      "@context": "https://schema.org",
      "@type": "FuneralHome",
      "name": "Центр ритуальных услуг Влата",
      "description": "Ритуальные услуги в г. Ершове и Ершовском районе: организация похорон, гробы, венки, кресты, перевозка, прощальный зал. Круглосуточно.",
      "url": typeof location !== 'undefined' ? location.origin + '/' + base : '',
      "image": typeof location !== 'undefined' ? location.origin + '/' + base + 'images/hero-bg.jpg' : '',
      "areaServed": "Ершов, Ершовский район, Саратовская область",
      "telephone": "+789603431891",
      "priceRange": "₽₽",
      "openingHours": "Mo-Su 00:00-24:00",
      "address": {
        "@type": "PostalAddress",
        "streetAddress": "ул. Фрунзе, 18",
        "addressLocality": "Ершов",
        "addressRegion": "Саратовская область",
        "addressCountry": "RU"
      },
      "geo": {
        "@type": "GeoCoordinates",
        "latitude": 51.352332,
        "longitude": 48.270298
      },
      "hasMap": "https://yandex.ru/maps/org/vlata/176311151621/"
    };
  }

  const headerHTML = `
  <div class="brand-bar">
    <div class="header-inner brand-bar-inner">
      ${brandSwitch}
      <span class="brand-bar-note">${isDanila ? 'Производство памятников · г. Ершов' : 'Ритуальные услуги · г. Ершов'}</span>
    </div>
  </div>
  <header class="${headerClass}">
    <div class="header-inner">
      ${logo}
      ${nav}
      ${phone}
      <button class="nav-toggle" type="button" aria-label="Открыть меню" aria-controls="site-nav" aria-expanded="false">
        <span class="nav-toggle-bar"></span>
        <span class="nav-toggle-bar"></span>
        <span class="nav-toggle-bar"></span>
      </button>
    </div>
  </header>`;

  const footerHTML = `
  <footer class="footer" id="contacts-footer">
    <div class="container">
      <div class="footer-grid">
        <div class="footer-brand">${footerBrand}</div>
        <div class="footer-nav">${footerNav}</div>
        <div class="footer-nav">${footerServices}</div>
        <div class="footer-contacts">
          <h4>Контакты</h4>
          <ul>
            <li><i class="fas fa-phone"></i><a href="tel:${isDanila ? '+789093316877' : '+789603431891'}">${isDanila ? '+7 (909) 331-68-77' : '+7 (960) 343-18-91'}</a></li>
            <li><i class="fas fa-clock"></i><span>${isDanila ? 'Ежедневно с 8:00 до 17:00' : 'Круглосуточно, без выходных'}</span></li>
            <li><i class="fas fa-envelope"></i><a href="mailto:iva0281@yandex.ru">iva0281@yandex.ru</a></li>
            <li><i class="fas fa-map-marker-alt"></i><span>${isDanila ? 'ул. Кутузова, 38, г. Ершов' : 'ул. Фрунзе, 18, г. Ершов'}</span></li>
          </ul>
        </div>
      </div>
      <div class="footer-bottom">
        <p>&copy; 2026 ${footerText}. Все права защищены.</p>
        <nav class="footer-bottom-nav" aria-label="Организации">
          <a href="${href('index.html')}">Влата</a>
          <a href="${href('danila-master/index.html')}">Данила Мастер</a>
        </nav>
      </div>
    </div>
  </footer>`;

  const headerMount = document.getElementById('site-header');
  const footerMount = document.getElementById('site-footer');
  if (headerMount) headerMount.innerHTML = headerHTML;
  if (footerMount) footerMount.innerHTML = footerHTML;

  // Мобильное меню: кнопка-гамбургер открывает/закрывает навигацию
  const headerEl = headerMount ? headerMount.querySelector('.header') : null;
  const navToggle = headerMount ? headerMount.querySelector('.nav-toggle') : null;
  if (headerEl && navToggle) {
    navToggle.addEventListener('click', () => {
      const isOpen = headerEl.classList.toggle('is-open');
      navToggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
      navToggle.setAttribute('aria-label', isOpen ? 'Закрыть меню' : 'Открыть меню');
    });
  }

  // Выпадающие подменю: на мобильных раскрываются по тапу, а не по наведению
  if (headerMount) {
    headerMount.querySelectorAll('.dropdown > .nav-link').forEach((link) => {
      link.addEventListener('click', (e) => {
        if (window.innerWidth <= 768) {
          e.preventDefault();
          link.parentElement.classList.toggle('is-expanded');
        }
      });
    });
  }

  // JSON-LD Organization
  const script = document.createElement('script');
  script.type = 'application/ld+json';
  script.textContent = JSON.stringify(schemaOrg);
  document.head.appendChild(script);

  // ===== SEO-мета: geo, canonical, Open Graph, Twitter (на всех страницах) =====
  (function injectSeoMeta() {
    const head = document.head;
    const siteName = isDanila ? 'Данила Мастер' : 'Центр ритуальных услуг «Влата»';
    const lat = schemaOrg.geo ? schemaOrg.geo.latitude : 51.35;
    const lon = schemaOrg.geo ? schemaOrg.geo.longitude : 48.27;
    const descEl = document.querySelector('meta[name="description"]');
    const description = descEl ? descEl.getAttribute('content') : schemaOrg.description || '';
    const pageUrl = typeof location !== 'undefined' ? location.href.split('#')[0] : '';
    const ogImage = schemaOrg.image || '';

    function setMeta(attr, key, value) {
      if (!value) return;
      let el = head.querySelector(`meta[${attr}="${key}"]`);
      if (!el) {
        el = document.createElement('meta');
        el.setAttribute(attr, key);
        head.appendChild(el);
      }
      el.setAttribute('content', value);
    }

    // Тема мобильного браузера
    setMeta('name', 'theme-color', '#121212');
    // Гео-теги для локального SEO
    setMeta('name', 'geo.region', 'RU-SAR');
    setMeta('name', 'geo.placename', 'Ершов');
    setMeta('name', 'geo.position', `${lat};${lon}`);
    setMeta('name', 'ICBM', `${lat}, ${lon}`);
    // Open Graph
    setMeta('property', 'og:type', 'website');
    setMeta('property', 'og:site_name', siteName);
    setMeta('property', 'og:locale', 'ru_RU');
    setMeta('property', 'og:title', document.title);
    setMeta('property', 'og:description', description);
    setMeta('property', 'og:url', pageUrl);
    setMeta('property', 'og:image', ogImage);
    // Twitter Card
    setMeta('name', 'twitter:card', 'summary_large_image');
    setMeta('name', 'twitter:title', document.title);
    setMeta('name', 'twitter:description', description);
    setMeta('name', 'twitter:image', ogImage);

    // Canonical
    if (pageUrl) {
      let canonical = head.querySelector('link[rel="canonical"]');
      if (!canonical) {
        canonical = document.createElement('link');
        canonical.setAttribute('rel', 'canonical');
        head.appendChild(canonical);
      }
      canonical.setAttribute('href', pageUrl);
    }
  })();

  document.querySelectorAll('.cta-button, .service-button, .btn-order').forEach((button) => {
    button.addEventListener('click', () => {
      const isDanilaPage = document.body.dataset.brand === 'danila';
      const phoneNum = isDanilaPage ? '+7 (909) 331-68-77' : '+7 (927) 154-09-50';
      if (confirm(`Позвонить по номеру ${phoneNum}?`)) {
        window.location.href = `tel:${phoneNum.replace(/\D/g, '')}`;
      }
    });
  });
})();
