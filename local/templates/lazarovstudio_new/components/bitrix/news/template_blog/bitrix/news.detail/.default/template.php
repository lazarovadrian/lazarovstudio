<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die(); ?>
<div class="blog_detail container mt120 mb120">

	<?if($arParams["DISPLAY_PICTURE"]!="N" && is_array($arResult["DETAIL_PICTURE"])):?>
		<img class="blog_detail_pic" src="<?=$arResult["DETAIL_PICTURE"]["SRC"]?>" width="<?=$arResult["DETAIL_PICTURE"]["WIDTH"]?>" height="<?=$arResult["DETAIL_PICTURE"]["HEIGHT"]?>" alt="<?=$arResult["NAME"]?>"  title="<?=$arResult["NAME"]?>" />
	<?endif?>

	<?if($arParams["DISPLAY_DATE"]!="N" && $arResult["DISPLAY_ACTIVE_FROM"]):?>
		<div class="news-date"><?=$arResult["DISPLAY_ACTIVE_FROM"]?></div>
	<?endif;?>

	<?if($arParams["DISPLAY_NAME"]!="N" && $arResult["NAME"]):?>
		<h3><?=$arResult["NAME"]?></h3>
	<?endif;?>

	<div class="blog_detail_text">

        <?if($arParams["DISPLAY_PREVIEW_TEXT"]!="N" && $arResult["FIELDS"]["PREVIEW_TEXT"]):?>
            <p><?=$arResult["FIELDS"]["PREVIEW_TEXT"];unset($arResult["FIELDS"]["PREVIEW_TEXT"]);?></p>
        <?endif;?>

        <?if($arResult["NAV_RESULT"]):?>
            <?if($arParams["DISPLAY_TOP_PAGER"]):?><?=$arResult["NAV_STRING"]?><br /><?endif;?>
            <?echo $arResult["NAV_TEXT"];?>
            <?if($arParams["DISPLAY_BOTTOM_PAGER"]):?><br /><?=$arResult["NAV_STRING"]?><?endif;?>
        <?elseif($arResult["DETAIL_TEXT"] <> ''):?>
            <?echo $arResult["DETAIL_TEXT"];?>
        <?else:?>
            <?echo $arResult["PREVIEW_TEXT"];?>
        <?endif?>

        <?if($arResult['PROPERTIES']['ATTR_DOP_DESC']["VALUE"]):?>
            <div class="news_detail_content_second">
                <?if($arResult['PROPERTIES']['ATTR_DOP_DESC']["VALUE"]["TYPE"] == 'text'):?>
                    <p><?=$arResult['PROPERTIES']['ATTR_DOP_DESC']["VALUE"]["TEXT"];?></p>
                <?else:?>
                    <?=htmlspecialcharsBack($arResult['PROPERTIES']['ATTR_DOP_DESC']["VALUE"]["TEXT"]);?>
                <?endif;?>
            </div>
        <?endif;?>


	</div>
</div>

<script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "BlogPosting",
        "mainEntityOfPage": {
            "@type": "WebPage",
            "@id": "https://lazarovstudio.ru<?=$arResult["DETAIL_PAGE_URL"]?>"
        },
        "headline": "<?=$arResult["NAME"]?>",
        "description": "<?echo $arResult["PREVIEW_TEXT"];?>",
        "image": "https://lazarovstudio.ru/local/templates/lazarovstudio/images/logo.jpg",
        "author": {
            "@type": "Person",
            "name": "Лазаров Адриан",
            "url": "https://lazarovstudio.ru/"
        },
        "publisher": {
            "@type": "Organization",
            "name": "LazarovStudio",
            "logo": {
                "@type": "ImageObject",
                "url": "https://lazarovstudio.ru/local/templates/lazarovstudio/images/logo.jpg"
            }
        },
        "datePublished": "<?=$arResult["DISPLAY_ACTIVE_FROM"]?>",
        "articleBody": "<?echo $arResult["PREVIEW_TEXT"];?>"
    }
</script>
