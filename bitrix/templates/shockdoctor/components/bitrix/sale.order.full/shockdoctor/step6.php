<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<? /* Заказ завершен */ ?>

<div class="cart-complete">

	<? 	if (!empty($arResult["ORDER"])) { ?>
			
		<h3>Заказ №<?=$arResult["ORDER"]["ID"]?></h3>

		<p>
			На указанную вами почту будет отпралена копия информации о заказе. Наши менеджеры свяжутся с вами в ближайшее время для подтверждения данных.
		</p>
		
		<p class="back"><a href="/">На главную страницу</a></p>
	
		<?/*
		<?= str_replace("#ORDER_DATE#", $arResult["ORDER"]["DATE_INSERT_FORMATED"], str_replace("#ORDER_ID#", $arResult["ORDER"]["ACCOUNT_NUMBER"], GetMessage("STOF_ORDER_CREATED_DESCR"))); ?>
		
		<?= str_replace("#LINK#", $arParams["PATH_TO_PERSONAL"], GetMessage("STOF_ORDER_VIEW")) ?>
		*/?>

		<?
		/*
		if (!empty($arResult["PAY_SYSTEM"])) {
			?>
			
			<?echo GetMessage("STOF_ORDER_PAY_ACTION")?>

			<?echo GetMessage("STOF_ORDER_PAY_ACTION1")?> <?= $arResult["PAY_SYSTEM"]["NAME"] ?>

				<?
				if (strlen($arResult["PAY_SYSTEM"]["ACTION_FILE"]) > 0)
				{
					?>
						
							<?
							if ($arResult["PAY_SYSTEM"]["NEW_WINDOW"] == "Y")
							{
								?>
								<script language="JavaScript">
									window.open('<?=$arParams["PATH_TO_PAYMENT"]?>?ORDER_ID=<?=urlencode(urlencode($arResult["ORDER"]["ACCOUNT_NUMBER"]))?>');
								</script>
								<?= str_replace("#LINK#", $arParams["PATH_TO_PAYMENT"]."?ORDER_ID=".urlencode(urlencode($arResult["ORDER"]["ACCOUNT_NUMBER"])), GetMessage("STOF_ORDER_PAY_WIN")) ?>
								<?
							}
							else
							{
								if (strlen($arResult["PAY_SYSTEM"]["PATH_TO_ACTION"])>0)
								{
									include($arResult["PAY_SYSTEM"]["PATH_TO_ACTION"]);
								}
							}
							?>

					<?
				}
				?>

			<?
		}
		*/
		?>
	
	<?	} else {  ?>

		<?echo GetMessage("STOF_ERROR_ORDER_CREATE")?>

		<?=str_replace("#ORDER_ID#", $arResult["ORDER_ID"], GetMessage("STOF_NO_ORDER"))?>
		<?=GetMessage("STOF_CONTACT_ADMIN")?>

	<?  }  ?>

	<?/*
		<?= str_replace("#LINK#", $arParams["PATH_TO_PERSONAL"], GetMessage("STOF_ORDER_VIEW")) ?><br /><br />
		<?= str_replace("#LINK#", $arParams["PATH_TO_PERSONAL"], GetMessage("STOF_ANNUL_NOTES")) ?><br /><br />
		<?= str_replace("#ORDER_ID#", $arResult["ORDER_ID"], GetMessage("STOF_ORDER_ID_NOTES")) ?>
	*/?>

</div>