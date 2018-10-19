<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
$countryId = getIdByCode($_REQUEST["CODE"], 5, IBLOCK_ELEMENT);
$res = CIBlockElement::GetByID($countryId);
if($ar_res = $res->GetNext())
 $APPLICATION->SetTitle("Дилеры / ".$ar_res['NAME']);
?>
<div class="container_16">
	<div class="grid16" style="margin-bottom:20px;">
        <br><br>
    </div>
	<div class="clear"></div>
	<div class="grid16">
		<table class="list">
			<tbody>
				<tr>
					<th class="alpha"><span>Название</span></th>
					<th><span>Адрес</span></th>
					<th style="width:200px;"><span>Контакты</span></th>
					<th class="omaga"><span>Сайт</span></th>
				</tr>
		<?foreach($arResult["ITEMS"] as $arItem):?>
			<?
			$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
			$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
			if($arItem["PROPERTIES"]["COUNTRY"]["VALUE"] == $countryId){
			?>
			<tr id="<?=$this->GetEditAreaId($arItem['ID']);?>">
				<td class="alpha">
					<h2 style="margin:0"><?=$arItem["NAME"]?></h2>
					<?if($arItem["PROPERTIES"]["DESCRIPTION"]["VALUE"] != ""){?><strong><?=$arItem["PROPERTIES"]["DESCRIPTION"]["VALUE"]?></strong><br><?}?>
					<?if($arItem["PROPERTIES"]["DESCRIPTION"]["VALUE"] != ""){echo $arItem["PROPERTIES"]["DESCRIPTION2"]["VALUE"];}?>
				</td>
				<td>
					<?if($arItem["PROPERTIES"]["ADDRESS"]["VALUE"] != ""){echo $arItem["PROPERTIES"]["ADDRESS"]["VALUE"]."<br>";}?>
					<?if($arItem["PROPERTIES"]["INDEX"]["VALUE"] != ""){echo $arItem["PROPERTIES"]["INDEX"]["VALUE"];}?>
				</td>
				<td>
					<?if($arItem["PROPERTIES"]["PHONE"]["VALUE"] != ""){?><label>Телефон</label><?=$arItem["PROPERTIES"]["PHONE"]["VALUE"];}?>
					<?if($arItem["PROPERTIES"]["FAX"]["VALUE"] != ""){?><label>Факс</label><?=$arItem["PROPERTIES"]["FAX"]["VALUE"];}?>
					<?if($arItem["PROPERTIES"]["EMAIL"]["VALUE"] != ""){?><br><label>E-mail</label><a href="mailto:<?=$arItem["PROPERTIES"]["EMAIL"]["VALUE"];}?>" class="extern" title="Click to open email-app" target="_blank">Click</a>
				</td>
				<td class="omega">
					<?if($arItem["PROPERTIES"]["SITE"]["VALUE"] != ""){?><a class="extern" title="Extern Link" href="http://www.<?=$arItem["PROPERTIES"]["SITE"]["VALUE"]?>" target="_blank"><?=$arItem["PROPERTIES"]["SITE"]["VALUE"]?></a><?}?>
				</td>
			</tr>
		<?	}
		endforeach;?>
			</tbody>
		</table>
	</div>
</div>