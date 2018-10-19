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
// Форма поиска по каталогу, результаты поиска списком
$arElements = $APPLICATION->IncludeComponent(
	"bitrix:search.page",
	"shockdoctor-result",
	Array(
		"RESTART" => $arParams["RESTART"],
		"NO_WORD_LOGIC" => $arParams["NO_WORD_LOGIC"],
		"USE_LANGUAGE_GUESS" => $arParams["USE_LANGUAGE_GUESS"],
		"CHECK_DATES" => $arParams["CHECK_DATES"],
		"arrFILTER" => array("iblock_".$arParams["IBLOCK_TYPE"]),
		"arrFILTER_iblock_".$arParams["IBLOCK_TYPE"] => array($arParams["IBLOCK_ID"]),
		"USE_TITLE_RANK" => "N",
		"DEFAULT_SORT" => "rank",
		"FILTER_NAME" => "",
		"SHOW_WHERE" => "N",
		"arrWHERE" => array(),
		"SHOW_WHEN" => "N",
		"PAGE_RESULT_COUNT" => 50,
		"DISPLAY_TOP_PAGER" => "N",
		"DISPLAY_BOTTOM_PAGER" => "N",
		"PAGER_TITLE" => "",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => "N",
	),
	$component
);

?>

<?

// Результаты поиска по каталогу

if (!empty($arElements) && is_array($arElements)) {
		global $searchFilter;
		
		// Направления сортировки
		$sort = (isset($_REQUEST["sort"]) && $_REQUEST["sort"])? $_REQUEST["sort"] : "BASE";
		$order = (isset($_REQUEST["order"]) && $_REQUEST["order"])? $_REQUEST["order"] : "ASC";
		
		$searchFilter = array(
			"=ID" => $arElements,
		);
		$APPLICATION->IncludeComponent(
		"bitrix:catalog.section",
		"shockdoctor-search",
		array(
		
		
			"TEMPLATE_THEME" => "blue",
			"PRODUCT_DISPLAY_MODE" => "Y",
			"ADD_PICT_PROP" => "MORE_PHOTO",
			"LABEL_PROP" => "-",
			"OFFER_ADD_PICT_PROP" => "-",
			"OFFER_TREE_PROPS" => array(
				0 => "-",
				1 => "COLOR_REF",
			),
			"PRODUCT_SUBSCRIPTION" => "N",
			"SHOW_DISCOUNT_PERCENT" => "N",
			"SHOW_OLD_PRICE" => "N",
			"MESS_BTN_BUY" => "Купить",
			"MESS_BTN_ADD_TO_BASKET" => "В корзину",
			"MESS_BTN_SUBSCRIBE" => "Подписаться",
			"MESS_BTN_DETAIL" => "Подробнее",
			"MESS_NOT_AVAILABLE" => "Нет в наличии",
			"AJAX_MODE" => "N",
			"IBLOCK_TYPE" => "catalog",
			"IBLOCK_ID" => "16",
			"SECTION_ID" => $SECTION_ID,
			"SECTION_CODE" => "",
			"SECTION_USER_FIELDS" => array(
				0 => "",
				1 => "",
			),
			
			"ELEMENT_SORT_FIELD" => $sort,
			"ELEMENT_SORT_ORDER" => $order,
			
			"ELEMENT_SORT_FIELD2" => "name",
			"ELEMENT_SORT_ORDER2" => "asc",
			
			"FILTER_NAME" => "searchFilter",
			
			"INCLUDE_SUBSECTIONS" => "Y",
			"SHOW_ALL_WO_SECTION" => "Y",
			"SECTION_URL" => "",
			"DETAIL_URL" => "",
			"BASKET_URL" => "/personal/basket.php",
			"ACTION_VARIABLE" => "action",
			"PRODUCT_ID_VARIABLE" => "id",
			"PRODUCT_QUANTITY_VARIABLE" => "quantity",
			"ADD_PROPERTIES_TO_BASKET" => "Y",
			"PRODUCT_PROPS_VARIABLE" => "prop",
			"PARTIAL_PRODUCT_PROPERTIES" => "N",
			"SECTION_ID_VARIABLE" => "SECTION_ID",
			"ADD_SECTIONS_CHAIN" => "Y",
			"DISPLAY_COMPARE" => "N",
			"SET_TITLE" => "Y",
			"SET_BROWSER_TITLE" => "Y",
			"BROWSER_TITLE" => "-",
			"SET_META_KEYWORDS" => "Y",
			"META_KEYWORDS" => "",
			"SET_META_DESCRIPTION" => "Y",
			"META_DESCRIPTION" => "",
			"SET_STATUS_404" => "N",
			"PAGE_ELEMENT_COUNT" => "100000",
			"LINE_ELEMENT_COUNT" => "100000",
			"PROPERTY_CODE" => array(
				0 => "NEWPRODUCT",
				1 => "SALELEADER",
				2 => "SPECIALOFFER",
				3 => "",
				4 => "",
			),
			"OFFERS_FIELD_CODE" => array(
				0 => "NAME",
				1 => "PREVIEW_PICTURE",
				2 => "DETAIL_PICTURE",
				3 => "",
			),
			"OFFERS_PROPERTY_CODE" => array(
				0 => "ARTNUMBER",
				1 => "SPORT_TYPE",
				2 => "MORE_PHOTO",
				3 => "SIZES_CLOTHES",
				4 => "COLOR_REF",
				5 => "",
			),
			
			"OFFERS_SORT_FIELD" => $sort,
			"OFFERS_SORT_ORDER" => $order,
			
			"OFFERS_SORT_FIELD2" => "active_from",
			"OFFERS_SORT_ORDER2" => "desc",
			"OFFERS_LIMIT" => "100",
			"PRICE_CODE" => array(
				0 => "BASE",
			),
			"USE_PRICE_COUNT" => "Y",
			"SHOW_PRICE_COUNT" => "1",
			"PRICE_VAT_INCLUDE" => "Y",
			"PRODUCT_PROPERTIES" => array(
				0 => "SPORT_TYPE",
				1 => "SIZE_SH",
				2 => "COLOR",
				3 => "",
				4 => "",
			),
			"USE_PRODUCT_QUANTITY" => "Y",
			"CACHE_TYPE" => "A",
			"CACHE_TIME" => "36000000",
			"CACHE_FILTER" => "N",
			"CACHE_GROUPS" => "N",
			"DISPLAY_TOP_PAGER" => "N",
			"DISPLAY_BOTTOM_PAGER" => "N",
			"PAGER_TITLE" => "Товары",
			"PAGER_SHOW_ALWAYS" => "N",
			"PAGER_TEMPLATE" => "",
			"PAGER_DESC_NUMBERING" => "Y",
			"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
			"PAGER_SHOW_ALL" => "Y",
			"HIDE_NOT_AVAILABLE" => "Y",
			"OFFERS_CART_PROPERTIES" => array(
				0 => "ARTNUMBER",
				1 => "SPORT_TYPE",
				2 => "SIZES_SHOES",
				3 => "SIZES_CLOTHES",
				4 => "COLOR_REF",
				5 => "",
			),
			"AJAX_OPTION_JUMP" => "N",
			"AJAX_OPTION_STYLE" => "N",
			"AJAX_OPTION_HISTORY" => "N",
			"CONVERT_CURRENCY" => "Y",
			"CURRENCY_ID" => "RUB",
			"AJAX_OPTION_ADDITIONAL" => ""
		
			/*
			"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
			"IBLOCK_ID" => $arParams["IBLOCK_ID"],
			
			//"ELEMENT_SORT_FIELD" => $arParams["ELEMENT_SORT_FIELD"],
			//"ELEMENT_SORT_ORDER" => $arParams["ELEMENT_SORT_ORDER"],
			
			"ELEMENT_SORT_FIELD" => $sort,
			"ELEMENT_SORT_ORDER" => $order,
			
			"ELEMENT_SORT_FIELD2" => $arParams["ELEMENT_SORT_FIELD2"],
			"ELEMENT_SORT_ORDER2" => $arParams["ELEMENT_SORT_ORDER2"],
			"PAGE_ELEMENT_COUNT" => $arParams["PAGE_ELEMENT_COUNT"],
			"LINE_ELEMENT_COUNT" => $arParams["LINE_ELEMENT_COUNT"],
			
			// "PROPERTY_CODE" => $arParams["PROPERTY_CODE"],
			
			"PROPERTY_CODE" => array(
				0 => "NEWPRODUCT",
				1 => "SALELEADER",
				2 => "SPECIALOFFER",
				3 => "",
				4 => "",
			),
			
			//"OFFERS_CART_PROPERTIES" => $arParams["OFFERS_CART_PROPERTIES"],
			
			"OFFERS_CART_PROPERTIES" => array(
				0 => "ARTNUMBER",
				1 => "SPORT_TYPE",
				2 => "SIZES_SHOES",
				3 => "SIZES_CLOTHES",
				4 => "COLOR_REF",
				5 => "",
			),
			
			//"OFFERS_FIELD_CODE" => $arParams["OFFERS_FIELD_CODE"],
			
			"OFFERS_FIELD_CODE" => array(
				0 => "NAME",
				1 => "PREVIEW_PICTURE",
				2 => "DETAIL_PICTURE",
				3 => "",
			),
			
			//"OFFERS_PROPERTY_CODE" => $arParams["OFFERS_PROPERTY_CODE"],
			
			"OFFERS_PROPERTY_CODE" => array(
				0 => "ARTNUMBER",
				1 => "SPORT_TYPE",
				2 => "MORE_PHOTO",
				3 => "SIZES_CLOTHES",
				4 => "COLOR_REF",
				5 => "",
			),
			
			//"OFFERS_SORT_FIELD" => $arParams["OFFERS_SORT_FIELD"],
			//"OFFERS_SORT_ORDER" => $arParams["OFFERS_SORT_ORDER"],
			
			"OFFERS_SORT_FIELD" => $sort,
			"OFFERS_SORT_ORDER" => $order,
			
			"OFFERS_SORT_FIELD2" => $arParams["OFFERS_SORT_FIELD2"],
			"OFFERS_SORT_ORDER2" => $arParams["OFFERS_SORT_ORDER2"],
			"OFFERS_LIMIT" => $arParams["OFFERS_LIMIT"],
			"SECTION_URL" => $arParams["SECTION_URL"],
			"DETAIL_URL" => $arParams["DETAIL_URL"],
			"BASKET_URL" => $arParams["BASKET_URL"],
			"ACTION_VARIABLE" => $arParams["ACTION_VARIABLE"],
			"PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
			"PRODUCT_QUANTITY_VARIABLE" => $arParams["PRODUCT_QUANTITY_VARIABLE"],
			"PRODUCT_PROPS_VARIABLE" => $arParams["PRODUCT_PROPS_VARIABLE"],
			"SECTION_ID_VARIABLE" => $arParams["SECTION_ID_VARIABLE"],
			"CACHE_TYPE" => $arParams["CACHE_TYPE"],
			"CACHE_TIME" => $arParams["CACHE_TIME"],
			"DISPLAY_COMPARE" => $arParams["DISPLAY_COMPARE"],
			"PRICE_CODE" => $arParams["PRICE_CODE"],
			"USE_PRICE_COUNT" => $arParams["USE_PRICE_COUNT"],
			"SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],
			"PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],
			"PRODUCT_PROPERTIES" => $arParams["PRODUCT_PROPERTIES"],
			"USE_PRODUCT_QUANTITY" => $arParams["USE_PRODUCT_QUANTITY"],
			"CONVERT_CURRENCY" => $arParams["CONVERT_CURRENCY"],
			"CURRENCY_ID" => $arParams["CURRENCY_ID"],
			"HIDE_NOT_AVAILABLE" => $arParams["HIDE_NOT_AVAILABLE"],
			"DISPLAY_TOP_PAGER" => $arParams["DISPLAY_TOP_PAGER"],
			"DISPLAY_BOTTOM_PAGER" => $arParams["DISPLAY_BOTTOM_PAGER"],
			"PAGER_TITLE" => $arParams["PAGER_TITLE"],
			"PAGER_SHOW_ALWAYS" => $arParams["PAGER_SHOW_ALWAYS"],
			"PAGER_TEMPLATE" => $arParams["PAGER_TEMPLATE"],
			"PAGER_DESC_NUMBERING" => $arParams["PAGER_DESC_NUMBERING"],
			"PAGER_DESC_NUMBERING_CACHE_TIME" => $arParams["PAGER_DESC_NUMBERING_CACHE_TIME"],
			"PAGER_SHOW_ALL" => $arParams["PAGER_SHOW_ALL"],
			"FILTER_NAME" => "searchFilter",
			
			"SECTION_ID" => "",
			"SECTION_CODE" => "",
			
			"SECTION_USER_FIELDS" => array(),
			"INCLUDE_SUBSECTIONS" => "Y",
			"SHOW_ALL_WO_SECTION" => "Y",
			"META_KEYWORDS" => "",
			"META_DESCRIPTION" => "",
			"BROWSER_TITLE" => "",
			"ADD_SECTIONS_CHAIN" => "N",
			"SET_TITLE" => "N",
			"SET_STATUS_404" => "N",
			"CACHE_FILTER" => "N",
			"CACHE_GROUPS" => "N",
			*/
		),
		$arResult["THEME_COMPONENT"]
	);
}
else
{
	echo GetMessage("CT_BCSE_NOT_FOUND");
}

?>

