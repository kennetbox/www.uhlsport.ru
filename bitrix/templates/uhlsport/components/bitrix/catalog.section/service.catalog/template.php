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
?>


<?
if (!empty($arResult['ITEMS'])) {
    $templateData = array(
        'TEMPLATE_THEME' => $this->GetFolder() . '/themes/' . $arParams['TEMPLATE_THEME'] . '/style.css',
        'TEMPLATE_CLASS' => 'bx_' . $arParams['TEMPLATE_THEME']
    );

    $arSkuTemplate = array();
    if (!empty($arResult['SKU_PROPS'])) {
        foreach ($arResult['SKU_PROPS'] as &$arProp) {
            $templateRow = '';
            if ('TEXT' == $arProp['SHOW_MODE']) {
                if (5 < $arProp['VALUES_COUNT']) {
                    $strClass = 'bx_item_detail_size full';
                    $strWidth = ($arProp['VALUES_COUNT'] * 20) . '%';
                    $strOneWidth = (100 / $arProp['VALUES_COUNT']) . '%';
                    $strSlideStyle = '';
                } else {
                    $strClass = 'bx_item_detail_size';
                    $strWidth = '100%';
                    $strOneWidth = '20%';
                    $strSlideStyle = 'display: none;';
                }
                $templateRow .= '<div class="' . $strClass . '" id="#ITEM#_prop_' . $arProp['ID'] . '_cont">' .
                        '<span class="bx_item_section_name_gray">' . htmlspecialcharsex($arProp['NAME']) . '</span>' .
                        '<div class="bx_size_scroller_container"><div class="bx_size"><ul id="#ITEM#_prop_' . $arProp['ID'] . '_list" style="width: ' . $strWidth . ';">';
                foreach ($arProp['VALUES'] as $arOneValue) {
                    $arOneValue['NAME'] = htmlspecialcharsbx($arOneValue['NAME']);
                    $templateRow .= '<li data-treevalue="' . $arProp['ID'] . '_' . $arOneValue['ID'] . '" data-onevalue="' . $arOneValue['ID'] . '" style="width: ' . $strOneWidth . ';" title="' . $arOneValue['NAME'] . '"><i></i><span class="cnt">' . $arOneValue['NAME'] . '</span></li>';
                }
                $templateRow .= '</ul></div>' .
                        '<div class="bx_slide_left" id="#ITEM#_prop_' . $arProp['ID'] . '_left" data-treevalue="' . $arProp['ID'] . '" style="' . $strSlideStyle . '"></div>' .
                        '<div class="bx_slide_right" id="#ITEM#_prop_' . $arProp['ID'] . '_right" data-treevalue="' . $arProp['ID'] . '" style="' . $strSlideStyle . '"></div>' .
                        '</div></div>';
            } elseif ('PICT' == $arProp['SHOW_MODE']) {
                if (5 < $arProp['VALUES_COUNT']) {
                    $strClass = 'bx_item_detail_scu full';
                    $strWidth = ($arProp['VALUES_COUNT'] * 20) . '%';
                    $strOneWidth = (100 / $arProp['VALUES_COUNT']) . '%';
                    $strSlideStyle = '';
                } else {
                    $strClass = 'bx_item_detail_scu';
                    $strWidth = '100%';
                    $strOneWidth = '20%';
                    $strSlideStyle = 'display: none;';
                }
                $templateRow .= '<div class="' . $strClass . '" id="#ITEM#_prop_' . $arProp['ID'] . '_cont">' .
                        '<span class="bx_item_section_name_gray">' . htmlspecialcharsex($arProp['NAME']) . '</span>' .
                        '<div class="bx_scu_scroller_container"><div class="bx_scu"><ul id="#ITEM#_prop_' . $arProp['ID'] . '_list" style="width: ' . $strWidth . ';">';
                foreach ($arProp['VALUES'] as $arOneValue) {
                    $arOneValue['NAME'] = htmlspecialcharsbx($arOneValue['NAME']);
                    $templateRow .= '<li data-treevalue="' . $arProp['ID'] . '_' . $arOneValue['ID'] . '" data-onevalue="' . $arOneValue['ID'] . '" style="width: ' . $strOneWidth . '; padding-top: ' . $strOneWidth . ';"><i title="' . $arOneValue['NAME'] . '"></i>' .
                            '<span class="cnt"><span class="cnt_item" style="background-image:url(\'' . $arOneValue['PICT']['SRC'] . '\');" title="' . $arOneValue['NAME'] . '"></span></span></li>';
                }
                $templateRow .= '</ul></div>' .
                        '<div class="bx_slide_left" id="#ITEM#_prop_' . $arProp['ID'] . '_left" data-treevalue="' . $arProp['ID'] . '" style="' . $strSlideStyle . '"></div>' .
                        '<div class="bx_slide_right" id="#ITEM#_prop_' . $arProp['ID'] . '_right" data-treevalue="' . $arProp['ID'] . '" style="' . $strSlideStyle . '"></div>' .
                        '</div></div>';
            }
            $arSkuTemplate[$arProp['CODE']] = $templateRow;
        }
        unset($templateRow, $arProp);
    }

    if ($arParams["DISPLAY_TOP_PAGER"]) {
        ?>

        <? echo $arResult["NAV_STRING"]; ?>
        <?
    }

    $strElementEdit = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_EDIT");
    $strElementDelete = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_DELETE");
    $arElementDeleteParams = array("CONFIRM" => GetMessage('CT_BCS_TPL_ELEMENT_DELETE_CONFIRM'));
    ?>

    <div class="container_16">


        <h2>
            uhlsport Каталог
        </h2>


        <div class="container_16 downloads">

            <?
            foreach ($arResult['ITEMS'] as $key => $arItem) {
                $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], $strElementEdit);
                $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], $strElementDelete, $arElementDeleteParams);
                $strMainID = $this->GetEditAreaId($arItem['ID']);

                $arItemIDs = array(
                    'ID' => $strMainID,
                    'PICT' => $strMainID . '_pict',
                    'SECOND_PICT' => $strMainID . '_secondpict',
                    'STICKER_ID' => $strMainID . '_sticker',
                    'SECOND_STICKER_ID' => $strMainID . '_secondsticker',
                    'QUANTITY' => $strMainID . '_quantity',
                    'QUANTITY_DOWN' => $strMainID . '_quant_down',
                    'QUANTITY_UP' => $strMainID . '_quant_up',
                    'QUANTITY_MEASURE' => $strMainID . '_quant_measure',
                    'BUY_LINK' => $strMainID . '_buy_link',
                    'SUBSCRIBE_LINK' => $strMainID . '_subscribe',
                    'PRICE' => $strMainID . '_price',
                    'DSC_PERC' => $strMainID . '_dsc_perc',
                    'SECOND_DSC_PERC' => $strMainID . '_second_dsc_perc',
                    'PROP_DIV' => $strMainID . '_sku_tree',
                    'PROP' => $strMainID . '_prop_',
                    'DISPLAY_PROP_DIV' => $strMainID . '_sku_prop',
                    'BASKET_PROP_DIV' => $strMainID . '_basket_prop',
                );

                $strObName = 'ob' . preg_replace("/[^a-zA-Z0-9_]/", "x", $strMainID);

                $productTitle = (
                        isset($arItem['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE']) && $arItem['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE'] != '' ? $arItem['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE'] : $arItem['NAME']
                        );
                $imgTitle = (
                        isset($arItem['IPROPERTY_VALUES']['ELEMENT_PREVIEW_PICTURE_FILE_TITLE']) && $arItem['IPROPERTY_VALUES']['ELEMENT_PREVIEW_PICTURE_FILE_TITLE'] != '' ? $arItem['IPROPERTY_VALUES']['ELEMENT_PREVIEW_PICTURE_FILE_TITLE'] : $arItem['NAME']
                        );
                ?>

                <div class="grid_3 suffix_1 prefix_1">
                    <div>

                        <?
                        $pdf_file = CFile::GetPath($arItem["PROPERTIES"]["PDF"]["VALUE"]);
                        $file = CFile::ResizeImageGet($arItem['PREVIEW_PICTURE']['ID'], array('width' => 220, 'height' => 155), BX_RESIZE_IMAGE_PROPORTIONAL, true);
                        ?>

                        <img class="thumbnail" src="<? echo $file['src']; ?>" />

                        <h5>
                            <? echo $productTitle; ?>
                        </h5>

                        <a class="download" href="<?= $pdf_file ?>" download="download"><img src="/bitrix/templates/uhlsport/images/download.jpg" /></a><a target="_blank" href="<?= $pdf_file ?>"><img src="/bitrix/templates/uhlsport/images/flipbook.jpg" /></a>

                        <? /*
                          <a id="<? echo $arItemIDs['PICT']; ?>" href="<? echo $arItem['DETAIL_PAGE_URL']; ?>" class="bx_catalog_item_images" style="background-image: url('<? echo $arItem['PREVIEW_PICTURE']['SRC']; ?>')" title="<? echo $imgTitle; ?>">
                          <?
                          if ('Y' == $arParams['SHOW_DISCOUNT_PERCENT'])
                          {
                          ?>
                          <div id="<? echo $arItemIDs['DSC_PERC']; ?>" class="bx_stick_disc right bottom" style="display:<? echo (0 < $arItem['MIN_PRICE']['DISCOUNT_DIFF_PERCENT'] ? '' : 'none'); ?>;">-<? echo $arItem['MIN_PRICE']['DISCOUNT_DIFF_PERCENT']; ?>%</div>
                          <?
                          }
                          ?>
                          </a>
                         */ ?>

                    </div>
                </div>

                <?
            }
            ?>

        </div>

    </div>

    <script type="text/javascript">
        BX.message({
            MESS_BTN_BUY: '<? echo ('' != $arParams['MESS_BTN_BUY'] ? CUtil::JSEscape($arParams['MESS_BTN_BUY']) : GetMessageJS('CT_BCS_TPL_MESS_BTN_BUY')); ?>',
            MESS_BTN_ADD_TO_BASKET: '<? echo ('' != $arParams['MESS_BTN_ADD_TO_BASKET'] ? CUtil::JSEscape($arParams['MESS_BTN_ADD_TO_BASKET']) : GetMessageJS('CT_BCS_TPL_MESS_BTN_ADD_TO_BASKET')); ?>',
            MESS_NOT_AVAILABLE: '<? echo ('' != $arParams['MESS_NOT_AVAILABLE'] ? CUtil::JSEscape($arParams['MESS_NOT_AVAILABLE']) : GetMessageJS('CT_BCS_TPL_MESS_PRODUCT_NOT_AVAILABLE')); ?>',
            BTN_MESSAGE_BASKET_REDIRECT: '<? echo GetMessageJS('CT_BCS_CATALOG_BTN_MESSAGE_BASKET_REDIRECT'); ?>',
            BASKET_URL: '<? echo $arParams["BASKET_URL"]; ?>',
            ADD_TO_BASKET_OK: '<? echo GetMessageJS('ADD_TO_BASKET_OK'); ?>',
            TITLE_ERROR: '<? echo GetMessageJS('CT_BCS_CATALOG_TITLE_ERROR') ?>',
            TITLE_BASKET_PROPS: '<? echo GetMessageJS('CT_BCS_CATALOG_TITLE_BASKET_PROPS') ?>',
            TITLE_SUCCESSFUL: '<? echo GetMessageJS('ADD_TO_BASKET_OK'); ?>',
            BASKET_UNKNOWN_ERROR: '<? echo GetMessageJS('CT_BCS_CATALOG_BASKET_UNKNOWN_ERROR') ?>',
            BTN_MESSAGE_SEND_PROPS: '<? echo GetMessageJS('CT_BCS_CATALOG_BTN_MESSAGE_SEND_PROPS'); ?>',
            BTN_MESSAGE_CLOSE: '<? echo GetMessageJS('CT_BCS_CATALOG_BTN_MESSAGE_CLOSE') ?>'
        });
    </script>

    <?
}
?>
