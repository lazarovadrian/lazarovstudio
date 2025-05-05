<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true){
	die();
} ?>
<div class="portfolio_list">

	<? foreach($arResult["ITEMS"] as $arItem): ?>
		<?
         $this -> AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock ::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_EDIT"));
         $this -> AddDeleteAction(
            $arItem['ID'], $arItem['DELETE_LINK'], CIBlock ::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_DELETE"), ["CONFIRM" => GetMessage('NEWS_DELETE_CONFIRM')],
         );
		?>
       <div class="portfolio_item" id="<?=$this -> GetEditAreaId($arItem['ID']);?>">

          <a href="<?=$arItem["DETAIL_PAGE_URL"]?>">
             <img class="preview_picture" 
               src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>"
               width="<?php=$arItem["PREVIEW_PICTURE"]["WIDTH"]?>"
               height="<?php=$arItem["PREVIEW_PICTURE"]["HEIGHT"]?>"
               alt="<?php=$arItem["NAME"]?>"
               title="<?php=$arItem["NAME"]?>"
             />
          </a>

         <? if($arParams["DISPLAY_NAME"] != "N" && $arItem["NAME"]): ?>
          <div class="title"><a href="<?=$arItem["DETAIL_PAGE_URL"]?>"><? echo $arItem["NAME"] ?></a></div>
         <? endif; ?>

       </div>
	<? endforeach; ?>

	<? if($arParams["DISPLAY_BOTTOM_PAGER"]): ?>
		<?=$arResult["NAV_STRING"]?>
	<? endif; ?>
</div>
