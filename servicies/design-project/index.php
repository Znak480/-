<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Дизайн проект");
?>
<div data-page="design-project">
  <?$APPLICATION->IncludeComponent(
      "bitrix:breadcrumb", 
      "znak", 
      array(
          "COMPONENT_TEMPLATE" => ".default",
          "START_FROM" => "0",
          "PATH" => "",
          "SITE_ID" => "-",
      ),
      false
  );?>

  <section class="section design-project">
    <div class="design-hero">
      <div class="design-hero-background-element">
        <img 
          src="<?= SITE_TEMPLATE_PATH ?>/assets/image/design-project/hero-background-element.jpg" 
          alt=""
        >  
      </div>

      <div class="container"> 
        <div class="design-hero-content">
          <h1 class="design-hero-title">Бесплатный дизайн-проект ванной комнаты от сотрудников гипермаркета «ЗНАК»</h1>
          <p class="design-hero-description">Наши специалисты подготовят 3D‑визуализацию вашей ванной и подберут все необходимые материалы</p>
          <div class="design-hero-cta">
            <a href="https://crm.ceramic3d.com/organization/7d30a84d-f4c9-45ab-85eb-0eca70132114/project-lead?project-id=30cf9a62-7291-4d75-8902-148786a8d2a1" class="btn btn-neutral">Записаться</a> 
          </div>
        </div>
      </div>
    </div>

    <div class="design-features">
        <div class="container">
            <div class="design-features-content">
                <!-- Feature start -->
                <article class="design-feature-card" tabindex="0">
                    <h3 class="feature-item-title">3D-визуализация</h3>
                    <p class="feature-item-description">сразу увидите, как будет выглядеть ванная до начала ремонта</p>
                </article>
                <!-- Feature end -->

                <!-- Feature start -->
                <article class="design-feature-card" tabindex="0">
                    <h3 class="feature-item-title">Подбор материалов</h3>
                    <p class="feature-item-description">плитка, сантехника и мебель под стиль и бюджет</p>
                </article>
                <!-- Feature end -->

                <!-- Feature start -->
                <article class="design-feature-card" tabindex="0">
                    <h3 class="feature-item-title">Индивидуальный подход</h3>
                    <p class="feature-item-description">проект создаётся с учётом всех ваших пожеланий и особенностей помещения</p>
                </article>
                <!-- Feature end -->
            </div>
        </div> 
    </div>

    <div class="design-ideas">
        <div class="container">
            <h2>Идеи, реализованных проектов</h2>
        </div>
        <div class="container resizeble-container">
            <div class="swiper" id="design-ideas-slider">
                  <div class="swiper-wrapper">
                    
                    <a 
                        href="/local/templates/znak_v2/assets/image/design-project/banner/b1.jpg"
                        data-fancybox="ideas"
                        class="swiper-slide design-ideas-slide fancybox"
                    >
                        <img src="/local/templates/znak_v2/assets/image/design-project/banner/b1.jpg" alt="" srcset="">
                    </a>
                   
                    <a 
                        href="/local/templates/znak_v2/assets/image/design-project/banner/b2.jpg"
                        data-fancybox="ideas"
                        class="swiper-slide design-ideas-slide fancybox"
                    >
                        <img src="/local/templates/znak_v2/assets/image/design-project/banner/b2.jpg" alt="" srcset="">
                    </a>
                   
                    <a 
                        href="/local/templates/znak_v2/assets/image/design-project/banner/b3.jpg"
                        data-fancybox="ideas"
                        class="swiper-slide design-ideas-slide fancybox"
                    >
                        <img src="/local/templates/znak_v2/assets/image/design-project/banner/b3.jpg" alt="" srcset="">
                    </a>
                   
                    <a 
                        href="/local/templates/znak_v2/assets/image/design-project/banner/b4.jpg"
                        data-fancybox="ideas"
                        class="swiper-slide design-ideas-slide fancybox"
                    >
                        <img src="/local/templates/znak_v2/assets/image/design-project/banner/b4.jpg" alt="" srcset="">
                    </a>
                   
                    <a 
                        href="/local/templates/znak_v2/assets/image/design-project/banner/b5.jpg"
                        data-fancybox="ideas"
                        class="swiper-slide design-ideas-slide fancybox"
                    >
                        <img src="/local/templates/znak_v2/assets/image/design-project/banner/b5.jpg" alt="" srcset="">
                    </a>
                   
                    <a 
                        href="/local/templates/znak_v2/assets/image/design-project/banner/b6.jpg"
                        data-fancybox="ideas"
                        class="swiper-slide design-ideas-slide fancybox"
                    >
                        <img src="/local/templates/znak_v2/assets/image/design-project/banner/b6.jpg" alt="" srcset="">
                    </a>

                    <a 
                        href="/local/templates/znak_v2/assets/image/design-project/banner/b7.jpg"
                        data-fancybox="ideas"
                        class="swiper-slide design-ideas-slide fancybox"
                    >
                        <img src="/local/templates/znak_v2/assets/image/design-project/banner/b7.jpg" alt="" srcset="">
                    </a>

                    <a 
                        href="/local/templates/znak_v2/assets/image/design-project/banner/b8.jpg"
                        data-fancybox="ideas"
                        class="swiper-slide design-ideas-slide fancybox"
                    >
                        <img src="/local/templates/znak_v2/assets/image/design-project/banner/b8.jpg" alt="" srcset="">
                    </a>
                   
                    
                </div>
            </div>
        </div>
    </div>

    <div class="design-aq">
        <div class="container">
            <h2>Вопрос-ответ</h2>
            <?$APPLICATION->IncludeComponent(
                "bitrix:news.list",
                "design_faq",
                array(
                    "IBLOCK_TYPE" => "design_project",              
                    "IBLOCK_ID" => "39",                

                    "ACTIVE_DATE_FORMAT" => "d.m.Y",     
                    
                    "SORT_BY1" => "ACTIVE_FROM",         
                    "SORT_ORDER1" => "DESC",             
                    "ADD_SECTIONS_CHAIN" => "N",
                    "INCLUDE_IBLOCK_INTO_CHAIN" => "N",

                    "NEWS_COUNT" => "30",               
                    "DISPLAY_BOTTOM_PAGER" => "N",      
                    "PAGER_TITLE" => "",      
                    "PAGER_SHOW_ALWAYS" => "N",       
                    
                    "FIELD_CODE" => array(                
                        "NAME",
                        "PREVIEW_TEXT",
                        "PREVIEW_PICTURE",
                        "DETAIL_PAGE_URL"
                    ),
                    
                    "PROPERTY_CODE" => array(   
                        "CTA",
                        "ANSWER",
                        "QUESTION"
                    ),
                    
                    "DISPLAY_PANEL" => "N",              
                    "SET_TITLE" => "N",                  
                    "SET_STATUS_404" => "N",            
                
                    "DISPLAY_NAME" => "N",                
                    "DETAIL_URL" => "",                   
                    
                    "CACHE_TYPE" => "A",                  
                    "CACHE_TIME" => "36000000",          
                    "CACHE_FILTER" => "Y",                
                    "CACHE_GROUPS" => "Y",                
                ),
                false
            );?>
        </div>
    </div>

    <div class="design-reviews">
        <div class="container">
            <h2>Отзывы</h2>
            <?$APPLICATION->IncludeComponent(
                "bitrix:news.list",
                "design_review",
                [
                    "IBLOCK_TYPE" => "design_project",              
                    "IBLOCK_ID" => "40",                

                    "ACTIVE_DATE_FORMAT" => "d.m.Y",     
                    
                    "SORT_BY1" => "ACTIVE_FROM",         
                    "SORT_ORDER1" => "DESC",             
                    "ADD_SECTIONS_CHAIN" => "N",
                    "INCLUDE_IBLOCK_INTO_CHAIN" => "N",

                    "NEWS_COUNT" => "30",               
                    "DISPLAY_BOTTOM_PAGER" => "N",      
                    "PAGER_TITLE" => "Вопрос-ответ",      
                    "PAGER_SHOW_ALWAYS" => "N",       
                    
                    "FIELD_CODE" => array(                
                        "NAME",
                        "PREVIEW_TEXT",
                        "PREVIEW_PICTURE",
                        "DETAIL_PAGE_URL"
                    ),
                    
                    "PROPERTY_CODE" => array(   
                        "AUTOR",
                        "REVIEW_TEXT",
                        "IMAGE",
                        "LINK_TO_REVIEW",
                        "RATING"
                    ),
                    
                    "DISPLAY_PANEL" => "N",              
                    "SET_TITLE" => "N",                  
                    "SET_STATUS_404" => "Y",            
                
                    "DISPLAY_NAME" => "Y",                
                    "DETAIL_URL" => "",                   
                    
                    "CACHE_TYPE" => "A",                  
                    "CACHE_TIME" => "36000",          
                    "CACHE_FILTER" => "Y",                
                    "CACHE_GROUPS" => "Y",                
                ],
                false
            );?>
        </div>
    </div>

    <div class="cta-block">
        <div class="container">
            <div class="cta-block-content">
                <h2 class="cta-card-title">Посмотрите больше проектов</h2>
                <p class="cta-card-description">
                    Изучите готовые решения и найдите идеи для своей ванной 
                    — в нашей галерее вы увидите разные стили, планировки и варианты оформления
                </p>
                <a href="https://crm.ceramic3d.com/organization/7d30a84d-f4c9-45ab-85eb-0eca70132114/project-gallery" class="btn btn-primary cta-card-button inverted">Смотреть проекты</a>
            </div>
        </div>
    </div>

    <div class="cta-block">
        <div class="container">
            <div class="cta-block-content">
                <h2 class="cta-card-title">Оставить заявку на дизайн-проект</h2>
                <p class="cta-card-description">
                    Оставьте заявку, и мы поможем спланировать вашу 
                    ванную с учётом всех пожеланий и подберём подходящие материалы.
                </p>
                <a href="https://crm.ceramic3d.com/organization/7d30a84d-f4c9-45ab-85eb-0eca70132114/project-lead?project-id=30cf9a62-7291-4d75-8902-148786a8d2a1" class="btn btn-primary cta-card-button">Записаться</a>
            </div>
        </div>
    </div>
  </section>
</div>

<script>
    //TODO: Переписать скрипт в отдельный файл

    if (typeof Fancybox !== 'undefined') {
        Fancybox.bind("[data-fancybox]");
    }

    const { initSlider } = window.sliders;
    initSlider('#design-reviews-slider',{
        slidesPerView: 1.5,
        spaceBetween: 14,
        breakpoints:{
            456:{
                slidesPerView: 2,
            },
            680:{
                slidesPerView: 2.5,
            },
            768:{
                slidesPerView :3,
            },
            1024:{
                slidesPerView: 3.5,
            }

        } 
    })
    initSlider('#design-ideas-slider', {
        loop: true,
        slidesPerView: 1.75,
        spaceBetween: 30,
        initialSlide: 1,
        centeredSlides: true,
        speed: 800,
        breakpoints: {
            400:{
                slidesPerView: 2,
            },
            500:{
                centeredSlides: false,
                slidesPerView :3,
                initialSlide:0,
            }, 
            768: { 
                spaceBetween: 10,
                slidesPerView: 4,
            },
            1024: {
                 slidesPerView: 5,
            }
        }
    });

    const slider = document.getElementById('design-ideas-slider');
    const slides = slider.querySelectorAll('.swiper-slide');

    slides.forEach(slide => {
        const index = slide.getAttribute('data-swiper-slide-index');
        if (index !== null) {
            if (parseInt(index) % 2 === 0) {
                slide.classList.add('even');
            } else {
                slide.classList.add('odd');
            }
        }
    });
</script>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>