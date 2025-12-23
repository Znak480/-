<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();


?>
        <script type="text/javascript">

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

    }
}


</script>
<?$this->SetViewTarget('sectionDiscription');?>
        <p><?=$arResult["DESCRIPTION"]?></p><br><br>
<?$this->EndViewTarget();?>

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
//debug($arResult['NAV_RESULT']);
$dataAjax = $arResult['NAV_RESULT']->NavPageCount.",".
            $arResult['ID'].",".
            $arParams['PAGE_ELEMENT_COUNT'].",".
            $arParams['ELEMENT_SORT_FIELD'].",".
            $arParams['ELEMENT_SORT_ORDER'];

//echo $dataAjax;
//echo 'Количество страниц: '.$arResult['NAV_RESULT']->NavPageCount;
//echo count($arResult["ITEMS"]);
?>

<div class="loading-block">


<div class="products">
    <div class="products__list" style="overflow: hidden" data-page="<?= $arResult['NAV_RESULT']->PAGEN ?>" data-showmore="<?= $dataAjax ?>">
        <h1 class="common-din">Найдено товаров:</h1>
        <div class="catalog-content_ajax" id="cardscontainer">
            <? foreach ($arResult["ITEMS"] as $arItem): ?>
                <? //echo $arItem['SHOW_COUNTER'];?>
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

    </div>
</div>


<?//debug($arResult['NAV_RESULT'])?>
<!--        <div class="clear"></div>-->

<?
//debug($arResult['NAV_RESULT']->PAGEN);
//debug($arResult['NAV_RESULT']->NavPageCount);


/*
<div class="products_other">
    <? if ($arResult['NAV_RESULT']->PAGEN < $arResult['NAV_RESULT']->NavPageCount) { ?>
        <div class="products__more js-showMore">
            <button class="btn">Показать еще</button>
        </div>
    <? } ?>
    <div class="control paging">
        <?=$arResult["NAV_STRING"]?><br />
    </div>
</div>
*/
?>

<?if($arResult["NAV_STRING"]):?>
    <div id="ajaxLoader" class="" style="text-align: center;margin: 0 0 20px;padding-bottom: 30px;">
        <span class="me-2 btn" style="display: inline-block;">Показать еще</span>
    </div>
    <!-- ПАГИНАЦИЯ -->
    <div  id="page_str" class="pager_block" style="display: none">
        <?=$arResult["NAV_STRING"]?><br />
    </div>
    <!-- ПАГИНАЦИЯ -->
    <div style="display:none" id="paginationcontainer"></div>
    <div style="display:none" id="loadedelements"></div>


    <script>


        $(function() {

            //var $nextPageToLoad = 2; // ну ясно понятно что вторая страница
            var $nextPageToLoad = parseInt($('.pagination').find($('a.current')).html()) + 1;
            if(!$nextPageToLoad){ $nextPageToLoad = 2}
            console.log('Текущая страница: '+parseInt($('.pagination').find($('a.current')).html()));
            var $pagesCnt = parseInt($('#countPages').html()-1); // всего количество страниц
            var $canAddItems = ($pagesCnt >= $nextPageToLoad);  // можем добавит ьили нет
            var $navNum = parseInt($('#NavNumPage').html());
            console.log($nextPageToLoad + ' ' + $pagesCnt + ' ' + $canAddItems);


            $('#ajaxLoader').on('click', function(e) {
                e.preventDefault();

                console.log('#ajaxLoader click');

                if (!$canAddItems) { $('#ajaxLoader').hide(); return; }

                //$('#ajaxLoader').html('Загружаю...');
                //$('#ajaxLoader').attr('disabled','disabled');

                $canAddItems = false;
                // $('.pagination__heading, .pagination').remove();
                // тут формируем урл в зависимости от проекта
                var $url = '<?=$_SERVER['REQUEST_URI']?><?=$_SERVER['QUERY_STRING']?"&":"?"?>PAGEN_'+$navNum+'='+$nextPageToLoad;

                console.log($url + ' ' + $nextPageToLoad + ' ' + $pagesCnt + ' ' + $canAddItems);

                // собственно получаем новые элементики и загружаем из в дополнительный контейнер
                $("#loadedelements").load($url +  " .loading-block" , function() {
                    //console.log('растусовываем');
                    $("#cardscontainer").append($('#loadedelements .catalog-content_ajax').html());
                    $("#page_str").html($('#loadedelements .pager_block').html());
                    $("#loadedelements").html(''); // почистим обязательно


                    $canAddItems = ($pagesCnt > $nextPageToLoad);
                    if (!$canAddItems) { $('#ajaxLoader').addClass('d-none'); }
                    //$('#ajaxLoader').hide();
                    $nextPageToLoad++; // берем следующую страницу
                    // $('.pagination__heading, .pagination').remove();
                    // $('.product-list-container-default>.text-center').remove();

                   // $('#ajaxLoader').html('Показать ещё');
                    //$('#ajaxLoader').removeAttr('disabled');
                });
                //}

            });
        });
    </script>


<?endif;?>


</div>








<script>
    $(document).ready(function(){
        console.log($('.count-product').length);
        $('.js-count-result').html($('.count-product').length);
    });

</script>

