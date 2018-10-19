<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
?>

<div class="col-main">
<div class="form-container">

<div class="bx-auth">

<?if($arResult["AUTH_SERVICES"]):?>
	<div class="page-title">
		<h1>
			<? //echo GetMessage("AUTH_AUTHORIZE"); ?>
			 Регистрация   или вход на сайт
		</h1>
	</div>
<?endif?>

<form id="login-form" name="form_auth" method="post" target="_top" action="<?=$arResult["AUTH_URL"]?>">
<?
ShowMessage($arParams["~AUTH_RESULT"]);
ShowMessage($arResult['ERROR_MESSAGE']);
?>
<div class="row">
		<div class="col-1 new-users col-xs-12 col-sm-6">
		    <div class="theme-block">
		        <div class="content">
		            <h2>Новый пользователь?</h2>
		            <p class="form-instructions">Преимущества регистрации:</p>
		            <ul class="benefits">
		                <li>Быстрое оформление заказа</li>
		                <li>Сохранение адреса доставки</li>
		                <li>История заказов</li>
		            </ul>
		        </div>
		        <div class="buttons-set">
		            <a title="Зарегестрировать акаунт" class="button" href="/register/" onclick=""><b class="ink animate" style="height: 249px; width: 249px; top: -101.5px; left: 27px;"></b><span><span>РЕГИСТРАЦИЯ</span></span></a>
		        </div>
		    </div>
		</div>

		<div class="col-2 registered-users col-xs-12 col-sm-6">

		<input type="hidden" name="AUTH_FORM" value="Y" />
			<input type="hidden" name="TYPE" value="AUTH" />
			<?if (strlen($arResult["BACKURL"]) > 0):?>
			<input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
			<?endif?>
			<?foreach ($arResult["POST"] as $key => $value):?>
			<input type="hidden" name="<?=$key?>" value="<?=$value?>" />
			<?endforeach?>
		    <div class="theme-block">
		        <div class="content" style="width:auto;">
		            <h2>Вход на сайт:</h2>						
		            <p class="form-instructions">Введите данные для авторизации.</p>
		            <p class="required" style="color: #ee372a;">* Обязательные поля</p>
		            <ul class="form-list">
		                <li>
		                    <label for="email" class="required">Электронная почта</label>
		                    <div class="input-box">
								<input id="USER_LOGIN" class="bx-auth-input" type="text" name="USER_LOGIN" maxlength="255" value="<?=$arResult["LAST_LOGIN"]?>" />
							</div>
		                </li>
		                <li>
		                    <label for="pass" class="required">Пароль</label>
		                    <div class="input-box">
								<input id="USER_PASSWORD" class="bx-auth-input" type="password" name="USER_PASSWORD" maxlength="255" />
							</div>
		                </li>
		                <li>
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
						</li>
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
						<?if ($arResult["STORE_PASSWORD"] == "Y"):?>
							<li>
								<div class="input-box">
									<input style="width:auto;" type="checkbox" id="USER_REMEMBER" name="USER_REMEMBER" value="Y" /><label for="USER_REMEMBER">&nbsp;<?=GetMessage("AUTH_REMEMBER_ME")?></label>
								</div>
							</li>		
						<?endif?>
		                                            
		            </ul>
		            <!--<div class="remember-me-popup">
					    <div class="remember-me-popup-head">
					        <h3>What's this?</h3>
					        <a href="#" class="remember-me-popup-close" title="Close">Close</a>
					    </div>
					    <div class="remember-me-popup-body">
					        <p>Checking "Remember Me" will let you access your shopping cart on this computer when you are logged out</p>
					        <div class="remember-me-popup-close-button a-right">
					            <a href="#" class="remember-me-popup-close button" title="Close"><span>Close</span></a>
					        </div>
					    </div>
					</div>-->

		        </div>
		        <div class="buttons-set">
		            <button class="button" name="register_submit_button" value="<?=GetMessage("AUTH_AUTHORIZE")?>" type="submit" autocomplete="off"><span><span>ВОЙТИ</span></span></button>
		            <!--<a href="https://www.shockdoctor.com/customer/account/forgotpassword/" class="f-left">Forgot Your Password?</a>-->
		            <?if ($arParams["NOT_SHOW_LINKS"] != "Y"):?>
						<noindex>
							<a class="f-left" href="<?=$arResult["AUTH_FORGOT_PASSWORD_URL"]?>" rel="nofollow"><?/*=GetMessage("AUTH_FORGOT_PASSWORD_2")*/?>Забыли пароль?</a>
						</noindex>
					<?endif?>
		        </div>
		    </div>
		</div>

            <style type="text/css">
	          .button.button-secondary, .buttons-set .button, .cart-table .product-cart-actions .button, #co-shipping-method-form .buttons-set .button, .footer .button {
				    -moz-border-radius: 0;
				    -webkit-border-radius: 0;
				    border-radius: 0;
				    background: #f66c1c;
				    display: inline-block;
				    padding: 10px 18px;
				    color: #fff;
				    border: none;
				    font-size: 16px;
				    font-weight: 400;
				    font-family: "Klavika Basic", sans-serif;
				    line-height: 20px;
				    text-align: center;
				    text-transform: uppercase;
				    vertical-align: middle;
				    overflow: hidden;
				    position: relative;
				}
				.cart-table .product-cart-actions .button:hover, .buttons-set .button:hover{
					    background: #000;
    					cursor: pointer;
				}
				.buttons-set a.button {
				    text-decoration: none;
				}
				label.required:after, span.required:after {
				    content: ' * ';
				    color: #ee372a;
				    font-weight: normal;
				    font-family: "Helvetica Neue",Verdana,Arial,sans-serif;
				    font-size: 12px;
				}
            </style>
   </div>
<!--<table class="login-form-table">
<tbody>
	<tr>
		<td>
		
		
		
			<input type="hidden" name="AUTH_FORM" value="Y" />
			<input type="hidden" name="TYPE" value="AUTH" />
			<?if (strlen($arResult["BACKURL"]) > 0):?>
			<input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
			<?endif?>
			<?foreach ($arResult["POST"] as $key => $value):?>
			<input type="hidden" name="<?=$key?>" value="<?=$value?>" />
			<?endforeach?>
			
			<ul class="form-list">
				<li>
					<label for="USER_LOGIN">
						<?=GetMessage("AUTH_LOGIN")?>
					</label>
					<div class="input-box">
						<input id="USER_LOGIN" class="bx-auth-input" type="text" name="USER_LOGIN" maxlength="255" value="<?=$arResult["LAST_LOGIN"]?>" />
					</div>
				</li>
				<li>
					<label for="USER_PASSWORD">
						<?=GetMessage("AUTH_PASSWORD")?>
					</label>
					<div class="input-box">
						<input id="USER_PASSWORD" class="bx-auth-input" type="password" name="USER_PASSWORD" maxlength="255" />
					</div>
				</li>
				<li>
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
				</li>

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
				
				<?if ($arResult["STORE_PASSWORD"] == "Y"):?>
				<li>
					<div class="input-box">
						<input type="checkbox" id="USER_REMEMBER" name="USER_REMEMBER" value="Y" /><label for="USER_REMEMBER">&nbsp;<?=GetMessage("AUTH_REMEMBER_ME")?></label>
					</div>
				</li>		
				<?endif?>

			</ul>

			<?if ($arParams["NOT_SHOW_LINKS"] != "Y"):?>
				<noindex>
					<a class="forgot wnd-open" href="<?=$arResult["AUTH_FORGOT_PASSWORD_URL"]?>" rel="nofollow"><?=GetMessage("AUTH_FORGOT_PASSWORD_2")?></a>
				</noindex>
			<?endif?>

			<div class="buttons-set form-buttons btn-only">
				<button class="button wnd-submit cta wnd-open" name="register_submit_button" value="<?=GetMessage("AUTH_AUTHORIZE")?>" type="submit" autocomplete="off">
					<span><span><?=GetMessage("AUTH_AUTHORIZE")?></span></span>
				</button>
				<?/*
				<input name="Login" class="wnd-submit" type="submit" value="<?=GetMessage("AUTH_AUTHORIZE")?>" />
				*/?>
			</div>

		</td>
		<td class="column-separator"></td>
		<td class="right">
			<div class="members-receive">
				Члены получают
			</div>
			<ul class="members-pluses">
				<li>
					Бесплатный Стандартная доставка на
					<br/>
					любой заказ
				</li>
				<li>
					Новости о продукции и проникнуть Пикс
				</li>
				<li>
					Эксклюзивный контент спортсмен
				</li>
				<li>
					Эксклюзивные специальные предложения
				</li>
			</ul>
			<?if($arParams["NOT_SHOW_LINKS"] != "Y" && $arResult["NEW_USER_REGISTRATION"] == "Y" && $arParams["AUTHORIZE_REGISTRATION"] != "Y"):?>
				<noindex>
					<a class="btn wnd-open" href="/register/<?/*=$arResult["AUTH_REGISTER_URL"]*/?>" rel="nofollow"><span><?=GetMessage("AUTH_CREATE_ACCOUNT")?></span></a>
					<?/*=GetMessage("AUTH_FIRST_ONE")*/?>
				</noindex>
			<?endif?>
		</td>
	</tr>
</tbody>
</table>-->

</form>


</div><!-- [end bx-auth] -->


</div><!-- [end form-container] -->
</div><!-- [end col-main] -->


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

