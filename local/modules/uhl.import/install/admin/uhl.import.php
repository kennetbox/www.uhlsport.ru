<?
	if (file_exists( $_SERVER["DOCUMENT_ROOT"]."/local/modules/uhl.import/admin/uhl.import.php")){
	  require_once($_SERVER["DOCUMENT_ROOT"]."/local/modules/uhl.import/admin/uhl.import.php");
	}
	else{
	  require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/uhl.import/admin/uhl.import.php");
	}
?>