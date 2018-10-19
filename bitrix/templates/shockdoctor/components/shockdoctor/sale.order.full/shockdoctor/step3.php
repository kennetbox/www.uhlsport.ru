<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<? /* Способы доставки */ ?>


<div class="cart-form-container">

<div class="cart-form">

<?/*
<div class="fieldset">
	<div class="radio-field">
		<p style="margin-right: 0px;">
			<?echo GetMessage("STOF_DELIVERY_NOTES")?>
			<?echo GetMessage("STOF_PRIVATE_NOTES")?>
			<?echo GetMessage("STOF_DELIVERY_PROMT")?>
			<?echo GetMessage("STOF_SELECT_DELIVERY")?>
		</p>
	</div>
</div>	
*/?>

<div class="fieldset">
	<? /* [Данные о пользователе] */ ?>
		<div class="fieldset">
			<h3>
				Персональные данные
			</h3>
			<div class="info">
				<? if($arResult["POST"]["ORDER_PROP_1"]) { ?><?=$arResult["POST"]["ORDER_PROP_1"]?>, <? } ?>
				<? if($arResult["POST"]["ORDER_PROP_2"]) { ?><?=$arResult["POST"]["ORDER_PROP_2"]?>, <? } ?>
				<? if($arResult["POST"]["ORDER_PROP_3"]) { ?><?=$arResult["POST"]["ORDER_PROP_3"]?>  <? } ?>
			</div>
		</div>
	<? /* [/Данные о пользователе] */ ?>
</div>

<div class="fieldset">
	<? /* [Адрес Доставки] */ ?>
		<div class="fieldset">
			<h3>
				Адрес Доставки
			</h3>
			<div class="info">
				<? if($arResult["POST"]["ORDER_PROP_20"]) { ?><?=$arResult["POST"]["ORDER_PROP_20"]?>, <? } ?>
				<br />
				<? if($arResult["POST"]["ORDER_PROP_4"]) { ?><?=$arResult["POST"]["ORDER_PROP_4"]?>, <? } ?>
				<? if($arResult["POST"]["ORDER_PROP_5"]) { ?><?=$arResult["POST"]["ORDER_PROP_5"]?>, <? } ?>
				<br />
				<? if($arResult["POST"]["ORDER_PROP_7"]) { ?><?=$arResult["POST"]["ORDER_PROP_7"]?>  <? } ?>
			</div>
		</div>
	<? /* [/Адрес Доставки] */ ?>	
</div>
	
<div class="fieldset">
	<h3>
		Способы доставки
	</h3>
	
	<?
		foreach ($arResult["DELIVERY"] as $delivery_id => $arDelivery) {
	?>
	<div style="margin-top: 35px; float: none;">
	
	<?
		if ($delivery_id !== 0 && intval($delivery_id) <= 0):
	?>
				
			<h3>
				<?=$arDelivery["TITLE"]?>
			</h3>
			
			<?if (strlen($arDelivery["DESCRIPTION"]) > 0):?>
				<?=nl2br($arDelivery["DESCRIPTION"])?>
			<?endif;?>

			<?
				foreach ($arDelivery["PROFILES"] as $profile_id => $arProfile)
				{
			?>
			<div class="radio-field">
				
				<label for="ID_DELIVERY_<?=$delivery_id?>_<?=$profile_id?>">
					<input type="radio" id="ID_DELIVERY_<?=$delivery_id?>_<?=$profile_id?>" name="<?=$arProfile["FIELD_NAME"]?>" value="<?=$delivery_id.":".$profile_id;?>" <?=$arProfile["CHECKED"] == "Y" ? "checked=\"checked\"" : "";?> />
				</label>
				
				<h4>
					<?=$arProfile["TITLE"]?>
				</h4>
				<?if (strlen($arProfile["DESCRIPTION"]) > 0):?>
				<p>
					<?=nl2br($arProfile["DESCRIPTION"])?>
				</p>
				<?endif;?>

				<?
					$APPLICATION->IncludeComponent('bitrix:sale.ajax.delivery.calculator', '', array(
						"NO_AJAX" => $arParams["SHOW_AJAX_DELIVERY_LINK"] == 'S' ? 'Y' : 'N',
						"DELIVERY" => $delivery_id,
						"PROFILE" => $profile_id,
						"ORDER_WEIGHT" => $arResult["ORDER_WEIGHT"],
						"ORDER_PRICE" => $arResult["ORDER_PRICE"],
						"LOCATION_TO" => $arResult["DELIVERY_LOCATION"],
						"LOCATION_ZIP" => $arResult['DELIVERY_LOCATION_ZIP'],
						"CURRENCY" => $arResult["BASE_LANG_CURRENCY"],
					));
				?>
				
				<?if ($arParams["SHOW_AJAX_DELIVERY_LINK"] == 'N'):?>
				<script type="text/javascript">deliveryCalcProceed({STEP:1,DELIVERY:'<?=CUtil::JSEscape($delivery_id)?>',PROFILE:'<?=CUtil::JSEscape($profile_id)?>',WEIGHT:'<?=CUtil::JSEscape($arResult["ORDER_WEIGHT"])?>',PRICE:'<?=CUtil::JSEscape($arResult["ORDER_PRICE"])?>',LOCATION:'<?=intval($arResult["DELIVERY_LOCATION"])?>',CURRENCY:'<?=CUtil::JSEscape($arResult["BASE_LANG_CURRENCY"])?>'})</script>
				<?endif;?>
					
			</div>
			<?
				} // endforeach
			?>

		<?
			else:
		?>
		<div class="radio-field">
			
			<label for="ID_DELIVERY_ID_<?= $arDelivery["ID"] ?>">	
				<input type="radio" id="ID_DELIVERY_ID_<?= $arDelivery["ID"] ?>" name="<?=$arDelivery["FIELD_NAME"]?>" value="<?= $arDelivery["ID"] ?>"<?if ($arDelivery["CHECKED"]=="Y") echo " checked";?>>
			</label>	
			
			<h4>
				<?= $arDelivery["NAME"] ?> [<?/*=GetMessage("SALE_DELIV_PRICE");*/?><?=$arDelivery["PRICE_FORMATED"]?>]
			</h4>
			
			<p>
				<?
				if (strlen($arDelivery["PERIOD_TEXT"])>0)
				{
					echo $arDelivery["PERIOD_TEXT"];
				}
				?>
				
				<? 	if (strlen($arDelivery["DESCRIPTION"])>0) {  ?>
						<?=$arDelivery["DESCRIPTION"]?>
				<? 	}  ?>
			</p>
		
		</div>
		<?  endif; ?>
	</div>
	<?  } // endforeach ?>
	<?
	//endif;
	?>

</div>
	
<div class="clearfix">

	<button id="contButton" type="submit" name="contButton" value="<?= GetMessage("SALE_CONTINUE")?>" class="cta cta-lg">Продолжить</button>
	<?/*
	<input type="submit" name="contButton" value="<?= GetMessage("SALE_CONTINUE")?>" />
	*/?>
	<?	if(!($arResult["SKIP_FIRST_STEP"] == "Y" && $arResult["SKIP_SECOND_STEP"] == "Y")) { ?>
		<input id="backButton" class="dnone" type="submit" name="backButton" value="<?echo GetMessage("SALE_BACK_BUTTON")?>">
		<?/*
			<p class="comeback"><a id="comeback" href="#">Вернуться к адресу доставки</a></p>
		*/?>
		
		<p class="comeback"><a href="/personal/cart/">Вернуться в корзину</a></p>
		
		<script>
			jQuery(function($) {
				$('#comeback').bind('click', function(e) {
					e.preventDefault();
					
					$('#backButton').trigger('click');
					
					return false;
				});
			});
		</script>
	<? } ?>

</div><!-- [end clearfix] -->
	
</div><!-- [end cart-form-container] -->
	
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
	
</div><!-- [end cart-form] -->


