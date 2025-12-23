<?

$err_mess = 'error';

$strsql = "SELECT ACTIONS cc, APPLICATION aa FROM  b_sale_discount as i2
      where i2.active='Y' and (i2.active_from<=CURDATE() or i2.active_from is NULL)  and (i2.active_to>=CURDATE() or  i2.active_to is NULL)
      and i2.PRESET_ID is NULL
      and
        (
          i2.APPLICATION like concat('%', '] == ".$arResult['ID'].")', '%')
          or
          i2.APPLICATION like concat('%', '] == ".$arResult['ID']." |', '%')
        )
        order by id desc";
$ids=array();
$sales=array();
$resZ = $DB->Query($strsql, false, $err_mess.LINE);

if( $tovar = $resZ->GetNext() ) {


    $s=unserialize($tovar['~cc'])['CHILDREN'];
    foreach ($s as $key => $val) {
        $skidka = array(
            "value"=>$val['DATA']['Value'],
            "type" =>$val['DATA']['Unit']
        );
        foreach ($val['CHILDREN'] as $tov) {

            $ids[] = $tov['DATA']['value'];
        }
    }
}
//echo "<pre>";
//echo "skidka: ".$skidka."<br>";
//echo "ids: "."<br>";
//print_r($ids);
//echo "</pre>";
$priceCombo = 0;
?>
<?if(!empty($ids)){?>
<div class="content-block content-block_nopadding regular-block">
    <div class="content-block__title content-block__title_white">
        <span>Комбо-набор</span>
    </div>
<div class="combo">
    <div class="combo__list">
        <? foreach ($ids as $siblingProdID) { ?>

            <?
            $arSelect = Array("ID", "NAME", "DETAIL_PAGE_URL", "CATALOG_GROUP_1",'PREVIEW_PICTURE');
            $arFilter = Array("IBLOCK_ID" => IBLOCK_PRODUCTS_ID, "ACTIVE_DATE" => "Y", "ACTIVE" => "Y", "ID" => $siblingProdID);
            $res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nTopCount" => 1), $arSelect);
            while ($ob = $res->GetNextElement()) {
                $siblingProd = $ob->GetFields();
//                echo "<pre>";
//                print_r($siblingProd);
//                echo "</pre>";
                ?>

                <div class="p-item product">
                    <a href="<?=$siblingProd['DETAIL_PAGE_URL']?>" class="p-item__link">
                        <div class="p-item__image image">
                            <? $imgSP = CFile::ResizeImageGet($siblingProd["PREVIEW_PICTURE"], array('width' => 130, 'height' => 110), BX_RESIZE_IMAGE_PROPORTIONAL, true);
                            ?>
                            <img src="<?=$imgSP['src']?>" alt="">
                        </div>
                        <span class="p-item__name"><?=$siblingProd['NAME']?></span>
                    </a>
                    <div class="p-item__bot">
                        <span class="p-item__price"><?=$siblingProd['CATALOG_PRICE_1']?> р.</span>
                        <button class="p-item__buy add-to-cart" rel="<?=$siblingProd['ID']?>"></button>
                    </div>
                </div>
                <?//$priceCombo +=$siblingProd['CATALOG_PRICE_1']?>
                <?
                if ($skidka['type'] == "Perc"){
                    $priceCombo += $siblingProd['CATALOG_PRICE_1'] - ($skidka['value']/100)*$siblingProd['CATALOG_PRICE_1'];
                }

                ?>

            <? } ?>
        <? } ?>
    </div>
    <div class="combo__end">
        <span class="combo__summa"><?=$priceCombo?> р.</span>
        <button class="btn btn_add add-to-cart btn_combo" rel="<?=implode(',',$ids)?>">В корзину</button>
    </div>
</div>
</div>
<?}?>