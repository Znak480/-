<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
$summa = 0;
$i = 0;
foreach ($arResult["ITEMS"] as &$v) {
    $i = $i + $v["QUANTITY"];
    $summa += $v['PRICE'] * $v["QUANTITY"];
} ?>
<div class="cart__wrapper">
  <div>
    <!-- <div class="link-to-cart">В вашей корзине</div> -->
    <div class="quantity"><?= $i ?> товаров</div>
    <div style="margin: 5px 0px -5px 0px">на сумму <?= $summa ?> руб</div>
  </div>
  <div class="bg"></div>
</div>