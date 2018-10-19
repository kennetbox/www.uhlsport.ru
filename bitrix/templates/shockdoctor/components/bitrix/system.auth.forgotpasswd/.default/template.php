<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<div class="col-main">
	<div class="form-container">

<div class="page-title">
	<h1>
		<?=GetMessage("AUTH_GET_CHECK_STRING")?>
	</h1>
</div>

<form id="form-validate" class="create-account" name="bform" method="post" target="_top" action="<?=$arResult["AUTH_URL"]?>">

<? ShowMessage($arParams["~AUTH_RESULT"]); ?>

<table class="login-form-table forgot">
	<tbody>
		<tr>
			<td>
				<? if (strlen($arResult["BACKURL"]) > 0) { ?>
					<input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
				<? } ?>
				<input type="hidden" name="AUTH_FORM" value="Y" />
				<input type="hidden" name="TYPE" value="SEND_PWD" />
				
				<?/*
				<p>
					<?=GetMessage("AUTH_FORGOT_PASSWORD_1")?>
				</p>
				*/?>
				<?/*
				<div class="field">
					<label>
						<?=GetMessage("AUTH_LOGIN")?>
					</label>
					<div class="input-box">
						<input type="text" name="USER_LOGIN" maxlength="50" value="<?=$arResult["LAST_LOGIN"]?>" />&nbsp;<?=GetMessage("AUTH_OR")?>
					</div>
				</div>
				*/?>
				
				<div class="fieldset">
					<ul class="form-list">
						<li>
							<div class="field">	
								<label>
									<?=GetMessage("AUTH_EMAIL")?>
								</label>
								<div class="input-box">
									<input type="text" name="USER_EMAIL" maxlength="255" />
								</div>
							</div>
						</li>
					</ul>
					
					<div class="field-bottom-text">
						<i>Введите адрес электронной почты, и мы вышлем вам <br> ссылку для восстановления пароля.</i>
					</div>
				</div>
				
				<div class="buttons-set form-buttons">
					
					<button type="submit" name="send_account_info" value="<?=GetMessage("AUTH_SEND")?>" class="button wnd-submit cta wnd-open"><span><span>Восстановить</span></span></button>
					
				</div>
				
				<?/*
				<p>
					<a href="<?=$arResult["AUTH_AUTH_URL"]?>"><b><?=GetMessage("AUTH_AUTH")?></b></a>
				</p>
				*/?>
				
			</td>
			<td class="column-separator"></td>
			<td class="right">
				<div class="members-receive">Члены получают</div>
				<ul class="members-pluses">
					<li>Бесплатный Стандартная доставка на любой заказ</li>
					<li>Новости о продукции и проникнуть Пикс</li>
					<li>Эксклюзивный контент спортсмен</li>
					<li>Эксклюзивные специальные предложения</li>
				</ul>
				<a href="/register/" class="btn wnd-open" wnd="registration"><span>Создать аккаунт</span></a>
			</td>
		</tr>
	</tbody>
</table>
</form>

	</div><!-- [end form-container] -->
</div><!-- [col-main] -->

<script type="text/javascript">
document.bform.USER_LOGIN.focus();
</script>
