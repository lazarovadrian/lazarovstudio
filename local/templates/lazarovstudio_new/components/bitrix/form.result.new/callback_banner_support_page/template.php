<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if ($arResult["isFormErrors"] == "Y"):?><?=$arResult["FORM_ERRORS_TEXT"];?><?endif;?>
	<div class="form_popup js-modal <?=$arResult["FORM_NOTE"] ? "is-show": ""?>">
		<svg class="form_popup__cross js-modal-close" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M23.954 21.03l-9.184-9.095 9.092-9.174-2.832-2.807-9.09 9.179-9.176-9.088-2.81 2.81 9.186 9.105-9.095 9.184 2.81 2.81 9.112-9.192 9.18 9.1z"></path></svg>
		<div class="success">
			<?=$arResult["FORM_NOTE"]?>
		</div>
		<?if($arResult["isFormNote"] != "Y"){}?>
	</div>
<section class="callback_banner__form container">
	<?=$arResult["FORM_HEADER"]?>

	<div class="callback_banner__container">
		<div class="callback_banner__img">
			<img src="<?=$arResult["FORM_IMAGE"]["URL"]?>"/>
		</div>
		<div class="callback_banner__inputs">
			<div class="info">
				<p class="title"><?=$arResult["FORM_TITLE"]?></p>
				<p class="desc"><?=$arResult["FORM_DESCRIPTION"]?></p>
			</div>
			<?foreach ($arResult["QUESTIONS"] as $FIELD_SID => $arQuestion){
					if ($arQuestion['STRUCTURE'][0]['FIELD_TYPE'] == 'hidden'){
						echo $arQuestion["HTML_CODE"];
					}else{?>
					<?if (is_array($arResult["FORM_ERRORS"]) && array_key_exists($FIELD_SID, $arResult['FORM_ERRORS'])):?>
					<span class="error-fld" title="<?=htmlspecialcharsbx($arResult["FORM_ERRORS"][$FIELD_SID])?>"></span>
					<?endif;?>
					<?=$arQuestion["CAPTION"]?><?if ($arQuestion["REQUIRED"] == "Y"):?><?=$arResult["REQUIRED_SIGN"];?><?endif;?>
					<?=$arQuestion["IS_INPUT_CAPTION_IMAGE"] == "Y" ? "<br />".$arQuestion["IMAGE"]["HTML_CODE"] : ""?>	
					<?=$arQuestion["HTML_CODE"]?>
				<?}
			}?>
			<?if($arResult["isUseCaptcha"] == "Y"){?>
				<?=GetMessage("FORM_CAPTCHA_TABLE_TITLE")?>
				<input type="hidden" name="captcha_sid" value="<?=htmlspecialcharsbx($arResult["CAPTCHACode"]);?>" /><img src="/bitrix/tools/captcha.php?captcha_sid=<?=htmlspecialcharsbx($arResult["CAPTCHACode"]);?>" width="180" height="40" />
				<?=GetMessage("FORM_CAPTCHA_FIELD_TITLE")?><?=$arResult["REQUIRED_SIGN"];?>
				<input type="text" name="captcha_word" size="30" maxlength="50" value="" class="inputtext" />
			<?}?>
			<button class="btn-default" type="submit" name="web_form_submit" value="Отправить">Отправить</button>
			<?=$arResult["FORM_FOOTER"]?>
			<p class="politics">нажимая кнопку “Отправить” Вы соглашаетесь с <a href="/polzovatelskoe-soglashenie/" target="_blank">политикой обработки персональных данных.</a></p>
		</div>
	</div>
	<div class="block_desc">
		<p class="title">Технический аудит</p>
		<p class="sub_title">FREE</p>
		<p class="desc">Экспресс-аудит. Проверим Вашу платформу стандартными средствами Битрикс.</p>
	</div>
	</div>
	
</section>

<script>
	$(".js-modal-close").on("click",function(){
		$(".js-modal").removeClass("is-show");
	});
</script>
