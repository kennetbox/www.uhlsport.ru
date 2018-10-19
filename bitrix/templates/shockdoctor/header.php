<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
IncludeTemplateLangFile($_SERVER["DOCUMENT_ROOT"]."/bitrix/templates/".SITE_TEMPLATE_ID."/header.php");
$wizTemplateId = COption::GetOptionString("main", "wizard_template_id", "eshop_adapt_horizontal", SITE_ID);
CUtil::InitJSCore();
CJSCore::Init(array("fx"));
$curPage = $APPLICATION->GetCurPage(true);
?><? if(!$_REQUEST["ajax"] && @$_REQUEST["ajax"] != "Y"){ ?><!DOCTYPE html><? } // не Ajax - корзина ?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?=LANGUAGE_ID?>" lang="<?=LANGUAGE_ID?>">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="user-scalable=no, initial-scale=1.0, maximum-scale=1.0, width=device-width">
	<meta name="yandex-verification" content="44ec3bdcc46311a0" />
	<title>
		<?$APPLICATION->ShowTitle()?>
	</title>
	<link rel="shortcut icon" type="image/x-icon" href="<?=SITE_DIR?>/favicon.ico" />
	<?//$APPLICATION->ShowHead();
	echo '<meta http-equiv="Content-Type" content="text/html; charset='.LANG_CHARSET.'"'.(true ? ' /':'').'>'."\n";
	$APPLICATION->ShowMeta("robots", false, true);
	$APPLICATION->ShowMeta("keywords", false, true);
	$APPLICATION->ShowMeta("description", false, true);

	?>

	<script type="text/javascript" src="//code.jquery.com/jquery-1.11.0.min.js"></script>

	<link rel="stylesheet" type="text/css" href="<?=CUtil::GetAdditionalFileURL(SITE_TEMPLATE_PATH."/colors.css")?>" />

	<link rel="stylesheet" type="text/css" href="<?=CUtil::GetAdditionalFileURL(SITE_TEMPLATE_PATH."/js/slick/slick.css")?>" />
	<link rel="stylesheet" type="text/css" href="<?=CUtil::GetAdditionalFileURL(SITE_TEMPLATE_PATH."/js/slick/slick-theme.css")?>" />
	<link rel="stylesheet" type="text/css" href="<?=CUtil::GetAdditionalFileURL(SITE_TEMPLATE_PATH."/js/owl/owl.carousel.css")?>" />
	<link rel="stylesheet" type="text/css" href="<?=CUtil::GetAdditionalFileURL(SITE_TEMPLATE_PATH."/js/owl/owl.theme.css")?>" />
	<link rel="stylesheet" type="text/css" href="<?=CUtil::GetAdditionalFileURL(SITE_TEMPLATE_PATH."/js/owl/owl.transitions.css")?>" />
	<?
	$APPLICATION->ShowHeadStrings();

	//$APPLICATION->ShowHeadScripts();
	//$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/script.js");
	?>

	<link rel="icon" href="<?=SITE_TEMPLATE_PATH?>/media/favicon/default/Logo2.png" type="image/x-icon" />
    <link rel="shortcut icon" href="<?=SITE_TEMPLATE_PATH?>/media/favicon/default/Logo2.png" type="image/x-icon" />

    <link href='http://fonts.googleapis.com/css?family=PT+Sans+Narrow:400,700&amp;subset=latin,cyrillic' rel='stylesheet' type='text/css'>

	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />

    <!--[if lt IE 7]>
    <script type="text/javascript">
    //<![CDATA[
        var BLANK_URL = '<?=SITE_TEMPLATE_PATH?>/js/blank.html';
        var BLANK_IMG = '<?=SITE_TEMPLATE_PATH?>/js/spacer.gif';
    //]]>
    </script>
    <![endif]-->



		<? $APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH."/css/styles.css"); ?>
		<? $APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH."/css/widgets.css"); ?>
		<? $APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH."/css/window.css"); ?>
		<? $APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH."/css/forms.css"); ?>
		<? $APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH."/css/bootstrap.css"); ?>
		<? $APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH."/css/customer.css"); ?>
		<? $APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH."/js/dist/magnific-popup.css"); ?>
		<? $APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH."/css/ajaxlogin.css"); ?>

		<link rel="stylesheet" href="<?=SITE_TEMPLATE_PATH?>/css/print.css" media="print" />

		<? $APPLICATION->ShowCSS(true, true); ?>

		<? $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/prototype/prototype.js"); ?>
		<? $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/prototype/validation.js"); ?>
		<? $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/prototype/window.js"); ?>

		<? $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/scriptaculous/builder.js"); ?>
		<? $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/scriptaculous/effects.js"); ?>
		<? $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/scriptaculous/dragdrop.js"); ?>
		<? $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/scriptaculous/controls.js"); ?>
		<? $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/scriptaculous/slider.js"); ?>

		<? $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/varien/js.js"); ?>
		<? $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/varien/form.js"); ?>
		<? $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/varien/menu.js"); ?>
		<? $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/varien/configurable.js"); ?>

		<? $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/mage/translate.js"); ?>
		<? $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/mage/cookies.js"); ?>

		<? $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/lib/ccard.js"); ?>

		<? $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/enterprise/catalogevent.js"); ?>

		<? $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/scripts.js"); ?>
		<? $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/ga_social_tracking.js"); ?>
		<? $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/sd-scripts.js"); ?>
		<? $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/ajax-window.js"); ?>

	<? $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/validator/jquery.validate.min.js"); ?>
	<? //$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/validator/localization/messages_ru.min.js"); ?>

	<? $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/owl/owl.carousel.js"); ?>
	<? $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/slick/slick.js"); ?>
	<? $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/dist/jquery.jquery.magnific-popup.js"); ?>
	<? $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/dist/jquery.magnific-popup.min.js"); ?>

    <!--[if lte IE 9]>
        <link rel="stylesheet" href="<?=SITE_TEMPLATE_PATH?>/css/ie/styles-ie9.css" />
    <![endif]-->
    <!--[if lt IE 9]>
        <link rel="stylesheet" href="<?=SITE_TEMPLATE_PATH?>/css/ie/styles-ie8.css" />
    <![endif]-->
    <!--[if lt IE 8]>
        <link rel="stylesheet" href="<?=SITE_TEMPLATE_PATH?>/css/ie/styles-ie7.css" />
    <![endif]-->
    <!--[if lt IE 7]>
        <script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/js/lib/ds-sleight.js"></script>
        <script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/skin/frontend/shock-doctor/default/js/iehover-fix.js"></script>
    <![endif]-->

    <script type="text/javascript">
        //<![CDATA[
        Mage.Cookies.path     = '/';
        // Mage.Cookies.domain   = '.www.shockdoctor.com';
				Mage.Cookies.domain   = '.www.shockdoctor.ru';
        //]]>
    </script>

    <script type="text/javascript">
        //<![CDATA[
        optionalZipCountries = ["AG","HK","IE","MO","PA","ZA"];
        //]]>
    </script>

    <script type="text/javascript">
        var Translator = new Translate({"Please use only letters (a-z or A-Z), numbers (0-9) or underscore(_) in this field, first character should be a letter.":"Please use only letters (a-z or A-Z), numbers (0-9) or underscores (_) in this field, first character must be a letter."});
    </script>

	<script type="text/javascript">
		jQuery(function($) {
			var formValidate = $('form').has("input[class^='required'],input[class^='required']");
			formValidate.each(function(index) {
				$(this).validate({
					errorPlacement: function(error,element) {
						return true;
					}
				});
			});
		});
	</script>

</head>
<? $dir = $APPLICATION->GetCurDir(false); ?>
<body>
<? /* [Счетчики аналитики] */ ?>
<?$APPLICATION->IncludeComponent("bitrix:main.include", "", array("AREA_FILE_SHOW" => "file", "PATH" => SITE_DIR."include/analyticstracking.php"), false);?>
<div id="panel"><?$APPLICATION->ShowPanel();?></div>
<div class="wrapper">

<div class="page">

<div id="header" class="header">

    <div id="header-contents" class="header-contents">

		<!--<div class="top-promo-banner">
			<div class="row">
				<div class="container">
					<strong>FREE Shipping </strong>ALL Month- You Shop. We Ship!
				</div>
			</div>
		</div>-->

		<div class="header-row-background">
			<div class="container">
				<div class="header-row">

					<div class="header-switchers"></div>

					<div class="top-links">
						<div class="top-links-inline">
							<div class="links">

								<? global $USER; ?>
								<? if ($USER->IsAuthorized()) { ?>

									<ul>
										<li><a href="/company/where-to-buy/">Где купить</a></li>
										<li><a href="/personal/">Привет: <span class="user-name"><?echo $USER->GetLogin()?></span></a>   [<a href="/personal/?logout=yes">Выйти</a>]</li>
									</ul>

								<? } else { ?>

									<ul>
										<li><a href="/company/where-to-buy/">Где купить</a></li>
										<?/*
										<li><a class="registration_link" href="/register/">Создать аккаунт</a></li>
										*/?>
										<li><a class="registration_link" href="/login/">Регистрация</a></li>

										<li><a class="login_link" href="/login/" <?/*ajaxhref="/customer/account/login/"*/?>>Войти</a></li>

										<li class="header-links-cart">
											<?/*
												$APPLICATION->IncludeComponent(
													"bitrix:sale.basket.basket.line",
													"basket_line_shockdoctor",
													array(
														"PATH_TO_BASKET" => SITE_DIR."personal/cart/",
														"PATH_TO_PERSONAL" => SITE_DIR."personal/",
														"SHOW_PERSONAL_LINK" => "N",
														"SHOW_NUM_PRODUCTS" => "Y",
														"SHOW_TOTAL_PRICE" => "Y",
														"SHOW_PRODUCTS" => "N",
														"POSITION_FIXED" =>"N"
													),
													false,
													array()
												);
											*/?>
											<?/*
											<a href="/checkout/cart/" id="cartHeader"><strong>Корзина</strong> (<span>0</span>)</a>
											*/?>
										</li>
									</ul>

								<? } ?>

							</div>
						</div>
					</div>

					<p class="welcome-msg">Добро пожаловать в наш онлайн магазин!</p>

				</div>
			</div>
		</div>

		<div class="container">
			<div class="page-header-container">

				<a href="/" title="Shock Doctor: Hardcore Protection, Fearless Performance" class="logo">
                    <img src="<?=SITE_TEMPLATE_PATH?>/images/shock-doctor-logo.png" alt="Shock Doctor: Hardcore Protection, Fearless Performance" width="360" height="37">
                </a>

				<div class="f-right">

					<div class="header-minicart desktop">
						<?

							$APPLICATION->IncludeComponent(
								"bitrix:sale.basket.basket.line",
								"basket_line_shockdoctor",
								array(
									"PATH_TO_BASKET" => SITE_DIR."personal/cart/",
									"PATH_TO_PERSONAL" => SITE_DIR."personal/",
									"SHOW_PERSONAL_LINK" => "N",
									"SHOW_NUM_PRODUCTS" => "Y",
									"SHOW_TOTAL_PRICE" => "Y",
									"SHOW_PRODUCTS" => "N",
									"POSITION_FIXED" =>"N"
								),
								false,
								array()
							);

						?>

						<?
							/*
							$cntBasketItems = CSaleBasket::GetList(
							   array(),
							   array(
								  "FUSER_ID" => CSaleBasket::GetBasketUserID(),
								  "LID" => SITE_ID,
								  "ORDER_ID" => "NULL"
							   ),
							   array()
							);
							*/
						?>
							<?
								$APPLICATION->IncludeComponent(
									"bitrix:sale.basket.basket.small",
									"popup_shockdoctor",
									Array(
										"PATH_TO_BASKET" => "/personal/cart/",
										"PATH_TO_ORDER" => "/personal/order/make/",
										"SHOW_DELAY" => "Y",
										"SHOW_NOTAVAIL" => "Y",
										"SHOW_SUBSCRIBE" => "Y"
									)
								);
							?>
						<? if($cntBasketItems == 0) { /*?>
							<div id="top-cart-container">
								<!--{CART_SIDEBAR_a8f425f238218db362da452140399803}-->
								<div class="top-cart">
									<div id="topCartContent" class="block-content" style="display:none">
										<div class="inner-wrapper" style="">
											<div class="arrow"></div>
											<p class="block-subtitle">
												<span onclick="Enterprise.TopCart.hideCart()" class="close-btn">
													<img src="/bitrix/templates/shockdoctor/images/close-button.png" alt="Close">
												</span>
												<span class="title">Корзина</span>
											</p>
											<p class="cart-empty">У Вас нет товаров в корзине.</p>
										</div>
									</div>
									<script type="text/javascript">
										Enterprise.TopCart.initialize('topCartContent', 'cartHeader', '/');
										// Below can be used to show minicart after item added
										// Enterprise.TopCart.showCart(7);
									</script>
								</div>
							</div>
						<?*/ } else { ?>

						<? } ?>
					</div>

					<div class="header-search desktop">

						<?
						// Поиск по каталогу ID инфоблока 16

							$APPLICATION->IncludeComponent (
								"bitrix:catalog.search",
								"shockdoctor",
								Array(
									"AJAX_MODE" => "Y",
									"IBLOCK_TYPE" => "catalog",
									"IBLOCK_ID" => "16",
									"ELEMENT_SORT_FIELD" => "sort",
									"ELEMENT_SORT_ORDER" => "asc",
									"ELEMENT_SORT_FIELD2" => "id",
									"ELEMENT_SORT_ORDER2" => "desc",

									"SECTION_URL" => "",
									"DETAIL_URL" => "",

									"BASKET_URL" => "/personal/basket.php",

									"ACTION_VARIABLE" => "action",
									"PRODUCT_ID_VARIABLE" => "id",
									"PRODUCT_QUANTITY_VARIABLE" => "quantity",
									"PRODUCT_PROPS_VARIABLE" => "prop",

									"SECTION_ID_VARIABLE" => "SECTION_ID",

									"DISPLAY_COMPARE" => "Y",
									"PAGE_ELEMENT_COUNT" => "30",
									"LINE_ELEMENT_COUNT" => "3",

									"PROPERTY_CODE" => array(),

									"OFFERS_FIELD_CODE" => array(),

									"OFFERS_PROPERTY_CODE" => array(),

									"OFFERS_SORT_FIELD" => "sort",
									"OFFERS_SORT_ORDER" => "asc",

									"OFFERS_SORT_FIELD2" => "id",
									"OFFERS_SORT_ORDER2" => "desc",

									"OFFERS_LIMIT" => "20",

									"PRICE_CODE" => array("BASE"),

									"USE_PRICE_COUNT" => "Y",
									"SHOW_PRICE_COUNT" => "1",
									"PRICE_VAT_INCLUDE" => "Y",
									"USE_PRODUCT_QUANTITY" => "Y",

									"CACHE_TYPE" => "A",
									"CACHE_TIME" => "36000000",

									"RESTART" => "Y",
									"NO_WORD_LOGIC" => "Y",
									"USE_LANGUAGE_GUESS" => "Y",
									"CHECK_DATES" => "Y",
									"DISPLAY_TOP_PAGER" => "Y",
									"DISPLAY_BOTTOM_PAGER" => "Y",
									"PAGER_TITLE" => "Товары",
									"PAGER_SHOW_ALWAYS" => "Y",
									"PAGER_TEMPLATE" => "",
									"PAGER_DESC_NUMBERING" => "Y",
									"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
									"PAGER_SHOW_ALL" => "Y",
									"HIDE_NOT_AVAILABLE" => "N",
									"CONVERT_CURRENCY" => "Y",
									"CURRENCY_ID" => "RUB",
									"OFFERS_CART_PROPERTIES" => array(),
									"AJAX_OPTION_JUMP" => "Y",
									"AJAX_OPTION_STYLE" => "Y",
									"AJAX_OPTION_HISTORY" => "Y"
								)
							);

						?>

					</div>

				</div>
			</div>
		</div>

		<?/*
        <div class="header-promos">
			<? if (!$USER->IsAuthorized()) { ?>
				<p class="cta">
					<? /login/?register=yes ?>
					 <a class="registration_link" href="/register/">Регистрация здесь</a>
				</p>
			<? } ?>
            <p class="cta header-outlet <? if ($USER->IsAuthorized()) { ?>header-auth<? } ?>">
                <a href="/sale/">Распродажи</a>
            </p>
        </div>
		*/?>

    </div> <!-- end header-contents -->

</div> <!-- end header -->

<?
	$APPLICATION->IncludeComponent(
		'bitrix:menu',
		"top_menu_shockdoctor", array(

				"ROOT_MENU_TYPE" => "top",
				"MENU_CACHE_TYPE" => "Y",
				"MENU_CACHE_TIME" => "36000000",
				"MENU_CACHE_USE_GROUPS" => "Y",
				"MENU_CACHE_GET_VARS" => array(),
				"MAX_LEVEL" => "1",
				"USE_EXT" => "N",
				"ALLOW_MULTI_SELECT" => "N"

		)
	);
?>

<?
	// Слайдер отображаем только на главной
	// ВРЕМЕННО СКРЫТ
	if($dir == '/' && ERROR_404 != 'Y') { ?>
		<!--<a href="/catalog/kappy/"><img style="width: 100%;" src="<?=SITE_TEMPLATE_PATH?>/media/main/main_1.png" /></a>-->
	<?}

	//if(false) {
?>

<? // [Вывод верхнего баннера на Главной странице] ?>
	<?
		$uri = $APPLICATION->GetCurUri(); //."index.php";
		//$dir = $APPLICATION->GetCurDir(false);

		$IBLOCK_ID = 18; // Инфоблок "полноразмерный баннер вверху страницы"
		$arSelect = Array("ID","IBLOCK_ID","NAME","DATE_ACTIVE_FROM","DETAIL_TEXT", "DETAIL_TEXT_TYPE", "DETAIL_PICTURE","PROPERTY_*");//IBLOCK_ID и ID обязательно должны быть указаны, см. описание arSelectFields выше
		if($dir == '/') {
			$arFilter = Array("IBLOCK_ID"=>IntVal($IBLOCK_ID), "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y", "PROPERTY_CONNECT_TO_URL"=>"".$dir."");
		} else {
			$arFilter = Array("IBLOCK_ID"=>IntVal($IBLOCK_ID), "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y", "PROPERTY_CONNECT_TO_URL"=>"".$dir."%");
		}

		$res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize"=>10), $arSelect);
		$listTopBanners = array();
		while($ob = $res->GetNextElement()){

			$arFields = $ob->GetFields();
			$arProps = $ob->GetProperties();

			$listTopBanners[] = array(
				"ID" => $arFields["ID"],
				"NAME" => $arFields["NAME"],
				"TEXT" => $arFields["DETAIL_TEXT"],
				"DETAIL_TEXT_TYPE" => $arFields["DETAIL_TEXT_TYPE"],
				"DETAIL_PICTURE" => $arFields["DETAIL_PICTURE"],
				"LINK" => $arProps["LINK"]["VALUE"],
				"BUTTON_HTML" => $arProps["BUTTON_HTML"]["VALUE"],
				// "FIRST_BANNER" => $arProps["FIRST_BANNER"]["VALUE"],
				// "SECOND_BANNER" => $arProps["SECOND_BANNER"]["VALUE"],
				// "THREE_BANNER" => $arProps["THREE_BANNER"]["VALUE"],
			);

		}

	?>


<? if(count($listTopBanners) > 0) { ?>
<div class="feature-slider">
    <div class="feature-slider-slides" style="min-height: 655px;">

	<? foreach($listTopBanners as $key => $val) { ?>
		<div id="banner-<?=($key + 1) ?>" class="feature-slider-slide feature-slider-ice" style="display: none;">

			<? if($val[TEXT] != '') { ?>
				<?
				if ('html' == $val['DETAIL_TEXT_TYPE'])
				{
					echo $val["TEXT"];
				}
				else
				{
					?><p><? echo $val["TEXT"]; ?></p><?
				}
				?>
			<? } else { ?>
				<a <? if($val["LINK"] != '') { ?>href="<?=$val["LINK"]?>"<? } ?>><?=$val["TEXT"]?></a>
			<? } ?>

        </div>
	<? } ?>

    </div> <!-- end feature-slider-slides -->

    <div class="feature-slider-nav">
        <ul>
			<? foreach($listTopBanners as $key => $val) { ?>
				<li class="feature-slider-ice-nav">
					<a href="#banner-<?=($key + 1) ?>">
						<?=htmlspecialcharsBack($val["BUTTON_HTML"])?>
					</a>
				</li>
			<? } ?>

        </ul>
    </div> <!-- end feature-slider-nav -->
</div> <!-- end feature-slider -->
	<? } else { ?>

		<? // Если нет - ничего не выводим ?>

	<? } ?>
<? // [/Вывод верхнего баннера на Главной странице] ?>
<?
//	}
?>

<? if(strpos($dir,'/catalog') === false && strpos($dir,'/sports') === false && strpos($dir,'/sale') === false) { ?>
<div class="main<? if($dir == '/' && ERROR_404 != 'Y') {?> home<? } elseif( strpos($dir,'/athletes') !== false || strpos($dir,'/register') !== false || strpos($dir,'/login') !== false || strpos($dir,'/personal') !== false || strpos($dir,'/company/news') !== false || strpos($dir,'/auth') !== false || ERROR_404 == 'Y') { ?> col1-layout<? } elseif( strpos($dir,'/search') !== false ) { ?> list<? } ?>">

	<? if(strpos($dir,'/personal/cart') !== false) { ?>
	<div class="cart">
	<? } elseif(
				$dir != '/' &&
				strpos($dir,'/athletes') === false &&
				strpos($dir,'/search') === false &&
				strpos($dir,'/register') === false &&
				strpos($dir,'/login') === false &&
				strpos($dir,'/personal') === false &&
				strpos($dir,'/company/news') === false &&
				strpos($dir,'/auth') === false

	) { ?>
	<div class="content">
	<div class="modules">
	<? } elseif(
			strpos($dir,'/athletes') !== false ||
				strpos($dir,'/auth') !== false
		) { ?>
	<div class="col-main">
	<? } ?>
<? } ?>
