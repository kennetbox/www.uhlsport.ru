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

$templateData = array(
    'TEMPLATE_THEME' => $this->GetFolder() . '/themes/' . $arParams['TEMPLATE_THEME'] . '/style.css',
    'TEMPLATE_CLASS' => 'bx_' . $arParams['TEMPLATE_THEME']
);

$strMainID = $this->GetEditAreaId($arResult['ID']);
$arItemIDs = array(
    'ID' => $strMainID,
    'PICT' => $strMainID . '_pict',
    'DISCOUNT_PICT_ID' => $strMainID . '_dsc_pict',
    'STICKER_ID' => $strMainID . '_sticker',
    'BIG_SLIDER_ID' => $strMainID . '_big_slider',
    'BIG_IMG_CONT_ID' => $strMainID . '_bigimg_cont',
    'SLIDER_CONT_ID' => $strMainID . '_slider_cont',
    'SLIDER_LIST' => $strMainID . '_slider_list',
    'SLIDER_LEFT' => $strMainID . '_slider_left',
    'SLIDER_RIGHT' => $strMainID . '_slider_right',
    'OLD_PRICE' => $strMainID . '_old_price',
    'PRICE' => $strMainID . '_price',
    'DISCOUNT_PRICE' => $strMainID . '_price_discount',
    'SLIDER_CONT_OF_ID' => $strMainID . '_slider_cont_',
    'SLIDER_LIST_OF_ID' => $strMainID . '_slider_list_',
    'SLIDER_LEFT_OF_ID' => $strMainID . '_slider_left_',
    'SLIDER_RIGHT_OF_ID' => $strMainID . '_slider_right_',
    'QUANTITY' => $strMainID . '_quantity',
    'QUANTITY_DOWN' => $strMainID . '_quant_down',
    'QUANTITY_UP' => $strMainID . '_quant_up',
    'QUANTITY_MEASURE' => $strMainID . '_quant_measure',
    'QUANTITY_LIMIT' => $strMainID . '_quant_limit',
    'BUY_LINK' => $strMainID . '_buy_link',
    'ADD_BASKET_LINK' => $strMainID . '_add_basket_link',
    'COMPARE_LINK' => $strMainID . '_compare_link',
    'PROP' => $strMainID . '_prop_',
    'PROP_DIV' => $strMainID . '_skudiv',
    'DISPLAY_PROP_DIV' => $strMainID . '_sku_prop',
    'OFFER_GROUP' => $strMainID . '_set_group_',
    'BASKET_PROP_DIV' => $strMainID . '_basket_prop',
);
$strObName = 'ob' . preg_replace("/[^a-zA-Z0-9_]/", "x", $strMainID);
$templateData['JS_OBJ'] = $strObName;

$strTitle = (
        isset($arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_TITLE"]) && '' != $arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_TITLE"] ? $arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_TITLE"] : $arResult['NAME']
        );
$strAlt = (
        isset($arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_ALT"]) && '' != $arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_ALT"] ? $arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_ALT"] : $arResult['NAME']
        );
?>

<?
global $arrFilter;
?>

<div id="messages_product_view"></div>
<div class="product-details" itemtype="http://schema.org/Product" itemscope="">

    <div class="product-intro">

        <div class="bx_item_detail <? echo $templateData['TEMPLATE_CLASS']; ?>" id="<? echo $arItemIDs['ID']; ?>">

            <?
            reset($arResult['MORE_PHOTO']);
            $arFirstPhoto = current($arResult['MORE_PHOTO']);
            $arResultVideo = $arResult["PROPERTIES"]["VIDEO_IFRAME_YOUTUBE"]["VALUE"];
            ?>
            <div class="bx_item_container">
                <div class="bx_lt product-attributes">

                    <?
// Название товара
                    if ('Y' == $arParams['DISPLAY_NAME']) {
                        ?>
                        <p itemprop="name" class="product-attributes-name">
                            <?
                            echo (
                            isset($arResult["IPROPERTY_VALUES"]["ELEMENT_PAGE_TITLE"]) && '' != $arResult["IPROPERTY_VALUES"]["ELEMENT_PAGE_TITLE"] ? $arResult["IPROPERTY_VALUES"]["ELEMENT_PAGE_TITLE"] : $arResult["NAME"]
                            );
                            ?>
                        </p>
                        <?
                    }
                    ?>

                    <? /* [Цена] */ ?>

                    <div class="item_price">
                        <h2>
                            <span class="price-box" itemtype="http://schema.org/Offer" itemscope="">

                                <?
                                $boolDiscountShow = (0 < $arResult['MIN_PRICE']['DISCOUNT_DIFF']);
                                ?>

                                <span class="old-price">
                                    <?
                                    if (
                                            !empty($arResult["OFFERS"][0]["PROPERTIES"]["OLD_PRICE"]["VALUE"]) &&
                                            $arResult["OFFERS"][0]["PROPERTIES"]["OLD_PRICE"]["VALUE"] > 0
                                    /*
                                      &&
                                      $arResult["SECTION"]["CODE"] == 'sale'
                                     */
                                    ) {
                                        ?>
                                        <em class="price">
                                            <?= $arResult["OFFERS"][0]["PROPERTIES"]["OLD_PRICE"]["VALUE"] ?> руб.
                                        </em>
                                    <? } else { ?>
                                        <em class="price" id="<? echo $arItemIDs['OLD_PRICE']; ?>" style="display: <? echo ($boolDiscountShow ? '' : 'none'); ?>">
                                            <? echo ($boolDiscountShow ? $arResult['MIN_PRICE']['PRINT_VALUE'] : ''); ?>
                                        </em>						
                                    <? } ?>
                                </span>

                                <span class="special-price">
                                    <em class="price" id="<? echo $arItemIDs['PRICE']; ?>">
                                        <? echo $arResult['MIN_PRICE']['PRINT_DISCOUNT_VALUE']; ?>
                                    </em>
                                </span>
                                <span class="special-price">
                                    <em class="price" id="<? echo $arItemIDs['DISCOUNT_PRICE']; ?>" style="display: <? echo ($boolDiscountShow ? '' : 'none'); ?>">
                                        <? echo ($boolDiscountShow ? GetMessage('ECONOMY_INFO', array('#ECONOMY#' => $arResult['MIN_PRICE']['PRINT_DISCOUNT_DIFF'])) : ''); ?>
                                    </em>
                                </span>

                            </span>
                        </h2>
                    </div>
                    <? /* [Нет в Наличии]
                      <p class="availability out-of-stock"><span>Нет в наличии</span></p>
                     */ ?>
                    <? /* [/Цена] */ ?>


                    <?
                    if (!empty($arResult['DISPLAY_PROPERTIES']) || $arResult['SHOW_OFFERS_PROPS']) {
                        ?>

                        <div class="item_info_section">
                            <?
                            if (!empty($arResult['DISPLAY_PROPERTIES'])) {
                                ?>
                                <dl>
                                    <?
                                    foreach ($arResult['DISPLAY_PROPERTIES'] as &$arOneProp) {
                                        ?>
                                        <? if ($arOneProp['CODE'] == 'VIDEO_IFRAME_YOUTUBE') continue; ?>
                                        <dt>
                                        <? echo $arOneProp['NAME']; ?>
                                        </dt>
                                        <?
                                        echo '<dd>', (
                                        is_array($arOneProp['DISPLAY_VALUE']) ? implode(' / ', $arOneProp['DISPLAY_VALUE']) : $arOneProp['DISPLAY_VALUE']
                                        ), '</dd>';
                                    }
                                    unset($arOneProp);
                                    ?>
                                </dl>
                                <?
                            }
                            if ($arResult['SHOW_OFFERS_PROPS']) {
                                ?>
                                <dl id="<? echo $arItemIDs['DISPLAY_PROP_DIV'] ?>" style="display: none;"></dl>
                                <?
                            }
                            ?>
                        </div>
                        <?
                    }
                    ?>


                    <?
                    // Текст Анонса
                    if ('' != $arResult['PREVIEW_TEXT']) {
                        if (
                                'S' == $arParams['DISPLAY_PREVIEW_TEXT_MODE'] || ('E' == $arParams['DISPLAY_PREVIEW_TEXT_MODE'] && '' == $arResult['DETAIL_TEXT'])
                        ) {
                            ?>
                            <div class="item_info_section">
                                <?
                                echo ('html' == $arResult['PREVIEW_TEXT_TYPE'] ? $arResult['PREVIEW_TEXT'] : '<p>' . $arResult['PREVIEW_TEXT'] . '</p>');
                                ?>
                            </div>
                            <?
                        }
                    }
                    ?>


                    <?
                    if (isset($arResult['OFFERS']) && !empty($arResult['OFFERS']) && !empty($arResult['OFFERS_PROP'])) {
                        $arSkuProps = array();
                        ?>
                        <div <? /* class="item_info_section" */ ?> id="<? echo $arItemIDs['PROP_DIV']; ?>">
                            <?
                            $SIZES_CLOTHES = array();
                            foreach ($arResult['OFFERS'] as $key => $val) {
                                $SIZES_CLOTHES[$val['PROPERTIES']['SIZES_CLOTHES']['VALUE_ENUM_ID']] = $val['PROPERTIES']['SIZES_CLOTHES']['VALUE'];
                            }

                            foreach ($arResult['SKU_PROPS'] as &$arProp) {
                                if (!isset($arResult['OFFERS_PROP'][$arProp['CODE']]))
                                    continue;
                                $arSkuProps[] = array(
                                    'ID' => $arProp['ID'],
                                    'SHOW_MODE' => $arProp['SHOW_MODE'],
                                    'VALUES_COUNT' => $arProp['VALUES_COUNT']
                                );
                                if ('TEXT' == $arProp['SHOW_MODE']) {
                                    if (5 < $arProp['VALUES_COUNT']) {
                                        $strClass = 'bx_item_detail_size full';
                                        $strOneWidth = (100 / $arProp['VALUES_COUNT']) . '%';
                                        $strWidth = (20 * $arProp['VALUES_COUNT']) . '%';
                                        $strSlideStyle = '';
                                    } else {
                                        $strClass = 'bx_item_detail_size';
                                        $strOneWidth = '20%';
                                        $strWidth = '100%';
                                        $strSlideStyle = 'display: none;';
                                    }
                                    ?>
                                    <div class="<? echo $strClass; ?>" id="<? echo $arItemIDs['PROP'] . $arProp['ID']; ?>_cont">

                                        <? /* [Размеры] */ ?>
                                        <fieldset id="product-options-wrapper" class="product-options">
                                            <dl class="last">
                                                <dt>
                                                <label class="required">
                                                    <? echo htmlspecialcharsex($arProp['NAME']); ?>:
                                                </label>
                                                </dt>
                                                <dd>
                                                    <div class="input-box validation-passed">

                                                        <div class="bx_size_scroller_container">
                                                            <div class="bx_size">

                                                                <ul class="size_ul dnone" id="<? echo $arItemIDs['PROP'] . $arProp['ID']; ?>_list" <? /* style="width: <? echo $strWidth; ?>;margin-left:0%;" */ ?>>
                                                                    <?
                                                                    foreach ($arProp['VALUES'] as $arOneValue) {
                                                                        ?>
                                                                        <li
                                                                            data-treevalue="<? echo $arProp['ID'] . '_' . $arOneValue['ID']; ?>"
                                                                            data-onevalue="<? echo $arOneValue['ID']; ?>"
                                                                            <? /* style="width: <? echo $strOneWidth; ?>;" */ ?>
                                                                            ><i></i><span class="cnt"><? echo htmlspecialcharsex($arOneValue['NAME']); ?></span></li>
                                                                            <?
                                                                        }
                                                                        ?>
                                                                </ul>

                                                                <select class="size_select">
                                                                    <?
                                                                    $cindex = 0;

                                                                    ksort($arProp['VALUES']);

                                                                    foreach ($arProp['VALUES'] as $arOneValue) {
                                                                        if (isset($SIZES_CLOTHES[$arOneValue['ID']])) {
                                                                            ?>

                                                                            <option data-onevalue="<? echo $arOneValue['ID']; ?>" <? if ($cindex == 0) { ?>selected="selected"<? } ?>><? echo htmlspecialcharsex($arOneValue['NAME']); ?></option>

                                                                            <?
                                                                            $cindex += 1;
                                                                        }
                                                                    }
                                                                    ?>
                                                                </select>

                                                                <script>

                                                                    jQuery(function ($) {
                                                                        var $select = $('.size_select'),
                                                                                $ul = $select.prev('ul.size_ul');
                                                                        $select.bind('change', function () {
                                                                            var $this = $(this),
                                                                                    $ul = $this.prev('ul.size_ul');
                                                                            if ($ul.size()) {
                                                                                //alert("li: " + $ul.find('li[data-onevalue=' + $this.find('option:selected').data('onevalue') + ']').size());
                                                                                $ul.find('li[data-onevalue=' + $this.find('option:selected').data('onevalue') + ']').trigger('click');
                                                                            }
                                                                        });
                                                                    });

                                                                </script>

                                                            </div>
                                                            <div class="bx_slide_left" style="<? echo $strSlideStyle; ?>" id="<? echo $arItemIDs['PROP'] . $arProp['ID']; ?>_left" data-treevalue="<? echo $arProp['ID']; ?>"></div>
                                                            <div class="bx_slide_right" style="<? echo $strSlideStyle; ?>" id="<? echo $arItemIDs['PROP'] . $arProp['ID']; ?>_right" data-treevalue="<? echo $arProp['ID']; ?>"></div>
                                                        </div>

                                                    </div><!-- [end validation-passed] -->
                                                </dd>

                                                <dd class="last">
                                                    <? /*
                                                      <div class="input-box">
                                                      <select name="super_attribute[170]" id="attribute170" class="required-entry super-attribute-select">
                                                      <option value="">Choose an Option...</option>
                                                      </select>
                                                      </div>
                                                     */ ?>
                                                    <? /* [Таблица размеров] */ ?>
                                                    <? $APPLICATION->IncludeComponent("bitrix:main.include", "", array("AREA_FILE_SHOW" => "file", "PATH" => SITE_DIR . "include/table_size.php"), false); ?>

                                                </dd>

                                            </dl>

                                        </fieldset>
                                        <? /* [/Размеры] */ ?>
                                    </div>
                                    <?
                                } elseif ('PICT' == $arProp['SHOW_MODE']) {
                                    if (5 < $arProp['VALUES_COUNT']) {
                                        $strClass = 'bx_item_detail_scu full';
                                        $strOneWidth = (100 / $arProp['VALUES_COUNT']) . '%';
                                        $strWidth = (20 * $arProp['VALUES_COUNT']) . '%';
                                        $strSlideStyle = '';
                                    } else {
                                        $strClass = 'bx_item_detail_scu';
                                        $strOneWidth = '20%';
                                        $strWidth = '100%';
                                        $strSlideStyle = 'display: none;';
                                    }
                                    ?>
                                    <div class="<? echo $strClass; ?>" id="<? echo $arItemIDs['PROP'] . $arProp['ID']; ?>_cont">
                                        <fieldset id="product-options-wrapper" class="product-options">
                                            <?
                                            $colorsArr = array();
                                            foreach ($arResult['OFFERS'] as $key => $val) {
                                                $colorsArr[$val['PROPERTIES']['COLOR_REF']['VALUE']] = $val['PROPERTIES']['COLOR_REF']['VALUE'];
                                            }
                                            ?>
                                            <dl class="last">
                                                <dt>
                                                <label class="required">
                                                    <? echo htmlspecialcharsex($arProp['NAME']); ?>:
                                                </label>
                                                </dt>
                                                <dd>
                                                    <div class="input-box validation-passed">
                                                        <span class="swatch-name">

                                                        </span>

                                                        <div class="bx_scu_scroller_container">
                                                            <div class="bx_scu">

                                                                <ul class="swatches" id="<? echo $arItemIDs['PROP'] . $arProp['ID']; ?>_list" <? /* style="width: <? echo $strWidth; ?>;margin-left:0%;" */ ?>>
                                                                    <?
                                                                    $selected = 0;
                                                                    foreach ($arProp['VALUES'] as $key => $arOneValue) {
                                                                        ?>
                                                                        <li	
                                                                            <? if (in_array($arOneValue['XML_ID'], $colorsArr) && $selected == 0) { ?>data-class="bx_active" <? } ?> 
                                                                            data-treevalue="<? echo $arProp['ID'] . '_' . $arOneValue['ID'] ?>"
                                                                            data-onevalue="<? echo $arOneValue['ID']; ?>"
                                                                            <? /* style="width: echo $strOneWidth; auto!important; padding-top: 0px!important; */ ?>
                                                                            >

                                                                            <?
                                                                            if (in_array($arOneValue['XML_ID'], $colorsArr) && $selected == 0) {
                                                                                $selected = 1;
                                                                                ?>
                                                                                <input id="swatch_<?= $key ?>" type="radio" name="color" value="1" checked="checked" class="checked" />
                                                                            <? } else { ?>
                                                                                <input id="swatch_<?= $key ?>" type="radio" name="color" value="1" />
                                                                            <? } ?>

                                                                            <label class="swatch-red" for="swatch_<?= $key ?>">
                                                                                <span style="background-image:url('<? echo $arOneValue['PICT']['SRC']; ?>'); background-position: 50% 50%;"><? echo htmlspecialcharsbx($arOneValue['NAME']); ?></span>
                                                                            </label>

                                                                        </li>
                                                                        <?
                                                                    }
                                                                    ?>
                                                                </ul>

                                                            </div>
                                                            <div class="bx_slide_left" style="<? echo $strSlideStyle; ?>" id="<? echo $arItemIDs['PROP'] . $arProp['ID']; ?>_left" data-treevalue="<? echo $arProp['ID']; ?>"></div>
                                                            <div class="bx_slide_right" style="<? echo $strSlideStyle; ?>" id="<? echo $arItemIDs['PROP'] . $arProp['ID']; ?>_right" data-treevalue="<? echo $arProp['ID']; ?>"></div>
                                                        </div>

                                                    </div><!-- [end validation-passed] -->
                                                </dd>
                                            </dl>

                                        </fieldset>

                                    </div>

                                    <?
                                }
                            }
                            unset($arProp);
                            ?>
                        </div>
                        <?
                    }
                    ?>

                    <? /* [Переключение цвета и запоминание текущего, в фокусе] */ ?>
                    <script>
                        jQuery(function ($) {
                            $(window).load(function () {
                                var product = $('#product-options-wrapper'),
                                        swatches = $('.swatches:eq(0)', product)
                                swatch_name = $('.swatch-name:eq(0)', product),
                                        swatch_li = $('li', swatches).not('.bx_missing'),
                                        focus_color = '';
                                swatch_name.text(swatch_li.eq(0).find('label span').text());
                                focus_color = swatch_name.text();
                                swatch_li.bind('mouseenter mouseleave click', function (e) {
                                    var $this = $(this),
                                            type = e.type;
                                    if (type == 'mouseenter') {
                                        swatch_name.text($this.find('label span').text());
                                    } else if (type == 'mouseleave') {
                                        swatch_name.text(focus_color);
                                    } else if (type == 'click') {
                                        focus_color = swatch_name.text();
                                    }
                                });

                            });
                        });
                    </script>				

                    <div class="product-options-bottom">
                        <div class="add-to-cart">

                            <?
                            if (isset($arResult['OFFERS']) && !empty($arResult['OFFERS'])) {
                                $canBuy = $arResult['OFFERS'][$arResult['OFFERS_SELECTED']]['CAN_BUY'];
                            } else {
                                $canBuy = $arResult['CAN_BUY'];
                            }
                            if ($canBuy) {
                                $buyBtnMessage = ('' != $arParams['MESS_BTN_BUY'] ? $arParams['MESS_BTN_BUY'] : GetMessage('CT_BCE_CATALOG_BUY'));
                                $buyBtnClass = 'bx_big bx_bt_button bx_cart';
                            } else {
                                $buyBtnMessage = ('' != $arParams['MESS_NOT_AVAILABLE'] ? $arParams['MESS_NOT_AVAILABLE'] : GetMessageJS('CT_BCE_CATALOG_NOT_AVAILABLE'));
                                $buyBtnClass = 'bx_big bx_bt_button_type_2 bx_cart';
                            }
                            if ('Y' == $arParams['USE_PRODUCT_QUANTITY']) {
                                ?>
                                <label for="qty"><? echo GetMessage('CATALOG_QUANTITY'); ?>:</label>

                                <span class="item_buttons_counter_block">
                                    <? /*
                                      <a href="javascript:void(0)" class="bx_bt_button_type_2 bx_small bx_fwb" id="<? echo $arItemIDs['QUANTITY_DOWN']; ?>">-</a>
                                     */ ?>
                                    <input data-id="quantity" id="<? echo $arItemIDs['QUANTITY']; ?>" type="text" class="tac transparent_input" value="<?
                                    echo (isset($arResult['OFFERS']) && !empty($arResult['OFFERS']) ? 1 : $arResult['CATALOG_MEASURE_RATIO']
                                    );
                                    ?>">
                                           <? /*
                                             <a href="javascript:void(0)" class="bx_bt_button_type_2 bx_small bx_fwb" id="<? echo $arItemIDs['QUANTITY_UP']; ?>">+</a>
                                             <span class="bx_cnt_desc" id="<? echo $arItemIDs['QUANTITY_MEASURE']; ?>"><? echo (isset($arResult['CATALOG_MEASURE_NAME']) ? $arResult['CATALOG_MEASURE_NAME'] : ''); ?></span>
                                            */ ?>
                                </span>

                                <?
                                $dir = $APPLICATION->GetCurDir(false);
                                $data = "?";
                                $data .= "action=BUY";
                                $data .= "&";
                                $data .= "SECTION_CODE=" . $_REQUEST['SECTION_CODE'];
                                $data .= "&";
                                $data .= "ajax_basket=Y";
                                $data .= "&";
                                $data .= "basket_props=" . $arResult['OFFERS_PROP_CODES'];
                                $data .= "&";
                                $data .= "prop[0]=0";
                                $data .= "&";

                                // $data .= "id=1";
                                // $data .= "&";
                                // $data .= "quantity=1";
                                // $data .= "&";
                                ?>

                                <button class="button btn-cart cta" style="dispay: none; position: absolute; left: -10000px;" id="<? echo $arItemIDs['BUY_LINK']; ?>" href="javascript:void(0);">
                                    <span><span><? echo $buyBtnMessage; ?></span></span>
                                </button>
                                <div class="relative">
                                    <? /* [id="<? echo $arItemIDs['BUY_LINK']; ?>"] */ ?>
                                    <button data-dir="<?= $dir ?>" data-ajax-href="<?= $dir . $data ?>" class="button btn-cart cta" href="javascript:void(0);">
                                        <span><span><? echo $buyBtnMessage; ?></span></span>
                                    </button>
                                </div>
                                <script>
                                    jQuery(function ($) {
                                        var button = $('button[data-ajax-href]'),
                                                quantity = $("input[data-id='quantity']");

                                        button.click(function (e) {
                                            e.preventDefault();
                                            var $this = $(this),
                                                    url = $this.data('ajax-href'),
                                                    dir = $this.data('dir'),
                                                    quantity_val = quantity.val(),
                                                    data_id = $('.product-media div[data-id]:visible'),
                                                    id_val = data_id.data('id'),
                                                    loader = $("<div></div>").addClass('loader');

                                            loader.insertAfter($this);
                                            loader.css({
                                                'width': $this.outerWidth() + 4,
                                                'height': $this.outerHeight() + 4,
                                                'margin-top': -1.55 * $this.outerHeight(),
                                                'left': -2
                                            })

                                            $.ajaxSetup({
                                                // Disable caching of AJAX responses
                                                cache: false
                                            });

                                            BX.ajax.loadJSON(
                                                    url + 'quantity=' + quantity_val + '&' + 'id=' + id_val,
                                                    function (out) {
                                                        if (out.STATUS == 'OK') {
                                                            $.get("/index.php", {'clear_cache': 'Y', 'ajax': 'Y'}, function (xml) {  // загрузку XML из файла example.xml   

                                                                $("#header").html($(xml).find('#header').html());
                                                                Enterprise.TopCart.initialize('topCartContent', 'cartHeader', '/');
                                                                Enterprise.TopCart.showCart(3);
                                                                loader.remove();

                                                            }, 'html');
                                                        }
                                                    }
                                            );

                                            return false;
                                        });
                                    });
                                </script>

                                <p class="required" style="display:none">* Обязательные поля</p>

                                <? /* <span class="item_buttons_counter_block"></span>
                                  if ('Y' == $arParams['DISPLAY_COMPARE'])
                                  {
                                  ?>
                                  <a href="javascript:void(0)" class="bx_big bx_bt_button_type_2 bx_cart" style="margin-left: 10px"><? echo ('' != $arParams['MESS_BTN_COMPARE']
                                  ? $arParams['MESS_BTN_COMPARE']
                                  : GetMessage('CT_BCE_CATALOG_COMPARE')
                                  ); ?></a>
                                  <?
                                  } */
                                ?>

                                <?
                                if ('Y' == $arParams['SHOW_MAX_QUANTITY']) {
                                    if (isset($arResult['OFFERS']) && !empty($arResult['OFFERS'])) {
                                        ?>
                                        <p id="<? echo $arItemIDs['QUANTITY_LIMIT']; ?>" style="display: none;"><? echo GetMessage('OSTATOK'); ?>: <span></span></p>
                                        <?
                                    } else {
                                        if ('Y' == $arResult['CATALOG_QUANTITY_TRACE'] && 'N' == $arResult['CATALOG_CAN_BUY_ZERO']) {
                                            ?>
                                            <p id="<? echo $arItemIDs['QUANTITY_LIMIT']; ?>"><? echo GetMessage('OSTATOK'); ?>: <span><? echo $arResult['CATALOG_QUANTITY']; ?></span></p>
                                            <?
                                        }
                                    }
                                }
                            } else {
                                ?>
                                <div class="item_buttons vam">
                                    <span class="item_buttons_counter_block">

                                        <a href="javascript:void(0);" class="<? echo $buyBtnClass; ?>" id="<? echo $arItemIDs['BUY_LINK']; ?>"><span></span><? echo $buyBtnMessage; ?></a>
                                        <?
                                        if ('Y' == $arParams['DISPLAY_COMPARE']) {
                                            ?>
                                            <a id="<? echo $arItemIDs['COMPARE_LINK']; ?>" href="javascript:void(0)" class="bx_big bx_bt_button_type_2 bx_cart" style="margin-left: 10px"><?
                                                echo ('' != $arParams['MESS_BTN_COMPARE'] ? $arParams['MESS_BTN_COMPARE'] : GetMessage('CT_BCE_CATALOG_COMPARE')
                                                );
                                                ?></a>
                                            <?
                                        }
                                        ?>
                                    </span>
                                </div>
                                <?
                            }
                            ?>
                        </div><!-- [end add-to-cart] -->
                    </div><!-- [end product-options-bottom] -->



                </div><!-- [end bx_lt] -->

                <?
                $arFile = CFile::GetFileArray($arFirstPhoto["ID"]);
                $file = CFile::ResizeImageGet($arFile, array('width' => 680, 'height' => 435), BX_RESIZE_IMAGE_PROPORTIONAL, true);
                ?>

                <div class="bx_rt product-media">

                    <? /* [Слайдер] */ ?>
                    <div class="bx_item_slider" id="<? echo $arItemIDs['BIG_SLIDER_ID']; ?>">

                        <div class="bx_bigimages" id="<? echo $arItemIDs['BIG_IMG_CONT_ID']; ?>">

                            <div class="bx_bigimages_imgcontainer">
                                <span class="bx_bigimages_aligner">
                                    <a class="product-image image-zoom" target="_blank" id="main-image" title="" href="<? echo $arFirstPhoto['SRC']; ?>" />

                                    <img
                                        id="<? echo $arItemIDs['PICT']; ?>" 
                                        src="<? echo $file['src']; ?>"
                                        alt="<? echo $strAlt; ?>" 
                                        title="<? echo $strTitle; ?>"
                                        >

                                    <p class="notice">Увеличить</p>
                                    </a>
                                </span>
                            </div>

                            <?
                            // Видео с Youtube.com - показывается по отдельному клику
                            if (
                                    isset($arResultVideo) &&
                                    !empty($arResultVideo)
                            ) {
                                ?>
                                <div class="video"> 
                                    <? echo htmlspecialcharsBack($arResultVideo); ?>
                                </div>
                            <? } ?>

                        </div>
                        <?
                        if ($arResult['SHOW_SLIDER']) {
                            if (!isset($arResult['OFFERS']) || empty($arResult['OFFERS'])) {
                                if (5 < $arResult['MORE_PHOTO_COUNT']) {
                                    $strClass = 'bx_slider_conteiner full';
                                    $strOneWidth = (100 / $arResult['MORE_PHOTO_COUNT']) . '%';
                                    $strWidth = (20 * $arResult['MORE_PHOTO_COUNT']) . '%';
                                    $strSlideStyle = '';
                                } else {
                                    $strClass = 'bx_slider_conteiner';
                                    $strOneWidth = '20%';
                                    $strWidth = '100%';
                                    $strSlideStyle = 'display: none;';
                                }
                                ?>
                                <div data-id="<?= $arResult["ID"] ?>" class="<? echo $strClass; ?>" id="<? echo $arItemIDs['SLIDER_CONT_ID']; ?>">

                                    <div class="bx_slider_scroller_container">

                                        <? if (sizeof($arResult['MORE_PHOTO']) > 0): ?>
                                            <div class="bx_slide">
                                                <div class="more-views">
                                                    <ul style="width: <? echo $strWidth; ?>;" id="<? echo $arItemIDs['SLIDER_LIST']; ?>">
                                                        <?
                                                        foreach ($arResult['MORE_PHOTO'] as &$arOnePhoto) {
                                                            ?>

                                                            <?
                                                            $arFile_680 = CFile::GetFileArray($arOnePhoto["ID"]);
                                                            $file_680 = CFile::ResizeImageGet($arFile_680, array('width' => 680, 'height' => 435), BX_RESIZE_IMAGE_PROPORTIONAL, true);

                                                            //$arFile_148 = CFile::GetFileArray($arOnePhoto["ID"]);
                                                            $file_148 = CFile::ResizeImageGet($arOnePhoto["ID"], array('width' => 147, 'height' => 97), BX_RESIZE_IMAGE_PROPORTIONAL, true);
                                                            ?>
                                                            <li data-bg-original="<? echo $arOnePhoto['SRC']; ?>" data-bg-resize="<?= $file_680['src'] ?>" data-value="<? echo $arOnePhoto['ID']; ?>" style="width: <? echo $strOneWidth; ?>; padding-top: <? echo $strOneWidth; ?>;"><span class="cnt"><span class="cnt_item" style="background-image:url('<? echo $file_148['src']; ?>'); background-position: 50% 50%;"></span></span></li>
                                                            <? /*
                                                              <li data-value="<? echo $arOnePhoto['ID']; ?>" style="width: <? echo $strOneWidth; ?>; padding-top: <? echo $strOneWidth; ?>;"><span class="cnt"><span class="cnt_item" style="background-image:url('<? echo $arOnePhoto['SRC']; ?>'); background-position: 50% 50%;"></span></span></li>
                                                             */ ?>
                                                            <?
                                                        }
                                                        unset($arOnePhoto);
                                                        ?>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="bx_slide_left" id="<? echo $arItemIDs['SLIDER_LEFT']; ?>" style="<? echo $strSlideStyle; ?>"></div>
                                            <div class="bx_slide_right" id="<? echo $arItemIDs['SLIDER_RIGHT']; ?>" style="<? echo $strSlideStyle; ?>"></div>
                                        <? endif; ?>
                                    </div>

                                </div>

                                <?
                            } else {
                                foreach ($arResult['OFFERS'] as $key => $arOneOffer) {
                                    if (!isset($arOneOffer['MORE_PHOTO_COUNT']) || 0 >= $arOneOffer['MORE_PHOTO_COUNT'])
                                        continue;
                                    $strVisible = ($key == $arResult['OFFERS_SELECTED'] ? '' : 'none');
                                    if (5 < $arOneOffer['MORE_PHOTO_COUNT']) {
                                        $strClass = 'bx_slider_conteiner full';
                                        $strOneWidth = (100 / $arOneOffer['MORE_PHOTO_COUNT']) . '%';
                                        $strWidth = (20 * $arOneOffer['MORE_PHOTO_COUNT']) . '%';
                                        $strSlideStyle = '';
                                    } else {
                                        $strClass = 'bx_slider_conteiner';
                                        $strOneWidth = '20%';
                                        $strWidth = '100%';
                                        $strSlideStyle = 'display: none;';
                                    }
                                    ?>

                                    <div data-id="<?= $arOneOffer['ID'] ?>" class="<? echo $strClass; ?>" id="<? echo $arItemIDs['SLIDER_CONT_OF_ID'] . $arOneOffer['ID']; ?>" style="display: <? echo $strVisible; ?>;">
                                        <div class="bx_slider_scroller_container">
                                            <div class="bx_slide">
                                                <ul style="width: <? echo $strWidth; ?>;" id="<? echo $arItemIDs['SLIDER_LIST_OF_ID'] . $arOneOffer['ID']; ?>">
                                                    <?
                                                    foreach ($arOneOffer['MORE_PHOTO'] as &$arOnePhoto) {
                                                        ?>
                                                        <?
                                                        $arFile_680 = CFile::GetFileArray($arOnePhoto["ID"]);
                                                        $file_680 = CFile::ResizeImageGet($arFile_680, array('width' => 680, 'height' => 435), BX_RESIZE_IMAGE_PROPORTIONAL, true);

                                                        //$arFile_148 = CFile::GetFileArray($arOnePhoto["ID"]);
                                                        $file_148 = CFile::ResizeImageGet($arOnePhoto["ID"], array('width' => 147, 'height' => 97), BX_RESIZE_IMAGE_PROPORTIONAL, true);
                                                        ?>
                                                        <li data-bg-original="<? echo $arOnePhoto['SRC']; ?>" data-bg-resize="<?= $file_680['src'] ?>" data-value="<? echo $arOnePhoto['ID']; ?>" style="width: <? echo $strOneWidth; ?>; padding-top: <? echo $strOneWidth; ?>;"><span class="cnt"><span class="cnt_item" style="background-image:url('<? echo $file_148['src']; ?>'); background-position: 50% 50%;"></span></span></li>
                                                        <? /*
                                                          <li data-value="<? echo $arOneOffer['ID'].'_'.$arOnePhoto['ID']; ?>" style="width: <? echo $strOneWidth; ?>; padding-top: <? echo $strOneWidth; ?>"><span class="cnt"><span class="cnt_item" style="background-image:url('<? echo $arOnePhoto['SRC']; ?>'); background-position: 50% 50%;"></span></span></li>
                                                         */ ?>
                                                        <?
                                                    }
                                                    unset($arOnePhoto);
                                                    ?>
                                                </ul>
                                            </div>
                                            <div class="bx_slide_left" id="<? echo $arItemIDs['SLIDER_LEFT_OF_ID'] . $arOneOffer['ID'] ?>" style="<? echo $strSlideStyle; ?>" data-value="<? echo $arOneOffer['ID']; ?>"></div>
                                            <div class="bx_slide_right" id="<? echo $arItemIDs['SLIDER_RIGHT_OF_ID'] . $arOneOffer['ID'] ?>" style="<? echo $strSlideStyle; ?>" data-value="<? echo $arOneOffer['ID']; ?>"></div>
                                        </div>
                                    </div>


                                    <?
                                }
                            }
                        }
                        ?>
                    </div><!-- [end bx_item_slider] -->
                    <? /* [/Слайдер] */ ?>

                    <script>
                        jQuery(function ($) {
                            $(window).load(function () {
                                var html = '<?
                    // Видео с Youtube.com - показывается по отдельному клику
                    if (
                            isset($arResultVideo) &&
                            !empty($arResultVideo)
                    ) {
                        ?><div class="video_direct"><a class="video_href" href="#"><img src="/media/catalog/element/videolabel_small_2_3.jpg" width="150" height="100" alt="" /></a></div><? } ?>',
                                            bx_slide = $('.bx_slide'),
                                            bx_slide_li = $('li', bx_slide),
                                            video = $('.video'),
                                            swatches = $('.swatches'),
                                            bx_bigimages_imgcontainer = $('.bx_bigimages_imgcontainer');

                                    if (html != '') {
                                        $(html).insertAfter(bx_slide);
                                        var video_href = $('.video_href');
                                        video_href.bind('click', function (e) {
                                            e.preventDefault();
                                            bx_slide_li.removeClass('bx_active');
                                            $(this).addClass('bx_active');
                                            video.show();
                                            bx_bigimages_imgcontainer.hide();
                                            return false;
                                        });
                                        bx_slide_li.bind('click', function (e) {
                                            video_href.removeClass('bx_active');
                                            video.hide();
                                            bx_bigimages_imgcontainer.show();
                                        });
                                        swatches.bind('click', function (e) {
                                            video.hide();
                                            bx_bigimages_imgcontainer.show();
                                        });
                                    }

                                    if ($("li[data-class = 'bx_active']").size()) {
                                        $("li[data-class = 'bx_active']").addClass('bx_active').find("input[type = 'radio']").trigger('click');
                                    }

                                    var bx_scu = $('.bx_scu>ul.swatches>li:visible'),
                                            bx_slider_conteiner = $('.bx_item_slider .bx_slider_conteiner'),
                                            main_image = $('#main-image'),
                                            bx_slide = $('.bx_slide li', bx_slider_conteiner),
                                            main_image_img = main_image.find('img:eq(0)');

                                    bx_slide.click(function (e) {
                                        var $this = $(this),
                                                index = bx_scu.index($this),
                                                original_img = $this.data('bg-original'),
                                                resize_img = $this.data('bg-resize');

                                        main_image.attr('href', original_img);
                                        main_image_img.attr('src', resize_img);
                                        main_image_img.src = resize_img;
                                    });

                                    bx_scu.click(function (e) {
                                        var $this = $(this),
                                                index = bx_scu.index($this),
                                                current_slider_conteiner = bx_slider_conteiner.filter(':visible'),
                                                $bx_slide = $('.bx_slide li', current_slider_conteiner);

                                        $bx_slide.eq(0).trigger('click');
                                    });


                                });
                            });
                    </script>

                    <?
// Бренды - не используем
                    /*
                      $useBrands = ('Y' == $arParams['BRAND_USE']);
                      $useVoteRating = ('Y' == $arParams['USE_VOTE_RATING']);
                      if ($useBrands || $useVoteRating)
                      {
                      ?>
                      <div class="bx_optionblock">
                      <?
                      if ($useVoteRating)
                      {
                      ?><?$APPLICATION->IncludeComponent(
                      "bitrix:iblock.vote",
                      "stars",
                      array(
                      "IBLOCK_TYPE" => $arParams['IBLOCK_TYPE'],
                      "IBLOCK_ID" => $arParams['IBLOCK_ID'],
                      "ELEMENT_ID" => $arResult['ID'],
                      "ELEMENT_CODE" => "",
                      "MAX_VOTE" => "5",
                      "VOTE_NAMES" => array("1", "2", "3", "4", "5"),
                      "SET_STATUS_404" => "N",
                      "DISPLAY_AS_RATING" => $arParams['VOTE_DISPLAY_AS_RATING'],
                      "CACHE_TYPE" => $arParams['CACHE_TYPE'],
                      "CACHE_TIME" => $arParams['CACHE_TIME']
                      ),
                      $component,
                      array("HIDE_ICONS" => "Y")
                      );?><?
                      }
                      if ($useBrands)
                      {
                      ?><?$APPLICATION->IncludeComponent("bitrix:catalog.brandblock", ".default", array(
                      "IBLOCK_TYPE" => $arParams['IBLOCK_TYPE'],
                      "IBLOCK_ID" => $arParams['IBLOCK_ID'],
                      "ELEMENT_ID" => $arResult['ID'],
                      "ELEMENT_CODE" => "",
                      "PROP_CODE" => $arParams['BRAND_PROP_CODE'],
                      "CACHE_TYPE" => $arParams['CACHE_TYPE'],
                      "CACHE_TIME" => $arParams['CACHE_TIME'],
                      "CACHE_GROUPS" => $arParams['CACHE_GROUPS'],
                      "WIDTH" => "",
                      "HEIGHT" => ""
                      ),
                      $component,
                      array("HIDE_ICONS" => "Y")
                      );?><?
                      }
                      ?>
                      </div>
                      <?
                      }
                      unset($useVoteRating);
                      unset($useBrands);
                     */
                    ?>
                </div><!-- [end bx_rt] -->



                <?
                // Данные по OFFERS - Торговым предложениям
                if (isset($arResult['OFFERS']) && !empty($arResult['OFFERS'])) {
                    ?>
                    <div class="bx_md">
                        <div class="item_info_section">		
                            <?
                            if ($arResult['OFFER_GROUP']) {
                                foreach ($arResult['OFFERS'] as $arOffer) {
                                    if (!$arOffer['OFFER_GROUP'])
                                        continue;
                                    ?>
                                    <span id="<? echo $arItemIDs['OFFER_GROUP'] . $arOffer['ID']; ?>" style="display: none;">

                                        <?
                                        $APPLICATION->IncludeComponent("bitrix:catalog.set.constructor", ".default", array(
                                            "IBLOCK_ID" => $arResult["OFFERS_IBLOCK"],
                                            "ELEMENT_ID" => $arOffer['ID'],
                                            "PRICE_CODE" => $arParams["PRICE_CODE"],
                                            "BASKET_URL" => $arParams["BASKET_URL"],
                                            "OFFERS_CART_PROPERTIES" => $arParams["OFFERS_CART_PROPERTIES"],
                                            "CACHE_TYPE" => $arParams["CACHE_TYPE"],
                                            "CACHE_TIME" => $arParams["CACHE_TIME"],
                                            "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
                                                ), $component, array("HIDE_ICONS" => "Y")
                                        );
                                        ?>

                                    </span>
                                    <?
                                }
                            }
                            ?>
                        </div>
                    </div>
                    <?
                }
                else {
                    if ($arResult['MODULES']['catalog']) {
                        ?>
                        <div class="bx_md">
                            <div class="item_info_section">		
                                <?
                                $APPLICATION->IncludeComponent("bitrix:catalog.set.constructor", ".default", array(
                                    "IBLOCK_ID" => $arParams["IBLOCK_ID"],
                                    "ELEMENT_ID" => $arResult["ID"],
                                    "PRICE_CODE" => $arParams["PRICE_CODE"],
                                    "BASKET_URL" => $arParams["BASKET_URL"],
                                    "CACHE_TYPE" => $arParams["CACHE_TYPE"],
                                    "CACHE_TIME" => $arParams["CACHE_TIME"],
                                    "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
                                        ), $component, array("HIDE_ICONS" => "Y")
                                );
                                ?>
                            </div>
                        </div>
                        <?
                    }
                }
                ?>


                <?
                // Комментарии - не используем
                /*
                  <div class="tab-section-container">
                  <?
                  if ('Y' == $arParams['USE_COMMENTS'])
                  {
                  ?>
                  <?$APPLICATION->IncludeComponent(
                  "bitrix:catalog.comments",
                  "",
                  array(
                  "ELEMENT_ID" => $arResult['ID'],
                  "ELEMENT_CODE" => "",
                  "IBLOCK_ID" => $arParams['IBLOCK_ID'],
                  "URL_TO_COMMENT" => "",
                  "WIDTH" => "",
                  "COMMENTS_COUNT" => "5",
                  "BLOG_USE" => $arParams['BLOG_USE'],
                  "FB_USE" => $arParams['FB_USE'],
                  "FB_APP_ID" => $arParams['FB_APP_ID'],
                  "VK_USE" => $arParams['VK_USE'],
                  "VK_API_ID" => $arParams['VK_API_ID'],
                  "CACHE_TYPE" => $arParams['CACHE_TYPE'],
                  "CACHE_TIME" => $arParams['CACHE_TIME'],
                  "BLOG_TITLE" => "",
                  "BLOG_URL" => "",
                  "PATH_TO_SMILE" => "/bitrix/images/blog/smile/",
                  "EMAIL_NOTIFY" => "N",
                  "AJAX_POST" => "Y",
                  "SHOW_SPAM" => "Y",
                  "SHOW_RATING" => "N",
                  "FB_TITLE" => "",
                  "FB_USER_ADMIN_ID" => "",
                  "FB_APP_ID" => $arParams['FB_APP_ID'],
                  "FB_COLORSCHEME" => "light",
                  "FB_ORDER_BY" => "reverse_time",
                  "VK_TITLE" => "",
                  ),
                  $component,
                  array("HIDE_ICONS" => "Y")
                  );?>
                  <?
                  }
                  ?>
                  </div>
                 */
                ?>
            </div>

        </div><!-- [end bx_rt] -->

        <?
        if (isset($arResult['OFFERS']) && !empty($arResult['OFFERS'])) {
            ?>

            <?
            foreach ($arResult['JS_OFFERS'] as &$arOneJS) {
                if ($arOneJS['PRICE']['DISCOUNT_VALUE'] != $arOneJS['PRICE']['VALUE']) {
                    $arOneJS['PRICE']['PRINT_DISCOUNT_DIFF'] = GetMessage('ECONOMY_INFO', array('#ECONOMY#' => $arOneJS['PRICE']['PRINT_DISCOUNT_DIFF']));
                    $arOneJS['PRICE']['DISCOUNT_DIFF_PERCENT'] = -$arOneJS['PRICE']['DISCOUNT_DIFF_PERCENT'];
                }
                $strProps = '';
                if ($arResult['SHOW_OFFERS_PROPS']) {
                    if (!empty($arOneJS['DISPLAY_PROPERTIES'])) {
                        foreach ($arOneJS['DISPLAY_PROPERTIES'] as $arOneProp) {
                            $strProps .= '<dt>' . $arOneProp['NAME'] . '</dt><dd>' . (
                                    is_array($arOneProp['VALUE']) ? implode(' / ', $arOneProp['VALUE']) : $arOneProp['VALUE']
                                    ) . '</dd>';
                        }
                    }
                }
                $arOneJS['DISPLAY_PROPERTIES'] = $strProps;
            }
            if (isset($arOneJS))
                unset($arOneJS);
            $arJSParams = array(
                'CONFIG' => array(
                    'SHOW_QUANTITY' => $arParams['USE_PRODUCT_QUANTITY'],
                    'SHOW_DISCOUNT_PERCENT' => ('Y' == $arParams['SHOW_DISCOUNT_PERCENT']),
                    'SHOW_OLD_PRICE' => ('Y' == $arParams['SHOW_OLD_PRICE']),
                    'DISPLAY_COMPARE' => ('Y' == $arParams['DISPLAY_COMPARE']),
                    'SHOW_SKU_PROPS' => $arResult['SHOW_OFFERS_PROPS'],
                    'OFFER_GROUP' => $arResult['OFFER_GROUP'],
                    'MAIN_PICTURE_MODE' => $arParams['DETAIL_PICTURE_MODE']
                ),
                'PRODUCT_TYPE' => $arResult['CATALOG_TYPE'],
                'VISUAL' => array(
                    'ID' => $arItemIDs['ID'],
                ),
                'DEFAULT_PICTURE' => array(
                    'PREVIEW_PICTURE' => $arResult['DEFAULT_PICTURE'],
                    'DETAIL_PICTURE' => $arResult['DEFAULT_PICTURE']
                ),
                'PRODUCT' => array(
                    'ID' => $arResult['ID'],
                    'NAME' => $arResult['~NAME']
                ),
                'BASKET' => array(
                    'QUANTITY' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
                    'BASKET_URL' => $arParams['BASKET_URL'],
                    'SKU_PROPS' => $arResult['OFFERS_PROP_CODES']
                ),
                'OFFERS' => $arResult['JS_OFFERS'],
                'OFFER_SELECTED' => $arResult['OFFERS_SELECTED'],
                'TREE_PROPS' => $arSkuProps
            );
            ?>

            <?
        }
        else {
            ?>

            <?
            $emptyProductProperties = empty($arResult['PRODUCT_PROPERTIES']);
            if ('Y' == $arParams['ADD_PROPERTIES_TO_BASKET'] && !$emptyProductProperties) {
                ?>
                <div id="<? echo $arItemIDs['BASKET_PROP_DIV']; ?>" style="display: none;">
                    <?
                    if (!empty($arResult['PRODUCT_PROPERTIES_FILL'])) {
                        foreach ($arResult['PRODUCT_PROPERTIES_FILL'] as $propID => $propInfo) {
                            ?>
                            <input
                                type="hidden"
                                name="<? echo $arParams['PRODUCT_PROPS_VARIABLE']; ?>[<? echo $propID; ?>]"
                                value="<? echo htmlspecialcharsbx($propInfo['ID']); ?>"
                                >
                                <?
                                if (isset($arResult['PRODUCT_PROPERTIES'][$propID]))
                                    unset($arResult['PRODUCT_PROPERTIES'][$propID]);
                            }
                        }
                        $emptyProductProperties = empty($arResult['PRODUCT_PROPERTIES']);
                        if (!$emptyProductProperties) {
                            ?>
                        <table>
                            <?
                            foreach ($arResult['PRODUCT_PROPERTIES'] as $propID => $propInfo) {
                                ?>
                                <tr>
                                    <td>
                                        <? echo $arResult['PROPERTIES'][$propID]['NAME']; ?>
                                    </td>
                                    <td>
                                        <?
                                        if (
                                                'L' == $arResult['PROPERTIES'][$propID]['PROPERTY_TYPE'] && 'C' == $arResult['PROPERTIES'][$propID]['LIST_TYPE']
                                        ) {
                                            foreach ($propInfo['VALUES'] as $valueID => $value) {
                                                ?><label><input
                                                        type="radio"
                                                        name="<? echo $arParams['PRODUCT_PROPS_VARIABLE']; ?>[<? echo $propID; ?>]"
                                                        value="<? echo $valueID; ?>"
                                                        <? echo ($valueID == $propInfo['SELECTED'] ? '"checked"' : ''); ?>
                                                        ><? echo $value; ?></label><br><?
                                                }
                                            } else {
                                                ?>
                                            <select name="<? echo $arParams['PRODUCT_PROPS_VARIABLE']; ?>[<? echo $propID; ?>]">
                                                <?
                                                foreach ($propInfo['VALUES'] as $valueID => $value) {
                                                    ?><option
                                                        value="<? echo $valueID; ?>"
                                                        <? echo ($valueID == $propInfo['SELECTED'] ? '"selected"' : ''); ?>
                                                        ><? echo $value; ?></option><?
                                                    }
                                                    ?>
                                            </select>
                                            <?
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <?
                            }
                            ?>
                        </table>
                        <?
                    }
                    ?>
                </div>
                <?
            }
            ?>

            <?
            $arJSParams = array(
                'CONFIG' => array(
                    'SHOW_QUANTITY' => $arParams['USE_PRODUCT_QUANTITY'],
                    'SHOW_PRICE' => true,
                    'SHOW_DISCOUNT_PERCENT' => ('Y' == $arParams['SHOW_DISCOUNT_PERCENT']),
                    'SHOW_OLD_PRICE' => ('Y' == $arParams['SHOW_OLD_PRICE']),
                    'DISPLAY_COMPARE' => ('Y' == $arParams['DISPLAY_COMPARE']),
                    'MAIN_PICTURE_MODE' => $arParams['DETAIL_PICTURE_MODE']
                ),
                'VISUAL' => array(
                    'ID' => $arItemIDs['ID'],
                ),
                'PRODUCT_TYPE' => $arResult['CATALOG_TYPE'],
                'PRODUCT' => array(
                    'ID' => $arResult['ID'],
                    'PICT' => $arFirstPhoto,
                    'NAME' => $arResult['~NAME'],
                    'SUBSCRIPTION' => true,
                    'PRICE' => $arResult['MIN_PRICE'],
                    'SLIDER_COUNT' => $arResult['MORE_PHOTO_COUNT'],
                    'SLIDER' => $arResult['MORE_PHOTO'],
                    'CAN_BUY' => $arResult['CAN_BUY'],
                    'CHECK_QUANTITY' => $arResult['CHECK_QUANTITY'],
                    'QUANTITY_FLOAT' => is_double($arResult['CATALOG_MEASURE_RATIO']),
                    'MAX_QUANTITY' => $arResult['CATALOG_QUANTITY'],
                    'STEP_QUANTITY' => $arResult['CATALOG_MEASURE_RATIO'],
                    'BUY_URL' => $arResult['~BUY_URL'],
                ),
                'BASKET' => array(
                    'ADD_PROPS' => ('Y' == $arParams['ADD_PROPERTIES_TO_BASKET']),
                    'QUANTITY' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
                    'PROPS' => $arParams['PRODUCT_PROPS_VARIABLE'],
                    'EMPTY_PROPS' => $emptyProductProperties,
                    'BASKET_URL' => $arParams['BASKET_URL']
                )
            );
            unset($emptyProductProperties);
        }
        ?>


        <script type="text/javascript">
            var <? echo $strObName; ?> = new JCCatalogElement(<? echo CUtil::PhpToJSObject($arJSParams, false, true); ?>);
            BX.message({
                MESS_BTN_BUY: '<? echo ('' != $arParams['MESS_BTN_BUY'] ? CUtil::JSEscape($arParams['MESS_BTN_BUY']) : GetMessageJS('CT_BCE_CATALOG_BUY')); ?>',
                MESS_BTN_ADD_TO_BASKET: '<? echo ('' != $arParams['MESS_BTN_ADD_TO_BASKET'] ? CUtil::JSEscape($arParams['MESS_BTN_ADD_TO_BASKET']) : GetMessageJS('CT_BCE_CATALOG_BUY')); ?>',
                MESS_NOT_AVAILABLE: '<? echo ('' != $arParams['MESS_NOT_AVAILABLE'] ? CUtil::JSEscape($arParams['MESS_NOT_AVAILABLE']) : GetMessageJS('CT_BCE_CATALOG_NOT_AVAILABLE')); ?>',
                TITLE_ERROR: '<? echo GetMessageJS('CT_BCE_CATALOG_TITLE_ERROR') ?>',
                TITLE_BASKET_PROPS: '<? echo GetMessageJS('CT_BCE_CATALOG_TITLE_BASKET_PROPS') ?>',
                BASKET_UNKNOWN_ERROR: '<? echo GetMessageJS('CT_BCE_CATALOG_BASKET_UNKNOWN_ERROR') ?>',
                BTN_SEND_PROPS: '<? echo GetMessageJS('CT_BCE_CATALOG_BTN_SEND_PROPS'); ?>',
                BTN_MESSAGE_CLOSE: '<? echo GetMessageJS('CT_BCE_CATALOG_BTN_MESSAGE_CLOSE') ?>'
            });
        </script>


    </div><!-- [end product-intro] -->
    <? if ('' != $arResult['DETAIL_TEXT']) { ?>
        <div class="product-info">
            <div class="product-info-section-heading">
                <h1>
                    <?
                    echo (
                    isset($arResult["IPROPERTY_VALUES"]["ELEMENT_PAGE_TITLE"]) && '' != $arResult["IPROPERTY_VALUES"]["ELEMENT_PAGE_TITLE"] ? $arResult["IPROPERTY_VALUES"]["ELEMENT_PAGE_TITLE"] : $arResult["NAME"]
                    );
                    ?>
                </h1>
            </div>

            <div class="product-info-slide product-description">
                <div class="module-b" style="margin: 30px 0;width: 100%;">

                    <div class="product-description-left">
                        <?
                        if ('' != $arResult['DETAIL_TEXT']) {
                            ?>
                            <?
                            if ('html' == $arResult['DETAIL_TEXT_TYPE']) {
                                echo $arResult['DETAIL_TEXT'];
                            } else {
                                ?><p><? echo $arResult['DETAIL_TEXT']; ?></p><?
                            }
                            ?>
                            <?
                        }
                        ?>
                    </div>

                    <div class="product-description-right module-b-right" style="display: none;">

        <!--								<p class="module-b-heading"><strong>Технология</strong> &amp; Особенности</p>-->

                        <?= $arResult["IPROPERTY_VALUES"]["TECHNOLOGY"] ?>
                        <?
                        if ('' != $arResult['DETAIL_TEXT']) {
                            ?>
                            <?
                            if ('html' == $arResult["PROPERTIES"]["TECHNOLOGY"]["VALUE"]["TEXT"]["TYPE"]) {
                                echo htmlspecialcharsBack($arResult["PROPERTIES"]["TECHNOLOGY"]["VALUE"]["TEXT"]);
                            } else {
                                ?><p><? echo htmlspecialcharsBack($arResult["PROPERTIES"]["TECHNOLOGY"]["VALUE"]["TEXT"]); ?></p><?
                            }
                            ?>
                            <?
                        }
                        ?>

                    </div>

                </div> <!-- end module-b -->
            </div> <!-- end product-description -->


        </div>
    <? } ?>


    <?
    $arrFilter = Array("ID" => $arResult["PROPERTIES"]["RECOMMEND"]["VALUE"]);

    $SECTION_ID = 0;

    $APPLICATION->IncludeComponent(
            "bitrix:catalog.section", "recomended", Array(
        "TEMPLATE_THEME" => "blue",
        "PRODUCT_DISPLAY_MODE" => "N",
        "ADD_PICT_PROP" => "MORE_PHOTO",
        "LABEL_PROP" => "NEW_BOOK",
        "OFFER_ADD_PICT_PROP" => "FILE",
        "OFFER_TREE_PROPS" => array("-"),
        "PRODUCT_SUBSCRIPTION" => "N",
        "SHOW_DISCOUNT_PERCENT" => "N",
        "SHOW_OLD_PRICE" => "N",
        "MESS_BTN_BUY" => "Купить",
        "MESS_BTN_ADD_TO_BASKET" => "В корзину",
        "MESS_BTN_SUBSCRIBE" => "Подписаться",
        "MESS_BTN_DETAIL" => "Подробнее",
        "MESS_NOT_AVAILABLE" => "Нет в наличии",
        "AJAX_MODE" => "Y",
        "IBLOCK_TYPE" => "catalog",
        "IBLOCK_ID" => "16",
        "SECTION_ID" => $SECTION_ID,
        "SECTION_CODE" => "",
        "SECTION_USER_FIELDS" => array(),
        "ELEMENT_SORT_FIELD" => "sort",
        "ELEMENT_SORT_ORDER" => "asc",
        "ELEMENT_SORT_FIELD2" => "name",
        "ELEMENT_SORT_ORDER2" => "asc",
        "FILTER_NAME" => "arrFilter",
        "INCLUDE_SUBSECTIONS" => "Y",
        "SHOW_ALL_WO_SECTION" => "Y",
        "SECTION_URL" => "",
        "DETAIL_URL" => "",
        "BASKET_URL" => "/personal/basket.php",
        "ACTION_VARIABLE" => "action",
        "PRODUCT_ID_VARIABLE" => "id",
        "PRODUCT_QUANTITY_VARIABLE" => "quantity",
        "ADD_PROPERTIES_TO_BASKET" => "Y",
        "PRODUCT_PROPS_VARIABLE" => "prop",
        "PARTIAL_PRODUCT_PROPERTIES" => "N",
        "SECTION_ID_VARIABLE" => "SECTION_ID",
        "ADD_SECTIONS_CHAIN" => "Y",
        "DISPLAY_COMPARE" => "N",
        "SET_TITLE" => "Y",
        "SET_BROWSER_TITLE" => "Y",
        "BROWSER_TITLE" => "-",
        "SET_META_KEYWORDS" => "Y",
        "META_KEYWORDS" => "",
        "SET_META_DESCRIPTION" => "Y",
        "META_DESCRIPTION" => "",
        "SET_STATUS_404" => "N",
        "PAGE_ELEMENT_COUNT" => "30",
        "LINE_ELEMENT_COUNT" => "3",
        "PROPERTY_CODE" => array(
            0 => "NAME",
            1 => "LINK",
            2 => "DETAIL_PICTURE",
            2 => "MORE_PHOTO",
        ),
        "OFFERS_FIELD_CODE" => array(
            0 => "NAME",
            1 => "LINK",
            3 => "SUBCAT_BASE_PRICE",
            4 => "MORE_PHOTO",
        ),
        "OFFERS_PROPERTY_CODE" => array(),
        "OFFERS_SORT_FIELD" => "sort",
        "OFFERS_SORT_ORDER" => "asc",
        "OFFERS_SORT_FIELD2" => "active_from",
        "OFFERS_SORT_ORDER2" => "desc",
        "OFFERS_LIMIT" => "5",
        "PRICE_CODE" => Array("0" => "BASE"),
        "USE_PRICE_COUNT" => "Y",
        "SHOW_PRICE_COUNT" => "1",
        "PRICE_VAT_INCLUDE" => "Y",
        "PRODUCT_PROPERTIES" => array(),
        "USE_PRODUCT_QUANTITY" => "Y",
        "CACHE_TYPE" => "A",
        "CACHE_TIME" => "36000000",
        "CACHE_FILTER" => "Y",
        "CACHE_GROUPS" => "Y",
        "DISPLAY_TOP_PAGER" => "N",
        "DISPLAY_BOTTOM_PAGER" => "N",
        "PAGER_TITLE" => "Товары",
        "PAGER_SHOW_ALWAYS" => "Y",
        "PAGER_TEMPLATE" => "",
        "PAGER_DESC_NUMBERING" => "Y",
        "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
        "PAGER_SHOW_ALL" => "Y",
        "HIDE_NOT_AVAILABLE" => "Y",
        "OFFERS_CART_PROPERTIES" => array(),
        "AJAX_OPTION_JUMP" => "N",
        "AJAX_OPTION_STYLE" => "Y",
        "AJAX_OPTION_HISTORY" => "N",
        "CONVERT_CURRENCY" => "Y",
        "CURRENCY_ID" => "RUB",
            )
    );
    ?>




</div><!-- [end product-details] -->

