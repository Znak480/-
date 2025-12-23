<?php

namespace Craft\Core\Component;

use Bitrix\Main\Diag\Debug;
use Craft\Core\Html\HtmlInterface;
use Craft\Form\Admin\Helper\FormFieldHelper;
use Craft\Core\Html\Html;
use Craft\Core\Component\Security\Csrf;

abstract class HtmlComponent extends BaseComponent
{
	protected ?string $htmlDriverClass = null;

	public function __construct($component = null)
	{
		if(is_null($this->htmlDriverClass))
		{
			$this->htmlDriverClass = Html::class;
		}

		parent::__construct($component);
	}

	public function htmlDriver(string $className): void
	{
		$obj = new $className();
		if(!$obj instanceof HtmlInterface)
		{
			throw new \Exception("Html Driver object must implement HtmlInterface");
		}

		$this->htmlDriverClass = $className;
	}

	public function beginForm(array $htmlOptions = []): string
	{
		$html = $this->htmlDriverClass::beginForm($htmlOptions);
		$html .= $this->htmlDriverClass::renderTag('input', [
			'name'  => '_csrf',
			'type'  => 'hidden',
			'value' => Csrf::getInstance()->generateToken(),
		]);

		if($this->arResult['SIGN_COMPONENT_PARAMS'])
		{
			$html .= $this->htmlDriverClass::renderTag('input', [
				'name'  => 'sign_component_params',
				'type'  => 'hidden',
				'value' => $this->arResult['SIGN_COMPONENT_PARAMS'],
			]);
		}


		return $html;
	}

	public function endForm(): string
	{
		return $this->htmlDriverClass::endForm();
	}


	public function input(string $propertyCode, array $htmlOptions = []): string
	{
		$property = $this->takeProperty($propertyCode);
		if(!$property)
		{
			return '';
		}

		$defaultOptions = [
			'name'        => $propertyCode,
			'placeholder' => $property['NAME'],
		];

		$defaultUserSettings = $property['SETTINGS'] ?? [];
		$typeField = $defaultUserSettings['TYPE_FIELD'] ?? FormFieldHelper::TYPE_FIELD_INPUT;

		switch($typeField)
		{
			case FormFieldHelper::TYPE_FIELD_SELECT:
				return $this->select(array_merge($defaultOptions, $htmlOptions));
			case FormFieldHelper::TYPE_FIELD_TEXTAREA:
				return $this->textarea(array_merge($defaultOptions, $htmlOptions));
			case FormFieldHelper::TYPE_FIELD_FILE:
				$defaultOptions['type'] = 'file';
				return $this->file(array_merge($defaultOptions, $htmlOptions));
			default:
				return $this->_input(array_merge($defaultOptions, $htmlOptions));
		}
	}

	protected function _input(array $htmlOptions = []): string
	{
		return $this->htmlDriverClass::renderTag('input', $htmlOptions);
	}

	protected function select(array $values, array $htmlOptions = []): string
	{
		return $this->htmlDriverClass::select($htmlOptions['name'], $values, $htmlOptions);
	}

	protected function textarea(array $htmlOptions = []): string
	{
		return $this->htmlDriverClass::textarea($htmlOptions);
	}

	protected function enum(string $name, array $htmlOptions = []): string
	{
		$dict = $this->getDictionary($name) ?? [];

		$dictionary = array_reduce($dict, function($result, $item) {
			$result[$item['ID']] = $item['LABEL'];
			return $result;
		}, []);


		return $this->select($dictionary, $htmlOptions);
	}

	protected function file(array $htmlOptions = []): string
	{
		return $this->htmlDriverClass::renderTag('input', $htmlOptions);
	}

	protected function fileMultiple(string $inputName, array $classList = []): string
	{
		ob_start();
		?>
		<input
			type="file"
			name="<?=$inputName;?>[]"
			<?=$classList ? 'class="' . implode(' ', $classList) . '"' : '';?>
			multiple
		>
		<?php
		return ob_get_clean();
	}
}