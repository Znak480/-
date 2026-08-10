(function() {
    "use strict";
  
    function createElementFromHtml(htmlString) {
        const div = document.createElement('div');
        div.innerHTML = htmlString.trim();
        return div.firstChild;
    }

    function initSlider(selector, options) {
        const container = document.querySelector(selector);
        if (!container) return;

        const uid = Date.now() + Math.random().toString(36).substr(2, 6);
        const prevId = `swiper-prev-${uid}`;
        const nextId = `swiper-next-${uid}`;

        const wrapper = document.createElement('div');
        wrapper.classList.add('swiper-container');
        wrapper.id = `swiper-container-${uid}`;
        container.parentNode.insertBefore(wrapper, container);
        wrapper.appendChild(container);


        let prevBtn = container.querySelector('.znak-prev-btn');
        if (!prevBtn) {
            const prevHtml = `<button id="${prevId}" class="znak-slider-btn znak-prev-btn">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M10.8284 12.0007L15.7782 16.9504L14.364 18.3646L8 12.0007L14.364 5.63672L15.7782 7.05093L10.8284 12.0007Z"></path>
                </svg>
            </button>`;
            prevBtn = createElementFromHtml(prevHtml);
            wrapper.appendChild(prevBtn);
        } else {
            prevBtn.id = prevId;
        }

        let nextBtn = container.querySelector('.znak-next-btn');
        if (!nextBtn) {
            const nextHtml = `<button id="${nextId}" class="znak-slider-btn znak-next-btn">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M13.1717 12.0007L8.22192 7.05093L9.63614 5.63672L16.0001 12.0007L9.63614 18.3646L8.22192 16.9504L13.1717 12.0007Z"></path>
                </svg>
            </button>`;
            nextBtn = createElementFromHtml(nextHtml);
            wrapper.appendChild(nextBtn);
        } else {
            nextBtn.id = nextId;
        }

        const needPagination = options.pagination;

        let paginationConfig = {};
        if (needPagination) {
            const paginationId = `swiper-pagination-${uid}`;
            let paginationEl = container.querySelector('.swiper-pagination');
            if (!paginationEl) {
                paginationEl = createElementFromHtml(`<div id="${paginationId}" class="swiper-pagination banner-pagination"></div>`);
                wrapper.appendChild(paginationEl);
            } else {
                paginationEl.id = paginationId;
            }

            if (typeof options.pagination === 'object') {
                paginationConfig = {
                    ...options.pagination,
                    el: `#${paginationId}`,
                };
            } else {
                paginationConfig = {
                    el: `#${paginationId}`,
                    clickable: true,
                };
            }
        }

        const swiperOptions = {
            ...options,
            pagination: needPagination ? paginationConfig : false,
            navigation: {
                prevEl: `#${prevId}`,
                nextEl: `#${nextId}`,
            },
        };
        console.log(needPagination, options.pagination)
        const swiper = new Swiper(container, swiperOptions);
        return swiper;
    }

    function fixPlaceholderHeight() {
        const slides = document.querySelectorAll('.swiper-slide');
        if (slides.length === 0) return;

        let targetHeight = null;

        for (let i = 0; i < slides.length; i++) {
            const img = slides[i].querySelector('img');
            if (img && !slides[i].querySelector('.plug-banner')) {
                targetHeight = slides[i].offsetHeight;
                break;
            }
        }

        if (!targetHeight) {
            targetHeight = Math.min(window.innerWidth * 0.5, 600);
        }

        slides.forEach(slide => {
            const plug = slide.querySelector('.banner-swiper');
            if (plug) {
                slide.style.height = targetHeight + 'px';
                plug.style.height = '100%';
            }
        });
    }

    window.sliders = {
        initSlider: initSlider,
        fixPlaceholderHeight: fixPlaceholderHeight
    };

})();