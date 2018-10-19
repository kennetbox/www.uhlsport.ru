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

<? $arCurDir = explode("/", $APPLICATION->GetCurDir()); ?>


<div class="feature_gloves">
	<div class="container_16">
		<div class="grid_16">
			<ul id="productlist-in" class="image-grid image-grid-left">
			
<? if(count($arResult["ITEMS"]) > 0): ?>			
			<?$t = 0;?>
			<?foreach($arResult["ITEMS"] as $arItem){
			$t++;
			
			echo "<pre style='display: none;'>";
				print_r( $arItem["PROPERTIES"] );
			echo "</pre>";
			
			?>
				<li data-new="<?if($arItem["PROPERTIES"]["NEWPRODUCT"]["VALUE_ENUM_ID"] == "1"){echo "0";}else{echo "1";}?>" data-id="<?=$arItem["PROPERTIES"]["ARTNUMBER"]["VALUE"]?>" data-color="<?=$arItem["PROPERTIES"]["MAIN_COLOR2"]["VALUE"]?>" data-sort="<?=$t?>" data-prop="<?if($arCurDir[2]=="vratarskie_perchatki"){?>gk,finder_gk,goalkeeper<?}?><?foreach($arItem["PROPERTIES"]["FOAM"]["VALUE"] as $arPr){echo ",".$arPr;}?><?foreach($arItem["PROPERTIES"]["CUT"]["VALUE"] as $arPr){echo ",".$arPr;}?><?foreach($arItem["PROPERTIES"]["FINGER_PROTECTION"]["VALUE"] as $arPr){echo ",".$arPr;}?><?if($arItem["PROPERTIES"]["KID_SIZE"]["VALUE"] == "Y"){echo ",kid";}?>">
                    <a href="<?=$arItem["DETAIL_PAGE_URL"]?>">
						<img style="height: 160px;" class="pthumb lazy" src="<?=$arItem["DETAIL_PICTURE"]["SRC"]?>">
                        <h4><?=$arItem["NAME"]?></h4>                        
                        <div class="color"><?=$arItem["PROPERTIES"]["COLOR"]["VALUE"]?></div>
                        <span class="price"><?=$arItem["PRICES"]["BASE"]["PRINT_VALUE_NOVAT"]?></span>
						<?if($arItem["PROPERTIES"]["NEWPRODUCT"]["VALUE_ENUM_ID"] == "1"){?><span class="new"></span><?}?>
                    </a>
                </li>
			<?}?>
<? endif; ?>
			
<?/* [Закрывается в файле \bitrix\templates\uhlsport\components\bitrix\catalog.section\catalog.section.after\template.php]
			</ul>
		</div>
	</div>
</div>
*/?>

