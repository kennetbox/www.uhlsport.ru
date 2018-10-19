<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<h3>Наша компания</h3>
<?if (!empty($arResult)):?>
	<ul>
		<?
		foreach($arResult as $arItem):
			if($arParams["MAX_LEVEL"] == 1 && $arItem["DEPTH_LEVEL"] > 1) 
				continue;
		?>
			<li>
				<a href="<?=$arItem["LINK"]?>" <?if($arItem["SELECTED"]):?>class="selected"<?endif?>>
					<?=$arItem["TEXT"]?>
				</a>
			</li>
		<?endforeach?>
	</ul>
<?endif?>