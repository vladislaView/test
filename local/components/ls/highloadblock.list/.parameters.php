<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true)die();

$arComponentParameters = array(

	'PARAMETERS' => array(
		'BLOCK_ID' => array(
			'PARENT' => 'BASE',
			'NAME' => "High-Block ID",
			'TYPE' => 'TEXT'
		),
		'DETAIL_URL' => array(
			'PARENT' => 'BASE',
			'NAME' => "URL-для детального просмотра",
			'TYPE' => 'TEXT',
			'DEFAULT' => "detail.php?BLOCK_ID=#BLOCK_ID# & ID=#ID#"
		),
		"CACHE_TIME"  =>  array("DEFAULT"=>36000000),
		'IBLOCK_ID' => array(
			'PARENT' => 'BASE',
			'NAME' => "Инфоблок голосования ID",
			'TYPE' => 'TEXT'
		),
	
	),
);