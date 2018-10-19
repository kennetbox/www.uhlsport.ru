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


<div class="list-toolbar-athletes">
		<div class="content">
				<h2>Наши спорстмены</h2>
		</div>

		<?if($arParams["DISPLAY_TOP_PAGER"]):?>
			<?=$arResult["NAV_STRING"]?><br />
		<?endif;?>
		<?foreach($arResult["ITEMS"] as $arItem):?>
				<?
				$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
				$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
				?>
				<?
					$ID = $_REQUEST["ID"];
					if( $arItem["ID"] == $ID ) {
						$currPage = true;
					} else {
						$currPage = false;
					}
				?>
				<div class="content">
						<h2>
								<? if(!$currPage) { ?>
								<a href="<?=$arItem["DETAIL_PAGE_URL"]?>">
								<? } ?>
										<?echo $arItem["NAME"]?>
								<? if(!$currPage) { ?>
								</a>
								<? } ?>
						</h2>
				</div>
		<?endforeach;?>

</div><!-- [end list-toolbar-athletes] -->
				

