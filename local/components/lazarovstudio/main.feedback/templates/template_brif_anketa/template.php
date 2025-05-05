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

<?
//получаем данные из свойств инфоблока, тип СПИСОК
CModule::IncludeModule("iblock");
$arProps = Array();
$IBLOCK_ID = 11;
$property_enums = CIBlockPropertyEnum::GetList(Array("ID" => "ASC", "SORT" => "ASC"), Array("IBLOCK_ID" => $IBLOCK_ID));
while ($enum_fields = $property_enums->GetNext()) {
	$arProps[$enum_fields["PROPERTY_CODE"]]["NAME"] = $enum_fields["PROPERTY_NAME"];
	$arProps[$enum_fields["PROPERTY_CODE"]]["VALUE"][] = $enum_fields["VALUE"];
};
?>
<!-- <?=GetMessage("MFT_MESSAGE")?><?if(empty($arParams["REQUIRED_FIELDS"]) || in_array("MESSAGE", $arParams["REQUIRED_FIELDS"])):?>
<span class="mf-req">*</span><?endif?> -->
<div class="main-content">
	
	<div class="rwt-contact-area rn-section-gap">
    	<div class="container">
			<div class="page-title">
				<h1 class="title display-one rn-sub-badge-h1">Бриф на создание сайта в 1С-Битрикс</h1>
				<p class="desc">Спасибо, что нашли время заполнить бриф. Помните, максимально заполненный бриф помогает вам получить сайт, соответствующий вашим ожиданиям.</p>
				<p class="desc">В итоге, заполненный бриф, вы сможете использовать его как техническое задание при обращении к другому специалисту.</p>
			</div>
		<?
		if(!empty($arResult["ERROR_MESSAGE"])){
			foreach($arResult["ERROR_MESSAGE"] as $v)
				ShowError($v);
			}
			if($arResult["OK_MESSAGE"] <> ''){?>
				<div class="mf-ok-text"><?=$arResult["OK_MESSAGE"]?></div>
		<?}?>
			<form class="contact-form-1 rainbow-dynamic-form" id="<?=$formId?>" action="<?=POST_FORM_ACTION_URI?>" method="POST">
				<?=bitrix_sessid_post()?>
					
					<div class="form_brif">

						<div class="block_design">
							<div class="title"><p>Дизайн</p></div>
							<div class="form-group">
								<input type="text" name="user_likesite" id="contact-likesite"  value="<?=$arResult["AUTHOR_LIKESITE"]?>" placeholder="<?=GetMessage("MFT_LIKESITE")?>" required>
							</div>
							<div class="form-group">
								<input type="text" name="user_notlikesite" id="contact-notlikesite"  value="<?=$arResult["AUTHOR_NOTLIKESITE"]?>" placeholder="<?=GetMessage("MFT_NOTLIKESITE")?>" required>
							</div>
							<div class="form-group">
								<input type="text" name="user_colorssite" id="contact-colorssite"  value="<?=$arResult["AUTHOR_COLORSSTIE"]?>" placeholder="<?=GetMessage("MFT_COLORSSTIE")?>" required>
							</div>
							<div class="form-group">

								<label for="stock-select"><?=GetMessage("MFT_LOGO")?>:</label>
								<select name="user_logo" id="logo-select">
									<?foreach($arProps["ATTR_BRIF_LOGO"]["VALUE"] as $inputLogo):?>
										<option value="<?=$arResult["AUTHOR_LOGO"]?><?=$inputLogo;?>"><?=$inputLogo;?></option>
									<?endforeach;?>
								</select>

							</div>
							<div class="form-group">
								<textarea 
									name="MESSAGE" 
									id="contact-text-dis" 
									placeholder="<?=GetMessage("MFT_TEXT_DIS")?>"
									required
								></textarea>
							</div>
						</div>

						<div class="block_function">
							<div class="title"><p>Функционал</p></div>
							<div class="form-group">
								<input type="text" name="user_lang" id="contact-lang"  value="<?=$arResult["AUTHOR_LANG"]?>" placeholder="<?=GetMessage("MFT_LANG")?>" required>
							</div>
							<div class="form-group">
								<label for="stock-select"><?=GetMessage("MFT_STOCK")?>:</label>
								<select name="user_stock" id="stock-select" class="selected">
									<?foreach($arProps["ATTR_BRIF_STOCK_HOSTING"]["VALUE"] as $optStock):?>
										<option value="<?=$arResult["AUTHOR_STOCK"]?><?=$optStock;?>"><?=$optStock;?></option>
									<?endforeach;?>
								</select>
							</div>
							<div class="form-group">
								<input type="text" name="user_domen" id="contact-domen"  value="<?=$arResult["AUTHOR_DOMEN"]?>" placeholder="<?=GetMessage("MFT_DOMEN")?>" required>
							</div>
							<div class="form-group">
								<label for="paySystem-select">Платежная система?</label>
								<select name="user_paySystem" id="paySystem-select" class="selected">
									<?foreach($arProps["ATTR_FUNCTION_PAY_SYSTEMS"]["VALUE"] as $paySystem):?>
										<option value="<?=$arResult["AUTHOR_STOCK"]?><?=$paySystem;?>"><?=$paySystem;?></option>
									<?endforeach;?>
								</select>
							</div>
							
							<div class="form-group block_select_functions">
								<p class="title">Выберете нужный функционал для сайта</p>
								<?foreach($arProps["ATTR_BLOCKS_FUNCTION"]["VALUE"] as $key => $inpFunc):?>
										<?if($key <= 10):?>
											<div class="select_funtion">
												<input type="checkbox" name="checkbox[]" value="<?=$arResult["AUTHOR_FUNC"]?><?=$inpFunc;?>" class="functionSelected">
												<label for="checkbox[]"><?=$inpFunc;?></label>
											</div>
										<?endif?>
										<?if($key > 10):?>
											<div class="select_funtion">
												<input type="checkbox" name="checkbox[]" value="<?=$arResult["AUTHOR_FUNC"]?><?=$inpFunc;?>" class="functionSelected">
												<label for="checkbox[]"><?=$inpFunc;?></label>
											</div>
										<?endif?>
								<?endforeach;?>
							</div>

							<div class="form-group">
								<textarea 
									name="contact_text_fun" 
									id="contact-text-fun" 
									placeholder="<?=GetMessage("MFT_USER")?>"
									value="<?=$arResult["AUTHOR_FUNC_TEXT"]?>"
									required
								></textarea>
							</div>
						</div>

						<div class="block_contact">
							<div class="title"><p>Контакты</p></div>
							<div class="form-group">
								<input type="text" name="user_name" id="contact-name"  value="<?=$arResult["AUTHOR"];?>" placeholder="<?=GetMessage("MFT_NAME")?>" required>
							</div>
							<div class="form-group">
								<input type="text" name="user_phone" id="contact-phone"  value="<?=$arResult["AUTHOR_PHONE"];?>" placeholder="<?=GetMessage("MFT_PHONE")?>" required>
							</div>
							<div class="form-group">
								<input type="email" name="user_email" id="contact-email"  value="<?=$arResult["AUTHOR_EMAIL"];?>" placeholder="<?=GetMessage("MFT_EMAIL")?>" required>
							</div>
							<div class="form-group">
								<input type="text" name="user_city" id="contact-city"  value="<?=$arResult["AUTHOR_CITY"];?>" placeholder="<?=GetMessage("MFT_CITY")?>">
							</div>
							<div class="form-group">
								<input type="text" name="user_adva" id="contact-adva"  value="<?=$arResult["AUTHOR_ADVA"];?>" placeholder="<?=GetMessage("MFT_ADVA")?>">
							</div>
							<div class="form-group">
								<input type="text" name="user_budget" id="contact-budget"  value="<?=$arResult["AUTHOR_BUDGET"];?>" placeholder="<?=GetMessage("MFT_BUDGET")?>">
							</div>
							<div class="form-group">
								<input type="text" name="user_deadline" id="contact-deadline"  value="<?=$arResult["AUTHOR_DEADLINE"];?>" placeholder="<?=GetMessage("MFT_DEADLINE")?>">
							</div>

							<div class="form-group">
								<label for="pay-select"><?=GetMessage("MFT_METHOD_PAY")?>:</label>
								<select name="user_pay" id="pay-select">
									<?foreach($arProps["ATTR_BRIF_PAY"]["VALUE"] as $optPay):?>
										<option value="<?=$arResult["AUTHOR_PAY"];?><?=$optPay;?>"><?=$optPay;?></option>
									<?endforeach;?>
								</select>
							</div>

							<div class="form-group btn_block">
								<input class="btn-default btn-large rainbow-btn" type="submit" name="submit" value="<?=GetMessage("MFT_SUBMIT")?>">
							</div>
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
					<!-- <input class="btn-default" type="submit" name="submit" value="<?=GetMessage("MFT_SUBMIT")?>"> -->
			</form>
		</div>
	</div>
</div>