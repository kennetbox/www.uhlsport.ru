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
 * @param array $arParams
 * @param array $arResult
 * @param CBitrixComponentTemplate $this
 */
?>

<?
	if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
?>

<div class="col-main">
	<div class="form-container">

<div class="bx-auth">

<?
ShowMessage($arParams["~AUTH_RESULT"]);
?>

<?if($arResult["USE_EMAIL_CONFIRMATION"] === "Y" && is_array($arParams["AUTH_RESULT"]) &&  $arParams["AUTH_RESULT"]["TYPE"] === "OK"):?>
	<div class="error_text">
		<p>
			<?echo GetMessage("AUTH_EMAIL_SENT")?>
		</p>
	</div>
<?else:?>

<?if($arResult["USE_EMAIL_CONFIRMATION"] === "Y"):?>
	<div class="error_text">
		<p>
			<?echo GetMessage("AUTH_EMAIL_WILL_BE_SENT")?>
		</p>
	</div>
<?endif?>

<noindex>

<div class="page-title">
	<h1>
		<?=GetMessage("AUTH_REGISTER")?>
	</h1>
</div>

<form id="form-validate" class="create-account" method="post" action="<?=$arResult["AUTH_URL"]?>" name="bform">

<table class="register-form-table">
<tbody>
	<tr>
		<td>

<?
if (strlen($arResult["BACKURL"]) > 0)
{
?>
	<input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
<?
}
?>
	<input type="hidden" name="AUTH_FORM" value="Y" />
	<input type="hidden" name="TYPE" value="REGISTRATION" />



				
				<div class="field">
					<label>
						<?=GetMessage("AUTH_NAME")?>
					</label>
					<div class="input-box">
						<input type="text" name="USER_NAME" maxlength="50" value="<?=$arResult["USER_NAME"]?>" class="bx-auth-input" />
					</div>
				</div>

				<div class="field">
					<label>
						<?=GetMessage("AUTH_LAST_NAME")?>
					</label>
					<div class="input-box">
						<input type="text" name="USER_LAST_NAME" maxlength="50" value="<?=$arResult["USER_LAST_NAME"]?>" class="bx-auth-input" />
					</div>
				</div>

				<div class="field">
					<label>
						<span class="starrequired">*</span><?=GetMessage("AUTH_LOGIN_MIN")?>
					</label>
					<div class="input-box">
						<input type="text" name="USER_LOGIN" maxlength="50" value="<?=$arResult["USER_LOGIN"]?>" class="bx-auth-input" />
					</div>
				</div>

				<div class="field">
					<label>
						<span class="starrequired">*</span><?=GetMessage("AUTH_PASSWORD_REQ")?>
					</label>
					<div class="input-box">
						<input type="password" name="USER_PASSWORD" maxlength="50" value="<?=$arResult["USER_PASSWORD"]?>" class="bx-auth-input" />
					</div>
				</div>
				
				<?if($arResult["SECURE_AUTH"]):?>
					<div class="field">
						<span class="bx-auth-secure" id="bx_auth_secure" title="<?echo GetMessage("AUTH_SECURE_NOTE")?>" style="display:none">
							<div class="bx-auth-secure-icon"></div>
						</span>
						<noscript>
							<span class="bx-auth-secure" title="<?echo GetMessage("AUTH_NONSECURE_NOTE")?>">
								<div class="bx-auth-secure-icon bx-auth-secure-unlock"></div>
							</span>
						</noscript>
					</div>
					<script type="text/javascript">
					document.getElementById('bx_auth_secure').style.display = 'inline-block';
					</script>
				<?endif?>

				<div class="field">
					<label>
						<span class="starrequired">*</span><?=GetMessage("AUTH_CONFIRM")?>
					</label>
					<div class="input-box">
						<input type="password" name="USER_CONFIRM_PASSWORD" maxlength="50" value="<?=$arResult["USER_CONFIRM_PASSWORD"]?>" class="bx-auth-input" />
					</div>
				</div>

				<div class="field">
					<label>
						<?if($arResult["EMAIL_REQUIRED"]):?><span class="starrequired">*</span><?endif?><?=GetMessage("AUTH_EMAIL")?>
					</label>
					<div class="input-box">
						<input type="text" name="USER_EMAIL" maxlength="255" value="<?=$arResult["USER_EMAIL"]?>" class="bx-auth-input" />
					</div>
				</div>


<?// ********************* User properties ***************************************************?>
<?if($arResult["USER_PROPERTIES"]["SHOW"] == "Y"):?>

	<?=strlen(trim($arParams["USER_PROPERTY_NAME"])) > 0 ? $arParams["USER_PROPERTY_NAME"] : GetMessage("USER_TYPE_EDIT_TAB")?>

	<?foreach ($arResult["USER_PROPERTIES"]["DATA"] as $FIELD_NAME => $arUserField):?>
		
		<label>
			<?=$arUserField["EDIT_FORM_LABEL"]?>:
			<?if ($arUserField["MANDATORY"]=="Y"):?>
				<span class="starrequired">*</span>
			<?endif;?>
		</label>
			
			
		<?$APPLICATION->IncludeComponent(
			"bitrix:system.field.edit",
			$arUserField["USER_TYPE"]["USER_TYPE_ID"],
			array("bVarsFromForm" => $arResult["bVarsFromForm"], "arUserField" => $arUserField, "form_name" => "bform"), null, array("HIDE_ICONS"=>"Y"));?>
			
	<?endforeach;?>
<?endif;?>
<?// ******************** /User properties ***************************************************

	/* CAPTCHA */
	if ($arResult["USE_CAPTCHA"] == "Y")
	{
		?>

		<div class="field">
			<label>
				<?=GetMessage("CAPTCHA_REGF_TITLE")?> [<?=GetMessage("CAPTCHA_REGF_PROMT")?>]:<span class="starrequired">*</span>
			</label>
			<div style="padding: 5px 0px;">
				<input type="hidden" name="captcha_sid" value="<?=$arResult["CAPTCHA_CODE"]?>" />
				<img src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult["CAPTCHA_CODE"]?>" width="180" height="40" alt="CAPTCHA" />
			</div>
			<div class="input-box">
				<input type="text" name="captcha_word" maxlength="50" value="" />
			</div>
		</div>

		<?
	}
	/* CAPTCHA */
	?>

	<p>
		<?echo $arResult["GROUP_POLICY"]["PASSWORD_REQUIREMENTS"];?>
	</p>
	<p>
		<span class="starrequired">*</span><?=GetMessage("AUTH_REQ")?>
	</p>

	<p>
		<a href="<?=$arResult["AUTH_AUTH_URL"]?>" rel="nofollow"><b><?=GetMessage("AUTH_AUTH")?></b></a>
	</p>

</td>
<td class="column-separator"></td>
<td class="right">

<br />

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
				<button class="button wnd-submit cta wnd-open" name="Register" value="<?=GetMessage("AUTH_REGISTER")?>" type="submit" autocomplete="off">
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
</noindex>

<script type="text/javascript">
document.bform.USER_NAME.focus();
</script>

<?endif?>


</div><!-- [end bx-auth] -->


	</div><!-- [end form-container] -->
</div><!-- [end col-main] -->