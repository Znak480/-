<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
 
<div id="compare_list_count" class="compare cell_block">
	<?if(count($arResult) <= 0):?>
	    К сравнению
	<?else:?>
	<a href="/compare/">В сравнении: </a> <span> <?=(count($arResult))?></span>
<?endif?>
	
</div>