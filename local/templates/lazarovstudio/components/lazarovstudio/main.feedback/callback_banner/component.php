<?
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

$arResult["PARAMS_HASH"] = md5(serialize($arParams).$this->GetTemplateName());

$arParams["USE_CAPTCHA"] = (($arParams["USE_CAPTCHA"] != "N" && !$USER->IsAuthorized()) ? "Y" : "N");
$arParams["EVENT_NAME"] = trim($arParams["EVENT_NAME"]);
if($arParams["EVENT_NAME"] == '')
	$arParams["EVENT_NAME"] = "FEEDBACK_FORM";
$arParams["EMAIL_TO"] = trim($arParams["EMAIL_TO"]);
if($arParams["EMAIL_TO"] == '')
	$arParams["EMAIL_TO"] = COption::GetOptionString("main", "email_from");
$arParams["OK_TEXT"] = trim($arParams["OK_TEXT"]);
if($arParams["OK_TEXT"] == '')
	$arParams["OK_TEXT"] = GetMessage("MF_OK_MESSAGE");

// Security measures
$arParams["EMAIL_TO"] = htmlspecialcharsbx($arParams["EMAIL_TO"]);
$arParams["OK_TEXT"] = htmlspecialcharsbx($arParams["OK_TEXT"]);

// Rate limiting
$ipAddress = $_SERVER['REMOTE_ADDR'];
$cacheTime = 3600; // 1 hour
$cacheId = 'feedback_attempts_' . $ipAddress;
$cachePath = '/feedback_attempts/';

$obCache = new CPHPCache();
$attempts = 0;

if($obCache->InitCache($cacheTime, $cacheId, $cachePath)) {
    $vars = $obCache->GetVars();
    $attempts = $vars['attempts'];
}

if($attempts > 10) {
    $arResult["ERROR_MESSAGE"][] = GetMessage("MF_TOO_MANY_ATTEMPTS");
    $this->IncludeComponentTemplate();
    return;
}

if($_SERVER["REQUEST_METHOD"] == "POST" && $_POST["submit"] <> '' && (!isset($_POST["PARAMS_HASH"]) || $arResult["PARAMS_HASH"] === $_POST["PARAMS_HASH"]))
{
    // CSRF protection
    if(!check_bitrix_sessid()) {
        $arResult["ERROR_MESSAGE"][] = GetMessage("MF_SESS_EXP");
        $this->IncludeComponentTemplate();
        return;
    }

    $arResult["ERROR_MESSAGE"] = array();
    if(check_bitrix_sessid())
    {
        // Input validation
        if(strlen($_POST["user_name"]) < 2)
            $arResult["ERROR_MESSAGE"][] = GetMessage("MF_REQ_NAME");
        
        // Phone validation
        if(!preg_match('/^\+7\s?[\(]{0,1}9[0-9]{2}[\)]{0,1}\s?\d{3}[-]{0,1}\d{2}[-]{0,1}\d{2}$/', $_POST["user_phone"]))
            $arResult["ERROR_MESSAGE"][] = GetMessage("MF_REQ_PHONE");

        if($arParams["USE_CAPTCHA"] == "Y")
        {
            include_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/classes/general/captcha.php");
            $captcha_code = $_POST["captcha_sid"];
            $captcha_word = $_POST["captcha_word"];
            $cpt = new CCaptcha();
            $captchaPass = COption::GetOptionString("main", "captcha_password", "");
            if (strlen($captcha_word) > 0 && strlen($captcha_code) > 0)
            {
                if (!$cpt->CheckCodeCrypt($captcha_word, $captcha_code, $captchaPass))
                    $arResult["ERROR_MESSAGE"][] = GetMessage("MF_CAPTCHA_WRONG");
            }
            else
                $arResult["ERROR_MESSAGE"][] = GetMessage("MF_CAPTHCA_EMPTY");

        }

        // XSS protection
        $userName = htmlspecialcharsbx($_POST["user_name"]);
        $userPhone = htmlspecialcharsbx($_POST["user_phone"]);
            
        if(empty($arResult["ERROR_MESSAGE"]))
        {
            // Increment attempt counter
            $attempts++;
            $obCache->StartDataCache();
            $obCache->EndDataCache(array('attempts' => $attempts));

            $arFields = Array(
                "AUTHOR" => $userName,
                "AUTHOR_PHONE" => $userPhone,
                "EMAIL_TO" => $arParams["EMAIL_TO"],
                "TEXT" => GetMessage("MF_CALL_REQUEST") . " " . $userName . " (" . $userPhone . ")"
            );

            // Log the request
            CEventLog::Add(array(
                "SEVERITY" => "SECURITY",
                "AUDIT_TYPE_ID" => "FEEDBACK_FORM",
                "MODULE_ID" => "main",
                "ITEM_ID" => $arParams["EVENT_NAME"],
                "DESCRIPTION" => "Feedback form submission from " . $userName . " (" . $userPhone . ")"
            ));

            if(!empty($arParams["EVENT_MESSAGE_ID"]))
            {
                foreach($arParams["EVENT_MESSAGE_ID"] as $v)
                    if(IntVal($v) > 0)
                        CEvent::Send($arParams["EVENT_NAME"], SITE_ID, $arFields, "N", IntVal($v));
            }
            else
                CEvent::Send($arParams["EVENT_NAME"], SITE_ID, $arFields);

            $_SESSION["MF_NAME"] = $userName;
            $_SESSION["MF_PHONE"] = $userPhone;

            LocalRedirect($APPLICATION->GetCurPageParam("success=".$arResult["PARAMS_HASH"], Array("success")));
        }
        
        $arResult["AUTHOR_NAME"] = $userName;
        $arResult["AUTHOR_PHONE"] = $userPhone;
    }
    else
        $arResult["ERROR_MESSAGE"][] = GetMessage("MF_SESS_EXP");
}
elseif($_REQUEST["success"] === $arResult["PARAMS_HASH"])
{
    $arResult["OK_MESSAGE"] = $arParams["OK_TEXT"];
}

if(empty($arResult["ERROR_MESSAGE"]))
{
    if($USER->IsAuthorized())
    {
        $arResult["AUTHOR_NAME"] = $USER->GetFormattedName(false);
        $arResult["AUTHOR_PHONE"] = "";
    }
    else
    {
        if(strlen($_SESSION["MF_NAME"]) > 0)
            $arResult["AUTHOR_NAME"] = htmlspecialcharsbx($_SESSION["MF_NAME"]);
        if(strlen($_SESSION["MF_PHONE"]) > 0)
            $arResult["AUTHOR_PHONE"] = htmlspecialcharsbx($_SESSION["MF_PHONE"]);
    }
}

if($arParams["USE_CAPTCHA"] == "Y")
    $arResult["capCode"] =  htmlspecialcharsbx($APPLICATION->CaptchaGetCode());

$this->IncludeComponentTemplate(); 