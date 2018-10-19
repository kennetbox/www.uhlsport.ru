<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="container_16">
	<div class="feature_color">
		<div class="container_16">
			<div class="grid_16">
				<ul style="clear:both;" id="productlist" class="image-gridsmall">
				<?foreach ($arResult["ITEMS"] as $arItem){?>
					<li data-id="<?=$arItem["PROPERTIES"]["ARTNUMBER"]["VALUE"]?>" data-color="<?=$arItem["PROPERTIES"]["COLOR"]["VALUE"]?>">
						<a href="<?=$arItem["DETAIL_PAGE_URL"]?>">
							<img class="lazy" style="width: 80px; height: 80px; display: inline;" src="<?=MakeImage($arItem["DETAIL_PICTURE"]["SRC"], array('w'=>96,'h'=>96))?>" title="<?=$arItem["NAME"]?> (<?=$arItem["PROPERTIES"]["COLOR"]["VALUE"]?> <?=$arItem["PROPERTIES"]["ARTNUMBER"]["VALUE"]?>)">
						</a>
					</li>
				<?}?>
				</ul>
			</div>
		</div>
	</div>
</div>
