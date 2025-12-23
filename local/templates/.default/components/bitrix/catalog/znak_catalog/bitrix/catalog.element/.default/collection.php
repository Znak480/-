<div class="content-block content-block_nopadding regular-block">
    <?
    //        echo "<pre>";
    //        print_r($arResult['PROPERTIES']['COLLECTION']);
    //        echo "</pre>";
    //     echo $arResult['PROPERTIES']['COLLECTION']['VALUE'];
    ?>


    <?
    //$arResult['PROPERTIES']['COLLECTION_PRODUCTS']['VALUE'] = $arResult['PROPERTIES']['RELATED_PRODUCTS']['VALUE'];
    $arSelectCP =Array("IBLOCK_ID","ID", "NAME", "DATE_ACTIVE_FROM","DETAIL_PAGE_URL","PREVIEW_PICTURE","CATALOG_GROUP_1","PROPERTY_COLLECTION");
    $arFilterCP = Array("IBLOCK_ID"=>IBLOCK_PRODUCTS_ID, "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y",array(
        "LOGIC" => "AND",
        "=PROPERTY_COLLECTION" => $arResult['PROPERTIES']['COLLECTION']['VALUE'],
        "!PROPERTY_COLLECTION" => false
    ),"!ID"=>$arResult['ID']);
    $res = CIBlockElement::GetList(Array(), $arFilterCP, false, Array("nTopCount"=>5), $arSelectCP);
    $arColProds = array();
    while($ob = $res->GetNextElement())
    {
        $arF = $ob->GetFields();
        //$arF['PROPERTIES'] = $ob->GetProperties();
        $arColProds[] = $arF;
    }
//                    echo "<pre>";
//                    print_r($arColProds);
//                    echo "</pre>";

    ?>


    <? if (!empty($arColProds)) { ?>
        <div class="content-block content-block_nopadding regular-block">
            <div class="content-block__title">
                <span>К этому товару подходят</span>
            </div>
            <div class="p-list p-list_borders">
                <? foreach ($arColProds as $colProd) { ?>
                    <div class="p-item product">
                        <a href="<?=$colProd['DETAIL_PAGE_URL']?>" class="p-item__link">
                            <div class="p-item__image image">
                                <? $file = CFile::ResizeImageGet($colProd["PREVIEW_PICTURE"], array('width' => 130, 'height' => 110), BX_RESIZE_IMAGE_PROPORTIONAL, true);
                                //var_dump($arItem['PREVIEW_PICTURE']);
                                ?>
                                <img src="<?=$file['src']?>" alt="">
                            </div>
                            <span class="p-item__name"><?= $colProd['NAME'] ?></span>
                        </a>
                        <div class="p-item__bot">
                            <span class="p-item__price"><?= $colProd['CATALOG_PRICE_1'] ?> р.</span>
                            <button class="p-item__buy add-to-cart" rel="<?=$colProd['ID']?>"></button>
                        </div>
                    </div>
                    <?
                } ?>
            </div>
        </div>
        <?
    } ?>
</div>