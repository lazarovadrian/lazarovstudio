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
<div class="services_list container">
<?foreach($arResult["ITEMS"] as $arItem):?>
	<?
		$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
		$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
	?>
	<div class="services_item" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
		<?if($arParams["DISPLAY_PICTURE"]!="N" && is_array($arItem["PREVIEW_PICTURE"])):?>
			<div class="img">
				<a href="<?=$arItem["PROPERTIES"]["ATTR_LINK_BTN"]["VALUE"]?>">
					<img
						class="picture"
						src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>"
						width="<?=$arItem["PREVIEW_PICTURE"]["WIDTH"]?>"
						height="<?=$arItem["PREVIEW_PICTURE"]["HEIGHT"]?>"
						alt="<?=$arItem["PREVIEW_PICTURE"]["ALT"]?>"
						title="<?=$arItem["PREVIEW_PICTURE"]["TITLE"]?>"
					/>
				</a>
			</div>
		<?endif?>
		
		<div class="info_item">
			<p class="title"><a href="<?=$arItem["PROPERTIES"]["ATTR_LINK_BTN"]["VALUE"]?>"><?=$arItem["NAME"]?></a></p>
			<?if($arParams["DISPLAY_PREVIEW_TEXT"]!="N" && $arItem["PREVIEW_TEXT"]):?>
				<p class="desc">
					<?=$arItem["PREVIEW_TEXT"];?>
				</p>
			<?endif;?>

			<?if($arItem["PROPERTIES"]["ATTR_LIST_SERVICES"]["VALUE"]):?>
				<div class="list_services_item">
					<p class="title"><?=$arItem["PROPERTIES"]["ATTR_LIST_SERVICES"]["NAME"]?></p>
					<ul>
						<?foreach($arItem["PROPERTIES"]["ATTR_LIST_SERVICES"]["VALUE"] as $servicesItem):?>
							<li><?=$servicesItem?></li>
						<?endforeach;?>
					</ul>
				</div>
			<?endif;?>

			<?//if($arParams["DISPLAY_NAME"]!="N" && $arItem["NAME"]):?>
			<!--	<a class="btn-default" href="--><?php //=$arItem["PROPERTIES"]["ATTR_LINK_BTN"]["VALUE"]?><!--">--><?php //=$arItem["PROPERTIES"]["ATTR_NAME_BTN"]["VALUE"]?><!--</a>-->
			<?//endif;?>
		</div>

		<?if($arItem["PROPERTIES"]["ATTR_PRICE_DEVELOPER"]["VALUE"]):?>
			<div class="block_prices">
				<div class="header">
					<p class="title">Тарифы</p>
				</div>
				<div class="block_prices__items">
					<? foreach ($arItem["PROPERTIES"]["ATTR_PRICE_DEVELOPER"]["VALUE"] as $priceDeveloper): ?>
						<? $elemName = CIBlockElement::GetByID($priceDeveloper)->GetNextElement()->GetFields(); ?>
						<? $props = CIBlockElement::GetByID($priceDeveloper)->GetNextElement()->GetProperties(); ?>
						<div class="content_price">
							<? if ($elemName["NAME"]): ?>
								<h4 class="title"><?=$elemName["NAME"];?></h4>
							<? endif; ?>
							<p class="description b1">Реализация: <?=$props["ATTR_DEADLINES"]["VALUE"]?> дней</p>
							<p class="pricing">
							<span class="price-wrapper b1"> от
								<span class="price"> <?=$props["ATTR_PRICE"]["VALUE"]?></span>
								<span class="currency">₽</span>
							</span>
							</p>
							<? if ($elemName["PREVIEW_TEXT"]): ?>
								<p class="description b1 mb--0"><? echo $elemName["PREVIEW_TEXT"]; ?></p>
							<? endif; ?>
						</div>
					<? endforeach; ?>
				</div>
			</div>
		<?endif;?>

		<?if($arItem["PROPERTIES"]["ATTR_PRICE_SUPPORT"]["VALUE"]):?>
			<div class="block_prices">
				<div class="header">
					<p class="title">Тарифы</p>
				</div>
				<div class="block_prices__items support">
					<? foreach ($arItem["PROPERTIES"]["ATTR_PRICE_SUPPORT"]["VALUE"] as $priceDeveloper): ?>
						<? $elemName = CIBlockElement::GetByID($priceDeveloper)->GetNextElement()->GetFields(); ?>
						<? $props = CIBlockElement::GetByID($priceDeveloper)->GetNextElement()->GetProperties(); ?>
						<div class="content_price">
							<? if ($elemName["NAME"]): ?>
								<h4 class="title"><?=$elemName["NAME"];?></h4>
							<? endif; ?>
							<p class="pricing">
							<span class="price-wrapper b1">
								<span class="price">Цена: <?=$props["ATTR_PRICE"]["VALUE"]?></span>
								<span class="currency">₽</span>
							</span>
							</p>
							<? if ($elemName["PREVIEW_TEXT"]): ?>
								<p class="description b1 mb--0"><? echo $elemName["PREVIEW_TEXT"]; ?></p>
							<? endif; ?>

							<div class="pricing-btn-group">
								<a class="btn-default" href="<?=$elemName["DETAIL_PAGE_URL"]?>">Подробнее</a>
							</div>
						</div>
					<? endforeach; ?>
				</div>
			</div>
		<?endif;?>
	</div>
<?endforeach;?>
</div>
