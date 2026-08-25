<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
{
	die();
}

$this->setFrameMode(true);

if(!$arResult["NavShowAlways"])
{
	if ($arResult["NavRecordCount"] == 0 || ($arResult["NavPageCount"] == 1 && $arResult["NavShowAll"] == false))
		return;
}

$isAjax = isset($arParams['AJAX_MODE']) && $arParams['AJAX_MODE'] == 'Y';
$containerId = 'pagination-' . rand(1000, 9999);

$strNavQueryString = ($arResult["NavQueryString"] != "" ? $arResult["NavQueryString"]."&amp;" : "");
$strNavQueryStringFull = ($arResult["NavQueryString"] != "" ? "?".$arResult["NavQueryString"] : "");
?>

<!-- Классическая пагинация -->
<ul class="pagination">
<?
if($arResult["bDescPageNumbering"] === true):
	if ($arResult["NavPageNomer"] < $arResult["NavPageCount"]):
?>
	<li class="pagination-item">
		<a href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>PAGEN_<?= $arResult["NavNum"] ?>=<?= ($arResult["NavPageNomer"] + 1) ?>">
			<svg width="16" height="16" viewBox="0 0 24 24" fill="none">
				<path d="M15 18L9 12L15 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
			</svg>
		</a>
	</li>
<?
	else:
?>
	<li class="pagination-item disabled">
		<span>
			<svg width="16" height="16" viewBox="0 0 24 24" fill="none">
				<path d="M15 18L9 12L15 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
			</svg>
		</span>
	</li>
<?
	endif;
else:
	if ($arResult["NavPageNomer"] > 1):
?>
	<li class="pagination-item">
		<a href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>PAGEN_<?= $arResult["NavNum"] ?>=<?= ($arResult["NavPageNomer"] - 1) ?>">
			<svg width="16" height="16" viewBox="0 0 24 24" fill="none">
				<path d="M15 18L9 12L15 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
			</svg>
		</a>
	</li>
<?
	else:
?>
	<li class="pagination-item disabled">
		<span>
			<svg width="16" height="16" viewBox="0 0 24 24" fill="none">
				<path d="M15 18L9 12L15 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
			</svg>
		</span>
	</li>
<?
	endif;
endif;


if($arResult["bDescPageNumbering"] === true):
	$bFirst = true;
	if ($arResult["NavPageNomer"] < $arResult["NavPageCount"]):
		if ($arResult["nStartPage"] < $arResult["NavPageCount"]):
			$bFirst = false;
			if($arResult["bSavePage"]):
?>
	<li class="pagination-item <?= ($arResult["NavPageCount"] == $arResult["NavPageNomer"]) ? 'active' : '' ?>">
		<a href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>PAGEN_<?= $arResult["NavNum"] ?>=<?= $arResult["NavPageCount"] ?>">1</a>
	</li>
<?
			else:
?>
	<li class="pagination-item <?= ($arResult["NavPageCount"] == $arResult["NavPageNomer"]) ? 'active' : '' ?>">
		<a href="<?= $arResult["sUrlPath"] ?><?= $strNavQueryStringFull ?>">1</a>
	</li>
<?
			endif;
			if ($arResult["nStartPage"] < ($arResult["NavPageCount"] - 1)):
?>
	<li class="pagination-item disabled">
		<span>...</span>
	</li>
<?
			endif;
		endif;
	endif;
	
	do
	{
		$NavRecordGroupPrint = $arResult["NavPageCount"] - $arResult["nStartPage"] + 1;
		if ($arResult["nStartPage"] == $arResult["NavPageNomer"]):
?>
	<li class="pagination-item <?= ($bFirst ? 'first ' : '') ?>active">
		<span><?= $NavRecordGroupPrint ?></span>
	</li>
<?
		elseif($arResult["nStartPage"] == $arResult["NavPageCount"] && $arResult["bSavePage"] == false):
?>
	<li class="pagination-item <?= ($bFirst ? 'first ' : '') ?>">
		<a href="<?= $arResult["sUrlPath"] ?><?= $strNavQueryStringFull ?>"><?= $NavRecordGroupPrint ?></a>
	</li>
<?
		else:
?>
	<li class="pagination-item <?= ($bFirst ? 'first ' : '') ?>">
		<a href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>PAGEN_<?= $arResult["NavNum"] ?>=<?= $arResult["nStartPage"] ?>"><?= $NavRecordGroupPrint ?></a>
	</li>
<?
		endif;
		
		$arResult["nStartPage"]--;
		$bFirst = false;
	} while($arResult["nStartPage"] >= $arResult["nEndPage"]);

	if ($arResult["NavPageNomer"] > 1):
		if ($arResult["nEndPage"] > 1):
			if ($arResult["nEndPage"] > 2):
?>
	<li class="pagination-item disabled">
		<span>...</span>
	</li>
<?
			endif;
?>
	<li class="pagination-item">
		<a href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>PAGEN_<?= $arResult["NavNum"] ?>=1"><?= $arResult["NavPageCount"] ?></a>
	</li>
<?
		endif;
	endif;
	
else:
	$bFirst = true;
	if ($arResult["NavPageNomer"] > 1):
		if ($arResult["nStartPage"] > 1):
			$bFirst = false;
			if($arResult["bSavePage"]):
?>
	<li class="pagination-item <?= ($arResult["NavPageNomer"] == 1) ? 'active' : '' ?>">
		<a href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>PAGEN_<?= $arResult["NavNum"] ?>=1">1</a>
	</li>
<?
			else:
?>
	<li class="pagination-item <?= ($arResult["NavPageNomer"] == 1) ? 'active' : '' ?>">
		<a href="<?= $arResult["sUrlPath"] ?><?= $strNavQueryStringFull ?>">1</a>
	</li>
<?
			endif;
			if ($arResult["nStartPage"] > 2):
?>
	<li class="pagination-item disabled">
		<span>...</span>
	</li>
<?
			endif;
		endif;
	endif;

	do
	{
		if ($arResult["nStartPage"] == $arResult["NavPageNomer"]):
?>
	<li class="pagination-item <?= ($bFirst ? 'first ' : '') ?>active">
		<span><?= $arResult["nStartPage"] ?></span>
	</li>
<?
		elseif($arResult["nStartPage"] == 1 && $arResult["bSavePage"] == false):
?>
	<li class="pagination-item <?= ($bFirst ? 'first ' : '') ?>">
		<a href="<?= $arResult["sUrlPath"] ?><?= $strNavQueryStringFull ?>"><?= $arResult["nStartPage"] ?></a>
	</li>
<?
		else:
?>
	<li class="pagination-item <?= ($bFirst ? 'first ' : '') ?>">
		<a href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>PAGEN_<?= $arResult["NavNum"] ?>=<?= $arResult["nStartPage"] ?>"><?= $arResult["nStartPage"] ?></a>
	</li>
<?
		endif;
		
		$arResult["nStartPage"]++;
		$bFirst = false;
	} while($arResult["nStartPage"] <= $arResult["nEndPage"]);

	if($arResult["NavPageNomer"] < $arResult["NavPageCount"]):
		if ($arResult["nEndPage"] < $arResult["NavPageCount"]):
			if ($arResult["nEndPage"] < ($arResult["NavPageCount"] - 1)):
?>
	<li class="pagination-item disabled">
		<span>...</span>
	</li>
<?
			endif;
?>
	<li class="pagination-item">
		<a href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>PAGEN_<?= $arResult["NavNum"] ?>=<?= $arResult["NavPageCount"] ?>"><?= $arResult["NavPageCount"] ?></a>
	</li>
<?
		endif;
	endif;
endif;

// ===== СТРЕЛКА ВПЕРЕД =====
if($arResult["bDescPageNumbering"] === true):
	if ($arResult["NavPageNomer"] > 1):
?>
	<li class="pagination-item">
		<a href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>PAGEN_<?= $arResult["NavNum"] ?>=<?= ($arResult["NavPageNomer"] - 1) ?>">
			<svg width="16" height="16" viewBox="0 0 24 24" fill="none">
				<path d="M9 18L15 12L9 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
			</svg>
		</a>
	</li>
<?
	else:
?>
	<li class="pagination-item disabled">
		<span>
			<svg width="16" height="16" viewBox="0 0 24 24" fill="none">
				<path d="M9 18L15 12L9 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
			</svg>
		</span>
	</li>
<?
	endif;
else:
	if ($arResult["NavPageNomer"] < $arResult["NavPageCount"]):
?>
	<li class="pagination-item">
		<a href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>PAGEN_<?= $arResult["NavNum"] ?>=<?= ($arResult["NavPageNomer"] + 1) ?>">
			<svg width="16" height="16" viewBox="0 0 24 24" fill="none">
				<path d="M9 18L15 12L9 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
			</svg>
		</a>
	</li>
<?
	else:
?>
	<li class="pagination-item disabled">
		<span>
			<svg width="16" height="16" viewBox="0 0 24 24" fill="none">
				<path d="M9 18L15 12L9 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
			</svg>
		</span>
	</li>
<?
	endif;
endif;
?>
</ul>
