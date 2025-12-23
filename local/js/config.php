<?php
if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

$libs = [
	/*'polyphiles'    => [
		'js' => [
			'object_assign' => '/local/js/polyphiles/object_assign/object_assign.js',
		],
	],*/
];
$libs = array_merge($libs, [
	'polyphiles.object_assign' => [
		'js' => $libs['polyphiles']['js']['object_assign'],
	],
]);

foreach($libs as $libName => $lib)
{
	if(!isset($lib['skip_core']))
	{
		$lib['skip_core'] = true;
	}

	CJSCore::RegisterExt($libName, $lib);
}
