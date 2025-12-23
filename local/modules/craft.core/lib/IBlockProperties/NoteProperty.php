<?php

namespace Craft\Core\IBlockProperties;

class NoteProperty
{
	public static function getTypeDescription()
	{
		return [
			'PROPERTY_TYPE'        => 'S',
			'USER_TYPE'            => 'JEDI_NOTE_PROPERTY',
			'DESCRIPTION'          => '[craft] Произвольный текст',
			'GetPropertyFieldHtml' => [__CLASS__, 'GetPropertyFieldHtml'],
			'GetSettingsHTML'      => [__CLASS__, 'GetSettingsHTML'],
			'PrepareSettings'      => [__CLASS__, 'PrepareSettings'],
			'ConvertToDB'          => [__CLASS__, 'ConvertToDB'],
			'ConvertFromDB'        => [__CLASS__, 'ConvertFromDB'],
		];
	}

	public static function GetPropertyFieldHtml($arProperty, $value, $strHTMLControlName)
	{
		$html = 'Не указана';
		if($arProperty['USER_TYPE_SETTINGS']['VALUE'])
		{
			$html = $arProperty['USER_TYPE_SETTINGS']['VALUE'];
		}

		return $html;
	}

	public static function GetSettingsHTML($arProperty, $strHTMLControlName, &$arPropertyFields)
	{
		$arPropertyFields = [
			"HIDE" => ["FILTRABLE", "ROW_COUNT", "COL_COUNT", 'DEFAULT_VALUE'],
		];

		$value = '';
		if($arProperty['USER_TYPE_SETTINGS']['VALUE'])
		{
			$value = $arProperty['USER_TYPE_SETTINGS']['VALUE'];
		}

		return '<tr>
		<td>Текст подсказки:</td>
		<td>
			<textarea 
					cols="55" 
					rows="10" 
					name="' . $strHTMLControlName["NAME"] . '[VALUE]" 
					placeholder="Текст подсказки"
					>' . $value . '</textarea>
		</td>
		</tr>';
	}

	public static function PrepareSettings($arFields)
	{
		$fields = [];
		if(isset($arFields['USER_TYPE_SETTINGS']) && is_array($arFields['USER_TYPE_SETTINGS']))
		{
			$fields = $arFields['USER_TYPE_SETTINGS'];
		}

		return [
			'VALUE' => $fields['VALUE'],
		];
	}

	public static function ConvertToDB($arProperty, $value)
	{
		if(empty($value['VALUE']))
		{
			return false;
		}

		$value['VALUE'] = serialize($value['VALUE']);

		return $value;
	}

	public static function ConvertFromDB($arProperty, $value, $format = '')
	{
		$value['VALUE'] = unserialize($value['VALUE']);

		return $value;
	}
}
