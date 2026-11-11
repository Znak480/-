import { modalSystem } from './modules/modal/modalSystem.js';
import { showMore } from './modules/showMore.js';


window.modalSystem = modalSystem;
// Класс отвечающий за контроль состояния элемента аккордина на странице
class AccordionItem {
    constructor(element) {
        if (!element) {
            throw new Error('Accordion item must have an element');
        }

        this.element = element;

        this.header = element.querySelector('[data-item="header"]');
        this.body = element.querySelector('[data-item="body"]');

        this.element.dataset.state = "closed";
        this.header?.addEventListener('click', () => this.toggle());
    }

    open() {
        if (this.isOpen()) {
            return;
        }

        this.header.setAttribute("aria-expanded", true);
        this.header.classList.add('open');

        this.body.classList.add('active');
        this.element.dataset.state = "open";

        //Кастомный Event для реализации поведения после открытия меню
        this.element.dispatchEvent(new CustomEvent('accordion:open'));
    }

    close() {
        if (!this.isOpen()) {
            return;
        }

        this.header.setAttribute("aria-expanded", false);
        this.header.classList.remove('open');

        this.body.classList.remove('active');
        this.element.dataset.state = "closed";

        //Кастомный Event для реализации поведения после закрытия меню
        this.element.dispatchEvent(new CustomEvent('accordion:close'));
    }


    toggle() {
        this.isOpen() ? this.close() : this.open();
    }

    isOpen() {
        return this.element.dataset.state === 'open';
    }
}

// Класс отвечающий за управление аккордеоном на странице
class Accordion {

    // Конструктор класса Accordion принисмает два параметра:
    // container - селектор контейнера в котором находится список элементов
    // options - объект опций
    constructor(container, options = {}) {
        this.container = document.querySelector(container);

        if (!this.container) {
            return;
        }

        this.items = [];
        this.options = { closeOthers: true, ...options };
        this.init();
    }


    // Инициализация элементов посредством передачи элемента аккордина в обьект класса AccordeonItem
    init() {
        const itemElements = this.container.querySelectorAll('[data-entity="accordion-item"]');
        itemElements.forEach(el => {
            const item = new AccordionItem(el);
            this.items.push(item);

            el.addEventListener('accordion:open', () => this.onItemOpen(item));
            el.addEventListener('accordion:close', () => this.onItemClose(item));
        });

        console.log(this);
    }

    // Открытие элемента аккордиона
    // openedItem - открываемый элемент представленный объектом класса AccordionItem
    onItemOpen(openedItem) {
        if (this.options.closeOthers) {
            this.items.forEach(item => {
                if (item !== openedItem && item.isOpen()) item.close();
            });
        }
    }

    //TODO: добавить обработчик события закрытие элемента
    onItemClose(closedItem) { }

    openAll() { this.items.forEach(item => item.open()); }
    closeAll() { this.items.forEach(item => item.close()); }
}

function closeDropdowns() {
    document.querySelectorAll('.region-dropdown.open')
        .forEach(el => el.classList.remove('open'));

    document.querySelectorAll('.title-search-result.active')
        .forEach(el => {
            el.classList.remove('active');
            el.style.display = 'none';
        });
}

function getHeaderHeight() {
    const mobileHeader = document.querySelector('.header-mobile');
    const desktopHeader = document.querySelector('.header-desktop');

    let header = null;
    let headerHeight = 0;

    if (desktopHeader && window.getComputedStyle(desktopHeader).display !== 'none') {
        header = desktopHeader;
        headerHeight = desktopHeader.offsetHeight;
    } else if (mobileHeader && window.getComputedStyle(mobileHeader).display !== 'none') {
        header = mobileHeader;
        headerHeight = mobileHeader.offsetHeight;
    }

    if (!header) return 0;

    return header.getBoundingClientRect().top + window.scrollY + headerHeight;
}

function updateFixedHeader() {
    const fixedHeader = document.querySelector('.header-fixed');
    if (!fixedHeader) return;

    const triggerPoint = getHeaderHeight();

    if (window.scrollY > triggerPoint) {
        fixedHeader.classList.add('active');
    } else {
        fixedHeader.classList.remove('active');
    }

    const openDropdowns = document.querySelectorAll('.region-dropdown.open');
    openDropdowns.forEach(function (dropdown) {
        const parentFixed = dropdown.closest('.header-fixed');
        if (!parentFixed || !parentFixed.classList.contains('active')) {
            dropdown.classList.remove('open');
        }
    });

}

let scrollTimer;
window.addEventListener('scroll', () => {
    clearTimeout(scrollTimer);
    scrollTimer = setTimeout(closeDropdowns, 100);
}, { passive: true });


document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
        closeDropdowns();
        modalSystem.closeAll();
    }
});

document.addEventListener('click', (e) => {
    const isPopup = e.target.closest('.region-selector') ||
        e.target.closest('.header-input') ||
        e.target.closest('.btn-burger') ||
        e.target.closest('.modal');

    if (!isPopup) {
        closeDropdowns();
    }
});


function bindStickyElementTop(){
    const element = document.querySelector("[data-element='sticky']");
    const headerFixed = document.querySelector('.header-fixed');

    if(!element) return;

    const headerHeight = headerFixed.offsetHeight;
    const topGap = headerHeight + 10;

    element.style.top = `${topGap}px`
}

//Загрузка контента
document.addEventListener('DOMContentLoaded', (event) => {
    bindStickyElementTop();

    const btnBanner = document.querySelector(".btn-rang-close");

    if(btnBanner){
        btnBanner.addEventListener('click', (e) => {
            e.stopPropagation();
            e.preventDefault();
            const section = e.target.closest(".banner-section");
            
            if(!section) return;
            
            section.classList.add("closing");

            section.addEventListener('transitionend', (e) => {
                if (e.propertyName !== 'max-height') return;
                section.classList.add('hidden');
            }, { once: true });
        })
    }

    modalSystem.register({
        id: 'mobile-sidebar',
        selector: '#mobile-menu'
    });


    function openContext() {
        const windowWidth = window.innerWidth;

        if (windowWidth < 768) {
            modalSystem.open('mobile-sidebar');
        } else {
            window.location.href = '/catalog';
        }

    }

    const actions = {
        'mobile-sidebar': {
            open: () => modalSystem.open('mobile-sidebar'),
            close: () => modalSystem.close('mobile-sidebar'),
            toggle: () => {
                if (modalSystem.isOpen('mobile-sidebar')) {
                    modalSystem.close('mobile-sidebar');
                } else {
                    modalSystem.open('mobile-sidebar');
                }
            }
        },
        'catalog': {
            open: () => window.location.href = '/catalog',
        },
        'toggle-action': {
            open: () => openContext()
        }
    };

    document.querySelectorAll(".btn-burger").forEach((button) => {
        const menuType = button.dataset.menu;
        if (!menuType) {
            console.warn('Кнопка без data-menu:', button);
            return;
        }

        const action = actions[menuType];
        if (!action) {
            console.error(`Действие не найдено: ${menuType}`);
            return;
        }

        button.addEventListener("click", function (e) {
            e.preventDefault();
            e.stopPropagation();

            if (action.toggle) {
                action.toggle();
            } else if (action.open) {
                action.open();
            }
        })

        window.addEventListener('scroll', () => updateFixedHeader());
        window.addEventListener('resize', () => updateFixedHeader());

        updateFixedHeader();

    });


    document.addEventListener('click', function (e) {
        const btn = e.target.closest('.increment, .decrement');
        if (!btn) return;

        e.preventDefault();

        const input = btn.closest('.input-number').querySelector('.quantity');
        let value = parseInt(input.value) || 1;
        let modificator = 1;
        if (btn.classList.contains('increment')) {
            value++;
        } else {
            value = Math.max(input.min, value - 1);
            modificator = -1;
        }

        input.value = value;

        const event = new Event('change', { bubbles: true });
        event.modificator = modificator;

        input.dispatchEvent(event)
    });


    modalSystem.register({
        id: "filter",
        selector: ".catalog-filter-sidebar",
    });

    document.querySelectorAll(".btn-filter").forEach((button) => {
        button.addEventListener("click", (e) => {
            e.preventDefault();
            e.stopPropagation();

            if (!button || modalSystem.isOpen("filter")) {
                return;
            }

            modalSystem.open("filter")
        });
    });

    showMore({
        container: '.filter-checkbox-list',
        itemSelector: '.filter-checkbox',
        divider: '.filter-divider',
        visibleCount: 4,
        button: {
            buttonSelector: '.btn-show-more',
            buttonTextExpanded: 'Свернуть',
            buttonTextCollapsed: 'Показать еще',
        },
        animation: true,
        animationDuration: 300
    });

    //Инициализация аккордеона на странице design_project (Дизайн проект)
    const accordion = new Accordion(".design-aq-list", { closeOthers: false, })

    let resizeTimeout;
    window.addEventListener('resize', function () {
        clearTimeout(resizeTimeout);
        resizeTimeout = setTimeout(function () {
            window.updateSliderMouseover();
        }, 250);
    });

    window.loadProductSlider();

    window.updateSliderMouseover();
});


let productSliders = [];

window.loadProductSlider = function () {
    productSliders.forEach(slider => {
        if (slider && slider.destroy) {
            slider.destroy(true, true);
        }
    });
    productSliders = [];

    document.querySelectorAll('[data-card="product-slider"]').forEach(function (element, index) {
        const bannerContainer = element.closest(".product-card-banner-container");

        if (element.swiper) {
            element.swiper.destroy(true, true);
        }

        const swiperInstance = new Swiper(element, {
            modules: [MouseoverPlugin],
            slidesPerView: 1,
            mouseover: {
                el: element.querySelector(".swiper-mouseover"),
                reset: true,
            },
            observer: true,
            observeParents: true,
            observeSlideChildren: true,
            resizeObserver: true,

            pagination: {
                el: bannerContainer.querySelector(".swiper-pagination"),
                type: 'bullets',
            },
        });

        // Сохраняем ссылку на экземпляр в DOM элементе
        element.swiper = swiperInstance;
        productSliders[index] = swiperInstance;

        let touchTimeout;
        swiperInstance.on('touchEnd', function (swiper, event) {
            clearTimeout(touchTimeout);
            touchTimeout = setTimeout(() => {
                swiperInstance.slideTo(0);
            }, 2000);
        });
    });

    return productSliders;
};

// Функция обновления эффекта mouseover при ресайзе
window.updateSliderMouseover = function () {
    const sliders = productSliders.length ? productSliders : window.loadProductSlider();
    const width = window.innerWidth;

    sliders.forEach(slider => {
        if (!slider || !slider.el) return;

        const mouseover = slider.el.querySelector(".swiper-mouseover");
        if (!mouseover) return;

        if (width > 1024) {
            mouseover.style.visibility = "visible";
        } else {
            mouseover.style.visibility = "hidden";
        }
    });
};

BX.ready(function () {
    BX.addCustomEvent('onIntensaFavoriteChange', function (data) {
        if (data.success) {
            document.querySelectorAll('[data-entity="favorite-counter"]').forEach(fCount => {

                if (!fCount) {
                    return;
                }
                const button = fCount.closest('.btn-action');

                setTimeout(() => {
                    fCount.classList.toggle("hidden", data.count == 0);
                    if (data.count > 0) {
                        button.classList.add("active");
                    } else {
                        button.classList.remove("active");
                    }
                }, 300)
            })
        }
    })
});