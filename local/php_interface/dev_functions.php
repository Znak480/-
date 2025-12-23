<?php

function DevIncludeFile($file, $path = NULL, array $arParams = [])
{
	$include = NULL;
	$includeFile = NULL;

	if(!$path)
	{
		$pathInfo = pathinfo($_SERVER['REAL_FILE_PATH'] ?: $_SERVER["SCRIPT_NAME"]);

		$includeFile = '';
		if($pathInfo['dirname'])
		{
			$includeFile = $pathInfo['dirname'] . '/';
		}

		$includeFile .= '.include/';
	} else
	{
		$path = str_replace($_SERVER['DOCUMENT_ROOT'], '', $path);
		$includeFile = $path;
	}

	$includeFile .= $file . '.php';

	$path_file = str_replace(['\\', '//'], "/", $includeFile);

	if(is_file($_SERVER['DOCUMENT_ROOT'] . $includeFile))
	{
		if(is_array($arParams))
		{
			extract($arParams, EXTR_SKIP);
		}

		$include = include $_SERVER['DOCUMENT_ROOT'] . $includeFile;
	}

	return $include;
}

function getBitrixMenuChilds($input, &$start = 0, $level = 0)
{
	$arIblockItemsMD5 = [];

	if(!$level)
	{
		$lastDepthLevel = 1;
		if($input && is_array($input))
		{
			foreach($input as $i => $arItem)
			{
				if($arItem['DEPTH_LEVEL'] > $lastDepthLevel)
				{
					if($i > 0)
					{
						if(!$input[$i - 1]['IS_PARENT'])
						{
							$input[$i - 1]['NO_PARENT'] = false;
						}
						$input[$i - 1]['IS_PARENT'] = 1;
					}
				}
				$lastDepthLevel = $arItem['DEPTH_LEVEL'];
			}
		}
	}

	$childs = [];
	$count = count($input);
	for($i = $start; $i < $count; ++$i)
	{
		$item = $input[$i];
		if(!isset($item))
		{
			continue;
		}
		if($level > $item['DEPTH_LEVEL'] - 1)
		{
			break;
		} else
		{
			if(!empty($item['IS_PARENT']))
			{
				$i++;
				$item['CHILDREN'] = getBitrixMenuChilds($input, $i, $level + 1);
				$i--;
			}

			$childs[] = $item;
		}
	}
	$start = $i;

	if(is_array($childs))
	{
		foreach($childs as $j => $item)
		{
			if($item['PARAMS'])
			{
				$md5 = md5(
					$item['TEXT'] . $item['LINK'] . $item['SELECTED'] . $item['PERMISSION'] . $item['ITEM_TYPE'] . $item['IS_PARENT'] . serialize(
						$item['ADDITIONAL_LINKS']
					) . serialize($item['PARAMS'])
				);

				// check if repeat in one section chids list
				if(isset($arIblockItemsMD5[$md5][$item['PARAMS']['DEPTH_LEVEL']]))
				{
					if(isset($arIblockItemsMD5[$md5][$item['PARAMS']['DEPTH_LEVEL']][$level]) || ($item['DEPTH_LEVEL'] === 1 && !$level))
					{
						unset($childs[$j]);
						continue;
					}
				}
				if(!isset($arIblockItemsMD5[$md5]))
				{
					$arIblockItemsMD5[$md5] = [$item['PARAMS']['DEPTH_LEVEL'] => [$level => true]];
				} else
				{
					$arIblockItemsMD5[$md5][$item['PARAMS']['DEPTH_LEVEL']][$level] = true;
				}
			}
		}
	}

	if(!$level)
	{
		$arIblockItemsMD5 = [];
	}

	return $childs;
}

/**
 * @param \Bitrix\Main\Type\Date $date
 * @return string
 */
function monthName($date)
{
	$stringMountName = '';

	$months = [
		1  => 'января',
		2  => 'февраля',
		3  => 'марта',
		4  => 'апреля',
		5  => 'мая',
		6  => 'июня',
		7  => 'июля',
		8  => 'августа',
		9  => 'сентября',
		10 => 'октября',
		11 => 'ноября',
		12 => 'декабря',
	];

	if(array_key_exists($date->format('m'), $months))
	{
		$stringMountName = $months[$date->format('m')];
	}

	return $stringMountName;
}

function getRealUserIp(): string
{
	$context = \Bitrix\Main\Application::getInstance()->getContext();
	$request = $context->getRequest();

	// Основные заголовки, используемые прокси-серверами
	$headers = [
		'HTTP_X_REAL_IP',
		'HTTP_X_FORWARDED_FOR',
		'HTTP_CLIENT_IP',
	];

	// Проверка заголовков в порядке приоритета
	foreach($headers as $header)
	{
		$ip = $request->getHeader($header);
		if($ip)
		{
			// Обработка цепочек IP (client, proxy1, proxy2)
			$ips = explode(',', $ip);
			$clientIp = trim(array_shift($ips));

			// Фильтрация валидного IP
			if(filter_var($clientIp, FILTER_VALIDATE_IP))
			{
				return $clientIp;
			}
		}
	}

	// Если заголовков нет - стандартный метод
	return $request->getRemoteAddress();
}
