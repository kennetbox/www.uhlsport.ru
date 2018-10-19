<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
echo ShowError($arResult["ERROR_MESSAGE"]);

$bDelayColumn  = false;
$bDeleteColumn = false;
$bWeightColumn = false;
$bPropsColumn  = false;
$bPriceType    = false;

if ($normalCount > 0):
?>

<?
	$forms=array('товар', 'товара', 'товаров');
	function sklonenie($n, $forms) {
	  return $n%10==1&&$n%100!=11?$forms[0]:($n%10>=2&&$n%10<=4&&($n%100<10||$n%100>=20)?$forms[1]:$forms[2]);
	}
?>

<div id="basket_items_list">
	<div id="shopping-cart-table" class="bx_ordercart_order_table_container">
		<table id="basket_items" class="data-table cart-table">

			<thead>
				<tr>
					<?
					$count = 0;
					foreach ($arResult["GRID"]["HEADERS"] as $id => $arHeader):
						$arHeader["name"] = (isset($arHeader["name"]) ? (string)$arHeader["name"] : '');
						if ($arHeader["name"] == '')
							$arHeader["name"] = GetMessage("SALE_".$arHeader["id"]);
						$arHeaders[] = $arHeader["id"];

						// remember which values should be shown not in the separate columns, but inside other columns
						if (in_array($arHeader["id"], array("TYPE")))
						{
							$bPriceType = true;
							continue;
						}
						elseif ($arHeader["id"] == "PROPS")
						{
							$bPropsColumn = true;
							continue;
						}
						elseif ($arHeader["id"] == "DELAY")
						{
							$bDelayColumn = true;
							continue;
						}
						elseif ($arHeader["id"] == "DELETE")
						{
							$bDeleteColumn = true;
							continue;
						}
						elseif ($arHeader["id"] == "WEIGHT")
						{
							$bWeightColumn = true;
						}

						if ($arHeader["id"] == "NAME"):
						?>
							<td class="image-column" id="col_<?=$arHeader["id"];?>">
						<?
						elseif ($arHeader["id"] == "PRICE"):
						?>
							<td class="price-column" id="col_<?=$arHeader["id"];?>">
						<?
						elseif ($arHeader["id"] == "QUANTITY"):
						?>
							<td class="qnty-column" id="col_<?=$arHeader["id"];?>">
						<?
						else:
						?>
							<td class="total-column" id="col_<?=$arHeader["id"];?>">
						<?
						endif;
						?>
							<? if($count == 0) { ?>
								В корзине <?=$normalCount?> <?=sklonenie($normalCount, $forms)?>
							<? } else {?>
								<?=$arHeader["name"]; ?>
							<? } ?>
							</td>
							<?
								if($arHeader["id"] == 'NAME') {
							?>
								<td class="title-column"></td>
							<?
								}
							?>
					<?
					$count++;
					endforeach;

					?>
				</tr>
			</thead>

			<tbody>
				<?
				foreach ($arResult["GRID"]["ROWS"] as $k => $arItem):

					if ($arItem["DELAY"] == "N" && $arItem["CAN_BUY"] == "Y"):
				?>
					<tr id="<?=$arItem["ID"]?>">
						<?
						foreach ($arResult["GRID"]["HEADERS"] as $id => $arHeader):

							if (in_array($arHeader["id"], array("PROPS", "DELAY", "DELETE", "TYPE"))) // some values are not shown in the columns in this template
								continue;

							if ($arHeader["id"] == "NAME"):
							?>
								<td class="itemphoto image-column">

								<?
									$IBLOCK_ID = 17;
									$ELEMENT_ID = $arItem["PRODUCT_ID"];
									$arSelect = Array( "ID", "IBLOCK_ID", "CODE", "NAME", "URL", "DATE_ACTIVE_FROM", "PROPERTY_MORE_PHOTO" ); //IBLOCK_ID и ID обязательно должны быть указаны, см. описание arSelectFields выше
									$arFilter = Array( "IBLOCK_ID" => IntVal($IBLOCK_ID), "ID" => $ELEMENT_ID, "ACTIVE_DATE" => "Y", "ACTIVE" =>"Y" );
									$res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize"=>50), $arSelect); 
									$addINFO = '';
									while($ob = $res->GetNextElement()){ 
										$arProps = $ob->GetProperties();
										$photoID = $arProps["MORE_PHOTO"]["VALUE"][0];

										$arFile = CFile::GetFileArray( $photoID );
										$file = CFile::ResizeImageGet($arFile, array('width'=>150, 'height'=>100), BX_RESIZE_IMAGE_PROPORTIONAL, true);                
										if(empty($file['src'])) {
											$img = '<img src="'.$APPLICATION->GetTemplatePath().'images/empty.gif" src="background: transparent url('.$APPLICATION->GetTemplatePath().'images/no_photo.png) no-repeat 50% 50%" width="150" height="100" />';
										} else {
											$img = '<img src="'.$file['src'].'" width="'.$file['width'].'" height="'.$file['height'].'" />';
										}
										if( !empty($arProps["COLOR_REF"]["VALUE"]) ) {
											$addINFO .= $arProps["COLOR_REF"]["VALUE"].",";
										}
										if( !empty($arProps["SIZES_SHOES"]["VALUE"]) ) {
											$addINFO .= $arProps["SIZES_SHOES"]["VALUE"];
										}
										if( !empty($arProps["SIZES_CLOTHES"]["VALUE"]) ) {
											$addINFO .= $arProps["SIZES_CLOTHES"]["VALUE"];
										}
									}

									$IBLOCK_ID = 16;
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
									
									/*
									if ( strlen($arItem["PREVIEW_PICTURE_SRC"] ) > 0):
										$url = $arItem["PREVIEW_PICTURE_SRC"];
									elseif ( strlen($arItem["DETAIL_PICTURE_SRC"] ) > 0):
										$url = $arItem["DETAIL_PICTURE_SRC"];
									elseif (strlen( $image['src'] ) > 0):
										$url = $image['src'];
									else:
										$url = $templateFolder."/images/no_photo.png";
									endif;
									*/
									?>
								
									<a href="<?=$detailURL ?>" class="product-image">
										<?=$img?>
										<?/*
										<img src="<?=$url?>" width="150" height="100" alt="Ultra ShockSkin 5-pad EXT Thigh Impact Short" />
										*/?>
									</a>

								</td>
								<td class="item title-column">
									<h2 class="product-name">
										<?if (strlen($arItem["DETAIL_PAGE_URL"]) > 0):?>
										<a href="<?=$detailURL ?>">
										<?endif;?>
											<?=$arItem["NAME"]?>
										<?if (strlen($arItem["DETAIL_PAGE_URL"]) > 0):?>
										</a>
										<?endif;?>
									</h2>
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
									<p class="item-options">
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

											<?
											else:
											?>

												<?
												foreach ($arProp["VALUES"] as $valueId => $arSkuValue):

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

											<?
											endif;
										endforeach;
									?>
									</p>
									<?
									endif;
									?>
									
									<?
										if ($bDeleteColumn):
									?>
										<a class="btn-remove btn-remove2" href="<?=str_replace("#ID#", $arItem["ID"], $arUrls["delete"])?>" title="Удалить">Удалить из корзины</a>
									<?
										endif;
									?>

								</td>
							<?
							elseif ($arHeader["id"] == "QUANTITY"):
							?>
								<td class="qnty-column">

									<?
										$ratio = isset($arItem["MEASURE_RATIO"]) ? $arItem["MEASURE_RATIO"] : 0;
										$max = isset($arItem["AVAILABLE_QUANTITY"]) ? "max=\"".$arItem["AVAILABLE_QUANTITY"]."\"" : "";
										$useFloatQuantity = ($arParams["QUANTITY_FLOAT"] == "Y") ? true : false;
										$useFloatQuantityJS = ($useFloatQuantity ? "true" : "false");
									?>
									
									<?
										if (!isset($arItem["MEASURE_RATIO"])) {
											$arItem["MEASURE_RATIO"] = 1;
										}
									?>
									
									<?  if ( floatval($arItem["MEASURE_RATIO"]) != 0 ): ?>
										<a href="javascript:void(0);" class="qty-btn minus" onclick="setQuantity(<?=$arItem["ID"]?>, <?=$arItem["MEASURE_RATIO"]?>, 'down', <?=$useFloatQuantityJS?>);"></a>
									<? 	endif; ?>
									
									<input
										type="text"
										size="3"
										id="QUANTITY_INPUT_<?=$arItem["ID"]?>"
										name="QUANTITY_INPUT_<?=$arItem["ID"]?>"
										size="2" 
										class="input-text qty"
										maxlength="18"
										min="0"
										<?=$max?>
										step="<?=$ratio?>"
										style="max-width: 50px"
										value="<?=$arItem["QUANTITY"]?>"
										onchange="updateQuantity('QUANTITY_INPUT_<?=$arItem["ID"]?>', '<?=$arItem["ID"]?>', <?=$ratio?>, <?=$useFloatQuantityJS?>)"
									>

									<?  if ( floatval($arItem["MEASURE_RATIO"]) != 0 ): ?>
										<a href="javascript:void(0);" class="qty-btn plus" onclick="setQuantity(<?=$arItem["ID"]?>, <?=$arItem["MEASURE_RATIO"]?>, 'up', <?=$useFloatQuantityJS?>);"></a>
									<? 	endif; ?>
									
									<?/*
									if (isset($arItem["MEASURE_TEXT"]))
									{
										?>
											<?=$arItem["MEASURE_TEXT"]?>
										<?
									}
									*/?>

									<input type="hidden" id="QUANTITY_<?=$arItem['ID']?>" name="QUANTITY_<?=$arItem['ID']?>" value="<?=$arItem["QUANTITY"]?>" />
								</td>
							<?
							elseif ($arHeader["id"] == "PRICE"):
							?>
								<td class="price-column">
								
									<span class="cart-price">
										<span class="price" id="current_price_<?=$arItem["ID"]?>">
											<?=$arItem["PRICE_FORMATED"]?>
										</span>
										<span class="price" id="old_price_<?=$arItem["ID"]?>">
											<?if (floatval($arItem["DISCOUNT_PRICE_PERCENT"]) > 0):?>
												<?=$arItem["FULL_PRICE_FORMATED"]?>
											<?endif;?>
										</span>

										<?if ($bPriceType && strlen($arItem["NOTES"]) > 0):?>
											<span class="price"><?=GetMessage("SALE_TYPE")?></span>
											<br />
											<span class="price"><?=$arItem["NOTES"]?></span>
										<?endif;?>
									</span>
									
								</td>
							<?
							elseif ($arHeader["id"] == "DISCOUNT"):
							?>
								<td class="custom">
									<span class="cart-price">
										<span class="price" id="discount_value_<?=$arItem["ID"]?>"><?=$arItem["DISCOUNT_PRICE_PERCENT_FORMATED"]?></span>
									</span>
								</td>
							<?
							elseif ($arHeader["id"] == "WEIGHT"):
							?>
								<td class="custom">
									<span class="cart-price">
										<span class="price">
											<?=$arItem["WEIGHT_FORMATED"]?>
										</span>
									</span>
								</td>
							<?
							else:
							?>
								<td class="custom">
									<span class="cart-price">
										<span class="price">
										<? if ($arHeader["id"] == "SUM"): ?>
											<div id="sum_<?=$arItem["ID"]?>">
										<? endif; ?>
										<? echo $arItem[$arHeader["id"]]; ?>
										<? if ($arHeader["id"] == "SUM"): ?>
											</div>
										<? endif; ?>
										</span>
									</span>
								</td>
							<?
							endif;
						endforeach;
						?>

					</tr>
					<?
					endif;
				endforeach;
				?>
			</tbody>
		</table>
		<table>
			<tr>
				<td style="padding: 0px;"></td>
				<td style="padding: 0px;"></td>
				<td style="padding: 0px;"></td>
				<td style="padding: 0px;"></td>
				<td style="padding: 0px;"></td>
			</tr>
			<tr>
				<td style="padding: 0px;"></td>
				<td style="padding: 0px;"></td>
				<td style="padding: 0px;"></td>
				<td style="padding: 0px;"></td>
				<td style="padding: 0px;"></td>
			</tr>
		</table>
	</div>
	<input type="hidden" id="column_headers" value="<?=CUtil::JSEscape(implode($arHeaders, ","))?>" />
	<input type="hidden" id="offers_props" value="<?=CUtil::JSEscape(implode($arParams["OFFERS_PROPS"], ","))?>" />
	<input type="hidden" id="action_var" value="<?=CUtil::JSEscape($arParams["ACTION_VARIABLE"])?>" />
	<input type="hidden" id="quantity_float" value="<?=$arParams["QUANTITY_FLOAT"]?>" />
	<input type="hidden" id="count_discount_4_all_quantity" value="<?=($arParams["COUNT_DISCOUNT_4_ALL_QUANTITY"] == "Y") ? "Y" : "N"?>" />
	<input type="hidden" id="price_vat_show_value" value="<?=($arParams["PRICE_VAT_SHOW_VALUE"] == "Y") ? "Y" : "N"?>" />
	<input type="hidden" id="hide_coupon" value="<?=($arParams["HIDE_COUPON"] == "Y") ? "Y" : "N"?>" />
	<input type="hidden" id="coupon_approved" value="N" />
	<input type="hidden" id="use_prepayment" value="<?=($arParams["USE_PREPAYMENT"] == "Y") ? "Y" : "N"?>" />

	<div class="bx_ordercart_order_pay">

		<div class="shopping-cart-totals">
			<div class="inner">
				<p>
					<small>Сумма заказа:</small>
					<span class="price" id="allSum_FORMATED"><?=str_replace(" ", "&nbsp;", $arResult["allSum_FORMATED"])?></span>
				</p>
				<a class="checkout cta cta-lg" href="javascript:void(0)" onclick="checkOut();"><?=GetMessage("SALE_ORDER")?></a>
				<!--
				<button type="submit" class="cta cta-lg">Оформить заказ</button>
				-->
			</div>
		</div>
		
	</div>
	
</div>
<?
else:
?>
<div id="basket_items_list">
	<table>
		<tbody>
			<tr>
				<td colspan="<?=$numCells?>" style="text-align:center">
					<div class=""><?=GetMessage("SALE_NO_ITEMS");?></div>
				</td>
			</tr>
		</tbody>
	</table>
</div>
<?
endif;
?>