<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="container_16">
    <div class="grid_8 prefix_1 postfix_1">
		<div class="notice">
            <div class="notice_top"></div>
            <div class="content">
                <h2><?=$arResult["NAME"]?></h2>
				<div class="info"><label>Страна</label><?=$arResult["PROPERTIES"]["COUNTRY"]["VALUE"]?></div>
				<div class="info"><label>Клуб</label><?=$arResult["PROPERTIES"]["CLUB"]["VALUE"]?></div>
				<div class="info"><label>Лига</label><?=$arResult["PROPERTIES"]["LEAGUE"]["VALUE"]?></div>
				<br>
				<div class="info"><label>Рост</label><?=$arResult["PROPERTIES"]["SIZE"]["VALUE"]?></div>
				<div class="info"><label>Вес</label><?=$arResult["PROPERTIES"]["WEIGHT"]["VALUE"]?></div>
				<div class="info"><label>День рождения</label><?=$arResult["PROPERTIES"]["BIRTHDAY"]["VALUE"]?></div>
                <br>
            </div>
            <div class="notice_bottom"></div>
        </div>
        <br>
		<div>
			<br>
			<br>
			<h3>More information about the sponsorpartner here...</h3>
			<?if($arResult["PROPERTIES"]["WIKI"]["VALUE"] != ""){?><a href="<?=$arResult["PROPERTIES"]["WIKI"]["VALUE"]?>" target="_blank" title="Wikipedia">
				<img src="/images/footer_wikipedia_55x55.png">
			</a><?}?>
			<?if($arResult["PROPERTIES"]["FACEBOOK"]["VALUE"] != ""){?><a href="<?=$arResult["PROPERTIES"]["FACEBOOK"]["VALUE"]?>" target="_blank" title="Facebook">
				<img src="/images/footer_fb_55x55.png">
			</a><?}?>
			<?if($arResult["PROPERTIES"]["TWITTER"]["VALUE"] != ""){?><a href="<?=$arResult["PROPERTIES"]["TWITTER"]["VALUE"]?>" target="_blank" title="Twitter">
				<img src="/images/footer_twitter_55x55.png">
			</a><?}?>
		</div>
        <br>
    </div>
    <div class="grid8 effects">
        <div class="sub">
                <a title="Ahamada, Ali" href="<?=$arResult["DETAIL_PICTURE"]["SRC"]?>" rel="lightbox">
                    <img class="middle" src="<?=MakeImage($arResult["DETAIL_PICTURE"]["SRC"],array('w'=> 340))?>">
                </a>
        </div>
    </div>
</div>