<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="container_16">
	<ul class="image-grid lower">
	<?
	$arFilter = array(
		"IBLOCK_ID" => 2,
		"ACTIVE" => "Y",
		"DEPTH_LEVEL" => 1
	);
	$rsSect = CIBlockSection::GetList (array("sort" => "asc"), $arFilter);
	while($arSect = $rsSect->Fetch())
    {
	// Пропускаем вывод раздела "Склад в Германии"
	if($arSect['ID'] == 76) continue;
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