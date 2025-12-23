<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();


?>
		<script type="text/javascript">
//function compare_tov(id)
//{
//    var chek = document.getElementById('compareid_'+id);
//    if (chek.checked)
//    {
//        //Добавить
//        var AddedGoodId = id;
//        $.get("/ajx/list_compare.php",
//            {
//                action: "ADD_TO_COMPARE_LIST", id: AddedGoodId},
//            function(data) {
//                $("#label"+AddedGoodId).html(data);
//            }
//        );
//    }
//    else
//    {
//        //Удалить
//        var AddedGoodId = id;
//        $.get("/ajx/list_compare.php",
//            {
//                action: "DELETE_FROM_COMPARE_LIST", id: AddedGoodId},
//            function(data) {
//                $("#label"+AddedGoodId).html(data);
//            }
//        );
//    }
//}
function compare_tov(id)
{
    var thisElem =$('#compareid_'+id);
    var chek = thisElem.data('chosen');

    console.log(chek);
    if (chek)
    {
        //thisElem.data('chosen',0);
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
        // thisElem.data('chosen',1);
        // //Удалить
        // var AddedGoodId = id;
        // $.get("/ajx/list_compare.php",
        //     {
        //         action: "DELETE_FROM_COMPARE_LIST", id: AddedGoodId},
        //     function(data) {
        //         thisElem.html(data);
        //     }
        // );
    }
}


</script>
<?$this->SetViewTarget('sectionDiscription');?>
        <p><?=$arResult["DESCRIPTION"]?></p><br><br>
<?$this->EndViewTarget();?>
<?
//echo "<pre style='display: none'>shortNav: ";
//
//$shortNav = array();
//
//foreach ($arResult['NAV_RESULT'] as $key=>$arI){
//    if (is_array($arI) or is_object($arI) or empty($arI) ){
//        continue;
//    } else {
//        $shortNav[$key] = $arI;
//    }
//}
//print_r ($shortNav);
//echo "NavPageSize: ".$arResult['NAV_RESULT']['NavPageSize']."<br>";
//echo "NavPageNomer: ".$arResult['NAV_RESULT']['NavPageNomer']."<br>";
//echo "nps: ".$arResult['NAV_RESULT']['NavPageSize']."<br>";
//echo "</pre>";
//echo "<pre style='display: none'>";
//print_r($arResult["ITEMS"]);
//echo "</pre>";
?>
<?
//дата атрибут data-showmore для "показать ещё"
//формат:
/*
 *общее кол-во страниц,
 * id текущего раздела,
 * количество элементов на странице
 * поле для сортировки
 * порядок сортировки
 * */
//echo $arParams['ELEMENT_SORT_ORDER'];
//var_dump($arResult['NAV_RESULT']);
$dataAjax = $arResult['NAV_RESULT']->NavPageCount.",".
            $arResult['ID'].",".
            $arParams['PAGE_ELEMENT_COUNT'].",".
            $arParams['ELEMENT_SORT_FIELD'].",".
            $arParams['ELEMENT_SORT_ORDER'];

//echo $dataAjax;
?>
<div class="products__list products__list_e1" style="overflow: hidden" data-page="<?= $arResult['NAV_RESULT']->PAGEN ?>" data-showmore="<?= $dataAjax ?>">
    <? foreach ($arResult["ITEMS"] as $arItem): ?>
        <?
        $APPLICATION->IncludeFile(
            "/local/include/card-product.php",
            Array(
                "arItem" => $arItem
            ),
            Array("MODE" => "PHP")
        );
        ?>
    <? endforeach; ?>
</div>


        <!-- <div class="clear"></div> -->

<div class="products_other">
    <? if ($arResult['NAV_RESULT']->PAGEN < $arResult['NAV_RESULT']->NavPageCount) { ?>
        <div class="products__more">
            <button class="btn">Показать еще</button>
        </div>
    <? } ?>
    <div class="control paging">
        <? echo $arResult["NAV_STRING"]; ?>
    </div>
</div>

