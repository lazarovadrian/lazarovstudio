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

$url = $APPLICATION->GetCurPage();
?>
<?foreach($arResult["ITEMS"] as $arItem):?>
	<?
	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
	?>
	<?if($arItem["PROPERTIES"]["ATTR_SHOW_ON_PAGE"]["VALUE"] == "$url"):?>

	<div 
		class="slider-area slider-style-1 variation-default height-850 bg_image"
		data-black-overlay="7"
		id="<?=$this->GetEditAreaId($arItem['ID']);?>"
		style="background-image: url(<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>);"
	>
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<div class="inner pt--80 text-center" >
						<div>
							<h1 class="title display-one rn-sub-badge-h1"><?=$arItem["NAME"]?></h1>
						</div>
						<?if($arParams["DISPLAY_PREVIEW_TEXT"]!="N" && $arItem["PREVIEW_TEXT"]):?>
							<div class="banner_desc">
								<p><?=$arItem["PREVIEW_TEXT"];?></p>
							</div>
						<?endif;?>
						<?if($arItem["PROPERTIES"]["ATTR_BANNER_LINK"]["VALUE"]):?>
							<a class="btn-default btn-small" href="tel:<?=$arItem["PROPERTIES"]["ATTR_BANNER_LINK"]["VALUE"];?>"><?=$arItem["PROPERTIES"]["ATTR_BANNER_LINK"]["DESCRIPTION"];?></a>
						<?endif;?>
					</div>
				</div>
			</div>
		</div>
	</div>
<?endif;?>

<?endforeach;?>