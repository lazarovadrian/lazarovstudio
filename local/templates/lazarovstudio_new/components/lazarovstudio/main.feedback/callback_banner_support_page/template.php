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

<?if(!empty($arResult["ERROR_MESSAGE"])):?>
    <div class="alert alert-danger">
        <?foreach($arResult["ERROR_MESSAGE"] as $error):?>
            <div><?=htmlspecialcharsbx($error)?></div>
        <?endforeach;?>
    </div>
<?endif;?>

<?if($arResult["OK_MESSAGE"] <> ''):?>
    <div class="alert alert-success mf-ok-text">
        <?=htmlspecialcharsbx($arResult["OK_MESSAGE"])?>
    </div>
<?endif;?>

<form class="mt--40" id="<?=$formId?>" action="<?=POST_FORM_ACTION_URI?>" method="POST" novalidate>
	<?=bitrix_sessid_post()?>
	<div class="row">
		<div class="col-lg-6 col-md-12 col-12">

			<div class="rnform-group">
				<input type="text" name="user_name" value="<?=htmlspecialcharsbx($arResult["AUTHOR_NAME"])?>" placeholder="<?=GetMessage("MFT_NAME")?>" required minlength="2" maxlength="50">
			</div>

			<div class="rnform-group">
				<input class="phone" type="tel" name="user_phone" value="<?=htmlspecialcharsbx($arResult["AUTHOR_PHONE"])?>" placeholder="+7 (999) 999-99-99" required pattern="\+7\s?[\(]{0,1}9[0-9]{2}[\)]{0,1}\s?\d{3}[-]{0,1}\d{2}[-]{0,1}\d{2}">
			</div>

		</div>

		<?if($arParams["USE_CAPTCHA"] == "Y"):?>
		<div class="col-lg-12">
			<div class="mf-text"><?=GetMessage("MFT_CAPTCHA")?></div>
			<input type="hidden" name="captcha_sid" value="<?=htmlspecialcharsbx($arResult["capCode"])?>">
			<img src="/bitrix/tools/captcha.php?captcha_sid=<?=htmlspecialcharsbx($arResult["capCode"])?>" width="180" height="40" alt="CAPTCHA">
			<div class="mf-text"><?=GetMessage("MFT_CAPTCHA_CODE")?><span class="mf-req">*</span></div>
			<input class="blog-btn" type="text" name="captcha_word" size="30" maxlength="50" value="" required>
		</div>
		<?endif;?>
		<input type="hidden" name="PARAMS_HASH" value="<?=htmlspecialcharsbx($arResult["PARAMS_HASH"])?>">
		<button type="submit" name="submit" class="btn-default">
			<?=GetMessage("MFT_SUBMIT")?>
		</button>
	</div>
</form>

<?if($arResult['FACEBOOK_CONVERSION_ENABLED']):?>
<script>
	document.addEventListener('DOMContentLoaded', function() {
		const form = document.getElementById('<?=$formId?>');
		const closeMess = document.querySelector(".mf-ok-text");
		
		if (form) {
			form.addEventListener('submit', function(e) {
				if (form.elements && 
					form.elements['user_email'] &&
					form.elements['user_phone'] &&
					form.elements['user_phone'].value && 
					form.elements['user_site']) {
					BX.ajax.runAction('sale.facebookconversion.contact', {
						data: {contactBy: form.elements['user_email'].value}
					});
				}
			});
		}
		
		if (closeMess) {
			closeMess.addEventListener("click", function() {
				this.style.display = "none";
			});
		}
	});
</script>
<?endif;?>