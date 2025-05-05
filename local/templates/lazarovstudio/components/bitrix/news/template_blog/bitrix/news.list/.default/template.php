<?
use Bitrix\Main\Diag\Debug;

if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<div class="mt120 mb120 blog_list container">

<?foreach($arResult["ITEMS"] as $arItem):?>
	<?
        $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_EDIT"));
        $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('NEWS_DELETE_CONFIRM')));
	?>
	<div class="blog_item" id="<?=$this->GetEditAreaId($arItem['ID']);?>">

        <?if(!$arParams["HIDE_LINK_WHEN_NO_DETAIL"] || ($arItem["DETAIL_TEXT"] && $arResult["USER_HAVE_ACCESS"])):?>
            <a href="<?=$arItem["DETAIL_PAGE_URL"]?>">
                <div class="blog_title"><?echo $arItem["NAME"]?></div>
            </a>
        <?endif;?>

        <div class="blog_item__list_data_see">
          <? if($arParams["DISPLAY_DATE"] != "N" && $arItem["DISPLAY_ACTIVE_FROM"]): ?>
            <div class="blog_date"><? echo $arItem["DISPLAY_ACTIVE_FROM"] ?></div>
          <?endif ?>
          <div class="blog_count_see">Просмотров: <?=$arItem['SHOW_COUNTER']?> </div>
        </div>
       
		<?if($arParams["DISPLAY_PREVIEW_TEXT"]!="N" && $arItem["PREVIEW_TEXT"]):?>
			<div class="blog_preview"><?echo $arItem["PREVIEW_TEXT"];?></div>
		<?endif;?>

	</div>
<?endforeach;?>
<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
	<?=$arResult["NAV_STRING"]?>
<?endif;?>
</div>

<script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Blog",
        "name": "Блог LazarovStudio.ru",
        "url": "https://lazarovStudio.ru/blog/",
        "description": "Данный блог-заметка с примерами кода для 1С-Битрикс и Android разработки",
        "publisher": {
            "@type": "Organization",
            "name": "LazarovStudio",
            "logo": {
                "@type": "ImageObject",
                "url": "https://lazarovStudio.ru/blog/local/templates/lazarovstudio/images/logo.jpg"
            }
        }
    }
</script>

