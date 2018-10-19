<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

	if(!empty($arResult["ORDER_PROPS"]))
	{
		$str_order_first = array();
		$str_count_first = 0;
		
		foreach($arResult["ORDER_PROPS"] as $val)
		{?>
		
		<?$str_order_first[$str_count_first] = '<tr><td width="40%" align="right">';?>
		<?$str_order_first[$str_count_first] .= $val["NAME"].':</td>';?>
		<?$str_order_first[$str_count_first] .= '<td width="60%">'.$val["VALUE"].'</td></tr>';?>
		<?$str_count_first++;
	}
	
	$str_order_first = implode("", $str_order_first);

	$str_order_second = array();
	$str_count_second = 0;
	
	foreach($arResult["BASKET"] as $val)
	{
		?>
		
		<?$str_order_second[$str_count_second] = '<tr><td>';?>
		<?
				if (strlen($val["DETAIL_PAGE_URL"])>0)
					$str_order_second[$str_count_second] .= "<a href=\"".SITE_SERVER_NAME.$val["DETAIL_PAGE_URL"]."\">";
					$str_order_second[$str_count_second] .= htmlspecialcharsEx($val["NAME"]);
				if (strlen($val["DETAIL_PAGE_URL"])>0)
					$str_order_second[$str_count_second] .= "</a>";
		?>
		<?$str_order_second[$str_count_second] .= '</td>';?>
<?//$str_order_second[$str_count_second] .= '<td>'.$val["DISCOUNT_PRICE_PERCENT_FORMATED"].'</td>';?>
<?//$str_order_second[$str_count_second] .= '<td>'.htmlspecialcharsEx($val["NOTES"]).'</td>';?>
		<?$str_order_second[$str_count_second] .= '<td>'.$val["QUANTITY"].'</td>';?>
		<?$str_order_second[$str_count_second] .= '<td align="right">'.$val["PRICE_FORMATED"].'</td></tr>';?>
		<?$str_count_second++;
	}
	$str_order_second = implode("", $str_order_second);?>
				
	<?$eventArFields = Array( 
			 "value_1" => $arResult["ID"],
			 "value_2" => $arResult["DATE_INSERT"],
			 "value_3" => $arResult["PRICE_FORMATED"],
			 "value_4" => $arResult["USER_NAME"],
			 "value_5" => $arResult["USER"]["LOGIN"],
			 "value_6" => $arResult["USER"]["EMAIL"],
			 "value_7" => $str_order_first,
			 "value_8" => $arResult["PAY_SYSTEM"]["NAME"],
			 "value_9" => GetMessage("SALE_NO"),
			 "value_10" => $arResult["DELIVERY"]["NAME"],
			 "value_11" => $str_order_second,
			 "value_12" => $arResult["TAX_VALUE_FORMATED"],
			 "value_13" => $arResult["PRICE_DELIVERY_FORMATED"],
			 "value_14" =>$arResult["PRICE_FORMATED"],
			 "value_15" =>$arResult["USER_DESCRIPTION"]
		   ); 
	CEvent::Send("SALE_NEW_ORDER_M", "s1", $eventArFields , "N", 77);
}?>