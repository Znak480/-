<?php

namespace Craft\Core\Helper;

class TempImageHelper
{

	const TEMP_DATA_IMAGES = 'TEMP_DATA_IMAGES';
	const IS_TEST = 'IS_TEST';

	/**
	 * Эксперементальный метод для сайтов, где проблемы с папкой upload, в пути к картинкам вставляем
	 * этот метод чтобы выводилась заглушка во время работ только на тесте
	 *
	 * Возвращает путь к картинке по типу. Где ключ это тип заглушки. Значение путь к фото.
	 * Если заглушки нет, то вернет оригинал.
	 *
	 * Завести константу-массив с ключ-значением.
	 *
	 * Пример массива:
	 * news => /local/images/news_1.png
	 * blog => /local/images/blog_1.png
	 *
	 * @param string $orig Путь к оригинальному фото
	 * @param string $type Тип заглушки
	 * @return string
	 */
	public static function temp(string $orig, string $type): string
	{
		if(!defined(self::IS_TEST) || !IS_TEST)
		{
			return $orig;
		}

		if(!defined(self::TEMP_DATA_IMAGES))
		{
			return $orig;
		}

		if(!in_array($type, TEMP_DATA_IMAGES))
		{
			return $orig;
		}

		return TEMP_DATA_IMAGES[$type];
	}
}