<?
  if($APPLICATION->GetGroupRight("uhl.import")!="D" && CModule::IncludeModule("uhl.import")){
    IncludeModuleLangFile(__FILE__);
    $aMenu[] = array(
      "parent_menu" => "global_menu_services",
      "section" => "uhl.import",
      "sort" => 10,
      "text" => "Импорт каталога",
      "title" => "Импорт каталога",
      "icon" => "statistic_icon_summary",
      "icon" => "default_menu_icon",
      "page_icon" => "statistic_icon_summary",
      "items_id" => "module_uhl_import",
      "items" => array(
        array(
          "text" => "Импорт остатков каталога",
          "url" => "/bitrix/admin/uhl.import.php"."?&lang=".LANG,
          "more_url" => array("uhl.import.php"),
        ),
      )
    );
    return $aMenu;
  }
  return false;
?>