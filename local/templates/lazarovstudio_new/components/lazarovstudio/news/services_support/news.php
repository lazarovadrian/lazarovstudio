<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */

$this->setFrameMode(true);

// Cache settings
$cacheTime = 3600; // 1 hour
$cacheId = 'services_support_' . $arParams['SECTION_ID'] . '_' . $arParams['IBLOCK_ID'];
$cachePath = '/services_support/';

$obCache = new CPHPCache();

if($obCache->InitCache($cacheTime, $cacheId, $cachePath)) {
    $vars = $obCache->GetVars();
    $arSection = $vars['arSection'];
    $tabSection = $vars['tabSection'];
    $accardionSection = $vars['accardionSection'];
    $stapWorkSection = $vars['stapWorkSection'];
    $workSection = $vars['workSection'];
    $arItemTabs = $vars['arItemTabs'];
    $arItemAccordion = $vars['arItemAccordion'];
    $arItemStapWork = $vars['arItemStapWork'];
    $arItemWork = $vars['arItemWork'];
} else {
    $obCache->StartDataCache();

    // Функция для получения данных раздела с оптимизацией запросов
    function getSectionData($sectionId, $iblockId) {
        if (!$sectionId || !$iblockId) return null;
        
        static $sections = array();
        if (isset($sections[$sectionId])) {
            return $sections[$sectionId];
        }
        
        $arFilter = array('IBLOCK_ID' => $iblockId, 'ID' => $sectionId);
        $arSelect = array('IBLOCK_ID', 'ID', 'NAME', 'CODE', 'DESCRIPTION', 'PREVIEW_PICTURE', 'UF_*');
        
        $rsSect = CIBlockSection::GetList(
            array("SORT" => "ASC"),
            $arFilter,
            false,
            $arSelect
        );
        
        if ($arSect = $rsSect->GetNext()) {
            $sections[$sectionId] = array(
                "ID" => $arSect["ID"],
                "NAME" => $arSect["NAME"],
                "CODE" => $arSect["CODE"],
                "DESCRIPTION" => $arSect["DESCRIPTION"],
                "SECTION_ACCARDION" => $arSect["UF_COMPONENT_SECTION_ACCARDION"],
                "TABS_SECTION" => $arSect["UF_COMPONENT_TABS_SECTION"],
                "STAP_WORK" => $arSect["UF_COMPONENT_STAP_WORK_SECTION"],
                "COMPONENT_ADV" => $arSect["UF_COMPONENT_ADV"],
                "PREVIEW_PICTURE" => CFile::GetPath($arSect["PREVIEW_PICTURE"])
            );
            return $sections[$sectionId];
        }
        return null;
    }

    // Функция для получения элементов раздела с оптимизацией запросов
    function getSectionElements($sectionId, $iblockId) {
        if (!$sectionId || !$iblockId) return array();
        
        static $elements = array();
        $cacheKey = $sectionId . '_' . $iblockId;
        
        if (isset($elements[$cacheKey])) {
            return $elements[$cacheKey];
        }
        
        $arItems = array();
        $arFilter = array(
            'IBLOCK_ID' => $iblockId,
            'GLOBAL_ACTIVE' => 'Y',
            'SECTION_ID' => $sectionId
        );
        $arSelect = array("ID", "ACTIVE", "NAME", "PREVIEW_PICTURE", "PREVIEW_TEXT", "PROPERTY_*");
        
        $res = CIBlockElement::GetList(
            array("SORT" => "ASC"),
            $arFilter,
            false,
            false,
            $arSelect
        );
        
        while ($item = $res->GetNextElement()) {
            $arFields = $item->GetFields();
            $arProps = $item->GetProperties();
            
            $arItems[] = array(
                "ID" => $arFields["ID"],
                "ACTIVE" => $arFields["ACTIVE"],
                "NAME" => $arFields["NAME"],
                "PICTURE" => CFile::GetPath($arFields["PREVIEW_PICTURE"]),
                "PREVIEW_TEXT" => $arFields["PREVIEW_TEXT"],
                "PROPERTIES" => $arProps
            );
        }
        
        $elements[$cacheKey] = $arItems;
        return $arItems;
    }

    // Получаем данные основного раздела
    $arSection = getSectionData($arParams['SECTION_ID'], $arParams['IBLOCK_ID']);

    // Получаем данные связанных разделов
    $tabSection = $arSection["TABS_SECTION"] ? getSectionData($arSection["TABS_SECTION"], $arParams['IBLOCK_ID']) : null;
    $accardionSection = $arSection["SECTION_ACCARDION"] ? getSectionData($arSection["SECTION_ACCARDION"], $arParams['IBLOCK_ID']) : null;
    $stapWorkSection = $arSection["STAP_WORK"] ? getSectionData($arSection["STAP_WORK"], $arParams['IBLOCK_ID']) : null;
    $workSection = $arSection["COMPONENT_ADV"] ? getSectionData($arSection["COMPONENT_ADV"], 20) : null;

    // Получаем элементы связанных разделов
    $arItemTabs = $tabSection ? array("ITEM_TAB" => getSectionElements($tabSection["ID"], $tabSection["IBLOCK_ID"])) : array();
    $arItemAccordion = $accardionSection ? array("ITEM_ACCARDION" => getSectionElements($accardionSection["ID"], $accardionSection["IBLOCK_ID"])) : array();
    $arItemStapWork = $stapWorkSection ? array("ITEM_STAPWORK" => getSectionElements($stapWorkSection["ID"], $stapWorkSection["IBLOCK_ID"])) : array();
    $arItemWork = $workSection ? array("ITEM_WORK" => getSectionElements($workSection["ID"], $workSection["IBLOCK_ID"])) : array();

    // Save data to cache
    $obCache->EndDataCache(array(
        'arSection' => $arSection,
        'tabSection' => $tabSection,
        'accardionSection' => $accardionSection,
        'stapWorkSection' => $stapWorkSection,
        'workSection' => $workSection,
        'arItemTabs' => $arItemTabs,
        'arItemAccordion' => $arItemAccordion,
        'arItemStapWork' => $arItemStapWork,
        'arItemWork' => $arItemWork
    ));
}
?>

<div class="rn-blog-details-area" itemscope itemtype="http://schema.org/Article">
	<div class="blog-details-content pt--60">
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					<div class="content">
						<div class="page-title">						
							<h1 class="title w-600 mb--20" itemprop="headline"><?=$arSection["NAME"];?></h1>
							<meta itemprop="datePublished" content="<?=date('c')?>">
							<meta itemprop="dateModified" content="<?=date('c')?>">
						</div>

						<div class="block_txt_info" itemprop="articleBody">
							<?=$arSection["DESCRIPTION"];?>
						</div>

						<!-- Tabs -->
						<?if($tabSection && $tabSection["ACTIVE"] != "N"):?>
						<div class="rwt-tab-area">
							<div class="container">
								<div class="row mb--20">
									<div class="col-lg-12">
										<div class="section-title">
											<h2 class="title w-600 mb--20"><?=$tabSection["NAME"];?></h2>
										</div>
									</div>
								</div>

								<div class="rbt-separator-mid">
									<div class="container">
										<hr class="rbt-separator m-0">
									</div>
								</div>

								<div class="row row--30 align-items-center">
									<div class="col-lg-12 mt_md--40 mt_sm--40 order-2 order-lg-1">
										<div class="rn-default-tab" role="tablist">
											<ul class="nav nav-tabs tab-button" role="tablist">
											<?foreach($arItemTabs["ITEM_TAB"] as $keyTab => $tab):?>
												<?if($tab["ACTIVE"] != "N"):?>
													<li class="nav-item tabs__tab" role="presentation">
														<button 
															class="nav-link <?=$keyTab == 0 ? "active" : "" ?>" 
															id="tab-<?=$keyTab;?>" 
															data-bs-toggle="tab" 
															data-bs-target="#idTab-<?=$keyTab;?>" 
															type="button" 
															role="tab" 
															aria-controls="idTab-<?=$keyTab;?>" 
															aria-selected="<?=$keyTab == 0 ? "true" : "false" ?>">
															<?=$tab["NAME"];?>
														</button>
													</li>
												<?endif;?>
											<?endforeach;?>
											</ul>
											<div class="rn-tab-content tab-content">
												<?foreach($arItemTabs["ITEM_TAB"] as $keyTab => $tabInfo):?>
													<?if($tabInfo["ACTIVE"] != "N"):?>
														<div 
															class="tab-pane fade <?=$keyTab == 0 ? "show active" : "" ?>" 
															id="idTab-<?=$keyTab;?>" 
															role="tabpanel" 
															aria-labelledby="tab-<?=$keyTab;?>">
															<div itemprop="articleSection">
																<?=$tabInfo["PREVIEW_TEXT"];?>
															</div>
														</div>
													<?endif;?>
												<?endforeach;?>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<?endif;?>

						<h3 class="center">Тарифы поддержки сайта</h3>
						<section class="block_tariffs" itemscope itemtype="http://schema.org/Offer">
							<?$APPLICATION->IncludeComponent(
								"bitrix:news.list",
								"template_price_list",
								array(
									"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
									"IBLOCK_ID" => $arParams["IBLOCK_ID"],
									"SECTION_ID" => $arParams["SECTION_ID"],
									"NEWS_COUNT" => $arParams["NEWS_COUNT"],
									"SORT_BY1" => $arParams["SORT_BY1"],
									"SORT_ORDER1" => $arParams["SORT_ORDER1"],
									"SORT_BY2" => $arParams["SORT_BY2"],
									"SORT_ORDER2" => $arParams["SORT_ORDER2"],
									"FIELD_CODE" => $arParams["LIST_FIELD_CODE"],
									"PROPERTY_CODE" => $arParams["LIST_PROPERTY_CODE"],
									"DETAIL_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["detail"],
									"SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
									"IBLOCK_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["news"],
									"DISPLAY_PANEL" => $arParams["DISPLAY_PANEL"],
									"SET_TITLE" => $arParams["SET_TITLE"],
									"SET_LAST_MODIFIED" => $arParams["SET_LAST_MODIFIED"],
									"MESSAGE_404" => $arParams["MESSAGE_404"],
									"SET_STATUS_404" => $arParams["SET_STATUS_404"],
									"SHOW_404" => $arParams["SHOW_404"],
									"FILE_404" => $arParams["FILE_404"],
									"INCLUDE_IBLOCK_INTO_CHAIN" => $arParams["INCLUDE_IBLOCK_INTO_CHAIN"],
									"CACHE_TYPE" => "A",
									"CACHE_TIME" => "3600",
									"CACHE_FILTER" => "Y",
									"CACHE_GROUPS" => "Y",
									"DISPLAY_TOP_PAGER" => $arParams["DISPLAY_TOP_PAGER"],
									"DISPLAY_BOTTOM_PAGER" => $arParams["DISPLAY_BOTTOM_PAGER"],
									"PAGER_TITLE" => $arParams["PAGER_TITLE"],
									"PAGER_TEMPLATE" => $arParams["PAGER_TEMPLATE"],
									"PAGER_SHOW_ALWAYS" => $arParams["PAGER_SHOW_ALWAYS"],
									"PAGER_DESC_NUMBERING" => $arParams["PAGER_DESC_NUMBERING"],
									"PAGER_DESC_NUMBERING_CACHE_TIME" => $arParams["PAGER_DESC_NUMBERING_CACHE_TIME"],
									"PAGER_SHOW_ALL" => $arParams["PAGER_SHOW_ALL"],
									"PAGER_BASE_LINK_ENABLE" => $arParams["PAGER_BASE_LINK_ENABLE"],
									"PAGER_BASE_LINK" => $arParams["PAGER_BASE_LINK"],
									"PAGER_PARAMS_NAME" => $arParams["PAGER_PARAMS_NAME"],
									"DISPLAY_DATE" => $arParams["DISPLAY_DATE"],
									"DISPLAY_NAME" => $arParams["DISPLAY_NAME"],
									"DISPLAY_PICTURE" => $arParams["DISPLAY_PICTURE"],
									"DISPLAY_PREVIEW_TEXT" => $arParams["DISPLAY_PREVIEW_TEXT"],
									"PREVIEW_TRUNCATE_LEN" => $arParams["PREVIEW_TRUNCATE_LEN"],
									"ACTIVE_DATE_FORMAT" => $arParams["LIST_ACTIVE_DATE_FORMAT"],
									"USE_PERMISSIONS" => $arParams["USE_PERMISSIONS"],
									"GROUP_PERMISSIONS" => $arParams["GROUP_PERMISSIONS"],
									"FILTER_NAME" => $arParams["FILTER_NAME"],
									"HIDE_LINK_WHEN_NO_DETAIL" => $arParams["HIDE_LINK_WHEN_NO_DETAIL"],
									"CHECK_DATES" => $arParams["CHECK_DATES"]
								),
								$component
							);?>
						</section>

						<div class="content_text">
							<p class="title">Не нашли подходящий тариф?</p>
							<a class="desc" href="tel:+79010048567" aria-label="Позвонить для обсуждения тарифа">Обсудим Вашу задачу и подберём решение -></a>
						</div>

						<?if($workSection && $workSection["ACTIVE"] != "N"):?>
							<div class="section-title title_left">
								<?foreach($arItemWork["ITEM_WORK"] as $arItem):?>
									<span><?=$arItem["PROPERTIES"]["ATTR_STAP"]["VALUE"];?></span>
									<p class="title"><?=$arItem["NAME"];?></p>
									<p class="desc"><?=$arItem["PREVIEW_TEXT"];?></p>
								<?endforeach?>
							</div>
							<div class="stap_list container">
								<?foreach($arItemWork["ITEM_WORK"] as $arItem):?>
									<div class="stap_item">
										<div class="stap_item__img">
											<img src="<?=$arItem["PICTURE"];?>" 
												 alt="<?=$arItem["NAME"]?>"
												 loading="lazy"
												 width="150"
												 height="150">
										</div>
										<div class="stap_item__info">
											<p class="title"><?=$arItem["NAME"]?></p>
											<?if($arParams["DISPLAY_PREVIEW_TEXT"]!="N" && $arItem["PREVIEW_TEXT"]):?>
												<p class="desc"><?=$arItem["PREVIEW_TEXT"];?></p>
											<?endif;?>
										</div>
									</div>
								<?endforeach;?>
							</div>
						<?endif;?>

						<div class="block_txt_warning">
							<blockquote class="txt_warning">
								<?$APPLICATION->IncludeComponent(
									"bitrix:main.include",
									"",
									Array(
										"AREA_FILE_SHOW" => "file",
										"AREA_FILE_SUFFIX" => "inc",
										"COMPOSITE_FRAME_MODE" => "A",
										"COMPOSITE_FRAME_TYPE" => "AUTO",
										"EDIT_TEMPLATE" => "",
										"PATH" => "/include/warningMessTwo.php"
									)
								);?>
							</blockquote>
						</div>

						<?$APPLICATION->IncludeComponent(
							"bitrix:form.result.new",
							"callback_banner_support_page",
							Array(
								"AJAX_MODE" => "Y",
								"AJAX_OPTION_HISTORY" => "N",
								"AJAX_OPTION_JUMP" => "N",
								"AJAX_OPTION_SHADOW" => "N",
								"AJAX_OPTION_STYLE" => "Y",
								"CACHE_TIME" => "0",
								"CACHE_TYPE" => "N",
								"CHAIN_ITEM_LINK" => "",
								"CHAIN_ITEM_TEXT" => "",
								"COMPOSITE_FRAME_MODE" => "A",
								"COMPOSITE_FRAME_TYPE" => "AUTO",
								"EDIT_URL" => "",
								"IGNORE_CUSTOM_TEMPLATE" => "N",
								"LIST_URL" => "",
								"SEF_MODE" => "N",
								"SUCCESS_URL" => "",
								"USE_EXTENDED_ERRORS" => "N",
								"VARIABLE_ALIASES" => array("RESULT_ID"=>"","WEB_FORM_ID"=>"",),
								"WEB_FORM_ID" => "3"
							)
						);?>

						<div class="section-footer">
							<div class="infoFooter">
								<p>Проведу проверку всего Вашего проекта, расскажу как исправить ошибки и оптимизировать сайт</p>
							</div>

							<div class="author_block">
								<img src="/upload/iblock/c9a/ttf4kyv5xv56iw3shmykps9clwcb7wt8.png">
								<div class="author_block_info">
									<p class="title" >Лазаров Адриан</p>
									<p class="desc">Senior разработчик</p>
								</div>
							</div>
						</div>

						<!-- Accordion -->
						<?if($accardionSection && $accardionSection["ACTIVE"] != "N"):?>
							<div class="rn-accordion-area">
								<div class="container">
									<div class="row">
										<div class="col-lg-12">
											<div class="section-title" >
												<h2 class="title w-600 mb--20"><?=$accardionSection["NAME"];?></h2>
											</div>
										</div>
									</div>
									<div class="row mt--35 row--20">
										<div class="col-lg-12">
											<div class="rn-accordion-style rn-accordion-04 accordion">
												<div class="accordion" id="accordionExampled">
													<?foreach($arItemAccordion["ITEM_ACCARDION"] as $key => $accardion):?>
														<?if($accardion["ACTIVE"] != "N"):?>
															<div class="accordion-item card">
																<h2 class="accordion-header card-header" id="heading<?=$key?>">
																	<button class="accordion-button <?=$key == 0 ? "" : "collapsed" ?>" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?=$key;?>" aria-expanded="<?=$key == 0 ? "true" : "false" ?>" aria-controls="collapse<?=$key;?>"><?=$accardion["NAME"];?></button>
																</h2>
																<div id="collapse<?=$key;?>" class="accordion-collapse collapse <?=$key == 0 ? "show" : "" ?>" aria-labelledby="heading<?=$key?>" data-bs-parent="#accordionExampled">
																	<div class="accordion-body card-body">
																		<ul class="list">
																			<?=$accardion["PREVIEW_TEXT"];?>
																		</ul>
																	</div>
																</div>
															</div>
														<?endif;?>
													<?endforeach;?>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						<?endif;?>
						<!-- End Accordion-4 Area  -->

						<div class="block_txt_warning">
							<blockquote class="txt_warning">
								<?$APPLICATION->IncludeComponent(
									"bitrix:main.include",
									"",
									Array(
										"AREA_FILE_SHOW" => "file",
										"AREA_FILE_SUFFIX" => "inc",
										"COMPOSITE_FRAME_MODE" => "A",
										"COMPOSITE_FRAME_TYPE" => "AUTO",
										"EDIT_TEMPLATE" => "",
										"PATH" => "/include/warningMessOne.php"
									)
								);?>
							</blockquote>
						</div>

						<div class="content">
							<p>
								<!-- <?$APPLICATION->IncludeComponent(
									"bitrix:main.include",
									"",
									Array(
										"AREA_FILE_SHOW" => "file",
										"AREA_FILE_SUFFIX" => "inc",
										"COMPOSITE_FRAME_MODE" => "A",
										"COMPOSITE_FRAME_TYPE" => "AUTO",
										"EDIT_TEMPLATE" => "",
										"PATH" => "/include/seoTxt.php"
									)
								);?> -->
							</p>
						</div>

						<!-- Start Service-6 Area  -->
						<?if($stapWorkSection && $arItemStapWork["ITEM_STAPWORK"]):?>
							<div class="rn-service-area">
								<div class="container">
									<div class="row">
										<div class="col-lg-12">
											<div class="section-title" >
												<h2 class="title w-600 mb--20 rem4"><?=$stapWorkSection["NAME"];?></h2>
												<p class="description b1"><?=$stapWorkSection["DESCRIPTION"];?></p>
											</div>
										</div>
									</div>
									<div class="row row--15 service-wrapper">
										<?foreach($arItemStapWork["ITEM_STAPWORK"] as $key => $itemStapWork):?>
											<?if($itemStapWork["ACTIVE"] != "N"):?>
												<div class="stapWorkWidth col-lg-3 col-md-6 col-sm-6 col-12" >
													<div class="service service__style--1 icon-circle-style with-working-process">
														<div class="icon">
															<div class="line"></div><?=$key +1;?>
														</div>
														<div class="content">
															<h4 class="title"><?=$itemStapWork["NAME"];?></h4>
															<p class="description b1 color-gray mb--0"><?=$itemStapWork["PREVIEW_TEXT"];?></p>
														</div>
													</div>
												</div>
											<?endif;?>
										<?endforeach;?>
									</div>
								</div>
							</div>
						<?endif;?>
						<!-- End Service-6 Area  -->
					

						<div class="content">
							<p>
								<?$APPLICATION->IncludeComponent(
									"bitrix:main.include",
									"",
									Array(
										"AREA_FILE_SHOW" => "file",
										"AREA_FILE_SUFFIX" => "inc",
										"COMPOSITE_FRAME_MODE" => "A",
										"COMPOSITE_FRAME_TYPE" => "AUTO",
										"EDIT_TEMPLATE" => "",
										"PATH" => "/include/seoTxtOne.php"
									)
								);?>
							</p>
						</div>

					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
	// Lazy loading for images
	if ('loading' in HTMLImageElement.prototype) {
		const images = document.querySelectorAll('img[loading="lazy"]');
		images.forEach(img => {
			img.src = img.dataset.src;
		});
	} else {
		// Fallback for browsers that don't support lazy loading
		const script = document.createElement('script');
		script.src = 'https://cdnjs.cloudflare.com/ajax/libs/lazysizes/5.3.2/lazysizes.min.js';
		document.body.appendChild(script);
	}

	// Initialize tabs with keyboard navigation
	const tabButtons = document.querySelectorAll('[role="tab"]');
	const tabPanels = document.querySelectorAll('[role="tabpanel"]');

	tabButtons.forEach(button => {
		button.addEventListener('keydown', e => {
			const targetButton = e.target;
			const buttonContainer = targetButton.parentElement.parentElement;
			const buttons = [...buttonContainer.querySelectorAll('[role="tab"]')];

			let index = buttons.indexOf(targetButton);
			let newIndex;

			switch (e.key) {
				case 'ArrowLeft':
					newIndex = index - 1;
					break;
				case 'ArrowRight':
					newIndex = index + 1;
					break;
				default:
					return;
			}

			if (newIndex < 0) {
				newIndex = buttons.length - 1;
			} else if (newIndex >= buttons.length) {
				newIndex = 0;
			}

			buttons[newIndex].click();
			buttons[newIndex].focus();
			e.preventDefault();
		});
	});
});
</script>