<?
	namespace UHL;

  use \Bitrix\Main\Loader;

  Loader::registerAutoLoadClasses(null, array("\UHL\MasterImport" => "/local/classes/master.import.php",));

  /**
   * 	Импорт остатков каталога и обновление цен
   */
  class CatalogImport extends MasterImport
  {
    const BRAND = "UHLSPORT";
    protected $CATALOG_IBLOCK_ID = 2;
    protected $OFFERS_IBLOCK_ID = 16;
    protected $nodeBrandID = "00134";
    protected $nodePriceID = "00004";
    protected $nodeMinPriceID = "00012";
    protected $nodeMaxPriceID = "MaximumPrice";

    
    function Import($importFilePath)
    {
      // Тип выгрузки
      $this->GetImportType($importFilePath);

      // Номер выгрузки
      $this->GetMessageNo();

      $this->XML = new \XMLReader();
      $this->XML->open($importFilePath);

      $DOM = new \DOMDocument;

      while($this->XML->read()) {
        if($this->XML->nodeType != \XMLReader::ELEMENT) continue;

        // Структура элемента
        if($this->XML->localName == "offer"){
          
          $node = simplexml_import_dom($DOM->importNode($this->XML->expand(),true));
          
          $basePrice = "0";
          $minPrice = "0";
          $maxPrice = "0";
          $nodePrevName = "";
          // Получение цен
          while($this->XML->read()) {
            if($this->XML->nodeType == \XMLReader::ELEMENT) {
              if($this->XML->localName == 'priceId'){
                $price = trim($this->XML->expand()->nodeValue);
                if($this->XML->getAttribute('id') == $this->nodePriceID)
                  $basePrice = $price;
                if($this->XML->getAttribute('id') == $this->nodeMinPriceID)
                  $minPrice = $price;
                if($this->XML->getAttribute('id') == $this->nodeMaxPriceID)
                  $maxPrice = $price;
              }
              elseif($nodePrevName == "priceId") break;
              $nodePrevName  = $this->XML->localName;
            }
          }

          $brand = "";
          // Получение искомых элементов по BRAND
          while($this->XML->read()) {
            if($this->XML->nodeType == \XMLReader::ELEMENT) {
              if(($this->XML->localName == 'prop')&&($this->XML->getAttribute('id') == $this->nodeBrandID)) {
                if ($this->XML->expand()->nodeValue == CatalogImport::BRAND) {
                  $arLoadFields = array(
                    "TIMESTAMP_X" => "now()",
                    "XML_ID" => $node->uid,
                    "NAME" => $node->name,
                    // "BASE_PRICE" => $basePrice
                  );
                  echo $this->GetCatalogItemByArtnumber($node->article);
                  _D($node);
                }
                break;
              }
            }
          }

          // Далее по списку

        }

      }
      
    }
  }

?>