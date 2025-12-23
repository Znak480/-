<?
ignore_user_abort(false);
define("NO_KEEP_STATISTIC", true);
define("NO_AGENT_CHECK", true);
define('PUBLIC_AJAX_MODE', true);
$_SERVER["DOCUMENT_ROOT"] = $_SERVER['DOCUMENT_ROOT'].'';
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
$_SESSION["SESS_SHOW_INCLUDE_TIME_EXEC"]="N";
$APPLICATION->ShowIncludeStat = false;
CModule::IncludeModule("iblock");
CModule::IncludeModule("main");
CHTTP::SetStatus('404 Not Found');
define("IBLOCK_PRODUCTS_ID",19);
ini_set('display_errors', 0);
ini_set('log_errors','on');
ini_set("memory_limit", "1000M");
//$sl = setlocale(LC_ALL,'ru_RU.UTF-8');


$xml = simplexml_load_file("import0_1.xml");

if (!$xml){
    echo 'Ошибка получения объекта. Импорт прерван.';
    echo('Ошибка получения объекта. Импорт прерван.');
    echo "<br>Конец<br>";
    exit();
}
else {
    echo('Объект XML получен');
}
?>

<?
//обработка классификатора
$sections = array();//массив с разделами
$properties = array();//массив со свойствами
$products = array();//массив с товарами
$groups = $xml->Классификатор->Группы;

//получение списка разделов
foreach ($groups->Группа as $group){
    $sections[(string)$group->Ид]['ID'] =(string)$group->Ид;
    $sections[(string)$group->Ид]['NAME'] =(string) $group->Наименование;
    $sections[(string)$group->Ид]['PARENTS'][0] ="TOP";
    $sections[(string)$group->Ид]['DL'] ="1";
    //
    $arFilter = array('IBLOCK_ID' => 19,'DEPTH_LEVEL'=>1, 'NAME'=>(string) $group->Наименование); // выберет потомков без учета активности
    $rsSect = CIBlockSection::GetList(array(),$arFilter);
   	while ($arSect = $rsSect->GetNext()) {
		echo $arSect['NAME']." - ".$arSect['XML_ID']." - ".(string)$group->Ид;
/*		if(file_exists($_SERVER['DOCUMENT_ROOT']."/parseXML/pictures2sect/".(string)$group->Ид).".jpg") {
			echo ". Файл найден";
			rename($_SERVER['DOCUMENT_ROOT']."/parseXML/pictures2sect/".((string)$group->Ид).".jpg", $_SERVER['DOCUMENT_ROOT']."/parseXML/pictures2sect/".$arSect['XML_ID'].".jpg");
		}  else echo ". Файл не найден" ;
*/	}
	echo "<br>";;
    //
    if(isset($group->Группы)) {
        foreach ($group->Группы->Группа as $subGroup) {
            $sections[(string)$subGroup->Ид]['ID'] = (string)$subGroup->Ид;
            $sections[(string)$subGroup->Ид]['NAME'] = (string)$subGroup->Наименование;
            $sections[(string)$subGroup->Ид]['PARENTS'][0] = (string)$group->Ид;
            $sections[(string)$subGroup->Ид]['DL'] = "2";
    //
    $arFilter = array('IBLOCK_ID' => 19,'DEPTH_LEVEL'=>2, 'NAME'=>(string) $subGroup->Наименование); // выберет потомков без учета активности
    $rsSect = CIBlockSection::GetList(array(),$arFilter);
   	while ($arSect = $rsSect->GetNext()) {
		echo $arSect['NAME']." - ".$arSect['XML_ID'];
/*		if(file_exists($_SERVER['DOCUMENT_ROOT']."/parseXML/pictures2sect/".(string)$subGroup->Ид).".jpg") {
			echo ". Файл найден";
			rename($_SERVER['DOCUMENT_ROOT']."/parseXML/pictures2sect/".((string)$subGroup->Ид).".jpg", $_SERVER['DOCUMENT_ROOT']."/parseXML/pictures2sect/".$arSect['XML_ID'].".jpg");
		}  else echo ". Файл не найден";
*/	}
	echo "<br>";;
    //

            if (isset($subGroup->Группы)) {
                foreach ($subGroup->Группы->Группа as $subGroup3) {
                    $sections[(string)$subGroup3->Ид]['ID'] = (string)$subGroup3->Ид;
                    $sections[(string)$subGroup3->Ид]['NAME'] = (string)$subGroup3->Наименование;
                    $sections[(string)$subGroup3->Ид]['PARENTS'][0] = (string)$group->Ид;
                    $sections[(string)$subGroup3->Ид]['PARENTS'][1] = (string)$subGroup->Ид;
                    $sections[(string)$subGroup3->Ид]['DL'] = "3";
    //
    $arFilter = array('IBLOCK_ID' => 19,'DEPTH_LEVEL'=>3, 'NAME'=>(string) $subGroup3->Наименование); // выберет потомков без учета активности
    $rsSect = CIBlockSection::GetList(array(),$arFilter);
   	while ($arSect = $rsSect->GetNext()) {
		echo $arSect['NAME']." - ".$arSect['XML_ID'];
/*		if(file_exists($_SERVER['DOCUMENT_ROOT']."/parseXML/pictures2sect/".(string)$subGroup3->Ид).".jpg") {
			echo ". Файл найден";
			rename($_SERVER['DOCUMENT_ROOT']."/parseXML/pictures2sect/".((string)$subGroup3->Ид).".jpg", $_SERVER['DOCUMENT_ROOT']."/parseXML/pictures2sect/".$arSect['XML_ID'].".jpg");
		}  else echo ". Файл не найден" ;
*/	}
	echo "<br>";;
    //



                };
            };
        };
    };
};
//получение свойств
//print_r($sections);

?>