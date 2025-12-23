<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$this->setFrameMode(true);

if(!$arResult["NavShowAlways"])
{
    if ($arResult["NavRecordCount"] == 0 || ($arResult["NavPageCount"] == 1 && $arResult["NavShowAll"] == false))
        return;
}


?>
<!--modern-page-navigation-->
<div class="pagination mt-3">
    <span id="countPages" style="display:block"><?=$arResult['NavPageCount']?></span>
    <span id="NavNumPage" style="display:block"><?=$arResult["NavNum"]?></span>
    <!--    <ul class="pagination">-->
    <?

    $strNavQueryString = ($arResult["NavQueryString"] != "" ? $arResult["NavQueryString"]."&amp;" : "");
    $strNavQueryStringFull = ($arResult["NavQueryString"] != "" ? "?".$arResult["NavQueryString"] : "");
    ?>

    <?
    if($arResult["bDescPageNumbering"] === true):
        $bFirst = true;
        if ($arResult["NavPageNomer"] < $arResult["NavPageCount"]):
            if($arResult["bSavePage"]):
                ?>

                <!--            <li><a class="modern-page-previous" href="--><?//=$arResult["sUrlPath"]?><!--?--><?//=$strNavQueryString?><!--PAGEN_--><?//=$arResult["NavNum"]?><!--=--><?//=($arResult["NavPageNomer"]+1)?><!--">--><?//=GetMessage("nav_prev")?><!--</a></li>-->
                <li>
                    <a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]+1)?>">
                        <svg width="24" height="14" viewBox="0 0 24 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M11.8114 0.114353C12.1234 0.27502 12.3179 0.580531 12.3179 0.912819V6.08703H23.0209C23.5614 6.08703 24 6.496 24 6.99991C24 7.50382 23.5614 7.91279 23.0209 7.91279H12.3179V13.087C12.3179 13.4205 12.1234 13.726 11.8114 13.8855C11.4994 14.0473 11.1182 14.0364 10.8166 13.8599L0.456894 7.77281C0.172314 7.60484 0 7.31394 0 6.99991C0 6.68588 0.172314 6.39497 0.456894 6.227L10.8166 0.139914C10.9759 0.0474087 11.1574 -6.10352e-05 11.3388 -6.10352e-05C11.5007 -6.10352e-05 11.6639 0.0388885 11.8114 0.114353Z" fill="#9BA5AB"/>
                        </svg>
                    </a>
                </li>
            <?
            else:
                if ($arResult["NavPageCount"] == ($arResult["NavPageNomer"]+1) ):
                    ?>
                    <!--                <li><a class="modern-page-previous" href="--><?//=$arResult["sUrlPath"]?><!----><?//=$strNavQueryStringFull?><!--">--><?//=GetMessage("nav_prev")?><!--</a></li>-->
                    <li>
                        <a href="<?=$arResult["sUrlPath"]?><?=$strNavQueryStringFull?>">
                            <svg width="24" height="14" viewBox="0 0 24 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M11.8114 0.114353C12.1234 0.27502 12.3179 0.580531 12.3179 0.912819V6.08703H23.0209C23.5614 6.08703 24 6.496 24 6.99991C24 7.50382 23.5614 7.91279 23.0209 7.91279H12.3179V13.087C12.3179 13.4205 12.1234 13.726 11.8114 13.8855C11.4994 14.0473 11.1182 14.0364 10.8166 13.8599L0.456894 7.77281C0.172314 7.60484 0 7.31394 0 6.99991C0 6.68588 0.172314 6.39497 0.456894 6.227L10.8166 0.139914C10.9759 0.0474087 11.1574 -6.10352e-05 11.3388 -6.10352e-05C11.5007 -6.10352e-05 11.6639 0.0388885 11.8114 0.114353Z" fill="#9BA5AB"/>
                            </svg>
                        </a>
                    </li>
                <?
                else:
                    ?>
                    <!--                <li><a class="modern-page-previous" href="--><?//=$arResult["sUrlPath"]?><!--?--><?//=$strNavQueryString?><!--PAGEN_--><?//=$arResult["NavNum"]?><!--=--><?//=($arResult["NavPageNomer"]+1)?><!--">--><?//=GetMessage("nav_prev")?><!--</a></li>-->
                    <li>
                        <a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]+1)?>">
                            <svg width="24" height="14" viewBox="0 0 24 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M11.8114 0.114353C12.1234 0.27502 12.3179 0.580531 12.3179 0.912819V6.08703H23.0209C23.5614 6.08703 24 6.496 24 6.99991C24 7.50382 23.5614 7.91279 23.0209 7.91279H12.3179V13.087C12.3179 13.4205 12.1234 13.726 11.8114 13.8855C11.4994 14.0473 11.1182 14.0364 10.8166 13.8599L0.456894 7.77281C0.172314 7.60484 0 7.31394 0 6.99991C0 6.68588 0.172314 6.39497 0.456894 6.227L10.8166 0.139914C10.9759 0.0474087 11.1574 -6.10352e-05 11.3388 -6.10352e-05C11.5007 -6.10352e-05 11.6639 0.0388885 11.8114 0.114353Z" fill="#9BA5AB"/>
                            </svg>
                        </a>
                    </li>
                <?
                endif;
            endif;

            if ($arResult["nStartPage"] < $arResult["NavPageCount"]):
                $bFirst = false;
                if($arResult["bSavePage"]):
                    ?>
                    <li><a class="modern-page-first" href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=$arResult["NavPageCount"]?>">1</a></li>
                <?
                else:
                    ?>
                    <li><a class="modern-page-first" href="<?=$arResult["sUrlPath"]?><?=$strNavQueryStringFull?>">1</a></li>
                <?
                endif;
                if ($arResult["nStartPage"] < ($arResult["NavPageCount"] - 1)):
                    /*?>
                                <span class="modern-page-dots">...</span>
                    <?*/
                    ?>
                    <li><a class="modern-page-dots" href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=intval($arResult["nStartPage"] + ($arResult["NavPageCount"] - $arResult["nStartPage"]) / 2)?>">...</a></li>
                <?
                endif;
            endif;
        endif;
        do
        {
            $NavRecordGroupPrint = $arResult["NavPageCount"] - $arResult["nStartPage"] + 1;

            if ($arResult["nStartPage"] == $arResult["NavPageNomer"]):
                ?>

                <li><a href="javascript:void(0)" class="selected"><?=$NavRecordGroupPrint?></a></li>
            <?
            elseif($arResult["nStartPage"] == $arResult["NavPageCount"] && $arResult["bSavePage"] == false):
                ?>
                <li><a href="<?=$arResult["sUrlPath"]?><?=$strNavQueryStringFull?>" class="<?=($bFirst ? "modern-page-first" : "")?>"><?=$NavRecordGroupPrint?></a></li>
            <?
            else:
                ?>
                <li><a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=$arResult["nStartPage"]?>"<?
                    ?> class="<?=($bFirst ? "modern-page-first" : "")?>"><?=$NavRecordGroupPrint?></a></li>
            <?
            endif;

            $arResult["nStartPage"]--;
            $bFirst = false;
        } while($arResult["nStartPage"] >= $arResult["nEndPage"]);

        if ($arResult["NavPageNomer"] > 1):
            if ($arResult["nEndPage"] > 1):
                if ($arResult["nEndPage"] > 2):
                    /*?>
                            <span class="modern-page-dots">...</span>
                    <?*/
                    ?>
                    <li><a class="modern-page-dots" href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=round($arResult["nEndPage"] / 2)?>">...</a></li>
                <?
                endif;
                ?>
                <li><a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=1"><?=$arResult["NavPageCount"]?></a></li>
            <?
            endif;

            ?>
            <!--        <li><a class="modern-page-next"href="--><?//=$arResult["sUrlPath"]?><!--?--><?//=$strNavQueryString?><!--PAGEN_--><?//=$arResult["NavNum"]?><!--=--><?//=($arResult["NavPageNomer"]-1)?><!--">--><?//=GetMessage("nav_next")?><!--</a></li>-->
            <li>
                <a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]-1)?>">
                    <svg width="24" height="14" viewBox="0 0 24 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12.1886 0.114353C11.8766 0.27502 11.6821 0.580531 11.6821 0.912819V6.08703H0.979059C0.438618 6.08703 0 6.496 0 6.99991C0 7.50382 0.438618 7.91279 0.979059 7.91279H11.6821V13.087C11.6821 13.4205 11.8766 13.726 12.1886 13.8855C12.5006 14.0473 12.8818 14.0364 13.1834 13.8599L23.5431 7.77281C23.8277 7.60484 24 7.31394 24 6.99991C24 6.68588 23.8277 6.39497 23.5431 6.227L13.1834 0.139914C13.0241 0.0474087 12.8426 -6.10352e-05 12.6612 -6.10352e-05C12.4993 -6.10352e-05 12.3361 0.0388885 12.1886 0.114353Z" fill="#232C31"/>
                    </svg>
                </a>
            </li>
        <?
        endif;

    else:






        $bFirst = true;

        if ($arResult["NavPageNomer"] > 1):
            if($arResult["bSavePage"]):
                ?>
                <!--            <li><a class="modern-page-previous" href="--><?//=$arResult["sUrlPath"]?><!--?--><?//=$strNavQueryString?><!--PAGEN_--><?//=$arResult["NavNum"]?><!--=--><?//=($arResult["NavPageNomer"]-1)?><!--">--><?//=GetMessage("nav_prev")?><!--</a></li>-->

                <a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]-1)?>" class="pagination__prev pagination__btn noSelect">
                    <svg>
                        <use href="/images/icons/sprites.svg#arrow"></use>
                    </svg>
                </a>
            <?
            else:
                if ($arResult["NavPageNomer"] > 2):
                    ?>
                    <!--                <li><a class="modern-page-previous" href="--><?//=$arResult["sUrlPath"]?><!--?--><?//=$strNavQueryString?><!--PAGEN_--><?//=$arResult["NavNum"]?><!--=--><?//=($arResult["NavPageNomer"]-1)?><!--">--><?//=GetMessage("nav_prev")?><!--</a></li>-->

                    <a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]-1)?>" class="pagination__prev pagination__btn noSelect">
                        <svg>
                            <use href="/images/icons/sprites.svg#arrow"></use>
                        </svg>
                    </a>
                <?
                else:
                    ?>
                    <!--                <li><a class="modern-page-previous" href="--><?//=$arResult["sUrlPath"]?><!----><?//=$strNavQueryStringFull?><!--">--><?//=GetMessage("nav_prev")?><!--</a></li>-->

                    <a href="<?=$arResult["sUrlPath"]?><?=$strNavQueryStringFull?>" class="pagination__prev pagination__btn noSelect">
                        <svg>
                            <use href="/images/icons/sprites.svg#arrow"></use>
                        </svg>
                    </a>
                <?
                endif;

            endif;

            if ($arResult["nStartPage"] > 1):
                $bFirst = false;
                if($arResult["bSavePage"]):
                    ?>
                    <!--                <li><a class="modern-page-first" href="--><?//=$arResult["sUrlPath"]?><!--?--><?//=$strNavQueryString?><!--PAGEN_--><?//=$arResult["NavNum"]?><!--=1">1</a></li>-->
                    <a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=1" class="pagination__link">1</a>
                <?
                else:
                    ?>
                    <!--                <li><a class="modern-page-first" href="--><?//=$arResult["sUrlPath"]?><!----><?//=$strNavQueryStringFull?><!--">1</a></li>-->
                    <a href="<?=$arResult["sUrlPath"]?><?=$strNavQueryStringFull?>" class="pagination__link">1</a>
                <?
                endif;
                if ($arResult["nStartPage"] > 2):
                    /*?>
                                <span class="modern-page-dots">...</span>
                    <?*/
                    ?>
                    <div class="pagination__link noLink">...</div>
                    <!--                <li><a class="modern-page-dots" href="--><?//=$arResult["sUrlPath"]?><!--?--><?//=$strNavQueryString?><!--PAGEN_--><?//=$arResult["NavNum"]?><!--=--><?//=round($arResult["nStartPage"] / 2)?><!--">...</a></li>-->
                <?
                endif;
            endif;
        endif;

        do
        {
            if ($arResult["nStartPage"] == $arResult["NavPageNomer"]):
                ?>
                <a href="javascript:void(0)" class="pagination__link current"><?=$arResult["nStartPage"]?></a>
                <!--        <li><a href="javascript:void(0)" class="selected">--><?//=$arResult["nStartPage"]?><!--</a></li>-->

            <?
            elseif($arResult["nStartPage"] == 1 && $arResult["bSavePage"] == false):
                ?>
                <a href="<?=$arResult["sUrlPath"]?><?=$strNavQueryStringFull?>" class="pagination__link"><?=$arResult["nStartPage"]?></a>
                <!--            <li><a href="--><?//=$arResult["sUrlPath"]?><!----><?//=$strNavQueryStringFull?><!--" class="--><?//=($bFirst ? "modern-page-first" : "")?><!--">--><?//=$arResult["nStartPage"]?><!--</a></li>-->
            <?
            else:
                ?>
                <a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=$arResult["nStartPage"]?>" class="pagination__link"><?=$arResult["nStartPage"]?></a>
                <!--        <li><a href="--><?//=$arResult["sUrlPath"]?><!--?--><?//=$strNavQueryString?><!--PAGEN_--><?//=$arResult["NavNum"]?><!--=--><?//=$arResult["nStartPage"]?><!--"--><?//
//            ?><!-- class="--><?//=($bFirst ? "modern-page-first" : "")?><!--">--><?//=$arResult["nStartPage"]?><!--</a></li>-->
            <?
            endif;
            $arResult["nStartPage"]++;
            $bFirst = false;
        } while($arResult["nStartPage"] <= $arResult["nEndPage"]);

        if($arResult["NavPageNomer"] < $arResult["NavPageCount"]):
            if ($arResult["nEndPage"] < $arResult["NavPageCount"]):
                if ($arResult["nEndPage"] < ($arResult["NavPageCount"] - 1)):
                    /*?>
                            <span class="modern-page-dots">...</span>
                    <?*/
                    ?>
                    <div class="pagination__link noLink">...</div>

                    <!--            <li><a class="modern-page-dots" href="--><?//=$arResult["sUrlPath"]?><!--?--><?//=$strNavQueryString?><!--PAGEN_--><?//=$arResult["NavNum"]?><!--=--><?//=round($arResult["nEndPage"] + ($arResult["NavPageCount"] - $arResult["nEndPage"]) / 2)?><!--">...</a></li>-->
                <?
                endif;
                ?>
                <a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=$arResult["NavPageCount"]?>" class="pagination__link"><?=$arResult["NavPageCount"]?></a>
                <!--            <li><a href="--><?//=$arResult["sUrlPath"]?><!--?--><?//=$strNavQueryString?><!--PAGEN_--><?//=$arResult["NavNum"]?><!--=--><?//=$arResult["NavPageCount"]?><!--">--><?//=$arResult["NavPageCount"]?><!--</a></li>-->
            <?
            endif;
            ?>
            <!--        <li><a class="modern-page-next" href="--><?//=$arResult["sUrlPath"]?><!--?--><?//=$strNavQueryString?><!--PAGEN_--><?//=$arResult["NavNum"]?><!--=--><?//=($arResult["NavPageNomer"]+1)?><!--">--><?//=GetMessage("nav_next")?><!--</a></li>-->

            <a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]+1)?>" class="pagination__next pagination__btn noSelect">
                <svg>
                    <use href="/images/icons/sprites.svg#arrow"></use>
                </svg>
            </a>
        <?
        endif;
    endif;










    if ($arResult["bShowAll"]):
        if ($arResult["NavShowAll"]):
            ?>
            <li><a class="modern-page-pagen" href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>SHOWALL_<?=$arResult["NavNum"]?>=0"><?=GetMessage("nav_paged")?></a></li>
        <?
        else:
            ?>
            <li><a class="modern-page-all" href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>SHOWALL_<?=$arResult["NavNum"]?>=1"><?=GetMessage("nav_all")?></a></li>
        <?
        endif;
    endif
    ?>
    <!--    </ul>-->
</div>