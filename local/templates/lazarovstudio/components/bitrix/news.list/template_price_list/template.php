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
    
<div class="col-lg-4 col-md-6 col-12" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
    <div class="rn-pricing <?=($arItem["PROPERTIES"]["ATTR_CHECKED_DEFAULT"]["VALUE"] === "Y") ? "active" : ""?> ">

        <div class="pricing-table-inner">
                <div class="pricing-header">
                    <?if($arParams["DISPLAY_NAME"]!="N" && $arItem["NAME"]):?>
                        <h4 class="title"><?echo $arItem["NAME"]?></h4>
                    <?endif;?>

                    <div class="pricing">
                        <div class="price-wrapper"><span class="currency">₽</span>
                            <span class="price"><?=$arItem["PROPERTIES"]["ATTR_PRICE"]["VALUE"]?></span>
                        </div>
                        <span class="subtitle"> руб / мес</span>
                    </div>
                </div>

                <div class="pricing-body">
                    <ul class="plan-offer-list">
                        <?=htmlspecialcharsBack($arItem["PROPERTIES"]["ATTR_DESC_SERVICES_DEEP"]["VALUE"]["TEXT"])?>
                    </ul>
                </div>
                <div class="pricing-footer"><a class="btn-default <?=($arItem["PROPERTIES"]["ATTR_CHECKED_DEFAULT"]["VALUE"] === "Y") ? "" : "btn-border" ?>" href="#formPriceSupport">Оформить</a></div>
        </div>

	</div>
</div>
<?endforeach;?>