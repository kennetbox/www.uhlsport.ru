<?
  namespace UHL;

  use \Bitrix\Main\Loader;

  /**
   *  Класс импорта каталога
   */
  class MasterImport
  {
    protected $error = array();
    protected $importDir = "/1c/import/";
    protected $importFileName = "ВыгрузкаНаСайт.zip";
    protected $importFileFullName = "";
    protected $importType;
    protected $importMessageNo = 0;
    protected $XML = array();

    function __construct()
    {
      if( !Loader::includeModule("iblock")||!Loader::includeModule("highloadblock")||!Loader::includeModule("catalog")||!Loader::includeModule("sale")||!Loader::includeModule("uhl.import")){
        $this->error[] = "Не установлены нужные модули";
        throw new \Bitrix\Main\SystemException("Error: Не установлены нужные модули");
        return false;
      }
    }

    function hasError(){
      return count($this->error) > 0;
    }

    // Получение полного имени файла выгрузки
    function GetImportFilePath()
    {
      Loader::includeModule("fileman");

      $this->importDir = $_SERVER["DOCUMENT_ROOT"].$this->importDir;
      $this->importFileFullName = $this->importDir.$this->importFileName;

      if(\CBXArchive::IsArchive($this->importFileFullName)){

        $archive = \CBXArchive::GetArchive($this->importFileFullName);

        if ($archive instanceof \IBXArchive){
          global $USER;
          $archive->SetOptions(
            array(
              "REMOVE_PATH"       => $_SERVER["DOCUMENT_ROOT"],
              "UNPACK_REPLACE"    => true,
              "CHECK_PERMISSIONS" => $USER->IsAdmin() ? false : true
            )
          );

          $extract = $archive->Unpack($this->importDir);

          if (!$extract){
            $this->error = $arc->GetErrors();
            $this->error[] = "Error Unpack File. Check disk space.";
          }
          else{
            $exName = $extract[0]["filename"];
          }
        }
        else{
          $this->error[] = "Ошибка с архивом";
        }
      }
      if($exName && !file_exists($exName)){
        $this->error[] = "Файл не найден";
      }
      else{
        $this->importFileFullName = $exName;
        $exName = str_replace($_SERVER["DOCUMENT_ROOT"], "", $exName);
      }
      echo "GetImportFilePath() : $this->importFileFullName<br/>";
      return $exName;
    }

    // Получение типа выгрузки
    function GetImportType()
    {
      $this->XML = new \XMLReader();
      $this->XML->open($this->importFileFullName);

      while($this->XML->read()) {
        if($this->XML->nodeType == \XMLReader::ELEMENT) {
          if(($this->XML->localName == 'FullUpload')){
            $this->importType = intval(trim($this->XML->expand()->nodeValue));
          }
        }
      }
      $this->XML->close();
      echo "GetImportType() : $this->importType<br/>";
    }

    // Возврат к началу XML
    function XMLStart()
    {
      $this->XML->open($this->importFileFullName);
      echo "XMLStart()<br/>";
    }

    // Получение номера выгрузки
    function GetMessageNo()
    {
      $this->XML->open($this->importFileFullName);
      while($this->XML->read()) {
        if($this->XML->nodeType == \XMLReader::ELEMENT) {
          if(($this->XML->localName == 'MessageNo')){
            $this->importMessageNo = intval(trim($this->XML->expand()->nodeValue));
            break;
          }
        }
      }
      if ($this->importMessageNo <= 0) {
        $this->error[] = "Поле MessageNo не найдено";
      }
      echo "GetMessageNo() : ".$this->importMessageNo."<br/>";
    }

    function GetCatalogItemByArtnumber($ARTNUMBER = ""){
      $ARTNUMBER = trim($ARTNUMBER);
      $res = \Bitrix\Iblock\ElementTable::getList(
        array(
          "select" => array("ID", "IBLOCK_ID", "NAME", "CODE"),
          "filter" => array(
            "IBLOCK_ID" => $this->CATALOG_IBLOCK_ID,
            "NAME" => "%$ARTNUMBER%",
          ),
        )
      );
      if($arItem = $res->fetch())
        _D($arItem);
      else
        return false;
    }

  }
?>