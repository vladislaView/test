<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
if (!empty($arResult['ERROR']))
{
	echo $arResult['ERROR'];
	return false;
}

// Расчет IP пользователя
function getRealIP() {
      $ip = false;
      if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
         $ips = explode (', ', $_SERVER['HTTP_X_FORWARDED_FOR']);
         for ($i = 0; $i < count($ips); $i++) {
            if (!preg_match("/^(10|172\\.16|192\\.168)\\./", $ips[$i])) {
               $ip = $ips[$i];
               break;
            }
         }
      }
      return ($ip ? $ip : $_SERVER['REMOTE_ADDR']);
}
// Получение текущих оценок
function getVote(){
	$arSelect = Array("NAME","PROPERTY_IP","PROPERTY_IDNews","PROPERTY_LIKE");//IBLOCK_ID и ID обязательно должны быть указаны, см. описание arSelectFields выше
	$arFilter = Array("IBLOCK_ID"=>"2","NAME"=>getCurrentUser(),"PROPERTY_IP" => getRealIP());
	$rs = CIBlockElement::GetList(false, $arFilter, false, false, $arSelect);	
	
	while($ob = $rs->GetNext()){
	$id = $ob["PROPERTY_IDNEWS_VALUE"];	
	$arProps[$id] =$ob;		
	$id++;
	}	
	   return $arProps;
}
// Получение авторизованного пользователя
function getCurrentUser(){
	global $USER;
	if ($USER->IsAuthorized()) 
 	{
  	$rsUser = CUser::GetByID($USER->GetID()); 
  	$arUser = $rsUser->Fetch();
  	$user = $arUser["NAME"]." ".$arUser["LAST_NAME"];
	} 
	return $user; 
}
// Добавление голоса
function addDB($dataNews,$isLike){
	$el = new CIBlockElement;
	$name = getCurrentUser();
	$PROP = array();
	$PROP[1] = 1;  // highblock id
	$PROP[2] = $dataNews; //  id новость
	if(!empty($dataNews)&&!empty($isLike)){
	if($isLike)
		$PROP[3] = 1;
	else
		$PROP[3] = -1;    //like = 1 dislike = -1    
	$PROP[4] = getRealIP(); 
	
	$arLoadProductArray = Array(
	  "IBLOCK_SECTION_ID" => false,          // элемент лежит в корне раздела
	  "IBLOCK_ID"      => 2, //idblock голосов 
	  "PROPERTY_VALUES"=> $PROP,
	  "NAME"           => $name // author
	  );
	if($PRODUCT_ID = $el->Add($arLoadProductArray))
	  echo "New ID: ".$PRODUCT_ID;
	else
	  echo "Error: ".$el->LAST_ERROR;
	} 
}

?>

<div>
	<?
	$res = getVote();
	?>
	<!-- Перебор результатов  -->
	<? foreach ($arResult['rows'] as $row): ?>
	
	<div class="reports-list-item">
		<? foreach(array_keys($arResult['tableColumns']) as $col): ?>
		<?

		$finalValue = $row[$col];

		if ($col === 'ID' && !empty($arParams['DETAIL_URL']))
		{
			$url = str_replace(
				array('#ID#', '#BLOCK_ID#'),
				array($finalValue, intval($arParams['BLOCK_ID'])),
				$arParams['DETAIL_URL']
			);
			$id = $row[$col];
			$finalValue = '<a href="'.htmlspecialcharsbx($url).'">';
		}

		?>
		<?=$finalValue?>
		
		<br>
		<? endforeach; ?>
		</a>
		<? if((!empty($res[$id]["PROPERTY_IDNEWS_VALUE"])) && ($res[$id]["PROPERTY_IDNEWS_VALUE"] == $id)):?>
		<? if($res[$id]["PROPERTY_LIKE_VALUE"]==1)
			echo "Вы проголосовали +";	
		else if($res[$id]["PROPERTY_LIKE_VALUE"]==-1)
			echo "Вы проголосовали -";?>
		<?else:?>
	<form  name = "test" method="post">
	<button type="submit" name="like" value="<?=$id?>">Проголосовать +</button>
	<button type="submit" name="dizlike" value="<?=$id?>">Проголосовать -</button>
	</form>
	<?endif;?>
	</div>
	
</div>

<? endforeach; ?>
<?
// Тем называемые события по нажатию кнопки "Проголосовать" Требует доработки! 
if (isset($_POST['like'])) {
	addDB($_POST['like'],true);
	isset($_POST);
}
else if(isset($_POST['dizlike'])){
	addDB($_POST['dizlike'],false);
	isset($_POST);
}
?>
