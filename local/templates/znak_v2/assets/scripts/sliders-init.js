(function () {
    "use strict";

    // Ждём загрузки DOM
    BX.ready(function () {
        // Проверяем, что Swiper загружен
        if (typeof Swiper === 'undefined') {
            console.warn('Swiper not loaded');
            return;
        }

        // Проверяем, что наши функции доступны
        if (typeof window.sliders === 'undefined') {
            console.warn('Sliders functions not loaded');
            return;
        }

        const { initSlider } = window.sliders;

        // Настройки для баннеров
        const bannerOptions = {
            slidesPerView: 1.25,
            spaceBetween: 12,
            loop: true,
            pagination: {
                clickable: true,
            },
            breakpoints: {
                576: {
                    centeredSlides: true,
                    slidesPerView: 1.5,
                    slidesToScroll: 1,
                },
                768: {
                    slidesPerView: 1,
                },
            },
        };  

        // Инициализация слайдеров
        initSlider('#hero-banner', bannerOptions);
        initSlider('#promo-banner', bannerOptions);

        initSlider('#services-slider2', {
            slidesPerView: 2,
            spaceBetween: 12,
            navigation: false,
            breakpoints: {
                480: {
                    slidesPerView: 2,
                    spaceBetween: 12,
                },
                500: {
                    slidesPerView: 4,
                    spaceBetween: 16,
                },
                768: {
                    slidesPerView: 'auto',
                    spaceBetween: 20,
                }
            }
        });

        initSlider("#popular-cards-slider", {
            slidesPerView: 2,
            spaceBetween: 12,
            navigation: false,
            
            breakpoints: {
                480: { slidesPerView: 3.25, spaceBetween: 14 },
                768: { slidesOffsetAfter: 0, slidesPerView: 3.5, spaceBetween: 16 },
                1024: { slidesPerView: 4, spaceBetween: 20 }
            }
        });

        initSlider('#advice-slider', {
            slidesPerView: 1.05,
            spaceBetween: 12,
            slidesOffsetAfter: 16,
            breakpoints: {
                380: { slidesPerView: 1.25, slidesOffsetAfter: 0, spaceBetween: 16 },
                479: { slidesPerView: 1.5 },
                616: { slidesPerView: 2, spaceBetween: 16 },
                768: { slidesPerView: 2.5, spaceBetween: 20 },
                1024: { slidesPerView: 2.75, spaceBetween: 24 },
                1280: { slidesPerView: 3, spaceBetween: 24 },
                1536: { slidesPerView: 3.5, spaceBetween: 28 }
            }
        });

        // Фикс высоты
        setTimeout(window.sliders.fixPlaceholderHeight, 100);
    });

    // Фикс при загрузке и ресайзе
    window.addEventListener('load', () => {
        setTimeout(window.sliders.fixPlaceholderHeight, 100);
    });

    window.addEventListener('resize', () => {
        setTimeout(window.sliders.fixPlaceholderHeight, 200);
    });

   
})(BX, Swiper);