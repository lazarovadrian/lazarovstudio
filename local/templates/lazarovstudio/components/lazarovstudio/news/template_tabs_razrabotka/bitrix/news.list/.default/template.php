<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);


	$arSections = Array();
	$arFilter = array('IBLOCK_ID' => $arParams['IBLOCK_ID'], 'ID'=>$arParams['SECTION_ID']);
	$arSelect = array('ID', 'NAME', 'CODE','DESCRIPTION','PREVIEW_PICTURE');
	$rsSect = CIBlockSection::GetList(
		Array(), //сортировка
		$arFilter, //фильтр (выше объявил)
		false, //выводить количество элементов - нет
		$arSelect //выборка вывода
	);
	while ($arSect = $rsSect->GetNext()) {
		$arSelFlds["ID"] = $arSect["ID"];
		$arSelFlds["NAME"] = $arSect["NAME"];
		$arSelFlds["CODE"] = $arSect["CODE"];
		$arSelFlds["DESCRIPTION"] = $arSect["DESCRIPTION"];
		$arSelFlds["PICTURE"] = CFile::GetPath($arSect["PICTURE"]);
		$arSections["SECTION"][] = $arSelFlds;
	}


    $arItemElems = Array();//массив для элементов
    $arFilter = Array('IBLOCK_ID'=>$arParams['IBLOCK_ID'], 'GLOBAL_ACTIVE'=>'Y', 'SECTION_ID'=>$arParams["SECTION_ID"]);//фильтруем по нужному разделу
    
    /*Формируем массив элементов из выбраного раздела*/
    $arSelect = Array("ID", "ACTIVE", "IBLOCK_ID", "NAME", "PREVIEW_PICTURE", "PREVIEW_TEXT", "DETAIL_TEXT", "DETAIL_PAGE_URL", "PROPERTY_*");
    $res = CIBlockElement::GetList(Array("SORT"=>"ASC", 'GLOBAL_ACTIVE'=>'Y'), $arFilter, false, false, $arSelect);
    
    while($item = $res->GetNextElement()){
        $arElemFields = $item->GetFields();
        $arSelFlds["ID"] = $arElemFields["ID"];
        $arSelFlds["ACTIVE"] = $arElemFields["ACTIVE"];
        $arSelFlds["NAME"] = $arElemFields["NAME"];
        $arSelFlds["PICTURE"] = CFile::GetPath($arElemFields["PREVIEW_PICTURE"]);
        $arSelFlds["PREVIEW_TEXT"] = $arElemFields["PREVIEW_TEXT"];
        $arSelFlds["DETAIL_PAGE_URL"] = $arElemFields["DETAIL_PAGE_URL"];
        $arProps = $item->GetProperties();
		$arSelFlds["ATTR_PRICE_NAME"] = $arProps["ATTR_PRICE"]["NAME"];
		$arSelFlds["ATTR_PRICE_VALUE"] = $arProps["ATTR_PRICE"]["VALUE"];
		$arSelFlds["ATTR_DEADLINE_NAME"] = $arProps["ATTR_DEADLINE"]["NAME"];
		$arSelFlds["ATTR_DEADLINE_VALUE"] = $arProps["ATTR_DEADLINE"]["VALUE"];
		$arSelFlds["ATTR_BTN_CALC_PRICE_NAME"] = $arProps["ATTR_BTN_CALC_PRICE"]["NAME"];
		$arSelFlds["ATTR_BTN_CALC_PRICE_VALUE"] = $arProps["ATTR_BTN_CALC_PRICE"]["VALUE"];

        //добавляем все что выбрали выше
        $arItemElems["ITEM"][] = $arSelFlds;
    }
?>

<div class="razrabotka_tabs container">
	<div class="section-title title_left">
		<?foreach($arSections["SECTION"] as $tabsInfo):?>
			<span><?=$tabsInfo["DESCRIPTION"]?></span>
			<h2 class="title"><?=$tabsInfo["NAME"]?></h2>
		<?endforeach;?>
	</div>
	<div class="razrabotka_tabs__item">

		<?foreach($arItemElems["ITEM"] as $keyTab => $arItem):?>
			<?
				$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
				$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
			?>
			<?if($arItem["ACTIVE"] != "N"):?>
				<div class="item" id="<?=$this->GetEditAreaId($arItem['ID']);?>">

					<button 
						class="title <?=$keyTab == 0 ? "" : "collapsed" ?>"
						id="heading<?=$keyTab?>"
						data-bs-toggle="collapse" 
						data-bs-target="#collapse<?=$keyTab;?>" 
						aria-expanded="<?=$keyTab == 0 ? "true" : "false" ?>" 
						aria-controls="collapse<?=$keyTab;?>"
					>
						<?=$arItem["NAME"]?>
					</button>

					<div 
						id="collapse<?=$keyTab;?>" 
						class="accordion-collapse collapse <?=$keyTab == 0 ? "show" : "" ?>" 
						aria-labelledby="heading<?=$key?>" 
						data-bs-parent="#accordionExampled"
					>
						<?if($arParams["DISPLAY_PREVIEW_TEXT"]!="N" && $arItem["PREVIEW_TEXT"]):?>
							<p class="desc"><?=$arItem["PREVIEW_TEXT"];?></p>
						<?endif;?>

						<div class="item_info_Price_deadline">
							<?if($arItem["ATTR_PRICE_VALUE"]):?>
								<div class="block_price">
									<p class="price_title"><?=$arItem["ATTR_PRICE_NAME"]?></p>
									<p class="price"><?=$arItem["ATTR_PRICE_VALUE"]?></p>
								</div>
							<?endif;?>

							<?if($arItem["ATTR_DEADLINE_VALUE"]):?>
								<div class="block_deadline">
									<p class="deadline_title"><?=$arItem["ATTR_DEADLINE_NAME"]?></p>
									<p class="deadline"><?=$arItem["ATTR_DEADLINE_VALUE"]?></p>
								</div>
							<?endif;?>
						</div>

						<div class="item_block_btns">
							<?if($arItem["ATTR_BTN_CALC_PRICE_VALUE"]):?>
								<a href="<?=$arItem["ATTR_BTN_CALC_PRICE_VALUE"]?>" target="_blank" class="btn-default"><?=$arItem["ATTR_BTN_CALC_PRICE_NAME"]?></a>
							<?endif;?>
							<a href="#" target="_blank" class="detail_more">Подробнее</a>
						</div>
					</div>
					
				</div>
			<?endif;?>
		<?endforeach;?>
	</div>
</div>
