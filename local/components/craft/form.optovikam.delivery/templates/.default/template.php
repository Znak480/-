<?php if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die(); ?>
<?php
/**
 * @var string $componentPath
 * @var array $arParams
 * @var array $arResult
 * @var CBitrixComponentTemplate $this
 * @global CMain $APPLICATION
 * @global CUser $USER
 * @global CDatabase $DB
 * @var CBitrixComponentTemplate $this
 * @var string $templateName
 * @var string $templateFile
 * @var string $templateFolder
 * @var string $componentPath
 * @var CraftFormOptovikamDelivery $component
 */

//$assets = \Bitrix\Main\Page\Asset::getInstance();
//$assets->addJs('https://code.jquery.com/jquery-3.7.1.js');
?>

<form class="form-table" id="dostpricewrap" data-dost-price-form>
	<div class="line">
		<div class="label">
			Организация *
		</div>
		<div class="input">
			<input value="" name="org" type="text">
		</div>
		<div class="clear">
		</div>
	</div>
	<div class="line">
		<div class="label">
			Ф. И. О. *
		</div>
		<div class="input">
			<input value="" name="fio" type="text">
		</div>
		<div class="clear">
		</div>
	</div>
	<div class="line">
		<div class="label">
			Телефон *
		</div>
		<div class="input">
			<input value="" name="phone" type="text">
		</div>
		<div class="clear">
		</div>
	</div>
	<div class="line">
		<div class="label">
			E-mail *
		</div>
		<div class="input">
			<input value="" name="email" type="text">
		</div>
		<div class="clear">
		</div>
	</div>
	<div class="line extended-line">
		<div class="label">
			Примечание
		</div>
		<div class="input">
			<textarea name="comment"></textarea>
		</div>
		<div class="clear">
		</div>
	</div>
	<div class="line extended-line">
		<div class="label">
		</div>
		<div class="input checkbox" style="width:370px">
			<input type="checkbox" name="check" style="display: inline-block">
			* Являюсь представителем оптовой компании
		</div>
		<div class="clear">
		</div>
	</div>

	<div class="line">
		<div class="label"></div>

		<div class="input">
			<div style="max-width:100%;">
				<input type="checkbox" value="Y" name="agree" data-agree-checkbox>
				Принимаю условия
				<a href="/agreement/" target="_blank">Пользовательского соглашения</a>
				, и соглашаюсь с
				<a href="/personal-data/" target="_blank">Политикой
					обработки и
					использования
					персональных
					данных
				</a>
			</div>
		</div>
		<div class="clear"></div>
	</div>

	<br>
	<br>
	<div class="line">
		<div class="label">
		</div>
		<div class="input">
			<input value="Отправить" type="submit">
		</div>
		<div class="clear">
		</div>
	</div>
	<div class="line">
		<div class="label">
		</div>
		<div class="input">
			* обязательно для заполнения
		</div>
		<div class="clear">
		</div>
	</div>
</form>
