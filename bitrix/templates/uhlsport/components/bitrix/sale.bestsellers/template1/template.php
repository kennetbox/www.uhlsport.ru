<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** @var CBitrixComponentTemplate $this */
/** @var array $arParams */
/** @var array $arResult */
/** @global CDatabase $DB */

$this->setFrameMode(true);
?>
<div class="container_16">
	<div class="grid16">
		<ul class="image-grid">
			<?
			foreach($arResult["ITEMS"] as $arItem){
			?>
				<li>
					<a href="<?=$arItem["DETAIL_PAGE_URL"]?>">
						<img alt="<?=$arItem["DETAIL_PICTURE"]["ALT"]?>" title="<?=$arItem["DETAIL_PICTURE"]["TITLE"]?>" src="<?=$arItem["DETAIL_PICTURE"]["SRC"]?>">
						<h4><?=$arItem["NAME"]?></h4>
						<div class="articlenumber">
							<?=$arItem["PROPERTIES"]["ARTNUMBER"]["VALUE"]?>
						</div>
						<div class="color">
							<?
							foreach ($arItem["PROPERTIES"]["COLOR"]["VALUE"] as $arColor){
								echo $arColor."/";
							}
							?>
						</div>
						<span class="price"><?=$arItem["PRICES"]["BASE"]["PRINT_VALUE_NOVAT"]?></span>
						<?if($arItem["PROPERTIES"]["NEWPRODUCT"]["VALUE_ENUM_ID"] == "1"){?><span class="new"></span><?}?>
					</a>
				</li>
			<?
			}
			?>
		</ul>
	</div>
</div>