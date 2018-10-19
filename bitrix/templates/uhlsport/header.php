<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();
IncludeTemplateLangFile($_SERVER["DOCUMENT_ROOT"] . "/bitrix/templates/" . SITE_TEMPLATE_ID . "/header.php");
$wizTemplateId = COption::GetOptionString("main", "wizard_template_id", "eshop_adapt_horizontal", SITE_ID);
CUtil::InitJSCore();
CJSCore::Init(array("fx"));
$arCurDir = explode("/", $APPLICATION->GetCurDir());
$curPage = $APPLICATION->GetCurPage(true);
$curDir = $APPLICATION->GetCurDir(true);
$depthLevel = count(array_filter(explode("/", $curPage), function($val) {
            return $val && $val != 'index.php';
        }));
$GLOBALS['depthLevel'] = $depthLevel;
$GLOBALS['curPage'] = $curPage;
$GLOBALS['curDir'] = $curDir;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?= LANGUAGE_ID ?>" lang="<?= LANGUAGE_ID ?>">
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="user-scalable=no, initial-scale=1.0, maximum-scale=1.0, width=device-width">
        <meta name="yandex-verification" content="730af6d5eec7e094" />

            <link rel="shortcut icon" type="image/x-icon" href="<?= SITE_DIR ?>favicon.ico?v=2" />
            <link rel="icon" type="image/x-icon" href="<?= SITE_DIR ?>favicon.ico?v=2" /> 

            <?
            //$APPLICATION->ShowHead();
            echo '<meta http-equiv="Content-Type" content="text/html; charset=' . LANG_CHARSET . '"' . (true ? ' /' : '') . '>' . "\n";
            $APPLICATION->ShowMeta("robots", false, true);
            $APPLICATION->ShowMeta("keywords", false, true);
            $APPLICATION->ShowMeta("description", false, true);
            $APPLICATION->ShowCSS(true, true);
            $APPLICATION->ShowHeadStrings();
            $APPLICATION->ShowHeadScripts();
            $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH . "/script.js");
            ?>
            <link href="<?= SITE_TEMPLATE_PATH ?>/style.css" rel="stylesheet" type="text/css" />
            <link href="<?= SITE_TEMPLATE_PATH ?>/css.css" rel="stylesheet" type="text/css" />
            <link href="<?= SITE_TEMPLATE_PATH ?>/33979.css" rel="stylesheet" type="text/css" />
            <title><? $APPLICATION->ShowTitle() ?></title>
            <link rel="shortcut icon" href="/images/favicon.ico"/>
            <link rel="icon" type="image/png" href="/images/favicon-96x96.png" sizes="96x96"/>
            <link rel="icon" type="image/png" href="/images/favicon-32x32.png" sizes="32x32"/>
            <link rel="icon" type="image/png" href="/images/favicon-16x16.png" sizes="16x16"/>
            <script type="text/javascript" src="<?= SITE_TEMPLATE_PATH ?>/js/jquery-1.8.3.js"></script>
            <script src="<?= SITE_TEMPLATE_PATH ?>/js/modernizr?v=hoA4mtDJgt5gT0Rcfje6yD2XEXlM6c72VeG1H60rbHk1"></script>
            <script src="<?= SITE_TEMPLATE_PATH ?>/js/website?v=rsqc1vLpwpx693ctUUGsyMsrFj5ZnGAf0V-P1DU5a9k1"></script>
            <script type="text/javascript" src="<?= SITE_TEMPLATE_PATH ?>/js/jquery.jqzoom-core.js"></script>
            <script type="text/javascript">


                $(document).ready(function () {

                    $(".udropdown").click(function (e) {
                        $("#sizetable").fadeToggle();
                        $(this).toggleClass("udropdown2");
                        e.preventDefault();
                    });

                    var mobile = $("#menubutton").is(":visible");


                    if (!mobile) {
                        $('.jqzoom').jqzoom({
                            zoomType: 'standard',
                            preloadText: "Loading...",
                            position: "right",
                            lens: true,
                            preloadImages: false,
                            alwaysOn: false,
                            zoomWidth: 460,
                            zoomHeight: 340,
                            xOffset: 140,
                            yOffset: 0,
                            showEffect: "fadein",
                            hideEffect: "fadeout",
                            title: false
                        });
                    } else {

                        var index = 0;
                        var total = $(".view").length;
                        if (total == 1)
                            $("#prev,#next").hide();

                        $("#zoom1").click(function (e) {
                            e.preventDefault();
                        });

                        $("#prev").click(function () {
                            index--;
                            if (index < 0)
                                index = total - 1;
                            displayNext(index);
                        });
                        $("#next").click(function () {
                            index++;
                            if (index >= total)
                                index = 0;
                            displayNext(index);
                        });

                        function displayNext(index) {
                            var el = $(".view").eq(index).find("a");
                            var info = $.extend({}, eval("(" + $.trim(el.attr('rel')) + ")"));
                            $("#mainview").attr("src", info.largeimage);

                            track(document.title + " :: Big Image " + info.largeimage);
                        }
                    }

                });

            </script>
    </head>
    <body class="body">
        <? /* [Счетчики аналитики] */ ?>
        <? $APPLICATION->IncludeComponent("bitrix:main.include", "", array("AREA_FILE_SHOW" => "file", "PATH" => SITE_DIR . "include/analyticstracking.php"), false); ?>
        <div id="panel"><? $APPLICATION->ShowPanel(); ?></div>
        <div id="wrapper">
            <div id="printlogo" class="printonly">
                <img src="<?= SITE_TEMPLATE_PATH ?>/images/logo.png" alt=""/>
            </div>
            <header>
                <div id="fixed">
                    <div id="top"></div>
                    <?
                    $APPLICATION->IncludeComponent("bitrix:menu", "horizontal_multilevel1", Array(
                        "ROOT_MENU_TYPE" => "top", // Тип меню для первого уровня
                        "MENU_CACHE_TYPE" => "N", // Тип кеширования
                        "MENU_CACHE_TIME" => "36000000", // Время кеширования (сек.)
                        "MENU_CACHE_USE_GROUPS" => "Y", // Учитывать права доступа
                        "MENU_CACHE_GET_VARS" => "", // Значимые переменные запроса
                        "MAX_LEVEL" => "2", // Уровень вложенности меню
                        "CHILD_MENU_TYPE" => "left", // Тип меню для остальных уровней
                        "USE_EXT" => "N", // Подключать файлы с именами вида .тип_меню.menu_ext.php
                        "DELAY" => "N", // Откладывать выполнение шаблона меню
                        "ALLOW_MULTI_SELECT" => "N", // Разрешить несколько активных пунктов одновременно
                            ), false
                    );
                    ?>
                    <?
                    $APPLICATION->IncludeComponent("bitrix:search.title", "visual", array(
                        "NUM_CATEGORIES" => "1",
                        "TOP_COUNT" => "5",
                        "CHECK_DATES" => "N",
                        "SHOW_OTHERS" => "N",
                        "PAGE" => SITE_DIR . "catalog/",
                        "CATEGORY_0_TITLE" => GetMessage("SEARCH_GOODS"),
                        "CATEGORY_0" => array(
                            0 => "iblock_catalog",
                        ),
                        "CATEGORY_0_iblock_catalog" => array(
                            0 => "all",
                        ),
                        "CATEGORY_OTHERS_TITLE" => GetMessage("SEARCH_OTHER"),
                        "SHOW_INPUT" => "Y",
                        "INPUT_ID" => "title-search-input",
                        "CONTAINER_ID" => "search",
                        "PRICE_CODE" => array(
                            0 => "BASE",
                        ),
                        "SHOW_PREVIEW" => "Y",
                        "PREVIEW_WIDTH" => "75",
                        "PREVIEW_HEIGHT" => "75",
                        "CONVERT_CURRENCY" => "Y"
                            ), false
                    );
                    ?>
                    <div id="line"></div>
                    <a href="/" id="logo"></a>
                </div>
            </header>
            <div id="content" class="<?
            if ($arCurDir[1] == "") {
                echo "start";
            } elseif (array_search('products', $arCurDir)) {
                echo "newsletter";
            } elseif (array_search('company_history', $arCurDir)) {
                echo "history";
            }
            ?>">
                <div id="headerimage">
                    <? if ($arCurDir[1] == "") { ?>
                        <?
                        $APPLICATION->IncludeComponent("bitrix:news.list", "main_banner_template1", Array(
                            "IBLOCK_TYPE" => "banners", // Тип информационного блока (используется только для проверки)
                            "IBLOCK_ID" => "14", // Код информационного блока
                            "NEWS_COUNT" => "1", // Количество новостей на странице
                            "SORT_BY1" => "ACTIVE_FROM", // Поле для первой сортировки новостей
                            "SORT_ORDER1" => "DESC", // Направление для первой сортировки новостей
                            "SORT_BY2" => "SORT", // Поле для второй сортировки новостей
                            "SORT_ORDER2" => "ASC", // Направление для второй сортировки новостей
                            "FILTER_NAME" => "", // Фильтр
                            "FIELD_CODE" => array(// Поля
                                0 => "DETAIL_PICTURE",
                                1 => "",
                            ),
                            "PROPERTY_CODE" => array(// Свойства
                                0 => "LINK",
                                1 => "",
                            ),
                            "CHECK_DATES" => "Y", // Показывать только активные на данный момент элементы
                            "DETAIL_URL" => "", // URL страницы детального просмотра (по умолчанию - из настроек инфоблока)
                            "AJAX_MODE" => "N", // Включить режим AJAX
                            "AJAX_OPTION_JUMP" => "N", // Включить прокрутку к началу компонента
                            "AJAX_OPTION_STYLE" => "Y", // Включить подгрузку стилей
                            "AJAX_OPTION_HISTORY" => "N", // Включить эмуляцию навигации браузера
                            "CACHE_TYPE" => "A", // Тип кеширования
                            "CACHE_TIME" => "36000000", // Время кеширования (сек.)
                            "CACHE_FILTER" => "N", // Кешировать при установленном фильтре
                            "CACHE_GROUPS" => "Y", // Учитывать права доступа
                            "PREVIEW_TRUNCATE_LEN" => "", // Максимальная длина анонса для вывода (только для типа текст)
                            "ACTIVE_DATE_FORMAT" => "d.m.Y", // Формат показа даты
                            "SET_STATUS_404" => "N", // Устанавливать статус 404, если не найдены элемент или раздел
                            "SET_TITLE" => "N", // Устанавливать заголовок страницы
                            "INCLUDE_IBLOCK_INTO_CHAIN" => "N", // Включать инфоблок в цепочку навигации
                            "ADD_SECTIONS_CHAIN" => "N", // Включать раздел в цепочку навигации
                            "HIDE_LINK_WHEN_NO_DETAIL" => "N", // Скрывать ссылку, если нет детального описания
                            "PARENT_SECTION" => "", // ID раздела
                            "PARENT_SECTION_CODE" => "", // Код раздела
                            "INCLUDE_SUBSECTIONS" => "N", // Показывать элементы подразделов раздела
                            "PAGER_TEMPLATE" => ".default", // Шаблон постраничной навигации
                            "DISPLAY_TOP_PAGER" => "N", // Выводить над списком
                            "DISPLAY_BOTTOM_PAGER" => "N", // Выводить под списком
                            "PAGER_TITLE" => "Новости", // Название категорий
                            "PAGER_SHOW_ALWAYS" => "N", // Выводить всегда
                            "PAGER_DESC_NUMBERING" => "N", // Использовать обратную навигацию
                            "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000", // Время кеширования страниц для обратной навигации
                            "PAGER_SHOW_ALL" => "N", // Показывать ссылку "Все"
                            "DISPLAY_DATE" => "N", // Выводить дату элемента
                            "DISPLAY_NAME" => "N", // Выводить название элемента
                            "DISPLAY_PICTURE" => "N", // Выводить изображение для анонса
                            "DISPLAY_PREVIEW_TEXT" => "N", // Выводить текст анонса
                            "AJAX_OPTION_ADDITIONAL" => "", // Дополнительный идентификатор
                                ), false
                        );
                        ?>
                    <? } elseif (array_search("product", $arCurDir) || array_search("sponsoring_products", $arCurDir)) { ?>
                        <img id="himage" src="<?php echo SITE_TEMPLATE_PATH ?>/images/home.jpg" alt="" />
                    <? } elseif (array_search("nationalteams", $arCurDir) || array_search("teams", $arCurDir)) { ?>
                        <img id="himage" src="<?php echo SITE_TEMPLATE_PATH ?>/pic/natteam.jpg" alt="" />
                    <? } elseif (array_search("general_information", $arCurDir)) { ?>
                        <img id="himage" src="<?php echo SITE_TEMPLATE_PATH ?>/pic/general_information.jpg" alt="" />
                    <? } elseif (array_search("company_history", $arCurDir)) { ?>
                        <img id="himage" src="<?php echo SITE_TEMPLATE_PATH ?>/pic/company_history.jpg" alt="" />
                    <? } elseif (array_search("responsibility", $arCurDir)) { ?>
                        <img id="himage" src="<?php echo SITE_TEMPLATE_PATH ?>/pic/responsibility.jpg" alt="" />
                    <? } elseif (array_search("goalkeepers", $arCurDir) && isset($_GET["ID"])) { ?>
                        <img id="himage" src="<?php echo SITE_TEMPLATE_PATH ?>/images/torwart.jpg" alt="" />
                    <? } elseif ((array_search("goalkeepers", $arCurDir) && !isset($_GET["ID"]))) { ?>
                        <img id="himage" src="<?php echo SITE_TEMPLATE_PATH ?>/pic/636205215572300000.jpg" alt="" />
                    <? } elseif ((array_search("catalog", $arCurDir) && array_search("services", $arCurDir))) { ?>
                        <img id="himage" src="<?php echo SITE_TEMPLATE_PATH ?>/pic/catalog_service.jpg" alt="" />
                    <? } elseif ((array_search("refinement_service", $arCurDir) && array_search("services", $arCurDir))) { ?>
                        <img id="himage" src="<?php echo SITE_TEMPLATE_PATH ?>/pic/refinement_service.jpg" alt="" />
                    <? } elseif ((array_search("info", $arCurDir) && array_search("services", $arCurDir))) { ?>
                        <img id="himage" src="<?php echo SITE_TEMPLATE_PATH ?>/pic/catalog_service.jpg" alt="" />
                    <? } elseif ((array_search("dealers", $arCurDir))) { ?>
                        <img id="himage" src="<?php echo SITE_TEMPLATE_PATH ?>/pic/dealers.jpg" alt="" /> 
                    <? } else { ?>
                        <img id="himage" src="<?php echo SITE_TEMPLATE_PATH ?>/images/home.jpg" alt="" />
                    <? } ?>
                </div>
                <div class="seite">
                    <div class="headline">
                        <h2><? $APPLICATION->ShowTitle(); ?></h2>
                    </div>
                    <? if ($arCurDir[1] == ""): ?>
                        <a style="margin-left: -30px;" href="/products/vratarskie_perchatki/">
                            <img title="Gloves Overview" class="full" src="<?php echo SITE_TEMPLATE_PATH ?>/images/slide01.jpg" alt=""/>
                        </a>
                    <? endif; ?>

                    <div style="display: none;">
                        <?
                        $APPLICATION->IncludeComponent("bitrix:sale.basket.basket.line", "", array(
                            "PATH_TO_BASKET" => SITE_DIR . "personal/cart/",
                            "PATH_TO_PERSONAL" => SITE_DIR . "personal/",
                            "SHOW_PERSONAL_LINK" => "N",
                            "SHOW_NUM_PRODUCTS" => "Y",
                            "SHOW_TOTAL_PRICE" => "Y",
                            "SHOW_PRODUCTS" => "N",
                            "POSITION_FIXED" => "N"
                                ), false, array()
                        );
                        ?>
                    </div>
