import { modalSystem } from './modules/modal/modalSystem.js';
import { showMore } from './modules/showMore.js';

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

        if(!this.container){
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

//Загрузка контента
document.addEventListener('DOMContentLoaded', (event) => {
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
            open: () =>  window.location.href = '/catalog',
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

    //TODO: реализовать корректное отображение номера телефона
    //Добавить в модальное окно номер телефона
    modalSystem.register({
        id: "raspil-ldsp",
        title: "Хотите заказать услугу, позвоните нам",
        content: '<a href="tel:" class="phone-number">tel:</a>'
    });


    document.addEventListener("click", function (el) {
        const button = el.target.closest('[data-entity="btn-raspilovka"]');

        if(!button) return;

        modalSystem.open("raspil-ldsp");
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
});


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