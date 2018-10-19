<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);

CJSCore::Init(array("fx"));

if (file_exists($_SERVER["DOCUMENT_ROOT"] . $this->GetFolder() . '/themes/' . $arParams["TEMPLATE_THEME"] . '/colors.css'))
    $APPLICATION->SetAdditionalCSS($this->GetFolder() . '/themes/' . $arParams["TEMPLATE_THEME"] . '/colors.css');
?>
<?
// Адрес для корректного срабатывания фильтра
$requestUri = $_SERVER['REQUEST_URI'];
$requestUriArr = explode('?', $requestUri);
$uriArr = Array();
$arrLevel1 = explode('&', $requestUriArr[1]);
foreach ($arrLevel1 as $key => $val) {
    $arrLevel2 = explode('=', $val);
    $uriArr[$key] = $arrLevel2;
}
?>

<?
// Выберем в массив весь дополнительный функционал группы с идентификатором $ID
$ID = 3;
// подключаем модули
CModule::IncludeModule('iblock');
CModule::IncludeModule('highloadblock');

// необходимые классы
use Bitrix\Highloadblock as HL;
use Bitrix\Main\Entity;

// hlblock у нас первый ), $hlblock - это массив
$hlblock = HL\HighloadBlockTable::getById(3)->fetch();

// получаем сущность для работы с новым HL-блоком статей
// (тип $entity - Bitrix\Main\Entity\Base)
// меня сперва накрыло, см. ниже, но потом разъяснилось:
// в этом месте еще одно важное действие происходит:
// если класс датаМенеджер для работы с HL-инфоблоком не создан, то он в этом месте
// создается автоматически через eval(), т.е. тут у меня создается класс
// $entity_data_class.'Table' равный 'ArticlesTable'
$entity = HL\HighloadBlockTable::compileEntity($hlblock);

// затем получаем объект DataManager для работы с данными
// $entity_data_class - это строка (!!!!) ArticlesTable
//
// (ОООООО!) вот тут меня накрыло:
//--------- а как методы то вызываются, автозагрузчик все делает
//--------- и создает класс ArticlesTable?
//
// ответ нашел - можно самому сделать класс ArticlesTable с нужными мне методами,
// либо он будет создан, в методе HighloadBlockTable::compileEntity()
$entity_data_class = $entity->getDataClass();

// такой вот комментарий для eclipse, чтобы подсказки работали
/* $entity_data_class Bitrix\Main\Entity\DataManager */
/*
  $rs = CIBlockElement::GetList(
  array('ID' => 'ASC'),
  array('IBLOCK_ID' => 3),
  false, false,
  array('UF_NAME', 'UF_XML_ID', 'UF_FILE')
  );
 */
$resource = $entity_data_class::GetList(array(
            'select' => array('ID', 'UF_NAME', 'UF_XML_ID', 'UF_FILE'),
            'order' => array('ID' => 'ASC'),
            'filter' => array()
        ));
$colorsData = array();
while ($res = $resource->Fetch()) {
    $colorsData[] = array(
        "ID" => $res["ID"],
        "NAME" => strtolower($res["UF_NAME"]),
        "XML_ID" => $res["pearlblue"],
        "IMAGE" => CFile::GetPath($res["UF_FILE"]),
    );
}
?>

<div class="bx_filter_vertical bx_<?= $arParams["TEMPLATE_THEME"] ?>">

    <div class="bx_filter_section m4">
        <h2>Поиск по</h2>
        <form name="<? echo $arResult["FILTER_NAME"] . "_form" ?>" action="<? echo $arResult["FORM_ACTION"] ?>" method="get" class="smartfilter">
            <? foreach ($arResult["HIDDEN"] as $arItem): ?>
                <input type="hidden" name="<? echo $arItem["CONTROL_NAME"] ?>" id="<? echo $arItem["CONTROL_ID"] ?>" value="<? echo $arItem["HTML_VALUE"] ?>" />
            <? endforeach; ?>

            <div class="bx_filter_container">
                <dl class="narrow-by">
                    <?
                    foreach ($arResult["ITEMS"] as $key => $arItem):
                        $key = md5($key);
                        if (isset($arItem["PRICE"])):
                            if (!$arItem["VALUES"]["MIN"]["VALUE"] || !$arItem["VALUES"]["MAX"]["VALUE"] || $arItem["VALUES"]["MIN"]["VALUE"] == $arItem["VALUES"]["MAX"]["VALUE"])
                                continue;
                            ?>

                            <? /* [Фильтрация по цене - не используем]
                              <div class="bx_filter_container price">
                              <span class="bx_filter_container_title">
                              <span class="bx_filter_container_modef"></span>
                              <?=$arItem["NAME"]?>
                              </span>
                              <div class="bx_filter_param_area">
                              <div class="bx_filter_param_area_block">
                              <div class="bx_input_container">
                              <input
                              class="min-price"
                              type="text"
                              name="<?echo $arItem["VALUES"]["MIN"]["CONTROL_NAME"]?>"
                              id="<?echo $arItem["VALUES"]["MIN"]["CONTROL_ID"]?>"
                              value="<?echo $arItem["VALUES"]["MIN"]["HTML_VALUE"]?>"
                              size="5"
                              onkeyup="smartFilter.keyup(this)"
                              />
                              </div>
                              </div>
                              <div class="bx_filter_param_area_block">
                              <div class="bx_input_container">
                              <input
                              class="max-price"
                              type="text"
                              name="<?echo $arItem["VALUES"]["MAX"]["CONTROL_NAME"]?>"
                              id="<?echo $arItem["VALUES"]["MAX"]["CONTROL_ID"]?>"
                              value="<?echo $arItem["VALUES"]["MAX"]["HTML_VALUE"]?>"
                              size="5"
                              onkeyup="smartFilter.keyup(this)"
                              />
                              </div>
                              </div>
                              </div>
                              <div class="bx_ui_slider_track" id="drag_track_<?=$key?>">
                              <div class="bx_ui_slider_range" style="left: 0; right: 0%;"  id="drag_tracker_<?=$key?>"></div>
                              <a class="bx_ui_slider_handle left"  href="javascript:void(0)" style="left:0;" id="left_slider_<?=$key?>"></a>
                              <a class="bx_ui_slider_handle right" href="javascript:void(0)" style="right:0%;" id="right_slider_<?=$key?>"></a>
                              </div>
                              <div class="bx_filter_param_area">
                              <div class="bx_filter_param_area_block" id="curMinPrice_<?=$key?>">
                              <?
                              if (isset($arItem["VALUES"]["MIN"]["CURRENCY"]))
                              echo CCurrencyLang::CurrencyFormat($arItem["VALUES"]["MIN"]["VALUE"], $arItem["VALUES"]["MIN"]["CURRENCY"], false);
                              else
                              echo $arItem["VALUES"]["MIN"]["VALUE"];
                              ?>
                              </div>

                              <div class="bx_filter_param_area_block" id="curMaxPrice_<?=$key?>">
                              <?
                              if (isset($arItem["VALUES"]["MAX"]["CURRENCY"]))
                              echo CCurrencyLang::CurrencyFormat($arItem["VALUES"]["MAX"]["VALUE"], $arItem["VALUES"]["MAX"]["CURRENCY"], false);
                              else
                              echo $arItem["VALUES"]["MAX"]["VALUE"];
                              ?>
                              </div>
                              </div>
                              </div>

                              <script type="text/javascript">
                              var DoubleTrackBar<?=$key?> = new cDoubleTrackBar('drag_track_<?=$key?>', 'drag_tracker_<?=$key?>', 'left_slider_<?=$key?>', 'right_slider_<?=$key?>', {
                              OnUpdate: function(){
                              BX("<?echo $arItem["VALUES"]["MIN"]["CONTROL_ID"]?>").value = this.MinPos;
                              BX("<?echo $arItem["VALUES"]["MAX"]["CONTROL_ID"]?>").value = this.MaxPos;
                              },
                              Min: parseFloat(<?=$arItem["VALUES"]["MIN"]["VALUE"]?>),
                              Max: parseFloat(<?=$arItem["VALUES"]["MAX"]["VALUE"]?>),
                              MinInputId : BX('<?echo $arItem["VALUES"]["MIN"]["CONTROL_ID"]?>'),
                              MaxInputId : BX('<?echo $arItem["VALUES"]["MAX"]["CONTROL_ID"]?>'),
                              FingerOffset: 10,
                              MinSpace: 1,
                              RoundTo: 0.01,
                              Precision: 2
                              });
                              </script>
                             */ ?>

                            <?
                        endif;
                    endforeach;

                    foreach ($arResult["ITEMS"] as $key => $arItem):
                        if ($arItem["PROPERTY_TYPE"] == "N"):

                            if (!$arItem["VALUES"]["MIN"]["VALUE"] || !$arItem["VALUES"]["MAX"]["VALUE"] || $arItem["VALUES"]["MIN"]["VALUE"] == $arItem["VALUES"]["MAX"]["VALUE"])
                                continue;
                            ?>
                            <? /* [Фильтрация по цене - не используем]
                              <div class="bx_filter_container price">
                              <span class="bx_filter_container_title">
                              <span class="bx_filter_container_modef"></span>
                              <?=$arItem["NAME"]?>
                              </span>
                              <div class="bx_filter_param_area">
                              <div class="bx_filter_param_area_block">
                              <div class="bx_input_container">
                              <input
                              class="min-price"
                              type="text"
                              name="<?echo $arItem["VALUES"]["MIN"]["CONTROL_NAME"]?>"
                              id="<?echo $arItem["VALUES"]["MIN"]["CONTROL_ID"]?>"
                              value="<?echo $arItem["VALUES"]["MIN"]["HTML_VALUE"]?>"
                              size="5"
                              onkeyup="smartFilter.keyup(this)"
                              />
                              </div>
                              </div>
                              <div class="bx_filter_param_area_block">
                              <div class="bx_input_container">
                              <input
                              class="max-price"
                              type="text"
                              name="<?echo $arItem["VALUES"]["MAX"]["CONTROL_NAME"]?>"
                              id="<?echo $arItem["VALUES"]["MAX"]["CONTROL_ID"]?>"
                              value="<?echo $arItem["VALUES"]["MAX"]["HTML_VALUE"]?>"
                              size="5"
                              onkeyup="smartFilter.keyup(this)"
                              />
                              </div>
                              </div>
                              </div>

                              <div class="bx_ui_slider_track" id="drag_track_<?=$key?>">
                              <div class="bx_ui_slider_range" style="left: 0; right: 0%;"  id="drag_tracker_<?=$key?>"></div>
                              <a class="bx_ui_slider_handle left"  href="javascript:void(0)" style="left:0;" id="left_slider_<?=$key?>"></a>
                              <a class="bx_ui_slider_handle right" href="javascript:void(0)" style="right:0%;" id="right_slider_<?=$key?>"></a>
                              </div>

                              <div class="bx_filter_param_area">
                              <div class="bx_filter_param_area_block" id="curMinPrice_<?=$key?>"><?=$arItem["VALUES"]["MIN"]["VALUE"]?></div>
                              <div class="bx_filter_param_area_block" id="curMaxPrice_<?=$key?>"><?=$arItem["VALUES"]["MAX"]["VALUE"]?></div>
                              </div>

                              </div>
                              <script type="text/javascript">
                              var DoubleTrackBar<?=$key?> = new cDoubleTrackBar('drag_track_<?=$key?>', 'drag_tracker_<?=$key?>', 'left_slider_<?=$key?>', 'right_slider_<?=$key?>', {
                              OnUpdate: function(){
                              BX("<?echo $arItem["VALUES"]["MIN"]["CONTROL_ID"]?>").value = this.MinPos;
                              BX("<?echo $arItem["VALUES"]["MAX"]["CONTROL_ID"]?>").value = this.MaxPos;
                              },
                              Min: parseFloat(<?=$arItem["VALUES"]["MIN"]["VALUE"]?>),
                              Max: parseFloat(<?=$arItem["VALUES"]["MAX"]["VALUE"]?>),
                              MinInputId : BX('<?echo $arItem["VALUES"]["MIN"]["CONTROL_ID"]?>'),
                              MaxInputId : BX('<?echo $arItem["VALUES"]["MAX"]["CONTROL_ID"]?>'),
                              FingerOffset: 10,
                              MinSpace: 0.01,
                              RoundTo: 0.01,
                              Precision: 6
                              });
                              </script>
                             */ ?>
                        <? elseif (!empty($arItem["VALUES"]) && !isset($arItem["PRICE"])): ?>
                            <? /*
                              echo "<pre>";
                              print_r($arItem);
                              echo "</pre>";
                             */ ?>

                            <? if ($arItem["CODE"] == 'COLOR_REF') { ?>
                                <?
                                $isFilteredColor = false;
                                $filteredColorName = '';
                                foreach ($arItem["VALUES"] as $val => $ar):
                                    ?>
                                    <?
                                    $ar["FILTER_NAME"] = $ar["CONTROL_ID"];
                                    $ar["FILTER_NAME_EACH"] = "arrFilter_" . $arItem["ID"] . "_";
                                    $ar["FILTER_NAME_ALL"] = "arrFilter_";
                                    $priceSortUri = array();
                                    $priceSortUriAll = array();


                                    foreach ($uriArr as $key => $val) {

                                        if ($val[0] == 'set_filter') {
                                            continue;
                                        }

                                        // Сброс всех фильтров
                                        if (
                                                false === strpos($val[0], $ar["FILTER_NAME_ALL"])
                                        ) {
                                            if (!empty($val[0]) && $val[0] != '') {
                                                $priceSortUriAll[$key] = $val[0] . "=" . $val[1];
                                            }
                                        }
                                        // Сброс только текущего фильтра
                                        if (
                                                false === strpos($val[0], $ar["FILTER_NAME_EACH"])
                                        ) {
                                            if (!empty($val[0]) && $val[0] != '') {
                                                $priceSortUri[$key] = $val[0] . "=" . $val[1];
                                            }
                                        }
                                        if (
                                                false !== strpos($val[0], $ar["FILTER_NAME"])
                                        ) {
                                            $isFilteredColor = true;
                                            $filteredColorName = $ar["VALUE"];
                                        }
                                    }
                                    $printSortUri = (count($priceSortUri) > 0) ? implode('&', $priceSortUri) : '';
                                    $printSortUriAll = (count($priceSortUriAll) > 0) ? implode('&', $priceSortUriAll) : '';

                                    $amp = ($printSortUri == '') ? "" : "&";
                                    $printClearUrl = $requestUriArr[0] . "?" . $printSortUri; // URL без текущего фильтра
                                    $printClearUrlAll = $requestUriArr[0] . "?" . $printSortUriAll;
                                    $amp = $amp . $ar["CONTROL_NAME"];
                                    $printSortUrl = $requestUriArr[0] . "?" . $printSortUri . $amp . "=Y";
                                    ?>

                                    <?
                                    $color = strtolower($ar["VALUE"]);
                                    $currentColor = array();
                                    foreach ($colorsData as $key => $val) {
                                        if ($val["NAME"] == $color) {
                                            $currentColor = array(
                                                "ID" => $val["ID"],
                                                "NAME" => $val["NAME"],
                                                "XML_ID" => $val["XML_ID"],
                                                "IMAGE" => $val["IMAGE"],
                                                "CONTROL_NAME" => $ar["CONTROL_NAME"],
                                                "CONTROL_NAME_ALT" => $ar["CONTROL_NAME_ALT"],
                                                "FILTER_NAME" => "arrFilter_" . $arItem["ID"] . "_",
                                                "printClearUrl" => $printClearUrl,
                                                "printSortUrl" => $printSortUrl,
                                            );
                                        }
                                    }
                                    ?>

                                    <?
                                    $parseArr[] = array(
                                        "DATA" => $currentColor
                                    );
                                    ?>
                                <? endforeach; ?>
                                <dt>
                                <span class="bx_filter_container_title" onclick="hideFilterProps(this)">
                                    <span class="bx_filter_container_modef"></span>
                                    <?= $arItem["NAME"] ?>: <? if (!empty($filteredColorName)) { ?><?= $filteredColorName ?><? } ?>
                                </span>
                                </dt>
                                <dd>
                                    <div class="bx_filter_block">
                                        <?
                                        $count = 0;
                                        $length = count($arItem["VALUES"]);
                                        foreach ($parseArr as $val => $ar):
                                            ?>
                                            <? if (!$isFilteredColor) { ?>
                                                <?
                                                if ($count == 0) {
                                                    ?>
                                                    <ol class="narrow-by-color swatches">
                                                        <?
                                                    }
                                                    ?>
                                                    <li>

                                                        <a href="<?= $ar["DATA"]["printSortUrl"] ?>&set_filter=Y" title="<?= $ar["DATA"]["NAME"] ?>"><? /* [title="<?=$ar["FILTER_NAME"]?>"] */ ?>

                                                            <label>
                                                                <span class="<? if (isset($ar["DATA"]["XML_ID"]) && !empty($ar["DATA"]["XML_ID"])) { ?><?= $ar["DATA"]["XML_ID"] ?> <? } ?><? echo $ar["DATA"]["DISABLED"] ? 'disabled' : '' ?>" <? if (isset($ar["DATA"]["IMAGE"]) && !empty($ar["DATA"]["IMAGE"])) { ?>style="background: transparent url(<?= $ar["DATA"]["IMAGE"] ?>);"<? } ?>>
                                                                    <? /*
                                                                      <input
                                                                      type="checkbox"
                                                                      value="<?echo $ar["HTML_VALUE"]?>"
                                                                      name="<?echo $ar["CONTROL_NAME"]?>"
                                                                      id="<?echo $ar["CONTROL_ID"]?>"
                                                                      <?echo $ar["CHECKED"]? 'checked="checked"': ''?>
                                                                      <?  onclick="smartFilter.click(this)"  ?>
                                                                      />
                                                                      <?echo $ar["VALUE"];?>
                                                                     */ ?>
                                                                </span>
                                                            </label>

                                                        </a>

                                                    </li>

                                                    <?
                                                    if ($count == ($length - 1)) {
                                                        ?>
                                                    </ol>
                                                    <?
                                                }
                                                ?>
                                            <? } else { ?>
                                                <? if ($count > 0) continue; ?>
                                                <a class="btn-remove" href="<?= $ar["DATA"]["printClearUrl"] ?>">Сбросить цвет</a>

                                            <? } ?>
                                            <?
                                            $count++;
                                        endforeach;
                                        ?>
                                    </div>
                                </dd>

                            <? } elseif ($arItem["CODE"] == 'SPORT_TYPE') { ?>

                                <?
                                $count = 0;
                                $length = count($arItem["VALUES"]);
                                $isFilteredSport = false;

                                foreach ($arItem["VALUES"] as $val => $ar):
                                    ?>

                                    <?
                                    $ar["FILTER_NAME"] = $ar["CONTROL_ID"];
                                    $ar["FILTER_NAME_EACH"] = "arrFilter_" . $arItem["ID"] . "_";
                                    $ar["FILTER_NAME_ALL"] = "arrFilter_";
                                    $priceSortUri = array();
                                    $priceSortUriAll = array();
                                    foreach ($uriArr as $key => $val) {
                                        // Сброс всех фильтров
                                        if (
                                                false === strpos($val[0], $ar["FILTER_NAME_ALL"])
                                        ) {
                                            if (!empty($val[0]) && $val[0] != '') {
                                                $priceSortUriAll[$key] = $val[0] . "=" . $val[1];
                                            }
                                        }
                                        // Сброс только текущего фильтра
                                        if (
                                                false === strpos($val[0], $ar["FILTER_NAME_EACH"])
                                        ) {
                                            if (!empty($val[0]) && $val[0] != '') {
                                                $priceSortUri[$key] = $val[0] . "=" . $val[1];
                                            }
                                        }

                                        if (
                                                false !== strpos($val[0], $ar["FILTER_NAME"])
                                        ) {
                                            $isFilteredSport = true;
                                            $filteredColorName = $ar["VALUE"];
                                        }
                                    }

                                    $printSortUri = (count($priceSortUri) > 0) ? implode('&', $priceSortUri) : '';
                                    $printSortUriAll = (count($priceSortUriAll) > 0) ? implode('&', $priceSortUriAll) : '';

                                    $amp = ($printSortUri == '') ? "" : "&";
                                    $printClearUrl = $requestUriArr[0] . "?" . $printSortUri; // URL без текущего фильтра
                                    $printClearUrlAll = $requestUriArr[0] . "?" . $printSortUriAll;
                                    $amp = $amp . $ar["CONTROL_NAME"];
                                    $printSortUrl = $requestUriArr[0] . "?" . $printSortUri . $amp . "=Y";
                                    ?>
                                    <?
                                    $ar_print[] = array(
                                        "VALUE" => $ar["VALUE"],
                                        "DISABLED" => $ar["DISABLED"],
                                        "HTML_VALUE" => $ar["HTML_VALUE"],
                                        "CONTROL_NAME" => $ar["CONTROL_NAME"],
                                        "CONTROL_ID" => $ar["CONTROL_ID"],
                                        "CHECKED" => $ar["CHECKED"],
                                        "printClearUrl" => $printClearUrl,
                                        "printSortUrl" => $printSortUrl
                                    );
                                    ?>
                                    <?
                                    $count++;
                                endforeach;
                                ?>
                                <dt>
                                <span class="bx_filter_container_title" onclick="hideFilterProps(this)">
                                    <span class="bx_filter_container_modef"></span>
                                    <?= $arItem["NAME"] ?>: <? if (!empty($filteredColorName)) { ?><?= $filteredColorName ?><? } ?>
                                </span>
                                </dt>
                                <dd>
                                    <div class="bx_filter_block">
                                        <?
                                        $count = 0;
                                        foreach ($ar_print as $val => $ar):

                                            if (strlen($ar["VALUE"]) <= 0)
                                                continue;
                                            ?>
                                            <? if (!$isFilteredSport) { ?>
                                                <?
                                                if ($count == 0) {
                                                    ?>
                                                    <ol class="narrow-by-category">
                                                        <?
                                                    }
                                                    ?>
                                                    <li>
                                                        <a href="<?= $ar["printSortUrl"]; ?>">
                                                            <? echo $ar["VALUE"]; ?>
                                                            <? /*
                                                              <span class="<?echo $ar["DISABLED"] ? 'disabled': ''?>">
                                                              <label>
                                                              <input
                                                              style="position: absolute; left: -2500px;"
                                                              type="checkbox"
                                                              value="<?echo $ar["HTML_VALUE"]?>"
                                                              name="<?echo $ar["CONTROL_NAME"]?>"
                                                              id="<?echo $ar["CONTROL_ID"]?>"
                                                              <?echo $ar["CHECKED"]? 'checked="checked"': ''?>
                                                              onclick="smartFilter.click(this)"
                                                              /><?echo $ar["VALUE"];?>
                                                              </label>
                                                              </span>
                                                             */ ?>
                                                        </a>
                                                    </li>
                                                    <?
                                                    if ($count == ($length - 1)) {
                                                        ?>
                                                    </ol>
                                                    <?
                                                }
                                                ?>
                                            <? } else { ?>
                                                <? if ($count > 0) continue; ?>
                                                <a class="btn-remove" href="<?= $printClearUrl ?>">Сбросить вид спорта</a>

                                            <? } ?>
                                            <?
                                            $count++;
                                        endforeach;
                                        ?>
                                    </div>
                                </dd>
                            <? } else { ?>
                                <dt>
                                <span class="bx_filter_container_title" onclick="hideFilterProps(this)">
                                    <span class="bx_filter_container_modef"></span>
                                    <?= $arItem["NAME"] ?>
                                </span>
                                </dt>
                                <dd>
                                    <div class="bx_filter_block">
                                        <ol class="narrow-by-category">
                                            <? foreach ($arItem["VALUES"] as $val => $ar): ?>
                                                <li>
                                                    <span class="<? echo $ar["DISABLED"] ? 'disabled' : '' ?>">
                                                        <label for="<? echo $ar["CONTROL_ID"] ?>">
                                                            <input
                                                                type="checkbox"
                                                                value="<? echo $ar["HTML_VALUE"] ?>"
                                                                name="<? echo $ar["CONTROL_NAME"] ?>"
                                                                id="<? echo $ar["CONTROL_ID"] ?>"
                                                                <? echo $ar["CHECKED"] ? 'checked="checked"' : '' ?>
                                                                onclick="smartFilter.click(this)"
                                                                />
                                                            <? echo $ar["VALUE"]; ?></label>
                                                    </span>
                                                </li>
                                            <? endforeach; ?>
                                        </ol>
                                    </div>
                                </dd>
                            <? } ?>

                            <?
                        endif;
                    endforeach;
                    ?>

                </dl>

                <? if ($isFilteredSport or $isFilteredColor) { ?>
                    <p class="currently">
                        <a href="<?= $printClearUrlAll ?>">Сбросить все фильтры</a>
                    </p>
                <? } ?>
            </div>			

            <? /* Кнопки управления фильтром - [Показать] и [Сбросить]
              <div class="bx_filter_control_section">
              <span class="icon"></span><input class="bx_filter_search_button" type="submit" id="set_filter" name="set_filter" value="<?=GetMessage("CT_BCSF_SET_FILTER")?>" />
              <input class="bx_filter_search_button" type="submit" id="del_filter" name="del_filter" value="<?=GetMessage("CT_BCSF_DEL_FILTER")?>" />

              <div class="bx_filter_popup_result left" id="modef" <?if(!isset($arResult["ELEMENT_COUNT"])) echo 'style="display:none"';?> style="display: inline-block;">
              <?echo GetMessage("CT_BCSF_FILTER_COUNT", array("#ELEMENT_COUNT#" => '<span id="modef_num">'.intval($arResult["ELEMENT_COUNT"]).'</span>'));?>
              <span class="arrow"></span>
              <a href="<?echo $arResult["FILTER_URL"]?>"><?echo GetMessage("CT_BCSF_FILTER_SHOW")?></a>
              </div>
              </div>
             */ ?>

        </form>

    </div><!-- [end bx_filter_section] -->

</div>

<script>
    var smartFilter = new JCSmartFilter('<? echo CUtil::JSEscape($arResult["FORM_ACTION"]) ?>');
</script>