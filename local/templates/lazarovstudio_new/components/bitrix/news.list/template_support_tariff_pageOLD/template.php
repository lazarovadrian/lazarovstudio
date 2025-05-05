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
       <div class="rwt-pricingtable-area rn-section-gap" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
            <div class="container">
                
                <div class="row">
                    <div class="col-lg-12">
                        <div class="section-title text-center" >
                            <?if($arParams["DISPLAY_NAME"]!="N" && $arItem["NAME"]):?>
                                <h1 class="text-center"><span class="theme-gradient"><?echo $arItem["NAME"]?></span></h1>
                            <?endif;?>
                            <h2 class="subtitle w-600 mb--20"><?=$arItem["DISPLAY_PROPERTIES"]["ATTR_SUBTITLE"]["DISPLAY_VALUE"]?></h2>
                        </div>
                    </div>
                </div>

                <div class="row mt--30">
                    <div class="col-md-12">
                        <div class="advance-pricing">
                            <div class="inner">
                                <div class="row row--0">
                                    <div class="col-lg-6">

                                        <div class="pricing-left">
                                            <h3 class="main-title"><?echo $arItem["NAME"]?></h3>
                                            <?echo $arItem["DETAIL_TEXT"];?>

                                            <?if($arParams["DISPLAY_PREVIEW_TEXT"]!="N" && $arItem["PREVIEW_TEXT"]):?>
                                                <div class="single-list">
                                                    <ul class="plan-offer-list">
                                                        <?echo $arItem["PREVIEW_TEXT"];?>
                                                    </ul>
                                                </div>
                                            <?endif;?>

                                            <div class="price-wrapper">
                                                <span class="price-amount">₽ <?=$arItem["DISPLAY_PROPERTIES"]["ATTR_PRICE_SUPPORT"]["DISPLAY_VALUE"]?> <sup>/месяц</sup></span>
                                            </div>
                                            <div class="pricing-btn-group">
                                                <button class="btn-default">Оформить</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="pricing-right">
                                            <div class="pricing-offer">
                                                <div class="single-list">
                                                    <h4 class="price-title">Техническое обслуживание:</h4>
                                                    <ul class="plan-offer-list">
                                                        <?=htmlspecialcharsBack($arItem["PROPERTIES"]["ATTR_DESC_TECH"]["VALUE"]["TEXT"])?>
                                                    </ul>
                                                </div>
                                                <div class="single-list mt--40">
                                                    <h4 class="price-title">Программирование и дизайн сайта:</h4>
                                                    <ul class="plan-offer-list">
                                                        <?=htmlspecialcharsBack($arItem["PROPERTIES"]["ATTR_DESC_PROG_DIS"]["VALUE"]["TEXT"])?>
                                                    </ul>
                                                </div>
                                                <div class="single-list mt--40">
                                                    <h4 class="price-title">Уровень сервиса и объем работ:</h4>
                                                    <ul class="plan-offer-list">
                                                        <?=htmlspecialcharsBack($arItem["PROPERTIES"]["ATTR_DESC_SERVICES_DEEP"]["VALUE"]["TEXT"])?>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<?endforeach;?>