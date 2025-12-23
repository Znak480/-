<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

?>
<?
global $currentCity;
$arResult['PRICES']['BASE']=$arResult['PRICES'][$currentCity['PRICE_CODE']['VALUE']];
?>

<script type="text/javascript">
function compare_tov(id)
{
    var thisElem =$('#compareid_'+id);
    var chek = thisElem.data('chosen');
                  if (chek)
                  {
                      thisElem.data('chosen',0);
                                //Добавить
                                var AddedGoodId = id;
                                 $.get("/ajx/list_compare.php",
                                {
                                action: "ADD_TO_COMPARE_LIST", id: AddedGoodId},
                                function(data) {
                                    thisElem.html(data);
                                    console.log($(this));
                                }
                                );
                  }
                  else
                  {
                      // console.log('zero');
                      // thisElem.data('chosen',1);
                      //            //Удалить
                      //           var AddedGoodId = id;
                      //            $.get("/ajx/list_compare.php",
                      //           {
                      //           action: "DELETE_FROM_COMPARE_LIST", id: AddedGoodId},
                      //           function(data) {
                      //               thisElem.html(data);
                      //           }
                      //           );
                  }
}
//добавляем товар в список просмотренных
BX.ajax.post(
    '/bitrix/components/bitrix/catalog.element/ajax.php',
    {
        AJAX: 'Y',
        SITE_ID: 's1',
        PRODUCT_ID: <?=$arResult['ID']?>
        // PARENT_ID: 4919
    },
    function (){
       // console.log('success');
    }
);
</script>

<div class="rb">

<div class="common-content-thin product-page">
    <div class="title-block regular-block">
        <? $APPLICATION->IncludeComponent("bitrix:breadcrumb", "znak", Array(
            "COMPONENT_TEMPLATE" => ".default",
            "START_FROM" => "0",    // Номер пункта, начиная с которого будет построена навигационная цепочка
            "PATH" => "",    // Путь, для которого будет построена навигационная цепочка (по умолчанию, текущий путь)
            "SITE_ID" => "-",    // Cайт (устанавливается в случае многосайтовой версии, когда DOCUMENT_ROOT у сайтов разный)
        ),
            false
        ); ?>
    </div>

        <div class="content-block regular-block product">
            <div class="product-title">
                <?=$arResult["NAME"]?>
            </div>
            <div class="images image">
                <div class="main-image">
                    <?//шильдики "Распродажа","Скидка","Хит" и другие
                    if (!empty($arResult['PROPERTIES']['RAITING_PRODAZH']['VALUE']) or !empty($arResult['PROPERTIES']['AKTSIYA_']['VALUE'])) {


                        if (!empty($arResult['PROPERTIES']['AKTSIYA_']['VALUE'])){?>

                            <div class="product__label product__label_type5">
                                <span>Акция <?= $arResult['PROPERTIES']['AKTSIYA_']['VALUE']?>%</span>
                            </div>
                            <?

                        } else {
                            switch ($arResult['PROPERTIES']['RAITING_PRODAZH']['VALUE']) {
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
                                <span><?= $arResult['PROPERTIES']['RAITING_PRODAZH']['VALUE'] ?></span>
                            </div>
                            <?
                        }
                    }


                    if(!empty($arResult['PROPERTIES']['POD_ZAKAZ']['VALUE'])){?>
                            <div class="product__label product__label_type6">
                                <span>Под заказ</span>
                            </div>
                       <? }
                    if(!empty($arResult['PROPERTIES']['TSENA_CHTO_NADO']['VALUE'])){?>
                            <div class="product__label product__label_type5">
                                <span>Лучшая цена</span>
                            </div>
                       <? }

                    ?>
                    <?
                    $picture = '/images/no-photo.png';
                    $file['src'] = '/images/no-photo.png';
                    if($arResult["PREVIEW_PICTURE"]["SRC"]){
                        $picture = $arResult["PREVIEW_PICTURE"]["SRC"];
                        $file = CFile::ResizeImageGet($arResult["PREVIEW_PICTURE"]["ID"], array('width'=>200, 'height'=>200), BX_RESIZE_IMAGE_PROPORTIONAL, true);
                    }
                    ?>
                    <a href="<?=$picture?>" class="fancybox" rel="gal">
                         <?//$file = CFile::ResizeImageGet($arResult["PREVIEW_PICTURE"]["ID"], array('width'=>200, 'height'=>200), BX_RESIZE_IMAGE_PROPORTIONAL, true);  ?>
                        <img src="<?=$file["src"]?>" alt="" width="200">
                    </a>
                </div>
                <?if ($arResult["PROPERTIES"]["PICTURES"]["VALUE"]):?>
                <div class="preview-images">

                    <?foreach ($arResult["PROPERTIES"]["PICTURES"]["VALUE"] as $pic):?>
                        <div class="preview-image">
                            <a href="<?=CFile::GetPath($pic)?>" rel="gal" class="fancybox">
                                <?$file = CFile::ResizeImageGet($pic, array('width'=>80, 'height'=>80), BX_RESIZE_IMAGE_PROPORTIONAL, true);  ?>
                                <img src="<?=$file["src"]?>" alt="">
                            </a>
                        </div>
                    <?endforeach;?>

                    <div class="clear"></div>
                </div>
                <?endif;?>
            </div>
            <div class="product-info">
        <div class="product-info__container">

          <div class="product-info-questions">
            <div class="product-info__block">
              <a href="/dostavka.php" class="product-link">Как забрать товар?</a>
              <div class="chosen">
                <div class="chosen__ico">
                  <img src="/images/delivery.svg" alt="">
                </div>
                <span>Курьерская доставка</span>
              </div>
            </div>
            <div class="product-info__block">
              <a href="/payment/" class="product-link">Как оплатить товар?</a>
              <div class="chosen">
                <div class="chosen__ico">
                  <img src="/images/payment.svg" alt="">
                </div>
                <span>Банковской картой</span>
              </div>
            </div>
          </div>

          <div class="product-chars-new">
              <div class="product-availability">
                  <?//if($USER->IsAdmin()):?>
                    <?//ov_dump($arResult['ITEM_MEASURE']['TITLE'])?>
                    <?=qtyProduct($arResult['CATALOG_QUANTITY'], $arResult['ITEM_MEASURE']['TITLE'])?>

                  <?//endif;?>

                  <? /*if ($arResult['CAN_BUY']) { ?>
                      <span class="availability-status availability-status_in-stock">В наличии*</span>
                  <? } else { ?>
                      <span class="availability-status availability-status_out">Под заказ</span>
                  <? }*/ ?>
              </div>
            <!-- <span class="p-price"><?=$arResult['PRICES']['BASE']['PRINT_VALUE']?> за <?=$arResult['ITEM_MEASURE']['TITLE']?></span>** -->
              <span class="p-price"><?=$arResult['ITEM_PRICES'][0]['PRINT_PRICE']?> за <?=$arResult['ITEM_MEASURE']['TITLE']?></span>**
              <?//
              // $arResult['PRICES']['BASE']['PRINT_VALUE'] -> $arResult['ITEM_PRICES'][0]['PRINT_PRICE']
              //var_dump($arResult['PROPERTIES']['AKTSIYA_']['VALUE']);
              ?>
            <div class="product-info__price-card">

                <? if (!empty($arResult['PROPERTIES']['AKTSIYA_']['VALUE'])) { ?>
                    <span class="blue">Цена по акции</span>
                    <span class="p-price p-price_strong"><?= number_format($arResult['ITEM_PRICES'][0]['PRICE'] - $arResult['PROPERTIES']['AKTSIYA_']['VALUE'] / 100 * $arResult['ITEM_PRICES'][0]['PRICE'], 2, ',', ' ') ?> р.</span>**
                <? } else { ?>
                    <span class="blue">Цена по карте</span>
                    <span class="p-price p-price_strong"><?= number_format($arResult['ITEM_PRICES'][0]['PRICE'] - (int) $arResult['PROPERTIES']['SKIDKA_PO_KARTE_']['VALUE'] / 100 * $arResult['ITEM_PRICES'][0]['PRICE'], 2, ',', ' ') ?> р.</span><span style="position: absolute;">**</span>
                <? } ?>
            </div>
            <div class="product-actions">
              <label class="counter">
                <input type="number" class="counter__input quantity" value="1" min="1" id="quant<?=$arResult["ID"]?>">
              </label>
              <button class="btn btn_add add-to-cart" rel="<?=$arResult["ID"]?>">В корзину</button>
              <button class="btn buy1click" data-prod="<?=$arResult["ID"]?>">Купить в 1 клик</button>
            </div>

            <span class="compare-link"  id="compareid_<?=$arResult['ID'];?>" onclick="compare_tov(<?=$arResult['ID'];?>)" data-chosen="1">
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
                        "PRODUCT_ID"=>$arResult['ID']
                    ),
                    false
                );?>
            </span>
              <p class="specialLabel">
                  * - Наличие товара уточняйте у сотрудников компании. Тел.8 (3852) 36-40-80
                  <br>
                  ** - Окончательная стоимость рассчитывается в соответствии с действующей дисконтной системой.
              </p>

          </div>
        </div>
                <?if (!empty($arResult ['PRICES']['BASE']['PRINT_VALUE'])){?>
                    <div style="font-size: 20px;margin: 50px 0px 0px;display: none">
                        Цена: <?=$arResult ['PRICES']['BASE']['PRINT_VALUE']?>
                    </div>
                <?}?>
                <div class="buttons-block" style="display: none">
                    <div class="buttons">
                        <input type="number" min="1" class="quantity"  id="quant<?=$arResult["ID"]?>" value="1">
                        <input type="button" value="В корзину" rel="<?=$arResult["ID"]?>" class="add-to-cart">
                    </div>
                </div>

            </div>
      <div class="product-content">
          <? if (!empty($arResult["DETAIL_TEXT"])) { ?>
              <span class="caption">Описание</span>
              <p>
                  <?= $arResult["DETAIL_TEXT"] ?>
              </p>
          <? } ?>
          <span class="caption">Характеристики</span>
          <ul class="product-characteristics">
<?

$rejectProps=array("Реквизиты","Ставки налогов", "Код товара","поисковый контент","Под заказ","Цена что надо");
$rejectPropsCodes=array("CML2_ARTICLE");
?>
              <? foreach ($arResult['PROPERTIES'] as $arProp) { ?>
                  <?
                 // if ($arProp['XML_ID'] == '1' or $arProp['XML_ID'] == '4' or $arProp['XML_ID']=='55' )//"код товара" или "рейтинг продаж" или сопутствующие товары
        if(in_array($arProp["NAME"],$rejectProps)||in_array($arProp["CODE"],$rejectPropsCodes))
                        continue;
                  ?>
                  <?if(!empty($arProp['VALUE'])){?>
                      <li>
                          <div>
                              <span><?= $arProp['NAME'] ?> </span>
                          </div>
                          <div>
                              <span><?= $arProp['VALUE'] ?></span>
                          </div>
                      </li>
                  <?}?>
              <? } ?>
          </ul>
      </div>
            <div class="clear"></div>
            <?if ($arResult["PROPERTIES"]["SAME"]["VALUE"]):?>
            <div class="similars">
                <h1 class="common-din" style="margin-top:-60px;">С этим товаром покупают</h1>
                <?foreach ($arResult["PROPERTIES"]["SAME"]["VALUE"] as $k=>$same):?>
                    <?if($k==3)break;
                    $arFields = getElementById($same);
                    $APPLICATION->IncludeFile(
                        "/local/include/card-product.php",
                        Array(
                            "arItem" => $arFields
                        ),
                        Array("MODE" => "PHP")
                    );
                    ?>

                <?endforeach;?>

                <div class="clear"></div>
            </div>
            <?endif;?>



        <div class="clear"></div>

            <?if ($arResult["PROPERTIES"]["SIMILAR"]["VALUE"]):?>
                <div class="similars">
                    <h1 class="common-din" style="margin-top:-60px;">Похожие товары</h1>
                    <?foreach ($arResult["PROPERTIES"]["SIMILAR"]["VALUE"] as $k=> $same):?>
                        <?if($k==3)break;
                        $arFields = getElementById($same);
                        if($arFields['PREVIEW_PICTURE']) {
                          $file_prev_id = $arFields['PREVIEW_PICTURE'];
                          unset($arFields['PREVIEW_PICTURE']);
                          $arFields['PREVIEW_PICTURE'] = CFile::GetFileArray($file_prev_id);
                        }
                        $APPLICATION->IncludeFile(
                            "/local/include/card-product.php",
                            Array(
                                "arItem" => $arFields
                            ),
                            Array("MODE" => "PHP")
                        );
                        ?>

                    <?endforeach;?>

                    <div class="clear"></div>
                </div>

            <?else:?>
            <div class="similars">
                <h1 class="common-din" style="margin-top:-60px;">Похожие товары</h1>
            <?
                $arSelect = Array("ID", "NAME", "DATE_ACTIVE_FROM","PROPERTY_SALE","PROPERTY_DISCOUNT","PROPERTY_HIT","PREVIEW_PICTURE","DETAIL_PAGE_URL","CATALOG_GROUP_".$currentCity['PRICE_ID']['VALUE'],'PROPERTY_SKIDKA_PO_KARTE_',"PROPERTY_RAITING_PRODAZH","PROPERTY_AKTSIYA_");
                $arFilter = Array("IBLOCK_ID"=>$currentCity['IBLOCK_CATALOG']['VALUE'], "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y",'!NAME'=>false/*,"!=PREVIEW_PICTURE"=>false*/);//"!=PROPERTY_RAITING_PRODAZH"=>false,
//debug($arResult);
                $arFilter[]=array("IBLOCK_SECTION_ID"=>$arResult['IBLOCK_SECTION_ID'],"!ID"=>$arResult['ID']);
                $res = CIBlockElement::GetList(Array('RAND' => 'rand'), $arFilter, false, Array("nTopCount"=>3 ), $arSelect);
                while($ob = $res->GetNextElement())
                {
                    $arFields = $ob->GetFields();
                    $arFields['PRICES'][$currentCity['PRICE_CODE']['VALUE']]= array(
                        "VALUE"=> $arFields['CATALOG_PRICE_'.$currentCity['PRICE_ID']['VALUE']],
                        "PRINT_VALUE"=>$arFields['CATALOG_PRICE_'.$currentCity['PRICE_ID']['VALUE']]." р."
                    );
                    if($arFields['PREVIEW_PICTURE']) {
                        $file_prev_id = $arFields['PREVIEW_PICTURE'];
                        unset($arFields['PREVIEW_PICTURE']);
                        $arFields['PREVIEW_PICTURE'] = CFile::GetFileArray($file_prev_id);
                    }

                    $arFields['PROPERTIES']['SKIDKA_PO_KARTE_']['VALUE'] = $arFields['PROPERTY_SKIDKA_PO_KARTE__VALUE'];
                    $arFields['ITEM_PRICES'][0]['PRICE'] = $arFields['CATALOG_PRICE_'.$currentCity['PRICE_ID']['VALUE']];
                    $arFields['ITEM_PRICES'][0]['PRINT_PRICE'] = $arFields['CATALOG_PRICE_'.$currentCity['PRICE_ID']['VALUE']]." р.";
                    $APPLICATION->IncludeFile(
                        "/local/include/card-product.php",
                        array(
                            "arItem" => $arFields
                        ),
                        array("MODE" => "PHP")
                    );

                }

                ?>

                <div class="clear"></div>
            </div>
            <?endif;?>






        </div>



<?/*if ($USER->IsAdmin() or 1){?>

    <?//вы уже смотрели?>
    <div class="content-block content-block_nopadding regular-block" style="display: none">
        <?$APPLICATION->IncludeComponent(
            "bitrix:catalog.products.viewed",
            "viewedElements",
            Array(
                "ACTION_VARIABLE" => "action_cpv",
                "ADDITIONAL_PICT_PROP_14" => "-",
                "ADDITIONAL_PICT_PROP_2" => "-",
                "ADD_PROPERTIES_TO_BASKET" => "Y",
                "ADD_TO_BASKET_ACTION" => "ADD",
                "BASKET_URL" => "/personal/basket.php",
                "CACHE_GROUPS" => "Y",
                "CACHE_TIME" => "3600",
                "CACHE_TYPE" => "A",
                "CART_PROPERTIES_14" => array(""),
                "CART_PROPERTIES_2" => array(""),
                "CONVERT_CURRENCY" => "N",
                "DEPTH" => "2",
                "DISPLAY_COMPARE" => "N",
                "ENLARGE_PRODUCT" => "STRICT",
                "HIDE_NOT_AVAILABLE" => "N",
                "HIDE_NOT_AVAILABLE_OFFERS" => "N",
                "IBLOCK_ID" => IBLOCK_PRODUCTS_ID,
                "IBLOCK_MODE" => "single",
                "IBLOCK_TYPE" => "catalog",
                "LABEL_PROP_14" => array(""),
                "LABEL_PROP_2" => array(""),
                "LABEL_PROP_MOBILE_14" => array(),
                "LABEL_PROP_MOBILE_2" => array(),
                "LABEL_PROP_POSITION" => "top-left",
                "MESS_BTN_ADD_TO_BASKET" => "В корзину",
                "MESS_BTN_BUY" => "Купить",
                "MESS_BTN_DETAIL" => "Подробнее",
                "MESS_BTN_SUBSCRIBE" => "Подписаться",
                "MESS_NOT_AVAILABLE" => "Нет в наличии",
                "PAGE_ELEMENT_COUNT" => "9",
                "PARTIAL_PRODUCT_PROPERTIES" => "N",
                "PRICE_CODE" => array('BASE'),
                "PRICE_VAT_INCLUDE" => "Y",
                "PRODUCT_BLOCKS_ORDER" => "price,props,sku,quantityLimit,quantity,buttons,compare",
                "PRODUCT_ID_VARIABLE" => "id",
                "PRODUCT_PROPS_VARIABLE" => "prop",
                "PRODUCT_QUANTITY_VARIABLE" => "quantity",
                "PRODUCT_ROW_VARIANTS" => "[{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false}]",
                "PRODUCT_SUBSCRIPTION" => "Y",
                "PROPERTY_CODE_14" => array(""),
                "PROPERTY_CODE_2" => array(""),
                "PROPERTY_CODE_MOBILE_14" => array(""),
                "PROPERTY_CODE_MOBILE_2" => array(""),
                "SECTION_CODE" => "",
                "SECTION_ELEMENT_CODE" => "",
                "SECTION_ELEMENT_ID" => $GLOBALS["CATALOG_CURRENT_ELEMENT_ID"],
                "SECTION_ID" => $GLOBALS["CATALOG_CURRENT_SECTION_ID"],
                "SHOW_CLOSE_POPUP" => "N",
                "SHOW_DISCOUNT_PERCENT" => "N",
                "SHOW_FROM_SECTION" => "N",
                "SHOW_MAX_QUANTITY" => "N",
                "SHOW_OLD_PRICE" => "Y",
                "SHOW_PRICE_COUNT" => "1",
                "SHOW_PRODUCTS_14" => "N",
                "SHOW_PRODUCTS_2" => "N",
                "SHOW_SLIDER" => "Y",
                "SLIDER_INTERVAL" => "3000",
                "SLIDER_PROGRESS" => "N",
                "TEMPLATE_THEME" => "blue",
                "USE_ENHANCED_ECOMMERCE" => "N",
                "USE_PRICE_COUNT" => "N",
                "USE_PRODUCT_QUANTITY" => "N"
            )
        );?>
    </div>

    <?//сопутствующие товары?>

    <?

    if (!empty($arResult['PROPERTIES']['RELATED_PRODUCTS']['VALUE'])){
    ?>
        <div class="content-block content-block_nopadding regular-block">
            <?
            $arSelectRP =Array("ID", "NAME", "DATE_ACTIVE_FROM","DETAIL_PAGE_URL","PREVIEW_PICTURE","CATALOG_GROUP_1");
            $arFilterRP = Array("IBLOCK_ID"=>IBLOCK_PRODUCTS_ID, "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y","ID"=>$arResult['PROPERTIES']['RELATED_PRODUCTS']['VALUE']);
            $res = CIBlockElement::GetList(Array(), $arFilterRP, false, Array("nTopCount"=>5), $arSelectRP);
            $arRelProds = array();
            while($ob = $res->GetNextElement())
            {
                $arF = $ob->GetFields();
                $arRelProds[] = $arF;
            }

            ?>


            <? if (!empty($arRelProds)) { ?>
                <div class="content-block regular-block">

                    <span class="caption">С этим товаром покупают</span>
                    <div class="p-list">
                        <? foreach ($arRelProds as $relProd) { ?>
                            <div class="p-item product">
                                <a href="<?=$relProd['DETAIL_PAGE_URL']?>" class="p-item__link">
                                    <div class="p-item__image image">
                                        <? $file = CFile::ResizeImageGet($relProd["PREVIEW_PICTURE"], array('width' => 130, 'height' => 110), BX_RESIZE_IMAGE_PROPORTIONAL, true);
                                        //var_dump($arItem['PREVIEW_PICTURE']);
                                        ?>
                                        <img src="<?=$file['src']?>" alt="">
                                    </div>
                                    <span class="p-item__name"><?= $relProd['NAME'] ?></span>
                                </a>
                                <div class="p-item__bot">
                                    <span class="p-item__price"><?= $relProd['CATALOG_PRICE_1'] ?> р.</span>
                                    <button class="p-item__buy add-to-cart" rel="<?=$relProd['ID']?>"></button>
                                </div>
                            </div>
                            <?
                        } ?>
                    </div>
                </div>
                <?
            } ?>
        </div>
    <?}?>
    <?//товары из коллекции (к этому товару подходят)?>
<?if (!empty($arResult['PROPERTIES']['COLLECTION']['VALUE'])){
    include ('collection.php');
    }
?>


<?}*/?>
    <?//комбо набор?>
    <?include ('combo.php')?>



<?//?>
        <?/*
        <div class="content-block regular-block options" style="padding: 15px;display: none">
        <?$arSelect = Array("ID", "NAME", "PREVIEW_PICTURE", "DETAIL_PAGE_URL");
            $arFilter = Array("IBLOCK_ID"=>$arResult["IBLOCK_ID"], "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y", "SECTION_ID" => $arResult["IBLOCK_SECTION_ID"]);
            $res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
            while($ob = $res->GetNextElement())
            {
             $arFields = $ob->GetFields();
            ?>
            <?if ($arFields["ID"]==$arResult["ID"]):?>
            <div class="option current-option" style="overflow: hidden; margin: 0 10px; height:162px;">
                <?$file = CFile::ResizeImageGet($arFields["PREVIEW_PICTURE"], array('width'=>80, 'height'=>80), BX_RESIZE_IMAGE_PROPORTIONAL, true);  ?>
                <span style="display:block; width:120px; height:80px; text-align:center;" ><img src="<?=$file["src"]?>" alt=""></span>
                <div class="title"><?=$arFields["NAME"]?></div>
            </div>
            <?else:?>
            <div class="option" style="overflow: hidden; margin: 0 10px; height:162px;">
                <?$file = CFile::ResizeImageGet($arFields["PREVIEW_PICTURE"], array('width'=>80, 'height'=>80), BX_RESIZE_IMAGE_PROPORTIONAL, true);  ?>
                <a href="<?=$arFields["DETAIL_PAGE_URL"]?>"><span style="display:block; width:120px; height:80px; text-align:center;"><img src="<?=$file["src"]?>" alt=""></span></a>
                <div class="title"><a href="<?=$arFields["DETAIL_PAGE_URL"]?>"><?=$arFields["NAME"]?></a></div>
            </div>
            <?endif;?>
            <?}?>

            <div class="clear"></div>
        </div>
        */?>
    </div>
</div>