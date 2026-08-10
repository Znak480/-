<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if(empty($arResult))
	return "";

$showTitle = $arResult["SHOW_TITLE"] ?? "Y";

$strReturn = '';

$strReturn .= '<section class="breadcrumb">
	<div class="container">
		<ul class="breadcrumb-wrapper" role="navigation" aria-label="breadcrumb" itemscope itemtype="http://schema.org/BreadcrumbList">';

$itemSize = count($arResult);
for($index = 0; $index < $itemSize; $index++)
{
	$title = htmlspecialcharsex($arResult[$index]["TITLE"]);
	$link = $arResult[$index]["LINK"];
	$isLast = ($index == $itemSize - 1);
	$position = $index + 1;
	
	// Стрелка (кроме первого)
	if($index > 0) {
		$strReturn .= '
			<li class="breadcrumb-item" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
				<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
					<path d="M0 0h24v24H0z" fill="none" />
					<path fill="currentColor" d="M10 6L8.59 7.41L13.17 12l-4.58 4.59L10 18l6-6z" />
				</svg>';
	} else {
		$strReturn .= '
			<li class="breadcrumb-item" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">';
	}
	
	if($link <> "" && !$isLast)
	{
		$strReturn .= '
				<a class="breadcrumb-item-link" href="' . $link . '" title="' . $title . '" itemprop="item">
					<span itemprop="name">' . $title . '</span>
				</a>
				<meta itemprop="position" content="' . $position . '" />
			</li>';
	}
	else
	{
		$strReturn .= '
				<span class="breadcrumb-item-link" itemprop="name">' . $title . '</span>
				<meta itemprop="position" content="' . $position . '" />
			</li>';
	}
}

$lastTitle = htmlspecialcharsex($arResult[$itemSize-1]["TITLE"]);
$strReturn .= '</ul>';
		
if($showTitle === "Y"){
	$strReturn .= '<h1 class="breadcrumb-title">' . $lastTitle . '</h1>';
}

$strReturn .='</div></section>';

return $strReturn;
?>
