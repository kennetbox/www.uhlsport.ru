<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
	echo ShowError($arResult["ERROR_MESSAGE"]);

	$bDelayColumn  = false;
	$bDeleteColumn = false;
	$bWeightColumn = false;
	$bPropsColumn  = false;
	$bPriceType    = false;
?>

<?

	global $ORDER_PRICE, $DELIVERY_PRICE;

?>

<div class="cart-summary">
<h3>В корзине</h3>
<?
if ($normalCount > 0):
?>

<?
	$forms=array('товар', 'товара', 'товаров');
	function sklonenie($n, $forms) {
	  return $n%10==1&&$n%100!=11?$forms[0]:($n%10>=2&&$n%10<=4&&($n%100<10||$n%100>=20)?$forms[1]:$forms[2]);
	}
?>



	<?
	foreach ($arResult["GRID"]["ROWS"] as $k => $arItem):

		if ($arItem["DELAY"] == "N" && $arItem["CAN_BUY"] == "Y"):
	?>
<div class="item">
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
							$image = CFile::ResizeImageGet($file, array('width' => 150, 'height' => 100), BX_RESIZE_IMAGE_EXACT, true);
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
						
						<?/*
						<a href="<?=$detailURL ?>" class="product-image">
							<img src="<?=$url?>" width="150" height="100" alt="Ultra ShockSkin 5-pad EXT Thigh Impact Short" />
						</a>
						*/?>
						
						<small>ID: <span class="digit">#<?=$arItem["ID"]?></span></small>
						
						<h4 class="product-name">
							<?if (strlen($arItem["DETAIL_PAGE_URL"]) > 0):?>
							<a href="<?=$detailURL ?>">
							<?endif;?>
								<?=$arItem["NAME"]?>
							<?if (strlen($arItem["DETAIL_PAGE_URL"]) > 0):?>
							</a>
							<?endif;?>
						</h4>
						<div class="bx_ordercart_itemart">
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
						</div>
						
						<?
						if (is_array($arItem["SKU_DATA"]) && !empty($arItem["SKU_DATA"])):
						?>
						<p>
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
						</p>
						<?
						endif;
						?>
						
				<?
				elseif ($arHeader["id"] == "PRICE"):
				?>
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
					<span class="times">×</span>
					<span class="quantity digit"><?=$arItem["QUANTITY"]?></span>
					
				<?
				else:
				?>

			<? endif; ?>
			<? endforeach; ?>
</div>
	<?
		endif;
	endforeach;
	?>
	


<?
else:
?>

<?
endif;
?>
	
	<div class="total">
	
		<? if( isset($ORDER_PRICE) && !empty($ORDER_PRICE) && isset($DELIVERY_PRICE) && !empty($DELIVERY_PRICE) ) { ?>
		<table class="prices_table">
		<col width="20%" />
		<col width="80%" />
			<tr>
				<td>
					<b>Доставка:</b>
				</td>
				<td>
					<span class="price">
						<?=$DELIVERY_PRICE ?> руб.
					</span>
				</td>
			</tr>
			<tr>
				<td>
					<b>Итого:</b>
				</td>
				<td>
					<span class="price">
						<?=$ORDER_PRICE + $DELIVERY_PRICE ?> руб.
					</span>
				</td>
			</tr>
		</table>
		<? } else { ?>
		<b>Итого:</b>
			<span class="price"><?=str_replace(" ", "&nbsp;", $arResult["allSum_FORMATED"])?></span>
		<? } ?>
	</div>
</div>