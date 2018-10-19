<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<? /* Способы оплаты */ ?>


<div class="cart-form-container">
	<div class="cart-form cart-form-payment">
	
		<?/*
			<input type="submit" name="contButton" value="<?= GetMessage("SALE_CONTINUE")?> &gt;&gt;" />
			<?echo GetMessage("STOF_PRIVATE_NOTES")?>
			<?echo GetMessage("STOF_PAYMENT_WAY")?>		
		*/?>
	
	<div class="fieldset">
	
		<?
		if ($arResult["PAY_FROM_ACCOUNT"]=="Y")
		{
			?>
			<!--<input type="hidden" name="PAY_CURRENT_ACCOUNT" value="Y">-->
			<div class="radio-field">
				
				<label>
					<input type="checkbox" name="PAY_CURRENT_ACCOUNT" id="PAY_CURRENT_ACCOUNT" value="Y"<?if($arResult["PAY_CURRENT_ACCOUNT"]!="N") echo " checked";?>> <label for="PAY_CURRENT_ACCOUNT"><b><?echo GetMessage("STOF_PAY_FROM_ACCOUNT")?></b></label>
				</label>
				
				<h4>
					<?=GetMessage("STOF_ACCOUNT_HINT1")?> <b><?=$arResult["CURRENT_BUDGET_FORMATED"]?></b> <?echo GetMessage("STOF_ACCOUNT_HINT2")?>
				</h4>
				
			</div>
			<?
		}
		?>
		
		<?
		if(count($arResult["PAY_SYSTEM"])>0)
		{
			?>
				
				<h3>
					Способ оплаты
				</h3>
				
				<?/*echo GetMessage("STOF_PAYMENT_HINT")*/?>

				<?
				foreach($arResult["PAY_SYSTEM"] as $arPaySystem) {
				?>
					<div class="radio-field">
						
						<label for="ID_PAY_SYSTEM_ID_<?= $arPaySystem["ID"] ?>">
							<input type="radio" id="ID_PAY_SYSTEM_ID_<?= $arPaySystem["ID"] ?>" name="PAY_SYSTEM_ID" value="<?= $arPaySystem["ID"] ?>"<?if ($arPaySystem["CHECKED"]=="Y") echo " checked";?> />
						</label>
						
						<h4>
							<?= $arPaySystem["PSA_NAME"] ?>
						</h4>
						
						<?
							if (strlen($arPaySystem["DESCRIPTION"])>0) {
								echo "<p>".$arPaySystem["DESCRIPTION"]."</p>";
							}
						?>
						
					</div>
				<?
				}
				?>

		<?
		}
		if ($arResult["HaveTaxExempts"]=="Y")
		{
			?>
			<div class="radio-field">
				
				<label>
					<input type="checkbox" name="TAX_EXEMPT" value="Y" checked> <b><?echo GetMessage("STOF_TAX_EX")?></b>
				</label>
				
				<h4>
					<?echo GetMessage("STOF_TAX_EX_PROMT")?>
				</h4>
				
			</div>
			<?
		}
		?>

	</div><!-- [end fieldset] -->

	<button class="cta cta-lg" type="submit" name="contButton" value="<?= GetMessage("SALE_CONTINUE")?>">Продолжить</button>
	
	<?if(!($arResult["SKIP_FIRST_STEP"] == "Y" && $arResult["SKIP_SECOND_STEP"] == "Y" && $arResult["SKIP_THIRD_STEP"] == "Y"))
	{
		?>

		<input class="dnone" id="backButton" type="submit" name="backButton" value="<?echo GetMessage("SALE_BACK_BUTTON")?>">
		<?/*
			<p class="comeback"><a id="comeback" href="#">Вернуться к адресу доставки</a></p>
		*/?>
		<p class="comeback"><a href="/personal/cart/">Вернуться в корзину</a></p>
		<script>
			jQuery(function($) {
				$('#comeback').click(function() {
					$('#backButton').trigger('click');
				});
			});
		</script>
		<?
	}
	?>
		
	<?/*
	<input type="submit" name="contButton" value="<?= GetMessage("SALE_CONTINUE")?> &gt;&gt;">
	*/?>

	</div><!-- [end cart-form cart-form-payment] -->

<?

	$GLOBALS['ORDER_PRICE']    = $arResult['ORDER_PRICE'];
	$GLOBALS['DELIVERY_PRICE'] = $arResult['DELIVERY_PRICE'];

	$APPLICATION->IncludeComponent(
		"bitrix:sale.basket.basket",
		"basket_shockdoctor_short",
		Array (
			"OFFERS_PROPS" => array("COLOR_REF"),
			"PATH_TO_ORDER" => "/personal/order.php",
			"HIDE_COUPON" => "N",
			"COLUMNS_LIST" => Array("NAME", "PRICE", "TYPE", "QUANTITY", "DELETE", "DELAY", "WEIGHT", "DISCOUNT"),
			"PRICE_VAT_SHOW_VALUE" => "Y",
			"COUNT_DISCOUNT_4_ALL_QUANTITY" => "N",
			"USE_PREPAYMENT" => "N",
			"QUANTITY_FLOAT" => "N",
			"SET_TITLE" => "Y",
			"ACTION_VARIABLE" => "action"
		)
	);
?>
	
</div><!-- [end cart-form-container] -->