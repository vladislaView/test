<?

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if (!empty($arResult['ERROR']))
{
	ShowError($arResult['ERROR']);
	return false;
}

global $USER_FIELD_MANAGER;

//$GLOBALS['APPLICATION']->SetTitle('Highloadblock Row');

$listUrl = str_replace('#BLOCK_ID#', intval($arParams['BLOCK_ID']),	$arParams['LIST_URL']);

?>

<a href="<?=htmlspecialcharsbx($listUrl)?>">Вернутся к новостям</a><br><br>

<div class="reports-result-list-wrap">
	<div class="report-table-wrap">


			<? foreach($arResult['fields'] as $field): ?>
				
				<div>
					<?
					$valign = "";
					$html = $USER_FIELD_MANAGER->getListView($field, $arResult['row'][$field['FIELD_NAME']]);
					?>
					<div class="reports-last-column"><?=$html?></div>
				</div>
			<? endforeach; ?>
	</div>
</div>