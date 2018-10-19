<?
/**
 * Bitrix Framework
 * @package bitrix
 * @subpackage main
 * @copyright 2001-2014 Bitrix
 */

/**
 * Bitrix vars
 * @global CMain $APPLICATION
 * @global CUser $USER
 * @param array $arParams
 * @param array $arResult
 * @param CBitrixComponentTemplate $this
 */

if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
?>

<div class="col-main">
	<div class="form-container">
		<div class="page-title">
			<h1>
				Создать аккаунт
			</h1>
		</div>

<?/*
	<h1>
		<?=GetMessage("AUTH_REGISTER")?>
	</h1>
*/?>
	
<div class="bx-auth-reg">



<?if($USER->IsAuthorized()):?>
<div class="error_text">
	<p>
		<?echo GetMessage("MAIN_REGISTER_AUTH")?>
	</p>
</div>
<?else:?>
<?
if (count($arResult["ERRORS"]) > 0):
?>
<div class="error_text">
<?
	foreach ($arResult["ERRORS"] as $key => $error)
		if (intval($key) == 0 && $key !== 0) 
			$arResult["ERRORS"][$key] = str_replace("#FIELD_NAME#", "&quot;".GetMessage("REGISTER_FIELD_".$key)."&quot;", $error);

	ShowError(implode("<br />", $arResult["ERRORS"]));
?>
</div>
<?
elseif($arResult["USE_EMAIL_CONFIRMATION"] === "Y"):
?>
<div class="error_text">
	<p>
		<?echo GetMessage("REGISTER_EMAIL_WILL_BE_SENT")?>
	</p>
</div>
<?endif?>

<form id="form-validate" class="create-account" method="post" action="<?=POST_FORM_ACTION_URI?>" name="regform" enctype="multipart/form-data">

<table class="register-form-table">
<tbody>
	<tr>
		<td>

<?
if($arResult["BACKURL"] <> ''):
?>

	<input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />

<?
endif;
?>






<?
// Имя, Фамилия
foreach ($arResult["SHOW_FIELDS"] as $FIELD):?>
	<?if($FIELD == "AUTO_TIME_ZONE" && $arResult["TIME_ZONE_ENABLED"] == true):?>

	<?else:?>

<?
	switch ($FIELD) {

	case "PERSONAL_GENDER":
		?>
		<div class="field">
			<label>
				<?=GetMessage("REGISTER_FIELD_".$FIELD)?>:<?if ($arResult["REQUIRED_FIELDS_FLAGS"][$FIELD] == "Y"):?><span class="starrequired">*</span><?endif?>
			</label>
			<div class="input-box">
				<select name="REGISTER[<?=$FIELD?>]">
					<option value=""><?=GetMessage("USER_DONT_KNOW")?></option>
					<option value="M"<?=$arResult["VALUES"][$FIELD] == "M" ? " selected=\"selected\"" : ""?>><?=GetMessage("USER_MALE")?></option>
					<option value="F"<?=$arResult["VALUES"][$FIELD] == "F" ? " selected=\"selected\"" : ""?>><?=GetMessage("USER_FEMALE")?></option>
				</select>
			</div>
		</div>
		<?
		break;

	case "PERSONAL_COUNTRY":
	case "WORK_COUNTRY":
		?>
		<div class="field">
			<label>
				<?=GetMessage("REGISTER_FIELD_".$FIELD)?>:<?if ($arResult["REQUIRED_FIELDS_FLAGS"][$FIELD] == "Y"):?><span class="starrequired">*</span><?endif?>
			</label>
			<div class="input-box">
				<select name="REGISTER[<?=$FIELD?>]"><?
				foreach ($arResult["COUNTRIES"]["reference_id"] as $key => $value) {
					?><option value="<?=$value?>"<?if ($value == $arResult["VALUES"][$FIELD]):?> selected="selected"<?endif?>><?=$arResult["COUNTRIES"]["reference"][$key]?></option>
				<? } ?>
				</select>
			</div>
		</div>
		<?
		break;

	case "PERSONAL_PHOTO":
	case "WORK_LOGO":
		?>
		<div class="field">
			<label>
				<?=GetMessage("REGISTER_FIELD_".$FIELD)?>:<?if ($arResult["REQUIRED_FIELDS_FLAGS"][$FIELD] == "Y"):?><span class="starrequired">*</span><?endif?>
			</label>
			<div class="input-box">
				<input size="30" type="file" name="REGISTER_FILES_<?=$FIELD?>" />
			</div>
		</div>
	<?
		break;

	case "PERSONAL_NOTES":
	case "WORK_NOTES":
		?>
		<div class="field">
			<label>
				<?=GetMessage("REGISTER_FIELD_".$FIELD)?>:<?if ($arResult["REQUIRED_FIELDS_FLAGS"][$FIELD] == "Y"):?><span class="starrequired">*</span><?endif?>
			</label>
			<div class="input-box">
				<textarea cols="30" rows="5" name="REGISTER[<?=$FIELD?>]"><?=$arResult["VALUES"][$FIELD]?></textarea>
			</div>
		</div>
	<?
		break;
	default:
	?>
		<? if ($FIELD != 'LOGIN' && $FIELD != 'PASSWORD' && $FIELD != 'CONFIRM_PASSWORD' && $FIELD != 'EMAIL' && $FIELD != "PERSONAL_BIRTHDAY") { ?>
		<div class="field">
		<label>
			<?=GetMessage("REGISTER_FIELD_".$FIELD)?>:<?if ($arResult["REQUIRED_FIELDS_FLAGS"][$FIELD] == "Y"):?><span class="starrequired">*</span><?endif?>
		</label>
		<div class="input-box">
			<input size="30" type="text" name="REGISTER[<?=$FIELD?>]" value="<?=$arResult["VALUES"][$FIELD]?>" />
		</div>
		</div>
	<?
		}
	?>
<? } ?>

	<?endif?>
<?endforeach;?>




<?
// Email
foreach ($arResult["SHOW_FIELDS"] as $FIELD):
?>
	<?if($FIELD == "AUTO_TIME_ZONE" && $arResult["TIME_ZONE_ENABLED"] == true):?>
	<?else:?>

<?
	switch ($FIELD) {

	default:
	?>
		<? if ($FIELD == 'EMAIL') { ?>
		<div class="field">
		<label>
			<?=GetMessage("REGISTER_FIELD_".$FIELD)?>:<?if ($arResult["REQUIRED_FIELDS_FLAGS"][$FIELD] == "Y"):?><span class="starrequired">*</span><?endif?>
		</label>
		<div class="input-box">
			<input id="FIELD-<?=$FIELD?>" size="30" type="text" name="REGISTER[<?=$FIELD?>]" value="<?=$arResult["VALUES"][$FIELD]?>" />
		</div>
		</div>
	<?
		}
	?>
<? } ?>

	<?endif?>
<?
endforeach;
?>




<?
// Дата рождения
foreach ($arResult["SHOW_FIELDS"] as $FIELD):?>
	<?if($FIELD == "AUTO_TIME_ZONE" && $arResult["TIME_ZONE_ENABLED"] == true):?>
	<?else:?>

<?
	switch ($FIELD) {

	default:
	?>
		<? if ($FIELD == 'PERSONAL_BIRTHDAY') { ?>
		<div class="field">
		<label>
			<?=GetMessage("REGISTER_FIELD_".$FIELD)?>:<?if ($arResult["REQUIRED_FIELDS_FLAGS"][$FIELD] == "Y"):?><span class="starrequired">*</span><?endif?>
		</label>
		<div class="input-box">
			<input id="PERSONAL_BIRTHDAY" size="30" type="text" name="REGISTER[<?=$FIELD?>]" value="<?=$arResult["VALUES"][$FIELD]?>" /><?
				if ($FIELD == "PERSONAL_BIRTHDAY")
					$APPLICATION->IncludeComponent(
						'bitrix:main.calendar',
						'',
						array(
							'SHOW_INPUT' => 'N',
							'FORM_NAME' => 'regform',
							'INPUT_NAME' => 'REGISTER[PERSONAL_BIRTHDAY]',
							'SHOW_TIME' => 'N'
						),
						null,
						array("HIDE_ICONS"=>"Y")
					);
	?>
		</div>
		</div>
	<?
		}
	?>
<? } ?>

	<?endif?>
<?
endforeach;
?>


	<ul class="form-list hidden">
		<?// ********************* User properties ***************************************************?>
		<?if($arResult["USER_PROPERTIES"]["SHOW"] == "Y"):?>

			<?/*=strlen(trim($arParams["USER_PROPERTY_NAME"])) > 0 ? $arParams["USER_PROPERTY_NAME"] : GetMessage("USER_TYPE_EDIT_TAB")*/?>
			
			<li>
				<label for="month">
					Дата рождения:
					<i>(MM/DD/YYYY)</i>
				</label>
				<div class="input-box customer-dob">
					<?foreach ($arResult["USER_PROPERTIES"]["DATA"] as $FIELD_NAME => $arUserField):?>
					
						<?
							switch($FIELD_NAME) {
								case 'UF_BIRTH_DAY': case 'UF_BIRTH_MONTH': case 'UF_BIRTH_YEAR':
						?>
							
							<?/*=$arUserField["EDIT_FORM_LABEL"]?>:<?if ($arUserField["MANDATORY"]=="Y"):?><span class="starrequired">*</span><?endif;*/?>

							<?$APPLICATION->IncludeComponent(
								"bitrix:system.field.edit",
								$arUserField["USER_TYPE"]["USER_TYPE_ID"],
								array("bVarsFromForm" => $arResult["bVarsFromForm"], "arUserField" => $arUserField, "form_name" => "regform"), null, array("HIDE_ICONS"=>"Y"));
							?>
						
						<?
							break;
						}
						?>
					
					<?endforeach;?>
				</div>
			</li>
			
		<?endif;?>
		<?// ******************** /User properties ***************************************************?>
	</ul>


	<ul class="form-list">
		<?// ********************* User properties ***************************************************?>
		<?if($arResult["USER_PROPERTIES"]["SHOW"] == "Y"):?>
			<?/*=strlen(trim($arParams["USER_PROPERTY_NAME"])) > 0 ? $arParams["USER_PROPERTY_NAME"] : GetMessage("USER_TYPE_EDIT_TAB")*/?>
			<li>
				<?foreach ($arResult["USER_PROPERTIES"]["DATA"] as $FIELD_NAME => $arUserField):?>
				
					<?
						switch($FIELD_NAME) {
							case 'UF_REGION_CODE':
					?>
						<label for="month">
							<?=$arUserField["EDIT_FORM_LABEL"]?>:<?if ($arUserField["MANDATORY"]=="Y"):?><span class="starrequired">*</span><?endif;?>
						</label>
						<div class="input-box customer-dob">
							<?$APPLICATION->IncludeComponent(
								"bitrix:system.field.edit",
								$arUserField["USER_TYPE"]["USER_TYPE_ID"],
								array("bVarsFromForm" => $arResult["bVarsFromForm"], "arUserField" => $arUserField, "form_name" => "regform"), null, array("HIDE_ICONS"=>"Y"));
							?>
						</div>
					<?
						break;
					}
					?>
				
				<?endforeach;?>
			</li>
		<?endif;?>
		<?// ******************** /User properties ***************************************************?>
	</ul>

<?foreach ($arResult["SHOW_FIELDS"] as $FIELD):?>
	<?if($FIELD == "AUTO_TIME_ZONE" && $arResult["TIME_ZONE_ENABLED"] == true):?>

		<div>
			<?echo GetMessage("main_profile_time_zones_auto")?><?if ($arResult["REQUIRED_FIELDS_FLAGS"][$FIELD] == "Y"):?><span class="starrequired">*</span><?endif?>
			<select name="REGISTER[AUTO_TIME_ZONE]" onchange="this.form.elements['REGISTER[TIME_ZONE]'].disabled=(this.value != 'N')">
				<option value=""><?echo GetMessage("main_profile_time_zones_auto_def")?></option>
				<option value="Y"<?=$arResult["VALUES"][$FIELD] == "Y" ? " selected=\"selected\"" : ""?>><?echo GetMessage("main_profile_time_zones_auto_yes")?></option>
				<option value="N"<?=$arResult["VALUES"][$FIELD] == "N" ? " selected=\"selected\"" : ""?>><?echo GetMessage("main_profile_time_zones_auto_no")?></option>
			</select>
		</div>	
				
		<div>
			<?echo GetMessage("main_profile_time_zones_zones")?>
			<select name="REGISTER[TIME_ZONE]"<?if(!isset($_REQUEST["REGISTER"]["TIME_ZONE"])) echo 'disabled="disabled"'?>>
				<?foreach($arResult["TIME_ZONE_LIST"] as $tz=>$tz_name):?>
					<option value="<?=htmlspecialcharsbx($tz)?>"<?=$arResult["VALUES"]["TIME_ZONE"] == $tz ? " selected=\"selected\"" : ""?>><?=htmlspecialcharsbx($tz_name)?></option>
				<?endforeach?>
			</select>
		</div>
		
	<?else:?>

<?
	switch ($FIELD)
	{
		case "PASSWORD":
?>
	<div class="field">
		<label>
			<?=GetMessage("REGISTER_FIELD_".$FIELD)?>:<?if ($arResult["REQUIRED_FIELDS_FLAGS"][$FIELD] == "Y"):?><span class="starrequired">*</span><?endif?>
		</label>
		<div class="input-box">
			<input size="30" type="password" name="REGISTER[<?=$FIELD?>]" value="<?=$arResult["VALUES"][$FIELD]?>" autocomplete="off" class="bx-auth-input" />
		</div>
	</div>
<?if($arResult["SECURE_AUTH"]):?>
				
	<span class="bx-auth-secure" id="bx_auth_secure" title="<?echo GetMessage("AUTH_SECURE_NOTE")?>" style="display:none">
		<div class="bx-auth-secure-icon"></div>
	</span>
	<noscript>
		<span class="bx-auth-secure" title="<?echo GetMessage("AUTH_NONSECURE_NOTE")?>">
			<div class="bx-auth-secure-icon bx-auth-secure-unlock"></div>
		</span>
	</noscript>
				
<script type="text/javascript">
document.getElementById('bx_auth_secure').style.display = 'inline-block';
</script>
<?endif?>
<?
	break;
	case "CONFIRM_PASSWORD":
		?>
		<div class="field">
			<label>
				<?=GetMessage("REGISTER_FIELD_".$FIELD)?>:<?if ($arResult["REQUIRED_FIELDS_FLAGS"][$FIELD] == "Y"):?><span class="starrequired">*</span><?endif?>
			</label>
			<div class="input-box">
				<input size="30" type="password" name="REGISTER[<?=$FIELD?>]" value="<?=$arResult["VALUES"][$FIELD]?>" autocomplete="off" />
			</div>
		</div>
	<?
		break;

	default:
	?>

		<? if ($FIELD == 'LOGIN') { ?>
		<div class="field">
			<label>
				<?=GetMessage("REGISTER_FIELD_".$FIELD)?>:<?if ($arResult["REQUIRED_FIELDS_FLAGS"][$FIELD] == "Y"):?><span class="starrequired">*</span><?endif?>
			</label>
			<div class="input-box">
			<input id="FIELD-<?=$FIELD?>" size="30" type="text" name="REGISTER[<?=$FIELD?>]" value="<?=$arResult["VALUES"][$FIELD]?>" /><?
			if ($FIELD == "PERSONAL_BIRTHDAY")
				$APPLICATION->IncludeComponent(
					'bitrix:main.calendar',
					'',
					array(
						'SHOW_INPUT' => 'N',
						'FORM_NAME' => 'regform',
						'INPUT_NAME' => 'REGISTER[PERSONAL_BIRTHDAY]',
						'SHOW_TIME' => 'N'
					),
					null,
					array("HIDE_ICONS"=>"Y")
				);
		?>
			</div>
		</div>
		<?
		}
?>
<? } ?>

	<?endif?>
<?endforeach?>


<script>
jQuery(function($) {
	var UF_BIRTH_DAY   = $("input[name = 'UF_BIRTH_DAY']"),
		UF_BIRTH_MONTH = $("input[name = 'UF_BIRTH_MONTH']"),
		UF_BIRTH_YEAR  = $("input[name = 'UF_BIRTH_YEAR']"),
		FIELD_EMAIL  = $("input#FIELD-EMAIL"),
		FIELD_LOGIN  = $("input#FIELD-LOGIN");
	
	$(document).on('change', '#PERSONAL_BIRTHDAY', function() {
		var $this = $(this),
			val = $this.val(),
			valArr = val.split('.');
		if(UF_BIRTH_DAY.size()) {
			UF_BIRTH_DAY.val(valArr[0]);
		}
		if(UF_BIRTH_MONTH.size()) {
			UF_BIRTH_MONTH.val(valArr[1]);
		}
		if(UF_BIRTH_YEAR.size()) {
			UF_BIRTH_YEAR.val(valArr[2]);
		}
	});
	$(document).on('change', "#FIELD-EMAIL", function() {
		FIELD_LOGIN.val($(this).val());
	});
});
</script>




<?
/* CAPTCHA */
if ($arResult["USE_CAPTCHA"] == "Y")
{
?>
	<div class="field">
		<label>
			<?=GetMessage("REGISTER_CAPTCHA_TITLE")?> [<?=GetMessage("REGISTER_CAPTCHA_PROMT")?>]:<span class="starrequired">*</span>
		</label>
		<div style="padding: 5px 0px 0px;">
			<input type="hidden" name="captcha_sid" value="<?=$arResult["CAPTCHA_CODE"]?>" />
			<img src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult["CAPTCHA_CODE"]?>" width="180" height="40" alt="CAPTCHA" />
		</div>
		<div class="input-box">
			<input type="text" name="captcha_word" maxlength="50" value="" />
		</div>
	</div>
<?
}
/* !CAPTCHA */
?>
<!--
<input type="submit" name="register_submit_button" value="<?=GetMessage("AUTH_REGISTER")?>" />
-->
</td>

<td class="column-separator"></td>

<td class="right">
<br />			
<?// ********************* User properties ***************************************************?>
<?if($arResult["USER_PROPERTIES"]["SHOW"] == "Y"):?>
<table class="fields boolean two-cols">
<tr>
	<?foreach ($arResult["USER_PROPERTIES"]["DATA"] as $FIELD_NAME => $arUserField):?>
		<?
			switch($FIELD_NAME) {
				case 'UF_USING_PRODUCTS':
				echo "<td>";
				echo "<label>".$arUserField["EDIT_FORM_LABEL"]?>:<?if ($arUserField["MANDATORY"]=="Y"):?><span class="starrequired">*</span></label><?endif;?>
				<?
					$APPLICATION->IncludeComponent(
					"bitrix:system.field.edit",
					$arUserField["USER_TYPE"]["USER_TYPE_ID"],
					array("bVarsFromForm" => $arResult["bVarsFromForm"], "arUserField" => $arUserField, "form_name" => "regform"), null, array("HIDE_ICONS"=>"Y"));
				echo "</td>";
				break;
			?>
		<?
				default: break;
			}
		?>	
	<?endforeach;?>
</tr>
</table>
<br />
<br />
<?endif;?>


<?if($arResult["USER_PROPERTIES"]["SHOW"] == "Y"):?>
<label>
	КАКИМ СПОРТОМ ВЫ УВЛЕКАЕТЕСЬ:
</label>
<br />
<table class="sports">
	<tbody>
		<tr>
		<?foreach ($arResult["USER_PROPERTIES"]["DATA"] as $FIELD_NAME => $arUserField):?>
			<?	switch($FIELD_NAME) {
				case 'UF_SPORT_FOOTBALL': ?>
					<td>
						<? 
						echo "<label>";
							$APPLICATION->IncludeComponent(
							"bitrix:system.field.edit",
							$arUserField["USER_TYPE"]["USER_TYPE_ID"],
							array("bVarsFromForm" => $arResult["bVarsFromForm"], "arUserField" => $arUserField, "form_name" => "regform"), null, array("HIDE_ICONS"=>"Y"));
						echo $arUserField["EDIT_FORM_LABEL"]?><?if ($arUserField["MANDATORY"]=="Y"):?><span class="starrequired">*</span></label><?endif;?>
					</td>
			<?	break; 
				case 'UF_SPORT_BASKETBALL': ?>
					<td>
						<? 
						echo "<label>";
							$APPLICATION->IncludeComponent(
							"bitrix:system.field.edit",
							$arUserField["USER_TYPE"]["USER_TYPE_ID"],
							array("bVarsFromForm" => $arResult["bVarsFromForm"], "arUserField" => $arUserField, "form_name" => "regform"), null, array("HIDE_ICONS"=>"Y"));
						echo $arUserField["EDIT_FORM_LABEL"]?><?if ($arUserField["MANDATORY"]=="Y"):?><span class="starrequired">*</span></label><?endif;?>
					</td>
			<?	break; ?>
			<?	default: break; ?>
			<? } ?>
		<?endforeach;?>
		</tr>
		
		<tr>
		<?foreach ($arResult["USER_PROPERTIES"]["DATA"] as $FIELD_NAME => $arUserField):?>
			<?	switch($FIELD_NAME) {
				case 'UF_SPORT_HOCKEY': ?>
					<td>
						<? 
						echo "<label>";
							$APPLICATION->IncludeComponent(
							"bitrix:system.field.edit",
							$arUserField["USER_TYPE"]["USER_TYPE_ID"],
							array("bVarsFromForm" => $arResult["bVarsFromForm"], "arUserField" => $arUserField, "form_name" => "regform"), null, array("HIDE_ICONS"=>"Y"));
						echo $arUserField["EDIT_FORM_LABEL"]?><?if ($arUserField["MANDATORY"]=="Y"):?><span class="starrequired">*</span></label><?endif;?>
					</td>
			<?	break; 
				case 'UF_SPORT_VOLLEYBALL': ?>
					<td>
						<? 
						echo "<label>";
							$APPLICATION->IncludeComponent(
							"bitrix:system.field.edit",
							$arUserField["USER_TYPE"]["USER_TYPE_ID"],
							array("bVarsFromForm" => $arResult["bVarsFromForm"], "arUserField" => $arUserField, "form_name" => "regform"), null, array("HIDE_ICONS"=>"Y"));
						echo $arUserField["EDIT_FORM_LABEL"]?><?if ($arUserField["MANDATORY"]=="Y"):?><span class="starrequired">*</span></label><?endif;?>
					</td>
			<?	break; ?>
			<?	default: break; ?>
			<? } ?>
		<?endforeach;?>
		</tr>
		
		<tr>
		<?foreach ($arResult["USER_PROPERTIES"]["DATA"] as $FIELD_NAME => $arUserField):?>
			<?	switch($FIELD_NAME) {
				case 'UF_SPORT_LACROSSE': ?>
					<td>
						<? 
						echo "<label>";
							$APPLICATION->IncludeComponent(
							"bitrix:system.field.edit",
							$arUserField["USER_TYPE"]["USER_TYPE_ID"],
							array("bVarsFromForm" => $arResult["bVarsFromForm"], "arUserField" => $arUserField, "form_name" => "regform"), null, array("HIDE_ICONS"=>"Y"));
						echo $arUserField["EDIT_FORM_LABEL"]?><?if ($arUserField["MANDATORY"]=="Y"):?><span class="starrequired">*</span></label><?endif;?>
					</td>
			<?	break; 
				case 'UF_SPORT_BOXING': ?>
					<td>
						<? 
						echo "<label>";
							$APPLICATION->IncludeComponent(
							"bitrix:system.field.edit",
							$arUserField["USER_TYPE"]["USER_TYPE_ID"],
							array("bVarsFromForm" => $arResult["bVarsFromForm"], "arUserField" => $arUserField, "form_name" => "regform"), null, array("HIDE_ICONS"=>"Y"));
						echo $arUserField["EDIT_FORM_LABEL"]?><?if ($arUserField["MANDATORY"]=="Y"):?><span class="starrequired">*</span></label><?endif;?>
					</td>
			<?	break; ?>
			<?	default: break; ?>
			<? } ?>
		<?endforeach;?>
		</tr>
		
		<tr>
		<?foreach ($arResult["USER_PROPERTIES"]["DATA"] as $FIELD_NAME => $arUserField):?>
			<?	switch($FIELD_NAME) {
				case 'UF_SPORT_BASEBALL': ?>
					<td>
						<? 
						echo "<label>";
							$APPLICATION->IncludeComponent(
							"bitrix:system.field.edit",
							$arUserField["USER_TYPE"]["USER_TYPE_ID"],
							array("bVarsFromForm" => $arResult["bVarsFromForm"], "arUserField" => $arUserField, "form_name" => "regform"), null, array("HIDE_ICONS"=>"Y"));
						echo $arUserField["EDIT_FORM_LABEL"]?><?if ($arUserField["MANDATORY"]=="Y"):?><span class="starrequired">*</span></label><?endif;?>
					</td>
			<?	break; 
				case 'UF_SPORT_ACTIVE': ?>
					<td>
						<? 
						echo "<label>";
							$APPLICATION->IncludeComponent(
							"bitrix:system.field.edit",
							$arUserField["USER_TYPE"]["USER_TYPE_ID"],
							array("bVarsFromForm" => $arResult["bVarsFromForm"], "arUserField" => $arUserField, "form_name" => "regform"), null, array("HIDE_ICONS"=>"Y"));
						echo $arUserField["EDIT_FORM_LABEL"]?><?if ($arUserField["MANDATORY"]=="Y"):?><span class="starrequired">*</span></label><?endif;?>
					</td>
			<?	break; ?>
			<?	default: break; ?>
			<? } ?>
		<?endforeach;?>
		</tr>
		
		<tr>
		<?foreach ($arResult["USER_PROPERTIES"]["DATA"] as $FIELD_NAME => $arUserField):?>
			<?	switch($FIELD_NAME) {
				case 'UF_SPORT_SOFTBALL': ?>
					<td>
						<? 
						echo "<label>";
							$APPLICATION->IncludeComponent(
							"bitrix:system.field.edit",
							$arUserField["USER_TYPE"]["USER_TYPE_ID"],
							array("bVarsFromForm" => $arResult["bVarsFromForm"], "arUserField" => $arUserField, "form_name" => "regform"), null, array("HIDE_ICONS"=>"Y"));
						echo $arUserField["EDIT_FORM_LABEL"]?><?if ($arUserField["MANDATORY"]=="Y"):?><span class="starrequired">*</span></label><?endif;?>
					</td>
			<?	break; 
				case 'UF_SPORT_TRAINING': ?>
					<td>
						<? 
						echo "<label>";
							$APPLICATION->IncludeComponent(
							"bitrix:system.field.edit",
							$arUserField["USER_TYPE"]["USER_TYPE_ID"],
							array("bVarsFromForm" => $arResult["bVarsFromForm"], "arUserField" => $arUserField, "form_name" => "regform"), null, array("HIDE_ICONS"=>"Y"));
						echo $arUserField["EDIT_FORM_LABEL"]?><?if ($arUserField["MANDATORY"]=="Y"):?><span class="starrequired">*</span></label><?endif;?>
					</td>
			<?	break; ?>
			<?	default: break; ?>
			<? } ?>
		<?endforeach;?>
		</tr>
		
		<tr>
		<?foreach ($arResult["USER_PROPERTIES"]["DATA"] as $FIELD_NAME => $arUserField):?>
			<?	switch($FIELD_NAME) {
				case 'UF_SPORT_RUGBY': ?>
					<td>
						<? 
						echo "<label>";
							$APPLICATION->IncludeComponent(
							"bitrix:system.field.edit",
							$arUserField["USER_TYPE"]["USER_TYPE_ID"],
							array("bVarsFromForm" => $arResult["bVarsFromForm"], "arUserField" => $arUserField, "form_name" => "regform"), null, array("HIDE_ICONS"=>"Y"));
						echo $arUserField["EDIT_FORM_LABEL"]?><?if ($arUserField["MANDATORY"]=="Y"):?><span class="starrequired">*</span></label><?endif;?>
					</td>
			<?	break; 
				case 'UF_SPORT_HANDBALL': ?>
					<td>
						<? 
						echo "<label>";
							$APPLICATION->IncludeComponent(
							"bitrix:system.field.edit",
							$arUserField["USER_TYPE"]["USER_TYPE_ID"],
							array("bVarsFromForm" => $arResult["bVarsFromForm"], "arUserField" => $arUserField, "form_name" => "regform"), null, array("HIDE_ICONS"=>"Y"));
						echo $arUserField["EDIT_FORM_LABEL"]?><?if ($arUserField["MANDATORY"]=="Y"):?><span class="starrequired">*</span></label><?endif;?>
					</td>
			<?	break; ?>
			<?	default: break; ?>
			<? } ?>
		<?endforeach;?>
		</tr>
		<tr>
		<?foreach ($arResult["USER_PROPERTIES"]["DATA"] as $FIELD_NAME => $arUserField):?>
			<?	switch($FIELD_NAME) {
				case 'UF_SPORT_LAWN_HOCKEY': ?>
					<td>
						<? 
						echo "<label>";
							$APPLICATION->IncludeComponent(
							"bitrix:system.field.edit",
							$arUserField["USER_TYPE"]["USER_TYPE_ID"],
							array("bVarsFromForm" => $arResult["bVarsFromForm"], "arUserField" => $arUserField, "form_name" => "regform"), null, array("HIDE_ICONS"=>"Y"));
						echo $arUserField["EDIT_FORM_LABEL"]?><?if ($arUserField["MANDATORY"]=="Y"):?><span class="starrequired">*</span></label><?endif;?>
					</td>
			<?	break; ?>
			<?	default: break; ?>
			<? } ?>
		<?endforeach;?>
		<td></td>
		</tr>
		
	</tbody>
</table>
<?endif;?>

<?// ******************** /User properties ***************************************************?>



		<div class="members-receive">Члены получают</div>
		
		<ul class="members-pluses">
			<li>Бесплатный Стандартная доставка на любой заказ</li>
			<li>Новости о продукции и проникнуть Пикс</li>
			<li>Эксклюзивный контент спортсмен</li>
			<li>Эксклюзивные специальные предложения</li>
		</ul>

		<p>
			<?echo $arResult["GROUP_POLICY"]["PASSWORD_REQUIREMENTS"];?>
		</p>

		<p>
			<span class="starrequired">*</span><?=GetMessage("AUTH_REQ")?>
		</p>

		</td>
	</tr>
</tbody>
</table>

<table class="register-submit-bar">
	<tbody>
		<tr>
			<td>
				<button type="button" class="button wnd-close cancel" autocomplete="off" onclick="location.href = '/'">
					<span><span>Отмена</span></span>
				</button>
			</td>
			<td>
				<button class="button wnd-submit cta wnd-open" name="register_submit_button" value="<?=GetMessage("AUTH_REGISTER")?>" type="submit" autocomplete="off">
					<span><span>Зарегистрироваться</span></span>
				</button>
			</td>
			<td class="note">
				<i>(Нажимая ЗАРЕГИСТРИРОВАТЬСЯ Вы соглашаетесь с<br> Shock Doctor Политика и правила пользования)</i>
			</td>
		</tr>
	</tbody>
</table>

</form>
<?endif?>

</div><!-- [end bx-auth-reg] -->

	</div><!-- [end form-container] -->
</div><!-- [end col-main] -->
	