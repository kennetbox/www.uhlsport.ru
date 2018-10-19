<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?><?
?>
<div class="col-main">
<div class="my-account">
	
	<div class="page-title">
		<div class="phone"><span class="title">Позвоните нам:</span> <span class="digit">1-800-233-6956</span></div>
		<h1>
			Ваш аккаунт
		</h1>
	</div>

	<div class="bx_profile my-account-body">
		<form id="form-validate" method="post" name="form1" action="<?=$arResult["FORM_TARGET"]?>?" enctype="multipart/form-data">

			<?=ShowError($arResult["strProfileError"]);?>
			<?
			if ($arResult['DATA_SAVED'] == 'Y')
				echo ShowNote(GetMessage('PROFILE_DATA_SAVED'));
				/*
				echo "<pre>";
					print_r($arResult["arUser"]);
				echo "<pre>";
				*/
			?>
		
			<table class="form-table">
				<tbody>
					<tr>
						<td class="left">
							
							<?=$arResult["BX_SESSION_CHECK"]?>
							<input type="hidden" name="lang" value="<?=LANG?>" />
							<input type="hidden" name="ID" value=<?=$arResult["ID"]?> />
							<input type="hidden" name="LOGIN" value=<?=$arResult["arUser"]["LOGIN"]?> />
							<input type="hidden" name="EMAIL" value=<?=$arResult["arUser"]["EMAIL"]?> />

							<h2>
								<?=GetMessage("LEGEND_PROFILE")?>
							</h2>
							
						<ul class="form-list">
							<li>							
								<div class="field">
									<label>
										<?=GetMessage('NAME')?>
									</label>
									<div class="input-box">
										<input type="text" name="NAME" maxlength="50" value="<?=$arResult["arUser"]["NAME"]?>" />
									</div>
								</div>
							</li>
							<li>
								<div class="field">
									<label>
										<?=GetMessage('LAST_NAME')?>
									</label>
									<div class="input-box">
										<input type="text" name="LAST_NAME" maxlength="50" value="<?=$arResult["arUser"]["LAST_NAME"]?>" />
									</div>
								</div>
							</li>
							<li>
								<div class="field">
									<label>
										Email
									</label>
									<div class="input-box">
										<input type="text" name="EMAIL" maxlength="50"  value="<?=$arResult["arUser"]["EMAIL"]?>" />
									</div>
								</div>
							</li>
							<li>
								<div class="field">
									<label>
										Телефон: ( ex: 555-555-5555 )
									</label>
									<div class="input-box">
										<input type="text" name="PERSONAL_PHONE" maxlength="50"  value="<?=$arResult["arUser"]["PERSONAL_PHONE"]?>" />
									</div>
								</div>
							</li>
							<li>
								<div class="field field-dob">
									<label for="month">Дата рождения: <i>(MM/DD/YYYY)</i></label>
									<div class="input-box customer-dob">
										<input type="text" class="input-text validate-custom" maxlength="2" title="Month" value="<?=$arResult["arUser"]["UF_BIRTH_DAY"]?>" name="UF_BIRTH_DAY" id="month" />
										<input type="text" class="input-text validate-custom" maxlength="2" title="Day" value="<?=$arResult["arUser"]["UF_BIRTH_MONTH"]?>" name="UF_BIRTH_MONTH" id="day">
										<input type="text" class="input-text validate-custom" maxlength="4" title="Year" value="<?=$arResult["arUser"]["UF_BIRTH_YEAR"]?>" name="UF_BIRTH_YEAR" id="year" autocomplete="off">

										<div style="clear:both"></div>

										<span style="display:none;" class="dob-full">
											<input type="hidden" name="dob" id="full">
										</span>

										<div style="opacity: 0.999999; display: none;" id="date-advice" class="validation-advice"></div>
									</div>

									<script type="text/javascript">
									//&lt;![CDATA[
										var customer_dob = new ShockDoctor.Validate.Date('id', '', false, '%m/%e/%y');
									//]]&gt;
									</script>
								</div>
							</li>
						</ul>
						
						
						<h3>
							Сохранить ваш адрес для быстрее<br />оформлять заказы
						</h3>
						<ul class="form-list">
							<li class="fields">
								<div class="field">
									<label for="street_1">Address 1:</label>
									<div class="input-box">
										<input type="text" class="input-text" id="street_1" title="Street Address" value="<?=$arResult["arUser"]["PERSONAL_STREET"]?>" name="PERSONAL_STREET" />
									</div>
								</div>
								<div class="field">
									<label for="street_2">Address 2:</label>
									<div class="input-box">
										<input type="text" class="input-text" id="street_2" title="Street Address 2" value="<?=$arResult["arUser"]["PERSONAL_NOTES"]?>" name="PERSONAL_NOTES">
									</div>
								</div>
							</li>
							<li class="fields">
								<div class="field">
									<label for="city">City:</label>
									<div class="input-box">
										<input type="text" id="city" class="input-text" title="City" value="<?=$arResult["arUser"]["PERSONAL_CITY"]?>" name="PERSONAL_CITY" />
									</div>
								</div>
							</li>
							<li class="fields">
								<table>
									<tbody>
										<tr>
											<td>
												<div class="field">
													<label for="region_id">Страна:</label>
													<div class="input-box input-box-state">
														
														<?
															echo SelectBoxFromArray(
																"COUNTRY_ID", 
																GetCountryArray(), 
																$COUNTRY_ID, 
																"выберите страну"
															);
														?>
														

														<script type="text/javascript">
															//&lt;![CDATA[
															$('region_id').setAttribute('defaultValue',  "0");
															//]]&gt;
														</script>
														<input type="text" style="display: none;" class="input-text" title="State" value="<?=$arResult["arUser"]["PERSONAL_STATE"]?>" name="PERSONAL_STATE" id="region" />
													</div>
												</div>
											</td>
											<td>
												<div class="field">
													<label class="required" for="zip"><em>*</em>Zip:</label>
													<div class="input-box">
														<input type="text" class="input-text validate-zip-international zip required-entry" id="" title="Zip Code" value="<?=$arResult["arUser"]["PERSONAL_ZIP"]?>" name="PERSONAL_ZIP" />
													</div>
												</div>
											</td>
										</tr>
									</tbody>
								</table>
							</li>
						</ul>
					
						
						
						
							<h3>
								Изменить пароль
								<?/*=GetMessage("MAIN_PSWD")*/?>
							</h3>
							
							<ul class="form-list">
								<li id="current_password2_container" class="fields">
									<label for="current_password2"><em>*</em>Введите старый пароль:</label><label for="change_password" class="orange">Редактировать пароль</label>
									<div class="input-box">
										<input type="password" id="current_password2" name="PASSWORD" class="input-text" onfocus="setPasswordForm(1)">
									</div>
									<div class="password">
										<input type="checkbox" class="checkbox" title="Edit Password" onclick="setPasswordForm(this.checked)" value="1" id="change_password" name="change_password">
									</div>
								</li>
							</ul>
							
							<div class="fieldset">
								<ul class="form-list">
									<li class="fields">
										<label for="current_password"><em>*</em>Введите старый пароль:</label>
										<div class="input-box">
											<input type="password" id="current_password" name="PASSWORD" class="input-text">
										</div>
									</li>
									<li class="fields">
										<label for="password"><em>*</em>Новый пароль: <i>( Минимум 6 символов )</i></label>
										<div class="input-box">
											<input type="password" id="password" name="NEW_PASSWORD" class="input-text validate-password required-entry">
										</div>
									</li>
									<li class="fields">
										<label for="confirmation"><em>*</em>Подтвердите новый пароль:</label>
										<div class="input-box">
											<input type="password" id="confirmation" name="NEW_PASSWORD_CONFIRM" class="input-text validate-cpassword required-entry">
										</div>
									</li>
								</ul>
								<label for="change_password" class="orange">Отменить изменение пароля</label>
							</div>

							
							<?
							/*
								<div class="field">
									<label>
										<?=GetMessage('NEW_PASSWORD_REQ')?>
									</label>
									<div class="input-box">
										<input type="password" name="NEW_PASSWORD" maxlength="50" value="" autocomplete="off" />
									</div>
								</div>
								
								<div class="field">
									<label>
										<?=GetMessage('NEW_PASSWORD_CONFIRM')?>
									</label>
									<div class="input-box">
										<input type="password" name="NEW_PASSWORD_CONFIRM" maxlength="50" value="" autocomplete="off" />
									</div>
								</div>
								<input name="save" value="<?=GetMessage("MAIN_SAVE")?>" class="bt_blue big shadow" type="submit" />
							*/
							?>
							
						</td>
						<td class="column-separator"></td>
						<td class="right">
							<div class="onestepcheckout-enable-newsletter">
								<input type="checkbox" id="id_subscribe" name="UF_SPECIAL_OFFER" <? if( !empty($arResult["arUser"]["UF_SPECIAL_OFFER"]) ) { ?>checked="checked"<? } ?> value="1">
								<label for="id_subscribe">Отправить мне Shock Doctor предложения по электронной почте.</label>
							</div>
							<div class="line-separator"></div>
							<label>Вы используете продукты Doctor Products?</label>
							<table class="two-cols"><tbody><tr>
								<td>
									<input type="radio" name="UF_USING_PRODUCTS" id="use_products1" value="1">
									<label for="use_products1">Да</label>
								</td>
								<td>
									<input type="radio" name="UF_USING_PRODUCTS" id="use_products2" value="0" checked="checked">
									<label for="use_products2">Нет</label>
								</td>
							</tr></tbody></table>

							<br><br><br>
							<label>Каким спортом Вы увлекаетесь?</label>
							<table class="sports">
								<tbody>
									<tr>
										<td>
											<input type="checkbox" name="UF_SPORT_FOOTBALL" <? if( !empty($arResult["arUser"]["UF_SPORT_FOOTBALL"]) ) { ?>checked="checked"<? } ?> id="sport_football">
											<label for="sport_football">Футбол</label>
										</td>
										<td>
											<input type="checkbox" name="UF_SPORT_BASKETBALL" <? if( !empty($arResult["arUser"]["UF_SPORT_BASKETBALL"]) ) { ?>checked="checked"<? } ?> id="sport_basketball">
											<label for="sport_basketball">Баскетбол</label>
										</td>
									</tr>
									<tr>
										<td>
											<input type="checkbox" name="UF_SPORT_HOCKEY" <? if( !empty($arResult["arUser"]["UF_SPORT_HOCKEY"]) ) { ?>checked="checked"<? } ?> id="sport_hockey">
											<label for="sport_hockey">Хоккей</label>
										</td>
										<td>
											<input type="checkbox" name="UF_SPORT_VOLLEYBALL" <? if( !empty($arResult["arUser"]["UF_SPORT_VOLLEYBALL"]) ) { ?>checked="checked"<? } ?> id="sport_volleyball">
											<label for="sport_volleyball">Волейбол</label>
										</td>
									</tr>
									<tr>
										<td>
											<input type="checkbox" name="UF_SPORT_LACROSSE" <? if( !empty($arResult["arUser"]["UF_SPORT_LACROSSE"]) ) { ?>checked="checked"<? } ?> id="sport_lacrosse">
											<label for="sport_lacrosse">Лакросс</label>
										</td>
										<td>
											<input type="checkbox" name="UF_SPORT_BOXING" <? if( !empty($arResult["arUser"]["UF_SPORT_BOXING"]) ) { ?>checked="checked"<? } ?> id="sport_mmaboxing">
											<label for="sport_mmaboxing">MMA / Бокс</label>
										</td>
									</tr>
									<tr>
										<td>
											<input type="checkbox" name="UF_SPORT_BASEBALL" <? if( !empty($arResult["arUser"]["UF_SPORT_BASEBALL"]) ) { ?>checked="checked"<? } ?> id="sport_baseball">
											<label for="sport_baseball">Бейсбол</label>
										</td>
										<td>
											<input type="checkbox" name="UF_SPORT_ACTIVE" <? if( !empty($arResult["arUser"]["UF_SPORT_ACTIVE"]) ) { ?>checked="checked"<? } ?> id="sport_actionsport">
											<label for="sport_actionsport">Активные виды спорта</label>
										</td>
									</tr>
									<tr>
										<td>
											<input type="checkbox" name="UF_SPORT_SOFTBALL" <? if( !empty($arResult["arUser"]["UF_SPORT_SOFTBALL"]) ) { ?>checked="checked"<? } ?> id="sport_softball">
											<label for="sport_softball">Софтбол</label>
										</td>
										<td>
											<input type="checkbox" name="UF_SPORT_TRAINING" <? if( !empty($arResult["arUser"]["UF_SPORT_TRAINING"]) ) { ?>checked="checked"<? } ?> id="sport_training">
											<label for="sport_training">Тренировка</label>
										</td>
									</tr>
									<tr>
										<td>
											<input type="checkbox" name="UF_SPORT_RUGBY" <? if( !empty($arResult["arUser"]["UF_SPORT_RUGBY"]) ) { ?>checked="checked"<? } ?> id="sport_rugby">
											<label for="sport_rugby">Регби</label>
										</td>
										<td>
											<input type="checkbox" name="UF_SPORT_HANDBALL" <? if( !empty($arResult["arUser"]["UF_SPORT_HANDBALL"]) ) { ?>checked="checked"<? } ?> id="sport_handball">
											<label for="sport_handball">Гандбол</label>
										</td>
									</tr>
									<tr>
										<td colspan="2">
											<input type="checkbox" name="UF_SPORT_LAWN_HOCKEY" <? if( !empty($arResult["arUser"]["UF_SPORT_LAWN_HOCKEY"]) ) { ?>checked="checked"<? } ?> id="sport_fieldhockey">
											<label for="sport_fieldhockey">Хоккей на траве</label>
										</td>
									</tr>
								</tbody>
							</table>

							<div class="line-separator"></div>

							<table class="form-buttons">
								<tbody>
									<tr>
										<td class="cancel" style="vertical-align: top;">
											<a href="/personal/"><span>Отменить</span></a>
										</td>
										<td class="save">
											<button class="button wnd-submit cta wnd-open" name="save" value="<?=GetMessage("MAIN_SAVE")?>"><span>Обновить</span></button>
											<?/*
											<a class="" id="edit_account_submitter" href="javascript:void(0)"><span>Обновить</span></a>
											*/?>
										</td>
									</tr>
								</tbody>
							</table>

							<div class="line-separator"></div>

							<div class="assistance">
								<div class="picture"><!-- picture --></div>
								<div class="two-lines">
									<div class="need">Нужна помощь?</div>
									<div class="service">Обслуживание клиентов</div>
								</div>

								<div class="clear"></div>

								<div class="text-info">
									<div>Email: <span class="orange">cs@shockdoctor.com</span></div>
									<div>Phone: <span class="digit">1-800-233-6956</span></div>
									<div>Часы работы: Пн.-Пт., с 8 до 17</div>
									<div>Выходные: Сб., Вс.</div>
								</div>
							</div>
						</td>
					</tr>
				</tbody>
			</table>
		</form>
	</div>

	<?
	/*
	if($arResult["SOCSERV_ENABLED"])
	{
		$APPLICATION->IncludeComponent("bitrix:socserv.auth.split", ".default", array(
				"SHOW_PROFILES" => "Y",
				"ALLOW_DELETE" => "Y"
			),
			false
		);
	}
	*/
	?>

</div><!-- [end my-account] -->
</div><!-- [end col-main] -->

