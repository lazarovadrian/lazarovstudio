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
?>
<?
	//выводит разделы фильтру указываем ID раздела и ID его инфоблока
	$arSections = Array();
	$arFilter = array('IBLOCK_ID' => $arParams['IBLOCK_ID'], 'ID'=>$arParams['SECTION_ID']);
	$arSelect = array('IBLOCK_ID', 'ID', 'NAME', 'CODE','DESCRIPTION','PREVIEW_PICTURE','UF_*');
	$rsSect = CIBlockSection::GetList(
		Array("SORT"=>"ASC"), //сортировка
		$arFilter, //фильтр (выше объявил)
		false, //выводить количество элементов - нет
		$arSelect //выборка вывода
	);
	while ($arSect = $rsSect->GetNext()) {
		$arSelFlds["ID"] = $arSect["ID"];
		$arSelFlds["NAME"] = $arSect["NAME"];
		$arSelFlds["CODE"] = $arSect["CODE"];
		$arSelFlds["DESCRIPTION"] = $arSect["DESCRIPTION"];
		$arSelFlds["SECTION_ACCARDION"] = $arSect["UF_COMPONENT_SECTION_ACCARDION"];
		$arSelFlds["TABS_SECTION"] = $arSect["UF_COMPONENT_TABS_SECTION"];
		$arSelFlds["STAP_WORK"] = $arSect["UF_COMPONENT_STAP_WORK_SECTION"];
		$arSelFlds["COMPONENT_ADV"] = $arSect["UF_COMPONENT_ADV"];
		$arSelFlds["PREVIEW_PICTURE"] = CFile::GetPath($arSect["PREVIEW_PICTURE"]);
		$arSections["SECTION"][] = $arSelFlds;
	}
?>

<?foreach($arSections["SECTION"] as $arItem):?>
	<!-- получаем разделы -->
	<?if($arItem["TABS_SECTION"] != null):?>
		<?$tabSection = CIBlockSection::GetByID($arItem["TABS_SECTION"])->GetNextElement()->GetFields();?>
	<?endif;?>
	<?if($arItem["SECTION_ACCARDION"] != null):?>
		<?$accardionSection = CIBlockSection::GetByID($arItem["SECTION_ACCARDION"])->GetNextElement()->GetFields();?>
	<?endif;?>
	<?if($arItem["STAP_WORK"] != null):?>
		<?$stapWorkSection = CIBlockSection::GetByID($arItem["STAP_WORK"])->GetNextElement()->GetFields();?>
	<?endif;?>
	<?if($arItem["COMPONENT_ADV"] != null):?>
		<?
		$arArraySectionAdv = Array();
		$arFilterSectionAdv = array('IBLOCK_ID' => 20, 'ID'=>$arItem["COMPONENT_ADV"]);
		$arSelectSectionAdv = array('ID','NAME','DESCRIPTION','UF_*');
		$rsSelectSectionAdv = CIBlockSection::GetList(
			Array(),//сортировка
			$arFilterSectionAdv, //фильтр (выше объявил)
			false, //выводить количество элементов - нет
			$arSelectSectionAdv //выборка вывода
		);
		while ($arSectionAdv = $rsSelectSectionAdv->GetNext()) {
			$arSelFldsT["ID"] = $arSectionAdv["ID"];
			$arSelFldsT["NAME"] = $arSectionAdv["NAME"];
			$arSelFldsT["PREVIEW_TEXT"] = $arSectionAdv["DESCRIPTION"];
			$arSelFldsT["DOP_TITLE"] = $arSectionAdv["UF_DOP_TITLE"];
			$arArraySectionAdv["SECTION_ADV"][] = $arSelFldsT;
		}
		$workSection = CIBlockSection::GetByID($arItem["COMPONENT_ADV"])->GetNextElement()->GetFields();
		?>
	<?endif;?>

	<!-- Получаем элементы компонента ТАБЫ -->
	<?if($tabSection["ID"] != null){
		$arItemTabs = Array();//массив для элементов
		$arFilter = Array('IBLOCK_ID'=>$tabSection["IBLOCK_ID"], 'GLOBAL_ACTIVE'=>'Y', 'SECTION_ID'=>$tabSection["ID"]);//фильтруем по нужному разделу
		$arSelect = Array("ID","ACTIVE","NAME","PREVIEW_PICTURE","PREVIEW_TEXT","PROPERTY_*");
		$res = CIBlockElement::GetList(Array("SORT"=>"ASC"), $arFilter, false, false, $arSelect);
		while($itemTabs = $res->GetNextElement()){
			$arTabFields = $itemTabs->GetFields();
			$arTabFlds["ID"] = $arTabFields["ID"];
			$arTabFlds["ACTIVE"] = $arTabFields["ACTIVE"];
			$arTabFlds["NAME"] = $arTabFields["NAME"];
			$arTabFlds["PICTURE"] = CFile::GetPath($arTabFields["PREVIEW_PICTURE"]);
			$arTabFlds["PREVIEW_TEXT"] = $arTabFields["PREVIEW_TEXT"];
			$arProps = $itemTabs->GetProperties();
			//добавляем все что выбрали выше
			$arItemTabs["ITEM_TAB"][] = $arTabFlds;
		}
	}?>
	<!-- Получаем элементы компонента аккардион -->
	<?if($accardionSection["ID"] != null){
		$arItemAccordion = Array();//массив для элементов
		$arFilter = Array('IBLOCK_ID'=>$accardionSection["IBLOCK_ID"], 'GLOBAL_ACTIVE'=>'Y', 'SECTION_ID'=>$accardionSection["ID"]);//фильтруем по нужному разделу
		$arSelect = Array("ID","ACTIVE","NAME","PREVIEW_PICTURE","PREVIEW_TEXT","PROPERTY_*");
		$res = CIBlockElement::GetList(Array("SORT"=>"ASC"), $arFilter, false, false, $arSelect);
		while($itemAccordion = $res->GetNextElement()){
			$arAccordionFields = $itemAccordion->GetFields();
			$arAccordionFlds["ID"] = $arAccordionFields["ID"];
			$arAccordionFlds["ACTIVE"] = $arAccordionFields["ACTIVE"];
			$arAccordionFlds["NAME"] = $arAccordionFields["NAME"];
			$arAccordionFlds["PICTURE"] = CFile::GetPath($arAccordionFields["PREVIEW_PICTURE"]);
			$arAccordionFlds["PREVIEW_TEXT"] = $arAccordionFields["PREVIEW_TEXT"];
			$arProps = $itemAccordion->GetProperties();
			//добавляем все что выбрали выше
			$arItemAccordion["ITEM_ACCARDION"][] = $arAccordionFlds;
		}
	}?>
	<!-- Получаем элементы компонента этапы работы -->
	<?if($stapWorkSection["ID"] != null){
		$arItemStapWork = Array();//массив для элементов
		$arFilter = Array('IBLOCK_ID'=>$stapWorkSection["IBLOCK_ID"], 'GLOBAL_ACTIVE'=>'Y', 'SECTION_ID'=>$stapWorkSection["ID"]);//фильтруем по нужному разделу
		$arSelect = Array("ID","ACTIVE","NAME","PREVIEW_PICTURE","PREVIEW_TEXT","PROPERTY_*");
		$res = CIBlockElement::GetList(Array("SORT"=>"ASC"), $arFilter, false, false, $arSelect);
		while($itemStapWork = $res->GetNextElement()){
			$arStapWorkFields = $itemStapWork->GetFields();
			$arStapWorkFlds["ID"] = $arStapWorkFields["ID"];
			$arStapWorkFlds["ACTIVE"] = $arStapWorkFields["ACTIVE"];
			$arStapWorkFlds["NAME"] = $arStapWorkFields["NAME"];
			$arStapWorkFlds["PICTURE"] = CFile::GetPath($arStapWorkFields["PREVIEW_PICTURE"]);
			$arStapWorkFlds["PREVIEW_TEXT"] = $arStapWorkFields["PREVIEW_TEXT"];
			$arProps = $itemStapWork->GetProperties();
			$arItemStapWork["ITEM_STAPWORK"][] = $arStapWorkFlds;
		}
	}?>
	<!-- Получаем элементы компонента этапы работы -->
	<?if($workSection["ID"] != null){
		$arItemWork = Array();//массив для элементов
		$arFilter = Array('IBLOCK_ID'=>$workSection["IBLOCK_ID"], 'GLOBAL_ACTIVE'=>'Y', 'SECTION_ID'=>$workSection["ID"]);//фильтруем по нужному разделу
		$arSelect = Array("ID","ACTIVE","NAME","PREVIEW_PICTURE","PREVIEW_TEXT","PROPERTY_*");
		$res = CIBlockElement::GetList(Array("SORT"=>"ASC"), $arFilter, false, false, $arSelect);
		while($itemStapWork = $res->GetNextElement()){
			$arStapWorkFields = $itemStapWork->GetFields();
			$arStapWorkFlds["ID"] = $arStapWorkFields["ID"];
			$arStapWorkFlds["ACTIVE"] = $arStapWorkFields["ACTIVE"];
			$arStapWorkFlds["NAME"] = $arStapWorkFields["NAME"];
			$arStapWorkFlds["PICTURE"] = CFile::GetPath($arStapWorkFields["PREVIEW_PICTURE"]);
			$arStapWorkFlds["PREVIEW_TEXT"] = $arStapWorkFields["PREVIEW_TEXT"];
			$arProps = $itemStapWork->GetProperties();
			$arStapWorkFlds["STAP"] = $arProps["ATTR_STAP"]["VALUE"];
			$arItemWork["ITEM_WORK"][] = $arStapWorkFlds;
		}
	}?>

<div class="rn-blog-details-area">
	<div class="blog-details-content pt--60">
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					<div class="content">

						<div class="page-title">						
							<h2 class="title w-600 mb--20"><?=$arItem["NAME"];?></h2>
						</div>

						<div class="block_txt_info">
							<?=$arItem["DESCRIPTION"];?>
						</div>

						<!-- Tabs -->
						<?if($tabSection["ACTIVE"] != "N"):?>
						<div class="rwt-tab-area">
							<div class="container">
								<div class="row mb--20">
									<div class="col-lg-12">
										<div class="section-title" >
											<h2 class="title w-600 mb--20"><?=$tabSection["NAME"];?></h2>
										</div>
									</div>
								</div>

								<div class="rbt-separator-mid">
									<div class="container">
										<hr class="rbt-separator m-0">
									</div>
								</div>

								<div class="row row row--30 align-items-center">
									<div class="col-lg-12 mt_md--40 mt_sm--40 order-2 order-lg-1">
										<div class="rn-default-tab">
											<ul class="nav nav-tabs tab-button" role="tablist">
											<?foreach($arItemTabs["ITEM_TAB"] as $keyTab => $tab):?>
												<?if($tab["ACTIVE"] != "N"):?>
													<li class="nav-item tabs__tab " role="presentation">
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
															<p>
																<?=$tabInfo["PREVIEW_TEXT"];?>
															</p>
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
						<section class="block_tariffs">
							<?$APPLICATION->IncludeComponent(
								"bitrix:news.list",
								"template_price_list",
								Array(
									"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
									"IBLOCK_ID" => $arParams["IBLOCK_ID"],
									"SECTION_ID" => $arParams["SECTION_ID"],//добавляем в шаблон id раздела
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
									"CACHE_TYPE" => $arParams["CACHE_TYPE"],
									"CACHE_TIME" => $arParams["CACHE_TIME"],
									"CACHE_FILTER" => $arParams["CACHE_FILTER"],
									"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
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
									"DISPLAY_NAME" => "Y",
									"DISPLAY_PICTURE" => $arParams["DISPLAY_PICTURE"],
									"DISPLAY_PREVIEW_TEXT" => $arParams["DISPLAY_PREVIEW_TEXT"],
									"PREVIEW_TRUNCATE_LEN" => $arParams["PREVIEW_TRUNCATE_LEN"],
									"ACTIVE_DATE_FORMAT" => $arParams["LIST_ACTIVE_DATE_FORMAT"],
									"USE_PERMISSIONS" => $arParams["USE_PERMISSIONS"],
									"GROUP_PERMISSIONS" => $arParams["GROUP_PERMISSIONS"],
									"FILTER_NAME" => $arParams["FILTER_NAME"],
									"HIDE_LINK_WHEN_NO_DETAIL" => $arParams["HIDE_LINK_WHEN_NO_DETAIL"],
									"CHECK_DATES" => $arParams["CHECK_DATES"],
								),
								$component
							);?>

						</section>

						<div class="content_text">
							<p class="title">Не нашли подходящий тариф?</p>
							<a class="desc" href="tel:+79010048567">Обсудим Вашу задачу и подберём решение -></a>
						</div>

						<?if($workSection["ACTIVE"] != "N"):?>
							<div class="section-title title_left">
								<?foreach($arArraySectionAdv["SECTION_ADV"] as $sectionAdv):?>
									<span><?=$sectionAdv["DOP_TITLE"];?></span>
									<p class="title"><?=$sectionAdv["NAME"];?></p>
									<p class="desc"><?=$sectionAdv["PREVIEW_TEXT"];?></p>
								<?endforeach?>
							</div>
							<div class="stap_list container">
								<?foreach($arItemWork["ITEM_WORK"] as $arItem):?>
									<div class="stap_item">
										<div class="stap_item__img">
											<img src="<?=$arItem["PICTURE"];?>" alt="">
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
						<?if($accardionSection["ACTIVE"] != "N"):?>
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
						<?if($arItemStapWork["ACTIVE"] != "N"):?>
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
<?endforeach;?>