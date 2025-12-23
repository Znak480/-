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
 * @var CraftFormVacanciesAssign $component
 */
?>

<form class="form-table" data-vacancy-form>
	<div class="line">
		<div class="label">
			Ф. И. О. *
		</div>
		<div class="input">
			<input type="text" value="" name="fio" class="required">
		</div>
	</div>
	<div class="line">
		<div class="label">
			Телефон *
		</div>
		<div class="input">
			<input type="text" value="" name="phone" class="required">
		</div>
	</div>
	<div class="line">
		<div class="label">
			E-mail *
		</div>
		<div class="input">
			<input type="text" value="" name="email" class="required">
		</div>
	</div>
	<div class="line">
		<div class="label">
			Должность *
		</div>
		<div class="input">
			<input type="text" value="" name="dolzhnost" class="required">
		</div>
	</div>
	<div class="line">
		<div class="label">
			Резюме
		</div>
		<div class="input">
			<input type="file" value="" name="file">
		</div>
	</div>
	<div class="line">
		<div class="label">
		</div>
		<div class="input">
			<input type="submit" value="Отправить">
		</div>
	</div>
	<p>
	</p>
	<p>
	</p>
</form>
<div class="clear"></div>