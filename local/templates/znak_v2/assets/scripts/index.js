import { modalSystem } from './modules/modal/modalSystem.js';
import { showMore } from './modules/showMore.js';

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
            console.log("#WIP[open]# Catalog - comming soon")
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
            open: () => console.log("#WIP[open]# Catalog - comming soon"),
            close: () => console.log("#WIP[close]# Catalog - comming soon")
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

        if (btn.classList.contains('increment')) {
            value++;
        } else {
            value = Math.max(1, value - 1);
        }

        input.value = value;

        input.dispatchEvent(new Event('change', { bubbles: true }));
    });


    modalSystem.register({
        id: "filter",
        selector: ".catalog-filter-sidebar",
    });

    document.querySelectorAll(".btn-filter").forEach((button) => {
        button.addEventListener("click", (e)=>{
            e.preventDefault();
            e.stopPropagation();

            if(!button || modalSystem.isOpen("filter")){
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
            buttonTextCollapsed : 'Показать еще',
        },
        animation: true,
        animationDuration: 300
    });
    
});


BX.ready(function(){
    BX.addCustomEvent('onIntensaFavoriteChange', function(data){
        if(data.success){
            document.querySelectorAll('[data-entity="favorite-counter"]').forEach(fCount => {
            
                if(!fCount){
                    return;
                }
                const button = fCount.closest('.btn-action');

                setTimeout(() =>{
                    fCount.classList.toggle("hidden", data.count == 0);
                        if(data.count > 0){
                        button.classList.add("active");                    
                        }else{
                            button.classList.remove("active");
                        }
                }, 300)                
            })
        }
    })
});