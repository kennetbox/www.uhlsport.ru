<tbody>
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

$templateData = array(
	'TEMPLATE_THEME' => $this->GetFolder().'/themes/'.$arParams['TEMPLATE_THEME'].'/style.css',
	'TEMPLATE_CLASS' => 'bx_'.$arParams['TEMPLATE_THEME']
);

$strMainID = $this->GetEditAreaId($arResult['ID']);
$arItemIDs = array(
	'ID' => $strMainID,
	'PICT' => $strMainID.'_pict',
	'DISCOUNT_PICT_ID' => $strMainID.'_dsc_pict',
	'STICKER_ID' => $strMainID.'_sticker',
	'BIG_SLIDER_ID' => $strMainID.'_big_slider',
	'BIG_IMG_CONT_ID' => $strMainID.'_bigimg_cont',
	'SLIDER_CONT_ID' => $strMainID.'_slider_cont',
	'SLIDER_LIST' => $strMainID.'_slider_list',
	'SLIDER_LEFT' => $strMainID.'_slider_left',
	'SLIDER_RIGHT' => $strMainID.'_slider_right',
	'OLD_PRICE' => $strMainID.'_old_price',
	'PRICE' => $strMainID.'_price',
	'DISCOUNT_PRICE' => $strMainID.'_price_discount',
	'SLIDER_CONT_OF_ID' => $strMainID.'_slider_cont_',
	'SLIDER_LIST_OF_ID' => $strMainID.'_slider_list_',
	'SLIDER_LEFT_OF_ID' => $strMainID.'_slider_left_',
	'SLIDER_RIGHT_OF_ID' => $strMainID.'_slider_right_',
	'QUANTITY' => $strMainID.'_quantity',
	'QUANTITY_DOWN' => $strMainID.'_quant_down',
	'QUANTITY_UP' => $strMainID.'_quant_up',
	'QUANTITY_MEASURE' => $strMainID.'_quant_measure',
	'QUANTITY_LIMIT' => $strMainID.'_quant_limit',
	'BUY_LINK' => $strMainID.'_buy_link',
	'ADD_BASKET_LINK' => $strMainID.'_add_basket_link',
	'COMPARE_LINK' => $strMainID.'_compare_link',
	'PROP' => $strMainID.'_prop_',
	'PROP_DIV' => $strMainID.'_skudiv',
	'DISPLAY_PROP_DIV' => $strMainID.'_sku_prop',
	'OFFER_GROUP' => $strMainID.'_set_group_',
	'BASKET_PROP_DIV' => $strMainID.'_basket_prop',
);
$strObName = 'ob'.preg_replace("/[^a-zA-Z0-9_]/", "x", $strMainID);
$templateData['JS_OBJ'] = $strObName;

$strTitle = (
	isset($arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_TITLE"]) && '' != $arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_TITLE"]
	? $arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_TITLE"]
	: $arResult['NAME']
);
$strAlt = (
	isset($arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_ALT"]) && '' != $arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_ALT"]
	? $arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_ALT"]
	: $arResult['NAME']
);
?>
<div class="product" id="<? echo $arItemIDs['ID']; ?>">
	<h1><?=$arResult["NAME"]?></h1>
	<h2>Артикул <?=$arResult["PROPERTIES"]["ARTNUMBER"]["VALUE"]?></h2>
	<div class="container_16">
		<div class="grid_9">
			<div class="grid_6 alpha">
				<div class="mainimage">
					<div class="mobileonly">
						<div id="prev"></div>
						<div id="next"></div>
					</div>
					<?if($arResult["PROPERTIES"]["NEWPRODUCT"]["VALUE_ENUM_ID"] == "1"){
						?><span class="new"></span><?
					}
					reset($arResult['MORE_PHOTO']);
					$arFirstPhoto = current($arResult['MORE_PHOTO']);
					?>
					<a id="zoom1" href="<? echo $arFirstPhoto['SRC']; ?>" class="jqzoom" rel="main" style="outline-style: none; text-decoration: none;">
						<img itemprop="image" alt="" id="mainview" src="<?=MakeImage($arFirstPhoto['SRC'], array('w'=>336, 'h'=>336)) ?>">
						<img id="<? echo $arItemIDs['PICT']; ?>" src="<?=MakeImage($arFirstPhoto['SRC'], array('w'=>336, 'h'=>336)) ?>" style="display:none;">
					</a>
				</div>
			</div>
			<div class="grid_2 suffix_1 omega" id="views">
                    <ul class="">
                        <!-- different views -->
						<?foreach ($arResult['MORE_PHOTO'] as &$arOnePhoto){?>
                            <li>
                                <div class="view" title="">
                                    <a href="javascript:void(0);" rel="{gallery: 'main', smallimage: '<?=MakeImage($arOnePhoto['SRC'], array('w'=>336, 'h'=>336))?>',largeimage: '<? echo $arOnePhoto['SRC']; ?>'}">
                                        <img src="<?=MakeImage($arOnePhoto['SRC'], array('w'=>96, 'h'=>96)) ?>">
                                    </a>
                                </div>
                            </li>
						<?}?>
                    </ul>
                &nbsp;
            </div>
			<div class="clear"></div>
			<?
			if($arResult["PROPERTIES"]["FOAM"]["VALUE"] != "" || $arResult["PROPERTIES"]["CUT"]["VALUE"] != "" || $arResult["PROPERTIES"]["FINGER_PROTECTION"]["VALUE"] != "" || $arResult["PROPERTIES"]["PROP_BALL"]["VALUE"] != "" || $arResult["PROPERTIES"]["KID_SIZE"]["VALUE"] == "Y"){
			?>
			<div class="grid_8 suffix_1 alpha omega">
                <ul class="icons">
					<?
					foreach($arResult["PROPERTIES"]["FOAM"]["VALUE"] as $arFoam){
						?>
						<li>
						<?
						if($arFoam == "absolutgrip"){$span = "Absolutgrip"; $tit = "For dry and wet weather";}
						if($arFoam == "absolutgripplus"){$span = "Absolutgrip+"; $tit = "For dry and wet weather";}
						if($arFoam == "aquasoft"){$span = "Aquasoft"; $tit = "For wet weather";}
						if($arFoam == "supersoftplus"){$span = "Supersoft +"; $tit = "For pitches";}
						if($arFoam == "supersoft"){$span = "Supersoft"; $tit = "For pitches";}
						if($arFoam == "soft"){$span = "Soft"; $tit = "For pitches";}
						if($arFoam == "startersoft"){$span = "Starter Soft"; $tit = "For pitches";}
						if($arFoam == "starterstripe"){$span = "Starter Stripe"; $tit = "For artificial grass and hard courts";}
						if($arFoam == "softgraphit"){$span = "Soft Graphit"; $tit = "For artificial grass and hard courts";}
						if($arFoam == "startergraphit"){$span = "Starter Graphit"; $tit = "For artificial grass and hard courts";}
						if($arFoam == "supergraphit"){$span = "Super Graphit"; $tit = "For artificial grass and hard courts";}
					
						if($arFoam == "supergrip"){$span = "Supergrip"; $tit = "Orange The Colour for ultrastrong grip. High-grip performance. New foam technology plus ‚high-grip‘ elements.Advantages: the foam has an ultra strong grip with optimum durability.";}
						if($arFoam == "fluo_gruen"){$span = "FLUO gruen"; $tit = "FLUO gruen";}

					
						if($arFoam == "fluo_gelb"){$span = "FLUO gelb"; $tit = "FLUO gelb";}
						if($arFoam == "kid"){$span = "Kid sizes"; $tit = "Kid sizes";}
						?>
							<img rel="tooltip" title="<?=$tit?>" src="/images/prop/<?=$arFoam?>.png" id="typeicon_<?=$arFoam?>">
							<span><?=$span?></span>
						</li>
						<?
					}
					foreach($arResult["PROPERTIES"]["CUT"]["VALUE"] as $arCut){
						if($arCut == "artificial_grass"){$tit = "Artificial grass"; $span = "For artificial grass";}
						if($arCut == "klassischer_schnitt"){$tit = ""; $span = "Classic Cut";}
						if($arCut == "weiter_schnitt"){$tit = ""; $span = "Wide Cut";}
						if($arCut == "halfnegative"){$tit = ""; $span = "Close Cut";}
						if($arCut == "fingersurround"){$span = "Fingersurround"; $tit = "Fingersurround";}
						
						if($arCut == "rollfinger"){$tit = "Seemless all-round grip for perfect ball control"; $span = "Rollfinger";}
						if($arCut == "absolutroll"){$tit = "Seemless all-round grip for perfect ball control"; $span = "Cut";}
						?>
						<li>
							<img rel="tooltip" title="<?=$tit?>" src="/images/prop/<?=$arCut?>.png" id="typeicon_<?=$arCut?>">
							<span><?=$span?></span>
						</li>
						<?
					}
					foreach($arResult["PROPERTIES"]["FINGER_PROTECTION"]["VALUE"] as $arFing){
						if($arFing == "bionikframe_x-change_mit_thumbframe"){$span = "Bionik X-Change"; $tit ="Slight stabilisation with additional thumb protection and interchangeable stabilisation element";}
						if($arFing == "bionikframeplus_mit_thumbframe"){$span = "Bionikframe +"; $tit ="Slight stabilisation with additional thumb protection";}
						if($arFing == "bionikframe"){$span = "Bionikframe"; $tit ="Slight stabilisation";}
						if($arFing == "supportframe"){$span = "Supportframe"; $tit ="Stabilisation for entry level and children's models";}
						if($arFing == "handbett"){$span = "Stabilization"; $tit ="For perfect fit, finger stabilisation and climate control";}
						if($arFing == "schockzone"){$span = "Schockzone"; $tit ="For additional shock absorption and wear resistance at the side of the hand";}
						if($arFing == "360_wrap"){$span = "360° wrap"; $tit ="Classic cut with new 360° wrap grants a maximized catching area and perfect fitting";}
						if($arFing == "shockzone3d"){$span = "Shockzone 3D"; $tit = "Shockzone 3D";}	
						if($arFing == "without"){$span = "Without"; $tit ="";}
						?>
						<li>
							<?if($arFing != "without"){?>
							<img rel="tooltip" title="<?=$tit?>" src="/images/prop/<?=$arFing?>.png" id="typeicon_<?=$arFing?>">
							<?}?>
							<span><?=$span?></span>
						</li>
						<?
					}foreach($arResult["PROPERTIES"]["PROP_BALL"]["VALUE"] as $arFing){
						if($arFing == "standard"){$span = "Standard"; $tit ="Standard ball with 32 panels";}
						if($arFing == "fluo"){$span = "FLUO"; $tit ="";}
						if($arFing == "fifa_approved"){$span = "FIFA Approved"; $tit ="";}
						if($arFing == "ball_bladder"){$span = "Ball bladder"; $tit ="Natural rubber ensures almost no loss of pressure";}
						if($arFing == "fluo_green"){$span = "FLUO"; $tit ="";}
						if($arFing == "construction"){$span = "Construction"; $tit ="Optimal abrasion resistance and flight stability";}
						?>
						<li>
							<?if($arFing != "without"){?>
							<img rel="tooltip" title="<?=$tit?>" src="/images/prop/<?=$arFing?>.png" id="typeicon_<?=$arFing?>">
							<?}?>
							<span><?=$span?></span>
						</li>
						<?
					}
					?>
					<?
					if($arResult["PROPERTIES"]["KID_SIZE"]["VALUE"] == "Y"){
					?>
						<li>
							<img rel="tooltip" title="<?=$tit?>" src="/images/prop/kid_sizes.png">
							<span>Kid sizes</span>
						</li>
					<?
					}
					?>
				</ul>
				<div class="clear" style="height:30px;"></div>
            </div>
			<?}?>
		</div>
		<div class="grid_7">
            <h3>Описание</h3>
            <div class="desciption">
                <?echo ('html' == $arResult['PREVIEW_TEXT_TYPE'] ? $arResult['PREVIEW_TEXT'] : '<p>'.$arResult['PREVIEW_TEXT'].'</p>');?>
            </div>
			
			<?
				$stockInGermany = 76; // ID раздела "Склад в Германии"
				$removeElms = 0;
				$ELEMENT_ID = $arResult["ID"];
				$canBuy;
				
				if(CModule::IncludeModule('iblock')) {
					
					$groupIDs = CIBlockElement::GetElementGroups($ELEMENT_ID, true, array("ID"));
					$groupIDArray = [];
					while($groupID = $groupIDs->Fetch()) {
						// $ar_new_groups[] = $groupID["ID"];
						$groupIDArray[] = $groupID["ID"];
					}
					$canBuy = !in_array($stockInGermany, $groupIDArray);
					/*
					if(!in_array($stockInGermany, $groupIDArray)) {
						
						echo "<pre style='display: none;'>";
							echo "DDD";
						echo "</pre>";
						
						//echo $stockInGermany." OK<br />";
						//print_r( $groupIDArray );
						
						//CSaleBasket::Delete($ELEMENT_ID);
						//$removeElms += 1;
					}
					*/
				}
			?>
			
            <h3 style="margin-top:20px;">Размер</h3>
			
			<div class="info <?if ($canBuy):?><? else: ?>left<? endif; ?>">
				<div class="sizeprice clearfix">
					<?
					$boolDiscountShow = (0 < $arResult['MIN_PRICE']['DISCOUNT_DIFF']);
					?>

					<div class="size <?if ($canBuy):?>pull-left<? else: ?>clearfix<? endif; ?>">
						<?
						if($arResult["PROPERTIES"]["SIZE_SH"]["VALUE"] != ""){
							$t = 1;
							foreach ($arResult["PROPERTIES"]["SIZE_SH"]["VALUE"] as $arSize){
								if($t==1){
									echo $arSize;
								}else{
									echo ", ".$arSize;
								}
								$t++;
							}
						}
						if($arResult["PROPERTIES"]["SIZE_CL"]["VALUE"] != ""){
							$t = 1;
							foreach ($arResult["PROPERTIES"]["SIZE_CL"]["VALUE"] as $arSize){
								if($t==1){
									echo $arSize;
								}else{
									echo ", ".$arSize;
								}
								$t++;
							}
						}
						?>
					</div>
<? if($arResult['MIN_PRICE']['PRINT_DISCOUNT_VALUE'] != 1){?>
						<span class="price price_en_us itemprop <?if ($canBuy):?>pull-right<? else: ?>pull-left<? endif; ?>" id="<? echo $arItemIDs['PRICE']; ?>">
							
							<? echo $arResult['MIN_PRICE']['PRINT_DISCOUNT_VALUE']; ?>*
							
						</span>
					
				</div>
				<div class="clearfix">
					<p class="comment <?if ($canBuy):?>pull-right<? else: ?>pull-left<? endif; ?>">
						* рекомендованная розничная цена
					</p>
				</div>
<?}?>				
				<? 
					/*
					echo "<pre style='display: none;'>";
						print_r( $arResult );
					echo "</pre>";
					*/
				?>
				
				<input id="<? echo $arItemIDs['QUANTITY']; ?>" type="hidden" class="tac transparent_input" value="1">
				<div class="<?if ($canBuy):?>text-right<? else: ?>text-left<? endif; ?> clearfix">
					<?if ($canBuy):?>
						
						<? 	// Заказать из Германии, если принадлежит разделу с ID = 76
							if(!in_array($stockInGermany, $groupIDArray)) {
						?>
							
							<a class="btn btn__buy-link" href="javascript:void(0);" id="<? echo $arItemIDs['BUY_LINK']; ?>">
								Заказать<?/*<img src="/images/prop/buynowshopatron.gif">*/?>
							</a>
							
						<? } else { ?>
							

							<a class="btn btn__buy-link" href="javascript:void(0);" id="<? echo $arItemIDs['BUY_LINK']; ?>">
								Заказать со склада в Германии
							</a>
							
							<div class="delivery">
								
								<h3 class="delivery__title">
									Условия доставки
								</h3>
								
								<p class="delivery__item">
									&mdash; 100% предоплата
								</p>
								<? if($arResult["PROPERTIES"]["GERMANY_DAYS"]["VALUE"] != ""): ?>
									<p class="delivery__item">
										&mdash; доставка от <?=$arResult["PROPERTIES"]["GERMANY_DAYS"]["VALUE"]?> дней;
									</p>
								<? endif; ?>
								<? if($arResult["PROPERTIES"]["GERMANY_PRICE"]["VALUE"] != ""): ?>
									<p class="delivery__item">
										&mdash; стоимость доствки от <?=$arResult["PROPERTIES"]["GERMANY_PRICE"]["VALUE"]?> рублей;
									</p>
								<? endif; ?>
								<? if($arResult["PROPERTIES"]["GERMANY_ADD"]["VALUE"] != ""): ?>
									<p class="delivery__item">
										&mdash; <?=$arResult["PROPERTIES"]["GERMANY_ADD"]["VALUE"]?>
									</p>
								<? endif; ?>
							</div>
							
						<? } ?>
						
					<?else:?>
						
						<? 	// Заказать из Германии, если принадлежит разделу с ID = 76
							if(!in_array($stockInGermany, $groupIDArray)) {
						?>
							
							<p>
								<b>
									Нет в наличии
								</b>
							</p>
							
						<? } else { ?>
							
							<a class="btn btn__buy-link" href="javascript:void(0);" id="<? echo $arItemIDs['BUY_LINK']; ?>">
								Заказать со склада в Германии
							</a>
							
							<div class="delivery">
								
								<h3 class="delivery__title">
									Условия доставки
								</h3>
								
								<p class="delivery__item">
									&mdash; 100% предоплата
								</p>
								<? if($arResult["PROPERTIES"]["GERMANY_DAYS"]["VALUE"] != ""): ?>
									<p class="delivery__item">
										&mdash; доставка от <?=$arResult["PROPERTIES"]["GERMANY_DAYS"]["VALUE"]?> дней;
									</p>
								<? endif; ?>
								<? if($arResult["PROPERTIES"]["GERMANY_PRICE"]["VALUE"] != ""): ?>
									<p class="delivery__item">
										&mdash; стоимость доствки от <?=$arResult["PROPERTIES"]["GERMANY_PRICE"]["VALUE"]?> рублей;
									</p>
								<? endif; ?>
								<? if($arResult["PROPERTIES"]["GERMANY_ADD"]["VALUE"] != ""): ?>
									<p class="delivery__item">
										&mdash; <?=$arResult["PROPERTIES"]["GERMANY_ADD"]["VALUE"]?>
									</p>
								<? endif; ?>
								
							</div>
							
						<? } ?>
						
					<?endif?>
					<?
						if ('Y' == $arParams['DISPLAY_COMPARE'])
						{
					?>
								<a href="javascript:void(0)" style="margin-left: 10px">
									<img src="/images/prop/buynowshopatron.gif">
								</a>
					<?
						}
					?>
				</div>
			</div>
			
			
            <h3>Цвета</h3>
            <div class="info">
				<?=$arResult["PROPERTIES"]["COLOR"]["VALUE"]?>
            </div>
            <div class="nomobile">
            </div>

            <hr style="margin-left: 0px;">

            <div class="noprint">
				<span style="position: relative" class="nomobile">
					<a href="#" class="udropdown">Таблица размеров</a>
					<?
					if($arResult["PROPERTIES"]["SIZE_TABLE"]["VALUE"] != ""){
						if($arResult["PROPERTIES"]["SIZE_TABLE"]["VALUE_ENUM_ID"] == "76"){$table = "handschuh_en";}
						if($arResult["PROPERTIES"]["SIZE_TABLE"]["VALUE_ENUM_ID"] == "77"){$table = "textil_en";}
						if($arResult["PROPERTIES"]["SIZE_TABLE"]["VALUE_ENUM_ID"] == "78"){$table = "ball_en";}
					?>
					<img src="/images/prop/<?=$table?>.png" id="sizetable" style="display:none; position:absolute; right:0px; top:20px; z-index:200">
					<?}?>
				</span>

				<div id="dealer">
					<select id="d-dropdown" class="cd-select">
						<option selected="selected" value="/dealers/">Дилеры</option>
						<?
						$res = CIBlockElement::GetList(array(),array("IBLOCK_ID" =>5,"PROPERTY_SHOW_FOOTER"=>17),false,false,array("IBLOCK_ID","ID","NAME","CODE"));
						while($ar_fields = $res->GetNext()){?>
							<option value="/dealers/<?=$ar_fields["CODE"];?>/"><?=$ar_fields["NAME"];?></option>    
						<?}?>
						<option value="/dealers/">View all...</option>
					</select>
				</div>


               <a title="Share this Product on FACEBOOK" class="facebook-product-share" target="_blank" href="http://www.facebook.com/sharer.php?u=http://www.uhlsport.com/en_us/products/details/100031801/ergonomic-bionik-x-change">Share</a>

            </div>
        </div>
	</div>
</div>
<div class="grid_16" style="margin-bottom: 50px;"></div>
<div class="clear"></div>
<?
$res1 = CIBlockElement::GetList(array(),array("IBLOCK_ID" =>2,"NAME"=>$arResult["NAME"]),false,false,array("ID","IBLOCK_ID","PROPERTY_NEWPRODUCT","PROPERTY_ARTNUMBER","PROPERTY_COLOR","DETAIL_PICTURE","DETAIL_PAGE_URL"));
$q = 0;
while($ar_fields = $res1->GetNext())
{
  if($ar_fields["ID"] != $arResult["ID"]){
	$q++;
	if($q == 1){
	?>
	<div class="headline"><h2>Другие цвета</h2></div>
		<ul class="image-grid">
	<?
	}
	?>
		<li>
			<a href="<?=$ar_fields["DETAIL_PAGE_URL"]?>">
				<img alt="product" src="<?=CFile::GetPath($ar_fields["DETAIL_PICTURE"])?>">
				<div class="articlenumber"><?=$ar_fields["PROPERTY_ARTNUMBER_VALUE"]?></div>
				<div class="color"><?=$ar_fields["PROPERTY_COLOR_VALUE"]?></div>
				<?if($ar_fields["PROPERTY_NEWPRODUCT_ENUM_ID"] == 1){?><span class="new"></span><?}?>
			</a>
		</li>
	<?
  }
}
echo "</ul>";
?>

<?
if (isset($arResult['OFFERS']) && !empty($arResult['OFFERS']))
{
	foreach ($arResult['JS_OFFERS'] as &$arOneJS)
	{
		if ($arOneJS['PRICE']['DISCOUNT_VALUE'] != $arOneJS['PRICE']['VALUE'])
		{
			$arOneJS['PRICE']['PRINT_DISCOUNT_DIFF'] = GetMessage('ECONOMY_INFO', array('#ECONOMY#' => $arOneJS['PRICE']['PRINT_DISCOUNT_DIFF']));
			$arOneJS['PRICE']['DISCOUNT_DIFF_PERCENT'] = -$arOneJS['PRICE']['DISCOUNT_DIFF_PERCENT'];
		}
		$strProps = '';
		if ($arResult['SHOW_OFFERS_PROPS'])
		{
			if (!empty($arOneJS['DISPLAY_PROPERTIES']))
			{
				foreach ($arOneJS['DISPLAY_PROPERTIES'] as $arOneProp)
				{
					$strProps .= '<dt>'.$arOneProp['NAME'].'</dt><dd>'.(
						is_array($arOneProp['VALUE'])
						? implode(' / ', $arOneProp['VALUE'])
						: $arOneProp['VALUE']
					).'</dd>';
				}
			}
		}
		$arOneJS['DISPLAY_PROPERTIES'] = $strProps;
	}
	if (isset($arOneJS))
		unset($arOneJS);
	$arJSParams = array(
		'CONFIG' => array(
			'SHOW_QUANTITY' => $arParams['USE_PRODUCT_QUANTITY'],
			'SHOW_DISCOUNT_PERCENT' => ('Y' == $arParams['SHOW_DISCOUNT_PERCENT']),
			'SHOW_OLD_PRICE' => ('Y' == $arParams['SHOW_OLD_PRICE']),
			'DISPLAY_COMPARE' => ('Y' == $arParams['DISPLAY_COMPARE']),
			'SHOW_SKU_PROPS' => $arResult['SHOW_OFFERS_PROPS'],
			'OFFER_GROUP' => $arResult['OFFER_GROUP'],
			'MAIN_PICTURE_MODE' => $arParams['DETAIL_PICTURE_MODE']
		),
		'PRODUCT_TYPE' => $arResult['CATALOG_TYPE'],
		'VISUAL' => array(
			'ID' => $arItemIDs['ID'],
		),
		'DEFAULT_PICTURE' => array(
			'PREVIEW_PICTURE' => $arResult['DEFAULT_PICTURE'],
			'DETAIL_PICTURE' => $arResult['DEFAULT_PICTURE']
		),
		'PRODUCT' => array(
			'ID' => $arResult['ID'],
			'NAME' => $arResult['~NAME']
		),
		'BASKET' => array(
			'QUANTITY' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
			'BASKET_URL' => $arParams['BASKET_URL'],
			'SKU_PROPS' => $arResult['OFFERS_PROP_CODES']
		),
		'OFFERS' => $arResult['JS_OFFERS'],
		'OFFER_SELECTED' => $arResult['OFFERS_SELECTED'],
		'TREE_PROPS' => $arSkuProps
	);
}
else
{
	$emptyProductProperties = empty($arResult['PRODUCT_PROPERTIES']);
	if ('Y' == $arParams['ADD_PROPERTIES_TO_BASKET'] && !$emptyProductProperties)
	{
?>
<div id="<? echo $arItemIDs['BASKET_PROP_DIV']; ?>" style="display: none;">
<?
		if (!empty($arResult['PRODUCT_PROPERTIES_FILL']))
		{
			foreach ($arResult['PRODUCT_PROPERTIES_FILL'] as $propID => $propInfo)
			{
?>
	<input
		type="hidden"
		name="<? echo $arParams['PRODUCT_PROPS_VARIABLE']; ?>[<? echo $propID; ?>]"
		value="<? echo htmlspecialcharsbx($propInfo['ID']); ?>"
	>
<?
				if (isset($arResult['PRODUCT_PROPERTIES'][$propID]))
					unset($arResult['PRODUCT_PROPERTIES'][$propID]);
			}
		}
		$emptyProductProperties = empty($arResult['PRODUCT_PROPERTIES']);
		if (!$emptyProductProperties)
		{
?>
	<table>
<?
			foreach ($arResult['PRODUCT_PROPERTIES'] as $propID => $propInfo)
			{
?>
	<tr><td><? echo $arResult['PROPERTIES'][$propID]['NAME']; ?></td>
	<td>
<?
				if(
					'L' == $arResult['PROPERTIES'][$propID]['PROPERTY_TYPE']
					&& 'C' == $arResult['PROPERTIES'][$propID]['LIST_TYPE']
				)
				{
					foreach($propInfo['VALUES'] as $valueID => $value)
					{
						?><label><input
							type="radio"
							name="<? echo $arParams['PRODUCT_PROPS_VARIABLE']; ?>[<? echo $propID; ?>]"
							value="<? echo $valueID; ?>"
							<? echo ($valueID == $propInfo['SELECTED'] ? '"checked"' : ''); ?>
						><? echo $value; ?></label><br><?
					}
				}
				else
				{
					?><select name="<? echo $arParams['PRODUCT_PROPS_VARIABLE']; ?>[<? echo $propID; ?>]"><?
					foreach($propInfo['VALUES'] as $valueID => $value)
					{
						?><option
							value="<? echo $valueID; ?>"
							<? echo ($valueID == $propInfo['SELECTED'] ? '"selected"' : ''); ?>
						><? echo $value; ?></option><?
					}
					?></select><?
				}
?>
	</td></tr>
<?
			}
?>
	</table>
<?
		}
?>
</div>
<?
	}
	$arJSParams = array(
		'CONFIG' => array(
			'SHOW_QUANTITY' => $arParams['USE_PRODUCT_QUANTITY'],
			'SHOW_PRICE' => true,
			'SHOW_DISCOUNT_PERCENT' => ('Y' == $arParams['SHOW_DISCOUNT_PERCENT']),
			'SHOW_OLD_PRICE' => ('Y' == $arParams['SHOW_OLD_PRICE']),
			'DISPLAY_COMPARE' => ('Y' == $arParams['DISPLAY_COMPARE']),
			'MAIN_PICTURE_MODE' => $arParams['DETAIL_PICTURE_MODE']
		),
		'VISUAL' => array(
			'ID' => $arItemIDs['ID'],
		),
		'PRODUCT_TYPE' => $arResult['CATALOG_TYPE'],
		'PRODUCT' => array(
			'ID' => $arResult['ID'],
			'PICT' => $arFirstPhoto,
			'NAME' => $arResult['~NAME'],
			'SUBSCRIPTION' => true,
			'PRICE' => $arResult['MIN_PRICE'],
			'SLIDER_COUNT' => $arResult['MORE_PHOTO_COUNT'],
			'SLIDER' => $arResult['MORE_PHOTO'],
			'CAN_BUY' => $arResult['CAN_BUY'],
			'CHECK_QUANTITY' => $arResult['CHECK_QUANTITY'],
			'QUANTITY_FLOAT' => is_double($arResult['CATALOG_MEASURE_RATIO']),
			'MAX_QUANTITY' => $arResult['CATALOG_QUANTITY'],
			'STEP_QUANTITY' => $arResult['CATALOG_MEASURE_RATIO'],
			'BUY_URL' => $arResult['~BUY_URL'],
		),
		'BASKET' => array(
			'ADD_PROPS' => ('Y' == $arParams['ADD_PROPERTIES_TO_BASKET']),
			'QUANTITY' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
			'PROPS' => $arParams['PRODUCT_PROPS_VARIABLE'],
			'EMPTY_PROPS' => $emptyProductProperties,
			'BASKET_URL' => $arParams['BASKET_URL']
		)
	);
	unset($emptyProductProperties);
}
?>
<script type="text/javascript">
var <? echo $strObName; ?> = new JCCatalogElement(<? echo CUtil::PhpToJSObject($arJSParams, false, true); ?>);
BX.message({
	MESS_BTN_BUY: '<? echo ('' != $arParams['MESS_BTN_BUY'] ? CUtil::JSEscape($arParams['MESS_BTN_BUY']) : GetMessageJS('CT_BCE_CATALOG_BUY')); ?>',
	MESS_BTN_ADD_TO_BASKET: '<? echo ('' != $arParams['MESS_BTN_ADD_TO_BASKET'] ? CUtil::JSEscape($arParams['MESS_BTN_ADD_TO_BASKET']) : GetMessageJS('CT_BCE_CATALOG_ADD')); ?>',
	MESS_NOT_AVAILABLE: '<? echo ('' != $arParams['MESS_NOT_AVAILABLE'] ? CUtil::JSEscape($arParams['MESS_NOT_AVAILABLE']) : GetMessageJS('CT_BCE_CATALOG_NOT_AVAILABLE')); ?>',
	TITLE_ERROR: '<? echo GetMessageJS('CT_BCE_CATALOG_TITLE_ERROR') ?>',
	TITLE_BASKET_PROPS: '<? echo GetMessageJS('CT_BCE_CATALOG_TITLE_BASKET_PROPS') ?>',
	BASKET_UNKNOWN_ERROR: '<? echo GetMessageJS('CT_BCE_CATALOG_BASKET_UNKNOWN_ERROR') ?>',
	BTN_SEND_PROPS: '<? echo GetMessageJS('CT_BCE_CATALOG_BTN_SEND_PROPS'); ?>',
	BTN_MESSAGE_CLOSE: '<? echo GetMessageJS('CT_BCE_CATALOG_BTN_MESSAGE_CLOSE') ?>'
});
</script>
						</tbody>	