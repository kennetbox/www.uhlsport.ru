<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
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

if (empty($arResult))
	return;
?>

<nav>
	<div id="mobilehome">
		<a href="/">
			<div></div>
		</a>
	</div>
	<div id="menubutton">
		<img src="<?=SITE_TEMPLATE_PATH?>/images/menu.png" title="Menu" alt=""/>
	</div>
	<ul id="menu">
		<li id="home">
			<a href="/">
				<div></div>
			</a>
		</li>
		<?foreach($arResult as $itemIdex => $arItem):?>
			<li><a href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a></li>
		<?endforeach;?>
	</ul>
</nav>
