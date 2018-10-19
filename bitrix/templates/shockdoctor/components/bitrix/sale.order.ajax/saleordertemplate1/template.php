<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?

if($USER->IsAuthorized() || $arParams["ALLOW_AUTO_REGISTER"] == "Y")
{
	if($arResult["USER_VALS"]["CONFIRM_ORDER"] == "Y" || $arResult["NEED_REDIRECT"] == "Y")
	{
		if(strlen($arResult["REDIRECT_URL"]) > 0)
		{
			$APPLICATION->RestartBuffer();
			?>
			<script type="text/javascript">
				window.top.location.href='<?=CUtil::JSEscape($arResult["REDIRECT_URL"])?>';
			</script>
			<?
			die();
		}

	}
}

$APPLICATION->SetAdditionalCSS($templateFolder."/style_cart.css");
$APPLICATION->SetAdditionalCSS($templateFolder."/style.css");
CJSCore::Init(array('fx', 'popup', 'window', 'ajax'));

?>

<div class="cart">
	<div class="cart-header">
		<div class="cart-header-contents">
			<h1>
				<span class="step current">Корзина</span>
				<span class="step item">Формирование заказа</span>
			</h1>
			<h2>
				<a href="/">Продолжить покупки</a>
			</h2>
		</div>
	</div>

<div class="content">
<div class="cart-contents">
	<a name="order_form"></a>
	
	<? if( isset( $_REQUEST['ORDER_ID'] ) && (int) $_REQUEST['ORDER_ID'] ) { ?>
	
		<div class="steps">
			<span>Заказ успешно оформлен</span>
		</div>
	
	<? } else { ?>
	
		<div class="steps">
			<span>
				Доставка
			</span>
			<ul>
				<li>
					<span class="digit">1</span>
					<div><b>Корзина</b></div>
				</li>
				<li class="active">
					<span class="digit">2</span>
					<div><b>Адрес и способ<br>доставки</b></div>
				</li>
				<li>
					<span class="digit">3</span>
					<div><b>Вариант<br>оплаты</b></div>
				</li>
				<li>
					<span class="digit">4</span>
					<div><b>Подтвердить<br>заказ</b></div>
				</li>
			</ul>
		</div>
	
	<? } ?>
	
	
	<div id="order_form_div" class="order-checkout <? if( !isset( $_REQUEST['ORDER_ID'] ) ) { ?>cart-form-container<? } ?>">
		
		<NOSCRIPT>
			<div class="errortext">
				<?=GetMessage("SOA_NO_JS")?>
			</div>
		</NOSCRIPT>

		<?
		if (!function_exists("getColumnName"))
		{
			function getColumnName($arHeader)
			{
				return (strlen($arHeader["name"]) > 0) ? $arHeader["name"] : GetMessage("SALE_".$arHeader["id"]);
			}
		}

		if (!function_exists("cmpBySort"))
		{
			function cmpBySort($array1, $array2)
			{
				if (!isset($array1["SORT"]) || !isset($array2["SORT"]))
					return -1;

				if ($array1["SORT"] > $array2["SORT"])
					return 1;

				if ($array1["SORT"] < $array2["SORT"])
					return -1;

				if ($array1["SORT"] == $array2["SORT"])
					return 0;
			}
		}
		?>

		<div class="bx_order_make">
			<?
			if(!$USER->IsAuthorized() && $arParams["ALLOW_AUTO_REGISTER"] == "N")
			{
				if(!empty($arResult["ERROR"]))
				{
					foreach($arResult["ERROR"] as $v)
						echo ShowError($v);
				}
				elseif(!empty($arResult["OK_MESSAGE"]))
				{
					foreach($arResult["OK_MESSAGE"] as $v)
						echo ShowNote($v);
				}

				include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/auth.php");
			}
			else
			{
				if($arResult["USER_VALS"]["CONFIRM_ORDER"] == "Y" || $arResult["NEED_REDIRECT"] == "Y")
				{
					if(strlen($arResult["REDIRECT_URL"]) == 0)
					{
						include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/confirm.php");
					}
				}
				else
				{
					?>
					<script type="text/javascript">
					function submitForm(val)
					{
						if(val != 'Y')
							BX('confirmorder').value = 'N';

						var orderForm = BX('ORDER_FORM');
						BX.ajax.submitComponentForm(orderForm, 'order_form_content', true);
						BX.submit(orderForm);
						BX.closeWait();

						return true;
					}

					function SetContact(profileId)
					{
						BX("profile_change").value = "Y";
						submitForm();
					}
					</script>
					
					<? if($_POST["is_ajax_post"] != "Y") { ?>
					
					<form id="ORDER_FORM" class="cart-form-address" action="<?=$APPLICATION->GetCurPage();?>" method="POST" name="ORDER_FORM" enctype="multipart/form-data">
						<?=bitrix_sessid_post()?>
						
						<div id="order_form_content">
							
							<? } else {
								$APPLICATION->RestartBuffer();
							} ?>

						<div class="cart-form">
							
							<?
							if(!empty($arResult["ERROR"]) && $arResult["USER_VALS"]["FINAL_STEP"] == "Y")
							{
								foreach($arResult["ERROR"] as $v)
									echo ShowError($v);
								?>
								<script type="text/javascript">
									top.BX.scrollToNode(top.BX('ORDER_FORM'));
								</script>
								<?
							}
							?>
							
							<? include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/person_type.php"); ?>
							
							<? include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/props.php"); ?>
							
							<?
								if ($arParams["DELIVERY_TO_PAYSYSTEM"] == "p2d")
								{
									include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/paysystem.php");
									include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/delivery.php");
								}
								else
								{
									include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/delivery.php");
									include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/paysystem.php");
								}
							?>
							
							<div class="field">
								<label class="field-label">
									<span>&nbsp;</span>
								</label>
								
									<a class="cta cta-lg" href="javascript:void();" onclick="submitForm('Y'); return false;">
										Продолжить
									</a>
									<?/*
									<a class="checkout cta cta-lg" href="javascript:void();" onclick="submitForm('Y'); return false;">
										<?=GetMessage("SOA_TEMPL_BUTTON")?>
									</a>
									*/?>
								<div <?/*class="bx_ordercart_order_pay_center"*/?>></div>
							</div><!-- [end field] -->
							
						</div><!-- [end cart-form] -->
						
						<div class="cart-summary">
							
							<? include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/related_props.php"); ?>

							<? include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/summary.php"); ?>
							
						</div><!-- [end cart-summary] -->
						
						<?
							if(strlen($arResult["PREPAY_ADIT_FIELDS"]) > 0) {
								echo $arResult["PREPAY_ADIT_FIELDS"];
							}
						?>

					<? if($_POST["is_ajax_post"] != "Y") { ?>
						
						</div><!-- [end order_form_content] -->
					
						<input type="hidden" name="confirmorder" id="confirmorder" value="Y" />
						<input type="hidden" name="profile_change" id="profile_change" value="N" />
						<input type="hidden" name="is_ajax_post" id="is_ajax_post" value="Y" />
						
					
					</form>
					
					<?/*
					if($arParams["DELIVERY_NO_AJAX"] == "N") { ?>
					
						<div>
							<?$APPLICATION->IncludeComponent("bitrix:sale.ajax.delivery.calculator", "", array(), null, array('HIDE_ICONS' => 'Y')); ?>
						</div>
						
					<? } 
					*/?><? /* style="display:none;" */ ?>
						
					<?
					}
					else
					{
					?>
						<script type="text/javascript">
							top.BX('confirmorder').value = 'Y';
							top.BX('profile_change').value = 'N';
						</script>
					<? die();
					}
					?>
					
					<?
				}
			}
			?>

		</div><!-- [end bx_order_make] -->
	</div><!-- [end order-checkout] -->
	
</div><!-- [end cart-contents] -->
</div><!-- [end content] -->



</div><!-- [end cart] -->