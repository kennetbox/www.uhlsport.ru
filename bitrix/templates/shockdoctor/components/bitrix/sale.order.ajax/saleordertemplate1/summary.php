<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
$bDefaultColumns = $arResult["GRID"]["DEFAULT_COLUMNS"];
$colspan = ($bDefaultColumns) ? count($arResult["GRID"]["HEADERS"]) : count($arResult["GRID"]["HEADERS"]) - 1;
$bPropsColumn = false;
$bUseDiscount = false;
$bPriceType = false;
$bShowNameWithPicture = ($bDefaultColumns) ? true : false; // flat to show name and picture column in one column
?>

<div class="bx_ordercart">
	
	<h3>
		В корзине
	</h3>
	
	<?foreach ($arResult["GRID"]["ROWS"] as $k => $arData):?>
	
	<div class="item">

		<?
		// prelimenary check for images to count column width
		foreach ($arResult["GRID"]["HEADERS"] as $id => $arColumn)
		{
			$arItem = (isset($arData["columns"][$arColumn["id"]])) ? $arData["columns"] : $arData["data"];
			if (is_array($arItem[$arColumn["id"]]))
			{
				foreach ($arItem[$arColumn["id"]] as $arValues)
				{
					if ($arValues["type"] == "image")
						$imgCount++;
				}
			}
		}

		foreach ($arResult["GRID"]["HEADERS"] as $id => $arColumn):

			$class = ($arColumn["id"] == "PRICE_FORMATED") ? "price" : "";

			if (in_array($arColumn["id"], array("PROPS", "TYPE", "NOTES"))) // some values are not shown in columns in this template
				continue;

			if ($arColumn["id"] == "PREVIEW_PICTURE" && $bShowNameWithPicture)
				continue;

			$arItem = (isset($arData["columns"][$arColumn["id"]])) ? $arData["columns"] : $arData["data"];

			if ($arColumn["id"] == "NAME"):
				$width = 70 - ($imgCount * 20);
			?>

				<small>ID: <span class="digit">#<?=$arItem["ID"]?></span></small>

				<h4 class="bx_ordercart_itemtitle">
					<?if (strlen($arItem["DETAIL_PAGE_URL"]) > 0):?><a href="<?=$arItem["DETAIL_PAGE_URL"] ?>"><?endif;?>
						<?=$arItem["NAME"]?>
					<?if (strlen($arItem["DETAIL_PAGE_URL"]) > 0):?></a><?endif;?>
				</h4>

				<?  if( count($arItem["PROPS"]) > 0 ) { ?>
				<p>
				<?  }  ?>
				<? 	
					$count = count( $arItem["PROPS"] );
					$item = 1;
					foreach( $arItem["PROPS"] as $key => $val) {
				?>
					<?=$val["VALUE"] ?><? if( $item < $count ) { ?>, <? } ?>
				<?
					$item++;
					}
				?>
				<?  if( count($arItem["PROPS"]) > 0 ) { ?>
				</p>
				<?  }  ?>

				<span class="price"><?=$arItem['PRICE_FORMATED'] ?></span>
				
				<span class="times">×</span>
				
				<span class="quantity digit"><?=$arItem['QUANTITY'] ?></span>

			<?
			endif;
			?>
			
		<? endforeach; ?>
		
	</div><!-- [end item] -->
	
	<?endforeach;?>
	
	
	<div class="total">
		<b>
			<?=GetMessage("SOA_TEMPL_SUM_IT")?>:
		</b>
		<span class="price"><?=$arResult["ORDER_TOTAL_PRICE_FORMATED"]?></span>
	</div>
	
	
	<?/* [Комментарии]
	<div class="bx_section">
	
		<h4>
			<?=GetMessage("SOA_TEMPL_SUM_COMMENTS")?>
		</h4>
		
		<div class="bx_block w100">
			<textarea name="ORDER_DESCRIPTION" id="ORDER_DESCRIPTION" style="max-width:100%;min-height:120px"><?=$arResult["USER_VALS"]["ORDER_DESCRIPTION"] ?></textarea>
		</div>
		
		<input type="hidden" name="" value="" />
	
	</div>
	*/?>
	
</div><!-- [end bx_ordercart] -->
