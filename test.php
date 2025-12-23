<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
CHTTP::SetStatus("404 Not Found");
@define("ERROR_404","Y");

if (!$USER->IsAdmin()){
    echo "Доступ запрещён";
} else {
    echo "Продолжайте <br>";
}
?>