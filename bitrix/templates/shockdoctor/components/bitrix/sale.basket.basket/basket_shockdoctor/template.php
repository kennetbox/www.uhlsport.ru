<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$arUrls = Array(
	"delete" => $APPLICATION->GetCurPage()."?".$arParams["ACTION_VARIABLE"]."=delete&id=#ID#",
	"delay" => $APPLICATION->GetCurPage()."?".$arParams["ACTION_VARIABLE"]."=delay&id=#ID#",
	"add" => $APPLICATION->GetCurPage()."?".$arParams["ACTION_VARIABLE"]."=add&id=#ID#",
);

$arBasketJSParams = array(
	'SALE_DELETE' => GetMessage("SALE_DELETE"),
	'SALE_DELAY' => GetMessage("SALE_DELAY"),
	'SALE_TYPE' => GetMessage("SALE_TYPE"),
	'TEMPLATE_FOLDER' => $templateFolder,
	'DELETE_URL' => $arUrls["delete"],
	'DELAY_URL' => $arUrls["delay"],
	'ADD_URL' => $arUrls["add"]
);
?>


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
		<div class="steps">
			<span>Корзина заказа</span>

			<ul>
				<li class="active">
					<span class="digit">1</span>
					<div><b>Корзина</b></div>
				</li>
				<li>
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
		<script type="text/javascript">
			var basketJSParams = <?=CUtil::PhpToJSObject($arBasketJSParams);?>
		</script>

		<?
		$APPLICATION->AddHeadScript($templateFolder."/script.js");

		if (strlen($arResult["ERROR_MESSAGE"]) <= 0)
		{
			?>
			
			<div id="warning_message">
				<?
				if (is_array($arResult["WARNING_MESSAGE"]) && !empty($arResult["WARNING_MESSAGE"]))
				{
					foreach ($arResult["WARNING_MESSAGE"] as $v)
						echo ShowError($v);
				}
				?>
			</div>
			
			<?

			$normalCount = count($arResult["ITEMS"]["AnDelCanBuy"]);
			$normalHidden = ($normalCount == 0) ? "style=\"display:none\"" : "";

			$delayCount = count($arResult["ITEMS"]["DelDelCanBuy"]);
			$delayHidden = ($delayCount == 0) ? "style=\"display:none\"" : "";

			$subscribeCount = count($arResult["ITEMS"]["ProdSubscribe"]);
			$subscribeHidden = ($subscribeCount == 0) ? "style=\"display:none\"" : "";

			$naCount = count($arResult["ITEMS"]["nAnCanBuy"]);
			$naHidden = ($naCount == 0) ? "style=\"display:none\"" : "";

			?>
			
				<form method="post" action="<?=POST_FORM_ACTION_URI?>" name="basket_form" id="basket_form">
				<fieldset>
					<div id="basket_form_container">
						<div class="bx_ordercart">
							<?/*
							<div class="bx_sort_container">
								
								<span>
									<?=GetMessage("SALE_ITEMS")?>
								</span>
								<a href="javascript:void(0)" id="basket_toolbar_button" class="current" onclick="showBasketItemsList()"><?=GetMessage("SALE_BASKET_ITEMS")?><div id="normal_count" class="flat" style="display:none">&nbsp;(<?=$normalCount?>)</div></a>
								<a href="javascript:void(0)" id="basket_toolbar_button_delayed" onclick="showBasketItemsList(2)" <?=$delayHidden?>><?=GetMessage("SALE_BASKET_ITEMS_DELAYED")?><div id="delay_count" class="flat">&nbsp;(<?=$delayCount?>)</div></a>
								<a href="javascript:void(0)" id="basket_toolbar_button_subscribed" onclick="showBasketItemsList(3)" <?=$subscribeHidden?>><?=GetMessage("SALE_BASKET_ITEMS_SUBSCRIBED")?><div id="subscribe_count" class="flat">&nbsp;(<?=$subscribeCount?>)</div></a>
								<a href="javascript:void(0)" id="basket_toolbar_button_not_available" onclick="showBasketItemsList(4)" <?=$naHidden?>><?=GetMessage("SALE_BASKET_ITEMS_NOT_AVAILABLE")?><div id="not_available_count" class="flat">&nbsp;(<?=$naCount?>)</div></a>
							</div>
							*/?>
							<?
								include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/basket_items.php");
								include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/basket_items_delayed.php");
								include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/basket_items_subscribed.php");
								include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/basket_items_not_available.php");
							?>
							<!--<div style="margin-right: 250px; font-size: 1.2em; padding: 5px 0px 0px;">
								<p>
									<strong>ВНИМАНИЕ!</strong>
									<br />
									На данном сайте представлен весь ассортимент продукции Shock Doctor и рекомендованные цены в ознакомительных целях.
									<br />
									Наличие всего заказываемого Вами товара у партнеров компании в России не гарантируется!
									<br />
									В случае наличия товара мы будем рады Вам его предоставить. Надеемся на Ваше понимание.
								</p>
							</div>-->
						</div>
					</div>
										
					<input type="hidden" name="BasketOrder" value="BasketOrder" />
					<!-- <input type="hidden" name="ajax_post" id="ajax_post" value="Y"> -->
				</fieldset>
				</form>
			
			<?
		}
		else
		{
		?>
		<div class="warning_message">
			<?	ShowError($arResult["ERROR_MESSAGE"]); ?>
		</div>
		<?
		}
		?>

	</div><!-- [end cart-contents] -->
</div><!-- [end content] -->

