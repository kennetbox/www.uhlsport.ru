<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?if($arResult["ORDER_ID"])://{pp($arResult, array( 'autoCollapsed' => TRUE ));}?>
<?$APPLICATION->IncludeComponent("bitrix:sale.personal.order.detail", "order", Array(
	"PATH_TO_LIST" => "",	// Страница со списком заказов
	"PATH_TO_CANCEL" => "",	// Страница отмены заказа
	"PATH_TO_PAYMENT" => "payment.php",	// Страница подключения платежной системы
	"ID" => $arResult["ORDER_ID"],	// Идентификатор заказа
	"SET_TITLE" => "Y",	// Устанавливать заголовок страницы
	"PROP_1" => "",	// Не показывать свойства для типа плательщика "Физическое лицо" (s1)
	),
	false
);?>
<?endif;?>