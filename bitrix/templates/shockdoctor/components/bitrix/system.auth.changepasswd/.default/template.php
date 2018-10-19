<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<div class="bx-auth login-form-table">
	
	<div class="page-title">
		<h1>
			<?
				ShowMessage($arParams["~AUTH_RESULT"]);
			?>
			<?=GetMessage("AUTH_CHANGE_PASSWORD")?>
		</h1>
	</div>
	
	<form id="login-form" method="post" action="<?=$arResult["AUTH_FORM"]?>" name="bform">
		
		<?if (strlen($arResult["BACKURL"]) > 0): ?>
		<input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
		<? endif ?>
		
		<input type="hidden" name="AUTH_FORM" value="Y" />
		<input type="hidden" name="TYPE" value="CHANGE_PWD" />
		
<table class="login-form-table">
<tbody>
	<tr>
		<td>
			<ul class="form-list">
				<li class="dnone">
					<label for="USER_LOGIN">
						<?=GetMessage("AUTH_LOGIN")?><span class="starrequired">*</span>
					</label>
					<div class="input-box">
						<input id="USER_LOGIN" type="hidden" name="USER_LOGIN" maxlength="50" value="<?=$arResult["LAST_LOGIN"]?>" class="bx-auth-input" />
					</div>
				</li>
				<li>				
					<label for="USER_LOGIN">
						<span class="starrequired">*</span><?=GetMessage("AUTH_CHECKWORD")?>
					</label>
					<div class="input-box">
						<input type="text" name="USER_CHECKWORD" maxlength="50" value="<?=$arResult["USER_CHECKWORD"]?>" class="bx-auth-input" />
					</div>
				</li>
				<li>
					<label for="USER_LOGIN">
						<?=GetMessage("AUTH_NEW_PASSWORD_REQ")?><span class="starrequired">*</span>
					</label>
					<div class="input-box">
						<input type="password" name="USER_PASSWORD" maxlength="50" value="<?=$arResult["USER_PASSWORD"]?>" class="bx-auth-input" />
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
				</li>
				<li>
					
					<label for="USER_LOGIN">
						<?=GetMessage("AUTH_NEW_PASSWORD_CONFIRM")?><span class="starrequired">*</span>
					</label>	
					<div class="input-box">
						<input type="password" name="USER_CONFIRM_PASSWORD" maxlength="50" value="<?=$arResult["USER_CONFIRM_PASSWORD"]?>" class="bx-auth-input"  />
					</div>
				</li>
			</ul>

			
			<div class="buttons-set form-buttons btn-only">
				<button class="button wnd-submit cta wnd-open" name="change_pwd" value="<?=GetMessage("AUTH_CHANGE")?>"><?=GetMessage("AUTH_CHANGE")?>	</button>
				<?/*
				<input type="submit" name="change_pwd" value="<?=GetMessage("AUTH_CHANGE")?>" />
				*/?>
			</div>

	<p>
		&nbsp;
	</p>
	<p>
		<?echo $arResult["GROUP_POLICY"]["PASSWORD_REQUIREMENTS"];?>
	</p>
	
	<p>
		<span class="starrequired">*</span><?=GetMessage("AUTH_REQ")?>
	</p>
	<p>
		&nbsp;
	</p>
	<p>
		<a class="forgot wnd-open" href="<?=$arResult["AUTH_AUTH_URL"]?>"><?=GetMessage("AUTH_AUTH")?></a>
	</p>


		</td>
		<td class="column-separator"></td>
		<td class="right">
			&nbsp;
		</td>
	</tr>
</tbody>
</table>
</form>
	
</form>

<script type="text/javascript">
document.bform.USER_LOGIN.focus();
</script>

</div>