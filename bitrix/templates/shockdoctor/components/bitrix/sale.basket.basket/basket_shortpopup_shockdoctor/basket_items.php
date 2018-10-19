<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
	echo ShowError($arResult["ERROR_MESSAGE"]);
/*
	$bDelayColumn  = false;
	$bDeleteColumn = false;
	$bWeightColumn = false;
	$bPropsColumn  = false;
	$bPriceType    = false;
	*/
?>

<p class="block-subtitle">
	<span onclick="Enterprise.TopCart.hideCart()" class="close-btn">
		<img src="<?=SITE_TEMPLATE_PATH?>/images/close-button.png" alt="Close">
	</span>
	<span class="title">Корзина</span>
</p>

<?
if ($normalCount > 0):
?>

<?
	/*
	$forms=array('товар', 'товара', 'товаров');
	function sklonenie($n, $forms) {
	  return $n%10==1&&$n%100!=11?$forms[0]:($n%10>=2&&$n%10<=4&&($n%100<10||$n%100>=20)?$forms[1]:$forms[2]);
	}
	*/
?>

<table class="mini-products-list" id="mini-cart">
<tbody class="last odd">
	<?
	foreach ($arResult["GRID"]["ROWS"] as $k => $arItem):

		if ($arItem["DELAY"] == "N" && $arItem["CAN_BUY"] == "Y"):
	?>
<tr>
	<?
	foreach ($arResult["GRID"]["HEADERS"] as $id => $arHeader):

		if (in_array($arHeader["id"], array("PROPS", "DELAY", "DELETE", "TYPE"))) // some values are not shown in the columns in this template
			continue;

		if ($arHeader["id"] == "NAME"):
		?>
		
			<?
				$IBLOCK_ID = 16; 
				$arInfo = CCatalogSKU::GetInfoByProductIBlock($IBLOCK_ID);
				if (is_array($arInfo)) {
					$arSelect = Array("ID", "NAME", "PROPERTY_MORE_PHOTO");
					$rsOffers = CIBlockElement::GetList(array(), array( 'IBLOCK_ID' => $arInfo['IBLOCK_ID'], 'ID' => $arItem["PRODUCT_ID"] ), $arSelect); 
					$count = 0;
					while ($arOffer = $rsOffers->GetNext()) {
					if($count > 0) continue;
					$file = CFile::GetFileArray( $arOffer["PROPERTY_MORE_PHOTO_VALUE"] );
					$image = CFile::ResizeImageGet($file, array('width' => 63, 'height' => 63), BX_RESIZE_IMAGE_EXACT, true);
					$count++;
					} 
				}
				
				$elementID = explode("#", $arItem['PRODUCT_XML_ID']);
				//$arSelect = Array("ID", "NAME", "LINK");
				$rsElement = CIBlockElement::GetList(array(), array( 'IBLOCK_ID' => $IBLOCK_ID, 'ID' => $elementID[0] )); 
				$count = 0;
				$detailURL = '/catalog/';
				while( $arElement = $rsElement->GetNext() ) {
					$res = CIBlockSection::GetByID($arElement['IBLOCK_SECTION_ID']);
					if($ar_res = $res->GetNext()) {
						$detailURL .= $ar_res['CODE'].'/';
					}
					$detailURL .= $arElement['CODE'].'/';
				}									

				if ( strlen($arItem["PREVIEW_PICTURE_SRC"] ) > 0):
					$url = $arItem["PREVIEW_PICTURE_SRC"];
				elseif ( strlen($arItem["DETAIL_PICTURE_SRC"] ) > 0):
					$url = $arItem["DETAIL_PICTURE_SRC"];
				elseif (strlen( $image['src'] ) > 0):
					$url = $image['src'];
				else:
					$url = $templateFolder."/images/no_photo.png";
				endif;
				
				?>

			<td class="imagerow">
				<a class="product-image" href="<?=$detailURL ?>" title="<?=$arItem["NAME"]?>">
					<img src="<?=$url?>"  width="63" height="63" alt="<?=$arItem["NAME"]?>" />
				</a>
			</td>
				
			<td>
				<h2 class="product-name">
					<?if (strlen($arItem["DETAIL_PAGE_URL"]) > 0):?>
					<a href="<?=$detailURL ?>">
					<?endif;?>
						<?=$arItem["NAME"]?>
					<?if (strlen($arItem["DETAIL_PAGE_URL"]) > 0):?>
					</a>
					<?endif;?>
				</h2>

				<dl class="item-options">
					<?
					if ($bPropsColumn):
						foreach ($arItem["PROPS"] as $val):

							if (is_array($arItem["SKU_DATA"]))
							{
								$bSkip = false;
								foreach ($arItem["SKU_DATA"] as $propId => $arProp)
								{
									if ($arProp["CODE"] == $val["CODE"])
									{
										$bSkip = true;
										break;
									}
								}
								if ($bSkip)
									continue;
							}

							echo $val["NAME"].":&nbsp;<span>".$val["VALUE"]."<span><br/>";
						endforeach;
					endif;
					?>
				</dl>

				<?
				if (is_array($arItem["SKU_DATA"]) && !empty($arItem["SKU_DATA"])):
				?>
				<dl class="item-options">
				<?
					foreach ($arItem["SKU_DATA"] as $propId => $arProp):

						// if property contains images or values
						$isImgProperty = false;
						if (array_key_exists('VALUES', $arProp) && is_array($arProp["VALUES"]) && !empty($arProp["VALUES"]))
						{
							foreach ($arProp["VALUES"] as $id => $arVal)
							{
								if (isset($arVal["PICT"]) && !empty($arVal["PICT"]) && is_array($arVal["PICT"])
									&& isset($arVal["PICT"]['SRC']) && !empty($arVal["PICT"]['SRC']))
								{
									$isImgProperty = true;
									break;
								}
							}
						}
						$countValues = count($arProp["VALUES"]);
						$full = ($countValues > 5) ? "full" : "";

						if ($isImgProperty): // iblock element relation property
						?>
							
							<? if( count($arProp["VALUES"]) > 0 ) { ?>
							
								<?
								foreach ($arProp["VALUES"] as $valueId => $arSkuValue):

									$selected = "";
									foreach ($arItem["PROPS"] as $arItemProp):
										if ($arItemProp["CODE"] == $arItem["SKU_DATA"][$propId]["CODE"])
										{
											if ($arItemProp["VALUE"] == $arSkuValue["NAME"] || $arItemProp["VALUE"] == $arSkuValue["XML_ID"])
												$selected = "bx_active";
										}
									endforeach;
								?>
								<?
									if($selected == "bx_active") {
								?>
									<?=$arSkuValue["NAME"]?>
								<?
									}
								?>
								<?
								endforeach;
								?>
							
							<? } ?>
							
						<?
						else:
						?>
						
						<? if( count($arProp["VALUES"]) > 0 ) { ?>

							<?
							foreach ($arProp["VALUES"] as $valueId => $arSkuValue):
							?>
							<?
								$selected = "";
								foreach ($arItem["PROPS"] as $arItemProp):
									if ($arItemProp["CODE"] == $arItem["SKU_DATA"][$propId]["CODE"])
									{
										if ($arItemProp["VALUE"] == $arSkuValue["NAME"])
											$selected = "bx_active";
									}
								endforeach;
							?>
							<?
								if($selected == "bx_active") {
							?>
								<?=", ".$arSkuValue["NAME"]?>
							<?
								}
							?>
							<? 
							endforeach;
							?>

						<? } ?>
						
					<? endif; ?>
					<? endforeach; ?>
				</dl>
				<?
				endif;
				?>
				<div class="qnty-column"><span class="qnty-title">QTY:</span> <?=$arItem["QUANTITY"]?></div>
			</td>
		<?
		elseif ($arHeader["id"] == "PRICE"):
		?>
			<td class="a-right price-column">
				<span class="cart-price"><span class="price"><?=$arItem["PRICE_FORMATED"]?></span></span>
				<a class="btn-remove btn-remove2" href="<?=str_replace("#ID#", $arItem["ID"], $arUrls["delete"])?>" title="Удалить">Удалить</a>
			</td>
			<?/*
			<span class="price">
				<span id="current_price_<?=$arItem["ID"]?>">
					<?=$arItem["PRICE_FORMATED"]?>
				</span>
				<span id="old_price_<?=$arItem["ID"]?>">
					<?if (floatval($arItem["DISCOUNT_PRICE_PERCENT"]) > 0):?>
						<?=$arItem["FULL_PRICE_FORMATED"]?>
					<?endif;?>
				</span>

				<?if ($bPriceType && strlen($arItem["NOTES"]) > 0):?>
					<span><?=GetMessage("SALE_TYPE")?></span>
					<br />
					<span><?=$arItem["NOTES"]?></span>
				<?endif;?>
			</span>
			*/?>
		<?
		else:
		?>

	<? endif; ?>
	<? endforeach; ?>
</tr>
<?
		endif;
	endforeach;
?>
</tbody>
</table>
	
	<p class="totals submit-bottom-bg">
		<span class="label">Итого:</span> <span class="price"><?=str_replace(" ", "&nbsp;", $arResult["allSum_FORMATED"])?></span>
	</p>
	
	<div class="continue-shopping">
		<a onclick="Enterprise.TopCart.hideCart(); return false;" href="#">Продолжить покупки</a>
	</div>

	<div class="checkout-buttons">
		<?/* <button class="button cta" type="button" onclick="Enterprise.TopCart.hideCart(); windowsInstances.loginCheckout.show()"> */?>
		<p class="cta cta-popup">
			<a href="/personal/cart/">Оформить заказ</a>
		</p>
		<?/* </button> */?>
	</div>
	
<?
else:
?>
	
	<p class="cart-empty">У Вас нет товаров в корзине.</p>

<?
endif;
?>
	
	<script type="text/javascript">
		Enterprise.TopCart.initialize('topCartContent', 'cartHeader', '/');
		// Below can be used to show minicart after item added
		// Enterprise.TopCart.showCart(7);
	</script>	
	