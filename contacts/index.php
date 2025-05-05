<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION -> SetTitle("LazarovStudio || Контакты");
?>
    <!-- Start Contact Area  -->
    <div class="main-content">
        <div class="rwt-contact-area rn-section-gap">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 mb--40">
                        <div class="section-title text-center">
                            <h4 class="subtitle "><span class="theme-gradient">Обратная связь</span></h4>
                            <h2 class="title w-600 mb--20">Наши контакты</h2>
                        </div>
                    </div>
                </div>
                <div class="row row--15">
                    <div class="col-lg-12">
                        <div class="rn-contact-address mt_dec--30">
                            <div class="row">
                                <div class="col-lg-4 col-md-6 col-12">
                                    <div class="rn-address">
                                        <div class="inner">
                                            <h4 class="title"><i class="fa-solid fa-phone"> </i> Телефоны</h4>
                                            <p><a rel='nofollow' href="tel:<?
															  $APPLICATION -> IncludeFile(SITE_TEMPLATE_PATH . "/includes/phone.php", [], ["SHOW_BORDER" => false]); ?>"><?
																  $APPLICATION -> IncludeFile(SITE_TEMPLATE_PATH . "/includes/phone.php", [], array("MODE" => "text", "NAME" => "Телефон")); ?></a></p>
                                        </div>
                                        <div class="contact_social_icon">
                                            <a href="<?
														  $APPLICATION -> IncludeFile(SITE_TEMPLATE_PATH . "/includes/tg.php", [], ["SHOW_BORDER" => false]); ?>" target="_blank">
                                                <i class="fa-brands fa-telegram fa-xl"></i>
                                            </a>
                                            <a href="<?
														  $APPLICATION -> IncludeFile(SITE_TEMPLATE_PATH . "/includes/whatsaap.php", [], ["SHOW_BORDER" => false]); ?>" target="_blank">
                                                <i class="fa-brands fa-whatsapp fa-xl"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 col-12">
                                    <div class="rn-address">
                                        <div class="icon">
                                            <i class="feather-mail"></i>
                                        </div>
                                        <div class="inner">
                                            <h4 class="title"><i class="fa-regular fa-envelope"> </i> Почта</h4>
                                            <p><a rel='nofollow' href="mailto:<?
															  $APPLICATION -> IncludeFile(SITE_TEMPLATE_PATH . "/includes/email.php", [], ["SHOW_BORDER" => false]); ?>"><?
																  $APPLICATION -> IncludeFile(SITE_TEMPLATE_PATH . "/includes/email.php", [], array("MODE" => "text", "NAME" => "Почта")); ?></a></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 col-12">
                                    <div class="rn-address">
                                        <div class="icon">
                                            <i class="feather-map-pin"></i>
                                        </div>
                                        <div class="inner">
                                            <h4 class="title"><i class="fa-solid fa-earth-europe"> </i> Откуда Мы</h4>
                                            <p>г. Сочи, Россия</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row row--15">
                    <iframe src="//yandex.ru/map-widget/v1/?z=12&ol=biz&oid=58695625678" width="100%" height="400" frameborder="0"></iframe>
                </div>

                <div class="row mt--40 row--15">
                    <h3 class="title w-600 mb--20 text-center">БЕСПЛАТНАЯ КОНСУЛЬТАЦИЯ</h3>
                    <div class="col-lg-12">
							  <?
							  $APPLICATION -> IncludeComponent(
								  "lazarovstudio:main.feedback",
								  "template_callback",
								  array(
									  "COMPOSITE_FRAME_MODE" => "A",
									  "COMPOSITE_FRAME_TYPE" => "AUTO",
									  "EMAIL_TO" => "lazarovstudio@yandex.ru",
									  "EVENT_MESSAGE_ID" => array("7"),
									  "OK_TEXT" => "Спасибо, ваше сообщение принято.",
									  "REQUIRED_FIELDS" => array("NAME", "PHONE", "MESSAGE"),
									  "USE_CAPTCHA" => "N",
									  "AJAX_MODE" => "Y", // [Y|N] При установленной опции для компонента будет включен режим AJAX.
									  "AJAX_OPTION_SHADOW" => "N", // [Y|N] Затемнять область
									  "AJAX_OPTION_JUMP" => "N", // [Y|N] Если пользователь совершит AJAX-переход, то при установленой опции по окончании загрузки произойдет прокрутка к началу компонента.
									  "AJAX_OPTION_STYLE" => "Y", // [Y|N] Если параметр принимает значение "Y", то при совершении AJAX-переходов будет происходить подгрузка и обработка списка стилей, вызванных компонентом.
									  "AJAX_OPTION_HISTORY" => "N", //[Y|N] Когда пользователь выполняет AJAX-переходы, то при включенной опции можно использовать кнопки браузера Назад и Вперед.
								  ),
							  ); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Contact Area  -->

    <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "ContactPage",
            "mainEntity": {
                "@type": "Organization",
                "name": "LazarovStudio",
                "url": "https://lazarovStudio.ru/contacts/",
                "contactPoint": {
                    "@type": "ContactPoint",
                    "telephone": "+7 (901) 004-67-85",
                    "contactType": "Customer Support",
                    "areaServed": "RU",
                    "availableLanguage": "Russian"
                },
                "address": {
                    "@type": "PostalAddress",
                    "streetAddress": " ",
                    "addressLocality": "Сочи",
                    "addressCountry": "RU"
                },
                "email": "lazarovstudio@ya.ru"
            }
        }
    </script>

<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>