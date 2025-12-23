<?require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");?>
<?//require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");?>
<?
//var_dump($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
?>
<?$APPLICATION->IncludeComponent("bitrix:sale.order.payment","",Array(
    )
);?>

<script>

    document.querySelector('.sale-paysystem-button-container input').click();
    </script>
<?//require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
