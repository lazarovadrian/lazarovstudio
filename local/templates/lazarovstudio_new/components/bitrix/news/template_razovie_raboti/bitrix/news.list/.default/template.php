<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<div class="breadcarumb-style-1 ptb--120">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<div class="inner pt--80 text-center">
					<div>
						<h1 class="title display-one rn-sub-badge-h1"><span class="theme-gradient"><?$APPLICATION->ShowTitle(false);?></span></h1>
					</div>
					<p class="description"><?$APPLICATION->ShowProperty('description');?></p>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="main-content">
	<div class="rn-blog-area rn-section-gap">
		<div class="container">
			<div class="row mt_dec--30">
				<div class="col-lg-12">
					<div class="row row--15">
							<?foreach($arResult["ITEMS"] as $arItem):?>
								<?
								$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_EDIT"));
								$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('NEWS_DELETE_CONFIRM')));
								?>

								<div class="col-lg-6 mt--30" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
									<div class="rn-card box-card-style-default card-list-view">
										<div class="inner">
											<div class="content">
												
												<h4 class="title">
													<a href="<?=$arItem["DETAIL_PAGE_URL"]?>"><?=$arItem["NAME"]?></a>
												</h4>

												<?if($arParams["DISPLAY_PREVIEW_TEXT"]!="N" && $arItem["PREVIEW_TEXT"]):?>
													<p class="descriptiion"><?=$arItem["PREVIEW_TEXT"];?></p>
												<?endif;?>

												<div class="pricing-btn-group">
													<a class="btn-default" href="<?=$arItem["DETAIL_PAGE_URL"]?>">Подробнее</a>
												</div>

											</div>
										</div>
									</div>
								</div>

							<?endforeach;?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>