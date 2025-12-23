<?//const IBLOCK_PRODUCTS_ID = 14;?>
<div class="product p-product count-product product_e1" style="position: relative">
<?
global $currentCity;
$arItem['PRICES']['BASE']=$arItem['PRICES'][$currentCity['PRICE_CODE']['VALUE']];
//$arItem['PRICES']['BASE']=$arItem['ITEM_PRICES'][0];


?>

    <?//шильдики "Распродажа","Скидка","Хит" и другие
//    echo "<pre style='display:none'>";
//    print_r($arItem['PROPERTIES']['AKTSIYA_']);
//    echo "</pre>";

    if (!empty($arItem['PROPERTIES']['RAITING_PRODAZH']['VALUE']) or !empty($arItem['PROPERTIES']['AKTSIYA_']['VALUE'])) {

         
        if (!empty($arItem['PROPERTIES']['AKTSIYA_']['VALUE'])){?>

            <div class="product__label product__label_type5">
                <span>Акция <?= $arItem['PROPERTIES']['AKTSIYA_']['VALUE']?>%</span>
            </div>
            <?

        } else {
            switch ($arItem['PROPERTIES']['RAITING_PRODAZH']['VALUE']) {
                case 'Эксклюзив':
                    $labelType = 1;//красный
                    break;
                case 'Рекомендуем':
                    $labelType = 2;//фиолетовый
                    break;
                case 'Новинка':
                    $labelType = 3;//жёлтый, текст - чёрный
                    break;
                case 'Хит':
                    $labelType = 4;//синий
                    break;
                default:
                    $labelType = '';
                    break;
            }

            ?>
            <div class="product__label product__label_type<?= $labelType ?>">
                <span><?= $arItem['PROPERTIES']['RAITING_PRODAZH']['VALUE'] ?></span>
            </div>
            <?
        }

        
    }else{
       /*if(!empty($arItem['PROPERTIES']['SKIDKA_PO_KARTE_']['VALUE'])){?>
            <div class="product__label product__label_type1">
                <span>Скидка <?=$arItem['PROPERTIES']['SKIDKA_PO_KARTE_']['VALUE']?>% по карте</span>
            </div>
       <? } */
    }

    //var_dump($arItem['PROPERTIES']['RAITING_PRODAZH']['VALUE']);
    //var_dump($arItem['PROPERTIES']['AKTSIYA_']['VALUE']);

    /*  */

    if(!empty($arItem['PROPERTIES']['POD_ZAKAZ']['VALUE'])){?>
            <div class="product__label product__label_type6">
                <span>Под заказ</span>
            </div>
       <? }
    if(!empty($arItem['PROPERTIES']['TSENA_CHTO_NADO']['VALUE'])){?>
            <div class="product__label product__label_type5">
                <span>Лучшая цена</span>
            </div>
       <? }



    ?>
    <?//Картинка?>
    <a href="<?=$arItem["DETAIL_PAGE_URL"]?>">
    <div class="image p-product__image">
        <?
        $ppID =  !empty($arItem["PREVIEW_PICTURE"]["ID"]) ? $arItem["PREVIEW_PICTURE"]["ID"] : $arItem["PREVIEW_PICTURE"];


        $picture = '/images/no-photo.png';
        $file['src'] = '/images/no-photo.png';
        //echo $ppID;
        //print_r($arItem["PREVIEW_PICTURE"]);
        //if ($arItem["PREVIEW_PICTURE"]["SRC"]) {




        if($ppID || $arItem["PREVIEW_PICTURE"]["SRC"]){
            if(is_array($arItem["PREVIEW_PICTURE"])&&is_set($arItem["PREVIEW_PICTURE"]["ID"])){
	        $picture = $arItem["PREVIEW_PICTURE"]["SRC"];
	            $file = CFile::ResizeImageGet($ppID, array('width' => 170, 'height' => 170), BX_RESIZE_IMAGE_PROPORTIONAL, true);
            }
        }


        ?>
        <?//$file = CFile::ResizeImageGet($ppID, array('width'=>170, 'height'=>170), BX_RESIZE_IMAGE_PROPORTIONAL, true);  ?>
        <center><img src="<?=$file["src"]?>" alt=""></center>
    </div>
    </a>
    <?//название?>
    <div class="name p-product__title">
        <a href="<?=$arItem["DETAIL_PAGE_URL"]?>"><?if (mb_strlen($arItem["NAME"])>70):?><?=mb_substr($arItem["NAME"],0,70)."..."?><?else:?><?=$arItem["NAME"]?><?endif;?></a>
    </div>
    <?//цена?>
    <? if (!empty($arItem ['ITEM_PRICES'])) { ?>
        <div class="p-product__prices">
            <div class="p-product__price">
                <? if (!empty($arItem['PROPERTIES']['AKTSIYA_']['VALUE'])) { ?>
                    <span>Цена по акции</span>
                    <strong><?= number_format($arItem['ITEM_PRICES'][0]['PRICE'] - $arItem['PROPERTIES']['AKTSIYA_']['VALUE'] / 100 * $arItem['ITEM_PRICES'][0]['PRICE'], 2, ',', ' ') ?> р.</strong>
                <? } else { ?>
                    <span>Цена по карте</span>
                    <strong><?= number_format((int)$arItem['ITEM_PRICES'][0]['PRICE'] - (int)$arItem['PROPERTIES']['SKIDKA_PO_KARTE_']['VALUE'] / 100 * (int)$arItem['ITEM_PRICES'][0]['PRICE'], 2, ',', ' ') ?>
                        р.</strong>
                <? } ?>
            </div>
            <? //базовая цена?>
            <? if (!empty($arItem['ITEM_PRICES'][0]['PRINT_PRICE'])) { ?>
                <div class="p-product__price p-product__price_old">
                    <span><?= $arItem['ITEM_PRICES'][0]['PRINT_PRICE'] ?></span>
                </div>
            <? } ?>
        </div>


    <?}?>
    <?//купить?>
    <div class="<?//buttons?> p-product__actions">
        <label class="counter">
            <input type="number" min="1" class="quantity"  id="quant<?=$arItem["ID"]?>" value="1" class="counter__input">
        </label>
        <input type="button" value="В корзину" class="add-to-cart" rel="<?=$arItem["ID"]?>" style="display: none">
        <button class="btn btn_add btn_product add-to-cart" rel="<?=$arItem["ID"]?>"></button>
        <button class="btn btn_product buy1click" data-prod="<?=$arItem["ID"]?>">в 1 клик</button>
    </div>
    <span class="compare-link"  id="compareid_<?=$arItem['ID'];?>" onclick="compare_tov(<?=$arItem['ID'];?>)" data-chosen="1">
                    <?$APPLICATION->IncludeComponent(
                        "bitrix:catalog.compare.list",
                        "ajax_count",
                        array(
                            "IBLOCK_TYPE" => "catalog",
                            "IBLOCK_ID" => IBLOCK_PRODUCTS_ID,
                            "AJAX_MODE" => "N",
                            "AJAX_OPTION_JUMP" => "N",
                            "AJAX_OPTION_STYLE" => "Y",
                            "AJAX_OPTION_HISTORY" => "N",
                            "DETAIL_URL" => "#SECTION_CODE#",
                            "COMPARE_URL" => "compare.php",
                            "NAME" => "CATALOG_COMPARE_LIST",
                            "AJAX_OPTION_ADDITIONAL" => "",
                            "PRODUCT_ID"=>$arItem['ID']
                        ),
                        false
                    );?>
                </span>
</div>