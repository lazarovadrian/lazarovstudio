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
?>

<?foreach($arResult["ITEMS"] as $arItem):?>
	<?
		$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
		$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
	?>
	<div class="col-lg-3 col-md-6 col-sm-6 col-12 d-flex" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
    	<div class="service service__style--1 bg-color-blackest radius mt--25 text-center rbt-border-new">
        <div class="icon">
            <?if($arParams["DISPLAY_PICTURE"]!="N" && is_array($arItem["PREVIEW_PICTURE"])):?>
                <?if(!$arParams["HIDE_LINK_WHEN_NO_DETAIL"] || ($arItem["DETAIL_TEXT"] && $arResult["USER_HAVE_ACCESS"])):?>
                    <img
                        class="preview_picture"
                        src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>"
                        width="<?=$arItem["PREVIEW_PICTURE"]["WIDTH"]?>"
                        height="<?=$arItem["PREVIEW_PICTURE"]["HEIGHT"]?>"
                        alt="<?=$arItem["PREVIEW_PICTURE"]["ALT"]?>"
                        title="<?=$arItem["PREVIEW_PICTURE"]["TITLE"]?>"
                    />
                <?endif;?>
		    <?endif?>
        </div>

        <div class="content">
            
            <?if($arParams["DISPLAY_NAME"]!="N" && $arItem["NAME"]):?>
                <h4 class="title w-600"><?echo $arItem["NAME"]?></h4>
            <?endif;?>
            
            <p class="description b1">Срок реализации: <?=$arItem["DISPLAY_PROPERTIES"]["ATTR_DEADLINES"]["DISPLAY_VALUE"]?> дней</p>
            
            <div class="pricing">
                <div class="price-wrapper">
                    от <span class="price"> <?=$arItem["DISPLAY_PROPERTIES"]["ATTR_PRICE"]["DISPLAY_VALUE"]?> </span><span class="currency">₽</span>
                </div>
            </div>

            <?if($arParams["DISPLAY_PREVIEW_TEXT"]!="N" && $arItem["PREVIEW_TEXT"]):?>
                <p class="description b1 mb--0"><?echo $arItem["PREVIEW_TEXT"];?></p>
            <?endif;?>
        </div>

	</div>
</div>
<?endforeach;?>


