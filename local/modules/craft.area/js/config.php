<?php
if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

$root = '/local/modules/craft.area/js';

$libs = [
	'craft.area.jquery' => [
		'js' => $root . '/craft.area.jquery/jquery-3.7.1.js',
	],
	'fbox'             => [
		'js'  => $root . '/fbox/fbox.js',
		'css' => $root . '/fbox/fbox.css',
	],
	'craftArea'         => [
		'js'  => $root . '/craftArea/script.js',
		'css' => $root . '/craftArea/style.css',
		'rel' => [
			'craft.area.jquery',
			'fbox',
		],
	],
	'copyTemplate'     => [
		'js'  => $root . '/copyTemplate/script.js',
		'css' => $root . '/copyTemplate/style.css',
		'rel' => [
			'craft.area.jquery',
		],
	],
];

foreach($libs as $libName => $lib)
{
	if(!isset($lib['skip_core']))
	{
		$lib['skip_core'] = true;
	}

	CJSCore::RegisterExt($libName, $lib);
}

