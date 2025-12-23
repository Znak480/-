<?php require_once($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php'); ?>
<?php

/**
 * @global CMain $APPLICATION
 */

use Bitrix\Main\Loader;
use Craft\Core\Html\Modal;
use Craft\Area\Rest\Response;
use Bitrix\Main\Application;
use Craft\Area\Entity\AreaField;
use Craft\Area\Entity\AreaFieldTable;
use Craft\Area\Admin\Helper\ComplexRow;
use Craft\Area\Admin\Settings\AreaBlockRowHelper;

foreach(['craft.area'] as $module)
{
	if(!Loader::includeModule($module))
	{
		throw new Exception('Модуль ' . $module . ' не подключен');
	}
}

global $APPLICATION;

$request = Application::getInstance()->getContext()->getRequest();
$action = $request->get('action') ?? $request->getPost('action');

switch($action)
{
	case 'addRowComplexField':

		$fieldId = $request->getPost('fieldId');
		if(!$fieldId)
		{
			Response::badRequest();
		}

		$field = AreaFieldTable::getByPrimary($fieldId)->fetchObject();
		if(!$field)
		{
			Response::badRequest();
		}

		Response::success([
			'template' => ComplexRow::render($field, null, rand()),
		]);

		break;
	case 'json':
		$formData = $request->getPostList()->toArray();
		Response::success([
			'json' => json_encode($formData),
		]);
		break;
	case 'getSettingsRow':
		$type = $request->getPost('type');
		$areaId = $request->getPost('areaId');
		$index = intval($request->getPost('index'));
		if(!$type)
		{
			throw new Exception('Тип поля не передан');
		}

		if(!$areaId)
		{
			throw new Exception('ID редактируемого блока не передан');
		}

		if($index < 0)
		{
			throw new Exception('Нет индекса');
		}


		$areaBlockRow = new AreaBlockRowHelper(
			new AreaField([AreaFieldTable::FIELD_TYPE => $type]),
			$areaId
		);

		ob_start();

		echo $areaBlockRow->render($index);

		Response::success([
			'template' => ob_get_clean(),
		]);

		break;
	case 'modal':

		$modal = $request->get('modal');
		if(!$modal)
		{
			Response::badRequest('Не верный запрос');
		}

		$key = $request->get('key');
		if(!$key)
		{
			Response::badRequest('Не верный запрос');
		}

		switch($modal)
		{
			case 'magicSettings':
				$APPLICATION->RestartBuffer();
				echo Modal::build()
					->title('Настройка составного свойства')
					->body(function() use ($key) {

						$renderCols = function() {
							ob_start();
							?>
							<div class="admin-form-row">
								<div class="admin-form-column">
									<label for="req">Обязательный</label>
									<input id="req" type="checkbox" name="required[]">
								</div>

								<div class="admin-form-column">
									<label for="name">Название</label>
									<input id="name" type="text" name="name[]">
								</div>

								<div class="admin-form-column">
									<label for="code">Символьный код</label>
									<input id="code" type="text" name="code[]">
								</div>

								<div class="admin-form-column">
									<label for="field">Тип поля</label>
									<select id="field" name="field[]">
										<?php
										foreach(AreaField::getRelateBlockTypeList() as $field)
										{
											?>
											<option value="<?=$field;?>"><?=AreaField::getTypeLabel($field);?></option>
											<?php
										}
										?>
									</select>
								</div>
							</div>

							<hr style="width: 100%; height: 1px;">
							<?php
							return ob_get_clean();
						};

						ob_start();
						?>
						<form method="post" data-magick-form="<?=$key;?>" class="settings-form">

							<div data-insert-target="magick-fields" class="admin-form-body settings-form-body">
								<?=$renderCols();?>
							</div>

							<div class="admin-form-footer settings-form-footer">
								<button class="btn-main"
										data-tpl="<?=htmlspecialcharsbx($renderCols());?>"
										data-insert="magick-fields"
										type="button">Добавить
								</button>
								<button class="btn-main second" type="submit">Сохранить</button>
							</div>
						</form>
						<?php
						return ob_get_clean();
					})
					->show();
				break;
		}

		break;
	default:
		Response::badRequest('Не верный запрос');
		break;
}

?>
