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

global $arrFilter;

?>

<div class="list-header">
		<div class="list-header-contents">
				<div class="category-list-title">
						<h2>Команда Shock Doctor</h2>
				</div>
				<div class="category-list-title-right">

				</div>
		</div>
</div>

<div class="list-contents-athletes">
			
		<?
		// Левое меню раздела "Спортсмены"
		$APPLICATION->IncludeComponent(
			"bitrix:news.list",
			"athletes_menu",
			Array(
				"IBLOCK_TYPE" => "athletes_shockdoctor",
				"IBLOCK_ID" => "23",
				"NEWS_COUNT" => "100",
				"SORT_BY1" => "ACTIVE_FROM",
				"SORT_ORDER1" => "DESC",
				"SORT_BY2" => "SORT",
				"SORT_ORDER2" => "ASC",
				"FILTER_NAME" => "",
				"FIELD_CODE" => array(	// Поля
					0 => "NAME",
					1 => "LINK",
				),
				"PROPERTY_CODE" => array(	// Свойства
					0 => "",
				),
				"CHECK_DATES" => "Y",
				"DETAIL_URL" => "",
				"AJAX_MODE" => "N",
				"AJAX_OPTION_JUMP" => "N",
				"AJAX_OPTION_STYLE" => "Y",
				"AJAX_OPTION_HISTORY" => "N",
				"CACHE_TYPE" => "A",
				"CACHE_TIME" => "36000000",
				"CACHE_FILTER" => "N",
				"CACHE_GROUPS" => "Y",
				"PREVIEW_TRUNCATE_LEN" => "",
				"ACTIVE_DATE_FORMAT" => "d.m.Y",
				"SET_STATUS_404" => "N",
				"SET_TITLE" => "N",
				"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
				"ADD_SECTIONS_CHAIN" => "N",
				"HIDE_LINK_WHEN_NO_DETAIL" => "N",
				"PARENT_SECTION" => "",
				"PARENT_SECTION_CODE" => "",
				"INCLUDE_SUBSECTIONS" => "N",
				"PAGER_TEMPLATE" => ".default",
				"DISPLAY_TOP_PAGER" => "N",
				"DISPLAY_BOTTOM_PAGER" => "N",
				"PAGER_TITLE" => "Новости",
				"PAGER_SHOW_ALWAYS" => "N",
				"PAGER_DESC_NUMBERING" => "N",
				"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
				"PAGER_SHOW_ALL" => "N",
				"DISPLAY_DATE" => "Y",
				"DISPLAY_NAME" => "Y",
				"DISPLAY_PICTURE" => "Y",
				"DISPLAY_PREVIEW_TEXT" => "Y",
				"AJAX_OPTION_ADDITIONAL" => ""
			)
		);
		?>

		<div class="list-products-athletes">
			
			<?
				/*
				echo "<pre>";
					print_r( $arResult );
				echo "</pre>";
				
				$arResult["PROPERTIES"]["ATHLETS_SPORTS"]
				$arResult["PROPERTIES"]["ATHLETS_PHOTO_165_215"]
				
				$arResult["PROPERTIES"]["ATHLETS_GALLERY_683_431"]["VALUE"]
				
				$arResult["PROPERTIES"]["ATHLETS_SOCIAL"]
				$arResult["PROPERTIES"]["ATHLETS_BIOGRAPHY"]
				$arResult["PROPERTIES"]["ATHLETS_SPORTS_LIST"]
				$arResult["PROPERTIES"]["ATHLETS_RECOMENDED_PRODUCT"]["VALUE"]
				*/
			?>
			
			
			
			<div class="athlete-detail">
					<?
							$name_arr = explode(" ",$arResult["NAME"]);
							$name_parse = $name_arr[0]." <strong>".$name_arr[1]."</strong>";
					?>
					<h1>
						<?=$name_parse?>
					</h1>
					<? if($arResult["PROPERTIES"]["ATHLETS_SPORTS"]["VALUE"] != '') { ?>
							<h2>
									<?=$arResult["PROPERTIES"]["ATHLETS_SPORTS"]["VALUE"]?>
							</h2>
					<? } ?>
					
					<div class="space20"></div>

					<?
							$gallery = $arResult["PROPERTIES"]["ATHLETS_GALLERY_683_431"]["VALUE"];
							$count = count($gallery);
							if($count > 0) {
					?>
					<div id="images">
							<div class="athlete-photos">
									<? foreach($gallery as $key => $val) { ?>
											<div id="image-<?=($key + 1)?>" class="image-content athlete-photo">
													<?=CFile::ShowImage($val, 9999, 431, "border=0", "", false);?>
											</div>
									<? } ?>
							</div>
							<div class="space20"></div>
							<?
									// Ссылка на социальные сети
									if($arResult["PROPERTIES"]["ATHLETS_SOCIAL"]["VALUE"] != '') {
							?>
									<?=htmlspecialcharsBack( $arResult["PROPERTIES"]["ATHLETS_SOCIAL"]["VALUE"] ) ?>
							<?
									}
							?>
							<div class="space10"></div>
							<div class="bar"></div>
							<div class="space10"></div>
							
							<ul class="athlete-tabs">
									<? foreach($gallery as $key => $val) { ?>
									<li class="nav-current">
											<a href="#image-<?=($key + 1)?>">
													<?=CFile::ShowImage($val, 99999, 100, "border=0", "", false);?>
											</a>
									</li>
											<? if($key < ($count - 1)) { ?>
													<div class="sidespace"></div>
											<? } ?>
									<? } ?>
							</ul>
							
					</div>
					
					<?
							}
					?>
					
					
			</div> <!-- end athlete-detail -->

			<div class="space20"></div>

			<div class="tabs">
					<div id="tabs">
							<div class="bio-bar">
									<ul class="athlete-tabs">
											<li><a href="#tab-1"><h2>Биография</h2></a></li>
									</ul>
							</div>

							<div class="space20"></div>

							<div id="tab-1" class="tab-content">
									<div class="bio-left">
											
											<? // Биография
												echo htmlspecialcharsBack( $arResult["PROPERTIES"]["ATHLETS_BIOGRAPHY"]["VALUE"]["TEXT"] );
											?>
											
									</div>
									<div class="bio-right">
											<h1>
													Jack's Locker:
											</h1>


											
<?

$arrFilter = Array( "ID" => $arResult["PROPERTIES"]["ATHLETS_RECOMENDED_PRODUCT"]["VALUE"] );

$SECTION_ID = 0;

$APPLICATION->IncludeComponent(
    "bitrix:catalog.section",
    "athletes",
    Array(
        "TEMPLATE_THEME" => "blue",
        "PRODUCT_DISPLAY_MODE" => "N",
        "ADD_PICT_PROP" => "MORE_PHOTO",
        "LABEL_PROP" => "NEW_BOOK",
        "OFFER_ADD_PICT_PROP" => "FILE",
        "OFFER_TREE_PROPS" => array("-"),
        "PRODUCT_SUBSCRIPTION" => "N",
        "SHOW_DISCOUNT_PERCENT" => "N",
        "SHOW_OLD_PRICE" => "N",
        "MESS_BTN_BUY" => "Купить",
        "MESS_BTN_ADD_TO_BASKET" => "В корзину",
        "MESS_BTN_SUBSCRIBE" => "Подписаться",
        "MESS_BTN_DETAIL" => "Подробнее",
        "MESS_NOT_AVAILABLE" => "Нет в наличии",
        "AJAX_MODE" => "Y",

        "IBLOCK_TYPE" => "catalog",
        "IBLOCK_ID" => "16",
				
        "SECTION_ID" => $SECTION_ID,
        "SECTION_CODE" => "",
        "SECTION_USER_FIELDS" => array(),
        "ELEMENT_SORT_FIELD" => "sort",
        "ELEMENT_SORT_ORDER" => "asc",
        "ELEMENT_SORT_FIELD2" => "name",
        "ELEMENT_SORT_ORDER2" => "asc",
        "FILTER_NAME" => "arrFilter",
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
        "PAGE_ELEMENT_COUNT" => "30",
        "LINE_ELEMENT_COUNT" => "3",
        "PROPERTY_CODE" => array(
					0 => "NAME",
					1 => "LINK",
					2 => "DETAIL_PICTURE",
					2 => "MORE_PHOTO",
				),
        "OFFERS_FIELD_CODE" => array(
					0 => "NAME",
					1 => "LINK",
					3 => "SUBCAT_BASE_PRICE",
					4 => "MORE_PHOTO",
				),
        "OFFERS_PROPERTY_CODE" => array(),
        "OFFERS_SORT_FIELD" => "sort",
        "OFFERS_SORT_ORDER" => "asc",
        "OFFERS_SORT_FIELD2" => "active_from",
        "OFFERS_SORT_ORDER2" => "desc",
        "OFFERS_LIMIT" => "5",
        "PRICE_CODE" => Array ("0" => "BASE"),
        "USE_PRICE_COUNT" => "Y",
        "SHOW_PRICE_COUNT" => "1",
        "PRICE_VAT_INCLUDE" => "Y",
        "PRODUCT_PROPERTIES" => array(),
        "USE_PRODUCT_QUANTITY" => "Y",
        "CACHE_TYPE" => "A",
        "CACHE_TIME" => "36000000",
        "CACHE_FILTER" => "Y",
        "CACHE_GROUPS" => "Y",
        "DISPLAY_TOP_PAGER" => "N",
        "DISPLAY_BOTTOM_PAGER" => "N",
        "PAGER_TITLE" => "Товары",
        "PAGER_SHOW_ALWAYS" => "Y",
        "PAGER_TEMPLATE" => "",
        "PAGER_DESC_NUMBERING" => "Y",
        "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
        "PAGER_SHOW_ALL" => "Y",
        "HIDE_NOT_AVAILABLE" => "Y",
        "OFFERS_CART_PROPERTIES" => array(),
        "AJAX_OPTION_JUMP" => "N",
        "AJAX_OPTION_STYLE" => "Y",
        "AJAX_OPTION_HISTORY" => "N",
        "CONVERT_CURRENCY" => "Y",
        "CURRENCY_ID" => "RUB",
    )
);

?>
											
									</div>
							</div> <!-- end tab-content -->
					</div> <!-- end #tabs -->
			</div> <!-- end .tabs -->

			
		</div><!-- [end list-products-athletes] -->

</div><!-- [end list-contents-athletes] -->