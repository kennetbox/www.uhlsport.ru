<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** @var CBitrixComponentTemplate $this */
/** @var array $arParams */
/** @var array $arResult */
/** @global CDatabase $DB */

$this->setFrameMode(true);

?>

<?
$countElement = count($arItem);
if($countElement > 0) {
?>
	
	<div class="modules">
			<div class="top-products-header grouped-products-header">
					<p class="top-products-heading">
						Вам может понравиться:
					</p>
			</div>
			<div style="min-height: 205px; margin-left: 0px;" class="top-products-groups grouped-products-groups">
					<div id="top_products_1" class="top-products-group">

						<?
						foreach($arResult["ITEMS"] as $key => $arItem){
							$res = CIBlockElement::GetList(array(),array("IBLOCK_ID"=>2,"ID"=>322), false, false, array("IBLOCK_ID", "ID","PROPERTY_COLOR","PROPERTY_ARTNUMBER"));
							$arRes = $res->GetNext();
								?>
								<div class="top-product grouped-product">
										<a title="<?=$arItem["NAME"]?>" href="<?=$arItem["DETAIL_PAGE_URL"]?>">
												<img src="<?=$arItem["DETAIL_PICTURE"]["SRC"]?>" width="190" alt="<?=$arItem["NAME"]?>" /> <? /*height="145"*/ ?> 
												<h3 class="product-name"><?=$arItem["NAME"]?></h3>
												<h4><span class="price"><?=$arItem["PRICE"]?> руб.</span></h4>
												<? /*	
												<div class="articlenumber"><?=$arRes["PROPERTY_ARTNUMBER_VALUE"]?></div>
												<div class="color">
													<?=$arRes["PROPERTY_COLOR_VALUE"];
													while($arColor = $res->GetNext()){
														echo "/".$arColor["PROPERTY_COLOR_VALUE"];
													}
													?>
												</div>
												*/ ?>
										</a>
								</div>
								<?
						}
						?>

					</div>
			</div> <!-- end top-products-groups -->
	</div>

<?
	}
?>



