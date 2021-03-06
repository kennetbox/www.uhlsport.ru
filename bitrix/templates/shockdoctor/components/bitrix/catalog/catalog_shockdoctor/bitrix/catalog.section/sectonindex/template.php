<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();
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

global $current_top_menu;
?>

<?
$arFilter = array(
    "IBLOCK_ID" => $arParams["IBLOCK_ID"],
    "ACTIVE" => "Y",
    "GLOBAL_ACTIVE" => "Y",
);
if (0 < intval($arResult["VARIABLES"]["SECTION_ID"])) {
    $arFilter["ID"] = $arResult["VARIABLES"]["SECTION_ID"];
} elseif ('' != $arResult["VARIABLES"]["SECTION_CODE"]) {
    $arFilter["=CODE"] = $arResult["VARIABLES"]["SECTION_CODE"];
}

$obCache = new CPHPCache();
if ($obCache->InitCache(36000, serialize($arFilter), "/iblock/catalog")) {
    $arCurSection = $obCache->GetVars();
} elseif ($obCache->StartDataCache()) {
    $arCurSection = array();
    if (\Bitrix\Main\Loader::includeModule("iblock")) {
        $dbRes = CIBlockSection::GetList(array(), $arFilter, false, array("ID"));

        if (defined("BX_COMP_MANAGED_CACHE")) {
            global $CACHE_MANAGER;
            $CACHE_MANAGER->StartTagCache("/iblock/catalog");

            if ($arCurSection = $dbRes->Fetch()) {
                $CACHE_MANAGER->RegisterTag("iblock_id_" . $arParams["IBLOCK_ID"]);
            }
            $CACHE_MANAGER->EndTagCache();
        } else {
            if (!$arCurSection = $dbRes->Fetch())
                $arCurSection = array();
        }
    }
    $obCache->EndDataCache($arCurSection);
}
if (!isset($arCurSection)) {
    $arCurSection = array();
}

$count = count($arResult['ITEMS']);
$forms = array('товар', 'товара', 'товаров');

function sklonenie($n, $forms) {
    return $n % 10 == 1 && $n % 100 != 11 ? $forms[0] : ($n % 10 >= 2 && $n % 10 <= 4 && ($n % 100 < 10 || $n % 100 >= 20) ? $forms[1] : $forms[2]);
}
?>

<div class="main list-product">
    <div class="list-header">
        <div class="list-header-contents">
            <div class="category-list-title">
                <h1>Показать все <?
                    if (isset($current_top_menu) && !empty($current_top_menu)) {
                        echo $current_top_menu;
                    }
                    ?>:</h1>
                <h2><strong class="digit"><?= $count ?></strong> <?= sklonenie($count, $forms) ?></h2>
            </div>
            <div class="toolbar">
                <div class="sorter">
                    <?
                    $requestUri = $_SERVER['REQUEST_URI'];
                    $requestUriArr = explode('?', $requestUri);
                    $uriArr = Array();
                    $arrLevel1 = explode('&', $requestUriArr[1]);
                    foreach ($arrLevel1 as $key => $val) {
                        $arrLevel2 = explode('=', $val);
                        $uriArr[$key] = $arrLevel2;
                    }
                    $priceSortUri = array();
                    foreach ($uriArr as $key => $val) {
                        if (
                                $val[0] != 'sort' &&
                                $val[0] != 'order'
                        ) {
                            $priceSortUri[$key] = $val[0] . "=" . $val[1];
                        }
                    }

                    $printSortUri = (count($priceSortUri) > 0) ? implode('&', $priceSortUri) : '';

                    $printSortUrl = array();
                    $amp = ($printSortUri == '') ? "" : "&";
                    $printSortUrl[] = $requestUriArr[0] . "?" . $printSortUri . $amp . "sort=BASE&order=DESC";
                    $printSortUrl[] = $requestUriArr[0] . "?" . $printSortUri . $amp . "sort=BASE&order=ASC";
                    ?>
                    <h2>
                        <label>Сортировать:</label>
                        <select onchange="setLocation(this.value)">
                            <option></option>
                            <option <? if (isset($_REQUEST["sort"]) && $_REQUEST["sort"] == 'BASE' && isset($_REQUEST["order"]) && $_REQUEST["order"] == 'DESC') { ?>selected<? } ?> value="<?= $printSortUrl[0] ?>">Цена по убыванию</option>
                            <option <? if (isset($_REQUEST["sort"]) && $_REQUEST["sort"] == 'BASE' && isset($_REQUEST["order"]) && $_REQUEST["order"] == 'ASC') { ?>selected<? } ?> value="<?= $printSortUrl[1] ?>">Цена по возрастанию</option>
                            <!--
                                                        <option value="https://www.shockdoctor.com/products/performance-sports-therapy/all?dir=desc&amp;order=rank_qty">Хиты продаж</option>
                            -->
                        </select>
                    </h2>
                </div>
            </div>
        </div>
    </div> <!-- end list-header -->

    <div class="list-contents">
        <div class="list-products">
            <div class="list-products category-products">



                <?
                if (!empty($arResult['ITEMS'])) {
                    $templateData = array(
                        'TEMPLATE_THEME' => $this->GetFolder() . '/themes/' . $arParams['TEMPLATE_THEME'] . '/style.css',
                        'TEMPLATE_CLASS' => 'bx_' . $arParams['TEMPLATE_THEME']
                    );

                    $arSkuTemplate = array();
                    if (!empty($arResult['SKU_PROPS'])) {
                        foreach ($arResult['SKU_PROPS'] as &$arProp) {
                            $templateRow = '';
                            if ('TEXT' == $arProp['SHOW_MODE']) {

                                if (5 < $arProp['VALUES_COUNT']) {
                                    $strClass = 'bx_item_detail_size full';
                                    $strWidth = ($arProp['VALUES_COUNT'] * 20) . '%';
                                    $strOneWidth = (100 / $arProp['VALUES_COUNT']) . '%';
                                    $strSlideStyle = '';
                                } else {
                                    $strClass = 'bx_item_detail_size';
                                    $strWidth = '100%';
                                    $strOneWidth = '20%';
                                    $strSlideStyle = 'display: none;';
                                }
                                $templateRow .= '<div class="' . $strClass . '" id="#ITEM#_prop_' . $arProp['ID'] . '_cont">';

                                //$templateRow .= '<span class="bx_item_section_name_gray">'.htmlspecialcharsex($arProp['NAME']).'</span>';

                                $templateRow .= '<div class="bx_size_scroller_container"><div class="bx_size"><ul id="#ITEM#_prop_' . $arProp['ID'] . '_list" style="width: ' . $strWidth . ';">';
                                foreach ($arProp['VALUES'] as $arOneValue) {
                                    $arOneValue['NAME'] = htmlspecialcharsbx($arOneValue['NAME']);
                                    $templateRow .= '<li data-treevalue="' . $arProp['ID'] . '_' . $arOneValue['ID'] . '" data-onevalue="' . $arOneValue['ID'] . '" style="width: ' . $strOneWidth . ';" title="' . $arOneValue['NAME'] . '"><i></i><span class="cnt">' . $arOneValue['NAME'] . '</span></li>';
                                }
                                $templateRow .= '</ul></div>';
                                $templateRow .= '<div class="bx_slide_left" id="#ITEM#_prop_' . $arProp['ID'] . '_left" data-treevalue="' . $arProp['ID'] . '" style="' . $strSlideStyle . '"></div>';
                                $templateRow .= '<div class="bx_slide_right" id="#ITEM#_prop_' . $arProp['ID'] . '_right" data-treevalue="' . $arProp['ID'] . '" style="' . $strSlideStyle . '"></div>';
                                $templateRow .= '</div></div>';
                            } elseif ('PICT' == $arProp['SHOW_MODE']) {
                                if (5 < $arProp['VALUES_COUNT']) {
                                    $strClass = 'bx_item_detail_scu full';
                                    $strWidth = ($arProp['VALUES_COUNT'] * 20) . '%';
                                    $strOneWidth = (100 / $arProp['VALUES_COUNT']) . '%';
                                    $strSlideStyle = '';
                                } else {
                                    $strClass = 'bx_item_detail_scu';
                                    $strWidth = '100%';
                                    $strOneWidth = '20%';
                                    $strSlideStyle = 'display: none;';
                                }
                                $templateRow .= '<div class="' . $strClass . '" id="#ITEM#_prop_' . $arProp['ID'] . '_cont">';

                                // $templateRow .= '<span class="bx_item_section_name_gray">'.htmlspecialcharsex($arProp['NAME']).'</span>';

                                $templateRow .= '<div class="bx_scu_scroller_container">';

                                $templateRow .= '<div class="bx_scu">';
                                $templateRow .= '<ul id="#ITEM#_prop_' . $arProp['ID'] . '_list" class="swatches">';
                                foreach ($arProp['VALUES'] as $arOneValue) {
                                    $arOneValue['NAME'] = htmlspecialcharsbx($arOneValue['NAME']);
                                    $templateRow .= '<li data-treevalue="' . $arProp['ID'] . '_' . $arOneValue['ID'] . '" data-onevalue="' . $arOneValue['ID'] . '" style="width: ' . $strOneWidth . '; padding-top: ' . $strOneWidth . ';"><i title="' . $arOneValue['NAME'] . '"></i>';
                                    $templateRow .= '<em>';
                                    $templateRow .= '<span style="background-image:url(\'' . $arOneValue['PICT']['SRC'] . '\');" title="' . $arOneValue['NAME'] . '"></span>';
                                    //$templateRow .= '<span><img class="cnt_item" src="'.$arOneValue['PICT']['SRC'].'" alt="'.$arOneValue['NAME'].'" /></span>';
                                    $templateRow .= '</em>';
                                    $templateRow .= '</li>';
                                }
                                $templateRow .= '</ul>';
                                $templateRow .= '</div>';

                                $templateRow .= '<div class="bx_slide_left" id="#ITEM#_prop_' . $arProp['ID'] . '_left" data-treevalue="' . $arProp['ID'] . '" style="' . $strSlideStyle . '"></div>';
                                $templateRow .= '<div class="bx_slide_right" id="#ITEM#_prop_' . $arProp['ID'] . '_right" data-treevalue="' . $arProp['ID'] . '" style="' . $strSlideStyle . '"></div>';

                                $templateRow .= '</div>';
                                $templateRow .= '</div>';
                            }
                            $arSkuTemplate[$arProp['CODE']] = $templateRow;
                        }
                        unset($templateRow, $arProp);
                    }

                    if ($arParams["DISPLAY_TOP_PAGER"]) {
                        ?><? echo $arResult["NAV_STRING"]; ?><?
                    }

                    $strElementEdit = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_EDIT");
                    $strElementDelete = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_DELETE");
                    $arElementDeleteParams = array("CONFIRM" => GetMessage('CT_BCS_TPL_ELEMENT_DELETE_CONFIRM'));
                    ?>

                    <?
                    foreach ($arResult['ITEMS'] as $key => $arItem) {

                        $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], $strElementEdit);
                        $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], $strElementDelete, $arElementDeleteParams);
                        $strMainID = $this->GetEditAreaId($arItem['ID']);

                        $arItemIDs = array(
                            'ID' => $strMainID,
                            'PICT' => $strMainID . '_pict',
                            'SECOND_PICT' => $strMainID . '_secondpict',
                            'STICKER_ID' => $strMainID . '_sticker',
                            'SECOND_STICKER_ID' => $strMainID . '_secondsticker',
                            'QUANTITY' => $strMainID . '_quantity',
                            'QUANTITY_DOWN' => $strMainID . '_quant_down',
                            'QUANTITY_UP' => $strMainID . '_quant_up',
                            'QUANTITY_MEASURE' => $strMainID . '_quant_measure',
                            'BUY_LINK' => $strMainID . '_buy_link',
                            'SUBSCRIBE_LINK' => $strMainID . '_subscribe',
                            'PRICE' => $strMainID . '_price',
                            'DSC_PERC' => $strMainID . '_dsc_perc',
                            'SECOND_DSC_PERC' => $strMainID . '_second_dsc_perc',
                            'PROP_DIV' => $strMainID . '_sku_tree',
                            'PROP' => $strMainID . '_prop_',
                            'DISPLAY_PROP_DIV' => $strMainID . '_sku_prop',
                            'BASKET_PROP_DIV' => $strMainID . '_basket_prop',
                        );

                        $strObName = 'ob' . preg_replace("/[^a-zA-Z0-9_]/", "x", $strMainID);

                        $productTitle = (
                                isset($arItem['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE']) && $arItem['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE'] != '' ? $arItem['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE'] : $arItem['NAME']
                                );
                        $imgTitle = (
                                isset($arItem['IPROPERTY_VALUES']['ELEMENT_PREVIEW_PICTURE_FILE_TITLE']) && $arItem['IPROPERTY_VALUES']['ELEMENT_PREVIEW_PICTURE_FILE_TITLE'] != '' ? $arItem['IPROPERTY_VALUES']['ELEMENT_PREVIEW_PICTURE_FILE_TITLE'] : $arItem['NAME']
                                );
                        ?>

                        <?
                        // $arItem['IBLOCK_SECTION_ID'];
                        $res = CIBlockSection::GetByID($arItem['IBLOCK_SECTION_ID']);
                        if ($ar_res = $res->GetNext()) {
                            $sectionCode = $ar_res['CODE'];
                        }
                        $elementHref = '/catalog/' . $sectionCode . '/' . $arItem['CODE'] . '/';
                        ?>

                        <div class="grouped-product">

                            <a class="bx_catalog_item_images" href="<? echo $elementHref; //$arItem['DETAIL_PAGE_URL'];                  ?>" alt="<? echo $imgTitle; ?>">

                                <div class="<? echo ($arItem['SECOND_PICT'] ? 'bx_catalog_item double' : 'bx_catalog_item'); ?>">
                                    <div class="bx_catalog_item_container" id="<? echo $strMainID; ?>">
                                        <? if ($arItem["PROPERTIES"]["NEWPRODUCT"]["VALUE"] === 'да') { ?>
                                            <span class="new">New</span>
                                        <? } ?>

                                        <?
                                        $file = CFile::ResizeImageGet($arItem["PREVIEW_PICTURE"]["ID"], array('width' => 190, 'height' => 145), BX_RESIZE_IMAGE_PROPORTIONAL, true);
                                        $img = $file["src"];
                                        echo '<img height="145" width="190" style="background: transparent url(' . $img . ') no-repeat 50% 50%;" src="/images/empty.gif" alt="" />';
                                        echo '<img id="' . $arItemIDs['PICT'] . '" src="/images/empty.gif" style="display: none;" alt="" />';
                                        ?>

                                        <?
                                        if ('Y' == $arParams['PRODUCT_DISPLAY_MODE']) {
                                            if (!empty($arItem['OFFERS_PROP'])) {
                                                $arSkuProps = array();
                                                ?>


                                                <div class="bx_catalog_item_scu" id="<? echo $arItemIDs['PROP_DIV']; ?>">
                                                    <?
                                                    foreach ($arSkuTemplate as $code => $strTemplate) {
                                                        if (!isset($arItem['OFFERS_PROP'][$code]))
                                                            continue;
                                                        if ($code == 'COLOR_REF') {
                                                            echo '<div>', str_replace('#ITEM#_prop_', $arItemIDs['PROP'], $strTemplate), '</div>';
                                                        } else {
                                                            echo '<div class="dnone">', str_replace('#ITEM#_prop_', $arItemIDs['PROP'], $strTemplate), '</div>';
                                                        }
                                                    }
                                                    foreach ($arResult['SKU_PROPS'] as $arOneProp) {
                                                        if (!isset($arItem['OFFERS_PROP'][$arOneProp['CODE']]))
                                                            continue;
                                                        $arSkuProps[] = array(
                                                            'ID' => $arOneProp['ID'],
                                                            'SHOW_MODE' => $arOneProp['SHOW_MODE'],
                                                            'VALUES_COUNT' => $arOneProp['VALUES_COUNT']
                                                        );
                                                    }
                                                    foreach ($arItem['JS_OFFERS'] as &$arOneJs) {
                                                        if (0 < $arOneJs['PRICE']['DISCOUNT_DIFF_PERCENT'])
                                                            $arOneJs['PRICE']['DISCOUNT_DIFF_PERCENT'] = '-' . $arOneJs['PRICE']['DISCOUNT_DIFF_PERCENT'] . '%';
                                                    }
                                                    unset($arOneJs);
                                                    ?>
                                                </div>

                                                <?
                                                if ($arItem['OFFERS_PROPS_DISPLAY']) {
                                                    foreach ($arItem['JS_OFFERS'] as $keyOffer => $arJSOffer) {
                                                        $strProps = '';
                                                        if (!empty($arJSOffer['DISPLAY_PROPERTIES'])) {
                                                            foreach ($arJSOffer['DISPLAY_PROPERTIES'] as $arOneProp) {
                                                                $strProps .= '<br>' . $arOneProp['NAME'] . ' <strong>' . (
                                                                        is_array($arOneProp['VALUE']) ? implode(' / ', $arOneProp['VALUE']) : $arOneProp['VALUE']
                                                                        ) . '</strong>';
                                                            }
                                                        }
                                                        $arItem['JS_OFFERS'][$keyOffer]['DISPLAY_PROPERTIES'] = $strProps;
                                                    }
                                                }
                                                $arJSParams = array(
                                                    'PRODUCT_TYPE' => $arItem['CATALOG_TYPE'],
                                                    'SHOW_QUANTITY' => $arParams['USE_PRODUCT_QUANTITY'],
                                                    'SHOW_ADD_BASKET_BTN' => false,
                                                    'SHOW_BUY_BTN' => true,
                                                    'SHOW_ABSENT' => true,
                                                    'SHOW_SKU_PROPS' => $arItem['OFFERS_PROPS_DISPLAY'],
                                                    'SECOND_PICT' => $arItem['SECOND_PICT'],
                                                    'SHOW_OLD_PRICE' => ('Y' == $arParams['SHOW_OLD_PRICE']),
                                                    'SHOW_DISCOUNT_PERCENT' => ('Y' == $arParams['SHOW_DISCOUNT_PERCENT']),
                                                    'DEFAULT_PICTURE' => array(
                                                        'PICTURE' => $arItem['PRODUCT_PREVIEW'],
                                                        'PICTURE_SECOND' => $arItem['PRODUCT_PREVIEW_SECOND']
                                                    ),
                                                    'VISUAL' => array(
                                                        'ID' => $arItemIDs['ID'],
                                                        'PICT_ID' => $arItemIDs['PICT'],
                                                        'SECOND_PICT_ID' => $arItemIDs['SECOND_PICT'],
                                                        'QUANTITY_ID' => $arItemIDs['QUANTITY'],
                                                        'QUANTITY_UP_ID' => $arItemIDs['QUANTITY_UP'],
                                                        'QUANTITY_DOWN_ID' => $arItemIDs['QUANTITY_DOWN'],
                                                        'QUANTITY_MEASURE' => $arItemIDs['QUANTITY_MEASURE'],
                                                        'PRICE_ID' => $arItemIDs['PRICE'],
                                                        'TREE_ID' => $arItemIDs['PROP_DIV'],
                                                        'TREE_ITEM_ID' => $arItemIDs['PROP'],
                                                        'BUY_ID' => $arItemIDs['BUY_LINK'],
                                                        'ADD_BASKET_ID' => $arItemIDs['ADD_BASKET_ID'],
                                                        'DSC_PERC' => $arItemIDs['DSC_PERC'],
                                                        'SECOND_DSC_PERC' => $arItemIDs['SECOND_DSC_PERC'],
                                                        'DISPLAY_PROP_DIV' => $arItemIDs['DISPLAY_PROP_DIV'],
                                                    ),
                                                    'BASKET' => array(
                                                        'QUANTITY' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
                                                        'PROPS' => $arParams['PRODUCT_PROPS_VARIABLE'],
                                                        'SKU_PROPS' => $arItem['OFFERS_PROP_CODES']
                                                    ),
                                                    'PRODUCT' => array(
                                                        'ID' => $arItem['ID'],
                                                        'NAME' => $productTitle
                                                    ),
                                                    'OFFERS' => $arItem['JS_OFFERS'],
                                                    'OFFER_SELECTED' => $arItem['OFFERS_SELECTED'],
                                                    'TREE_PROPS' => $arSkuProps,
                                                    'LAST_ELEMENT' => $arItem['LAST_ELEMENT']
                                                );
                                                ?>
                                                <script type="text/javascript">
                                                    var <? echo $strObName; ?> = new JCCatalogSection(<? echo CUtil::PhpToJSObject($arJSParams, false, true); ?>);
                                                </script>
                                                <?
                                            }
                                        }
                                        ?>

                                        <h3 class="product-name"><? echo $productTitle; ?></h3>

                                        <div class="bx_catalog_item_price">
                                            <h4>
                                                <span itemtype="http://schema.org/Offer" itemscope="" class="price-box">

                                                    <?
                                                    if (
                                                            !empty($arItem["OFFERS"][0]["PROPERTIES"]["OLD_PRICE"]["VALUE"]) &&
                                                            $arItem["OFFERS"][0]["PROPERTIES"]["OLD_PRICE"]["VALUE"] > 0
                                                    /*
                                                      &&
                                                      $arItem["SECTION"]["CODE"] == 'sale'
                                                     */
                                                    ) {
                                                        ?>
                                                        <span class="old-price">
                                                            <em class="price">
                                                                <?= $arItem["OFFERS"][0]["PROPERTIES"]["OLD_PRICE"]["VALUE"] ?> руб.
                                                            </em>
                                                        </span>
                                                    <? } ?>

                                                    <span id="product-price-<?= $arItem['ID'] ?>" itemprop="price" class="regular-price">

                                                        <span id="<? echo $arItemIDs['PRICE']; ?>" class="bx_price price">

                                                            <?
                                                            if (!empty($arItem['MIN_PRICE'])) {
                                                                if ('N' == $arParams['PRODUCT_DISPLAY_MODE'] && isset($arItem['OFFERS']) && !empty($arItem['OFFERS'])) {
                                                                    echo GetMessage(
                                                                            'CT_BCS_TPL_MESS_PRICE_SIMPLE_MODE', array(
                                                                        '#PRICE#' => $arItem['MIN_PRICE']['PRINT_DISCOUNT_VALUE'],
                                                                        '#MEASURE#' => GetMessage(
                                                                                'CT_BCS_TPL_MESS_MEASURE_SIMPLE_MODE', array(
                                                                            '#VALUE#' => $arItem['MIN_PRICE']['CATALOG_MEASURE_RATIO'],
                                                                            '#UNIT#' => $arItem['MIN_PRICE']['CATALOG_MEASURE_NAME']
                                                                                )
                                                                        )
                                                                            )
                                                                    );
                                                                } else {
                                                                    echo $arItem['MIN_PRICE']['PRINT_DISCOUNT_VALUE'];
                                                                }
                                                                if ('Y' == $arParams['SHOW_OLD_PRICE'] && $arItem['MIN_PRICE']['DISCOUNT_VALUE'] < $arItem['MIN_PRICE']['VALUE']) {
                                                                    ?> <? echo $arItem['MIN_PRICE']['PRINT_VALUE']; ?><?
                                                                }
                                                            }
                                                            ?>

                                                        </span>
                                                    </span>
                                                </span>
                                            </h4>	
                                        </div>


                                        <?
                                        if (!isset($arItem['OFFERS']) || empty($arItem['OFFERS'])) {
                                            ?>

                                            <?
                                            $emptyProductProperties = empty($arItem['PRODUCT_PROPERTIES']);

                                            $arJSParams = array(
                                                'PRODUCT_TYPE' => $arItem['CATALOG_TYPE'],
                                                'SHOW_QUANTITY' => $arParams['USE_PRODUCT_QUANTITY'],
                                                'SHOW_ADD_BASKET_BTN' => false,
                                                'SHOW_BUY_BTN' => true,
                                                'SHOW_ABSENT' => true,
                                                'PRODUCT' => array(
                                                    'ID' => $arItem['ID'],
                                                    'NAME' => $productTitle,
                                                    'PICT' => ('Y' == $arItem['SECOND_PICT'] ? $arItem['PREVIEW_PICTURE_SECOND'] : $arItem['PREVIEW_PICTURE']),
                                                    'CAN_BUY' => $arItem["CAN_BUY"],
                                                    'SUBSCRIPTION' => ('Y' == $arItem['CATALOG_SUBSCRIPTION']),
                                                    'CHECK_QUANTITY' => $arItem['CHECK_QUANTITY'],
                                                    'MAX_QUANTITY' => $arItem['CATALOG_QUANTITY'],
                                                    'STEP_QUANTITY' => $arItem['CATALOG_MEASURE_RATIO'],
                                                    'QUANTITY_FLOAT' => is_double($arItem['CATALOG_MEASURE_RATIO']),
                                                    'ADD_URL' => $arItem['~ADD_URL'],
                                                    'SUBSCRIBE_URL' => $arItem['~SUBSCRIBE_URL']
                                                ),
                                                'BASKET' => array(
                                                    'ADD_PROPS' => ('Y' == $arParams['ADD_PROPERTIES_TO_BASKET']),
                                                    'QUANTITY' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
                                                    'PROPS' => $arParams['PRODUCT_PROPS_VARIABLE'],
                                                    'EMPTY_PROPS' => $emptyProductProperties
                                                ),
                                                'VISUAL' => array(
                                                    'ID' => $arItemIDs['ID'],
                                                    'PICT_ID' => ('Y' == $arItem['SECOND_PICT'] ? $arItemIDs['SECOND_PICT'] : $arItemIDs['PICT']),
                                                    'QUANTITY_ID' => $arItemIDs['QUANTITY'],
                                                    'QUANTITY_UP_ID' => $arItemIDs['QUANTITY_UP'],
                                                    'QUANTITY_DOWN_ID' => $arItemIDs['QUANTITY_DOWN'],
                                                    'PRICE_ID' => $arItemIDs['PRICE'],
                                                    'BUY_ID' => $arItemIDs['BUY_LINK'],
                                                    'BASKET_PROP_DIV' => $arItemIDs['BASKET_PROP_DIV']
                                                ),
                                                'LAST_ELEMENT' => $arItem['LAST_ELEMENT']
                                            );
                                            unset($emptyProductProperties);
                                            ?>
                                            <script type="text/javascript">
                                                var <? echo $strObName; ?> = new JCCatalogSection(<? echo CUtil::PhpToJSObject($arJSParams, false, true); ?>);
                                            </script>

                                            <?
                                        } else {

                                            $boolShowOfferProps = ('Y' == $arParams['PRODUCT_DISPLAY_MODE'] && $arItem['OFFERS_PROPS_DISPLAY']);
                                            $boolShowProductProps = (isset($arItem['DISPLAY_PROPERTIES']) && !empty($arItem['DISPLAY_PROPERTIES']));
                                            if ($boolShowProductProps || $boolShowOfferProps) {
                                                ?>

                                                <? /* Остальные свойства товара, кроме цвета
                                                  <div class="bx_catalog_item_articul">
                                                  <?
                                                  if ($boolShowProductProps)
                                                  {
                                                  foreach ($arItem['DISPLAY_PROPERTIES'] as $arOneProp)
                                                  {
                                                  ?><br><strong><? echo $arOneProp['NAME']; ?></strong> <?
                                                  echo (
                                                  is_array($arOneProp['DISPLAY_VALUE'])
                                                  ? implode(' / ', $arOneProp['DISPLAY_VALUE'])
                                                  : $arOneProp['DISPLAY_VALUE']
                                                  );
                                                  }
                                                  }
                                                  if ($boolShowOfferProps)
                                                  {
                                                  ?>
                                                  <span id="<? echo $arItemIDs['DISPLAY_PROP_DIV']; ?>" style="display: none;"></span>
                                                  <?
                                                  }
                                                  ?>
                                                  </div>
                                                 */ ?>

                                                <?
                                            }
                                        }
                                        ?>

                                    </div>

                                </div>
                            </a>
                        </div><!-- [end grouped-product] -->

                        <? if ($key > 0 && ($key + 1) % 3 == 0) { ?>
                            <div class="cleaner"></div>
                        <? } ?>

                        <?
                    }
                    ?>


                    <script type="text/javascript">
                        BX.message({
                            MESS_BTN_BUY: '<? echo ('' != $arParams['MESS_BTN_BUY'] ? CUtil::JSEscape($arParams['MESS_BTN_BUY']) : GetMessageJS('CT_BCS_TPL_MESS_BTN_BUY')); ?>',
                            MESS_BTN_ADD_TO_BASKET: '<? echo ('' != $arParams['MESS_BTN_ADD_TO_BASKET'] ? CUtil::JSEscape($arParams['MESS_BTN_ADD_TO_BASKET']) : GetMessageJS('CT_BCS_TPL_MESS_BTN_ADD_TO_BASKET')); ?>',
                            MESS_NOT_AVAILABLE: '<? echo ('' != $arParams['MESS_NOT_AVAILABLE'] ? CUtil::JSEscape($arParams['MESS_NOT_AVAILABLE']) : GetMessageJS('CT_BCS_TPL_MESS_PRODUCT_NOT_AVAILABLE')); ?>',
                            BTN_MESSAGE_BASKET_REDIRECT: '<? echo GetMessageJS('CT_BCS_CATALOG_BTN_MESSAGE_BASKET_REDIRECT'); ?>',
                            BASKET_URL: '<? echo $arParams["BASKET_URL"]; ?>',
                            ADD_TO_BASKET_OK: '<? echo GetMessageJS('ADD_TO_BASKET_OK'); ?>',
                            TITLE_ERROR: '<? echo GetMessageJS('CT_BCS_CATALOG_TITLE_ERROR') ?>',
                            TITLE_BASKET_PROPS: '<? echo GetMessageJS('CT_BCS_CATALOG_TITLE_BASKET_PROPS') ?>',
                            TITLE_SUCCESSFUL: '<? echo GetMessageJS('ADD_TO_BASKET_OK'); ?>',
                            BASKET_UNKNOWN_ERROR: '<? echo GetMessageJS('CT_BCS_CATALOG_BASKET_UNKNOWN_ERROR') ?>',
                            BTN_MESSAGE_SEND_PROPS: '<? echo GetMessageJS('CT_BCS_CATALOG_BTN_MESSAGE_SEND_PROPS'); ?>',
                            BTN_MESSAGE_CLOSE: '<? echo GetMessageJS('CT_BCS_CATALOG_BTN_MESSAGE_CLOSE') ?>'
                        });
                    </script>
                    <?
                    if ($arParams["DISPLAY_BOTTOM_PAGER"]) {
                        ?><? echo $arResult["NAV_STRING"]; ?><?
                    }
                }
                ?>

            </div> <!-- end list-products 2 -->
        </div> <!-- end list-products -->

        <div class="list-toolbar" style="">

            <?
//            global $arrFilter;
//
//            $APPLICATION->IncludeComponent(
//                    "bitrix:catalog.smart.filter", "visual_vertical_shockdoctor", Array(
//                "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
//                "IBLOCK_ID" => $arParams["IBLOCK_ID"],
//                "SECTION_ID" => $arResult['ID'], // $arCurSection['ID'],
//                "FILTER_NAME" => $arParams["FILTER_NAME"],
//                "PRICE_CODE" => $arParams["PRICE_CODE"],
//                "CACHE_TYPE" => "N",
//                "CACHE_TIME" => "0",
//                "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
//                "SAVE_IN_SESSION" => "N",
//                "XML_EXPORT" => "Y",
//                "SECTION_TITLE" => "NAME",
//                "SECTION_DESCRIPTION" => "DESCRIPTION",
//                'HIDE_NOT_AVAILABLE' => $arParams["HIDE_NOT_AVAILABLE"],
//                "TEMPLATE_THEME" => $arParams["TEMPLATE_THEME"]
//                    ), $component, array('HIDE_ICONS' => 'Y')
//            );
            // LEEFT
            Leeft\Utils::newFilter($arResult['ID']);
            ?>
        </div> <!-- end list-toolbar -->

    </div> <!-- end list-contents -->
</div>



