<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="container_16">
	<div class="grid16">
		<table class="list sortable">
			<thead>
                <tr>
                    <th class="alpha sorting-asc" data-sort="string">
                        <span>Имя</span>
                    </th>
                        <th class="nomobile" data-sort="string">
                            <span>Клуб</span>
                        </th>
                        <th class="nomobile" data-sort="string">
                            <span>Лига</span>
                        </th>
                        <th class="omega" data-sort="string">
                            <span>Страна</span>
                        </th>
                </tr>
            </thead>
			<tbody>
			<?foreach ($arResult["ITEMS"] as $arItem){?>
				<tr>
					<td class="alpha sorting-asc">
					<?if($arItem["DETAIL_PICTURE"] != "" || $arItem["PROPERTIES"]["SIZE"]["VALUE"] != "" || $arItem["PROPERTIES"]["WEIGHT"]["VALUE"] != "" || $arItem["PROPERTIES"]["BIRTHDAY"]["VALUE"] != "" || $arItem["PROPERTIES"]["WIKI"]["VALUE"] != "" || $arItem["PROPERTIES"]["FACEBOOK"]["VALUE"] != "" || $arItem["PROPERTIES"]["TWITTER"]["VALUE"] != ""){?>
						<a href="<?=$arItem["DETAIL_PAGE_URL"]?>"><?=$arItem["NAME"]?></a>
					<?}else{echo $arItem["NAME"];}?>
					</td>
					<td class="nomobile"><?=$arItem["PROPERTIES"]["CLUB"]["VALUE"]?></td>
					<td class="nomobile"><?=$arItem["PROPERTIES"]["LEAGUE"]["VALUE"]?></td>
					<td class="nomobile"><?=$arItem["PROPERTIES"]["COUNTRY"]["VALUE"]?></td>
				</tr>
			<?}?>
			</tbody>
		</table>
	</div>
</div>