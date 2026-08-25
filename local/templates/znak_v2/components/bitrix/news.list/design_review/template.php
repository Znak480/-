<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die(); ?>

<?if(!empty($arResult["ITEMS"])):?>
	<div id="design-reviews-slider" class="swiper">
        <div class="swiper-wrapper">
            <?include __DIR__ . '/review_card.php';?>
        </div>
    </div>
<?else:?>
    <div class="empty-state">
        <div class="empty-state-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"></circle>
                <line x1="12" y1="8" x2="12" y2="12"></line>
                <line x1="12" y1="16" x2="12.01" y2="16"></line>
            </svg>
        </div>
        <h3 class="empty-state-title">Отзывов пока нет</h3>
        <p class="empty-state-description">Вы можете стать первым, оставив отзывы на<br> 2ГИС</p>
        <div class="empty-state-actions">
            <a href="https://2gis.ru/barnaul/firm/563478234415875/83.746093%2C53.341484/tab/reviews/addreview?m=83.745496%2C53.341324%2F19.25" class="btn btn-primary btn-sm">
                Оставить отзыв
            </a>
        </div>
    </div>
<?endif;?>