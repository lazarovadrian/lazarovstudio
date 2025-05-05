<footer class="rn-footer footer-style-default no-border">
    <div class="footer-top">
        <div class="container">
            <div class="row">
                <div class="col-lg-2 col-md-6 col-sm-6 col-12">
                    <div class="rn-footer-widget">
                        <h4 class="title">LazarovStudio</h4>
                        <div class="inner">
                            <?$APPLICATION->IncludeComponent(
                                "bitrix:menu", 
                                "bottom_nav_dev_footer", 
                                array(
                                    "ALLOW_MULTI_SELECT" => "N",
                                    "CHILD_MENU_TYPE" => "left",
                                    "DELAY" => "N",
                                    "MAX_LEVEL" => "1",
                                    "MENU_CACHE_GET_VARS" => array(
                                    ),
                                    "MENU_CACHE_TIME" => "3600",
                                    "MENU_CACHE_TYPE" => "A",
                                    "MENU_CACHE_USE_GROUPS" => "Y",
                                    "ROOT_MENU_TYPE" => "bottom_main",
                                    "USE_EXT" => "Y",
                                    "COMPONENT_TEMPLATE" => "bottom_nav_dev_footer"
                                ),
                                false
                            );?>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="rn-footer-widget">
                        <h4 class="title">Разработка</h4>
                        <div class="inner">
                            <?$APPLICATION->IncludeComponent(
                                "bitrix:menu", 
                                "bottom_nav_dev_footer", 
                                array(
                                    "ALLOW_MULTI_SELECT" => "N",
                                    "CHILD_MENU_TYPE" => "left",
                                    "DELAY" => "N",
                                    "MAX_LEVEL" => "1",
                                    "MENU_CACHE_GET_VARS" => array(
                                    ),
                                    "MENU_CACHE_TIME" => "3600",
                                    "MENU_CACHE_TYPE" => "A",
                                    "MENU_CACHE_USE_GROUPS" => "Y",
                                    "ROOT_MENU_TYPE" => "bottom",
                                    "USE_EXT" => "Y",
                                    "COMPONENT_TEMPLATE" => "bottom_nav_dev_footer"
                                ),
                                false
                            );?>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="rn-footer-widget">
                        <div class="widget-menu-top">
                            <h4 class="title">Продвижение сайтов</h4>
                            <div class="inner">
                                <?$APPLICATION->IncludeComponent(
                                    "bitrix:menu", 
                                    "bottom_nav_dev_footer", 
                                    array(
                                        "ALLOW_MULTI_SELECT" => "N",
                                        "CHILD_MENU_TYPE" => "left",
                                        "DELAY" => "N",
                                        "MAX_LEVEL" => "1",
                                        "MENU_CACHE_GET_VARS" => array(
                                        ),
                                        "MENU_CACHE_TIME" => "3600",
                                        "MENU_CACHE_TYPE" => "A",
                                        "MENU_CACHE_USE_GROUPS" => "Y",
                                        "ROOT_MENU_TYPE" => "bottom_seo",
                                        "USE_EXT" => "Y",
                                        "COMPONENT_TEMPLATE" => "bottom_nav_dev_footer"
                                    ),
                                    false
                                );?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="rn-footer-widget">
                        <div class="widget-menu-top">
                            <h4 class="title">Инструменты</h4>
                            <div class="inner">
                                <ul class="footer-link link-hover">
                                     <li><a href="/svgtodata/">SVG для кодирования URI данных</a></li>
                                    <!--<li><a href="#">Услуги SEO-специалиста</a></li>
                                    <li><a href="#">Коммерческое предложение</a></li>
                                    <li><a href="#">Разовая оптимизация</a></li> -->
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="rn-footer-widget">
                        <h4 class="title">Соц.сети</h4>
                        <div class="inner">
                            <h6 class="subtitle">подписаться</h6>
                            <ul class="social-icon social-default justify-content-start">
                                <li><a href="#">
                                        <i class="feather-facebook"></i>
                                    </a>
                                </li>
                                <li><a href="//www.instagram.com/lazarovstudio">
                                        <i class="feather-instagram"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div> -->
            </div>
        </div>
    </div>

    <div class="col-lg-12 col-md-12 col-12">
            <div class="address-content">
                <div>
                    <i class="fa-solid fa-earth-europe fa-xl"></i>
                    <span>Сочи, Россия</span>
                </div>
                <div>
                    <i class="fa-solid fa-phone fa-xl"></i>
                    <span><a rel='nofollow' href="tel:<?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH . "/includes/phone.php", [], ["SHOW_BORDER" => false]);?>"><? $APPLICATION->IncludeFile(SITE_TEMPLATE_PATH . "/includes/phone.php", [], array("MODE" => "text", "NAME" => "Телефон")); ?></a></span>
                </div>

                <ul class="social-icon social-default icon-naked">
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

</footer>
    <!-- Start Copy Right Area  -->
    <div class="copyright-area copyright-style-one">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                    <div class="copyright-left">
                        <ul class="ft-menu link-hover">
                            <li><a href="/politika-konfidentsialnosti/">Политика конфиденциальности</a></li>
                            <li><a href="/polzovatelskoe-soglashenie/">Пользовательское соглашение</a></li>
                            <li><a href="/contacts/">Контакты</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                    <div class="copyright-right text-center text-md-right">
                        <? 
                            $APPLICATION->IncludeFile(
                                SITE_DIR."include/copyright.php",
                            Array(),
                            Array("MODE"=>"html"));
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Copy Right Area  -->
</main>
<div class="rn-back-top"><i class="fa-solid fa-arrow-up"></i></div>

	<script>
		VANTA.GLOBE({
		  el: "#block3d",
		  mouseControls: true,
		  touchControls: true,
		  gyroControls: false,
		  minHeight: 200.00,
		  minWidth: 200.00,
		  scale: 1.00,
		  scaleMobile: 1.00,
		  size: 0.90,
		  color: 0xc231a1,
		  color2: 0xffffff,
		  backgroundColor: 0xf0f11
		});

        const btnMobileNav = document.querySelector('.mobile-menu-bar');
		const closeMobileNav = document.querySelector('.close-menu');
		const openbgNav = document.querySelector('.popup-mobile-menu');
		const openMobileNav = document.querySelector('.inner');
		
		if (btnMobileNav && openbgNav && openMobileNav) {
			const showMenu = () => {
				openbgNav.style.visibility = 'unset';
				openbgNav.style.opacity = '1';
				openMobileNav.style.left = '0';
				openMobileNav.style.opacity = '1';
			};
		
			const hideMenu = () => {
				openbgNav.style.visibility = 'hidden';
				openbgNav.style.opacity = '0';
				openMobileNav.style.left = '-150px';
				openMobileNav.style.opacity = '0';
			};
		
			btnMobileNav.addEventListener("click", showMenu);
			
			if (closeMobileNav) {
				closeMobileNav.addEventListener("click", hideMenu);
			}
		}
	</script>

<!-- Yandex.Metrika counter --> <script type="text/javascript" > (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)}; m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)}) (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym"); ym(51760934, "init", { clickmap:true, trackLinks:true, accurateTrackBounce:true, webvisor:true, trackHash:true, ecommerce:"dataLayer" }); </script> <noscript><div><img src="https://mc.yandex.ru/watch/51760934" style="position:absolute; left:-9999px;" alt="" /></div></noscript> <!-- /Yandex.Metrika counter -->
<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-5Z38NB9');</script>
<!-- End Google Tag Manager -->
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-5Z38NB9"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
<!-- Google tag (gtag.js) -->
<script async src="//www.googletagmanager.com/gtag/js?id=G-FXYTEYSQXB"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-FXYTEYSQXB');
</script>
<a rel='nofollow' href="//webmaster.yandex.ru/siteinfo/?site=https://lazarovstudio.ru">
    <img width="88" height="31" alt="" src="//yandex.ru/cycounter?https://lazarovstudio.ru&theme=dark&lang=ru"/>
</a>
</body>

<script>
    $(".phone").mask("+7(999)999-99-99");
    
</script>

</html>