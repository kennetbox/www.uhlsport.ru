<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
?>


<?//echo "<pre>"; print_r($arResult); echo "</pre>";?>
<form style="padding: auto;"id="login-form" name="form_auth" method="post" target="_top" action="<?=$arResult["AUTH_URL"]?>">
<?
ShowMessage($arParams["~AUTH_RESULT"]);
ShowMessage($arResult['ERROR_MESSAGE']);
?>

	<input type="hidden" name="AUTH_FORM" value="Y" />
	<input type="hidden" name="TYPE" value="AUTH" />
	<?if (strlen($arResult["BACKURL"]) > 0):?>
	<input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
	<?endif?>
	<?foreach ($arResult["POST"] as $key => $value):?>
	<input type="hidden" name="<?=$key?>" value="<?=$value?>" />
	<?endforeach?>		

	<div class="youama-window-box first">
        <div class="youama-window-content">
            <div class="input-fly youama-showhideme input-email">
                <label>Эл. почта <span>*</span></label>
                <input type="text" placeholder="E-mail address" class="youama-email" name="USER_LOGIN" value="<?=$arResult["LAST_LOGIN"]?>" style="cursor: auto; background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAASCAYAAABSO15qAAAAAXNSR0IArs4c6QAAAPhJREFUOBHlU70KgzAQPlMhEvoQTg6OPoOjT+JWOnRqkUKHgqWP4OQbOPokTk6OTkVULNSLVc62oJmbIdzd95NcuGjX2/3YVI/Ts+t0WLE2ut5xsQ0O+90F6UxFjAI8qNcEGONia08e6MNONYwCS7EQAizLmtGUDEzTBNd1fxsYhjEBnHPQNG3KKTYV34F8ec/zwHEciOMYyrIE3/ehKAqIoggo9inGXKmFXwbyBkmSQJqmUNe15IRhCG3byphitm1/eUzDM4qR0TTNjEixGdAnSi3keS5vSk2UDKqqgizLqB4YzvassiKhGtZ/jDMtLOnHz7TE+yf8BaDZXA509yeBAAAAAElFTkSuQmCC&quot;); background-attachment: scroll; background-size: 16px 18px; background-position: 98% 50%; background-repeat: no-repeat;">
                <div id="USER_LOGIN" class="youama-ajaxlogin-error err-email err-noemail err-wrongemail err-wronglogin" style="display: none;"></div>
            </div>
            <div class="input-fly youama-showhideme input-password">
                <label>Пароль <span>*</span></label>
                <input id="USER_PASSWORD" type="password" placeholder="Password" class="youama-password" name="USER_PASSWORD" value="" style="cursor: auto; background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAASCAYAAABSO15qAAAAAXNSR0IArs4c6QAAAPhJREFUOBHlU70KgzAQPlMhEvoQTg6OPoOjT+JWOnRqkUKHgqWP4OQbOPokTk6OTkVULNSLVc62oJmbIdzd95NcuGjX2/3YVI/Ts+t0WLE2ut5xsQ0O+90F6UxFjAI8qNcEGONia08e6MNONYwCS7EQAizLmtGUDEzTBNd1fxsYhjEBnHPQNG3KKTYV34F8ec/zwHEciOMYyrIE3/ehKAqIoggo9inGXKmFXwbyBkmSQJqmUNe15IRhCG3byphitm1/eUzDM4qR0TTNjEixGdAnSi3keS5vSk2UDKqqgizLqB4YzvassiKhGtZ/jDMtLOnHz7TE+yf8BaDZXA509yeBAAAAAElFTkSuQmCC&quot;); background-attachment: scroll; background-size: 16px 18px; background-position: 98% 50%; background-repeat: no-repeat;">
                <div class="youama-ajaxlogin-error err-password err-dirtypassword err-nopassword err-longpassword" style="display: none;"></div>
            </div>
        </div>
    </div>

    <div class="youama-window-box last">
        <div class="youama-window-content box-contents box-contents-button youama-showhideme">				
			<?if ($arParams["NOT_SHOW_LINKS"] != "Y"):?>
	            <span class="youama-forgot-password">
	                <a href="<?=$arResult["AUTH_FORGOT_PASSWORD_URL"]?>">Забыли пароль?</a>
	            </span>
            <?endif?>
            <?if($arResult["CAPTCHA_CODE"]):?>
							<li>
								<input type="hidden" name="captcha_sid" value="<?echo $arResult["CAPTCHA_CODE"]?>" />
								
								<img src="/bitrix/tools/captcha.php?captcha_sid=<?echo $arResult["CAPTCHA_CODE"]?>" width="180" height="40" alt="CAPTCHA" />

								<label>
									<?echo GetMessage("AUTH_CAPTCHA_PROMT")?>:
								</label>

								<input class="bx-auth-input" type="text" name="captcha_word" maxlength="50" value="" size="15" />
							</li>
						<?endif;?>
            <button name="register_submit_button" type="submit" class="button btn-login btn-proceed-checkout btn-checkout youama-ajaxlogin-button">
                <span>
                    <span>
                        Войти                                </span>
                </span>
            </button>
            <p id="y-to-register" class="yoauam-switch-window">
                или зарегестрироваться                        </p>
        </div>
    </div>

			
</form>




<script type="text/javascript">
<?if (strlen($arResult["LAST_LOGIN"])>0):?>
try{document.form_auth.USER_PASSWORD.focus();}catch(e){}
<?else:?>
try{document.form_auth.USER_LOGIN.focus();}catch(e){}
<?endif?>
</script>

<?if($arResult["AUTH_SERVICES"]):?>
<?
$APPLICATION->IncludeComponent("bitrix:socserv.auth.form", "",
	array(
		"AUTH_SERVICES" => $arResult["AUTH_SERVICES"],
		"CURRENT_SERVICE" => $arResult["CURRENT_SERVICE"],
		"AUTH_URL" => $arResult["AUTH_URL"],
		"POST" => $arResult["POST"],
		"SHOW_TITLES" => $arResult["FOR_INTRANET"]?'N':'Y',
		"FOR_SPLIT" => $arResult["FOR_INTRANET"]?'Y':'N',
		"AUTH_LINE" => $arResult["FOR_INTRANET"]?'N':'Y',
	),
	$component,
	array("HIDE_ICONS"=>"Y")
);
?>
<?endif?>

