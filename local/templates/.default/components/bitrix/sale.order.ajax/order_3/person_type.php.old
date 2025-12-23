<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
if(count($arResult["PERSON_TYPE"]) > 1)
{
	?>
    <div class="customer_type">
        <h2><?=GetMessage("SOA_CUSTOMER_TITLE")?></h2>
        <div style="clear:  both;"></div>
    </div>
    	<div class="type">
	<DIV CLASS="bx_block r1x3 pt8">
		Тип покупателя
	</DIV>


<!-- <pre>
<?var_dump($arResult["PERSON_TYPE"]);?>
</pre> -->
	<div class="bx_block r3x1">
            <select id="PERSON_TYPE_<?= $v["ID"] ?>" name="PERSON_TYPE" onChange="submitForm()">
        		<?foreach($arResult["PERSON_TYPE"] as $v):?>
                    <option value="<?= $v["ID"] ?>" <?if ($v["CHECKED"]=="Y") echo " selected=\"selected\"";?>><?= $v["NAME"] ?></option>
        		<?endforeach;?>
            </select>
    		<input type="hidden" name="PERSON_TYPE_OLD" value="<?=$arResult["USER_VALS"]["PERSON_TYPE_ID"]?>" />
    	</div>
	</div>


	<?
}
else
{
	if(IntVal($arResult["USER_VALS"]["PERSON_TYPE_ID"]) > 0)
	{
		//for IE 8, problems with input hidden after ajax
		?>
		<span style="display:none;">
		<input type="text" name="PERSON_TYPE" value="<?=IntVal($arResult["USER_VALS"]["PERSON_TYPE_ID"])?>" />
		<input type="text" name="PERSON_TYPE_OLD" value="<?=IntVal($arResult["USER_VALS"]["PERSON_TYPE_ID"])?>" />
		</span>
		<?
	}
	else
	{
		foreach($arResult["PERSON_TYPE"] as $v)
		{
			?>
			<input type="hidden" id="PERSON_TYPE" name="PERSON_TYPE" value="<?=$v["ID"]?>" />
			<input type="hidden" name="PERSON_TYPE_OLD" value="<?=$v["ID"]?>" />
			<?
		}
	}
}
?>