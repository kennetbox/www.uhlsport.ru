<?
  if (class_exists('uhl_import')) return;

  class uhl_import extends CModule
  {
    var $MODULE_ID = 'uhl.import';
    var $MODULE_VERSION;
    var $MODULE_VERSION_DATE;
    var $MODULE_NAME;
    var $MODULE_DESCRIPTION;
    var $MODULE_GROUP_RIGHTS = 'Y';

    var $PARTNER_NAME;
    var $PARTNER_URI;
    var $MODULE_CSS;
    var $MODULE_FOLDER = "uhl.import";

    public function uhl_import()
    {
      $arModuleVersion = array();

      $path = str_replace('\\', '/', __FILE__);
      $path = substr($path, 0, strlen($path) - strlen('/index.php'));
      include($path.'/version.php');

      if (is_array($arModuleVersion) && array_key_exists('VERSION', $arModuleVersion)){
        $this->MODULE_VERSION = $arModuleVersion['VERSION'];
        $this->MODULE_VERSION_DATE = $arModuleVersion['VERSION_DATE'];
      }

      $this->MODULE_NAME = "Импорт xml из 1С";
      $this->MODULE_DESCRIPTION = "Импорт базы СпортДепо, бренд UHLSport";
      $this->PARTNER_NAME = "www.goalcenter.ru";

    }

    function DoInstall(){
      global $DB, $APPLICATION;

      $this->errors = false;
      $this->InstallFiles();

      registerModule($this->MODULE_ID);

      $GLOBALS['APPLICATION']->includeAdminFile(
        "Установка модуля \"".$this->MODULE_NAME."\"",
        __DIR__.'/step.php'
      );
    }

    function InstallFiles(){
      copyDirFiles(
        __DIR__ . '/admin',
        $_SERVER['DOCUMENT_ROOT'] . '/bitrix/admin',
        true, true
      );
      return true;
    }

    function DoUninstall(){
      global $DOCUMENT_ROOT, $APPLICATION, $step;

      $this->UninstallFiles();

      unregisterModule($this->MODULE_ID);

      $APPLICATION->includeAdminFile(
        "Удаление модуля \"".$this->MODULE_NAME."\"",
        __DIR__ . '/unstep.php'
      );
    }

    function UninstallFiles(){
      deleteDirFiles(
        __DIR__ . '/admin',
        $_SERVER['DOCUMENT_ROOT'] . '/bitrix/admin'
      );

      return true;
    }

  }
?>