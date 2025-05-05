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
    $arFilter = Array('IBLOCK_ID'=>$arParams['IBLOCK_ID'], 'GLOBAL_ACTIVE'=>'Y', 'SECTION_ID'=>$arParams["SECTION_ID"]);
    $arSelect = Array("ID", "ACTIVE", "NAME", "PREVIEW_PICTURE", "PREVIEW_TEXT", "DETAIL_TEXT", "DETAIL_PAGE_URL", "PROPERTY_*");
    $res = CIBlockElement::GetList(Array("SORT"=>"ASC", 'GLOBAL_ACTIVE'=>'Y'), $arFilter, false, false, $arSelect);
    
    while($item = $res->GetNextElement()){
        $arElemFields = $item->GetFields();
        $arSelFlds["ID"] = $arElemFields["ID"];
        $arSelFlds["ACTIVE"] = $arElemFields["ACTIVE"];
        $arSelFlds["NAME"] = $arElemFields["NAME"];
        $arSelFlds["PICTURE"] = CFile::GetPath($arElemFields["PREVIEW_PICTURE"]);
        $arSelFlds["PREVIEW_TEXT"] = $arElemFields["PREVIEW_TEXT"];
        $arSelFlds["DETAIL_PAGE_URL"] = $arElemFields["DETAIL_PAGE_URL"];
        // $arProps = $item->GetProperties();
        $arItemElems["ITEM"][] = $arSelFlds;
    }
?>
<div class="benefit_list">

<?foreach($arItemElems["ITEM"] as $arItem):?>
	<?
	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
	?>
	<div class="benefit_item" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
		<img src="<?=$arItem["PICTURE"];?>" alt="">

		<p class="title"><?=$arItem["NAME"]?></p>

		<?if($arParams["DISPLAY_PREVIEW_TEXT"]!="N" && $arItem["PREVIEW_TEXT"]):?>
			<p class="desc"><?=$arItem["PREVIEW_TEXT"];?></p>
		<?endif;?>
	</div>
<?endforeach;?>
</div>
