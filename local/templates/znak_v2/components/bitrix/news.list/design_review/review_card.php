<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die(); 

$month_list = array(
	1  => 'января',
	2  => 'февраля',
	3  => 'марта',
	4  => 'апреля',
	5  => 'мая', 
	6  => 'июня',
	7  => 'июля',
	8  => 'августа',
	9  => 'сентября',
	10 => 'октября',
	11 => 'ноября',
	12 => 'декабря'
);
?>

<? foreach ($arResult['ITEMS'] as $item): 
    $text = $item["PROPERTIES"]["REVIEW_TEXT"]["VALUE"];
    $textLength = mb_strlen($text);
    $isLong = $textLength > 120;
?>
    <div class="swiper-slide design-reviews-slide">
        <a href="<?= $item["PROPERTIES"]["LINK_TO_REVIEW"]["VALUE"] ?>" class="reviews-slide-header">
            <!-- Иконка 2GIS (можно заменить на фото пользователя) -->
            <svg class="xyz" id="Icon/Map/2GIS" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="none">
                <path fill="#19AA1E" d="M0 0h18v18H0z"/>
                <path fill="#FFB919" fill-rule="evenodd" d="M0 0h18v5.906L0 3.094z" clip-rule="evenodd"/>
                <path fill="#82D714" fill-rule="evenodd" d="m0 16.03 18-2.812V18H0z" clip-rule="evenodd"/>
                <path fill="#fff" fill-rule="evenodd" d="m0 2.738 6.283.982A5.05 5.05 0 0 1 9 2.953c1.39 0 2.64.52 3.55 1.435q.172.173.325.361L18 5.55v.712l-4.605-.72c.345.659.525 1.391.527 2.135 0 .964-.216 1.925-.662 2.89l-.013.03-.19.406h-.447c-.925 0-1.538.277-1.94.767-.314.384-.497.904-.558 1.47l-.002.017-.012.13-.008.077q-.035.38-.047.642L18 12.862v.712L0 16.387v-.712l7.966-1.245-.004-.16v-.044l-.002-.024v-.035a14 14 0 0 0-.054-.743l-.006-.057-.01-.099c-.056-.57-.236-1.095-.55-1.485-.397-.494-1.004-.774-1.922-.78h-.476l-.189-.406c-.455-.975-.675-1.946-.675-2.92 0-1.225.497-2.41 1.372-3.29l.076-.074L0 3.45z" clip-rule="evenodd"/>
                <path fill="#0073FA" fill-rule="evenodd" d="M9 3.656c2.513 0 4.218 1.934 4.218 4.02 0 .838-.182 1.71-.609 2.624-2.472 0-3.082 1.77-3.198 2.885l-.008.074q-.058.597-.067.957l-.67.105v-.022q-.014-.532-.072-1.06l-.002-.02c-.107-1.113-.704-2.919-3.201-2.919-.427-.914-.61-1.786-.61-2.623C4.781 5.59 6.487 3.656 9 3.656" clip-rule="evenodd"/>
            </svg>

            <div class="review-slide-header-content">
                <h3 class="review-slide-reviewer"><?= htmlspecialchars($item["PROPERTIES"]["AUTOR"]["VALUE"]) ?></h3>
                
                <div class="review-meta">
                    <!-- ЗВЕЗДЫ ДИНАМИЧЕСКИ -->
                    <ul class="review-rating" aria-label="Рейтинг: <?= $item["PROPERTIES"]["RATING"]["VALUE"] ?> из 5">
                        <?php
                        $ratingValue = $item['PROPERTIES']['RATING']['VALUE'] ?? 0;
                        $ratingValue = (float) $ratingValue; 
                        $rating = round($ratingValue, 1); 
                        for ($i = 1; $i <= 5; $i++):
                            $filled = $i <= $rating ? 'filled' : 'empty';
                        ?>
                            <li class="star <?= $filled ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                    <path d="M0 0h24v24H0z" fill="none" />
                                    <path fill="currentColor" d="m5.825 21l1.625-7.025L2 9.25l7.2-.625L12 2l2.8 6.625l7.2.625l-5.45 4.725L18.175 21L12 17.275z" />
                                </svg>
                            </li>
                        <?php endfor; ?>
                    </ul>
                    
                    <?php
                    $dateReview = $item['PROPERTIES']['DATE_REVIEW']['VALUE'];
                    $timestamp = $dateReview ? (is_numeric($dateReview) ? $dateReview : strtotime($dateReview)) : time();
                    ?>

                    <span class="review-date">
                        <?= date('d', $timestamp) . ' ' . $month_list[date('n', $timestamp)] . ' ' . date('Y', $timestamp) ?>
                    </span>
                </div>
            </div>
        </a>

        <div class="reviews-slide-body">
            <div class="review-content-wrapper <?= (mb_strlen($item["PROPERTIES"]["REVIEW_TEXT"]["VALUE"]) > 120) ? 'collapsed' : '' ?>">
                <!-- Текст отзыва -->
                <div class="review-text-wrapper">
                    <p class="review-text">
                        <?= htmlspecialchars($text) ?>
                    </p>
                </div>
                
                <!-- Картинки -->
                <? if (!empty($item["PROPERTIES"]["IMAGE"]["VALUE"])): ?>
                    <div class="review-images">
                        <? 
                        $images = is_array($item["PROPERTIES"]["IMAGE"]["VALUE"]) 
                            ? $item["PROPERTIES"]["IMAGE"]["VALUE"] 
                            : [$item["PROPERTIES"]["IMAGE"]["VALUE"]]; 
                        ?>
                        <? foreach ($images as $imageId): ?>
                            <? $file = CFile::ResizeImageGet($imageId, array('width' => 1024, 'height' => 512), BX_RESIZE_IMAGE_PROPORTIONAL); ?>
                            <a href="<?= $file['src'] ?>" data-fancybox="<?= "review-image-" . $item["ID"]?>" class="fancybox">
                                <img src="<?= $file['src'] ?>" alt="Фото отзыва" class="review-image-item">
                            </a>
                        <? endforeach; ?>
                    </div>
                <? endif; ?>
            </div>

            
            <button class="btn btn-ghost btn-show-more" data-expanded="false">
                <span>Показать еще</span>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="12" height="12">
                    <path d="M201.4 406.6c12.5 12.5 32.8 12.5 45.3 0l192-192c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L224 338.7 54.6 169.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l192 192z" />
                </svg>
            </button>
            
        </div>
    </div>
<? endforeach; ?>

