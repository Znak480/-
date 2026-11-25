function initSlider() {
    const gridEl = document.querySelector("#partners-list");
    if (!gridEl) return;

    let swiper = null;
    const mq = window.matchMedia("(max-width: 767px)");

    function createSwiper() {
        if (swiper) {
            swiper.destroy(true, true);
            swiper = null;
        }

        if (mq.matches) {
            swiper = new Swiper(gridEl, {
                loop: true,
                speed: 5000,
                autoplay: {
                    delay: 1,
                    disableOnInteraction: false, 
                },
                slidesPerView: 1.5, 
                spaceBetween: 8,
                breakpoints: {
                    425: {
                        slidesPerView: 2,
                    },
                    600:{
                        slidesPerView : 2.5,
                    }
                }
            });
        } else {
            swiper = new Swiper(gridEl, {
                spaceBetween: 6,
                grabCursor: true,
                slidesPerView: 3,
                grid: {
                    rows: 10,
                    fill: "row"
                },
                breakpoints: {
                    1024: {
                        slidesPerView: 5,
                        grid: { rows: 16, fill: "row" }
                    },
                    1440: {
                        slidesPerView: 6,
                        grid: { rows: 12, fill: "row" }
                    },
                    1920: {
                        slidesPerView: 7,
                        grid: { rows:  10, fill: "row" }
                    }
                }
            });
        }
    }

    createSwiper();
    mq.addEventListener("change", createSwiper);

    return swiper;
}

document.addEventListener("DOMContentLoaded", () => {
    initSlider();
});
