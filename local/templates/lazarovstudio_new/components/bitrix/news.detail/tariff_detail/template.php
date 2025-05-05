<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
$tariffName = $arResult["NAME"];
$strTariffName = str_replace('&quot;', '', $tariffName);
?>
<div class="rwt-pricingtable-area rn-section-gap" id="<?=$this->GetEditAreaId($arResult['ID']);?>">
	<div class="container">
		
		<div class="row">
			<div class="col-lg-12">
				<div class="section-title text-center" >
					<?if($arParams["DISPLAY_NAME"]!="N" && $arResult["NAME"]):?>
						<h1 class="text-center"><span class="theme-gradient"><?echo $tariffName;?></span></h1>
					<?endif;?>
					<h2 class="subtitle w-600 mb--20"><?=$arResult["DISPLAY_PROPERTIES"]["ATTR_SUBTITLE"]["DISPLAY_VALUE"]?></h2>
				</div>
			</div>
		</div>

		<div class="row mt--30">
			<div class="col-md-12">
				<div class="advance-pricing">
					<div class="inner">
						<div class="row row--0">
							<div class="col-lg-6">

								<div class="pricing-left">
									<h3 class="main-title"><?echo $arResult["NAME"]?></h3>
									<p class="description"><?echo $arResult["PREVIEW_TEXT"];?></p>

									<div class="price-wrapper">
										<span class="price-amount">₽ <?=$arResult["DISPLAY_PROPERTIES"]["ATTR_PRICE_SUPPORT"]["DISPLAY_VALUE"]?> <sup>/месяц</sup></span>
									</div>
									<div class="pricing-btn-group">
										<a class="btn-default" href="#orderTariff">Оформить</a>
									</div>
								</div>
							</div>
							<div class="col-lg-6">
								<div class="pricing-right">
									<div class="pricing-offer">
										<div class="single-list">
											<h4 class="price-title">Техническое обслуживание:</h4>
											<ul class="plan-offer-list">
												<?=htmlspecialcharsBack($arResult["PROPERTIES"]["ATTR_DESC_TECH"]["VALUE"]["TEXT"])?>
											</ul>
										</div>
										<div class="single-list mt--40">
											<h4 class="price-title">Программирование и дизайн сайта:</h4>
											<ul class="plan-offer-list">
												<?=htmlspecialcharsBack($arResult["PROPERTIES"]["ATTR_DESC_PROG_DIS"]["VALUE"]["TEXT"])?>
											</ul>
										</div>
										<div class="single-list mt--40">
											<h4 class="price-title">Уровень сервиса и объем работ:</h4>
											<ul class="plan-offer-list">
												<?=htmlspecialcharsBack($arResult["PROPERTIES"]["ATTR_DESC_SERVICES_DEEP"]["VALUE"]["TEXT"])?>
											</ul>

										
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="rbt-separator-mid" id="orderTariff">
	<div class="container">
		<hr class="rbt-separator m-0">
	</div>
</div>
<!-- callBack --> <section class="rn-section-gapBottom">
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<div class="rn-comment-form pt--60">
					<div class="inner">
						<div class="section-title">
							<h2 class="title">Оформить <?echo $tariffName?></h2>
						</div>
						<?$APPLICATION->IncludeComponent("lazarovstudio:main.feedback", "template_order_tariff", Array(
							"AJAX_MODE" => "Y",
								"EMAIL_TO" => "lazarovstudio@ya.ru",	// E-mail, на который будет отправлено письмо
								"EVENT_MESSAGE_ID" => array(	// Почтовые шаблоны для отправки письма
									0 => "83",
								),
								"OK_TEXT" => "Спасибо, ваше сообщение принято.", // Сообщение, выводимое пользователю после отправки
								"TARIFF_TXT" => $strTariffName, // 
								"REQUIRED_FIELDS" => array(	// Обязательные поля для заполнения
									0 => "NAME",
									1 => "EMAIL",
									2 => "MESSAGE",
									3 => "PHONE",
									4 => "SITE",
									5 => "TARIFF"
								),
								"USE_CAPTCHA" => "Y",	// Использовать защиту от автоматических сообщений (CAPTCHA) для неавторизованных пользователей
							),
							false
						);?>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>