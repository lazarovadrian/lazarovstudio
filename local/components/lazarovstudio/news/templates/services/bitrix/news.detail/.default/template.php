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
	<img class="img-span <?=($APPLICATION->GetCurPage() === "/kontekst/reklama-pod-klyuch/") ? "page-id-51" : ""?>" src="<?=$arResult["DISPLAY_PROPERTIES"]["ATTR_PROGRESS_BIG_IMG"]['FILE_VALUE']["SRC"];?>">
	<div class="top-section-content-wrap class=" style="background-image: url('<?=$arResult["DETAIL_PICTURE"]["SRC"]?>')">
		<div class="top-section-content">
			<p><?=$arResult["DETAIL_TEXT"];?></p>
			<a class="btn btn-brief" href="#">Получить коммерческое предложение</a>
		</div>
	</div>

	<section class="section">
		<div class="container container-wrap">
			<h2 class="top-section-content-title section-content-title"><?=$arResult['DISPLAY_PROPERTIES']['ATTR_PROGRESS_H1']['VALUE'];?></h2>
		
			<div class="progress">
				<?foreach($arResult["DISPLAY_PROPERTIES"]["ATTR_PROGRESS_TITLE"]["VALUE"] as $key => $arProgressTitle):?>
					<? $key++?>
					<div class="step">
						<div class="step-progress"></div>
						<div class="icon-wrapper">
							<svg class="icon icon-checkmark" viewBox="0 0 32 32"><path class="path1" d="M27 4l-15 15-7-7-5 5 12 12 20-20z"></path></svg>
							<div class="step-text">Шаг <?=$key;?></div>
						</div>
						<p class="step-progress-content"><?=$arProgressTitle;?></p>
					</div>
				<?endforeach;?>
			</div>
		
			<div class="step-list-bottom-wrap">
				<ul class="step-list-bottom">
					<?foreach($arResult["DISPLAY_PROPERTIES"]["ATTR_PROGRESS_DESC"]["VALUE"] as $arProgressDesc):?>
						<li class="step-list-bottom-item">
							<p><?=$arProgressDesc;?></p>
						</li>
					<?endforeach;?>
				</ul>
			</div>	

		</div>
	</section>

	<section class="section">
		<div class="container container-wrap">
			<h3 class="top-section-content-title section-content-title"><?=$arResult['DISPLAY_PROPERTIES']['ATTR_PROGRESS__NUMBER_H1']['VALUE'];?></h3>

				<ul class="section-process-of-creation-list">
					<?foreach($arResult["DISPLAY_PROPERTIES"]["ATTR_PROGRESS__NUMBER_TITLE"]["VALUE"] as $key => $arProgressNumberTitle):?>
						<li class="section-process-of-creation-list__item">
							<span><?=$arProgressNumberTitle;?></span>
						</li>
					<?endforeach;?>
				</ul>
				
				<div class="step-list-bottom-wrap">
					<ul class="step-list-bottom">
					<?foreach($arResult["DISPLAY_PROPERTIES"]["ATTR_PROGRESS__NUMBER_DESC"]["VALUE"] as $arProgressNumberDesc):?>
						<li class="step-list-bottom-item">
							<p><?=$arProgressNumberDesc;?></p>
						</li>
					<?endforeach;?>
					</ul>
				</div>
		</div>
  </section>