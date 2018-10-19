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

// Убираем вариант показа промежуточной страницы
if (!isset($_REQUEST['SHOW']) || $_REQUEST['SHOW'] != 'all') {
    $_REQUEST['SHOW'] = 'all';
}
?>

<? // [Вывод верхнего баннера в подразделе "Каталога"] ?>
<?
$uri = $APPLICATION->GetCurUri(); //."index.php";
$dir = $APPLICATION->GetCurDir(false);

$IBLOCK_ID = (!isset($_REQUEST['SHOW']) && $_REQUEST['SHOW'] != 'all') ? 21 : 22; // Инфоблок "полноразмерный баннер вверху страницы"
$arSelect = Array("ID", "IBLOCK_ID", "NAME", "DATE_ACTIVE_FROM", "DETAIL_TEXT", "DETAIL_TEXT_TYPE", "DETAIL_PICTURE", "PROPERTY_*"); //IBLOCK_ID и ID обязательно должны быть указаны, см. описание arSelectFields выше
if ($dir == '/') {
    $arFilter = Array("IBLOCK_ID" => IntVal($IBLOCK_ID), "ACTIVE_DATE" => "Y", "ACTIVE" => "Y", "PROPERTY_CONNECT_TO_URL" => "" . $dir . "");
} else {
    $arFilter = Array("IBLOCK_ID" => IntVal($IBLOCK_ID), "ACTIVE_DATE" => "Y", "ACTIVE" => "Y", "PROPERTY_CONNECT_TO_URL" => "" . $dir . "%");
}
$res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize" => 10), $arSelect);
$listTopBanners = array();
while ($ob = $res->GetNextElement()) {

    $arFields = $ob->GetFields();
    $arProps = $ob->GetProperties();

    $listTopBanners[] = array(
        "ID" => $arFields["ID"],
        "NAME" => $arFields["NAME"],
        "TEXT" => $arFields["DETAIL_TEXT"],
        "DETAIL_TEXT_TYPE" => $arFields["DETAIL_TEXT_TYPE"],
        "DETAIL_PICTURE" => $arFields["DETAIL_PICTURE"],
        "LINK" => $arProps["LINK"]["VALUE"],
            // "FIRST_BANNER" => $arProps["FIRST_BANNER"]["VALUE"],
            // "SECOND_BANNER" => $arProps["SECOND_BANNER"]["VALUE"],
            // "THREE_BANNER" => $arProps["THREE_BANNER"]["VALUE"],
            // "BUTTON_HTML" => $arProps["BUTTON_HTML"]["VALUE"],
    );
}
?>
<? if (count($listTopBanners) > 0) { ?>


    <? if (count($listTopBanners) > 1) { ?>
        <div class="product-slider">
            <div class="product-slider-slides product-slider-mouthguards">
                <? foreach ($listTopBanners as $key => $val) { ?>
                    <div id="banner-<?= ($key + 1) ?>" class="product-slider-slide">
                        <? if ($val[TEXT] != '') { ?>
                            <?
                            if ('html' == $val['DETAIL_TEXT_TYPE']) {
                                echo $val["TEXT"];
                            } else {
                                ?><p><? echo $val["TEXT"]; ?></p><?
                            }
                            ?>
                        <? } else { ?>
                            <a <? if ($val["LINK"] != '') { ?>href="<?= $val["LINK"] ?>"<? } ?>><?= $val["TEXT"] ?></a>
                        <? } ?>
                    </div>
                <? } ?>
            </div> <!-- end product-slider-slides -->
            <div class="slider-nav">
                <ul>
                    <? foreach ($listTopBanners as $key => $val) { ?>
                        <li><a href="#banner-<?= ($key + 1) ?>">Slide 1</a></li>
                    <? } ?>
                </ul>
            </div>
        </div> <!-- end product-slider -->
    <? } else { ?>
        <div class="category-list-feature mouthguards-list-feature">
            <? foreach ($listTopBanners as $key => $val) { ?>
                <div id="banner-<?= ($key + 1) ?>" class="product-slider-slide">
                    <? if ($val[TEXT] != '') { ?>
                        <?
                        if ('html' == $val['DETAIL_TEXT_TYPE']) {
                            echo $val["TEXT"];
                        } else {
                            ?><p><? echo $val["TEXT"]; ?></p><?
                        }
                        ?>
                    <? } else { ?>
                        <a <? if ($val["LINK"] != '') { ?>href="<?= $val["LINK"] ?>"<? } ?>><?= $val["TEXT"] ?></a>
                    <? } ?>
                </div>
            <? } ?>
        </div> <!-- end product-slider-slides -->
        <script type="text/javascript">
            jQuery(document).ready(function () {
                //jQuery(".product-category-landing").css("margin-top","160px");
            });
        </script>
        <style type="text/css">
            .category-list-feature {
                height: 367px;
            }
        </style>
    <? } ?>
<? } else { ?>

    <? // Если нет - ничего не выводим  ?>

<? } ?>
<? // [/Вывод верхнего баннера в подразделе "Каталога"]  ?>

<div class="product-category-landing">

    <?
    if (!isset($_REQUEST['SHOW']) && $_REQUEST['SHOW'] != 'all') {
        ?>
        <div class="modules"><!-- [/end modules] -->
        <? } ?>

        <?
        if (!$arParams['FILTER_VIEW_MODE'])
            $arParams['FILTER_VIEW_MODE'] = 'VERTICAL';
        $arParams['USE_FILTER'] = (isset($arParams['USE_FILTER']) && $arParams['USE_FILTER'] == 'Y' ? 'Y' : 'N');
        $verticalGrid = ('Y' == $arParams['USE_FILTER'] && $arParams["FILTER_VIEW_MODE"] == "VERTICAL");
        ?>

        <?
        if ($arParams['USE_FILTER'] == 'Y') {

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
            ?>

            <div style="visibility: hidden; position: absolute; z-index: -1;">

                <?
                // Отображение фильтра необходимо для срабатывания из шаблона вывода списка каталога
                $APPLICATION->IncludeComponent(
                        "bitrix:catalog.smart.filter", "visual_" . ($arParams["FILTER_VIEW_MODE"] == "HORIZONTAL" ? "horizontal" : "vertical"), Array(
                    "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
                    "IBLOCK_ID" => $arParams["IBLOCK_ID"],
                    "SECTION_ID" => $arCurSection['ID'],
                    "FILTER_NAME" => $arParams["FILTER_NAME"],
                    "PRICE_CODE" => $arParams["PRICE_CODE"],
                    "CACHE_TYPE" => $arParams["CACHE_TYPE"],
                    "CACHE_TIME" => $arParams["CACHE_TIME"],
                    "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
                    "SAVE_IN_SESSION" => "N",
                    "XML_EXPORT" => "Y",
                    "SECTION_TITLE" => "NAME",
                    "SECTION_DESCRIPTION" => "DESCRIPTION",
                    'HIDE_NOT_AVAILABLE' => $arParams["HIDE_NOT_AVAILABLE"],
                    "TEMPLATE_THEME" => $arParams["HIDE_NOT_AVAILABLE"]
                        ), $component, array('HIDE_ICONS' => 'N')
                );
                ?>

            </div>

            <?
        }
        ?>


        <?
        global $arrFilter;
        $arrFilter['CATALOG_AVAILABLE'] = 'Y';

        $APPLICATION->IncludeComponent(
                "bitrix:catalog.section.list", "", array(
            "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
            "IBLOCK_ID" => $arParams["IBLOCK_ID"],
            "SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
            "SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
            "CACHE_TYPE" => $arParams["CACHE_TYPE"],
            "CACHE_TIME" => $arParams["CACHE_TIME"],
            "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
            "COUNT_ELEMENTS" => $arParams["SECTION_COUNT_ELEMENTS"],
            "TOP_DEPTH" => $arParams["SECTION_TOP_DEPTH"],
            "SECTION_URL" => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["section"],
            "VIEW_MODE" => $arParams["SECTIONS_VIEW_MODE"],
            "SHOW_PARENT_NAME" => $arParams["SECTIONS_SHOW_PARENT_NAME"],
            "HIDE_SECTION_NAME" => (isset($arParams["SECTIONS_HIDE_SECTION_NAME"]) ? $arParams["SECTIONS_HIDE_SECTION_NAME"] : "N"),
            "ADD_SECTIONS_CHAIN" => (isset($arParams["ADD_SECTIONS_CHAIN"]) ? $arParams["ADD_SECTIONS_CHAIN"] : '')
                ), $component
        );
        ?>

        <?
        if ($arParams["USE_COMPARE"] == "Y") {
            ?><?
            $APPLICATION->IncludeComponent(
                    "bitrix:catalog.compare.list", "", array(
                "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
                "IBLOCK_ID" => $arParams["IBLOCK_ID"],
                "NAME" => $arParams["COMPARE_NAME"],
                "DETAIL_URL" => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["element"],
                "COMPARE_URL" => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["compare"],
                    ), $component
            );
            ?><?
        }
        $intSectionID = 0;
        ?>

        <?
        // Разные шаблоны для общего просмотра и для списка товаров
        if (isset($_REQUEST['SHOW']) && $_REQUEST['SHOW'] == 'all') {

            // LEEFT
            $request = \Bitrix\Main\Application::getInstance()->getContext()->getRequest();
            if (strlen($request->get('category')) > 0) {
                global $arCategoryFilter;
                $arCategoryFilter['NAME'] = '%' . strtoupper($request->get('category')) . '%';
                $arParams["FILTER_NAME"] = 'arCategoryFilter';
            }
            $intSectionID = $APPLICATION->IncludeComponent(
                    "bitrix:catalog.section", "sectonindex", array(
                "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
                "IBLOCK_ID" => $arParams["IBLOCK_ID"],
                "ELEMENT_SORT_FIELD" => $arParams["ELEMENT_SORT_FIELD"],
                "ELEMENT_SORT_ORDER" => $arParams["ELEMENT_SORT_ORDER"],
                "ELEMENT_SORT_FIELD2" => $arParams["ELEMENT_SORT_FIELD2"],
                "ELEMENT_SORT_ORDER2" => $arParams["ELEMENT_SORT_ORDER2"],
                "PROPERTY_CODE" => $arParams["LIST_PROPERTY_CODE"],
                "META_KEYWORDS" => $arParams["LIST_META_KEYWORDS"],
                "META_DESCRIPTION" => $arParams["LIST_META_DESCRIPTION"],
                "BROWSER_TITLE" => $arParams["LIST_BROWSER_TITLE"],
                "INCLUDE_SUBSECTIONS" => $arParams["INCLUDE_SUBSECTIONS"],
                "BASKET_URL" => $arParams["BASKET_URL"],
                "ACTION_VARIABLE" => $arParams["ACTION_VARIABLE"],
                "PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
                "SECTION_ID_VARIABLE" => $arParams["SECTION_ID_VARIABLE"],
                "PRODUCT_QUANTITY_VARIABLE" => $arParams["PRODUCT_QUANTITY_VARIABLE"],
                "PRODUCT_PROPS_VARIABLE" => $arParams["PRODUCT_PROPS_VARIABLE"],
                "FILTER_NAME" => $arParams["FILTER_NAME"],
                "CACHE_TYPE" => $arParams["CACHE_TYPE"],
                "CACHE_TIME" => $arParams["CACHE_TIME"],
                "CACHE_FILTER" => $arParams["CACHE_FILTER"],
                "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
                "SET_TITLE" => $arParams["SET_TITLE"],
                "SET_STATUS_404" => $arParams["SET_STATUS_404"],
                "DISPLAY_COMPARE" => $arParams["USE_COMPARE"],
                "PAGE_ELEMENT_COUNT" => $arParams["PAGE_ELEMENT_COUNT"],
                "LINE_ELEMENT_COUNT" => $arParams["LINE_ELEMENT_COUNT"],
                "PRICE_CODE" => $arParams["PRICE_CODE"],
                "USE_PRICE_COUNT" => $arParams["USE_PRICE_COUNT"],
                "SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],
                "PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],
                "USE_PRODUCT_QUANTITY" => $arParams['USE_PRODUCT_QUANTITY'],
                "ADD_PROPERTIES_TO_BASKET" => (isset($arParams["ADD_PROPERTIES_TO_BASKET"]) ? $arParams["ADD_PROPERTIES_TO_BASKET"] : ''),
                "PARTIAL_PRODUCT_PROPERTIES" => (isset($arParams["PARTIAL_PRODUCT_PROPERTIES"]) ? $arParams["PARTIAL_PRODUCT_PROPERTIES"] : ''),
                "PRODUCT_PROPERTIES" => $arParams["PRODUCT_PROPERTIES"],
                "DISPLAY_TOP_PAGER" => $arParams["DISPLAY_TOP_PAGER"],
                "DISPLAY_BOTTOM_PAGER" => $arParams["DISPLAY_BOTTOM_PAGER"],
                "PAGER_TITLE" => $arParams["PAGER_TITLE"],
                "PAGER_SHOW_ALWAYS" => $arParams["PAGER_SHOW_ALWAYS"],
                "PAGER_TEMPLATE" => $arParams["PAGER_TEMPLATE"],
                "PAGER_DESC_NUMBERING" => $arParams["PAGER_DESC_NUMBERING"],
                "PAGER_DESC_NUMBERING_CACHE_TIME" => $arParams["PAGER_DESC_NUMBERING_CACHE_TIME"],
                "PAGER_SHOW_ALL" => $arParams["PAGER_SHOW_ALL"],
                "OFFERS_CART_PROPERTIES" => $arParams["OFFERS_CART_PROPERTIES"],
                "OFFERS_FIELD_CODE" => $arParams["LIST_OFFERS_FIELD_CODE"],
                "OFFERS_PROPERTY_CODE" => $arParams["LIST_OFFERS_PROPERTY_CODE"],
                "OFFERS_SORT_FIELD" => $arParams["OFFERS_SORT_FIELD"],
                "OFFERS_SORT_ORDER" => $arParams["OFFERS_SORT_ORDER"],
                "OFFERS_SORT_FIELD2" => $arParams["OFFERS_SORT_FIELD2"],
                "OFFERS_SORT_ORDER2" => $arParams["OFFERS_SORT_ORDER2"],
                "OFFERS_LIMIT" => $arParams["LIST_OFFERS_LIMIT"],
                "SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
                "SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
                "SECTION_URL" => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["section"],
                "DETAIL_URL" => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["element"],
                'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
                'CURRENCY_ID' => $arParams['CURRENCY_ID'],
                'HIDE_NOT_AVAILABLE' => $arParams["HIDE_NOT_AVAILABLE"],
                'LABEL_PROP' => $arParams['LABEL_PROP'],
                'ADD_PICT_PROP' => $arParams['ADD_PICT_PROP'],
                'PRODUCT_DISPLAY_MODE' => $arParams['PRODUCT_DISPLAY_MODE'],
                'OFFER_ADD_PICT_PROP' => $arParams['OFFER_ADD_PICT_PROP'],
                'OFFER_TREE_PROPS' => $arParams['OFFER_TREE_PROPS'],
                'PRODUCT_SUBSCRIPTION' => $arParams['PRODUCT_SUBSCRIPTION'],
                'SHOW_DISCOUNT_PERCENT' => $arParams['SHOW_DISCOUNT_PERCENT'],
                'SHOW_OLD_PRICE' => $arParams['SHOW_OLD_PRICE'],
                'MESS_BTN_BUY' => $arParams['MESS_BTN_BUY'],
                'MESS_BTN_ADD_TO_BASKET' => $arParams['MESS_BTN_ADD_TO_BASKET'],
                'MESS_BTN_SUBSCRIBE' => $arParams['MESS_BTN_SUBSCRIBE'],
                'MESS_BTN_DETAIL' => $arParams['MESS_BTN_DETAIL'],
                'MESS_NOT_AVAILABLE' => $arParams['MESS_NOT_AVAILABLE'],
                'TEMPLATE_THEME' => (isset($arParams['TEMPLATE_THEME']) ? $arParams['TEMPLATE_THEME'] : ''),
                "ADD_SECTIONS_CHAIN" => "N"
                    ), $component
            );
            ?>

            <?
        } else {
            ?>

            <?
            global $arrFilter;

            $arrFilter["!PROPERTY_FEATURED_PRODUCTS"] = false;

            // Другое представление каталога - в виде слайдера
            $intSectionID = $APPLICATION->IncludeComponent(
                    "bitrix:catalog.section", "sectonslider", array(
                "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
                "IBLOCK_ID" => $arParams["IBLOCK_ID"],
                "ELEMENT_SORT_FIELD" => $arParams["ELEMENT_SORT_FIELD"],
                "ELEMENT_SORT_ORDER" => $arParams["ELEMENT_SORT_ORDER"],
                "ELEMENT_SORT_FIELD2" => $arParams["ELEMENT_SORT_FIELD2"],
                "ELEMENT_SORT_ORDER2" => $arParams["ELEMENT_SORT_ORDER2"],
                "PROPERTY_CODE" => $arParams["LIST_PROPERTY_CODE"],
                "META_KEYWORDS" => $arParams["LIST_META_KEYWORDS"],
                "META_DESCRIPTION" => $arParams["LIST_META_DESCRIPTION"],
                "BROWSER_TITLE" => $arParams["LIST_BROWSER_TITLE"],
                "INCLUDE_SUBSECTIONS" => $arParams["INCLUDE_SUBSECTIONS"],
                "BASKET_URL" => $arParams["BASKET_URL"],
                "ACTION_VARIABLE" => $arParams["ACTION_VARIABLE"],
                "PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
                "SECTION_ID_VARIABLE" => $arParams["SECTION_ID_VARIABLE"],
                "PRODUCT_QUANTITY_VARIABLE" => $arParams["PRODUCT_QUANTITY_VARIABLE"],
                "PRODUCT_PROPS_VARIABLE" => $arParams["PRODUCT_PROPS_VARIABLE"],
                "FILTER_NAME" => "arrFilter", // $arParams["FILTER_NAME"],
                "CACHE_TYPE" => $arParams["CACHE_TYPE"],
                "CACHE_TIME" => $arParams["CACHE_TIME"],
                "CACHE_FILTER" => $arParams["CACHE_FILTER"],
                "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
                "SET_TITLE" => $arParams["SET_TITLE"],
                "SET_STATUS_404" => $arParams["SET_STATUS_404"],
                "DISPLAY_COMPARE" => $arParams["USE_COMPARE"],
                "PAGE_ELEMENT_COUNT" => $arParams["PAGE_ELEMENT_COUNT"],
                "LINE_ELEMENT_COUNT" => $arParams["LINE_ELEMENT_COUNT"],
                "PRICE_CODE" => $arParams["PRICE_CODE"],
                "USE_PRICE_COUNT" => $arParams["USE_PRICE_COUNT"],
                "SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],
                "PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],
                "USE_PRODUCT_QUANTITY" => $arParams['USE_PRODUCT_QUANTITY'],
                "ADD_PROPERTIES_TO_BASKET" => (isset($arParams["ADD_PROPERTIES_TO_BASKET"]) ? $arParams["ADD_PROPERTIES_TO_BASKET"] : ''),
                "PARTIAL_PRODUCT_PROPERTIES" => (isset($arParams["PARTIAL_PRODUCT_PROPERTIES"]) ? $arParams["PARTIAL_PRODUCT_PROPERTIES"] : ''),
                "PRODUCT_PROPERTIES" => $arParams["PRODUCT_PROPERTIES"],
                "DISPLAY_TOP_PAGER" => $arParams["DISPLAY_TOP_PAGER"],
                "DISPLAY_BOTTOM_PAGER" => $arParams["DISPLAY_BOTTOM_PAGER"],
                "PAGER_TITLE" => $arParams["PAGER_TITLE"],
                "PAGER_SHOW_ALWAYS" => $arParams["PAGER_SHOW_ALWAYS"],
                "PAGER_TEMPLATE" => $arParams["PAGER_TEMPLATE"],
                "PAGER_DESC_NUMBERING" => $arParams["PAGER_DESC_NUMBERING"],
                "PAGER_DESC_NUMBERING_CACHE_TIME" => $arParams["PAGER_DESC_NUMBERING_CACHE_TIME"],
                "PAGER_SHOW_ALL" => $arParams["PAGER_SHOW_ALL"],
                "OFFERS_CART_PROPERTIES" => $arParams["OFFERS_CART_PROPERTIES"],
                "OFFERS_FIELD_CODE" => $arParams["LIST_OFFERS_FIELD_CODE"],
                "OFFERS_PROPERTY_CODE" => $arParams["LIST_OFFERS_PROPERTY_CODE"],
                "OFFERS_SORT_FIELD" => $arParams["OFFERS_SORT_FIELD"],
                "OFFERS_SORT_ORDER" => $arParams["OFFERS_SORT_ORDER"],
                "OFFERS_SORT_FIELD2" => $arParams["OFFERS_SORT_FIELD2"],
                "OFFERS_SORT_ORDER2" => $arParams["OFFERS_SORT_ORDER2"],
                "OFFERS_LIMIT" => $arParams["LIST_OFFERS_LIMIT"],
                "SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
                "SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
                "SECTION_URL" => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["section"],
                "DETAIL_URL" => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["element"],
                'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
                'CURRENCY_ID' => $arParams['CURRENCY_ID'],
                'HIDE_NOT_AVAILABLE' => $arParams["HIDE_NOT_AVAILABLE"],
                'LABEL_PROP' => $arParams['LABEL_PROP'],
                'ADD_PICT_PROP' => $arParams['ADD_PICT_PROP'],
                'PRODUCT_DISPLAY_MODE' => $arParams['PRODUCT_DISPLAY_MODE'],
                'OFFER_ADD_PICT_PROP' => $arParams['OFFER_ADD_PICT_PROP'],
                'OFFER_TREE_PROPS' => $arParams['OFFER_TREE_PROPS'],
                'PRODUCT_SUBSCRIPTION' => $arParams['PRODUCT_SUBSCRIPTION'],
                'SHOW_DISCOUNT_PERCENT' => $arParams['SHOW_DISCOUNT_PERCENT'],
                'SHOW_OLD_PRICE' => $arParams['SHOW_OLD_PRICE'],
                'MESS_BTN_BUY' => $arParams['MESS_BTN_BUY'],
                'MESS_BTN_ADD_TO_BASKET' => $arParams['MESS_BTN_ADD_TO_BASKET'],
                'MESS_BTN_SUBSCRIBE' => $arParams['MESS_BTN_SUBSCRIBE'],
                'MESS_BTN_DETAIL' => $arParams['MESS_BTN_DETAIL'],
                'MESS_NOT_AVAILABLE' => $arParams['MESS_NOT_AVAILABLE'],
                'TEMPLATE_THEME' => (isset($arParams['TEMPLATE_THEME']) ? $arParams['TEMPLATE_THEME'] : ''),
                "ADD_SECTIONS_CHAIN" => "N"
                    ), $component
            );
            ?>

            <?
        } // end if show all
        ?>


        <?
// [Баннеры контентной области - полноразмерные]
        /*
          ?>

          <?
          $uri = $APPLICATION->GetCurUri(); //."index.php";
          $dir = $APPLICATION->GetCurDir(false);

          $IBLOCK_ID = 19; // Инфоблок "Баннеры контентной области - полноразмерные"
          $arSelect = Array("ID","IBLOCK_ID","NAME","DATE_ACTIVE_FROM","DETAIL_TEXT", "DETAIL_TEXT_TYPE", "DETAIL_PICTURE","PROPERTY_*");//IBLOCK_ID и ID обязательно должны быть указаны, см. описание arSelectFields выше
          if($dir == '/') {
          $arFilter = Array("IBLOCK_ID"=>IntVal($IBLOCK_ID), "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y", "PROPERTY_CONNECT_TO_URL"=>"".$dir."");
          } else {
          $arFilter = Array("IBLOCK_ID"=>IntVal($IBLOCK_ID), "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y", "PROPERTY_CONNECT_TO_URL"=>"".$dir."%");
          }

          $res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize"=>10), $arSelect);
          $listTopBanners = array();
          while($ob = $res->GetNextElement()){

          $arFields = $ob->GetFields();
          $arProps = $ob->GetProperties();

          $listTopBanners[] = array(
          "ID" => $arFields["ID"],
          "NAME" => $arFields["NAME"],
          "TEXT" => $arFields["DETAIL_TEXT"],
          "DETAIL_TEXT_TYPE" => $arFields["DETAIL_TEXT_TYPE"],
          "DETAIL_PICTURE" => $arFields["DETAIL_PICTURE"],
          "LINK" => $arProps["LINK"]["VALUE"],
          // "BUTTON_HTML" => $arProps["BUTTON_HTML"]["VALUE"],
          // "FIRST_BANNER" => $arProps["FIRST_BANNER"]["VALUE"],
          // "SECOND_BANNER" => $arProps["SECOND_BANNER"]["VALUE"],
          // "THREE_BANNER" => $arProps["THREE_BANNER"]["VALUE"],
          );

          }

          ?>
          <? foreach($listTopBanners as $key => $val) { ?>

          <div class="module-c">
          <? if($val["TEXT"] != '') {?>
          <?
          if ('html' == $val['DETAIL_TEXT_TYPE'])
          {
          echo htmlspecialcharsBack( $val['TEXT'] );
          }
          else
          {
          ?><? echo htmlspecialcharsBack( $val['TEXT'] ); ?><?
          }
          ?>
          <? } else { ?>
          <a <? if($val["LINK"] != '') { ?>href="<?=$val["LINK"]?>"<? } ?>>
          <? echo CFile::ShowImage($val["DETAIL_PICTURE"], 960, 0, "border=0", "", true); ?>
          </a>
          <? } ?>
          </div>

          <? } ?>
          <? // [/Баннеры контентной области - полноразмерные]
         */
        ?>


        <?
// [Вывод трех баннеров в контентной области]
        /*
          ?>
          <?
          //$uri = $APPLICATION->GetCurUri(); //."index.php";
          // $dir = $APPLICATION->GetCurDir(false);

          $IBLOCK_ID = 20; // Инфоблок "Три малых баннера внизу страницы"
          $arSelect = Array("ID","IBLOCK_ID","NAME","DATE_ACTIVE_FROM","DETAIL_TEXT", "DETAIL_TEXT_TYPE", "DETAIL_PICTURE","PROPERTY_*");//IBLOCK_ID и ID обязательно должны быть указаны, см. описание arSelectFields выше
          if($dir == '/') {
          $arFilter = Array("IBLOCK_ID"=>IntVal($IBLOCK_ID), "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y", "PROPERTY_CONNECT_TO_URL"=>"".$dir."");
          } else {
          $arFilter = Array("IBLOCK_ID"=>IntVal($IBLOCK_ID), "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y", "PROPERTY_CONNECT_TO_URL"=>"".$dir."%");
          }

          $res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize"=>10), $arSelect);
          $listTopBanners = array();

          while($ob = $res->GetNextElement()){

          $arFields = $ob->GetFields();
          $arProps = $ob->GetProperties();

          $listTopBanners[] = array(
          "ID" => $arFields["ID"],
          "NAME" => $arFields["NAME"],
          "TEXT" => $arFields["DETAIL_TEXT"],
          "DETAIL_TEXT_TYPE" => $arFields["DETAIL_TEXT_TYPE"],
          "DETAIL_PICTURE" => $arFields["DETAIL_PICTURE"],
          "LINK" => $arProps["LINK"]["VALUE"],
          // "BUTTON_HTML" => $arProps["BUTTON_HTML"]["VALUE"],
          "FIRST_BANNER" => $arProps["FIRST_BANNER"]["VALUE"]["TEXT"],
          "SECOND_BANNER" => $arProps["SECOND_BANNER"]["VALUE"]["TEXT"],
          "THREE_BANNER" => $arProps["THREE_BANNER"]["VALUE"]["TEXT"],
          "FIRST_BANNER_TYPE" => $arProps["FIRST_BANNER"]["VALUE"]["TYPE"],
          "SECOND_BANNER_TYPE" => $arProps["SECOND_BANNER"]["VALUE"]["TYPE"],
          "THREE_BANNER_TYPE" => $arProps["THREE_BANNER"]["VALUE"]["TYPE"],
          );

          }

          ?>
          <? // [/Вывод трех баннеров в контентной области]
         */
        ?>
        <?
        /*
          foreach($listTopBanners as $key => $val) { ?>
          <div class="promo-row">
          <div class="promo-row-promo">
          <?
          if ('html' == $val['FIRST_BANNER_TYPE'])
          {
          echo htmlspecialcharsBack( $val['FIRST_BANNER'] );
          }
          else
          {
          ?><? echo htmlspecialcharsBack( $val['FIRST_BANNER'] ); ?><?
          }
          ?>
          </div>
          <div class="promo-row-promo">
          <?
          if ('html' == $val['SECOND_BANNER_TYPE'])
          {
          echo htmlspecialcharsBack( $val['SECOND_BANNER'] );
          }
          else
          {
          ?><? echo htmlspecialcharsBack( $val['SECOND_BANNER'] ); ?><?
          }
          ?>
          </div>
          <div class="promo-row-promo">
          <?
          if ('html' == $val['THREE_BANNER_TYPE'])
          {
          echo htmlspecialcharsBack( $val['THREE_BANNER'] );
          }
          else
          {
          ?><p><? echo htmlspecialcharsBack( $val['THREE_BANNER'] ); ?></p><?
          }
          ?>
          </div>
          </div>
          <? }
         */
        ?>

        <?
        if (!isset($_REQUEST['SHOW']) && $_REQUEST['SHOW'] != 'all') {
            ?>
        </div><!-- [/end modules] -->
    <? } ?>

</div><!-- [/end product-category-landing] -->

