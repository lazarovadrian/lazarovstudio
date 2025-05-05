<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true){
	die();
}
use Bitrix\Main\Page\Asset;

$curPage = $APPLICATION->GetCurPage(true);
$curPageWI = $APPLICATION->GetCurPage();
$APPLICATION->SetPageProperty('canonical', 'https://' . $_SERVER['SERVER_NAME'] . $curPageWI);
?>
<!DOCTYPE html>
<html lang="ru-RU">

<head>
	<?php $APPLICATION -> ShowHead(); ?>
    <title><?php $APPLICATION -> ShowTitle() ?></title>
    <meta name="zen-verification" content="zWuyZThil2FjshlTAA16BIm5kAGZwsFJwQF6DS7K4VmiYpSYniPq47GRQRM1BWCI" />
    <meta name="yandex-verification" content="57efa5f64dea2ebe"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>


    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="favicon.ico">
    <link rel="apple-touch-icon" sizes="180x180" href="<?=SITE_TEMPLATE_PATH?>/images/favicons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?=SITE_TEMPLATE_PATH?>/images/favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="194x194" href="<?=SITE_TEMPLATE_PATH?>/images/favicons/favicon-194x194.png">
    <link rel="icon" type="image/png" sizes="192x192" href="<?=SITE_TEMPLATE_PATH?>/images/favicons/android-chrome-192x192.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?=SITE_TEMPLATE_PATH?>/images/favicons/favicon-16x16.png">
    <link rel="manifest" href="<?=SITE_TEMPLATE_PATH?>/images/favicons/site.webmanifest">
    <link rel="mask-icon" href="<?=SITE_TEMPLATE_PATH?>/images/favicons/safari-pinned-tab.svg" color="#0f0f11">
    <meta name="msapplication-TileColor" content="#0f0f11">
    <meta name="msapplication-TileImage" content="<?=SITE_TEMPLATE_PATH?>/images/favicons/mstile-144x144.png">
    <meta name="theme-color" content="#0f0f11">

    <!-- All Scripts  -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/three.js/r121/three.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/vanta@latest/dist/vanta.globe.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css"/>

    <?php
        Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/js/vendor/modernizr.min.js");
        Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/js/vendor/jquery.min.js");
        Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/js/vendor/bootstrap.min.js");
        Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/js/vendor/popper.min.js");
        Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/js/vendor/waypoint.min.js");
        Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/js/vendor/wow.min.js");
        Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/js/vendor/counterup.min.js");
        Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/js/vendor/masonry.js");
        Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/js/vendor/imageloaded.js");
        Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/js/vendor/magnify.min.js");
        Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/js/vendor/slick.min.js");
        Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/js/vendor/easypie.js");
        Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/js/vendor/text-type.js");
        Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/js/vendor/jquery.style.swicher.js");
        Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/js/vendor/js.cookie.js");
        Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/js/vendor/jquery.maskedinput.min.js");
        Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/js/hl.js");
        Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/js/main.js");
    ?>

	<!-- Fonts Inter -->
	<link rel="preconnect" href="//fonts.googleapis.com">
	<link rel="preconnect" href="//fonts.gstatic.com" crossorigin>
	<link href="//fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">

    <!-- CSS -->
    <?php
        Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/css/vendor/bootstrap.min.css");
        Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/css/plugins/animation.css");
        Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/css/plugins/magnify.min.css");
        Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/css/plugins/slick.css");
        Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/css/plugins/slick-theme.css");
        Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/css/plugins/lightbox.css");
        Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/css/plugins/all.min.css");
        Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/css/plugins/hljs.css");
        Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/css/style.css");
    ?>
</head>

<?php $APPLICATION -> ShowPanel(); ?>
<body>
<main class="page-wrapper">
    <div class="header-top-bar">
        <div class="container">
            <div class="row align-items-center mobile_hidden">
                <div class="col-lg-4 col-md-12 col-12">
                    <div class="header-left mobile_hidden">
                      <?php $APPLICATION -> IncludeComponent(
                          "bitrix:menu",
                          "header_nav_up",
                          [
                              "ALLOW_MULTI_SELECT" => "N",
                              "CHILD_MENU_TYPE" => "left",
                              "DELAY" => "N",
                              "MAX_LEVEL" => "1",
                              "MENU_CACHE_GET_VARS" => [
                              ],
                              "MENU_CACHE_TIME" => "3600",
                              "MENU_CACHE_TYPE" => "A",
                              "MENU_CACHE_USE_GROUPS" => "Y",
                              "ROOT_MENU_TYPE" => "bottom_main",
                              "USE_EXT" => "Y",
                              "COMPONENT_TEMPLATE" => "header_nav_up",
                          ],
                          false,
                      ); ?>
                    </div>
                </div>
                <div class="col-lg-8 col-md-12 col-12 mobile_hidden">
                    <div class="header-right">
                        <div class="address-content">
                            <p>
                                <i class="fa-solid fa-earth-europe fa-xl"></i>
                                <span>Сочи, Россия</span>
                            </p>
                            <p>
                                <i class="fa-solid fa-phone fa-xl"></i>
                                <span><a rel='nofollow' href="tel:<?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH . "/includes/phone.php", [], ["SHOW_BORDER" => false]);?>"><? $APPLICATION->IncludeFile(SITE_TEMPLATE_PATH . "/includes/phone.php", [], array("MODE" => "text", "NAME" => "Телефон")); ?></a></span>
                            </p>
                        </div>
                        <div class="social-icon-wrapper">
                            <ul class="social-icon social-default icon-naked">
                                <li>
                                    <a rel='nofollow' href="<?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH . "/includes/tg.php", [], ["SHOW_BORDER" => false]);?>" target="_blank">
                                        <i class="fa-brands fa-telegram fa-xl"></i>
                                    </a>
                                </li>
                                <li>
                                    <a rel='nofollow' href="<?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH . "/includes/whatsaap.php", [], ["SHOW_BORDER" => false]);?>" target="_blank">
                                        <i class="fa-brands fa-whatsapp fa-xl"></i>
                                    </a>
                                </li>
                                <li>
                                    <a rel='nofollow' href="mailto:<?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH . "/includes/email.php", [], ["SHOW_BORDER" => false]);?>">
                                        <i class="fa-regular fa-envelope fa-xl"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="btn_order">
                            <a href="/order/" class="btn-default btn-default_new">Заказать</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <header class="rn-header header-default header-left-align header-transparent header-sticky">
        <div class="container position-relative">
            <div class="row align-items-center row--0">
                <div class="col-lg-3 col-md-6 col-4">
                    <div class="logo">
                          <?php if($APPLICATION -> GetCurPage() === "/"): ?>
                           <img class="logo-light" src="<?=SITE_TEMPLATE_PATH?>/images/logo/logo.png" alt="LazarovStudio" title="lazarovstudio">
                           <span class="logo-name" href="/">lazarovstudio</span>
							  <?php else: ?>
                           <a href="/">
                               <img class="logo-light" src="<?=SITE_TEMPLATE_PATH?>/images/logo/logo.png" alt="LazarovStudio" title="lazarovstudio">
                           </a>
                           <a class="logo-name" href="/">lazarovstudio</a>
                          <?php endif; ?>
                    </div>
                </div>
                <div class="col-lg-9 col-md-6 col-8 position-static">
                    <div class="header-right">
							  <?php
							  $APPLICATION -> IncludeComponent(
								  "bitrix:menu",
								  "main_nav",
								  [
									  "ROOT_MENU_TYPE" => "top",
									  "MENU_CACHE_TYPE" => "A",
									  "MENU_CACHE_TIME" => "36000000",
									  "MENU_CACHE_USE_GROUPS" => "Y",
									  "MENU_CACHE_GET_VARS" => [
									  ],
									  "MAX_LEVEL" => "2",
									  "CHILD_MENU_TYPE" => "left",
									  "USE_EXT" => "Y",
									  "ALLOW_MULTI_SELECT" => "N",
									  "COMPONENT_TEMPLATE" => "main_nav",
									  "DELAY" => "N",
								  ],
								  false,
								  [
									  "ACTIVE_COMPONENT" => "Y",
								  ],
							  );
							  ?>
                        <!-- Start Mobile-Menu-Bar -->
                        <div class="mobile-menu-bar ml--5 d-block d-lg-none">
                            <div class="hamberger">
                                <button class="hamberger-button">
                                    <i class="fa-solid fa-bars"></i>
                                </button>
                            </div>
                        </div>
                        <!-- Start Mobile-Menu-Bar -->
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Mobile Menu -->
    <div class="popup-mobile-menu">
        <div class="inner">
            <div class="header-top">
                <div class="logo">
						 <?php if($APPLICATION -> GetCurPage() === "/"): ?>
                       <img class="logo-light" src="<?=SITE_TEMPLATE_PATH?>/images/logo/logo.png" alt="LazarovStudio" title="lazarovstudio">
                       <span class="logo-name" href="/">lazarovstudio</span>
						 <?php else: ?>
                       <a href="/">
                           <img class="logo-light" src="<?=SITE_TEMPLATE_PATH?>/images/logo/logo.png" alt="LazarovStudio" title="lazarovstudio">
                       </a>
                       <a class="logo-name" href="/">lazarovstudio</a>
						 <?php endif; ?>
                </div>
                <div class="close-menu">
                    <button class="close-button">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
            </div>
			  <?php
			  $APPLICATION -> IncludeComponent(
				  "bitrix:menu",
				  "mobile_main_nav",
				  [
					  "ROOT_MENU_TYPE" => "top",
					  "MENU_CACHE_TYPE" => "A",
					  "MENU_CACHE_TIME" => "36000000",
					  "MENU_CACHE_USE_GROUPS" => "Y",
					  "MENU_CACHE_GET_VARS" => [
					  ],
					  "MAX_LEVEL" => "2",
					  "CHILD_MENU_TYPE" => "left",
					  "USE_EXT" => "Y",
					  "ALLOW_MULTI_SELECT" => "N",
					  "COMPONENT_TEMPLATE" => "moblie_main_nav",
					  "DELAY" => "N",
				  ],
				  false,
				  [
					  "ACTIVE_COMPONENT" => "Y",
				  ],
			  );
			  ?>
            <div class="footer_mobile-nav">
                <div class="block_nav">
                    <div class="header-left">
                      <?php $APPLICATION -> IncludeComponent(
								  "bitrix:menu",
								  "header_nav_up",
								  [
									  "ALLOW_MULTI_SELECT" => "N",
									  "CHILD_MENU_TYPE" => "left",
									  "DELAY" => "N",
									  "MAX_LEVEL" => "1",
									  "MENU_CACHE_GET_VARS" => [
									  ],
									  "MENU_CACHE_TIME" => "3600",
									  "MENU_CACHE_TYPE" => "A",
									  "MENU_CACHE_USE_GROUPS" => "Y",
									  "ROOT_MENU_TYPE" => "bottom_main",
									  "USE_EXT" => "Y",
									  "COMPONENT_TEMPLATE" => "header_nav_up",
								  ],
								  false,
							  ); ?>
                    </div>
                    <div class="">
                        <div class="btn-default btn-phone">
                            <p>
                                <i class="fa-solid fa-phone fa-xl"></i>
                                <span><a href="tel:<?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH . "/includes/phone.php", [], ["SHOW_BORDER" => false]);?>"><? $APPLICATION->IncludeFile(SITE_TEMPLATE_PATH . "/includes/phone.php", [], array("MODE" => "text", "NAME" => "Телефон")); ?></a></span>
                            </p>
                        </div>
                        <div class="btn_order">
                            <a href="/order/" class="btn-default btn-default_new">Заказать</a>
                        </div>
                        <div class="social-icon-wrapper">
                            <ul class="social-icon social-default icon-naked mobile_nav_social">
                                <li>
                                    <a href="<?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH . "/includes/tg.php", [], ["SHOW_BORDER" => false]);?>" target="_blank">
                                        <i class="fa-brands fa-telegram fa-xl"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH . "/includes/whatsaap.php", [], ["SHOW_BORDER" => false]);?>" target="_blank">
                                        <i class="fa-brands fa-whatsapp fa-xl"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="mailto:<?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH . "/includes/email.php", [], ["SHOW_BORDER" => false]);?>">
                                        <i class="fa-regular fa-envelope fa-xl"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Mobile Menu -->