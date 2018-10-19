<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?foreach ($arResult["ITEMS"] as $arItem){?>
	<a href="<?=$arItem["PROPERTIES"]["LINK"]["VALUE"]?>">
		<img src="<?=$arItem["DETAIL_PICTURE"]["SRC"]?>">
	</a>
<?}?>