<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>

<? if (!empty($arResult)): ?>
    <div class="main-menu">
        <div class="content">
            <div id="header-nav" class="nav-content">
                <div class="nav-container">
                    <div class="nav">
                        <ul id="nav" class="grid-full">


                            <?
                            foreach ($arResult as $key => $arItem):
                                if ($arParams["MAX_LEVEL"] == 1 && $arItem["DEPTH_LEVEL"] > 1)
                                    continue;
                                ?>

                                <?
                                switch ($key) {
                                    case 0:
                                        ?>
                                        <li class="level nav-1 level-top first parent <? if ($arItem["SELECTED"]) { ?>active<? } ?>">
                                            <?
                                            if (CModule::IncludeModule("iblock")) {
                                                // если $ID не задан или это не число, тогда 
                                                // $ID будет =0, выбираем корневые разделы
                                                $ID = 0;
                                                $IBLOCK_ID = 16;
                                                // выберем папки из информационного блока $BID и раздела $ID
                                                $items = GetIBlockSectionList($IBLOCK_ID, $ID, Array("sort" => "asc"), 100);
                                                $content = '';
                                                $current = '';
                                                if (count($items) > 0) {

                                                    if (isset($_REQUEST["SECTION_CODE"]) && $_REQUEST["SECTION_CODE"] == $_arItem["CODE"]) {
                                                        $GLOBALS["current_top_menu"] = $_arItem["NAME"];
                                                        $current .= '<span class="breadcrumb">' . $_arItem["NAME"] . '</span>';
                                                    }

                                                    $content .= '<div class="level-top" >';
                                                    $content .= '<div class="level">';
                                                    $content .= '<ul class=" level">';
                                                    $content .= '<li class="">';
                                                    $content .= '<ul class="catagory_children">';
                                                    $content .= '<li class="li-wrapper">';

                                                    //$content .= '<div class="level0">';
                                                    $content .= '<div class="mm-cat-title">' . $arItem["TEXT"] . '</div>';
                                                    //$content .= '<ul class="level0 catagory_children">';

                                                    $i = 1;
                                                    while ($_arItem = $items->GetNext()) {
                                                        $res = CIBLockElement::GetList(array(), array('IBLOCK_ID' => $_arItem['IBLOCK_ID'], 'SECTION_ID' => $_arItem['ID'], 'ACTIVE' => 'Y'), false, false, array('ID'));
                                                        if ($res->SelectedRowsCount() <= 0)
                                                            continue;

                                                        if ($_arItem['CODE'] == 'sale') {
                                                            continue;
                                                        }
                                                        $arID = array();
                                                        // check offers
                                                        while ($db_res = $res->Fetch()):
                                                            $arID[] = $db_res['ID'];
                                                        endwhile;
                                                        $sku = CCatalogSKU::getOffersList($arID, 0, array('ACTIVE' => 'Y'));

                                                        if (sizeof($sku) <= 0)
                                                            continue;
                                                        if ($i == 1) {
                                                            $content .= '<div class="level1 nav-1-' . $i . ' first item " style="width: 50%">';
                                                        } else {
                                                            $content .= '<div class="level1 nav-1-' . $i . ' item" style="width: 50%">';
                                                        }
                                                        $content .= '<a href="/catalog/' . $_arItem['CODE'] . '/" class="catagory-level1">';
                                                        $content .= '<i class="material-icons">keyboard_arrow_right</i>';
                                                        $content .= '<span class="thumbnail">';
                                                        $content .= CFile::ShowImage($_arItem['PICTURE'], 0, 0, "border=0", "", true);
                                                        $content .= '</span>';
                                                        $content .= '<span>';
                                                        $content .= $_arItem["NAME"];
                                                        $content .= '</span>';
                                                        $content .= '</a>';
                                                        $content .= '</div>';



                                                        $i += 1;
                                                    }
                                                    //$content .= "</ul>";
                                                    //$content .= "</div>";

                                                    $content .= "</li>";
                                                    $content .= "</ul>";
                                                    $content .= "</li>";
                                                    $content .= "</ul>";
                                                    $content .= "</div>";
                                                    $content .= "</div>";
                                                }
                                            }
                                            ?>


                                            <a>
                                                <? /* <div class="level-top<?if($arItem["SELECTED"]){?> selected<? } ?>"> */ ?>
                                                <span><?= $arItem["TEXT"] ?></span>
                                                <? /* </div> */ ?>
                                            </a>

                                            <?= $content; ?>

                                        </li>

                                        <?
                                        break;

                                    case 1:
                                        ?>
                                        <li class="level nav-2 level-top last parent <? if ($arItem["SELECTED"]) { ?>active<? } ?>">

                                            <?
                                            if (CModule::IncludeModule("iblock")) {
                                                // если $ID не задан или это не число, тогда 
                                                // $ID будет =0, выбираем корневые разделы
                                                $ID = 0;
                                                $IBLOCK_ID = 15;
                                                // выберем папки из информационного блока $BID и раздела $ID
                                                $items = GetIBlockSectionList($IBLOCK_ID, $ID, Array("sort" => "asc"), 100);
                                                $content = '';
                                                $current = '';

                                                if (count($items) > 0) {
                                                    if (isset($_REQUEST["SPORTS"]) && $_REQUEST["SPORTS"] == $_arItem["CODE"]) {
                                                        $current .= '<span class="breadcrumb">' . $_arItem["NAME"] . '</span>';
                                                    }

                                                    $content .= '<div class="level-top" >';
                                                    $content .= '<div class="level">';
                                                    $content .= '<ul class=" level">';
                                                    $content .= '<li class="">';
                                                    $content .= '<ul class="catagory_children">';
                                                    $content .= '<li class="li-wrapper">';

                                                    //$content .= '<div class="level0">';

                                                    $content .= '<div class="mm-cat-title">' . $arItem["TEXT"] . '</div>';

                                                    //$content .= '<ul class="level0">';
                                                    $i = 1;
                                                    while ($_arItem = $items->GetNext()) {

                                                        $res = CIBLockElement::GetList(array(), array('IBLOCK_ID' => 16, 'PROPERTY_SPORT_TYPE' => $_arItem['ID'], 'ACTIVE' => 'Y'), false, false, array('ID'));
                                                        if ($res->SelectedRowsCount() <= 0)
                                                            continue;
                                                        $ar2ID = array();
                                                        // check offers
                                                        while ($db_res = $res->Fetch()):
                                                            $ar2ID[] = $db_res['ID'];
                                                        endwhile;
                                                        $sku = CCatalogSKU::getOffersList($ar2ID, 0, array('ACTIVE' => 'Y'));

                                                        if (sizeof($sku) <= 0)
                                                            continue;
                                                        if ($_arItem['CODE'] == 'sale') {
                                                            continue;
                                                        }
                                                        if ($i == 1) {
                                                            $content .= '<div class="level1 nav-2-' . $i . ' first item" style="width: 33%">';
                                                        } else {
                                                            $content .= '<div class="level1 nav-2-' . $i . ' item" style="width: 33%">';
                                                        }
                                                        $content .= '<a href="/sports/' . $_arItem['CODE'] . '/" class="catagory-level1">';
                                                        $content .= '<i class="material-icons">keyboard_arrow_right</i>';
                                                        $content .= '<span>';
                                                        $content .= $_arItem["NAME"];
                                                        $content .= '</span>';
                                                        $content .= '</a>';
                                                        $content .= '</div>';
                                                        if ($i % 3 == 0) {
                                                            //$content .= '</ul><ul class="level0">';
                                                        }



                                                        $i += 1;
                                                    }
                                                    //$content .= "</ul>"
                                                    //$content .= "</div>";

                                                    $content .= "</li>";
                                                    $content .= "</ul>";
                                                    $content .= "</li>";
                                                    $content .= "</ul>";
                                                    $content .= "</div>";
                                                    $content .= "</div>";
                                                }
                                            }
                                            ?>

                                            <a>
                                                <? /* <div class="level-top<?if($arItem["SELECTED"]):?> selected<?endif?>"> */ ?>
                                                <span><?= $arItem["TEXT"] ?></span>
                                                <? /* if($current != '') { ?>
                                                  <?=$current;?>
                                                  <? } */ ?>
                                                <? /* </div> */ ?>
                                            </a>
                                            <?= $content; ?>
                                        </li>
                                        <?
                                        break;

                                    case 2:
                                        ?>
                                        <li class="level nav-3 level-top last parent <? if ($arItem["SELECTED"]) { ?>active<? } ?>">

                                            <?
                                            if (CModule::IncludeModule("iblock")) {
                                                // если $ID не задан или это не число, тогда 
                                                // $ID будет =0, выбираем корневые разделы
                                                $ID = 0;
                                                $IBLOCK_ID = 26;
                                                // выберем папки из информационного блока $BID и раздела $ID
                                                $items = GetIBlockSectionList($IBLOCK_ID, $ID, Array("sort" => "asc"), 100);
                                                $content = '';
                                                $current = $_arItem["NAME"];

                                                if (count($items) > 0) {
                                                    if (isset($_REQUEST["DESTINATION"]) && $_REQUEST["DESTINATION"] == $_arItem["CODE"]) {
                                                        //$current .='<span class="breadcrumb">'.$_arItem["NAME"].'</span>';
                                                    }

                                                    $content .= '<div class="level-top" >';
                                                    $content .= '<div class="level">';
                                                    $content .= '<ul class=" level">';
                                                    $content .= '<li class="">';
                                                    $content .= '<ul class="catagory_children">';
                                                    $content .= '<li class="li-wrapper">';

                                                    //$content .= '<div class="level0">';

                                                    $content .= '<div class="mm-cat-title">' . $arItem["TEXT"] . '</div>';

                                                    //$content .= '<ul class="level0">';
                                                    $i = 1;
                                                    while ($_arItem = $items->GetNext()) {

                                                        $res = CIBLockElement::GetList(array(), array('IBLOCK_ID' => 16, 'PROPERTY_DESTINATION_TYPE' => $_arItem['ID'], 'ACTIVE' => 'Y'), false, false, array('ID'));

                                                        if ($res->SelectedRowsCount() <= 0)
                                                            continue;
                                                        if ($_arItem['CODE'] == 'sale') {
                                                            continue;
                                                        }
                                                        $ar3ID = array();
                                                        // check offers
                                                        while ($db_res = $res->Fetch()):
                                                            $ar3ID[] = $db_res['ID'];
                                                        endwhile;
                                                        $sku = CCatalogSKU::getOffersList($ar3ID, 0, array('ACTIVE' => 'Y'));

                                                        if (sizeof($sku) <= 0)
                                                            continue;
                                                        if ($i == 1) {
                                                            $content .= '<div class="level1 nav-3-' . $i . ' first item " style="width: 33%" data-cnt="' . $res->SelectedRowsCount() . '">';
                                                        } else {
                                                            $content .= '<div class="level1 nav-3-' . $i . ' item" style="width: 33%"  data-cnt="' . $res->SelectedRowsCount() . '">';
                                                        }

                                                        $content .= '<a href="/destination/' . $_arItem['CODE'] . '/" class="catagory-level1">';

                                                        $content .= '<i class="material-icons">keyboard_arrow_right</i>';
                                                        $content .= '<span>';
                                                        $content .= $_arItem["NAME"];
                                                        $content .= '</span>';
                                                        $content .= '</a>';
                                                        $content .= '</div>';
                                                        if ($i % 3 == 0) {
                                                            //$content .= '</ul><ul class="level0">';
                                                        }

                                                        $i += 1;
                                                    }
                                                    //$content .= "</ul>";
                                                    //$content .= "</div>";

                                                    $content .= "</li>";
                                                    $content .= "</ul>";
                                                    $content .= "</li>";
                                                    $content .= "</ul>";
                                                    $content .= "</div>";
                                                    $content .= "</div>";
                                                }
                                            }
                                            ?>
                                            <a>
                                                <? /* <div class="level-top<?if($arItem["SELECTED"]):?> selected<?endif?>"> */ ?>
                                                <span><?= $arItem["TEXT"] ?></span>
                                                <? /* if($current != '') { ?>
                                                  <?=$current;?>
                                                  <? } */ ?>
                                                <? /* </div> */ ?>
                                            </a>
                                            <?= $content; ?>
                                        </li>

                                        <?
                                        break;

                                    case 3:
                                        ?>
                                        <li class="level nav-4 nav-athletes <? if ($arItem["SELECTED"]): ?> active<? endif ?>">
                                            <a href="<?= $arItem["LINK"] ?>" class="<? if ($arItem["SELECTED"]): ?> active<? endif ?>">
                                                <span><?= $arItem["TEXT"] ?></span>
                                                <? /* if($arItem["SELECTED"]):?>
                                                  <span class="breadcrumb">Команда Shock Doctor</span>
                                                  <?endif */ ?>
                                            </a>
                                        </li>
                                        <?
                                        break;

                                    case 4:
                                        ?>
                                        <li class="level nav-5 nav-technology <? if ($arItem["SELECTED"]): ?> active<? endif ?>">
                                            <a href="<?= $arItem["LINK"] ?>" class="<? if ($arItem["SELECTED"]): ?> active<? endif ?>">
                                                <span><?= $arItem["TEXT"] ?></span>
                                            </a>
                                        </li>
                                        <?
                                        break;

                                    default:
                                        ?>
                                        <li class="level nav-6 <? if ($arItem["SELECTED"]): ?> active<? endif ?>">
                                            <a href="<?= $arItem["LINK"] ?>">
                                                <span><?= $arItem["TEXT"] ?></span>
                                            </a>
                                        </li>
                                        <?
                                        break;
                                }
                                ?>

                            <? endforeach ?>

                        </ul>
                    </div>
                </div> <!-- end nav-container -->
            </div> <!-- end nav -->
        </div> <!-- end container -->
    </div> <!-- end main-menu -->
<? endif ?>

