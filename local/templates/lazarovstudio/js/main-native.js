'use strict';

document.addEventListener('DOMContentLoaded', function() {
    // Инициализация всех функций
    new Main();
});

class Main {
    constructor() {
        this.init();
    }

    init() {
        this.smoothScroll();
        this.backToTopInit();
        this.headerSticky();
        this.wowActivation();
        this.headerTopActivation();
        this.masonryActivation();
        this.magnificPopup();
        this.swiperInit();
        this.radialProgress();
        this.menuCurrentLink();
        this.tooltipsInit();
        this.fancyboxInit();
        this.highlightCode();
        this.maskInit();
        this.waypointInit();
    }

    menuCurrentLink() {
        const currentPage = location.pathname.split('/');
        const current = currentPage[currentPage.length - 1];
        document.querySelectorAll('.mainmenu li a').forEach(function(link) {
            if (link.getAttribute('href') === current) {
                link.classList.add('active');
                const parentItem = link.closest('.has-menu-child-item');
                if (parentItem) {
                    parentItem.classList.add('menu-item-open');
                }
            }
        });
    }

    smoothScroll() {
        document.addEventListener('click', function(event) {
            const target = event.target.closest('.smoth-animation');
            if (target) {
                event.preventDefault();
                const href = target.getAttribute('href');
                const targetElement = document.querySelector(href);
                if (targetElement) {
                    const topOffset = targetElement.getBoundingClientRect().top + window.pageYOffset - 50;
                    window.scrollTo({
                        top: topOffset,
                        behavior: 'smooth'
                    });
                }
            }
        });
    }

    magnificPopup() {
        // Используем Fancybox вместо Magnific Popup
        // Реализация в fancyboxInit()
    }

    masonryActivation() {
        const grid = document.querySelector('.masonary-wrapper-activation');
        if (!grid) return;

        const items = grid.querySelectorAll('.masonary-item');
        const filters = document.querySelectorAll('.masonary-menu button');

        filters.forEach(filter => {
            filter.addEventListener('click', () => {
                const category = filter.dataset.filter;
                
                filters.forEach(f => f.classList.remove('active'));
                filter.classList.add('active');

                items.forEach(item => {
                    if (category === '*' || item.classList.contains(category)) {
                        item.style.display = 'block';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        });
    }

    backToTopInit() {
        const scrollTop = document.querySelector('.rn-back-top');
        
        if (scrollTop) {
            window.addEventListener('scroll', function() {
                const topPos = window.pageYOffset;
                if (topPos > 150) {
                    scrollTop.style.opacity = '1';
                } else {
                    scrollTop.style.opacity = '0';
                }
            });
            
            scrollTop.addEventListener('click', function(e) {
                e.preventDefault();
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            });
        }
    }

    headerSticky() {
        const headerSticky = document.querySelector('.header-sticky');
        
        if (headerSticky) {
            window.addEventListener('scroll', function() {
                if (window.pageYOffset > 250) {
                    headerSticky.classList.add('sticky');
                } else {
                    headerSticky.classList.remove('sticky');
                }
            });
        }
    }

    wowActivation() {
        // Проверяем наличие библиотеки WOW
        if (typeof WOW === 'function') {
            new WOW().init();
        }
    }

    headerTopActivation() {
        const activationButtons = document.querySelectorAll('.bgsection-activation');
        const headerTopNews = document.querySelector('.header-top-news');
        
        if (activationButtons.length && headerTopNews) {
            activationButtons.forEach(button => {
                button.addEventListener('click', function() {
                    headerTopNews.classList.add('deactive');
                });
            });
        }
    }

    radialProgress() {
        const progressElements = document.querySelectorAll('.radial-progress');
        if (!progressElements.length) return;

        progressElements.forEach(element => {
            const value = element.dataset.value;
            const size = 220;
            const strokeWidth = 20;
            const radius = (size - strokeWidth) / 2;
            const circumference = radius * 2 * Math.PI;
            const offset = circumference - (value / 100) * circumference;

            const svg = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
            svg.setAttribute('class', 'circular-chart');
            svg.setAttribute('width', size);
            svg.setAttribute('height', size);
            svg.setAttribute('viewBox', `0 0 ${size} ${size}`);

            const circle = document.createElementNS('http://www.w3.org/2000/svg', 'circle');
            circle.setAttribute('cx', size / 2);
            circle.setAttribute('cy', size / 2);
            circle.setAttribute('r', radius);
            circle.setAttribute('stroke-width', strokeWidth);
            circle.setAttribute('stroke', '#c231a1');
            circle.setAttribute('fill', 'none');
            circle.setAttribute('stroke-dasharray', `${circumference} ${circumference}`);
            circle.setAttribute('stroke-dashoffset', circumference);

            svg.appendChild(circle);
            element.appendChild(svg);

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        circle.style.transition = 'stroke-dashoffset 1.5s ease-in-out';
                        circle.style.strokeDashoffset = offset;
                    }
                });
            });

            observer.observe(element);
        });
    }

    swiperInit() {
        const sliders = document.querySelectorAll('.swiper-container');
        if (!sliders.length) return;

        sliders.forEach(slider => {
            new Swiper(slider, {
                slidesPerView: 1,
                spaceBetween: 30,
                loop: true,
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true
                },
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev'
                }
            });
        });
    }

    tooltipsInit() {
        // Нативная реализация тултипов
        const tooltipElements = document.querySelectorAll('[data-tooltip]');
        if (!tooltipElements.length) return;

        tooltipElements.forEach(element => {
            element.addEventListener('mouseenter', () => {
                const tooltip = element.getAttribute('data-tooltip');
                const tooltipElement = document.createElement('div');
                tooltipElement.className = 'tooltip';
                tooltipElement.textContent = tooltip;
                document.body.appendChild(tooltipElement);

                const rect = element.getBoundingClientRect();
                tooltipElement.style.position = 'absolute';
                tooltipElement.style.top = `${rect.top - tooltipElement.offsetHeight - 10}px`;
                tooltipElement.style.left = `${rect.left + (rect.width - tooltipElement.offsetWidth) / 2}px`;
            });

            element.addEventListener('mouseleave', () => {
                const tooltip = document.querySelector('.tooltip');
                if (tooltip) {
                    tooltip.remove();
                }
            });
        });
    }

    fancyboxInit() {
        // Инициализация Fancybox, если есть
        if (typeof Fancybox !== 'undefined') {
            Fancybox.bind("[data-fancybox]");
        }
    }

    highlightCode() {
        // Подсветка синтаксиса
        if (typeof hljs !== 'undefined') {
            document.querySelectorAll('pre code').forEach((el) => {
                hljs.highlightElement(el);
            });
        }
    }

    maskInit() {
        const phoneInputs = document.querySelectorAll('input[type="tel"]');
        if (!phoneInputs.length) return;

        phoneInputs.forEach(input => {
            input.addEventListener('input', (e) => {
                let x = e.target.value.replace(/\D/g, '').match(/(\d{0,1})(\d{0,3})(\d{0,3})(\d{0,2})(\d{0,2})/);
                e.target.value = !x[2] ? x[1] : '+' + x[1] + ' (' + x[2] + ') ' + x[3] + (x[4] ? '-' + x[4] : '') + (x[5] ? '-' + x[5] : '');
            });

            input.addEventListener('focus', () => {
                if (!input.value) {
                    input.value = '+7 (';
                }
            });

            input.addEventListener('blur', () => {
                if (input.value === '+7 (') {
                    input.value = '';
                }
            });
        });
    }

    waypointInit() {
        const elements = document.querySelectorAll('.wow');
        if (!elements.length) return;

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animated');
                    observer.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.1
        });

        elements.forEach(element => {
            observer.observe(element);
        });
    }
}

// Инициализация мобильного меню
const initMobileMenu = function() {
    const btnMobileNav = document.querySelector('.mobile-menu-bar');
    const closeMobileNav = document.querySelector('.close-menu');
    const openbgNav = document.querySelector('.popup-mobile-menu');
    const openMobileNav = document.querySelector('.inner');
    
    if (btnMobileNav && openbgNav && openMobileNav) {
        const showMenu = () => {
            openbgNav.style.visibility = 'unset';
            openbgNav.style.opacity = '1';
            openMobileNav.style.left = '0';
            openMobileNav.style.opacity = '1';
        };
    
        const hideMenu = () => {
            openbgNav.style.visibility = 'hidden';
            openbgNav.style.opacity = '0';
            openMobileNav.style.left = '-150px';
            openMobileNav.style.opacity = '0';
        };
    
        btnMobileNav.addEventListener("click", showMenu);
        
        if (closeMobileNav) {
            closeMobileNav.addEventListener("click", hideMenu);
        }
    }
};

// Вызываем инициализацию мобильного меню после загрузки DOM
document.addEventListener('DOMContentLoaded', initMobileMenu); 