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
$cacheId = 'template_tabs_razrabotka_' . $arParams['SECTION_ID'] . '_' . $arParams['IBLOCK_ID'];
$cachePath = '/template_tabs_razrabotka/';

$obCache = new CPHPCache();

if($obCache->InitCache($cacheTime, $cacheId, $cachePath)) {
    $vars = $obCache->GetVars();
    $arSection = $vars['arSection'];
    $arItems = $vars['arItems'];
} else {
    $obCache->StartDataCache();

    // Get section data
    $arFilter = array(
        'IBLOCK_ID' => $arParams['IBLOCK_ID'],
        'ID' => $arParams['SECTION_ID']
    );
    $arSelect = array('ID', 'NAME', 'DESCRIPTION');
    
    $rsSect = CIBlockSection::GetList(
        array(),
        $arFilter,
        false,
        $arSelect
    );
    
    if($arSection = $rsSect->GetNext()) {
        // Get section items
        $arFilter = array(
            'IBLOCK_ID' => $arParams['IBLOCK_ID'],
            'SECTION_ID' => $arParams['SECTION_ID'],
            'ACTIVE' => 'Y'
        );
        $arSelect = array('ID', 'NAME', 'PREVIEW_TEXT', 'PREVIEW_PICTURE', 'DETAIL_TEXT', 'PROPERTY_*');
        
        $rsElements = CIBlockElement::GetList(
            array('SORT' => 'ASC'),
            $arFilter,
            false,
            false,
            $arSelect
        );
        
        $arItems = array();
        while($ob = $rsElements->GetNextElement()) {
            $arFields = $ob->GetFields();
            $arProps = $ob->GetProperties();
            
            // Process images
            if($arFields['PREVIEW_PICTURE']) {
                $arFields['PREVIEW_PICTURE'] = CFile::ResizeImageGet(
                    $arFields['PREVIEW_PICTURE'],
                    array('width' => 800, 'height' => 600),
                    BX_RESIZE_IMAGE_PROPORTIONAL,
                    true
                );
            }
            
            $arItems[] = array(
                'ID' => $arFields['ID'],
                'NAME' => $arFields['NAME'],
                'PREVIEW_TEXT' => $arFields['PREVIEW_TEXT'],
                'DETAIL_TEXT' => $arFields['DETAIL_TEXT'],
                'PREVIEW_PICTURE' => $arFields['PREVIEW_PICTURE'],
                'PROPERTIES' => $arProps
            );
        }
        
        // Save to cache
        $obCache->EndDataCache(array(
            'arSection' => $arSection,
            'arItems' => $arItems
        ));
    }
}
?>

<div class="rn-blog-details-area" itemscope itemtype="http://schema.org/Article">
    <div class="blog-details-content pt--60">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="content">
                        <div class="page-title">
                            <h1 class="title w-600 mb--20" itemprop="headline"><?=$arSection['NAME']?></h1>
                            <meta itemprop="datePublished" content="<?=date('c')?>">
                            <meta itemprop="dateModified" content="<?=date('c')?>">
                        </div>

                        <?if($arSection['DESCRIPTION']):?>
                            <div class="block_txt_info" itemprop="description">
                                <?=$arSection['DESCRIPTION']?>
                            </div>
                        <?endif?>

                        <?if(!empty($arItems)):?>
                            <div class="rwt-tab-area rn-section-gap">
                                <div class="container">
                                    <div class="row mb--20">
                                        <div class="col-lg-12">
                                            <div class="section-title text-center" role="tablist">
                                                <ul class="nav nav-tabs tab-button" role="tablist">
                                                    <?foreach($arItems as $key => $item):?>
                                                        <li class="nav-item" role="presentation">
                                                            <button 
                                                                class="nav-link <?=$key == 0 ? 'active' : ''?>" 
                                                                id="tab-<?=$item['ID']?>" 
                                                                data-bs-toggle="tab" 
                                                                data-bs-target="#tab-content-<?=$item['ID']?>" 
                                                                type="button" 
                                                                role="tab" 
                                                                aria-controls="tab-content-<?=$item['ID']?>" 
                                                                aria-selected="<?=$key == 0 ? 'true' : 'false'?>">
                                                                <?=$item['NAME']?>
                                                            </button>
                                                        </li>
                                                    <?endforeach?>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-content">
                                        <?foreach($arItems as $key => $item):?>
                                            <div 
                                                class="tab-pane fade <?=$key == 0 ? 'show active' : ''?>" 
                                                id="tab-content-<?=$item['ID']?>" 
                                                role="tabpanel" 
                                                aria-labelledby="tab-<?=$item['ID']?>">
                                                <div class="row row--30 align-items-center">
                                                    <?if($item['PREVIEW_PICTURE']):?>
                                                        <div class="col-lg-6">
                                                            <div class="thumbnail">
                                                                <img 
                                                                    src="<?=$item['PREVIEW_PICTURE']['src']?>" 
                                                                    alt="<?=$item['NAME']?>"
                                                                    width="<?=$item['PREVIEW_PICTURE']['width']?>"
                                                                    height="<?=$item['PREVIEW_PICTURE']['height']?>"
                                                                    loading="lazy"
                                                                    itemprop="image">
                                                            </div>
                                                        </div>
                                                    <?endif?>

                                                    <div class="col-lg-<?=$item['PREVIEW_PICTURE'] ? '6' : '12'?>">
                                                        <div class="rn-default-tab-content">
                                                            <?if($item['PREVIEW_TEXT']):?>
                                                                <div class="section-title" itemprop="articleBody">
                                                                    <?=$item['PREVIEW_TEXT']?>
                                                                </div>
                                                            <?endif?>

                                                            <?if($item['DETAIL_TEXT']):?>
                                                                <div class="tab-content-text" itemprop="articleBody">
                                                                    <?=$item['DETAIL_TEXT']?>
                                                                </div>
                                                            <?endif?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?endforeach?>
                                    </div>
                                </div>
                            </div>
                        <?endif?>
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
