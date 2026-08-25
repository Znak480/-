BX.ready(function(){
    
    const { initSlider } = window.sliders;

    const slider = initSlider('#design-reviews-slider', {
        slidesPerView: 1,
        spaceBetween: 14,
        centeredSlides: false,
        slidesPerGroup: 1, 
        breakpoints: {
            440: {
                slidesPerView: 1.2,
                slidesPerGroup: 1,
            },
            600: {
                slidesPerView: 1.5,
                slidesPerGroup: 1,
            },
            680: {
                slidesPerView: 2,
                slidesPerGroup: 1,
            },
            1024: {
                slidesPerView: 2.5,
                slidesPerGroup: 1,
            },
            1280: {
                slidesPerView: 3,
                slidesPerGroup: 1,
            }
        }
    });


    function updateEventUI(swiper){
        const slides = swiper.el.querySelectorAll(".design-reviews-slide");
        
        slides.forEach((item) => {
            const wrapper = item.querySelector('.review-content-wrapper');

            const isExpanded = wrapper.classList.contains('expanded');
            
            if (isExpanded) {
                wrapper.classList.remove("expanded");
                wrapper.classList.add('collapsed');
                wrapper.style.maxHeight = '200px';

                const button = item.querySelector('.btn-show-more');
                if (button) {
                    button.classList.remove('expanded');
                    const span = button.querySelector('span');
                    if (span) {
                        span.textContent = 'Показать еще';
                    }
                }
            }
        })
    }


    function resizeCollapsed(wrapper, button){
        const fullHeight = wrapper.scrollHeight;
        
        if (fullHeight <= 200) {
            button.style.visibility = 'hidden';
            button.style.pointerEvents = 'none';
            wrapper.classList.remove('collapsed');
            wrapper.style.maxHeight = 'none';
        } else {
            button.style.visibility = 'visible';
            button.style.pointerEvents = 'auto';
            wrapper.classList.add('collapsed');
            wrapper.style.maxHeight = '200px';
        }
        
    }
    let isSlideChange = false;
    slider.on("slideChange", (swiper) => {
        isSlideChange = true;
        updateEventUI(swiper)
        setTimeout(() => isSlideChange = false, 300);
    });


    window.addEventListener('resize', function(target){
        if (isSlideChange) return;

        const slides = document.querySelectorAll(".design-reviews-slide");

        slides.forEach((item) => {
            const wrapper = item.querySelector('.review-content-wrapper');
            const button = item.querySelector('.btn-show-more');

            resizeCollapsed(wrapper, button)
        })
    });
   
    
    const buttons = document.querySelectorAll('.btn-show-more');
    
    buttons.forEach(button => {
        const slideBody = button.closest('.reviews-slide-body');
        const wrapper = slideBody.querySelector('.review-content-wrapper');
        const text = wrapper.querySelector('.review-text');

        resizeCollapsed(wrapper, button)
        
        
        button.addEventListener('click', function() {
            const isExpanded = wrapper.classList.toggle('expanded');
            
            if (isExpanded) {
                wrapper.classList.remove('collapsed');
                wrapper.style.maxHeight = wrapper.scrollHeight + 'px';
            } else {
                wrapper.classList.add('collapsed');
                wrapper.style.maxHeight = '200px';
            }
            
            this.classList.toggle('expanded');
            this.querySelector('span').textContent = isExpanded ? 'Скрыть' : 'Показать еще';
        });
    });
})