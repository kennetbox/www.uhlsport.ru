<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?/*
<div class="steps">
	<span>Личные данные</span>
</div>
*/?>

	<div class="user-data">
		<form id="form-validate" method="post" action="<?= $arParams["PATH_TO_ORDER"] ?>" name="order_auth_form">
			<?=bitrix_sessid_post()?>
			<h3>
				<?/*if($arResult["AUTH"]["new_user_registration"]=="Y"):?>
					<?echo GetMessage("STOF_2REG")?>
				<?endif;*/?>
				Вход
				<?/*echo GetMessage("STOF_LOGIN_PROMT")*/?>
			</h3>
			<p>
				Введите свои регистрационные данные, чтобы продолжитьоформление заказа.
			</p>
			<div class="field name-firstname">
				<label class="field-label" for="USER_LOGIN">
					<span><?echo GetMessage("STOF_LOGIN")?> <br>/email<span class="sof-req">*</span></span>
				</label>
				<div class="input-box">
					<input class="input-text" type="text" id="USER_LOGIN" name="USER_LOGIN" maxlength="30" size="30" value="<?=$arResult["USER_LOGIN"]?>" />
				</div>
			</div>

			<div class="field name-firstname">
				<label class="field-label" for="USER_PASSWORD">
					<span><?echo GetMessage("STOF_PASSWORD")?><span class="sof-req">*</span></span>
				</label>
				<div class="input-box">
					<input class="input-text" id="USER_PASSWORD" type="password" name="USER_PASSWORD" maxlength="30" size="30" />
				</div>
			</div>

			<div class="field">
				<label class="field-label"><span></span></label>
				<input type="hidden" name="do_authorize" value="Y" />				
				<button type="submit" value="<?echo GetMessage("STOF_NEXT_STEP")?>" class="cta cta-lg">Войти</button>
			</div>
			
			<div class="field">
				<label class="field-label"><span></span></label>
				<p class="forgot">
					<a href="/login/?forgot_password=yes"><?echo GetMessage("STOF_FORGET_PASSWORD")?></a>
					<? /*
					<a href="<?=$arParams["PATH_TO_AUTH"]?>?forgot_password=yes&back_url=<?= urlencode($arParams["PATH_TO_ORDER"]); ?>"><?echo GetMessage("STOF_FORGET_PASSWORD")?></a>
					*/ ?>
				</p>
			</div>
		</form>
		
		<script type="text/javascript">
			//&lt;![CDATA[
				var dataForm = new VarienForm('form-validate', true);
			//]]&gt;
		</script>
		
		

	
	
		<?
		
		if($arResult["AUTH"]["new_user_registration"]=="Y"):
		?>
			
			<div class="guest">
				<form style="background: transparent;" method="post" action="<?= $arParams["PATH_TO_ORDER"]?>" name="order_reg_form">
					<fieldset>
						<input type="hidden" name="ptype" value="guest" />
						<input type="hidden" name="PERSON_TYPE_1" value="1" />
						<h3>
							Для новых покупателей
						</h3>
						<p>
							Если вы впервые на нашем сайте, то просто продолжите оформление заказа. В процессе заполнения форм вы сможете внести все нужные для формирования заказа контактные данные.
						</p>
						<button class="cta cta-lg" type="submit">Продолжить как гость</button>
						<!--<a class="cta cta-lg" href="#">Продолжить как гость</a>-->
					</fieldset>
				</form>
			</div>
		<? 	/*
			// [Для новых покупателей - форма регистрации]
		?>
			<form style="background: transparent;" method="post" action="<?= $arParams["PATH_TO_ORDER"]?>" name="order_reg_form">
				<?=bitrix_sessid_post()?>
				
				<h3>
					<?if($arResult["AUTH"]["new_user_registration"]=="Y"):?>
						<?echo GetMessage("STOF_2NEW")?>
					<?endif;?>
				</h3>

				<div class="field name-firstname">
					<label class="field-label">
						<span><?echo GetMessage("STOF_NAME")?> <span class="sof-req">*</span></span>
					</label>
					<div class="input-box">
						<input class="input-text" type="text" name="NEW_NAME" size="40" value="<?=$arResult["POST"]["NEW_NAME"]?>" />
					</div>
				</div>

				<div class="field name-firstname">
					<label class="field-label">
						<span><?echo GetMessage("STOF_LASTNAME")?> <span class="sof-req">*</span></span>
					</label>
					<div class="input-box">
						<input class="input-text" type="text" name="NEW_LAST_NAME" size="40" value="<?=$arResult["POST"]["NEW_LAST_NAME"]?>" />
					</div>
				</div>

				<div class="field name-firstname">
					<label class="field-label">
						<span>E-Mail <span class="sof-req">*</span></span>
					</label>
					<div class="input-box">
						<input class="input-text" type="text" name="NEW_EMAIL" size="40" value="<?=$arResult["POST"]["NEW_EMAIL"]?>" />
					</div>
				</div>

				<?if($arResult["AUTH"]["new_user_registration_email_confirmation"] != "Y"):?>
					
					<div class="field name-firstname">
						<div class="input-box">
							<input type="radio" id="NEW_GENERATE_N" name="NEW_GENERATE" value="N" OnClick="ChangeGenerate(false)"<?if ($arResult["POST"]["NEW_GENERATE"] == "N") echo " checked";?>> <label for="NEW_GENERATE_N"><?echo GetMessage("STOF_MY_PASSWORD")?></label>
						</div>
					</div>
					
				<?endif;?>
				
				<?if($arResult["AUTH"]["new_user_registration_email_confirmation"] != "Y"):?>

						<div id="sof_choose_login">
							
				<?endif;?>
								
					<?if($arResult["AUTH"]["new_user_registration_email_confirmation"] != "Y"):?>
					
					<?endif;?>
					
						<div class="field name-firstname">
							<label class="field-label">
								<?echo GetMessage("STOF_LOGIN")?> <span class="sof-req">*</span>
							</label>
							
							<div class="input-box">
								<input class="input-text" type="text" name="NEW_LOGIN" size="30" value="<?=$arResult["POST"]["NEW_LOGIN"]?>" />
							</div>
						</div>
						
					<?if($arResult["AUTH"]["new_user_registration_email_confirmation"] != "Y"):?>
					
					<?endif;?>
						
						<div class="field name-firstname">
							<label class="field-label">
								<span><?echo GetMessage("STOF_PASSWORD")?> <span class="sof-req">*</span></span>
							</label>
							
							<div class="input-box">
								<input class="input-text" type="password" name="NEW_PASSWORD" size="30" />
							</div>
						</div>
						
					<?if($arResult["AUTH"]["new_user_registration_email_confirmation"] != "Y"):?>
					
					<?endif;?>
						
						<div class="field name-firstname">
						
							<label class="field-label">
								<span><?echo GetMessage("STOF_RE_PASSWORD")?> <span class="sof-req">*</span></span>
							</label>
							
							<div class="input-box">
								<input class="input-text" type="password" name="NEW_PASSWORD_CONFIRM" size="30" />
							</div>
						</div>
								
				<?if($arResult["AUTH"]["new_user_registration_email_confirmation"] != "Y"):?>
							
						</div>

				<?endif;?>
				
				<?if($arResult["AUTH"]["new_user_registration_email_confirmation"] != "Y"):?>
					<div class="field name-firstname">
						<div class="input-box">
							
							<input type="radio" id="NEW_GENERATE_Y" name="NEW_GENERATE" value="Y" OnClick="ChangeGenerate(true)"<?if ($arResult["POST"]["NEW_GENERATE"] != "N") echo " checked";?>> <label for="NEW_GENERATE_Y"><?echo GetMessage("STOF_SYS_PASSWORD")?></label>
							<script language="JavaScript">
							<!--
							ChangeGenerate(<?= (($arResult["POST"]["NEW_GENERATE"] != "N") ? "true" : "false") ?>);
							//-->
							</script>
							
						</div>
					</div>
				<?endif;?>
				<?
				if($arResult["AUTH"]["captcha_registration"] == "Y") //CAPTCHA
				{
					?>
							
						<div class="field name-firstname">

							<div>
								<?=GetMessage("CAPTCHA_REGF_TITLE")?>
							</div>

							<label class="field-label">
								
								<span><?=GetMessage("CAPTCHA_REGF_PROMT")?> <span class="sof-req">*</span>:</span>
								
							</label>
							<div class="input-box">
								
								<div>
									<input type="hidden" name="captcha_sid" value="<?=$arResult["AUTH"]["capCode"]?>">
									<img src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult["AUTH"]["capCode"]?>" width="180" height="40" alt="CAPTCHA" />
								</div>

								<input class="input-text" type="text" name="captcha_word" size="30" maxlength="50" value="" />										
								
							</div>
						</div>

					<?
				}
				?>

				<input class="cta cta-lg" type="submit" value="<?echo GetMessage("STOF_NEXT_STEP")?>" />

				<button type="submit" value="Продолжить оформление заказа" class="cta cta-lg" value="<?echo GetMessage("STOF_NEXT_STEP")?>">Продолжить оформление</button>
				<input type="hidden" name="do_register" value="Y" />

			</form>
		<?
			// [Для новых покупателей - форма регистрации]
			*/
		?>
		<?
		endif;
		?>
		
		
	</div><!-- [end user-data] -->
		

	<?/*
	<?echo GetMessage("STOF_REQUIED_FIELDS_NOTE")?>

	<?if($arResult["AUTH"]["new_user_registration"]=="Y"):?>
		<?echo GetMessage("STOF_EMAIL_NOTE")?>
	<?endif;?>

	<?echo GetMessage("STOF_PRIVATE_NOTES")?>
	*/?>
