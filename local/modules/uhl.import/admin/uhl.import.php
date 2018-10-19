<?
  require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_before.php");
	require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_after.php");

	$APPLICATION->SetTitle("Импорт остатков каталога");

	use \Bitrix\Main\Loader;
	Loader::registerAutoLoadClasses(null, array("\UHL\CatalogImport" => "/local/classes/import.php"));

	$CatalogImport = new \UHL\CatalogImport();
	$importFilePath = $CatalogImport->GetImportFilePath();

	$importFileFullPath = $_SERVER["DOCUMENT_ROOT"]."/".$importFilePath;

	if(!$CatalogImport->hasError()){
		$CatalogImport->Import($importFileFullPath);
	}

	require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_admin.php");
?>