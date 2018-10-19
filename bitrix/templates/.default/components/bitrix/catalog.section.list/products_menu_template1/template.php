<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
$arFilter = array(
	"IBLOCK_ID" => 2,
	"ACTIVE" => "Y",
	"DEPTH_LEVEL" => 1
);
$rsSect = CIBlockSection::GetList (array("sort" => "asc"), $arFilter);
?>
<div class="grid_4 alpha">
	<ul class="sublist">
	<?
	$t = 0;
	while($arSect = $rsSect->Fetch())
	{
	$t++;
	if($t <= 5){
	?>
		<li><a href="/products/<?=$arSect['CODE']?>/"><?=$arSect['NAME']?></a></li>
	<?	}}	?>
	</ul>
</div>
<div class="grid_3 omega">
	<ul class="sublist">
	<?
	$arFilter = array(
		"IBLOCK_ID" => 2,
		"ACTIVE" => "Y",
		"DEPTH_LEVEL" => 1
	);
	$rsSect = CIBlockSection::GetList (array("sort" => "asc"), $arFilter);
	$t = 0;
	while($arSect = $rsSect->Fetch())
	{
	$t++;
	if($t > 5){
	?>
		<li><a href="/products/<?=$arSect['CODE']?>/"><?=$arSect['NAME']?></a></li>
	<?	}}	?>
	</ul>
</div>