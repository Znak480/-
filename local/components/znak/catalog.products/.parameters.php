<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arComponentParameters = array(
    "GROUPS" => array(),
    "PARAMETERS" => array(
        "IBLOCK_ID" => array(
            "PARENT" => "BASE",
            "NAME" => "Инфоблок",
            "TYPE" => "STRING",
            "DEFAULT" => "",
        ),
        "FILTER" => array(
            "PARENT" => "BASE",
            "NAME" => "Дополнительный фильтр (JSON)",
            "TYPE" => "STRING",
            "DEFAULT" => "{}",
        ),
        "ELEMENTS_COUNT" => array(
            "PARENT" => "BASE",
            "NAME" => "Количество товаров",
            "TYPE" => "STRING",
            "DEFAULT" => "4",
        ),
        "SORT_BY" => array(
            "PARENT" => "BASE",
            "NAME" => "Сортировка",
            "TYPE" => "LIST",
            "VALUES" => array(
                "RAND" => "Случайно",
                "PROPERTY_RAITING_PRODAZH" => "По рейтингу продаж",
                "NAME" => "По названию",
                "ID" => "По ID",
                "DATE_ACTIVE_FROM" => "По дате",
            ),
            "DEFAULT" => "RAND",
        ),
        "SORT_ORDER" => array(
            "PARENT" => "BASE",
            "NAME" => "Порядок сортировки",
            "TYPE" => "LIST",
            "VALUES" => array(
                "ASC" => "По возрастанию",
                "DESC" => "По убыванию",
            ),
            "DEFAULT" => "DESC",
        ),
        "TITLE" => array(
            "PARENT" => "BASE",
            "NAME" => "Заголовок блока",
            "TYPE" => "STRING",
            "DEFAULT" => "",
        ),
        "CACHE_TIME" => array(
            "DEFAULT" => 3600,
        ),
        "ADDITIONAL_CLASSES"=>array(
            "PARENT" => "VISUAL",
            "NAME" => "Дополнительные CSS классы",
            "TYPE" => "STRING",
            "DEFAULT" => "",
            "REFRESH" => "Y"
        )
    ),
);
?>