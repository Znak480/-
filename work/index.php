<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Интернет-магазин Знак"); 
CModule::IncludeModule("iblock");?><div class="common-content-thin collections-page">
	<div class="title-block regular-block">
		<ul class="parent">
			 <?$APPLICATION->IncludeComponent(
	"bitrix:breadcrumb",
	"",
	Array(
		"COMPONENT_TEMPLATE" => ".default",
		"START_FROM" => "0",
		"PATH" => "",
		"SITE_ID" => "-"
	)
);?><br>
		</ul>
	</div>
</div>
 &nbsp;&nbsp;<br><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>