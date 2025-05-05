<?
$tariffName = $arResult["NAME"];
$strTariffName = str_replace('&quot;', '', $tariffName);
?>
<section class="rn-section-gapBottom">
<div class="container">
	<div class="row">
		<div class="col-sm-12">
			<div class="rn-comment-form pt--60">
				<div class="inner">
					<div class="section-title">
						<h2 class="title"><?=$strTariffName;?></h2>
					</div>
					 <?$APPLICATION->IncludeComponent("lazarovstudio:main.feedback", "template_order_one_work", Array(
						"AJAX_MODE" => "Y",
							"COMPONENT_TEMPLATE" => "template_order_tariff",
							"EMAIL_TO" => "lazarovstudio@ya.ru",	// E-mail, на который будет отправлено письмо
							"EVENT_MESSAGE_ID" => array(	// Почтовые шаблоны для отправки письма
								0 => "85",
							),
							"OK_TEXT" => "Спасибо, ваше сообщение принято.",	// Сообщение, выводимое пользователю после отправки
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
							"ONE_WORK_TXT" => ""
						),
						false
					);?>
				</div>
			</div>
		</div>
	</div>
</div>
</section>