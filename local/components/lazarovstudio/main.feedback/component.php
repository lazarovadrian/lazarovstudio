<?php
if(!defined("B_PROLOG_INCLUDED")||B_PROLOG_INCLUDED!==true)die();

/**
 * Bitrix vars
 *
 * @var array $arParams
 * @var array $arResult
 * @var CBitrixComponent $this
 * @global CMain $APPLICATION
 * @global CUser $USER
 */

// При отправке формы, создается элемент с данными
	// $el = new CIBlockElement;
	// $PROP = array();
	// $PROP[29] = "AUTHOR";
	// $PROP[32] = "AUTHOR_CITY";
	
	// $arLoadProductArray = Array(
	// "MODIFIED_BY"    => $USER->GetID(), // элемент изменен текущим пользователем
	// "IBLOCK_SECTION_ID" => false,          // элемент лежит в корне раздела
	// "IBLOCK_ID"      => 11,
	// "PROPERTY_VALUES"=> $PROP,
	// "NAME"           => "Элемент",
	// "ACTIVE"         => "Y",
	// "PREVIEW_TEXT"   => "текст для списка элементов",
	// "DETAIL_TEXT"    => "текст для детального просмотра"
	// );
	
	// if($PRODUCT_ID = $el->Add($arLoadProductArray))
	// echo "New ID: ".$PRODUCT_ID;
	// else
	// echo "Error: ".$el->LAST_ERROR;

$arResult["PARAMS_HASH"] = md5(serialize($arParams).$this->GetTemplateName());

$arParams["USE_CAPTCHA"] = (($arParams["USE_CAPTCHA"] != "N" && !$USER->IsAuthorized()) ? "Y" : "N");
$arParams["EVENT_NAME"] = trim($arParams["EVENT_NAME"]);
if($arParams["EVENT_NAME"] == '')
	$arParams["EVENT_NAME"] = "FEEDBACK_FORM";
$arParams["EVENT_PHONE"] = trim($arParams["EVENT_PHONE"]);
if($arParams["EVENT_PHONE"] == '')
	$arParams["EVENT_PHONE"] = GetMessage("MF_REQ_PHONE");
$arParams["EMAIL_TO"] = trim($arParams["EMAIL_TO"]);
if($arParams["EMAIL_TO"] == '')
	$arParams["EMAIL_TO"] = COption::GetOptionString("main", "email_from");
$arParams["OK_TEXT"] = trim($arParams["OK_TEXT"]);
if($arParams["OK_TEXT"] == '')
	$arParams["OK_TEXT"] = GetMessage("MF_OK_MESSAGE");

if($_SERVER["REQUEST_METHOD"] == "POST" && $_POST["submit"] <> '' && (!isset($_POST["PARAMS_HASH"]) || $arResult["PARAMS_HASH"] === $_POST["PARAMS_HASH"])){
	$arResult["ERROR_MESSAGE"] = array();
	if(check_bitrix_sessid()){
		if(empty($arParams["REQUIRED_FIELDS"]) || !in_array("NONE", $arParams["REQUIRED_FIELDS"])){
			if((empty($arParams["REQUIRED_FIELDS"]) || in_array("NAME", $arParams["REQUIRED_FIELDS"])) && mb_strlen($_POST["user_name"]) <= 1)
				$arResult["ERROR_MESSAGE"][] = GetMessage("MF_REQ_NAME");

			// if((empty($arParams["REQUIRED_FIELDS"]) || in_array("AUTHOR_PAY", $arParams["REQUIRED_FIELDS"])) && mb_strlen($_POST["user_pay"]) != "")
			// $arResult["ERROR_MESSAGE"][] = GetMessage("MF_REQ_PAY");

			// if((empty($arParams["REQUIRED_FIELDS"]) || in_array("EMAIL", $arParams["REQUIRED_FIELDS"])) && mb_strlen($_POST["user_email"]) <= 1)
			// 	$arResult["ERROR_MESSAGE"][] = GetMessage("MF_REQ_EMAIL");
			if((empty($arParams["REQUIRED_FIELDS"]) || in_array("PHONE", $arParams["REQUIRED_FIELDS"])) && mb_strlen($_POST["user_phone"]) < 12)
				$arResult["ERROR_MESSAGE"][] = GetMessage("MF_REQ_PHONE");
			if((empty($arParams["REQUIRED_FIELDS"]) || in_array("MESSAGE", $arParams["REQUIRED_FIELDS"])) && mb_strlen($_POST["MESSAGE"]) <= 3)
				$arResult["ERROR_MESSAGE"][] = GetMessage("MF_REQ_MESSAGE");

			if((empty($arParams["REQUIRED_FIELDS"]) || in_array("contact_text_dis", $arParams["REQUIRED_FIELDS"])) && mb_strlen($_POST["contact_text_dis"]) <= 3)
				$arResult["ERROR_MESSAGE"][] = GetMessage("MF_REQ_DOP_INFO");
			if((empty($arParams["REQUIRED_FIELDS"]) || in_array("contact_text_fun", $arParams["REQUIRED_FIELDS"])) && mb_strlen($_POST["contact_text_fun"]) <= 3)
				$arResult["ERROR_MESSAGE"][] = GetMessage("MF_REQ_TXT_USER");
		}
		// if(mb_strlen($_POST["user_email"]) > 1 && !check_email($_POST["user_email"]))
		// 	$arResult["ERROR_MESSAGE"][] = GetMessage("MF_EMAIL_NOT_VALID");
		if($arParams["USE_CAPTCHA"] == "Y"){
			$captcha_code = $_POST["captcha_sid"];
			$captcha_word = $_POST["captcha_word"];
			$cpt = new CCaptcha();
			$captchaPass = COption::GetOptionString("main", "captcha_password", "");
			if ($captcha_word <> '' && $captcha_code <> ''){
				if (!$cpt->CheckCodeCrypt($captcha_word, $captcha_code, $captchaPass))
					$arResult["ERROR_MESSAGE"][] = GetMessage("MF_CAPTCHA_WRONG");
			}
			else
				$arResult["ERROR_MESSAGE"][] = GetMessage("MF_CAPTHCA_EMPTY");

		}
		if(empty($arResult["ERROR_MESSAGE"])){
			$arFields = Array(
				"AUTHOR" => $_POST["user_name"],
				"AUTHOR_EMAIL" => $_POST["user_email"],
				"AUTHOR_PHONE" => $_POST["user_phone"],
				"AUTHOR_SITE" => $_POST["user_site"],
				"AUTHOR_CITY" => $_POST["user_city"],
				"AUTHOR_ADVA" => $_POST["user_adva"],
				"AUTHOR_BUDGET" => $_POST["user_budget"],
				"AUTHOR_DEADLINE" => $_POST["user_deadline"],
				"AUTHOR_PAY" => $_POST["user_pay"],
				"AUTHOR_FUNC" => $_POST['checkbox'],
				"AUTHOR_FUNC_TEXT" => $_POST["contact_text_fun"],
				"AUTHOR_LOGO" => $_POST["user_logo"],
				"AUTHOR_STOCK" => $_POST["user_stock"],
				"AUTHOR_PAY_SYSTEM" => $_POST["user_paySystem"],
				"AUTHOR_DOMEN" => $_POST["user_domen"],
				"AUTHOR_LANG" => $_POST["user_lang"],
				"AUTHOR_COLORSSTIE" => $_POST["user_colorssite"],
				"AUTHOR_LIKESITE" => $_POST["user_likesite"],
				"AUTHOR_NOTLIKESITE" => $_POST["user_notlikesite"],
				"AUTHOR_DEADLINE" => $_POST["user_deadline"],
				"EMAIL_TO" => $arParams["EMAIL_TO"],
				"TEXT" => $_POST["MESSAGE"],
				"TARIFF" => $_POST["tariff"],
			);
			if(!empty($arParams["EVENT_MESSAGE_ID"])){
				foreach($arParams["EVENT_MESSAGE_ID"] as $v)
					if(intval($v) > 0){
						CEvent::Send($arParams["EVENT_NAME"], SITE_ID, $arFields, "N", intval($v));
					}
			}
			else
			CEvent::Send($arParams["EVENT_NAME"], SITE_ID, $arFields);
			$_SESSION["MF_NAME"] = htmlspecialcharsbx($_POST["user_name"]);
			$_SESSION["MF_TARIFF"] = htmlspecialcharsbx($_POST["tariff"]);
			// $_SESSION["MF_EMAIL"] = htmlspecialcharsbx($_POST["user_email"]);
			$_SESSION["MF_PHONE"] = htmlspecialcharsbx($_POST["user_phone"]);
			LocalRedirect($APPLICATION->GetCurPageParam("success=".$arResult["PARAMS_HASH"], Array("success")));
		}

		$arResult["MESSAGE"] = htmlspecialcharsbx($_POST["MESSAGE"]);
		$arResult["AUTHOR_NAME"] = htmlspecialcharsbx($_POST["user_name"]);
		$arResult["TARIFF"] = htmlspecialcharsbx($_POST["tariff"]);
		// $arResult["AUTHOR_EMAIL"] = htmlspecialcharsbx($_POST["user_email"]);
		$arResult["AUTHOR_PHONE"] = htmlspecialcharsbx($_POST["user_phone"]);
		$arResult["AUTHOR_SITE"] = htmlspecialcharsbx($_POST["user_site"]);
	}
	else
		$arResult["ERROR_MESSAGE"][] = GetMessage("MF_SESS_EXP");
}
elseif($_REQUEST["success"] == $arResult["PARAMS_HASH"]){
	$arResult["OK_MESSAGE"] = $arParams["OK_TEXT"];
}
if(empty($arResult["ERROR_MESSAGE"])){
	if($USER->IsAuthorized()){
		$arResult["AUTHOR_NAME"] = $USER->GetFormattedName(false);
		// $arResult["AUTHOR_EMAIL"] = htmlspecialcharsbx($USER->GetEmail());
	}
	else{
		if($_SESSION["MF_NAME"] <> '')
			$arResult["AUTHOR_NAME"] = htmlspecialcharsbx($_SESSION["MF_NAME"]);
		// if($_SESSION["MF_EMAIL"] <> '')
		// 	$arResult["AUTHOR_EMAIL"] = htmlspecialcharsbx($_SESSION["MF_EMAIL"]);
		if($_SESSION["MF_PHONE"] <> '')
			$arResult["AUTHOR_PHONE"] = htmlspecialcharsbx($_SESSION["MF_PHONE"]);
		if($_SESSION["MF_SITE"] <> '')
			$arResult["AUTHOR_SITE"] = htmlspecialcharsbx($_SESSION["MF_SITE"]);
	}
}
if($arParams["USE_CAPTCHA"] == "Y")
	$arResult["capCode"] =  htmlspecialcharsbx($APPLICATION->CaptchaGetCode());

$arResult['FACEBOOK_CONVERSION_ENABLED'] =
	\Bitrix\Main\Loader::includeModule('sale')
	&& \Bitrix\Sale\Internals\FacebookConversion::isEventEnabled('Contact')
		? 'Y'
		: 'N'
;
$this->IncludeComponentTemplate();
