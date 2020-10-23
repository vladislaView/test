<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("detail");
?><?$APPLICATION->IncludeComponent(
	"ls:highloadblock.view",
	"",
	Array(
		"BLOCK_ID" => $_REQUEST['BLOCK_ID'],
		"CACHE_FILTER" => "N",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"LIST_URL" => "/",
		"ROW_ID" => $_REQUEST['ID'],
		"ROW_KEY" => "ID"
	)
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>