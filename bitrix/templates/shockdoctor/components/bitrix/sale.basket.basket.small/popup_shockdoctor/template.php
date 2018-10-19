<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>


<?
// Выберем в массив весь дополнительный функционал группы с идентификатором $ID
$ID = 3;
// подключаем модули
CModule::IncludeModule('iblock');
CModule::IncludeModule('highloadblock');

// необходимые классы
use Bitrix\Highloadblock as HL;
use Bitrix\Main\Entity;

// hlblock у нас первый ), $hlblock - это массив
$hlblock   = HL\HighloadBlockTable::getById( 3 )->fetch();

// получаем сущность для работы с новым HL-блоком статей
// (тип $entity - Bitrix\Main\Entity\Base)
// меня сперва накрыло, см. ниже, но потом разъяснилось:
// в этом месте еще одно важное действие происходит:
// если класс датаМенеджер для работы с HL-инфоблоком не создан, то он в этом месте
// создается автоматически через eval(), т.е. тут у меня создается класс
// $entity_data_class.'Table' равный 'ArticlesTable'
$entity   = HL\HighloadBlockTable::compileEntity( $hlblock );

// затем получаем объект DataManager для работы с данными
// $entity_data_class - это строка (!!!!) ArticlesTable
//
// (ОООООО!) вот тут меня накрыло:
//--------- а как методы то вызываются, автозагрузчик все делает
//--------- и создает класс ArticlesTable?
//
// ответ нашел - можно самому сделать класс ArticlesTable с нужными мне методами,
// либо он будет создан, в методе HighloadBlockTable::compileEntity()
$entity_data_class = $entity->getDataClass();

// такой вот комментарий для eclipse, чтобы подсказки работали
/* $entity_data_class Bitrix\Main\Entity\DataManager */
/*
$rs = CIBlockElement::GetList(
   array('ID' => 'ASC'),
   array('IBLOCK_ID' => 3),
   false, false,
   array('UF_NAME', 'UF_XML_ID', 'UF_FILE')
);
*/
$resource = $entity_data_class::GetList(array(
	'select' => array('ID', 'UF_NAME', 'UF_XML_ID', 'UF_FILE'),
	'order' => array( 'ID' => 'ASC'),
	'filter' => array()
));
$colorsData = array();
while ($res = $resource->Fetch()) {
	$colorsData[$res["UF_XML_ID"]] = array(
			"ID" => $res["ID"],
			"NAME" => strtolower($res["UF_NAME"]),
			"XML_ID" => $res["UF_XML_ID"],
			"IMAGE" => CFile::GetPath( $res["UF_FILE"] ),
	);
}

?>

<?
if ($arResult["READY"]=="Y" || $arResult["DELAY"]=="Y" || $arResult["NOTAVAIL"]=="Y" || $arResult["SUBSCRIBE"]=="Y")
{
?>



<div id="top-cart-container">
	<!--{CART_SIDEBAR_a8f425f238218db362da452140399803}-->
	<div class="top-cart">
		
		<div id="topCartContent" class="block-content" style="display:none">
			<div class="inner-wrapper">
				
				<div class="arrow"></div>

					<p class="block-subtitle">
						<span onclick="Enterprise.TopCart.hideCart()" class="close-btn">
							<img src="<?=SITE_TEMPLATE_PATH?>/images/close-button.png" alt="Close">
						</span>
						<span class="title">Корзина</span>
					</p>

<table id="mini-cart" class="mini-products-list">
	<tbody class="last odd">
<?
	if ($arResult["READY"]=="Y")
	{
?>
<?/*
<tr>
	<td align="center">
		<? echo GetMessage("TSBS_READY"); ?>
	</td>
</tr>
*/?>
		<?
		foreach ($arResult["ITEMS"] as &$v)
		{
			if ($v["DELAY"]=="N" && $v["CAN_BUY"]=="Y")
			{

			$IBLOCK_ID = 17;
			$ELEMENT_ID = $v["PRODUCT_ID"];
			$arSelect = Array( "ID", "IBLOCK_ID", "CODE", "NAME", "URL", "DATE_ACTIVE_FROM", "PROPERTY_MORE_PHOTO" ); //IBLOCK_ID и ID обязательно должны быть указаны, см. описание arSelectFields выше
			$arFilter = Array( "IBLOCK_ID" => IntVal($IBLOCK_ID), "ID" => $ELEMENT_ID, "ACTIVE_DATE" => "Y", "ACTIVE" =>"Y" );
			$res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize"=>50), $arSelect); 
			$addINFO = '';
			while($ob = $res->GetNextElement()){ 
				$arProps = $ob->GetProperties();
				$photoID = $arProps["MORE_PHOTO"]["VALUE"][0];

				$arFile = CFile::GetFileArray( $photoID );
				$file = CFile::ResizeImageGet($arFile, array('width'=>63, 'height'=>63), BX_RESIZE_IMAGE_PROPORTIONAL, true);
				if(empty($file['src'])) {
					$img = '<img src="'.$APPLICATION->GetTemplatePath().'images/no_photo.png" width="63" height="63" />';
				} else {
					$img = '<img src="'.$file['src'].'" width="'.$file['width'].'" height="'.$file['height'].'" />';
				}
				if( !empty($arProps["COLOR_REF"]["VALUE"]) ) {
					$addINFO .= $colorsData[$arProps["COLOR_REF"]["VALUE"]]["NAME"].", ";
				}
				if( !empty($arProps["SIZES_SHOES"]["VALUE"]) ) {
					$addINFO .= $arProps["SIZES_SHOES"]["VALUE"];
				}
				if( !empty($arProps["SIZES_CLOTHES"]["VALUE"]) ) {
					$addINFO .= $arProps["SIZES_CLOTHES"]["VALUE"];
				}
			}
			
		?>
		<tr>
			<td class="imagerow">
				<a class="product-image" href="<?=$detailURL ?>" title="<?=$arItem["NAME"]?>">
					<?=$img ?>
				</a>
			</td>
			<?
			if ('' != $v["DETAIL_PAGE_URL"])
			{
			?>
			<td>
				<h2 class="product-name">		
					<a href="<?echo $v["DETAIL_PAGE_URL"]; ?>">
						<?echo $v["NAME"]?>
					</a>
				</h2>
				<? if(!empty($addINFO)) { ?>
					<dl class="item-options"><?=$addINFO?></dl>
				<? } ?>
				<div class="qnty-column"><span class="qnty-title">Кол-во:</span> <?echo $v["QUANTITY"]?></div>
			</td>
			<?
			}
			else
			{
			?>
			<td>
				<h2 class="product-name">	
					<?echo $v["NAME"]?>
				</h2>
				<? if(!empty($addINFO)) { ?>
					<dl class="item-options"><?=$addINFO?></dl>
				<? } ?>
				<div class="qnty-column"><span class="qnty-title">Кол-во:</span> <?echo $v["QUANTITY"]?></div>
			</td>
			<?
			}
			?>
			<td class="a-right price-column">
				<span class="cart-price"><span class="price"><?echo $v["PRICE_FORMATED"]?></span></span>
				<a class="btn-remove btn-remove2" href="/personal/cart/?action=delete&id=<?=$v["ID"] ?>" title="Удалить">Удалить</a>
			</td>
		</tr>
		<?
			}
		}
		if (isset($v))
			unset($v);
		?>

		<?
		if ('' != $arParams["PATH_TO_BASKET"])
		{
		?>
<?/*
<tr>
	<td align="center">
		<form method="get" action="<?=$arParams["PATH_TO_BASKET"]?>">
			<input type="submit" value="<?= GetMessage("TSBS_2BASKET") ?>">
		</form>
	</td>
</tr>
*/?>

		<?
		}
		if ('' != $arParams["PATH_TO_ORDER"])
		{
		?>

<?/*
<tr>
	<td align="center">
		<form method="get" action="<?= $arParams["PATH_TO_ORDER"] ?>">
			<input type="submit" value="<?= GetMessage("TSBS_2ORDER") ?>">
		</form>
	</td>
</tr>
*/?>

	<?
		}
	}
	if ($arResult["DELAY"]=="Y")
	{
	?>
	
<?/*
<tr>
	<td align="center">
		<?= GetMessage("TSBS_DELAY") ?>
	</td>
</tr>
*/?>

	<?
	foreach ($arResult["ITEMS"] as &$v)
	{
		if ($v["DELAY"]=="Y" && $v["CAN_BUY"]=="Y")
		{
	
		$IBLOCK_ID = 17;
		$ELEMENT_ID = $v["PRODUCT_ID"];
		$arSelect = Array( "ID", "IBLOCK_ID", "CODE", "NAME", "URL", "DATE_ACTIVE_FROM", "PROPERTY_MORE_PHOTO" ); //IBLOCK_ID и ID обязательно должны быть указаны, см. описание arSelectFields выше
		$arFilter = Array( "IBLOCK_ID" => IntVal($IBLOCK_ID), "ID" => $ELEMENT_ID, "ACTIVE_DATE" => "Y", "ACTIVE" =>"Y" );
		$res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize"=>50), $arSelect); 
		$addINFO = '';
		while($ob = $res->GetNextElement()){ 
			$arProps = $ob->GetProperties();
			$photoID = $arProps["MORE_PHOTO"]["VALUE"][0];

			$arFile = CFile::GetFileArray( $photoID );
			$file = CFile::ResizeImageGet($arFile, array('width'=>63, 'height'=>63), BX_RESIZE_IMAGE_PROPORTIONAL, true);                
			$img = '<img src="'.$file['src'].'" width="'.$file['width'].'" height="'.$file['height'].'" />';
			if( !empty($arProps["COLOR_REF"]["VALUE"]) ) {
				$addINFO .= $arProps["COLOR_REF"]["VALUE"].",";
			}
			if( !empty($arProps["SIZES_SHOES"]["VALUE"]) ) {
				$addINFO .= $arProps["SIZES_SHOES"]["VALUE"];
			}
			if( !empty($arProps["SIZES_CLOTHES"]["VALUE"]) ) {
				$addINFO .= $arProps["SIZES_CLOTHES"]["VALUE"];
			}
		}
		
	?>
		
	<tr>
		<td class="imagerow">
			<a class="product-image" href="<?=$detailURL ?>" title="<?=$arItem["NAME"]?>">
				<?=$img ?>
			</a>
		</td>
		<?
		if ('' != $v["DETAIL_PAGE_URL"])
		{
		?>
		<td>
			<h2 class="product-name">
				<a href="<?echo $v["DETAIL_PAGE_URL"] ?>">
					<?echo $v["NAME"]?>
				</a>
			</h2>
			<? if(!empty($addINFO)) { ?>
				<dl class="item-options"><?=$addINFO?></dl>
			<? } ?>
			<div class="qnty-column"><span class="qnty-title">Кол-во:</span> <?echo $v["QUANTITY"]?></div>
		</td>
		<?
		}
		else
		{
		?>
		<td>
			<h2 class="product-name">
				<?echo $v["NAME"]?>
			</h2>
			<? if(!empty($addINFO)) { ?>
				<dl class="item-options"><?=$addINFO?></dl>
			<? } ?>
			<div class="qnty-column"><span class="qnty-title">Кол-во:</span> <?echo $v["QUANTITY"]?></div>
		</td>
		<?
		}
		?>

		<td class="a-right price-column">
			<span class="cart-price"><span class="price"><?echo $v["PRICE_FORMATED"]?></span></span>
			<a class="btn-remove btn-remove2" href="/personal/cart/?action=delete&id=<?=$v["ID"] ?>" title="Удалить">Удалить</a>
		</td>
	
	</tr>
		
	<?
		}
	}
	if (isset($v))
		unset($v);
	?>


<?
		if ('' != $arParams["PATH_TO_BASKET"])
		{
?>

<?/*
<tr>
	<td>
		<form method="get" action="<?=$arParams["PATH_TO_BASKET"]?>">
			<input type="submit" value="<?= GetMessage("TSBS_2BASKET") ?>">
		</form>
	</td>
</tr>
*/?>

<?
		}
	}
	if ($arResult["SUBSCRIBE"]=="Y")
	{
	?>

<?/*
<tr>
	<td align="center">
		<?= GetMessage("TSBS_SUBSCRIBE") ?>
	</td>
</tr>
*/?>
		<?
		foreach ($arResult["ITEMS"] as &$v)
		{
			if ($v["CAN_BUY"]=="N" && $v["SUBSCRIBE"]=="Y")
			{
			
			$IBLOCK_ID = 17;
			$ELEMENT_ID = $v["PRODUCT_ID"];
			$arSelect = Array( "ID", "IBLOCK_ID", "CODE", "NAME", "URL", "DATE_ACTIVE_FROM", "PROPERTY_MORE_PHOTO" ); //IBLOCK_ID и ID обязательно должны быть указаны, см. описание arSelectFields выше
			$arFilter = Array( "IBLOCK_ID" => IntVal($IBLOCK_ID), "ID" => $ELEMENT_ID, "ACTIVE_DATE" => "Y", "ACTIVE" =>"Y" );
			$res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize"=>50), $arSelect); 
			$addINFO = '';
			while($ob = $res->GetNextElement()){ 
				$arProps = $ob->GetProperties();
				$photoID = $arProps["MORE_PHOTO"]["VALUE"][0];

				$arFile = CFile::GetFileArray( $photoID );
				$file = CFile::ResizeImageGet($arFile, array('width'=>63, 'height'=>63), BX_RESIZE_IMAGE_PROPORTIONAL, true);                
				$img = '<img src="'.$file['src'].'" width="'.$file['width'].'" height="'.$file['height'].'" />';
				if( !empty($arProps["COLOR_REF"]["VALUE"]) ) {
					$addINFO .= $arProps["COLOR_REF"]["VALUE"].",";
				}
				if( !empty($arProps["SIZES_SHOES"]["VALUE"]) ) {
					$addINFO .= $arProps["SIZES_SHOES"]["VALUE"];
				}
				if( !empty($arProps["SIZES_CLOTHES"]["VALUE"]) ) {
					$addINFO .= $arProps["SIZES_CLOTHES"]["VALUE"];
				}
			}
			
		?>
		<tr>
			<td class="imagerow">
				<a class="product-image" href="<?=$detailURL ?>" title="<?=$arItem["NAME"]?>">
					<?=$img ?>
				</a>
			</td>
			<?
			if ('' != $v["DETAIL_PAGE_URL"])
			{
			?>
			<td>
				<h2 class="product-name">
					<a href="<?echo $v["DETAIL_PAGE_URL"] ?>">
						<b><?echo $v["NAME"]?></b>
					</a>
				</h2>
				<? if(!empty($addINFO)) { ?>
					<dl class="item-options"><?=$addINFO?></dl>
				<? } ?>
				<div class="qnty-column"><span class="qnty-title">Кол-во:</span> <?echo $v["QUANTITY"]?></div>
			</td>	
			<?
			}
			else
			{
			?>
			<td>
				<h2 class="product-name">
					<?echo $v["NAME"]?>
				</h2>
				<? if(!empty($addINFO)) { ?>
					<dl class="item-options"><?=$addINFO?></dl>
				<? } ?>
				<div class="qnty-column"><span class="qnty-title">Кол-во:</span> <?echo $v["QUANTITY"]?></div>
			</td>	
			<?
			}
			?>
			
		</tr>
			
		<?
			}
		}
		if (isset($v))
			unset($v);
		?>



<?
	}
	if ($arResult["NOTAVAIL"]=="Y")
	{
		?>

<?/*
<tr>
	<td align="center">
		<?= GetMessage("TSBS_UNAVAIL") ?>
	</td>
</tr>
*/?>

		<?
		foreach ($arResult["ITEMS"] as $key => $v)
		{
			if ($v["CAN_BUY"]=="N" && $v["SUBSCRIBE"]=="N")
			{
			
			$IBLOCK_ID = 17;
			$ELEMENT_ID = $v["PRODUCT_ID"];
			$arSelect = Array( "ID", "IBLOCK_ID", "CODE", "NAME", "URL", "DATE_ACTIVE_FROM", "PROPERTY_MORE_PHOTO" ); //IBLOCK_ID и ID обязательно должны быть указаны, см. описание arSelectFields выше
			$arFilter = Array( "IBLOCK_ID" => IntVal($IBLOCK_ID), "ID" => $ELEMENT_ID, "ACTIVE_DATE" => "Y", "ACTIVE" =>"Y" );
			$res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize"=>50), $arSelect); 
			$addINFO = '';
			while($ob = $res->GetNextElement()){ 
				$arProps = $ob->GetProperties();
				$photoID = $arProps["MORE_PHOTO"]["VALUE"][0];

				$arFile = CFile::GetFileArray( $photoID );
				$file = CFile::ResizeImageGet($arFile, array('width'=>63, 'height'=>63), BX_RESIZE_IMAGE_PROPORTIONAL, true);                
				$img = '<img src="'.$file['src'].'" width="'.$file['width'].'" height="'.$file['height'].'" />';
				if( !empty($arProps["COLOR_REF"]["VALUE"]) ) {
					$addINFO .= $arProps["COLOR_REF"]["VALUE"].",";
				}
				if( !empty($arProps["SIZES_SHOES"]["VALUE"]) ) {
					$addINFO .= $arProps["SIZES_SHOES"]["VALUE"];
				}
				if( !empty($arProps["SIZES_CLOTHES"]["VALUE"]) ) {
					$addINFO .= $arProps["SIZES_CLOTHES"]["VALUE"];
				}
			}
			
		?>
		
		<tr>
			<td class="imagerow">
				<a class="product-image" href="<?=$detailURL ?>" title="<?=$arItem["NAME"]?>">
					<?=$img ?>
				</a>
			</td>
			<?
			if ('' != $v["DETAIL_PAGE_URL"])
			{
			?>
			<td>
				<h2 class="product-name">
					<a href="<?echo $v["DETAIL_PAGE_URL"] ?>">
						<?echo $v["NAME"]?>
					</a>
				</h2>
				<? if(!empty($addINFO)) { ?>
					<dl class="item-options"><?=$addINFO?></dl>
				<? } ?>
				<div class="qnty-column"><span class="qnty-title">Кол-во:</span> <?echo $v["QUANTITY"]?></div>
			</td>
			<?
			}
			else
			{
			?>
			<td>
				<h2 class="product-name">
					<b><?echo $v["NAME"]?></b>
				</h2>
				<? if(!empty($addINFO)) { ?>
					<dl class="item-options"><?=$addINFO?></dl>
				<? } ?>
				<div class="qnty-column"><span class="qnty-title">Кол-во:</span> <?echo $v["QUANTITY"]?></div>
			</td>
			<?
			}
			?>
			<td class="a-right price-column">
				<span class="cart-price"><span class="price"><?echo $v["PRICE_FORMATED"]?></span></span>
				<a class="btn-remove btn-remove2" href="/personal/cart/?action=delete&id=<?=$v["ID"] ?>" title="Удалить">Удалить</a>
			</td>
		</tr>
		<?
			}
		}
		if (isset($v))
			unset($v);
		?>

<?
	}
	?>
	</tbody>
</table>

<?
	$sum = 0;
	foreach( $arResult["ITEMS"] as $key => $val ) {
		$sum = $sum + $val["QUANTITY"] * $val["PRICE"];
	}
?>
				<p class="totals submit-bottom-bg">
					<span class="label">Итого:</span> <span class="price"><?=$sum." руб." ?></span>
				</p>
				
				<div class="continue-shopping">
					<a onclick="Enterprise.TopCart.hideCart(); return false;" href="#">Продолжить покупки</a>
				</div>

				<div class="checkout-buttons">
					<?/* <button class="button cta" type="button" onclick="Enterprise.TopCart.hideCart(); windowsInstances.loginCheckout.show()"> */?>
					<p class="cta cta-popup">
						<a href="/personal/cart/">Оформить заказ</a>
					</p>
					<?/* </button> */?>
				</div>

			</div>
		</div>
		
		<script type="text/javascript">
			Enterprise.TopCart.initialize('topCartContent', 'cartHeader', '/');
			// Below can be used to show minicart after item added
			// Enterprise.TopCart.showCart(7);
		</script>
		
	</div>
</div>

<?
}
?>