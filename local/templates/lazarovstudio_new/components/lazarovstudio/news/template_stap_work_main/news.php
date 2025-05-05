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
$cacheId = 'template_stap_work_main_' . $arParams['SECTION_ID'] . '_' . $arParams['IBLOCK_ID'];
$cachePath = '/template_stap_work_main/';

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
        $arSelect = array('ID', 'NAME', 'PREVIEW_TEXT', 'PREVIEW_PICTURE', 'PROPERTY_*');
        
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
                            <div class="stap_list container">
                                <?foreach($arItems as $key => $item):?>
                                    <div class="stap_item" itemscope itemtype="http://schema.org/HowToStep">
                                        <?if($item['PREVIEW_PICTURE']):?>
                                            <div class="stap_item__img">
                                                <img 
                                                    src="<?=$item['PREVIEW_PICTURE']['src']?>" 
                                                    alt="<?=$item['NAME']?>"
                                                    width="<?=$item['PREVIEW_PICTURE']['width']?>"
                                                    height="<?=$item['PREVIEW_PICTURE']['height']?>"
                                                    loading="lazy"
                                                    itemprop="image">
                                            </div>
                                        <?endif?>

                                        <div class="stap_item__info">
                                            <p class="title" itemprop="name"><?=$item['NAME']?></p>
                                            <?if($item['PREVIEW_TEXT']):?>
                                                <p class="desc" itemprop="text"><?=$item['PREVIEW_TEXT']?></p>
                                            <?endif?>
                                            <?if($item['PROPERTIES']['ATTR_STAP']['VALUE']):?>
                                                <span class="step-number" itemprop="position"><?=$item['PROPERTIES']['ATTR_STAP']['VALUE']?></span>
                                            <?endif?>
                                        </div>
                                    </div>
                                <?endforeach?>
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

    // Add animation on scroll
    const stapItems = document.querySelectorAll('.stap_item');
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate');
                observer.unobserve(entry.target);
            }
        });
    }, {
        threshold: 0.1
    });

    stapItems.forEach(item => {
        observer.observe(item);
    });
});
</script>

<style>
.stap_item {
    opacity: 0;
    transform: translateY(20px);
    transition: opacity 0.6s ease-out, transform 0.6s ease-out;
}

.stap_item.animate {
    opacity: 1;
    transform: translateY(0);
}

.step-number {
    display: inline-block;
    width: 30px;
    height: 30px;
    line-height: 30px;
    text-align: center;
    border-radius: 50%;
    background-color: #007bff;
    color: #fff;
    margin-right: 10px;
}

@media (prefers-reduced-motion: reduce) {
    .stap_item {
        transition: none;
    }
}
</style>
