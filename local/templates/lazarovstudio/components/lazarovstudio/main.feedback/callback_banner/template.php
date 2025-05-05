<?
if(!defined("B_PROLOG_INCLUDED")||B_PROLOG_INCLUDED!==true)die();
/**
 * Bitrix vars
 *
 * @var array $arParams
 * @var array $arResult
 * @var CBitrixComponentTemplate $this
 * @global CMain $APPLICATION
 * @global CUser $USER
 */

$formId = 'feedback_form_' . $this->randString();
?>
<?echo '<textarea>' , var_dump($arSend) , '</textarea>';?>
	<?if(!empty($arResult["ERROR_MESSAGE"])){
		foreach($arResult["ERROR_MESSAGE"] as $v)
			ShowError($v);
	}
	if($arResult["OK_MESSAGE"] <> ''){?>
		<div class="mf-ok-text">
			<?=$arResult["OK_MESSAGE"]?>
		</div>
	<?}?>

<form class="mt--40" id="<?=$formId?>" action="<?=POST_FORM_ACTION_URI?>" method="POST">
	<div class="row">
	<?=bitrix_sessid_post()?>
		<div class="col-lg-6 col-md-12 col-12">

			<div class="rnform-group">
				<input type="text" name="user_name" value="<?=$arResult["AUTHOR_NAME"]?>" placeholder="<?=GetMessage("MFT_NAME")?>" require>
			</div>

			<div class="rnform-group">
				<input class="phone" type="tel" name="user_phone" value="<?=$arResult["AUTHOR_PHONE"]?>" placeholder="+7 (999) 999-99-99" require>
			</div>

		</div>

		<?if($arParams["USE_CAPTCHA"] == "Y"):?>
			<div class="col-lg-12">
				<div class="mf-text"><?=GetMessage("MFT_CAPTCHA")?></div>
				<input type="hidden" name="captcha_sid" value="<?=$arResult["capCode"]?>">
				<img src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult["capCode"]?>" width="180" height="40" alt="CAPTCHA">
				<div class="mf-text"><?=GetMessage("MFT_CAPTCHA_CODE")?><span class="mf-req">*</span></div>
				<input class="blog-btn" type="text" name="captcha_word" size="30" maxlength="50" value="">
			</div>
		<?endif;?>

		<input type="hidden" name="PARAMS_HASH" value="<?=$arResult["PARAMS_HASH"]?>">
		<input class="btn-default" type="submit" name="submit" value="<?=GetMessage("MFT_SUBMIT")?>">
	</div>
</form>
<?php if ($arResult['FACEBOOK_CONVERSION_ENABLED']): ?>
<script>
	var form = document.getElementById('<?=$formId?>');
	BX.Event.bind(form, 'submit', function() {
		if (form.elements && form.elements['user_email'] &&
			form.elements['user_phone'] &&
			form.elements['user_phone'].value && 
			form.elements['user_site']){BX.ajax.runAction('sale.facebookconversion.contact', {data: {contactBy: form.elements['user_email'].value}});}});
	var closeMess = document.querySelector(".mf-ok-text");
	closeMess.addEventListener( "click" , () => closeMess.style.display = "none");
</script>
<?php endif; ?>