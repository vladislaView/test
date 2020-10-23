<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true)die();

$arComponentParameters = array(
	'GROUPS' => array(
	),
	'PARAMETERS' => array(
		'BLOCK_ID' => array(
			'PARENT' => 'BASE',
			'NAME' => "ID highload блока",
			'TYPE' => 'TEXT',
			'DEFAULT' => '={$_REQUEST[\'BLOCK_ID\']}'
		),
		'ROW_KEY' => array(
			'PARENT' => 'BASE',
			'NAME' => 'Ключ записи',
			'TYPE' => 'TEXT',
			'DEFAULT' => 'ID'
		),
		'ROW_ID' => array(
			'PARENT' => 'BASE',
			'NAME' => 'Значение ключа записи',
			'TYPE' => 'TEXT',
			'DEFAULT' => '={$_REQUEST[\'ID\']}'
		),
		'LIST_URL' => array(
			'PARENT' => 'BASE',
			'NAME' => 'Путь к странице списка записей',
			'TYPE' => 'TEXT',
			'DEFAULT' => 'BLOCK_ID=#BLOCK_ID#'
		),
		"CACHE_TIME"  =>  array("DEFAULT"=>36000000),
		"CACHE_FILTER" => array(
			"PARENT" => "CACHE_SETTINGS",
			"NAME" => "Выбор кэша",
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "N",
		)
)
);