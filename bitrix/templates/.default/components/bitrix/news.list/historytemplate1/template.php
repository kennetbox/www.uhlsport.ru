<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div id="timeline">
	<ul id="dates">
		<?
		$t = 748;
		foreach($arResult["ITEMS"] as $arYear){?>
		<li><a href="#entry_<?=$t?>"><?=$arYear["NAME"]?></a></li>
		<?
		$t++;
		}?>
	</ul>
	<ul id="issues">
		<?
		$tt = 748;
		foreach($arResult["ITEMS"] as $arItem){?>
		<li id="entry_<?=$tt?>">
			<div class="container_16 OneLeft">
				<div class="gallery prefix_1 grid_6 suffix_2 effects">
					<?if($arItem["DETAIL_PICTURE"]["SRC"] != ""){?><img title="<?=$arItem["NAME"]?>" class="middle" src="<?=MakeImage($arItem["DETAIL_PICTURE"]["SRC"], array('w'=>340, 'h'=> 250))?>"><?}?>
				</div>
				<div class="grid_6 suffix_1 text">
					<h2><?=$arItem["NAME"]?></h2>
					<p><?=$arItem["PREVIEW_TEXT"]?></p>
				</div>
			</div>
		</li>
		<?
		$tt++;
		}?>
	</ul>
	<div id="grad_left"></div>
	<div id="grad_right"></div>
	<a href="#" id="next">+</a>
	<a href="#" id="prev">-</a>
</div>
<script src="/js/jquery.timelinr-0.9.53.js"></script>
<script>
$(function () {
	$().timelinr({
		arrowKeys: 'true',
		issuesTransparency:0.0
	})
});
</script>
