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
<section class="main_banner container style3d-1 variation3d-1">
<?foreach($arResult["ITEMS"] as $arItem):?>
	<?
	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
	?>
	<div class="banner_item" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
		<div class="info">
			<h1><?=$arItem["NAME"]?></h1>
			<div class="tags-title">
				<h6 class="tag-title">разработка</h6>
				<h6 class="tag-title">поддержка</h6>
				<h6 class="tag-title">продвижение</h6>						
			</div>
			<?if($arParams["DISPLAY_PREVIEW_TEXT"]!="N" && $arItem["PREVIEW_TEXT"]):?>
				<p class="desc"><?=$arItem["PREVIEW_TEXT"];?></p>
			<?endif;?>
			<?if($arItem["PROPERTIES"]["ATTR_SHOW_FORM"]["VALUE"] === "Y"):?>
				<div class="form">
						<?$APPLICATION->IncludeComponent("bitrix:form.result.new", "order_call_phone", Array(
							"AJAX_MODE" => "Y", // [Y|N] При установленной опции для компонента будет включен режим AJAX.
							"AJAX_OPTION_SHADOW" => "N", // [Y|N] Затемнять область
							"AJAX_OPTION_JUMP" => "N", // [Y|N] Если пользователь совершит AJAX-переход, то при установленой опции по окончании загрузки произойдет прокрутка к началу компонента.
							"AJAX_OPTION_STYLE" => "Y", // [Y|N] Если параметр принимает значение "Y", то при совершении AJAX-переходов будет происходить подгрузка и обработка списка стилей, вызванных компонентом.
							"AJAX_OPTION_HISTORY" => "N", //[Y|N] Когда пользователь выполняет AJAX-переходы, то при включенной опции можно использовать кнопки браузера Назад и Вперед.						
							"CACHE_TIME" => "",	// Время кеширования (сек.)
							"CACHE_TYPE" => "N",	// Тип кеширования
							"CHAIN_ITEM_LINK" => "",	// Ссылка на дополнительном пункте в навигационной цепочке
							"CHAIN_ITEM_TEXT" => "",	// Название дополнительного пункта в навигационной цепочке
							"COMPOSITE_FRAME_MODE" => "A",	// Голосование шаблона компонента по умолчанию
							"COMPOSITE_FRAME_TYPE" => "AUTO",	// Содержимое компонента
							"EDIT_URL" => "",	// Страница редактирования результата
							"IGNORE_CUSTOM_TEMPLATE" => "N",	// Игнорировать свой шаблон
							"LIST_URL" => "",	// Страница со списком результатов
							"SEF_MODE" => "N",	// Включить поддержку ЧПУ
							"SUCCESS_URL" => "",	// Страница с сообщением об успешной отправке
							"USE_EXTENDED_ERRORS" => "N",	// Использовать расширенный вывод сообщений об ошибках
							"VARIABLE_ALIASES" => array(
								"RESULT_ID" => "RESULT_ID",
								"WEB_FORM_ID" => "WEB_FORM_ID",
							),
							"WEB_FORM_ID" => "1",	// ID веб-формы
						),
						false
					);?>
				</div>
			<?else:?>
				<a class="btn-default btn-icon" href="<?=$arItem["PROPERTIES"]["ATTR_BTN_LINK"]["VALUE"]?>"><?=$arItem["PROPERTIES"]["ATTR_BTN_NAME"]["VALUE"]?></a>
			<?endif;?>
		</div>
		<div class="img">
			<img
				class="pic"
				src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>"
				width="<?=$arItem["PREVIEW_PICTURE"]["WIDTH"]?>"
				height="<?=$arItem["PREVIEW_PICTURE"]["HEIGHT"]?>"
				alt="<?=$arItem["PREVIEW_PICTURE"]["ALT"]?>"
				title="<?=$arItem["PREVIEW_PICTURE"]["TITLE"]?>"
			/>
		</div>
	</div>
<?endforeach;?>

</section>