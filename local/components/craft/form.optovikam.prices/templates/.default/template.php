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
 * @var CraftFormOptovikamPrices $component
 */
?>


<h2 class="common-sans">Оптовые цены</h2>
<p>
	Чтобы получить оптовый прайс, отправьте запрос, заполнив форму:
</p>
<form data-opt-price class="form-table">
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