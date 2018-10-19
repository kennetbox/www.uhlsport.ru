<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="container_16">


			<ul class="doubleboxes">
			<?
			foreach ($arResult["ITEMS"] as $arItem){
			?>
				<li style="float: left; list-style: none; position: relative; width: 460px;">
					<div class="doublebox effects">
						<h2><?=$arItem["NAME"]?></h2>
						<div class="sub">
							<img title="<?=$arItem["NAME"]?>" class="middle" src="<?=$arItem["DETAIL_PICTURE"]["SRC"]?>">
						</div>
					</div>
				</li>
			<?
			}
			?>
			</ul>



</div>