<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
?>

<div class="feature_gloves">
	<div class="container_16">
		<div class="grid_12">
			<ul id="productlist" class="image-grid image-grid-left" style=" width: 1000px;">
			<?$t = 1;?>
			<?foreach($arResult["ITEMS"] as $arItem){
			if($arItem["PROPERTIES"]["SALELEADER"]["VALUE"] == "Y" && $t <= 5){
			$t++;
			?>
				<li>
                    <a href="<?=$arItem["DETAIL_PAGE_URL"]?>">
						<img style="height: 160px;" class="pthumb lazy" src="<?=$arItem["DETAIL_PICTURE"]["SRC"]?>">
                        <h4><?=$arItem["NAME"]?></h4>                        
                        <div class="color"><?=$arItem["PROPERTIES"]["COLOR"]["VALUE"]?></div>
                        <span class="price"><?=$arItem["PRICES"]["BASE"]["PRINT_VALUE_NOVAT"]?></span>
						<?if($arItem["PROPERTIES"]["NEWPRODUCT"]["VALUE_ENUM_ID"] == "1"){?><span class="new"></span><?}?>
                    </a>
                </li>
			<?}}?>
			</ul>
		</div>
	</div>
</div>
<div style="clear:both;"></div>