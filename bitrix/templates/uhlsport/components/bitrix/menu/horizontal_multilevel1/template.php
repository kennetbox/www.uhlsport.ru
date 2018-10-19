<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<nav>
	<div id="mobilehome">
		<a href="/">
			<div></div>
		</a>
	</div>
	<div id="menubutton">
		<img src="<?=SITE_TEMPLATE_PATH?>/images/menu.png" title="Menu" alt=""/>
	</div>
	<ul id="menu">
		<li id="home">
			<a href="/">
				<div></div>
			</a>
		</li>
		<?
		$previousLevel = 0;
		foreach($arResult as $itemIdex => $arItem):?>
			<?if ($previousLevel && $arItem["DEPTH_LEVEL"] < $previousLevel):?>
				<?=str_repeat("</ul></li>", ($previousLevel - $arItem["DEPTH_LEVEL"]));?>
			<?endif?>
			
			
			<?if ($arItem["IS_PARENT"]):?>
				<?if ($arItem["DEPTH_LEVEL"] == 1):?>
					<li><a href="#" onclick="javascript:void(0);" class="<?if ($arItem["SELECTED"]):?>selected<?else:?>root-item<?endif?>"><?=$arItem["TEXT"]?></a>
						<ul>
				<?else:?>
					<li<?if ($arItem["SELECTED"]):?> class="item-selected"<?endif?>><a href="<?=$arItem["LINK"]?>" class="parent"><?=$arItem["TEXT"]?></a>
						<ul>
				<?endif?>

			<?else:?>

				<?if ($arItem["PERMISSION"] > "D"):?>

					<?if ($arItem["DEPTH_LEVEL"] == 1):?>
						<li><a href="<?=$arItem["LINK"]?>" class="<?if ($arItem["SELECTED"]):?>selected<?else:?>root-item<?endif?>"><?=$arItem["TEXT"]?></a></li>
					<?else:?>
						<li <?if ($arItem["SELECTED"]):?> class="item-selected"<?endif?>><a <?if($arItem["PARAMS"]["LINEHEIGHT"] == "1"){echo 'style="line-height: 15px;"';}?> href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a></li>
					<?endif?>

				<?else:?>

					<?if ($arItem["DEPTH_LEVEL"] == 1):?>
						<li><a href="" class="<?if ($arItem["SELECTED"]):?>selected<?else:?>root-item<?endif?>" title="<?=GetMessage("MENU_ITEM_ACCESS_DENIED")?>"><?=$arItem["TEXT"]?></a></li>
					<?else:?>
						<li><a href="" class="denied" title="<?=GetMessage("MENU_ITEM_ACCESS_DENIED")?>"><?=$arItem["TEXT"]?></a></li>
					<?endif?>

				<?endif?>

			<?endif?>

			<?$previousLevel = $arItem["DEPTH_LEVEL"];?>
		<?endforeach;?>
	</ul>
</nav>