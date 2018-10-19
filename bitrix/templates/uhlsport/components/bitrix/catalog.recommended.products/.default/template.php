<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** @var CBitrixComponentTemplate $this */
/** @var array $arParams */
/** @var array $arResult */
/** @global CDatabase $DB */

$this->setFrameMode(true);

?>
<div class="headline"><h2>Вас так же заинтересует…</h2></div>
<ul class="image-grid">
<?
foreach($arResult["ITEMS"] as $key => $arItem){
	$res = CIBlockElement::GetList(array(),array("IBLOCK_ID"=>2,"ID"=>$arItem["ID"]), false, false, array("IBLOCK_ID", "ID","PROPERTY_COLOR","PROPERTY_ARTNUMBER"));
	$arRes = $res->GetNext();
		?>
		<li>
			<a href="<?=$arItem["DETAIL_PAGE_URL"]?>">
				<img alt="product" src="<?=$arItem["DETAIL_PICTURE"]["SRC"]?>" style="width: 160px;">
				<h4><?=$arItem["NAME"]?></h4>
				<div class="articlenumber"><?=$arRes["PROPERTY_ARTNUMBER_VALUE"]?></div>
				<div class="color">
					<?=$arRes["PROPERTY_COLOR_VALUE"];
					while($arColor = $res->GetNext()){
						echo "/".$arColor["PROPERTY_COLOR_VALUE"];
					}
					?>
				</div>
			</a>
		</li>
		<?
}
?>
</ul>
