<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
global $depthLevel, $curPage, $arFilter;
?>

<? if(strpos($curPage, 'vratarskie_perchatki') !== FALSE && $depthLevel <= 2): ?>

	<div class="container_14">
		<?
		$arCurDir = explode("/", $APPLICATION->GetCurDir());
		$sectionCode = $arCurDir[2];
		$sectId = getIdByCode($sectionCode, 2, IBLOCK_SECTION);
		$arFilter = array(
			'LOGIC'=>'AND',
			"IBLOCK_ID" => 2,
			"ACTIVE" => "Y",
			"DEPTH_LEVEL" => 2,
			"SECTION_ID" => $sectId,
		);
		$rsSect = CIBlockSection::GetList (array("sort" => "asc"), $arFilter);
		while($arSect = $rsSect->Fetch())
		{
		?>
			<div class="grid_5">
				<h3 class="linkhighlights">
					<a href="/products/<?=$arSect['CODE']?>/">
						<?=$arSect['NAME']?>
					</a>
				</h3>
			</div>
		<?	}	?>
	
		<div class="cleaner"></div>
	
	</div>

<? else: ?>

	<div class="container_16">
		<ul class="image-grid lower">
		<?
		$arCurDir = explode("/", $APPLICATION->GetCurDir());
		$sectionCode = $arCurDir[2];
		$sectId = getIdByCode($sectionCode, 2, IBLOCK_SECTION);
		$arFilter = array(
			'LOGIC'=>'AND',
			"IBLOCK_ID" => 2,
			"ACTIVE" => "Y",
			"DEPTH_LEVEL" => 2,
			"SECTION_ID" => $sectId,
		);
		$rsSect = CIBlockSection::GetList (array("sort" => "asc"), $arFilter);
		while($arSect = $rsSect->Fetch())
		{
		?>
			<li>
				<a href="/products/<?=$arSect['CODE']?>/">
					<?	$srcPic = CFile::GetPath($arSect["PICTURE"]);	?>
					<img class="pthumb lazy" src="<?=$srcPic?>">
					<div><?=$arSect['NAME']?></div>
				</a>
			</li>
		<?	}	?>
		</ul>
	</div>

<? endif; ?>
