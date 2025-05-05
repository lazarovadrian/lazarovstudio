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
        $arProps = $item->GetProperties();
        $arSelFlds["LIST_SERVICES"] = $arProps["ATTR_LIST_SERVICES"]["VALUE"];
        $arSelFlds["LIST_SERVICES_NAME"] = $arProps["ATTR_LIST_SERVICES"]["NAME"];
        $arSelFlds["NAME_BTN"] = $arProps["ATTR_NAME_BTN"]["VALUE"];
        $arSelFlds["LINK_BTN"] = $arProps["ATTR_LINK_BTN"]["VALUE"];
        $arItemElems["ITEMS"][] = $arSelFlds;
    }
?>
<div class="services_list container">
<?foreach($arItemElems["ITEMS"] as $arItem):?>
	<?if($arItem["ACTIVE"] == "Y"):?>
	<?
		$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
		$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
	?>
		<div class="services_item" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
			<div class="img">
				<a href="<?=$arItem["PROPERTIES"]["ATTR_LINK_BTN"]["VALUE"]?>">
					<img
						class="picture"
						src="<?=$arItem["PICTURE"]?>"
						alt="<?=$arItem["PREVIEW_PICTURE"]["ALT"]?>"
						title="<?=$arItem["PREVIEW_PICTURE"]["TITLE"]?>"
					/>
				</a>
			</div>
			
			<div class="info_item">
				<p class="title"><a href="<?=$arItem["LINK_BTN"]?>"><?=$arItem["NAME"]?></a></p>
				<?if($arParams["DISPLAY_PREVIEW_TEXT"]!="N" && $arItem["PREVIEW_TEXT"]):?>
					<p class="desc">
						<?=$arItem["PREVIEW_TEXT"];?>
					</p>
				<?endif;?>

				<?if($arItem["LIST_SERVICES"]):?>
					<div class="list_services_item">
						<p class="title"><?=$arItem["LIST_SERVICES_NAME"]?></p>
						<ul>
							<?foreach($arItem["LIST_SERVICES"] as $servicesItem):?>
								<li><?=$servicesItem?></li>
							<?endforeach;?>
						</ul>
					</div>
				<?endif;?>

				<?if($arItem["LINK_BTN"] && $arItem["NAME_BTN"]):?>
					<a class="btn-default" target="_blank" href="<?=$arItem["LINK_BTN"]?>"><?=$arItem["NAME_BTN"]?></a>
				<?endif;?>
			</div>
		</div>
	<?endif;?>
<?endforeach;?>
</div>