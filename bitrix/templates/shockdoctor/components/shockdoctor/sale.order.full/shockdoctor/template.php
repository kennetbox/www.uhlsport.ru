<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?
	// Для Гостя - прозрачная регистрация
	$isGuest = (string) htmlspecialchars ( $_REQUEST['ptype'] );
	$currentStep = (int) htmlspecialchars( $_REQUEST['CurrentStep'] );
	if(isset($currentStep) && $currentStep > 0 && $isGuest == 'guest') {
		$arResult["CurrentStep"] = 2;
	}
	
?>

<div class="cart">

	<div class="cart-header">
		<div class="cart-header-contents">
			<h1>
				
				<span class="step current"><?/* Stage: <?=$arResult["CurrentStep"]?> */?>Корзина</span>
				
				<? if($arResult["CurrentStep"] == 1) { ?>
					<span class="step item">Личные данные</span>
				<? } ?>
				
			</h1>
			<h2>
				
				<a href="/">Продолжить покупки</a>
			
			</h2>
		</div>
	</div>

<div class="content">
	<div class="cart-contents">

		<div class="steps">
			
			<?
				$arMenuLine = array(
					0 => "Личные данные", //GetMessage("STOF_PERSON_TYPE_SHORT"),
					1 => GetMessage("STOF_MAKING_SHORT"),
					2 => GetMessage("STOF_DELIVERY_SHORT"),
					3 => GetMessage("STOF_PAYMENT_SHORT"),
					4 => GetMessage("STOF_CONFIRM_SHORT"),
					5 => "",
					6 => GetMessage("STOF_COMPLETE")
				);
			?>
			
			<span>
				<?=$arMenuLine[ $arResult["CurrentStep"] - 1 ]?>
			</span>
			
	<?
	if($arParams["SHOW_MENU"] == "Y") {
		?>

		<? if ( $USER->IsAuthorized() || $isGuest == 'guest' ): ?>
		<? if ( $arResult["CurrentStep"] < 6 ): ?>

			<ul>	
				<?
				
				$arResult["SKIP_THIRD_STEP"] = "Y"; // Скрываем ступень доставки
				
				$arMenuLine = array(
						0 => GetMessage("STOF_PERSON_TYPE"),
						1 => GetMessage("STOF_MAKING"),
						2 => GetMessage("STOF_DELIVERY"),
						3 => GetMessage("STOF_PAYMENT"),
						4 => GetMessage("STOF_CONFIRM")
					);
				$counter = 2;
				for ($i = 0; $i < count($arMenuLine); $i++) {

					if ($i == 0) {
						echo "<li>";
							echo "<span class='digit'>1</span>";
							echo "<div><b>";
								echo "<a href=\"/personal/cart/\" \">";
									echo GetMessage("STOF_BASKET");
								echo "</a>";
							echo "</b></div>";
						echo "</li>";
						continue; // Пропускаем ступень "Тип плательщика"
					}

					//if ($arResult["SKIP_FIRST_STEP"] == "Y" && $i == 0)
						//continue;
					if ($arResult["SKIP_FIRST_STEP"] == "Y" && $i == 0)
						continue;
					if ($arResult["SKIP_SECOND_STEP"] == "Y" && $i == 1)
						continue;
					if ($arResult["SKIP_THIRD_STEP"] == "Y" && $i == 2)
						continue;
					if ($arResult["SKIP_FORTH_STEP"] == "Y" && $i == 3)
						continue;

					
					if ($i > 0)
						echo " &gt; ";

					if (
						($arResult["CurrentStep"] > $i + 1)
							&&
						($arResult["CurrentStep"] != 3)
						) {
						echo "<li>";
							echo "<span class='digit'>".$counter."</span>";
							echo "<div><b>";
								echo "<a href=\"#\" OnClick=\"document.order_form.CurrentStep.value='".($i + 1)."'; document.order_form.BACK.value='Y'; document.order_form.submit();\">";
									echo $arMenuLine[$i];
								echo "</a>";
							echo "</b></div>";
						echo "</li>";
						
					} elseif (
						( $arResult["CurrentStep"] == ($i + 1) )
							|| 
						( $arResult["CurrentStep"] == 3 && $arResult["CurrentStep"] == $i + 2 )
					) {
						
						echo "<li class='active'>";
							echo "<span class='digit'>".$counter."</span>";
							echo "<div><b>";
								echo $arMenuLine[$i];
							echo "</b></div>";
						echo "</li>";
						
					} else {
						
						echo "<li>";
							echo "<span class='digit'>".$counter."</span>";
							echo "<div><b>";
								echo $arMenuLine[$i];
							echo "</b></div>";
						echo "</li>";
						
					}
					$counter++;
				}
				?>
			</ul>
		
		<? endif; ?>
		<? endif; ?>

	<?
	}
	?>

			
		</div>
	
	
<?  if (!$USER->IsAuthorized() && $isGuest != 'guest') {  ?>

	<?
		echo ShowError($arResult["ERROR_MESSAGE"]);	
		include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/auth.php");
	?>

<? } else { ?>


	<? 	if ($arResult["CurrentStep"] < 6):?>
		<form method="post" action="<?= htmlspecialcharsbx($arParams["PATH_TO_ORDER"]) ?>" name="order_form">
			<?=bitrix_sessid_post()?>
	
	<?endif;?>


	<? 
		echo ShowError($arResult["ERROR_MESSAGE"]); 
		if ($arResult["CurrentStep"] == 1)
			include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/step1.php");
		elseif ($arResult["CurrentStep"] == 2)
			include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/step2.php");
		elseif ($arResult["CurrentStep"] == 3)
			include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/step3.php");
		elseif ($arResult["CurrentStep"] == 4)
			include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/step4.php");
		elseif ($arResult["CurrentStep"] == 5)
			include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/step5.php");
		elseif ($arResult["CurrentStep"] >= 6)
			include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/step6.php");
	?>


	<?if ($arResult["CurrentStep"] > 0 && $arResult["CurrentStep"] <= 7):?>
		<input type="hidden" name="ORDER_PRICE" value="<?= $arResult["ORDER_PRICE"] ?>">
		<input type="hidden" name="ORDER_WEIGHT" value="<?= $arResult["ORDER_WEIGHT"] ?>">
		<input type="hidden" name="SKIP_FIRST_STEP" value="<?= $arResult["SKIP_FIRST_STEP"] ?>">
		<input type="hidden" name="SKIP_SECOND_STEP" value="<?= $arResult["SKIP_SECOND_STEP"] ?>">
		<input type="hidden" name="SKIP_THIRD_STEP" value="<?= $arResult["SKIP_THIRD_STEP"] ?>">
		<input type="hidden" name="SKIP_FORTH_STEP" value="<?= $arResult["SKIP_FORTH_STEP"] ?>">
	<?endif?>

	<?if ($arResult["CurrentStep"] > 1 && $arResult["CurrentStep"] <= 6):?>
		<input type="hidden" name="PERSON_TYPE" value="<?= $arResult["PERSON_TYPE"] ?>">
		<input type="hidden" name="BACK" value="">
	<?endif?>

	<?if ($arResult["CurrentStep"] > 2 && $arResult["CurrentStep"] <= 6):?>
		<input type="hidden" name="PROFILE_ID" value="<?= $arResult["PROFILE_ID"] ?>">
		<input type="hidden" name="DELIVERY_LOCATION" value="<?= $arResult["DELIVERY_LOCATION"] ?>">
		<?
		$dbOrderProps = CSaleOrderProps::GetList(
				array("SORT" => "ASC"),
				array("PERSON_TYPE_ID" => $arResult["PERSON_TYPE"], "ACTIVE" => "Y", "UTIL" => "N"),
				false,
				false,
				array("ID", "TYPE", "SORT")
			);
		while ($arOrderProps = $dbOrderProps->Fetch())
		{
			if ($arOrderProps["TYPE"] == "MULTISELECT")
			{
				if (count($arResult["POST"]["ORDER_PROP_".$arOrderProps["ID"]]) > 0)
				{
					for ($i = 0; $i < count($arResult["POST"]["ORDER_PROP_".$arOrderProps["ID"]]); $i++)
					{
						?><input type="hidden" name="ORDER_PROP_<?= $arOrderProps["ID"] ?>[]" value="<?= $arResult["POST"]["ORDER_PROP_".$arOrderProps["ID"]][$i] ?>"><?
					}
				}
				else
				{
					?><input type="hidden" name="ORDER_PROP_<?= $arOrderProps["ID"] ?>[]" value=""><?
				}
			}
			else
			{
				?><input type="hidden" name="ORDER_PROP_<?= $arOrderProps["ID"] ?>" value="<?= $arResult["POST"]["ORDER_PROP_".$arOrderProps["ID"]] ?>"><?
			}
		}
		?>
	<?endif?>

	<?if ($arResult["CurrentStep"] > 3 && $arResult["CurrentStep"] < 6):?>
		<input type="hidden" name="DELIVERY_ID" value="<?= is_array($arResult["DELIVERY_ID"]) ? implode(":", $arResult["DELIVERY_ID"]) : IntVal($arResult["DELIVERY_ID"]) ?>">
	<?endif?>

	<?if ($arResult["CurrentStep"] > 4 && $arResult["CurrentStep"] < 6):?>
		<input type="hidden" name="TAX_EXEMPT" value="<?= $arResult["TAX_EXEMPT"] ?>">
		<input type="hidden" name="PAY_SYSTEM_ID" value="<?= $arResult["PAY_SYSTEM_ID"] ?>">
		<input type="hidden" name="PAY_CURRENT_ACCOUNT" value="<?= $arResult["PAY_CURRENT_ACCOUNT"] ?>">
	<?endif?>

	<?if ($arResult["CurrentStep"] < 6):?>
		<input type="hidden" name="CurrentStep" value="<?= ($arResult["CurrentStep"] + 1) ?>">
	<?endif?>

	<?if ($arResult["CurrentStep"] < 6):?>
		</form>
	<?endif;?>
	
<? } ?>

	</div><!-- [end cart-contents] -->
</div><!-- [end content] -->

</div><!-- [end cart] -->
