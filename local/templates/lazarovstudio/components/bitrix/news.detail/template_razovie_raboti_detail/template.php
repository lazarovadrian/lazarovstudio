<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>


<?if($arParams["DISPLAY_PICTURE"]!="N" && is_array($arResult["DETAIL_PICTURE"])):?>
	<style>
		.bg_image--12 {background-image: url("<?=$arResult["DETAIL_PICTURE"]["SRC"];?>");}
	</style>
<?endif?>

        <div class="slider-area slider-style-1 variation-default height-850 bg_image bg_image--12" data-black-overlay="7">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-12 col-xl-12 order-2 order-lg-12 mt_md--40 mt_sm--40">
                        <div class="inner text-left">

							<?if($arParams["DISPLAY_NAME"]!="N" && $arResult["NAME"]):?>
								<h1 class="title display-one"><?=$arResult["NAME"]?></h1>
							<?endif;?>
                            
							<?if($arResult["PROPERTIES"]["ATTR_PRICE"]["VALUE"] != null):?>
                            	<span class="subtitle"><?=$arResult["PROPERTIES"]["ATTR_PRICE"]["VALUE"];?> ₽</span>
							<?endif;?>

                            <?if($arResult["PROPERTIES"]["ATTR_LIST_WORK"]["VALUE"] != null):?>
                                <ul class="list-icon">
                                    <?foreach($arResult["PROPERTIES"]["ATTR_LIST_WORK"]["VALUE"] as $key => $listWork):?>
                                    <li id="list_work_<?=$key?>">
                                        <span class="icon">
                                            <i class="feather-check"></i>
                                        </span>  
                                        <?=$listWork;?>
                                    </li>
                                    <?endforeach;?>
                                </ul>
                            <?endif;?>

                            <div class="button-group mt--40">
                            
                                <?if($arResult["PROPERTIES"]["ATTR_NAME_BTN_CALL"]["VALUE"]):?>
                                    <a class="btn-default btn-medium round btn-icon" target="_blank" href="tel:+79010048567"><?=$arResult["PROPERTIES"]["ATTR_NAME_BTN_CALL"]["VALUE"]?></a>
                                <?endif;?>

                                <?if($arResult["PROPERTIES"]["ATTR_NAME_BTN"]["VALUE"]):?>
                                    <a class="btn-default btn-medium btn-border round btn-icon" href="#contactform"><?=$arResult["PROPERTIES"]["ATTR_NAME_BTN"]["VALUE"]?></a></div>
                                <?endif;?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>

        <div class="blog-details-content pt--60">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 offset-lg-2">
                        <div class="content">
                            <div class="content_text">
                                <?=$arResult["DETAIL_TEXT"];?>
                            </div>

                            <!-- <div class="category-meta">
                                <span class="text">Tags:</span>
                                <div class="tagcloud">
                                    <a href="#">Corporate</a>
                                    <a href="#">Agency</a>
                                    <a href="#">Creative</a>
                                    <a href="#">Design</a>
                                    <a href="#">Minimal</a>
                                    <a href="#">Company</a>
                                    <a href="#">Development</a>
                                    <a href="#">App Landing</a>
                                    <a href="#">Startup</a>
                                    <a href="#">App</a>
                                    <a href="#">Business</a>
                                    <a href="#">Software</a>
                                    <a href="#">Landing</a>
                                    <a href="#">Art</a>
                                </div>
                            </div> -->
                            <div class="rbt-separator-mid" id="contactform">
                                <div class="container">
                                    <hr class="rbt-separator m-0">
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        
</div>