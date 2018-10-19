<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>

<? /* Заказ завершен */ ?>

<div class="cart-complete">

    <? if (!empty($arResult["ORDER"])) { ?>

        <h3>Заказ №<?= $arResult["ORDER"]["ID"] ?></h3>

        <p>
            На указанную вами почту будет отпралена копия информации о заказе. Наши менеджеры свяжутся с вами в ближайшее время для подтверждения данных.
        </p>

        <p class="back"><a href="/">На главную страницу</a></p>


        <?
        CModule::IncludeModule("main");
        if (CModule::IncludeModule("sale")) {

            $arUserResult = array();
            $strOrderList = "";
            $strOrderListForUser = "";

            $dbBasketItems = CSaleBasket::GetList(
                            array("ID" => "ASC"), array("ORDER_ID" => IntVal($arResult["ORDER"]["ID"])), false, false, array("ID", "NAME", "QUANTITY", "PRICE", "ORDER_PRICE")
            );
            while ($arBasketItems = $dbBasketItems->Fetch()) {
                $strOrderList .= '<tr><td style="PADDING-BOTTOM:3pt;PADDING-TOP:3pt;PADDING-LEFT:3pt;PADDING-RIGHT:3pt;"><p><a class="daria-goto-anchor" target="_blank" rel="noopener noreferrer">' . $arBasketItems["NAME"] . "</a></p></td>" . '<td style="PADDING-BOTTOM:3pt;PADDING-TOP:3pt;PADDING-LEFT:3pt;PADDING-RIGHT:3pt;"><p>' . $arBasketItems["QUANTITY"] . "</p></td>" . '<td style="PADDING-BOTTOM:3pt;PADDING-TOP:3pt;PADDING-LEFT:3pt;PADDING-RIGHT:3pt;"><p>' . SaleFormatCurrency($arBasketItems["PRICE"], "RUB") . "</p></td></tr>";
                $strOrderList .= "\n";

                $strOrderListForUser .= $arBasketItems["NAME"] . " - " . $arBasketItems["QUANTITY"] . " " . GetMessage("SALE_QUANTITY_UNIT");
                $strOrderListForUser .= "\n";

                $ORDER_PRICE = $arBasketItems["ORDER_PRICE"];
            }
            //echo "<table>";
            //echo $strOrderList;
            // echo "</table>";
            $db_vals = CSaleOrderPropsValue::GetList(
                            array("SORT" => "ASC"), array(
                        "ORDER_ID" => IntVal($arResult["ORDER"]["ID"])
                            )
            );
            while ($arVals = $db_vals->Fetch()) {
                //$arUserResult["USER_FIO"] =
                $values1[] = $arVals;
                //$values[] = $arVals["VALUE"];

                if ($arVals["ORDER_PROPS_ID"] == 1) {
                    $values['USER_FIO'] = $arVals["VALUE"];
                }
                if ($arVals["ORDER_PROPS_ID"] == 2) {
                    $values['USER_EMAIL'] = $arVals["VALUE"];
                }
                if ($arVals["ORDER_PROPS_ID"] == 3) {
                    $values['USER_PHONE'] = $arVals["VALUE"];
                }
                if ($arVals["ORDER_PROPS_ID"] == 4) {
                    $values['USER_INDEX'] = $arVals["VALUE"];
                }
                if ($arVals["ORDER_PROPS_ID"] == 5) {
                    $values['USER_CITY'] = $arVals["VALUE"];
                }
                if ($arVals["ORDER_PROPS_ID"] == 6) {
                    
                }
                if ($arVals["ORDER_PROPS_ID"] == 21) {
                    $values['USER_NEW_ARRIVALS'] = $arVals["VALUE"];
                }
                if ($arVals["ORDER_PROPS_ID"] == 22) {
                    $values['USER_FROM_GERMANY'] = $arVals["VALUE"];
                }
                if ($arVals["ORDER_PROPS_ID"] == 23) {
                    $values['USER_STREET'] = $arVals["VALUE"];
                }
                if ($arVals["ORDER_PROPS_ID"] == 24) {
                    $values['USER_HOUSE'] = $arVals["VALUE"];
                }
                if ($arVals["ORDER_PROPS_ID"] == 25) {
                    $values['USER_BILDING'] = $arVals["VALUE"];
                }
                if ($arVals["ORDER_PROPS_ID"] == 26) {
                    $values['USER_CORP'] = $arVals["VALUE"];
                }
                if ($arVals["ORDER_PROPS_ID"] == 27) {
                    $values['USER_FLAT'] = $arVals["VALUE"];
                }
                if ($arVals["ORDER_PROPS_ID"] == 28) {
                    $values['ORDER_DESCRIPTION'] = $arVals["VALUE"];
                }
                if ($arVals["ORDER_PROPS_ID"] == 29) {
                    $values['SEND_MAIL'] = $arVals["VALUE"];
                    $values['SEND_MAIL_ID'] = $arVals["ID"];
                }

                //echo "<pre>"; print_r($arVals); echo "</pre>";
            }

            $arUserResult["ORDER_ID"] = $arResult["ORDER"]["ID"];

            $arUserResult["ORDER_USER"] = ( (strlen($arResult["PAYER_NAME"]) > 0) ? $arResult["PAYER_NAME"] : $USER->GetFormattedName(false) );
            $arUserResult["PRICE"] = SaleFormatCurrency($ORDER_PRICE, $arResult["BASE_LANG_CURRENCY"]);
            $arUserResult["BCC"] = COption::GetOptionString("sale", "order_email", "order@" . $SERVER_NAME);
            $arUserResult["EMAIL"] = $arResult["ORDER"]["USER_EMAIL"];
            $arUserResult["ORDER_LIST"] = $strOrderList;
            $arUserResult["SALE_EMAIL"] = COption::GetOptionString("sale", "order_email", "order@" . $SERVER_NAME);

            $arUserResult["USER_FIO"] = $values['USER_FIO'];
            $arUserResult["USER_EMAIL"] = $values['USER_EMAIL'];
            $arUserResult["USER_PHONE"] = $values['USER_PHONE'];
            $arUserResult["USER_INDEX"] = $values['USER_INDEX'];
            $arUserResult["USER_CITY"] = $values['USER_CITY'];
            $arUserResult["USER_NEW_ARRIVALS"] = ($values['USER_NEW_ARRIVALS'] == "Y") ? "Да" : "Нет";
            $arUserResult["USER_FROM_GERMANY"] = ($values['USER_FROM_GERMANY'] == "Y") ? "Да" : "Нет";
            $arUserResult["USER_STREET"] = $values['USER_STREET'];
            $arUserResult["USER_HOUSE"] = $values['USER_HOUSE'];
            $arUserResult["USER_BILDING"] = $values['USER_BILDING'];
            $arUserResult["USER_CORP"] = $values['USER_CORP'];
            $arUserResult["USER_FLAT"] = $values['USER_FLAT'];
            $arUserResult["ORDER_DESCRIPTION"] = $values['ORDER_DESCRIPTION'];

            $arUserResult["SEND_MAIL"] = isset($values['SEND_MAIL']) ? $values['SEND_MAIL'] : "N";

            $arUserResult["PRICE"] = $arUserResult["PRICE"];
            $arUserResult["SITE_NAME"] = 'shockdoctor';
            $arUserResult["ORDER_FORMATED"] = $strOrderListForUser;

            $comment = CSaleOrder::GetByID($arUserResult["ORDER_ID"]);
            $arUserResult["ORDER_DATE"] = /* Date($DB->DateFormatToPHP(CLang::GetDateFormat("SHORT", SITE_ID))) */$comment["DATE_STATUS_FORMAT"];
            $arUserResult["COMMENT"] = $comment["USER_DESCRIPTION"];


            $arloc = CSaleLocation::GetList(
                            array("SORT" => "ASC", "COUNTRY_NAME_LANG" => "ASC", "CITY_NAME_LANG" => "ASC"), array('CITY_NAME' => $arUserResult["USER_CITY"], "LID" => LANGUAGE_ID), false, false, array()
            );
            if ($res = $arloc->Fetch()) {
                $location = $res["COUNTRY_NAME"] . ", " . $res["REGION_NAME"] . ", " . $res["CITY_NAME"];
                $arUserResult["USER_LAND"] = $res["COUNTRY_NAME"];
            }
            $arUserResult["LOCATION"] = $location;



            /* CEvent::SendImmediate(
              'SALE_NEW_ORDER',
              'sh',
              $arUserResult,
              'N',
              55
              );
             */
            if ($arUserResult["SEND_MAIL"] == "N") {

                $arFields = array(
                    "ORDER_ID" => $arUserResult["ORDER_ID"],
                    "ORDER_PROPS_ID" => 29,
                    "NAME" => "Отправка почты",
                    "CODE" => "SEND_MAIL",
                    "VALUE" => "Y"
                );

                $res = CSaleOrderPropsValue::Add($arFields);
                //echo $res;
                /* $arFields = array(

                  "VALUE" => "Y"
                  );

                  $result = CSaleOrderPropsValue::Update($values['SEND_MAIL_ID'],$arFields); */
                if ($res) {
                    CEvent::SendImmediate(
                            'SALE_NEW_ORDER_NEW', 'sh', $arUserResult, 'N'
                    );
                } else {
                    
                }
            } else {
                
            }

            /* $bSend = true;
              foreach(GetModuleEvents("sale", "OnOrderNewSendEmail", true) as $arEvent)
              if (ExecuteModuleEventEx($arEvent, Array($arUserResult["ORDER_ID"], &$eventName, &$arFields))===false)
              $bSend = false;

              if($bSend)
              {

              $event = new CEvent;
              $send = $event->Send('SALE_NEW_ORDER', SITE_ID, $arUserResult, "N");
              echo $send;
              } */
        }
        ?>



        <? /*
          <?= str_replace("#ORDER_DATE#", $arResult["ORDER"]["DATE_INSERT_FORMATED"], str_replace("#ORDER_ID#", $arResult["ORDER"]["ACCOUNT_NUMBER"], GetMessage("STOF_ORDER_CREATED_DESCR"))); ?>

          <?= str_replace("#LINK#", $arParams["PATH_TO_PERSONAL"], GetMessage("STOF_ORDER_VIEW")) ?>
         */ ?>

        <?
        /*
          if (!empty($arResult["PAY_SYSTEM"])) {
          ?>

          <?echo GetMessage("STOF_ORDER_PAY_ACTION")?>

          <?echo GetMessage("STOF_ORDER_PAY_ACTION1")?> <?= $arResult["PAY_SYSTEM"]["NAME"] ?>

          <?
          if (strlen($arResult["PAY_SYSTEM"]["ACTION_FILE"]) > 0)
          {
          ?>

          <?
          if ($arResult["PAY_SYSTEM"]["NEW_WINDOW"] == "Y")
          {
          ?>
          <script language="JavaScript">
          window.open('<?=$arParams["PATH_TO_PAYMENT"]?>?ORDER_ID=<?=urlencode(urlencode($arResult["ORDER"]["ACCOUNT_NUMBER"]))?>');
          </script>
          <?= str_replace("#LINK#", $arParams["PATH_TO_PAYMENT"]."?ORDER_ID=".urlencode(urlencode($arResult["ORDER"]["ACCOUNT_NUMBER"])), GetMessage("STOF_ORDER_PAY_WIN")) ?>
          <?
          }
          else
          {
          if (strlen($arResult["PAY_SYSTEM"]["PATH_TO_ACTION"])>0)
          {
          include($arResult["PAY_SYSTEM"]["PATH_TO_ACTION"]);
          }
          }
          ?>

          <?
          }
          ?>

          <?
          }
         */
        ?>

    <? } else { ?>

        <? echo GetMessage("STOF_ERROR_ORDER_CREATE") ?>

        <?= str_replace("#ORDER_ID#", $arResult["ORDER_ID"], GetMessage("STOF_NO_ORDER")) ?>
        <?= GetMessage("STOF_CONTACT_ADMIN") ?>

    <? } ?>

    <? /*
      <?= str_replace("#LINK#", $arParams["PATH_TO_PERSONAL"], GetMessage("STOF_ORDER_VIEW")) ?><br /><br />
      <?= str_replace("#LINK#", $arParams["PATH_TO_PERSONAL"], GetMessage("STOF_ANNUL_NOTES")) ?><br /><br />
      <?= str_replace("#ORDER_ID#", $arResult["ORDER_ID"], GetMessage("STOF_ORDER_ID_NOTES")) ?>
     */ ?>

</div>
<? //$arProp = CSaleOrderProps::GetList(array(), array('CODE' => 'SEND_MAIL'))->Fetch(); ?>
<? //echo "<pre>";print_r($values1); echo "</pre>"; ?>
<?
//echo "<pre>";print_r($arUserResult["COMMENT"]); echo "</pre>";?>