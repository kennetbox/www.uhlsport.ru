<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<? /* Физическое, юридическое лицо */ ?>

<?/*
	<input type="submit" name="contButton" value="<?= GetMessage("SALE_CONTINUE")?> &gt;&gt;">
*/?>

<div class="cart-form-container">
	<div id="form-validate" class="cart-form">
		<div class="fieldset">
		
			<h3>
				Тип покупателей
			</h3>

			<div class="radio-field">
				<p>
					<? echo GetMessage("STOF_PROC_DIFFERS") ?>
					<br />
					<? echo GetMessage("STOF_PRIVATE_NOTES") ?>
				</p>
				<p>
					<? echo GetMessage("STOF_SELECT_PERS_TYPE") ?>
				</p>
			</div>
			
			<?	foreach($arResult["PERSON_TYPE_INFO"] as $v) { 	?>
			<div class="radio-field">
				<label>
					<input type="radio" id="PERSON_TYPE_<?= $v["ID"] ?>" name="PERSON_TYPE" value="<?= $v["ID"] ?>"<?if ($v["CHECKED"]=="Y") echo " checked";?> />
				</label>
				<h4>
					<?= $v["NAME"] ?>
				</h4>
			</div>	
			<?  }  ?>
			
			<button type="submit" class="cta cta-lg" name="contButton" value="<?= GetMessage("SALE_CONTINUE")?>">Продолжить</button>
			
			<p class="comeback"><a href="/personal/cart/">Вернуться в корзину</a></p>
		
		</div>
	</div>
	
	<?
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
	
</div>