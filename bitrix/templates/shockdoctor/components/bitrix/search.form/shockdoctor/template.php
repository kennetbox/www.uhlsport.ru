<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
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
$this->setFrameMode(true);?>

<form action="<?=$arResult["FORM_ACTION"]?>">

	<div class="form-search">
	
		<?
			if($arParams["USE_SUGGEST"] === "Y"):
		?>
		
		<?
			$APPLICATION->IncludeComponent(
				"bitrix:search.suggest.input",
				"shockdoctor",
				array(
					"ID" => "search",
					"NAME" => "q",
					"VALUE" => "",
					"INPUT_SIZE" => 15,
					"DROPDOWN_SIZE" => 10,
					"CLASS" => "search-input",
				),
				$component, array("HIDE_ICONS" => "Y")
			);
		?>
		
		<?
			else:
		?>
		
			<input class="search-input" type="text" name="q" value="" size="15" maxlength="50" />
		
		<?
			endif;
		?>

		<button  name="s" type="submit" class="search-submit"><?=GetMessage("BSF_T_SEARCH_BUTTON");?></button>
			
	</div>

</form>

