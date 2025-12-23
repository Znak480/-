<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/*
$APPLICATION->SetAdditionalCSS($templateFolder."/style_cart.css");
$APPLICATION->SetAdditionalCSS($templateFolder."/style.css");
*/
CJSCore::Init(array('fx', 'popup', 'window', 'ajax'));
?>
<div class="container">
	

<div class="data">
<a name="order_form" style="display:none"></a>

<div id="order_form_div" class="order-checkout">
<NOSCRIPT>
	<div class="errortext"><?=GetMessage("SOA_NO_JS")?></div>
</NOSCRIPT>

<?
if (!function_exists("getColumnName"))
{
	function getColumnName($arHeader)
	{
		return (strlen($arHeader["name"]) > 0) ? $arHeader["name"] : GetMessage("SALE_".$arHeader["id"]);
	}
}

if (!function_exists("cmpBySort"))
{
	function cmpBySort($array1, $array2)
	{
		if (!isset($array1["SORT"]) || !isset($array2["SORT"]))
			return -1;

		if ($array1["SORT"] > $array2["SORT"])
			return 1;

		if ($array1["SORT"] < $array2["SORT"])
			return -1;

		if ($array1["SORT"] == $array2["SORT"])
			return 0;
	}
}
?>

<div class="bx_order_make mb-80">
	<?
	if(!$USER->IsAuthorized() && $arParams["ALLOW_AUTO_REGISTER"] == "N")
	{
		if(!empty($arResult["ERROR"]))
		{
			foreach($arResult["ERROR"] as $v)
				echo ShowError($v);
		}
		elseif(!empty($arResult["OK_MESSAGE"]))
		{
			foreach($arResult["OK_MESSAGE"] as $v)
				echo ShowNote($v);
		}

		include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/auth.php");
	}
	else
	{
		if($arResult["ORDER_ID"]>0)
		{
			if(strlen($arResult["REDIRECT_URL"]) > 0)
			{
				?>
				<script type="text/javascript">
				window.top.location.href='<?=CUtil::JSEscape($arResult["REDIRECT_URL"])?>';

				</script>
				<?
				die();
			} else {
				include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/confirm.php");
			}

		}
		else
		{
			?>
			<script type="text/javascript">
            
            BX.addCustomEvent("onAjaxSuccess", refreshform);
            
            function refreshform()
            {
//                $('select').styler();
            }
            
			function submitForm(val)
			{
   
				if(val != 'Y')
					BX('confirmorder').value = 'N';

				var orderForm = BX('ORDER_FORM');

				BX.ajax.submitComponentForm(orderForm, 'order_form_content', true);
				BX.submit(orderForm);
                
				BX.closeWait();                

				return true;
			}

			function SetContact(profileId)
			{
				BX("profile_change").value = "Y";
				submitForm();
			}
			</script>
			<?if($_POST["is_ajax_post"] != "Y")
			{
				?>
                <form action="<?=$APPLICATION->GetCurPage();?>" method="POST" name="ORDER_FORM" id="ORDER_FORM" enctype="multipart/form-data">
				<?=bitrix_sessid_post()?>
				<div id="order_form_content">
				<?
			}
			else
			{
				$APPLICATION->RestartBuffer();
			}
			if(!empty($arResult["ERROR"]) && $arResult["USER_VALS"]["FINAL_STEP"] == "Y")
			{
				foreach($arResult["ERROR"] as $v)
					echo ShowError($v);

				?>
				<script type="text/javascript">
					top.BX.scrollToNode(top.BX('order_form_div'));
				</script>
				<?
			}
?>
<div class="row">
	<div class="col-6">
<?
			include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/person_type.php");
			include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/props.php");

?>
<?
	global $currentCity;

	$arSelect = Array("ID", "IBLOCK_ID", "NAME", "EXTERNAL_ID","PROPERTY_*");//IBLOCK_ID и ID обязательно должны быть указаны, см. описание arSelectFields выше
	$res = CIBlockElement::GetList(array(), array("IBLOCK_ID"=>"18","ACTIVE"=>"Y"), false, Array("nPageSize"=>50), $arSelect);
	//
	//
	$cnt=0;
	$arFieldsDefault=array();$arPropsDefault=array();
	while($ob = $res->GetNextElement()){ 
 		$arFields = $ob->GetFields();  
		$arProps = $ob->GetProperties();
		if($cnt==0) {
			$arFieldsDefault=$arFields;
			$arPropsDefault=$arProps;
		}
		if($arProps['DOMAIN']['VALUE']==$_SERVER['SERVER_NAME']){
			$currentCity = array_merge($arFields, $arProps);
			define("CITY_NAME", $arFields['NAME']);
			break;
		}
		$cnt++;
	}
	// если не попали в домен
	if(!defined('CITY_NAME')) {
		$currentCity = array_merge($arFieldsDefault, $arPropsDefault);
		define("CITY_NAME", 'Барнаул');
	}

?>


			<input type="hidden" size="" value="<?=CITY_NAME?>" name="ORDER_PROP_5" id="ORDER_PROP_5">
	</div>
	<div class="col-6">

<?
/*			if ($arParams["DELIVERY_TO_PAYSYSTEM"] == "p2d")
			{
				include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/paysystem.php");
				include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/delivery.php");
			}
			else
			{*/
				include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/paysystem.php");
				include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/delivery.php");
/*			}*/

//			include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/related_props.php");
			// print_r($arResult);
?>
	</div>
</div>
<?
			include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/summary.php");

			if(strlen($arResult["PREPAY_ADIT_FIELDS"]) > 0)
				echo $arResult["PREPAY_ADIT_FIELDS"];
			?>
            
<!--             <input type="hidden" name="confirmorder" id="confirmorder" value="Y" />
			<input type="hidden" name="profile_change" id="profile_change" value="N" />
			<input type="hidden" name="is_ajax_post" id="is_ajax_post" value="Y" />
			<div class="bx_ordercart_order_pay_center">
				<a href="javascript:void();" onClick="submitForm('Y'); return false;" class="btn btn_size-l btn_main"><?=GetMessage("SOA_TEMPL_BUTTON")?></a>
			</div> -->
            
			</div>
			</div>
			</div>
            
			<?if($_POST["is_ajax_post"] != "Y")
			{
				?>
					
				</form>
				<?
				if($arParams["DELIVERY_NO_AJAX"] == "N")
				{
					$APPLICATION->AddHeadScript("/bitrix/js/main/cphttprequest.js");
					$APPLICATION->AddHeadScript("/bitrix/components/bitrix/sale.ajax.delivery.calculator/templates/.default/proceed.js");
				}
			}
			else
			{
				?>
					<script type="text/javascript">
						top.BX('confirmorder').value = 'Y';
						top.BX('profile_change').value = 'N';
					</script>
				<?
				die();
			}
		}
	}
	?>
	</div>
</div>
</div>


</div>