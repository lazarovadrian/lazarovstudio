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
<!-- Техническое обслуживание: ATTR_DESC_TECH -->
<!-- Текст под заголовком  ATTR_SUBTITLE -->
<!-- Программирование и дизайн сайта  ATTR_DESC_PROG_DIS -->
<!-- Уровень сервиса и объем работ  ATTR_DESC_SERVICES_DEEP -->
<!-- Уровень сервиса и объем работ 2  ATTR_DESC_SERVICES_DEEP2 -->
<!-- Табы  ATTR_COMPONENT_TABS-->
<!-- rpice ATTR_PRICE_SUPPORT -->

<div class="rn-company-mission-are rn-section-gap">
	<div class="tariff-detail container">

		<?if($arParams["DISPLAY_PICTURE"]!="N" && is_array($arResult["DETAIL_PICTURE"])):?>
			<img
				class="detail_picture"
				src="<?=$arResult["DETAIL_PICTURE"]["SRC"]?>"
				width="<?=$arResult["DETAIL_PICTURE"]["WIDTH"]?>"
				height="<?=$arResult["DETAIL_PICTURE"]["HEIGHT"]?>"
				alt="<?=$arResult["DETAIL_PICTURE"]["ALT"]?>"
				title="<?=$arResult["DETAIL_PICTURE"]["TITLE"]?>"
				/>
		<?endif?>

		<?if($arParams["DISPLAY_NAME"]!="N" && $arResult["NAME"]):?>
			<h3><?=$arResult["NAME"]?></h3>
			<p class="subTitle">
				<?=$arResult['DISPLAY_PROPERTIES']['ATTR_SUBTITLE']['DISPLAY_VALUE'];?>
			</p>
		<?endif;?>

<p class="title">Техническое обслуживание:</p>
		<?if($arResult['DISPLAY_PROPERTIES']['ATTR_DESC_TECH']['DISPLAY_VALUE']):?>
			<?=$arResult['DISPLAY_PROPERTIES']['ATTR_DESC_TECH']['DISPLAY_VALUE'];?>
		<?endif;?>
<hr>
<p class="title">Программирование и дизайн сайта</p>
		<?if($arResult['DISPLAY_PROPERTIES']['ATTR_DESC_PROG_DIS']['DISPLAY_VALUE']):?>
			<?=$arResult['DISPLAY_PROPERTIES']['ATTR_DESC_PROG_DIS']['DISPLAY_VALUE'];?>
		<?endif;?>
<hr>
<p class="title">Уровень сервиса и объем работ</p>
		<?if($arResult['DISPLAY_PROPERTIES']['ATTR_DESC_SERVICES_DEEP']['DISPLAY_VALUE']):?>
			<?=$arResult['DISPLAY_PROPERTIES']['ATTR_DESC_SERVICES_DEEP']['DISPLAY_VALUE'];?>
		<?endif;?>
<hr>
		<?if($arResult['DISPLAY_PROPERTIES']['ATTR_PRICE_SUPPORT']['DISPLAY_VALUE']):?>
			<p>₽ <?=$arResult['DISPLAY_PROPERTIES']['ATTR_PRICE_SUPPORT']['DISPLAY_VALUE'];?> руб / мес</p>
		<?endif;?>

		<?if($arResult["PREVIEW_TEXT"]):?>
			<p><?=$arResult["PREVIEW_TEXT"];?></p>
		<?endif;?>


		<!-- вывести форму откуда отправлена форма и добавить в форму заголовком тарифа -->
		<!-- вывести компонент пример работ -->
		<!--  -->

	</div>
</div>