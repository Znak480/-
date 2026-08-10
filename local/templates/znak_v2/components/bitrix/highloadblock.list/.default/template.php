<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
{
	die();
}

/** @global CMain $APPLICATION */
/** @var array $arParams */
/** @var array $arResult */


if (!empty($arResult['ERROR']))
{
	echo $arResult['ERROR'];
	return false;
}

?>
<div class="footer-social-icons">
	<? foreach($arResult['rows'] as $row):?>
		<a href="<?= $row["UF_LINK"]?>" target="_blank" rel="nofollow noopener">
		<?php
		$iconHtml = trim($row["UF_ICON"]);
		if (!empty($iconHtml)) {
			if (strpos($iconHtml, '<a') !== false) {
				preg_match('/href=["\']([^"\']+)["\']/i', $iconHtml, $matches);
				$href = $matches[1] ?? '';
				if ($href) {
					echo '<img src="' . htmlspecialchars($href) . '" alt="' . htmlspecialchars($row["UF_NAME"]) . '">';
				} else {
					echo $iconHtml;
				}
			} else {
				echo '<img src="' . htmlspecialchars($iconHtml) . '" alt="' . htmlspecialchars($row["UF_NAME"]) . '">';
			}
		}
		?>
		</a>
	<? endforeach;?>
</div>

