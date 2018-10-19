<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/*
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
*/
?>

<div id="top-cart-container">
	<!--{CART_SIDEBAR_a8f425f238218db362da452140399803}-->
	<div class="top-cart">
		
		<div id="topCartContent" class="block-content" style="display:none">
			<div class="inner-wrapper">
				
				<div class="arrow"></div>
				
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

					<?
						include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/basket_items.php");
						//include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/basket_items_delayed.php");
						//include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/basket_items_subscribed.php");
						//include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/basket_items_not_available.php");
					?>

				
				<?
			}
			else
			{
				ShowError($arResult["ERROR_MESSAGE"]);
			}
			?>
			
			</div>
		</div>

		<script type="text/javascript">
			Enterprise.TopCart.initialize('topCartContent', 'cartHeader', '/');
			// Below can be used to show minicart after item added
			// Enterprise.TopCart.showCart(7);
		</script>
		
	</div>
</div>

