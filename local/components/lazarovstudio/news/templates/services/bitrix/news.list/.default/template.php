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

    $arItemElems = Array();//массив для элементов
    $arFilter = Array('IBLOCK_ID'=>$arParams['IBLOCK_ID'], 'GLOBAL_ACTIVE'=>'Y', 'SECTION_ID'=>$arParams["SECTION_ID"]);//фильтруем по нужному разделу
    
    /*Формируем массив элементов из выбраного раздела*/
    $arSelect = Array("ID", "ACTIVE", "IBLOCK_ID", "NAME", "PREVIEW_PICTURE", "PREVIEW_TEXT", "DETAIL_TEXT", "DETAIL_PAGE_URL", "PROPERTY_*");
    $arFilterSubSection = Array($arFilter);//фильтруем по подразделу
    $res = CIBlockElement::GetList(Array("SORT"=>"ASC", 'GLOBAL_ACTIVE'=>'Y'), $arFilterSubSection, false, false, $arSelect);
    
    while($item = $res->GetNextElement()){
        $arElemFields = $item->GetFields();
        $arSelFlds["ID"] = $arElemFields["ID"];
        $arSelFlds["ACTIVE"] = $arElemFields["ACTIVE"];
        $arSelFlds["NAME"] = $arElemFields["NAME"];
        $arSelFlds["PICTURE"] = CFile::GetPath($arElemFields["PREVIEW_PICTURE"]);
        $arSelFlds["PREVIEW_TEXT"] = $arElemFields["PREVIEW_TEXT"];
        $arSelFlds["DETAIL_PAGE_URL"] = $arElemFields["DETAIL_PAGE_URL"];
        $arProps = $item->GetProperties();
        //добавляем все что выбрали выше
        $arItemElems["ITEMS"][] = $arSelFlds;
    }
?>

<ul class="main-services-list">

<?foreach($arItemElems["ITEMS"] as $arItem):?>
	<?
	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
	?>
	<li class="main-services-list-item" id="<?=$this->GetEditAreaId($arItem['ID']);?>">

		<div class="img-circle-wrap">
			<a href="<?=$arItem["DETAIL_PAGE_URL"]?>">
				<img
					class="attachment-full size-full wp-post-image"					
					src="<?=$arItem["PICTURE"]?>"
				/>
			</a>
		</div>

		<div class="main-services-list-item-content">
			<span class="main-services-list-item-title"><a href="<?=$arItem["DETAIL_PAGE_URL"]?>"><?=$arItem["NAME"]?></a></span>
			<p class="main-services-list-item-description"><?=$arItem["PREVIEW_TEXT"];?></p>
		</div>

		<a href="<?=$arItem["DETAIL_PAGE_URL"]?>" class="btn">Подробнее</a>
	</li>
<?endforeach;?>

</ul>
