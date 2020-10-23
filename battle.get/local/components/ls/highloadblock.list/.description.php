<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arComponentDescription = array(
	"NAME" => "Новостной блок",
	"DESCRIPTION" => "Выводит список записей заданного HL инфоблока",
	"CACHE_PATH" => "Y",
	"PATH" => array(
		"ID" => "Пользовательский компоненты",
		"CHILD" => array(
			"ID" => "hlblockusers",
			"NAME" => "Мои блоки",
		),
	),
);

?>