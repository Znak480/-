<?php

namespace Craft\Core\Html;

class Html implements HtmlInterface
{

	protected static ?Html $instance;

	public static function build(): Html
	{
		if(is_null(self::$instance))
		{
			self::$instance = new self();
		}

		return self::$instance;
	}

	public function beginForm(array $htmlOptions = []): string
	{
		return $this->beginTag('form', $htmlOptions);
	}

	public function endForm(): string
	{
		return $this->endTag('form');
	}

	public function renderTag(string $tag, array $htmlOptions = []): string
	{
		return sprintf('<%s %s>', $tag, $this->renderHtmlOptions($htmlOptions));
	}

	public function beginTag(string $tag, array $htmlOptions = []): string
	{
		return sprintf('<%s %s>', $tag, $this->renderHtmlOptions($htmlOptions));
	}

	public function endTag(string $tag): string
	{
		return '</' . $tag . '>';
	}

	public function renderHtmlOptions(array $htmlOptions): string
	{
		$_html = [];

		foreach($htmlOptions as $name => $value)
		{
			$_html[] = sprintf('%s="%s"', $name, $value);
		}

		return implode(' ', $_html);
	}


	public function select(string $inputName, array $values, array $htmlOptions = []): string
	{
		ob_start();
		?>
		<select <?=$this->renderHtmlOptions($htmlOptions);?>>
			<?php
			foreach($values as $value => $label)
			{
				?>
				<option value="<?=$value;?>"><?=$label;?></option>
				<?php
			}
			?>
		</select>
		<?php
		return ob_get_clean();
	}

	public function textarea(array $htmlOptions = []): string
	{
		ob_start();
		?>
		<textarea <?=$this->renderHtmlOptions($htmlOptions);?>></textarea>
		<?php
		return ob_get_clean();
	}

	public function input(string $inputName, array $htmlOptions = []): string
	{
		return self::baseInput($inputName, 'text', $htmlOptions);
	}

	public function baseInput(string $inputName, string $type, array $htmlOptions = []): string
	{
		$htmlOptions['type'] = $type;

		ob_start();
		?>
		<input <?=$this->renderHtmlOptions($htmlOptions);?>>
		<?php
		return ob_get_clean();
	}

	public function password(string $inputName, array $htmlOptions = []): string
	{
		return self::baseInput($inputName, 'password', $htmlOptions);
	}
}