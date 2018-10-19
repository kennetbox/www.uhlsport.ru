<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
require_once($_SERVER['DOCUMENT_ROOT']."/bitrix/php_interface/include/phpThumb/phpthumb.class.php");
?>
<?

  function _D($array){
    echo "<pre>";
    var_dump($array);
    echo "</pre>";
  }
  
function MakeImage ($src, $params = "") {
    if (is_numeric($src)) if ($src > 0) $src = CFile::GetPath($src);
    if (file_exists($_SERVER['DOCUMENT_ROOT'].$src)) {
        $ext = pathinfo($_SERVER['DOCUMENT_ROOT'].$src, PATHINFO_EXTENSION);
        $base_name = basename($src, ".".$ext);
        if (!defined("MAKEIMAGE_CODE_GEN_FUNCTION")) define ("MAKEIMAGE_CODE_GEN_FUNCTION", false);
        switch (MAKEIMAGE_CODE_GEN_FUNCTION) { // filesize || md5_file
            case "filesize": $code = md5(serialize($params).filesize($_SERVER['DOCUMENT_ROOT'].$src)); break;
            case "md5_file": $code = md5(serialize($params).md5_file($_SERVER['DOCUMENT_ROOT'].$src)); break;
            default: $code = md5(serialize($params).$_SERVER['DOCUMENT_ROOT'].$src);
        }
        $thumb_file = dirname($src)."/".$base_name."_thumb_".$code.".".$ext;
        if (file_exists($_SERVER['DOCUMENT_ROOT'].$thumb_file)) {
            return $thumb_file;
        } else {
            require_once($_SERVER['DOCUMENT_ROOT']."/bitrix/php_interface/include/phpThumb/phpthumb.class.php"); // Подключаем и иннициализируем phpThumb
            $phpThumb = new phpThumb();
            $phpThumb->src = $src;
            switch ($ext) {
                case "jpg": $phpThumb->f = "jpeg"; break;
                case "gif": $phpThumb->f = "gif"; break;
                case "png": $phpThumb->f = "png"; break;
                default: $phpThumb->f = "jpeg"; break;
            }           
            $phpThumb->q = 60;
            $phpThumb->bg = "ffffff";
            $phpThumb->far = "C";
            $phpThumb->aoe = 0;
            if (is_array($params)) {
                foreach ($params as $param=>$value) {
                    $phpThumb->$param = $value;
                }
            }
            $phpThumb->GenerateThumbnail();
            $success = $phpThumb->RenderToFile($_SERVER['DOCUMENT_ROOT'].$thumb_file);
            if ($success) return $thumb_file; 
            else return false;
        }
    } else {
        return false;
    }
}


function getIdByCode($code, $iblock_id, $type)
{
   if(CModule::IncludeModule("iblock"))
   {
      if($type == 'IBLOCK_ELEMENT')
      {
         $arFilter = array("IBLOCK_ID"=>$iblock_id, "CODE" => $code);
         $res = CIBlockElement::GetList(array(), $arFilter, false, array("nPageSize"=>1), array('ID'));
         $element = $res->Fetch();
         if($res->SelectedRowsCount() != 1) return '<p style="font-weight:bold;color:#ff0000">Элемент не найден</p>';
         else return $element['ID'];
      }
      else if($type == 'IBLOCK_SECTION')
      {
         $res = CIBlockSection::GetList(array(), array('IBLOCK_ID' => $iblock_id, 'CODE' => $code));
         $section = $res->Fetch();
         if($res->SelectedRowsCount() != 1) return 'false';
         else return $section['ID'];
      }
      else
      {
         echo '<p style="font-weight:bold;color:#ff0000">Укажите тип</p>';
         return;
      }
   }
}

/*function custom_mail($to, $subject, $message, $addh = "", $addp = "")
{
    require_once 'PHPMailer-master/class.phpmailer.php';
 
    try {
 
    $mail = new PHPMailer();
 
    // telling the class to use SMTP
    $mail->IsSMTP();
 
    // SMTP server
    $mail->Host = "uhlsport.ru";
 
    // set the SMTP port for the GMAIL
    $mail->Port = 25;
 
    $mail->SMTPAuth   = true;
    //$mail->CharSet = "utf-8";
$mail->CharSet = "Windows-1251";
 
    // SMTP account username
    $mail->Username = "info@uhlsport.ru";
 
    // SMTP account password
    $mail->Password = "2YkwvEdq";
 
    // $mail->SMTPDebug = 2;
 
    $mail->SetFrom('info@uhlsport.ru', 'uhlsport.ru');
    $mail->AddAddress($to);
    $mail->Body = $message;
    $mail->Subject = $subject;
 
    $addh = $mail->HeaderLine('To',
        $mail->EncodeHeader($mail->SecureHeader($to))).$addh;
    //$addh = $mail->HeaderLine('Subject',
    //    $mail->EncodeHeader($mail->SecureHeader($subject))).$addh;
    $mail->Header = $addh."\n";
 
    $status = $mail->Send();
 
    } catch (phpmailerException $e) {
        echo $e->errorMessage();
    } catch (Exception $e) {
        echo $e->getMessage();
    }
 
    return $status;
}*/

function roundPrices() {
	
	$arFields['PRICE'] = ceil($arFields['PRICE']/10)*10;

}



AddEventHandler("currency", "OnCurrencyRateAdd", "roundPrices"); 
AddEventHandler("currency", "OnBeforeCurrencyRateUpdate", "roundPrices"); 

AddEventHandler("catalog", "OnPriceUpdate", "roundPrices"); 
AddEventHandler("catalog", "OnProductAdd", "roundPrices"); 

AddEventHandler("catalog", "OnBeforePriceAdd", "roundPrices"); 
AddEventHandler("catalog", "OnAfterPriceUpdate", "roundPrices"); 

AddEventHandler("sale",   "OnBeforeBasketUpdate",   "roundPrices");
AddEventHandler("sale",   "OnBeforeBasketAdd",   "roundPrices");

?>