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

				<?foreach($arResult["ITEMS"] as $key => $arItem):?>
					<?
					$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
					$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
					?>
					
					<div class="grid" <? if($key == 1) { ?>style="clear: left"<? } ?>>
							<a href="<?=$arItem["DETAIL_PAGE_URL"]?>">
									<?=CFile::ShowImage($arItem["PROPERTIES"]["ATHLETS_PHOTO_165_215"]["VALUE"], 9999, 215, "border=0", "", true);?>
									<div class="text">
											<?
													$name_arr = explode(" ",$arItem["NAME"]);
													$name_parse = $name_arr[0]." <strong>".$name_arr[1]."</strong>";
											?>
											<h2>
												<?=$name_parse?>
											</h2>
											<? if($arItem["PROPERTIES"]["ATHLETS_SPORTS_LIST"]["VALUE"] != '') { ?>
											<h3><?=$arItem["PROPERTIES"]["ATHLETS_SPORTS_LIST"]["VALUE"] ?></h3>
											<? } ?>
									</div>
							</a>
					</div>
					
					<?
					/*
					
						$arItem["PROPERTIES"]["ATHLETS_SPORTS"]
						$arItem["PROPERTIES"]["ATHLETS_PHOTO_165_215"]
						
						$arItem["PROPERTIES"]["ATHLETS_GALLERY_683_431"]["VALUE"]
						
						$arItem["PROPERTIES"]["ATHLETS_SOCIAL"]
						$arItem["PROPERTIES"]["ATHLETS_BIOGRAPHY"]
						$arItem["PROPERTIES"]["ATHLETS_SPORTS_LIST"]
						$arItem["PROPERTIES"]["ATHLETS_RECOMENDED_PRODUCT"]["VALUE"]
					
					*/
					?>
				<?endforeach;?>
				
		</div><!-- [end list-products-athletes] -->

</div><!-- [end list-contents-athletes] -->

