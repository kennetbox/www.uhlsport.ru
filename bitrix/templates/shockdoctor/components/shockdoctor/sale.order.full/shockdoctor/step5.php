<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<? /* Подтвердить заказ */ ?>

<div class="cart-form-confirm">

		<?/*
			<input type="submit" name="contButton" value="<?= GetMessage("SALE_CONFIRM")?>" />
			<? echo GetMessage("STOF_CORRECT_PROMT_NOTE") ?>
			<? echo GetMessage("STOF_CONFIRM_NOTE") ?>
			<? echo GetMessage("STOF_CORRECT_ADDRESS_NOTE") ?>
			<? echo GetMessage("STOF_PRIVATE_NOTES") ?>
		*/?>
	
	<div class="confirm-info cf">

		<p>Проверьте свой заказ еще раз</p>
		
		<div class="confirm-info-col">
			
			<div class="item">
				<h3>Персональные данные</h3>
				<p>
					<?
					if(!empty($arResult["ORDER_PROPS_PRINT"]))
					{
						?>

							<?/*echo GetMessage("STOF_ORDER_PARAMS")*/?>

							<?
							$count = 0;

							
							foreach($arResult["ORDER_PROPS_PRINT"] as $arProperties) {
								if($arProperties["PROPS_GROUP_ID"] > 1) {
									continue;
								}
								if ($arProperties["SHOW_GROUP_NAME"] == "Y") {
									?>

									<?/*= $arProperties["GROUP_NAME"]."" */?>

									<?
								}
								
								if(strLen($arProperties["VALUE_FORMATED"])>0) {
								?><?/*= $arProperties["NAME"] */?><? if($count > 0) { ?>, <? } ?><?=$arProperties["VALUE_FORMATED"]?>
								<?
								}
								$count++;
							}
							?>
	
						<?
					}
					?>
				</p>
			</div>
			
			<div class="item">
				<h3><?= GetMessage("SALE_PAY_SUBTITLE")?></h3>
				
				<? if(is_array($arResult["PAY_SYSTEM"]) || $arResult["PAY_SYSTEM"]=="ERROR" || $arResult["PAYED_FROM_ACCOUNT"] == "Y") { ?>
					<p>
						<?
						if($arResult["PAYED_FROM_ACCOUNT"] == "Y")
							echo " (".GetMessage("STOF_PAYED_FROM_ACCOUNT").")";
						elseif (is_array($arResult["PAY_SYSTEM"]))
						{
							echo $arResult["PAY_SYSTEM"]["PSA_NAME"];
						}
						elseif ($arResult["PAY_SYSTEM"]=="ERROR")
						{
							echo ShowError(GetMessage("SALE_ERROR_PAY_SYS"));
						}
						elseif($arResult["PAYED_FROM_ACCOUNT"] != "Y")
						{
							echo GetMessage("STOF_NOT_SET");
						}
						
						?>
					</p>
				<? 	} ?>
			</div>
			
		</div>
		<div class="confirm-info-col">
			
			<div class="item">
				<h3>Адрес доставки</h3>
				<p>
					<?
					$count = 0;
					foreach($arResult["ORDER_PROPS_PRINT"] as $arProperties) {
						if($arProperties["PROPS_GROUP_ID"] < 1) {
							continue;
						}
						if ($arProperties["SHOW_GROUP_NAME"] == "Y") {
							?>

							<?/*= $arProperties["GROUP_NAME"]."" */?>

							<?
						}
						
						if(strLen($arProperties["VALUE_FORMATED"])>0) {
						?><?/*= $arProperties["NAME"] */?><? if($count > 0) { ?>, <? } ?><?=$arProperties["VALUE_FORMATED"]?>
						<?
						}
						$count++;
					}
					?>
				</p>
			</div>
			
			<div class="item">
				<h3>
					<?= GetMessage("SALE_DELIV_SUBTITLE")?>
				</h3>
				<p>
					<?
					if (is_array($arResult["DELIVERY"]))
					{
						echo $arResult["DELIVERY"]["NAME"];
						if (is_array($arResult["DELIVERY_ID"]))
						{
							echo " (".$arResult["DELIVERY"]["PROFILES"][$arResult["DELIVERY_PROFILE"]]["TITLE"].")";
						}
					}
					elseif ($arResult["DELIVERY"]=="ERROR")
					{
						echo ShowError(GetMessage("SALE_ERROR_DELIVERY"));
					}
					else
					{
						echo GetMessage("SALE_NO_DELIVERY");
					}
					?>
				</p>
			</div>
		</div>
	</div>

	<?
		$APPLICATION->IncludeComponent(
			"bitrix:sale.basket.basket",
			"basket_shockdoctor_long",
			Array (
				"OFFERS_PROPS" => array("COLOR_REF"),
				"PATH_TO_ORDER" => "/personal/order.php",
				"HIDE_COUPON" => "N",
				"COLUMNS_LIST" => Array(
					"NAME","PRICE","QUANTITY","SUM","PROPS","DELETE","DELAY"
				),
				"PRICE_VAT_SHOW_VALUE" => "Y",
				"COUNT_DISCOUNT_4_ALL_QUANTITY" => "N",
				"USE_PREPAYMENT" => "N",
				"QUANTITY_FLOAT" => "N",
				"SET_TITLE" => "Y",
				"ACTION_VARIABLE" => "action"
			)
		);
	?>

	<table id="shopping-cart-table" class="data-table cart-table">
		<tr class="notice-row <? if( count($arResult["BASKET_ITEMS"]) < 1 ) { ?>notice-row-top<? } ?>">
			<td class="image-column"></td>
			<td class="title-column">
			
				<?
				if (is_array($arResult["DELIVERY"]))
				{
					echo $arResult["DELIVERY"]["NAME"];
					if (is_array($arResult["DELIVERY_ID"]))
					{
						echo " (".$arResult["DELIVERY"]["PROFILES"][$arResult["DELIVERY_PROFILE"]]["TITLE"].")";
					}
				}
				elseif ($arResult["DELIVERY"]=="ERROR")
				{
					echo ShowError(GetMessage("SALE_ERROR_DELIVERY"));
				}
				else
				{
					echo GetMessage("SALE_NO_DELIVERY");
				}
				?>
			
			</td>
			<td class="price-column"></td>
			<td class="qnty-column"></td>
			<td class="total-column">
				<span class="cart-price">
					<span class="price"><?=$arResult["DELIVERY"]["PRICE"] ?> руб.</span>                            
				</span>
			</td>
		</tr>
	</table>
	
	
		<div class="shopping-cart-totals cf">
			<div class="order-comment">
				<label class="field-label" for="comment"><span>Комментарий к заказу:</span></label>
				<div class="input-box">
					<textarea rows="10" id="comment" name="ORDER_DESCRIPTION" title="Комментарий к заказу" class="input-text"><?=$arResult["ORDER_DESCRIPTION"]?></textarea>
				</div>
			</div>

			<div class="inner">
				<p>
					<small>Итого:</small>
					<span class="price"><?=$arResult["ORDER_TOTAL_PRICE_FORMATED"]?></span>
				</p>
				<?/*
				<input type="submit" name="contButton" value="<?= GetMessage("SALE_CONFIRM")?>" />
				*/?>
				<button class="cta cta-lg" type="submit" name="contButton" value="<?= GetMessage("SALE_CONFIRM")?>">Оформить заказ</button>
				<span class="notice">После подтверждения заказа наш менеджер свяжется с вами, чтобы подтвердить его детали.</span>
			</div>
		</div>


		
		<?
		
		/*
			if(!($arResult["SKIP_FIRST_STEP"] == "Y" && $arResult["SKIP_SECOND_STEP"] == "Y" && $arResult["SKIP_THIRD_STEP"] == "Y" && $arResult["SKIP_FORTH_STEP"] == "Y"))
			{
				?>
				
				<input type="submit" name="backButton" value="<?echo GetMessage("SALE_BACK_BUTTON")?>" />
				
				<?
			}
		*/?>
		
		

</div><!-- [end cart-form-confirm] -->
