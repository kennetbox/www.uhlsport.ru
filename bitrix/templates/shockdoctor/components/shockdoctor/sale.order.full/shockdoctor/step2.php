<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<? /* Адрес доставки */ ?>

<?
	// Для Гостя - прозрачная регистрация
	$isGuest = (string) htmlspecialchars ( $_REQUEST['ptype'] );
	$currentStep = (int) htmlspecialchars( $_REQUEST['CurrentStep'] );
	if(isset($currentStep) && $currentStep > 0 && $isGuest == 'guest') {
		$arResult["CurrentStep"] = 2;
	}
?>

<div class="cart-form-container">
<div class="cart-form">

<? if($isGuest == 'guest') { ?>

<div class="fieldset">
	<div class="radio-field">
		
		<label style="width: 100%;" for="ID_PROFILE_ID_0">
			<input type="radio" onclick="SetContact(true)" value="0" id="ID_PROFILE_ID_0" name="PROFILE_ID" style="float: right;" checked="checked">
			<input type="hidden" name="CurrentStep" value="<?=$arResult["CurrentStep"] ?>" />
			<input type="hidden" name="ptype" value="not<?=$isGuest ?>" />
			<h4 style="float: left;">Новый профиль</h4>
		</label>
		
	</div>
</div>

<div id="sof-prof-div" style="display: block;">
			
<div class="fieldset">

	<div style="margin-top: 35px; float: none;">
		<h3>Личные данные [Новый профиль]</h3>
		<div class="field ">
			<label class="field-label" for="input_FIO">Ф.И.О.:<span class="sof-req">*</span></label>
			<div class="input-box">
				<input class="required input-text" type="text" name="ORDER_PROP_1" value="" size="40" maxlength="250" />
			</div><!-- [end input-box] -->
		</div><!-- [end field] -->
	</div><!-- [end radio-field] -->
	
	<div style="margin-top: 35px; float: none;">
		<div class="field ">
			<label class="field-label" for="input_EMAIL">E-Mail:<span class="sof-req">*</span></label>
			<div class="input-box">
				<input class="required email input-text" type="text" name="ORDER_PROP_2" value="" size="40" maxlength="250" />
			</div><!-- [end input-box] -->
		</div><!-- [end field] -->
	</div><!-- [end radio-field] -->
	
	<div style="margin-top: 35px; float: none;">
		<div class="field ">
			<label class="field-label" for="input_PHONE">Телефон:<span class="sof-req">*</span></label>
			<div class="input-box">
				<input class="required input-text" type="text" name="ORDER_PROP_3" value="" size="0" maxlength="250" />
			</div><!-- [end input-box] -->
		</div><!-- [end field] -->
	</div><!-- [end radio-field] -->
	
	<div style="margin-top: 35px; float: none;">
		<div class="field checkbox">
			<label for="input_NEW_ARRIVALS">Я хочу узнать первым о новых поступлениях:</label>
			<input type="checkbox" value="Y" name="ORDER_PROP_21" id="input_NEW_ARRIVALS" />
		</div><!-- [end field] -->
	</div><!-- [end radio-field] -->
	
	<div style="margin-top: 35px; float: none;">
		<h3>Данные для доставки [Новый профиль]</h3>
		<div class="field ">
			<label class="field-label" for="input_COUNTRY">Страна:</label>
			<div class="input-box">
			
				<?
					// выведем выпадающий список стран
					$COUNTRY_ID = 1; // Выделяем Россию
					$countries = GetCountryArray();
					$country_name = '';
					foreach($countries['reference_id'] as $key => $val ) {
						if($val == 1) {
							$country_name = $countries['reference'][$key];
						}							
					}

					echo SelectBoxFromArray(
						"COUNTRY_ID", 
						GetCountryArray(), 
						$COUNTRY_ID, 
						"< выберите страну >",
						"class='input-text select-country'"
					);
					
				?>
				
				<input id="COUNTRY_INPUT" class="input-text" type="hidden" maxlength="250" value="<? if( !empty($arProperties["VALUE"]) ) { ?><?=$arProperties["VALUE"] ?><? } else { ?><?=$country_name ?><? } ?>" name="ORDER_PROP_20" />
				
				<script>
					jQuery(function($) {
						$(document).on('change', 'select.select-country', function() {
							
							var value = $(this).find("option:selected").text();
							
							$('#COUNTRY_INPUT').val( value );
						
						});
					});
				</script>
			</div><!-- [end input-box] -->
							
		</div><!-- [end field] -->
	</div><!-- [end radio-field] -->
	
	<div style="margin-top: 35px; float: none;">
		<div class="field ">
			<label class="field-label" for="input_ZIP">Индекс:</label>
			<div class="input-box">
				<input class="input-text" type="text" name="ORDER_PROP_4" value="" size="8" maxlength="250" />
			</div><!-- [end input-box] -->
		</div><!-- [end field] -->
	</div><!-- [end radio-field] -->
	
	<div style="margin-top: 35px; float: none;">
		<div class="field">
			<label class="field-label" for="input_CITY">Город:</label>
			<div class="input-box">
				<input type="text" name="ORDER_PROP_5" value="" size="40" maxlength="250" class="input-text">
			</div><!-- [end input-box] -->
		</div><!-- [end field] -->
	</div><!-- [end radio-field] -->
	
	<div style="margin-top: 35px; float: none;">
		<div class="field ">
			<label class="field-label" for="input_ADDRESS">Адрес доставки:<span class="sof-req">*</span></label>
			<div class="input-box">
				<textarea class="required input-text" name="ORDER_PROP_7" cols="30" rows="3"></textarea>
			</div><!-- [end input-box] -->
		</div><!-- [end field] -->
	</div><!-- [end radio-field] -->

</div><!-- [end fieldset] -->

</div><!-- [end sof-prof-div] -->

<? } else { ?>

<?
if (!function_exists('PrintPropsForm')) {
	function PrintPropsForm($arSource=Array(), $PRINT_TITLE = "", $arParams) {
		if (!empty($arSource)) {
?>

<div class="fieldset">

	<?
	foreach($arSource as $arProperties)
	{
	?>
	<div style="margin-top: 35px; float: none;">
	<?
		if($arProperties["SHOW_GROUP_NAME"] == "Y")
		{
	?>
		<h3>
			<?= $arProperties["GROUP_NAME"] ?><? if (strlen($PRINT_TITLE) > 0) { ?> [<?= $PRINT_TITLE ?>]<? }  ?>
		</h3>
	<?
		}
		?>
		
		<div class="field <? if($arProperties["TYPE"] == "CHECKBOX") { ?>checkbox<? } ?>">
			
			<label for="input_<?=$arProperties["CODE"] ?>" <? if($arProperties["TYPE"] != "CHECKBOX") { ?>class="field-label"<? } ?>>
				<?= $arProperties["NAME"] ?>:
				<?
				if($arProperties["REQUIED_FORMATED"]=="Y")
				{
					?><span class="sof-req">*</span><?
				}
				?>
			</label>

			<?
			if($arProperties["TYPE"] == "CHECKBOX")
			{
				?>
				
				<input id="input_<?=$arProperties["CODE"] ?>" type="checkbox" name="<?=$arProperties["FIELD_NAME"]?>" value="Y"<?if ($arProperties["CHECKED"]=="Y") echo " checked";?> />
				
				<?
			}
			elseif($arProperties["TYPE"] == "TEXT")
			{
				?>
				<div class="input-box">
					<? if($arProperties["CODE"] == 'COUNTRY') { ?>
						
						<?
							// выведем выпадающий список стран
							$COUNTRY_ID = 1; // Выделяем Россию
							$countries = GetCountryArray();
							$country_name = '';
							foreach($countries['reference_id'] as $key => $val ) {
								if($val == 1) {
									$country_name = $countries['reference'][$key];
								}							
							}

							echo SelectBoxFromArray(
								"COUNTRY_ID", 
								GetCountryArray(), 
								$COUNTRY_ID, 
								"< выберите страну >",
								"class='input-text select-country'"
							);
							
						?>
					
						<input id="COUNTRY_INPUT" class="input-text" type="hidden" maxlength="250" size="<?=$arProperties["SIZE1"]?>" value="<? if( !empty($arProperties["VALUE"]) ) { ?><?=$arProperties["VALUE"] ?><? } else { ?><?=$country_name ?><? } ?>" name="<?=$arProperties["FIELD_NAME"]?>" />
						
						<script>
							jQuery(function($) {
								$(document).on('change', 'select.select-country', function() {
									
									var value = $(this).find("option:selected").text();
									
									$('#COUNTRY_INPUT').val( value );
								
								});
							});
						</script>
						
					<? } else { ?>
					
						<input class="<? if($arProperties["REQUIED_FORMATED"]=="Y"){ ?>required <? } ?>input-text" type="text" maxlength="250" size="<?=$arProperties["SIZE1"]?>" value="<?=$arProperties["VALUE"]?>" name="<?=$arProperties["FIELD_NAME"]?>" />
					
					<? } ?>
				</div><!-- [end input-box] -->
				<?
			}
			elseif($arProperties["TYPE"] == "SELECT")
			{
				?>
				<div class="input-box">
					<select class="input-text" name="<?=$arProperties["FIELD_NAME"]?>" size="<?=$arProperties["SIZE1"]?>">
					<?  foreach($arProperties["VARIANTS"] as $arVariants) {  ?>
						<option value="<?=$arVariants["VALUE"]?>"<?if ($arVariants["SELECTED"] == "Y") echo " selected";?>><?=$arVariants["NAME"]?></option>
					<?  }  ?>
					</select>
				</div><!-- [end input-box] -->
				<?
			}
			elseif ($arProperties["TYPE"] == "MULTISELECT")
			{
				?>
				<div class="input-box">
					<select class="input-text" multiple name="<?=$arProperties["FIELD_NAME"]?>" size="<?=$arProperties["SIZE1"]?>">
					<?
					foreach($arProperties["VARIANTS"] as $arVariants)
					{
						?>
						<option value="<?=$arVariants["VALUE"]?>"<?if ($arVariants["SELECTED"] == "Y") echo " selected";?>><?=$arVariants["NAME"]?></option>
						<?
					}
					?>
					</select>
				</div><!-- [end input-box] -->
				<?
			}
			elseif ($arProperties["TYPE"] == "TEXTAREA")
			{
				?>
				<div class="input-box">
					<textarea class="<? if($arProperties["REQUIED_FORMATED"]=="Y"){ ?>required <? } ?>input-text" rows="<?=$arProperties["SIZE2"]?>" cols="<?=$arProperties["SIZE1"]?>" name="<?=$arProperties["FIELD_NAME"]?>"><?=$arProperties["VALUE"]?></textarea>
				</div><!-- [end input-box] -->
				<?
			}
			elseif ($arProperties["TYPE"] == "LOCATION")
			{
				$value = 0;
				foreach ($arProperties["VARIANTS"] as $arVariant)
				{
					if ($arVariant["SELECTED"] == "Y")
					{
						$value = $arVariant["ID"];
						break;
					}
				}

				if ($arParams["USE_AJAX_LOCATIONS"] == "Y"):
					$GLOBALS["APPLICATION"]->IncludeComponent(
						"bitrix:sale.ajax.locations",
						".default",
						array(
							"AJAX_CALL" => "N",
							"COUNTRY_INPUT_NAME" => "COUNTRY_".$arProperties["FIELD_NAME"],
							"REGION_INPUT_NAME" => "REGION_".$arProperties["FIELD_NAME"],
							"CITY_INPUT_NAME" => $arProperties["FIELD_NAME"],
							"CITY_OUT_LOCATION" => "Y",
							"LOCATION_VALUE" => $value,
							"ORDER_PROPS_ID" => $arProperties["ID"],
							"ONCITYCHANGE" => "",
						),
						null,
						array('HIDE_ICONS' => 'Y')
					);
				else:
				?>
				<div class="input-box">
					<select class="input-text" name="<?=$arProperties["FIELD_NAME"]?>" size="<?=$arProperties["SIZE1"]?>">
					<?
					foreach($arProperties["VARIANTS"] as $arVariants)
					{
						?>
						<option value="<?=$arVariants["ID"]?>"<?if ($arVariants["SELECTED"] == "Y") echo " selected";?>><?=$arVariants["NAME"]?></option>
						<?
					}
					?>
					</select>
				</div><!-- [end input-box] -->
				<?
				endif;
			}
			elseif ($arProperties["TYPE"] == "RADIO")
			{
				foreach($arProperties["VARIANTS"] as $arVariants)
				{
					?>
					<div class="input-box">
						<input type="radio" name="<?=$arProperties["FIELD_NAME"]?>" id="<?=$arProperties["FIELD_NAME"]?>_<?=$arVariants["ID"]?>" value="<?=$arVariants["VALUE"]?>"<?if($arVariants["CHECKED"] == "Y") echo " checked";?>> <label for="<?=$arProperties["FIELD_NAME"]?>_<?=$arVariants["ID"]?>"><?=$arVariants["NAME"]?></label>
					</div><!-- [end input-box] -->
					<?
				}
			}

			if (strlen($arProperties["DESCRIPTION"]) > 0)
			{
				?>
					<small>
						<?echo $arProperties["DESCRIPTION"] ?>
					</small>
				<?
			}
			?>
			
		</div><!-- [end field] -->
	</div><!-- [end radio-field] -->
	
		<?
	}
	?>
	
</div><!-- [end fieldset] -->

<?
			return true;
		}
		return false;
	}
}
?>

		<?/*
		<input type="submit" name="contButton" value="<?= GetMessage("SALE_CONTINUE")?>" />
		*/?>
		
		<?/*
		<div class="radio-field">
			<p style="margin-right: 0px;">
				<?echo GetMessage("STOF_CORRECT_NOTE")?>
			</p>
			<p style="margin-right: 0px;">
				<?echo GetMessage("STOF_PRIVATE_NOTES")?>
			</p>
		</div>
		<br />
		<br />
		*/?>
		
		<?
		$bPropsPrinted = PrintPropsForm($arResult["PRINT_PROPS_FORM"]["USER_PROPS_N"], GetMessage("SALE_INFO2ORDER"), $arParams);

		if(!empty($arResult["USER_PROFILES"]))
		{
			if ($bPropsPrinted)
				echo "";
			?>
			
			<div class="fieldset">
			
				<h3>
					<?echo GetMessage("STOF_PROFILES")?> [<?= GetMessage("SALE_PROFILES_PROMT")?>]
				</h3>
				
				<script language="JavaScript">
				function SetContact(enabled)
				{
					if(enabled)
						document.getElementById('sof-prof-div').style.display="block";
					else
						document.getElementById('sof-prof-div').style.display="none";
				}
				</script>
				
				<?
				$profiles = 0;
				foreach($arResult["USER_PROFILES"] as $arUserProfiles) {
				if($profiles > 0) continue; // Выводим только последний заполненный адрес
				?>
				
					<div class="radio-field">
						
						<label for="ID_PROFILE_ID_<?= $arUserProfiles["ID"] ?>">
							<input type="radio" name="PROFILE_ID" id="ID_PROFILE_ID_<?= $arUserProfiles["ID"] ?>" value="<?= $arUserProfiles["ID"];?>"<?if ($arUserProfiles["CHECKED"]=="Y") echo " checked";?> onClick="SetContact(false)" />
						</label>

						<h4>
							<?=$arUserProfiles["NAME"]?>
						</h4>
						
						<?
						foreach($arUserProfiles["USER_PROPS_VALUES"] as $arUserPropsValues) {
							if (strlen($arUserPropsValues["VALUE_FORMATED"]) > 0)
							{
						?>
						<p>
							
							<? if( !empty($arResult["PRINT_PROPS_FORM"]["USER_PROPS_Y"][$arUserPropsValues["ORDER_PROPS_ID"]]["NAME"]) ) { ?><?=$arResult["PRINT_PROPS_FORM"]["USER_PROPS_Y"][$arUserPropsValues["ORDER_PROPS_ID"]]["NAME"]?>:&nbsp;<? } ?><?=$arUserPropsValues["VALUE_FORMATED"]?>
							
						</p>
						<?
							}
						}
						?>
						
					</div>
					
				<?
				$profiles++;
				}
				?>
			</div><!-- [end fieldset] -->
			
			
			
			<div class="fieldset">
				<div class="radio-field">
					
					<label for="ID_PROFILE_ID_0" style="width: 100%;">
						
						<input style="float: right;" type="radio" name="PROFILE_ID" id="ID_PROFILE_ID_0" value="0"<?if ($arResult["PROFILE_ID"]=="0") echo " checked";?> onClick="SetContact(true)" />
					
						<h4 style="float: left;">
							<?echo GetMessage("SALE_NEW_PROFILE")?>
						</h4>
						
					</label>
					
				</div>
			</div><!-- [end fieldset] -->
			
			<?
		}
		else
		{
			?><input type="hidden" name="PROFILE_ID" value="0" /><?
		}
		?>

		<div id="sof-prof-div">
			<?
				PrintPropsForm($arResult["PRINT_PROPS_FORM"]["USER_PROPS_Y"], GetMessage("SALE_NEW_PROFILE_TITLE"), $arParams);
			?>
		</div>
		<?
		if ($arResult["USER_PROFILES_TO_FILL"]=="Y")
		{
			?>
			<script language="JavaScript">
				SetContact(<?echo ($arResult["USER_PROFILES_TO_FILL_VALUE"]=="Y" || $arResult["PROFILE_ID"] == "0")?"true":"false";?>);
			</script>
			<?
		}
		?>

<? 	} // End isGuest ?>
		
		
	<div class="clearfix">
		<button id="contButton" type="submit" name="contButton" value="<?= GetMessage("SALE_CONTINUE")?>" class="cta cta-lg">Продолжить</button>
		<!--
		<input type="submit" name="contButton" value="<?= GetMessage("SALE_CONTINUE")?>" />
		-->
		<? if(!($arResult["SKIP_FIRST_STEP"] == "Y")) { ?>
			<input id="backButton" class="dnone" type="submit" name="backButton" value="<?echo GetMessage("SALE_BACK_BUTTON")?>" />
			<p class="comeback"><a id="comeback" href="#">Вернуться к адресу доставки</a></p>
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


</div><!-- [end cart-form] -->

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

</div><!-- [end cart-form-container] -->

