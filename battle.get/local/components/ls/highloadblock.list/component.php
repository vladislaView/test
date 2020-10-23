<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true)die();

$requiredModules = array('highloadblock');
foreach ($requiredModules as $requiredModule)
{
	if (!CModule::IncludeModule($requiredModule))
	{
		ShowError(GetMessage("F_NO_MODULE"));
		return 0;
	}
}

use Bitrix\Highloadblock as HL;
use Bitrix\Main\Entity;

$hlblock_id = $arParams['BLOCK_ID'];
$iblock_id = $arParams['IBLOCK_ID'];

if (empty($hlblock_id))
{
	ShowError(GetMessage('HLBLOCK_LIST_NO_ID'));
	return 0;
}
if (empty($iblock_id))
{
	ShowError(GetMessage('IBLOCK_LIST_NO_ID'));
	return 0;
}
$hlblock = HL\HighloadBlockTable::getById($hlblock_id)->fetch();
if (empty($hlblock))
{
	ShowError(GetMessage('HLBLOCK_LIST_404'));
	return 0;
}

	
$entity = HL\HighloadBlockTable::compileEntity($hlblock);

$fields = $GLOBALS['USER_FIELD_MANAGER']->GetUserFields('HLBLOCK_'.$hlblock['ID'], 0, LANGUAGE_ID);

$mainQuery = new Entity\Query($entity);
$mainQuery->setSelect(array('*'));

$result = $mainQuery->exec();
$result = new CDBResult($result);

$rows = array();
$tableColumns = array();
while ($row = $result->fetch())
{
	foreach ($row as $k => $v)
	{
		$arUserField = $fields[$k];

		if ($k == 'ID')
		{
			$tableColumns['ID'] = true;
			continue;
		}
		if ($arUserField['SHOW_IN_LIST'] != 'Y')
		{
			continue;
		}

		$html = call_user_func_array(
			array($arUserField['USER_TYPE']['CLASS_NAME'], 'getadminlistviewhtml'),
			array(
				$arUserField,
				array(
					'NAME' => 'FIELDS['.$row['ID'].']['.$arUserField['FIELD_NAME'].']',
					'VALUE' => htmlspecialcharsbx(is_array($v) ? implode(', ', $v) : $v)
				)
			)
		);

		$tableColumns[$k] = true;
		$row[$k] = $html;
	}

	$rows[] = $row;
}

// Кэшируем необходимые данные
if ($this->StartResultCache(intval($arParams["CACHE_TIME"]))){

	$arResult['rows'] = $rows;
	$arResult['fields'] = $fields;
	$arResult['tableColumns'] = $tableColumns;
	$this->IncludeComponentTemplate();

}