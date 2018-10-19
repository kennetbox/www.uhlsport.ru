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
$this->setFrameMode(true);
?>
<div class="feature_gloves">
	<?
	$arCurDir = explode("/", $APPLICATION->GetCurDir());
	?>
	<script>
        var filtertech = <?if($arCurDir[2] == "vratarskie_svitery" || $arCurDir[2] == "vratarskie_shorty_i_bryuki" || $arCurDir[2]=="igrovaya_obuv" || $arCurDir[2] == "igrovye_myachi" || $arCurDir[2]=="trenirovochnye_myachi" || $arCurDir[2]=="detskie_i_spetsialnye_myachi" || $arCurDir[2]=="futzalnye_myachi" || $arCurDir[2]=="zashchita_i_bandazhi" || $arCurDir[2]=="funktsionalnye_sumki" || $arCurDir[2] == "kollektsiya_braziliya_2014"){echo "false";}else{echo "true";}?>;
        var filterprop = <?if($arCurDir[2] == "vratarskie_svitery" || $arCurDir[2] == "vratarskie_shorty_i_bryuki" || $arCurDir[2]=="funktsionalnye_sumki" || $arCurDir[2] == "kollektsiya_braziliya_2014"){echo "true";}else{echo "false";}?>;
        var filtercollection = <?if($arCurDir[2] == "vratarskie_svitery" || $arCurDir[2] == "vratarskie_perchatki" || $arCurDir[2] == "vratarskie_shorty_i_bryuki" || $arCurDir[2]== "igrovaya_obuv" || $arCurDir[2] == "igrovye_myachi" || $arCurDir[2]=="trenirovochnye_myachi" || $arCurDir[2]=="detskie_i_spetsialnye_myachi" || $arCurDir[2]=="futzalnye_myachi" || $arCurDir[2]=="zashchita_i_bandazhi" || $arCurDir[2]=="funktsionalnye_sumki" || $arCurDir[2] == "kollektsiya_braziliya_2014") {echo "false";}else{echo "true";}?>;
    </script>
	<div class="container_16">
		<div class="grid_12">
			<ul id="productlist" class="image-grid image-grid-left" style="height: 1740px; width: 730px;">
			<?$t = 0;?>
			<?foreach($arResult["ITEMS"] as $arItem){
			$t++;
			?>
				<li data-new="<?if($arItem["PROPERTIES"]["NEWPRODUCT"]["VALUE_ENUM_ID"] == "1"){echo "0";}else{echo "1";}?>" data-id="<?=$arItem["PROPERTIES"]["ARTNUMBER"]["VALUE"]?>" data-color="<?=$arItem["PROPERTIES"]["MAIN_COLOR"]["VALUE"]?>" data-sort="<?=$t?>" data-prop="<?if($arCurDir[2]=="vratarskie_perchatki"){?>gk,finder_gk,goalkeeper<?}?><?foreach($arItem["PROPERTIES"]["FOAM"]["VALUE"] as $arPr){echo ",".$arPr;}?><?foreach($arItem["PROPERTIES"]["CUT"]["VALUE"] as $arPr){echo ",".$arPr;}?><?foreach($arItem["PROPERTIES"]["FINGER_PROTECTION"]["VALUE"] as $arPr){echo ",".$arPr;}?><?if($arItem["PROPERTIES"]["KID_SIZE"]["VALUE"] == "Y"){echo ",kid";}?>">
                    <a href="<?=$arItem["DETAIL_PAGE_URL"]?>">
						<img style="height: 160px;" class="pthumb lazy" src="<?=$arItem["DETAIL_PICTURE"]["SRC"]?>">
                        <h4><?=$arItem["NAME"]?></h4>                        
                        <div class="color"><?=$arItem["PROPERTIES"]["COLOR"]["VALUE"]?></div>
                        <span class="price"><?=$arItem["PRICES"]["BASE"]["PRINT_VALUE_NOVAT"]?></span>
						<?if($arItem["PROPERTIES"]["NEWPRODUCT"]["VALUE_ENUM_ID"] == "1"){?><span class="new"></span><?}?>
                    </a>
                </li>
			<?}?>
			</ul>
		</div>
		<?if(array_search('vratarskie_perchatki',$arCurDir)){?>
		<div class="grid_4" id="ffilter">
        <div class="filter_top"></div>
        <div class="filter">
            <div>
                <fieldset>
                    <legend>Сортировка</legend>
                    
                    <input id="sort_color" type="radio" name="sort" value="color">
                    <label for="sort_color">По цветам</label><br>
                    
                    <input id="sort_name" type="radio" name="sort" checked="checked" value="name">
                    <label id="sort_name">По цене</label><br>
                    
                        <input type="radio" name="sort" value="new" id="sort_new">
                        <label for="sort_new">Новинки</label>
                </fieldset>

                   <hr style="margin:0; margin-left:10px; margin-right:20px; margin-bottom:20px; margin-top:-20px;">
                        <fieldset>
                            
                            <a data-key="Foam" class="udropdown techbutton" style="width:180px; display:block;" href="#">Пеноматериал
                                <br>
                                <span style="font-weight:bold;font-size:10px;line-height:22px;" class="techtext" id="info_Foam">Absolutgrip, Absolutgrip+, Aquasoft, Supersoft +, Soft, Starter Soft, Starter Stripe, Soft Graphit, Starter Graphit, Super Graphit</span>
                            </a>                        
                            <ul id="Foam" class="icons techninfos" style="margin-top:0;padding:0;display:none;">
                                
                                                                    <li title="For dry and wet weather" rel="tooltip">
                                        <div><input data-name="Absolutgrip" data-key="Foam" type="checkbox" checked="checked" name="tech_1" value="absolutgrip">
                                        <img src="/images/prop/absolutgrip.png"></div>
                                        <span>Absolutgrip</span>
                                    </li>
                                    <li title="For dry and wet weather" rel="tooltip">
                                        <div><input data-name="Absolutgrip+" data-key="Foam" type="checkbox" checked="checked" name="tech_1" value="absolutgripplus">
                                        <img src="/images/prop/absolutgripplus.png"></div>
                                        <span>Absolutgrip+</span>
                                    </li>
                                    <li title="For wet weather" rel="tooltip">
                                        <div><input data-name="Aquasoft" data-key="Foam" type="checkbox" checked="checked" name="tech_1" value="aquasoft">
                                        <img src="/images/prop/aquasoft.png"></div>
                                        <span>Aquasoft</span>
                                    </li>
                                    <li title="For pitches" rel="tooltip">
                                        <div><input data-name="Supersoft +" data-key="Foam" type="checkbox" checked="checked" name="tech_1" value="supersoftplus">
                                        <img src="/images/prop/supersoftplus.png"></div>
                                        <span>Supersoft +</span>
                                    </li>
                                    <li title="For pitches" rel="tooltip">
                                        <div><input data-name="Soft" data-key="Foam" type="checkbox" checked="checked" name="tech_1" value="soft">
                                        <img src="/images/prop/soft.png"></div>
                                        <span>Soft</span>
                                    </li>
                                    <li title="For pitches" rel="tooltip">
                                        <div><input data-name="Starter Soft" data-key="Foam" type="checkbox" checked="checked" name="tech_1" value="startersoft">
                                        <img src="/images/prop/startersoft.png"></div>
                                        <span>Starter Soft</span>
                                    </li>
                                    <li title="For artificial grass and hard courts" rel="tooltip">
                                        <div><input data-name="Starter Stripe" data-key="Foam" type="checkbox" checked="checked" name="tech_1" value="starterstripe">
                                        <img src="/images/prop/starterstripe.png"></div>
                                        <span>Starter Stripe</span>
                                    </li>
                                    <li title="For artificial grass and hard courts" rel="tooltip">
                                        <div><input data-name="Soft Graphit" data-key="Foam" type="checkbox" checked="checked" name="tech_1" value="softgraphit">
                                        <img src="/images/prop/softgraphit.png"></div>
                                        <span>Soft Graphit</span>
                                    </li>
                                    <li title="For artificial grass and hard courts" rel="tooltip">
                                        <div><input data-name="Starter Graphit" data-key="Foam" type="checkbox" checked="checked" name="tech_1" value="startergraphit">
                                        <img src="/images/prop/startergraphit.png"></div>
                                        <span>Starter Graphit</span>
                                    </li>
                                    <li title="For artificial grass and hard courts" rel="tooltip">
                                        <div><input data-name="Super Graphit" data-key="Foam" type="checkbox" checked="checked" name="tech_1" value="supergraphit">
                                        <img src="/images/prop/supergraphit.png"></div>
                                        <span>Super Graphit</span>
                                    </li>
                            </ul>
                        </fieldset>
                        <fieldset>
                            
                            <a data-key="Cut" class="udropdown techbutton" style="width:180px; display:block;" href="#">Покрой
                                <br>
                                <span style="font-weight:bold;font-size:10px;line-height:22px;" class="techtext" id="info_Cut">Classic Cut, Wide Cut, Close Cut, Rollfinger, Cut</span>
                            </a>                        
                            <ul id="Cut" class="icons techninfos" style="margin-top:0;padding:0;display:none;">
                                
                                                                    <li title="" rel="tooltip">
                                        <div><input data-name="Classic Cut" data-key="Cut" type="checkbox" checked="checked" name="tech_2" value="klassischer_schnitt">
                                        <img src="/images/prop/klassischer_schnitt.png"></div>
                                        <span>Classic Cut</span>
                                    </li>
                                    <li title="" rel="tooltip">
                                        <div><input data-name="Wide Cut" data-key="Cut" type="checkbox" checked="checked" name="tech_2" value="weiter_schnitt">
                                        <img src="/images/prop/weiter_schnitt.png"></div>
                                        <span>Wide Cut</span>
                                    </li>
                                    <li title="" rel="tooltip">
                                        <div><input data-name="Close Cut" data-key="Cut" type="checkbox" checked="checked" name="tech_2" value="halfnegative">
                                        <img src="/images/prop/halfnegative.png"></div>
                                        <span>Close Cut</span>
                                    </li>
                                    <li title="Seemless all-round grip for perfect ball control" rel="tooltip">
                                        <div><input data-name="Rollfinger" data-key="Cut" type="checkbox" checked="checked" name="tech_2" value="rollfinger">
                                        <img src="/images/prop/rollfinger.png"></div>
                                        <span>Rollfinger</span>
                                    </li>
                                    <li title="Seemless all-round grip for perfect ball control" rel="tooltip">
                                        <div><input data-name="Cut" data-key="Cut" type="checkbox" checked="checked" name="tech_2" value="absolutroll">
                                        <img src="/images/prop/absolutroll.png"></div>
                                        <span>Cut</span>
                                    </li>
                            </ul>
                        </fieldset>
                        <fieldset>
                            
                            <a data-key="FingerProtection" class="udropdown techbutton" style="width:180px; display:block;" href="#">Защита пальцев
                                <br>
                                <span style="font-weight:bold;font-size:10px;line-height:22px;" class="techtext" id="info_FingerProtection">Without, Bionik X-Change, Bionikframe +, Bionikframe, Supportframe, Stabilization, Schockzone</span>
                            </a>                        
                            <ul id="FingerProtection" class="icons techninfos" style="margin-top:0;padding:0;display:none;">
                                
                                <li>
                                    <div><input data-name="Without" data-key="FingerProtection" type="checkbox" name="tech_3" value="without" checked="checked"></div>
                                    <span>Without</span>
                                 </li>
                                                                    <li title="Slight stabilisation with additional thumb protection and interchangeable stabilisation element" rel="tooltip">
                                        <div><input data-name="Bionik X-Change" data-key="FingerProtection" type="checkbox" checked="checked" name="tech_3" value="bionikframe_x-change_mit_thumbframe">
                                        <img src="/images/prop/bionikframe_x-change_mit_thumbframe.png"></div>
                                        <span>Bionik X-Change</span>
                                    </li>
                                    <li title="Slight stabilisation with additional thumb protection" rel="tooltip">
                                        <div><input data-name="Bionikframe +" data-key="FingerProtection" type="checkbox" checked="checked" name="tech_3" value="bionikframeplus_mit_thumbframe">
                                        <img src="/images/prop/bionikframeplus_mit_thumbframe.png"></div>
                                        <span>Bionikframe +</span>
                                    </li>
                                    <li title="Slight stabilisation" rel="tooltip">
                                        <div><input data-name="Bionikframe" data-key="FingerProtection" type="checkbox" checked="checked" name="tech_3" value="bionikframe">
                                        <img src="/images/prop/bionikframe.png"></div>
                                        <span>Bionikframe</span>
                                    </li>
                                    <li title="Stabilisation for entry level and children's models" rel="tooltip">
                                        <div><input data-name="Supportframe" data-key="FingerProtection" type="checkbox" checked="checked" name="tech_3" value="supportframe">
                                        <img src="/images/prop/supportframe.png"></div>
                                        <span>Supportframe</span>
                                    </li>
                                    <li title="For perfect fit, finger stabilisation and climate control" rel="tooltip">
                                        <div><input data-name="Stabilization" data-key="FingerProtection" type="checkbox" checked="checked" name="tech_3" value="handbett">
                                        <img src="/images/prop/handbett.png"></div>
                                        <span>Stabilization</span>
                                    </li>
                                    <li title="For additional shock absorption and wear resistance at the side of the hand" rel="tooltip">
                                        <div><input data-name="Schockzone" data-key="FingerProtection" type="checkbox" checked="checked" name="tech_3" value="schockzone">
                                        <img src="/images/prop/schockzone.png"></div>
                                        <span>Schockzone</span>
                                    </li>
                            </ul>
                        </fieldset>
                    <hr style="margin-left:10px; margin-right:20px; margin-bottom:20px; margin-top:-20px;">


                <fieldset>
                    <legend>Colours at a glance</legend>
                        <input style="clear:both;" type="checkbox" name="color" checked="checked" value="black"> 
                        <label title="black" style="display:block;margin-top:3px;float:left;width:10px;height:10px;border:1px solid black;background-color:#000000;" class="jquery-checkbox-checked light" labelfor="color">
                        </label>
Черный<br>
                        <input style="clear:both;" type="checkbox" name="color" checked="checked" value="blue"> 
                        <label title="blue" style="display:block;margin-top:3px;float:left;width:10px;height:10px;border:1px solid black;background-color:#004B8B;" class="jquery-checkbox-checked " labelfor="color">
                        </label>
Синий <br>
                        <input style="clear:both;" type="checkbox" name="color" checked="checked" value="grey"> 
                        <label title="grey" style="display:block;margin-top:3px;float:left;width:10px;height:10px;border:1px solid black;background-color:#4F565B;" class="jquery-checkbox-checked light" labelfor="color">
                        </label>
Серый<br>
                        <input style="clear:both;" type="checkbox" name="color" checked="checked" value="white"> 
                        <label title="white" style="display:block;margin-top:3px;float:left;width:10px;height:10px;border:1px solid black;background-color:#FFFFFF;" class="jquery-checkbox-checked " labelfor="color">
                        </label>
Белый<br>
                </fieldset>
            </div>
        </div>
        <div class="filter_bottom"></div>
    </div>
	<?
	}
	if($arCurDir[2] == "vratarskie_svitery"){
	?>
		<div class="grid_4" id="ffilter">
        <div class="filter_top"></div>
        <div class="filter">
            <div>
                <fieldset>
                    <legend>Сортировка</legend>
                    
                    <input id="sort_color" type="radio" name="sort" value="color">
                    <label for="sort_color">По цветам</label><br>
                    
                    <input id="sort_name" type="radio" name="sort" checked="checked" value="name">
                    <label id="sort_name">По цене</label><br>
                    
                        <input type="radio" name="sort" value="new" id="sort_new">
                        <label for="sort_new">Новинки</label>
                </fieldset>


                    <fieldset>
                        <legend>View</legend>
                        <label></label>
                        <input type="radio" name="main" value="all" checked="checked">
                        Все<br>
                        <label></label>
                                                                            <input type="radio" name="main" value="kid">
Детский<br>
                    </fieldset>

                <fieldset>
                    <legend>Colours at a glance</legend>
                        <input style="clear:both;" type="checkbox" name="color" checked="checked" value="black"> 
                        <label title="black" style="display:block;margin-top:3px;float:left;width:10px;height:10px;border:1px solid black;background-color:#000000;" class="jquery-checkbox-checked light" labelfor="color">
                        </label>
Черный<br>
                        <input style="clear:both;" type="checkbox" name="color" checked="checked" value="blue"> 
                        <label title="blue" style="display:block;margin-top:3px;float:left;width:10px;height:10px;border:1px solid black;background-color:#004B8B;" class="jquery-checkbox-checked " labelfor="color">
                        </label>
Синий<br>
                        <input style="clear:both;" type="checkbox" name="color" checked="checked" value="green"> 
                        <label title="green" style="display:block;margin-top:3px;float:left;width:10px;height:10px;border:1px solid black;background-color:#308030;" class="jquery-checkbox-checked " labelfor="color">
                        </label>
Зеленый<br>
                        <input style="clear:both;" type="checkbox" name="color" checked="checked" value="grey"> 
                        <label title="grey" style="display:block;margin-top:3px;float:left;width:10px;height:10px;border:1px solid black;background-color:#4F565B;" class="jquery-checkbox-checked light" labelfor="color">
                        </label>
Серый<br>
                        <input style="clear:both;" type="checkbox" name="color" checked="checked" value="orange"> 
                        <label title="orange" style="display:block;margin-top:3px;float:left;width:10px;height:10px;border:1px solid black;background-color:#E77817;" class="jquery-checkbox-checked light" labelfor="color">
                        </label>
Оранжевый<br>
                        <input style="clear:both;" type="checkbox" name="color" checked="checked" value="red"> 
                        <label title="red" style="display:block;margin-top:3px;float:left;width:10px;height:10px;border:1px solid black;background-color:#CB1009;" class="jquery-checkbox-checked " labelfor="color">
                        </label>
Красный<br>
                        <input style="clear:both;" type="checkbox" name="color" checked="checked" value="yellow"> 
                        <label title="yellow" style="display:block;margin-top:3px;float:left;width:10px;height:10px;border:1px solid black;background-color:#FFF500;" class="jquery-checkbox-checked light" labelfor="color">
                        </label>
Желтый<br>
                </fieldset>
            </div>
        </div>
        <div class="filter_bottom"></div>
    </div>
	<?}
	if($arCurDir[2] == "vratarskie_shorty_i_bryuki"){?>
		<div class="grid_4" id="ffilter">
        <div class="filter_top"></div>
        <div class="filter">
            <div>
                <fieldset>
                    <legend>Сортировка</legend>
                    
                    <input id="sort_color" type="radio" name="sort" value="color">
                    <label for="sort_color">По цвету</label><br>
                    
                    <input id="sort_name" type="radio" name="sort" checked="checked" value="name">
                    <label id="sort_name">По цене</label><br>
                    
                </fieldset>


                    <fieldset>
                        <legend>View</legend>
                        <label></label>
                        <input type="radio" name="main" value="all" checked="checked">
                        Все<br>
                        <label></label>
                                                                            <input type="radio" name="main" value="kid">
Детям<br>
                    </fieldset>

                <fieldset>
                    <legend>Colours at a glance</legend>
                        <input style="clear:both;" type="checkbox" name="color" checked="checked" value="black"> 
                        <label title="black" style="display:block;margin-top:3px;float:left;width:10px;height:10px;border:1px solid black;background-color:#000000;" class="jquery-checkbox-checked light" labelfor="color">
                        </label>
Черный<br>
                </fieldset>
            </div>
        </div>
        <div class="filter_bottom"></div>
    </div>
	<?}
	if($arCurDir[2]=="igrovaya_obuv"){?>
	<div class="grid_4" id="ffilter">
        <div class="filter_top"></div>
        <div class="filter">
            <div>
                <fieldset>
                    <legend>Сортировка</legend>
                    
                    <input id="sort_color" type="radio" name="sort" value="color">
                    <label for="sort_color">По цвету</label><br>
                    
                    <input id="sort_name" type="radio" name="sort" checked="checked" value="name">
                    <label id="sort_name">По цене</label><br>
                    
                </fieldset>



                <fieldset>
                    <legend>Colours at a glance</legend>
                        <input style="clear:both;" type="checkbox" name="color" checked="checked" value="black"> 
                        <label title="black" style="display:block;margin-top:3px;float:left;width:10px;height:10px;border:1px solid black;background-color:#000000;" class="jquery-checkbox-checked light" labelfor="color">
                        </label>
Черный<br>
                        <input style="clear:both;" type="checkbox" name="color" checked="checked" value="grey"> 
                        <label title="grey" style="display:block;margin-top:3px;float:left;width:10px;height:10px;border:1px solid black;background-color:#4F565B;" class="jquery-checkbox-checked light" labelfor="color">
                        </label>
Серый<br>
                </fieldset>
            </div>
        </div>
        <div class="filter_bottom"></div>
    </div>
	<?}
	if($arCurDir[2] == "igrovye_myachi" || $arCurDir[2]=="trenirovochnye_myachi" || $arCurDir[2]=="detskie_i_spetsialnye_myachi" || $arCurDir[2]=="futzalnye_myachi"){?>
		<div class="grid_4" id="ffilter">
        <div class="filter_top"></div>
        <div class="filter">
            <div>
                <fieldset>
                    <legend>Сортировка</legend>
                    
                    <input id="sort_color" type="radio" name="sort" value="color">
                    <label for="sort_color">По цвету</label><br>
                    
                    <input id="sort_name" type="radio" name="sort" checked="checked" value="name">
                    <label id="sort_name">По цене</label><br>
                    
                </fieldset>



                <fieldset>
                    <legend>Colours at a glance</legend>
                        <input style="clear:both;" type="checkbox" name="color" checked="checked" value="white"> 
                        <label title="white" style="display:block;margin-top:3px;float:left;width:10px;height:10px;border:1px solid black;background-color:#FFFFFF;" class="jquery-checkbox-checked " labelfor="color">
                        </label>
Белый<br>
                </fieldset>
            </div>
        </div>
        <div class="filter_bottom"></div>
    </div>
	<?}
	if($arCurDir[2]=="zashchita_i_bandazhi"){?>
		<div class="grid_4" id="ffilter">
        <div class="filter_top"></div>
        <div class="filter">
            <div>
                <fieldset>
                    <legend>Сортировка</legend>
                    
                    <input id="sort_color" type="radio" name="sort" value="color">
                    <label for="sort_color">По цвету</label><br>
                    
                    <input id="sort_name" type="radio" name="sort" checked="checked" value="name">
                    <label id="sort_name">По цене</label><br>
                    
                </fieldset>



                <fieldset>
                    <legend>Colours at a glance</legend>
                        <input style="clear:both;" type="checkbox" name="color" checked="checked" value="black"> 
                        <label title="black" style="display:block;margin-top:3px;float:left;width:10px;height:10px;border:1px solid black;background-color:#000000;" class="jquery-checkbox-checked light" labelfor="color">
                        </label>
Черный<br>
                        <input style="clear:both;" type="checkbox" name="color" checked="checked" value="white"> 
                        <label title="white" style="display:block;margin-top:3px;float:left;width:10px;height:10px;border:1px solid black;background-color:#FFFFFF;" class="jquery-checkbox-checked " labelfor="color">
                        </label>
Белый<br>
                </fieldset>
            </div>
        </div>
        <div class="filter_bottom"></div>
    </div>
	<?}
	if($arCurDir[2]=="funktsionalnye_sumki"){?>
		<div class="grid_4" id="ffilter">
        <div class="filter_top"></div>
        <div class="filter">
            <div>
                <fieldset>
                    <legend>Сортировка</legend>
                    
                    <input id="sort_color" type="radio" name="sort" value="color">
                    <label for="sort_color">По цвету</label><br>
                    
                    <input id="sort_name" type="radio" name="sort" checked="checked" value="name">
                    <label id="sort_name">По цене</label><br>
                    
                        <input type="radio" name="sort" value="new" id="sort_new">
                        <label for="sort_new">Новинки</label>
                </fieldset>


                    <fieldset>
                        <legend>View</legend>
                        <label></label>
                        <input type="radio" name="main" value="all" checked="checked">
                        Все<br>
                        <label></label>
                                                                            <input type="radio" name="main" value="kid">
Детям<br>
                    </fieldset>

                <fieldset>
                    <legend>Colours at a glance</legend>
                        <input style="clear:both;" type="checkbox" name="color" checked="checked" value="black"> 
                        <label title="black" style="display:block;margin-top:3px;float:left;width:10px;height:10px;border:1px solid black;background-color:#000000;" class="jquery-checkbox-checked light" labelfor="color">
                        </label>
Черный<br>
                        <input style="clear:both;" type="checkbox" name="color" checked="checked" value="yellow"> 
                        <label title="yellow" style="display:block;margin-top:3px;float:left;width:10px;height:10px;border:1px solid black;background-color:#FFF500;" class="jquery-checkbox-checked light" labelfor="color">
                        </label>
Желтый<br>
                </fieldset>
            </div>
        </div>
        <div class="filter_bottom"></div>
    </div>
	<?}
	if($arCurDir[2] == "kollektsiya_braziliya_2014"){?>
		<div class="grid_4" id="ffilter">
        <div class="filter_top"></div>
        <div class="filter">
            <div>
                <fieldset>
                    <legend>Сортировка</legend>
                    
                    <input id="sort_color" type="radio" name="sort" value="color">
                    <label for="sort_color">По цвету</label><br>
                    
                    <input id="sort_name" type="radio" name="sort" checked="checked" value="name">
                    <label id="sort_name">По цене</label><br>
                    
                        <input type="radio" name="sort" value="new" id="sort_new">
                        <label for="sort_new">Новинка</label>
                </fieldset>


                    <fieldset>
                        <legend>View</legend>
                        <label></label>
                        <input type="radio" name="main" value="all" checked="checked">
                        Все<br>
                        <label></label>
                                                                            <input type="radio" name="main" value="kid">
Детям<br>
                    </fieldset>

                <fieldset>
                    <legend>Colours at a glance</legend>
                        <input style="clear:both;" type="checkbox" name="color" checked="checked" value="blue"> 
                        <label title="blue" style="display:block;margin-top:3px;float:left;width:10px;height:10px;border:1px solid black;background-color:#004B8B;" class="jquery-checkbox-checked " labelfor="color">
                        </label>
Синий<br>
                        <input style="clear:both;" type="checkbox" name="color" checked="checked" value="yellow"> 
                        <label title="yellow" style="display:block;margin-top:3px;float:left;width:10px;height:10px;border:1px solid black;background-color:#FFF500;" class="jquery-checkbox-checked light" labelfor="color">
                        </label>
Желтый<br>
                </fieldset>
            </div>
        </div>
        <div class="filter_bottom"></div>
    </div>
	<?}?>
	
	</div>
</div>