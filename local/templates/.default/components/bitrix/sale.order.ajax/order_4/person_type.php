<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
if(count($arResult["PERSON_TYPE"]) > 1)
{
	?>
    <div class="customer_type">
        <h2><?=GetMessage("SOA_CUSTOMER_TITLE")?></h2>
        <div style="clear:  both;"></div>
    </div>
<div class="row">
        		<?foreach($arResult["PERSON_TYPE"] as $v):?>
<div class=col-6>
                    <input type=radio  name="PERSON_TYPE" id="PT<?=$v["ID"]?>" onChange="submitForm()" value="<?= $v["ID"] ?>" <?if ($v["CHECKED"]=="Y") echo " checked";?>> <label for="PT<?=$v["ID"]?>"><?= $v["NAME"] ?></label><br>
</div>
        		<?endforeach;?>
</div>
<br>
    		<input type="hidden" name="PERSON_TYPE_OLD" value="<?=$arResult["USER_VALS"]["PERSON_TYPE_ID"]?>" />
<?
}
?>