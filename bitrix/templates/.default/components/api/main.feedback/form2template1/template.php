<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();
/**
 * Bitrix vars
 *
 * @var CBitrixComponent         $component
 * @var CBitrixComponentTemplate $this
 * @var array                    $arParams
 * @var array                    $arResult
 * @var array                    $arLangMessages
 * @var array                    $templateData
 *
 * @var string                   $templateFile
 * @var string                   $templateFolder
 * @var string                   $parentTemplateFolder
 * @var string                   $templateName
 * @var string                   $componentPath
 *
 * @var CDatabase                $DB
 * @var CUser                    $USER
 * @var CMain                    $APPLICATION
 */

$arResult['FORM_SUBMIT_VALUE'] = (strlen($arParams['FORM_SUBMIT_VALUE']) > 0) ? $arParams['FORM_SUBMIT_VALUE'] : GetMessage("MFT_SUBMIT");

if($arParams['TITLE_DISPLAY'] != 'N')
	$arResult['FORM_TITLE'] = '<h' . $arParams['FORM_TITLE_LEVEL'] . ' style="' . $arParams['FORM_STYLE_TITLE'] . '">' . $arParams['FORM_TITLE'] . '</h' . $arParams['FORM_TITLE_LEVEL'] . '>';

$tpl_class_name = 'tpl_default';
?>
<script type="text/javascript">
	jQuery(document).ready(function($){

		<? if((count($arParams['REQUIRED_FIELDS']) && $arParams['VALIDTE_REQUIRED_FIELDS'])): ?>
			$("#<?= $arParams['UNIQUE_FORM_ID']; ?>").validateMainFeedback();
		<? endif; ?>
		<? if($arParams['INCLUDE_PRETTY_COMMENTS']): ?>
			$('#<?= $arParams['UNIQUE_FORM_ID']; ?> textarea').prettyComments();
		<? endif; ?>
		<? if($arParams['INCLUDE_FORM_STYLER']): ?>
			$('#<?= $arParams['UNIQUE_FORM_ID']; ?> input[type*="checkbox"], #<?= $arParams['UNIQUE_FORM_ID']; ?> input[type*="radio"]').styler();
		<? endif; ?>
		<? if($arParams['HIDE_FORM_AFTER_SEND'] && !empty($arResult["OK_MESSAGE"])): ?>
			$("#<?= $arParams['UNIQUE_FORM_ID']; ?>").hide();
		<? endif; ?>
		<? if($arParams['SCROLL_TO_FORM_IF_MESSAGES'] && (!empty($arResult["OK_MESSAGE"]) || !empty($arResult["ERROR_MESSAGE"]))): ?>
			$('html, body').animate({
				scrollTop: $(".api-feedback.<?=$tpl_class_name;?>").offset().top
			}, <?=$arParams['SCROLL_TO_FORM_SPEED'];?>);
		<? endif; ?>
		<? if($arParams['SHOW_CSS_MODAL_AFTER_SEND'] && !empty($arResult["OK_MESSAGE"])): ?>
			var html_css_modal = '<section class="semantic-content" id="modal-text-<?=$arParams["UNIQUE_FORM_ID"];?>" tabindex="-1" role="dialog" aria-labelledby="modal-label" aria-hidden="true">' +
									'<div class="modal-inner"><header><h2 id="modal-label"><?=htmlspecialcharsback(CUtil::JSEscape($arParams["CSS_MODAL_HEADER"]));?></h2></header>' +
										'<div class="modal-content"><?=htmlspecialcharsback(CUtil::JSEscape($arParams["CSS_MODAL_CONTENT"]));?></div>' +
										'<footer><p><?=htmlspecialcharsback(CUtil::JSEscape($arParams["CSS_MODAL_FOOTER"]));?></p></footer>' +
									'</div>' +
									'<a href="#!" class="modal-close" title="<?=GetMessage("CLOSE_CSS_MODAL_WINDOW")?>" data-dismiss="modal">&times;</a>' +
								'</section>';
			$('body').append(html_css_modal);

    		window.location.hash = '#modal-text-<?=$arParams['UNIQUE_FORM_ID'];?>';
		<? endif; ?>
	}); //END Ready
</script>

	<form action="<?=POST_FORM_ACTION_URI;?>" method="POST" enctype="multipart/form-data" name="api_feedback_form" id="<?= $arParams['UNIQUE_FORM_ID']; ?>">
		<?= bitrix_sessid_post() ?>
		<input type="hidden" name="UNIQUE_FORM_ID" value="<?= $arParams['UNIQUE_FORM_ID']; ?>" />
		<? if($arParams['USE_HIDDEN_PROTECTION']): ?>
			<input type="text" class="hidden_protection" name="HIDDEN[NAME]" value="<?=$_REQUEST['HIDDEN']['NAME'];?>" />
			<input type="text" class="hidden_protection" name="HIDDEN[EMAIL]" value="<?=$_REQUEST['HIDDEN']['EMAIL'];?>" />
			<input type="text" class="hidden_protection" name="hidden_protection" value="<?=$_REQUEST['hidden_protection'];?>" />
		<? endif; ?>
		<? if(count($arParams['BRANCH_FIELDS']) && $arParams["BRANCH_ACTIVE"] == "Y"): ?>
			<div class="<?=$tpl_class_name;?>_BRANCH" style="<?= $arParams['FORM_STYLE_DIV'] ?>">
				<label for="<?=$tpl_class_name;?>_BRANCH" style="<?= $arParams['FORM_STYLE_LABEL'] ?>"><?= $arParams["BRANCH_BLOCK_NAME"] ?></label>
				<select name="BRANCH" id="<?=$tpl_class_name;?>_BRANCH" style="<?= $arParams['FORM_STYLE_SELECT']; ?>">
					<? foreach($arParams['BRANCH_FIELDS'] as $branchId => $arBranchFields): ?>
						<? $arBranch = explode('###', $arBranchFields); ?>
						<? if(count($arBranch)): ?>
							<option value="<?= $branchId ?>"<? if(intval($_POST["BRANCH"]) == $branchId): ?> selected="selected"<? endif ?>><?= $arBranch[0] ?></option>
						<? endif ?>
					<? endforeach ?>
				</select>
			</div>
			<? if($arParams["MSG_PRIORITY"] == "Y"): ?>
				<div class="<?=$tpl_class_name;?>_MSG_PRIORITY" style="<?= $arParams['FORM_STYLE_DIV'] ?>">
					<label for="<?=$tpl_class_name;?>_MSG_PRIORITY" style="<?= $arParams['FORM_STYLE_LABEL'] ?>"><?= $arParams["MSG_PRIORITY_BLOCK_NAME"]; ?></label>
					<select name="MSG_PRIORITY" id="<?=$tpl_class_name;?>_MSG_PRIORITY" style="<?= $arParams['FORM_STYLE_SELECT']; ?>">
						<option value="5 (Lowest)"<? if($_POST['MSG_PRIORITY'] == '5 (Lowest)'): ?> selected="selected"<? endif; ?>><?= GetMessage("MSG_PRIORITY_5") ?></option>
						<option value="3 (Normal)"<? if($_POST['MSG_PRIORITY'] == '3 (Normal)'): ?> selected="selected"<? endif; ?>><?= GetMessage("MSG_PRIORITY_3") ?></option>
						<option value="1 (Highest)"<? if($_POST['MSG_PRIORITY'] == '1 (Highest)'): ?> selected="selected"<? endif; ?>><?= GetMessage("MSG_PRIORITY_1") ?></option>
					</select>
				</div>
			<? endif ?>
		<? endif ?>
		
		<div class="grid_4 alpha">
			<input id="vorname" name="author_name" placeholder="Firstname" type="text" value="">
		</div>
		<div class="grid_4 omega">
			<input id="nachname" name="author_last_name" placeholder="Surname" type="text" value="">
		</div>
		<div class="clear"></div>
		<div class="grid_4 alpha">
			<select id="landID" name="author_state">
				<option value="Afghanistan">Afghanistan</option>
				<option value="Albania">Albania</option>
				<option value="Algeria">Algeria</option>
				<option value="American Samoa">American Samoa</option>
				<option value="Andorra">Andorra</option>
				<option value="Angola">Angola</option>
				<option value="Anguilla">Anguilla</option>
				<option value="Antarctica">Antarctica</option>
				<option value="Antigua and Barbuda">Antigua and Barbuda</option>
				<option value="Argentina">Argentina</option>
				<option value="Armenia">Armenia</option>
				<option value="Aruba">Aruba</option>
				<option value="Australia">Australia</option>
				<option value="Austria">Austria</option>
				<option value="Azerbaijan">Azerbaijan</option>
				<option value="Bahamas">Bahamas</option>
				<option value="Bahrain">Bahrain</option>
				<option value="Bangladesh">Bangladesh</option>
				<option value="Barbados">Barbados</option>
				<option value="Belarus">Belarus</option>
				<option value="Belgium">Belgium</option>
				<option value="Belize">Belize</option>
				<option value="Benin">Benin</option>
				<option value="Bermuda">Bermuda</option>
				<option value="Bhutan">Bhutan</option>
				<option value="Bolivia">Bolivia</option>
				<option value="Bosnia-Herzegovina">Bosnia-Herzegovina</option>
				<option value="Botswana">Botswana</option>
				<option value="Bouvet Island">Bouvet Island</option>
				<option value="Brazil">Brazil</option>
				<option value="British Indian Ocean Territory">British Indian Ocean Territory</option>
				<option value="Brunei Darussalam">Brunei Darussalam</option>
				<option value="Bulgaria">Bulgaria</option>
				<option value="Burkina Faso">Burkina Faso</option>
				<option value="Burundi">Burundi</option>
				<option value="Cambodia">Cambodia</option>
				<option value="Cameroon">Cameroon</option>
				<option value="Canada">Canada</option>
				<option value="Cape Verde">Cape Verde</option>
				<option value="Cayman Islands">Cayman Islands</option>
				<option value="Central African Republic">Central African Republic</option>
				<option value="Chad">Chad</option>
				<option value="Chile">Chile</option>
				<option value="China">China</option>
				<option value="Christmas Island">Christmas Island</option>
				<option value="Cocos (Keeling) Islands">Cocos (Keeling) Islands</option>
				<option value="Colombia">Colombia</option>
				<option value="Comoros">Comoros</option>
				<option value="Congo">Congo</option>
				<option value="Cook Islands">Cook Islands</option>
				<option value="Costa Rica">Costa Rica</option>
				<option value="Croatia">Croatia</option>
				<option value="Cuba">Cuba</option>
				<option value="Cyprus">Cyprus</option>
				<option value="Czech Republic">Czech Republic</option>
				<option value="Democratic Republic of the Congo">Democratic Republic of the Congo</option>
				<option value="Denmark">Denmark</option>
				<option value="Djibouti">Djibouti</option>
				<option value="Dominica">Dominica</option>
				<option value="Dominican Republic">Dominican Republic</option>
				<option value="East Timor">East Timor</option>
				<option value="Ecuador">Ecuador</option>
				<option value="Egypt">Egypt</option>
				<option value="El Salvador">El Salvador</option>
				<option value="England">England</option>
				<option value="England">England</option>
				<option value="Equatorial Guinea">Equatorial Guinea</option>
				<option value="Eritrea">Eritrea</option>
				<option value="Estonia">Estonia</option>
				<option value="Ethiopia">Ethiopia</option>
				<option value="Europa">Europa</option>
				<option value="Falkland Islands">Falkland Islands</option>
				<option value="Faroe Islands">Faroe Islands</option>
				<option value="Fiji">Fiji</option>
				<option value="Finland">Finland</option>
				<option value="France">France</option>
				<option value="French Guiana">French Guiana</option>
				<option value="French Polynesia">French Polynesia</option>
				<option value="French Southern Territories">French Southern Territories</option>
				<option value="Gabon">Gabon</option>
				<option value="Gambia">Gambia</option>
				<option value="Georgia">Georgia</option>
				<option value="Germany">Germany</option>
				<option value="Ghana">Ghana</option>
				<option value="Gibraltar">Gibraltar</option>
				<option value="Greece">Greece</option>
				<option value="Greenland">Greenland</option>
				<option value="Grenada">Grenada</option>
				<option value="Guadeloupe">Guadeloupe</option>
				<option value="Guatemala">Guatemala</option>
				<option value="Guinea">Guinea</option>
				<option value="Guinea-Bissau">Guinea-Bissau</option>
				<option value="Guyana">Guyana</option>
				<option value="Haiti">Haiti</option>
				<option value="Heard and McDonald Islands">Heard and McDonald Islands</option>
				<option value="Honduras">Honduras</option>
				<option value="Hong Kong">Hong Kong</option>
				<option value="Hungary">Hungary</option>
				<option value="Iceland">Iceland</option>
				<option value="India">India</option>
				<option value="Indonesia">Indonesia</option>
				<option value="International">International</option>
				<option value="Iran">Iran</option>
				<option value="Iraq">Iraq</option>
				<option value="Ireland">Ireland</option>
				<option value="Israel">Israel</option>
				<option value="Italy">Italy</option>
				<option value="Ivory Coast">Ivory Coast</option>
				<option value="Jamaica">Jamaica</option>
				<option value="Japan">Japan</option>
				<option value="Jordan">Jordan</option>
				<option value="Kazakhstan">Kazakhstan</option>
				<option value="Kenya">Kenya</option>
				<option value="Kiribati">Kiribati</option>
				<option value="Kosovo">Kosovo</option>
				<option value="Kuwait">Kuwait</option>
				<option value="Kyrgyzstan">Kyrgyzstan</option>
				<option value="Laos">Laos</option>
				<option value="Latvia">Latvia</option>
				<option value="Lebanon">Lebanon</option>
				<option value="Lesotho">Lesotho</option>
				<option value="Liberia">Liberia</option>
				<option value="Libya">Libya</option>
				<option value="Liechtenstein">Liechtenstein</option>
				<option value="Lithuania">Lithuania</option>
				<option value="Luxembourg">Luxembourg</option>
				<option value="Macau">Macau</option>
				<option value="Macedonia (Former Yugoslav Republic)">Macedonia (Former Yugoslav Republic)</option>
				<option value="Madagascar">Madagascar</option>
				<option value="Malawi">Malawi</option>
				<option value="Malaysia">Malaysia</option>
				<option value="Maldives">Maldives</option>
				<option value="Mali">Mali</option>
				<option value="Malta">Malta</option>
				<option value="Marshall Islands">Marshall Islands</option>
				<option value="Martinique">Martinique</option>
				<option value="Mauritania">Mauritania</option>
				<option value="Mauritius">Mauritius</option>
				<option value="Mayotte">Mayotte</option>
				<option value="Mexico">Mexico</option>
				<option value="Micronesia">Micronesia</option>
				<option value="Moldova">Moldova</option>
				<option value="Monaco">Monaco</option>
				<option value="Mongolia">Mongolia</option>
				<option value="Montenegro">Montenegro</option>
				<option value="Montserrat">Montserrat</option>
				<option value="Morocco">Morocco</option>
				<option value="Mozambique">Mozambique</option>
				<option value="Myanmar">Myanmar</option>
				<option value="Namibia">Namibia</option>
				<option value="Nauru">Nauru</option>
				<option value="Nepal">Nepal</option>
				<option value="Netherlands">Netherlands</option>
				<option value="Netherlands Antilles">Netherlands Antilles</option>
				<option value="New Caledonia">New Caledonia</option>
				<option value="New Zealand">New Zealand</option>
				<option value="Nicaragua">Nicaragua</option>
				<option value="Niger">Niger</option>
				<option value="Nigeria">Nigeria</option>
				<option value="Niue">Niue</option>
				<option value="Norfolk Island">Norfolk Island</option>
				<option value="North Korea">North Korea</option>
				<option value="Northern Mariana Islands">Northern Mariana Islands</option>
				<option value="North-Irland">North-Irland</option>
				<option value="Norway">Norway</option>
				<option value="Oman">Oman</option>
				<option value="Pakistan">Pakistan</option>
				<option value="Palau">Palau</option>
				<option value="Panama">Panama</option>
				<option value="Papua New Guinea">Papua New Guinea</option>
				<option value="Paraguay">Paraguay</option>
				<option value="Peru">Peru</option>
				<option value="Philippines">Philippines</option>
				<option value="Pitcairn Island">Pitcairn Island</option>
				<option value="Poland">Poland</option>
				<option value="Portugal">Portugal</option>
				<option value="Puerto Rico">Puerto Rico</option>
				<option value="Qatar">Qatar</option>
				<option value="Reunion">Reunion</option>
				<option value="Romania">Romania</option>
				<option value="Russia">Russia</option>
				<option value="Rwanda">Rwanda</option>
				<option value="Saint Helena">Saint Helena</option>
				<option value="Saint Kitts and Nevis">Saint Kitts and Nevis</option>
				<option value="Saint Lucia">Saint Lucia</option>
				<option value="Saint Pierre and Miquelon">Saint Pierre and Miquelon</option>
				<option value="Saint Tome and Principe">Saint Tome and Principe</option>
				<option value="Saint Vincent and Grenadines">Saint Vincent and Grenadines</option>
				<option value="Samoa">Samoa</option>
				<option value="San Marino">San Marino</option>
				<option value="Saudi Arabia">Saudi Arabia</option>
				<option value="Scotland">Scotland</option>
				<option value="Senegal">Senegal</option>
				<option value="Serbia">Serbia</option>
				<option value="Seychelles">Seychelles</option>
				<option value="Sierra Leone">Sierra Leone</option>
				<option value="Singapore">Singapore</option>
				<option value="Slovakia">Slovakia</option>
				<option value="Slovenia">Slovenia</option>
				<option value="Solomon Islands">Solomon Islands</option>
				<option value="Somalia">Somalia</option>
				<option value="South Africa">South Africa</option>
				<option value="South Georgia and South Sandwich Islands">South Georgia and South Sandwich Islands</option>
				<option value="South Korea">South Korea</option>
				<option value="Spain">Spain</option>
				<option value="Sri Lanka">Sri Lanka</option>
				<option value="Sudan">Sudan</option>
				<option value="Suriname">Suriname</option>
				<option value="Svalbard and Jan Mayen Islands">Svalbard and Jan Mayen Islands</option>
				<option value="Swaziland">Swaziland</option>
				<option value="Sweden">Sweden</option>
				<option value="Switzerland">Switzerland</option>
				<option value="Syria">Syria</option>
				<option value="Taiwan">Taiwan</option>
				<option value="Tajikistan">Tajikistan</option>
				<option value="Tanzania">Tanzania</option>
				<option value="Thailand">Thailand</option>
				<option value="Togo">Togo</option>
				<option value="Tokelau">Tokelau</option>
				<option value="Tonga">Tonga</option>
				<option value="Trinidad and Tobago">Trinidad and Tobago</option>
				<option value="Tunisia">Tunisia</option>
				<option value="Turkey">Turkey</option>
				<option value="Turkmenistan">Turkmenistan</option>
				<option value="Turks and Caicos Islands">Turks and Caicos Islands</option>
				<option value="Tuvalu">Tuvalu</option>
				<option value="Uganda">Uganda</option>
				<option value="Ukraine">Ukraine</option>
				<option value="United Arab Emirates">United Arab Emirates</option>
				<option value="United Kingdom">United Kingdom</option>
				<option selected="selected" value="United States">United States</option>
				<option value="Uruguay">Uruguay</option>
				<option value="Uzbekistan">Uzbekistan</option>
				<option value="Vanuatu">Vanuatu</option>
				<option value="Vatican City State">Vatican City State</option>
				<option value="Venezuela">Venezuela</option>
				<option value="Vietnam">Vietnam</option>
				<option value="Virgin Islands (British)">Virgin Islands (British)</option>
				<option value="Virgin Islands (USA)">Virgin Islands (USA)</option>
				<option value="Wales">Wales</option>
				<option value="Wallis and Futuna Islands">Wallis and Futuna Islands</option>
				<option value="Western Sahara">Western Sahara</option>
				<option value="World">World</option>
				<option value="Yemen">Yemen</option>
				<option value="Zambia">Zambia</option>
				<option value="Zimbabwe">Zimbabwe</option>
			</select>
		</div>
		<div class="grid_4 omega">
			<input data-val="true" data-val-required="Please provide a valid email" id="email" name="author_email" placeholder="email *" type="email" value="">
		</div>
		<div class="clear"></div>
		
		
		
		<?if(!empty($arParams['CUSTOM_FIELDS'])):?>
			<?foreach($arParams['CUSTOM_FIELDS'] as $fk => $FIELD)
			{
				$arFields = explode('@', $FIELD);
				$optgroup = false; //Have groups in <select>
				$arGroup  = array();

				switch($arFields[1])
				{
					case "select":
						$arrExp   = $values = array();
						$size     = '';
						$multiple = in_array("multiple", $arFields) ? ' multiple="multiple"' : false;
						foreach($arFields as $arField)
						{
							if(substr($arField, 0, 4) == "size")
							{
								$arrExp = explode("=", $arField);
								$size   = ' size="' . $arrExp[1] . '"';
							}

							if(substr($arField, 0, 6) == "values")
							{
								if(strpos($arField, '##') === false)
									$values = explode("#", substr($arField, 7));
								else
								{
									$optgroup = true;
									$values   = explode("##", substr($arField, 7));
								}
							}
						}
						?>
						<div class="<?=$tpl_class_name;?>_<?= ToLower('CUSTOM_FIELD_' . $fk) ?>" style="<?= $arParams['FORM_STYLE_DIV'] ?>">
							<?if(!$arParams['HIDE_FIELD_NAME']):?>
							
							<?endif;?>
							<select name="CUSTOM_FIELDS[<?= $fk ?>][]"<?= $multiple ?><?= $size ?> style="<?= $arParams['FORM_STYLE_SELECT']; ?>"
								<? if(in_array("required", $arFields)): ?> class="required" <? endif ?>>
								<?
								if ($optgroup)
								{
									foreach ($values as $k2 => $v2)
									{
										if (strpos($v2, '#') === false)
										{
											?><optgroup label="<?= $v2; ?>"><?
										}
										else
										{
											$arValues    = explode('#', $v2);
											$arValuesCnt = count($arValues);
											$l           = 0;
											foreach($arValues as $val)
											{
												$l++;
												?>
												<option<? if(strpos($arResult["CUSTOM_FIELD_" . $fk], $val) !== false): ?> selected<? endif; ?> value="<?= $val; ?>"><?= $val; ?></option><?
												if($arValuesCnt == $l)
													echo '</optgroup>';
											}
										}
									}
								}
								else
								{
									foreach($values as $k1 => $v)
									{
										?><option<? if(strpos($arResult["CUSTOM_FIELD_" . $fk], $v) !== false): ?> selected<? endif; ?> value="<?= $v ?>"><?= $v ?></option><?
									}
								}
								?>
							</select>
						</div><?
					break;

					//v1.2.9
					case "input":
						if($arFields[2]=="checkbox")
                        {
	                        $values = array();//����������� ������
	                        foreach($arFields as $arField)
	                        {
		                        if(substr($arField,0,6)=="values")
		                        {
			                        $values = explode("#",substr($arField,7));
		                        }
	                        }
	                        ?>
	                        <div class="<?=$tpl_class_name;?>_<?= ToLower('CUSTOM_FIELD_' . $fk) ?>" style="<?= $arParams['FORM_STYLE_DIV'] ?>">
	                            <?if(!$arParams['HIDE_FIELD_NAME']):?>
		                        
	                            <?endif;?>
		                        <div style="<?= $arParams['FORM_STYLE_INPUT'] ?>" class="option-qroup<? if(in_array("required", $arFields)): ?> required<? endif ?>">
			                        <?foreach($values as $k2=>$v):?>
				                        <label for="<?= $arParams['UNIQUE_FORM_ID']; ?>_FIELD_<?=$fk?>_<?=$k2?>">
					                        <input
						                        id="<?= $arParams['UNIQUE_FORM_ID']; ?>_FIELD_<?=$fk?>_<?=$k2?>"
						                        type="<?=$arFields[2]?>"
						                        name="CUSTOM_FIELDS[<?= $fk ?>][]"
						                        value="<?=$v?>"
						                        <? if(strpos($arResult["CUSTOM_FIELD_" . $fk], $v) !== false): ?> checked="checked"<?endif?>>
					                        <?=$v?>
				                        </label><br/>
			                        <?endforeach?>
		                        </div>
	                        </div>
	                    <?
	                    }
	                    elseif($arFields[2]=="radio")
	                    {
	                        $values = array();//����������� ������
	                        foreach($arFields as $arField)
	                        {
		                        if(substr($arField,0,6)=="values")
		                        {
			                        $values = explode("#",substr($arField,7));
		                        }
	                        }
	                        ?>
	                        <div class="<?=$tpl_class_name;?>_<?= ToLower('CUSTOM_FIELD_' . $fk) ?>" style="<?= $arParams['FORM_STYLE_DIV'] ?>">
		                        <?if(!$arParams['HIDE_FIELD_NAME']):?>
		                        
		                        <?endif;?>
		                        <div style="<?= $arParams['FORM_STYLE_INPUT'] ?>" class="option-qroup<? if(in_array("required", $arFields)): ?> required<? endif ?>">
			                        <?foreach($values as $k3=>$v):?>
				                        <label for="<?= $arParams['UNIQUE_FORM_ID']; ?>_FIELD_<?=$fk?>_<?=$k3?>">
					                        <input id="<?= $arParams['UNIQUE_FORM_ID']; ?>_FIELD_<?=$fk?>_<?=$k3?>"
					                               type="<?=$arFields[2]?>"
					                               name="CUSTOM_FIELDS[<?= $fk ?>][]"
					                               value="<?=$v?>"
						                            <? if($arResult["CUSTOM_FIELD_" . $fk] == $v): ?> checked="checked"<?endif?>>
					                        <?=$v?>
				                        </label><br/>
			                        <?endforeach?>
		                        </div>
	                        </div>
	                    <?
	                    }
						elseif($arFields[2]=="date")
						{
							$values = array();//����������� ������
							$bDateMultiple = false;
							foreach($arFields as $arField)
							{
								if(substr($arField, 0, 4) == "size")
								{
									$arrExp = explode("=", $arField);
									if(intval($arrExp[1]) >=2)
										$bDateMultiple = true;
								}

								if(substr($arField,0,6)=="values")
								{
									$values = explode("#",substr($arField,7));
								}

								$arResultDateValues = explode(':~:',$arResult["CUSTOM_FIELD_".$fk]);
							}
							?>
							<div class="<?=$tpl_class_name;?>_<?= ToLower('CUSTOM_FIELD_' . $fk) ?> date-group" style="<?= $arParams['FORM_STYLE_DIV'] ?>">
								<?if(!$arParams['HIDE_FIELD_NAME']):?>
								
								<?endif;?>
								<input type="text"
								       id="<?= $arParams['UNIQUE_FORM_ID']; ?>_FIELD_<?=$fk?>_1"
								       name="CUSTOM_FIELDS[<?=$fk?>][]"
								       value="<?=$arResultDateValues[0]?>"
								       style="<?= $arParams['FORM_STYLE_INPUT'] ?>"
									<?if($arParams['INCLUDE_PLACEHOLDER']):?> placeholder="<?=date('d.m.Y');?>" <?endif?>
									<? if(in_array("required", $arFields)): ?> class="required"<? endif ?>>
									<?$APPLICATION->IncludeComponent(
										"bitrix:main.calendar",
										"",
										Array(
											"SHOW_INPUT" => "N",
											"FORM_NAME" => "api_feedback_form",
											"INPUT_NAME" => $arParams['UNIQUE_FORM_ID'] ."_FIELD_". $fk ."_1",
											"INPUT_NAME_FINISH" => "",
											"INPUT_VALUE" => "",
											"INPUT_VALUE_FINISH" => "",
											"SHOW_TIME" => "N",
											"HIDE_TIMEBAR" => "Y"
										),
										null,
										Array(
											'HIDE_ICONS' => 'Y'
										)
									);?>
								<?if($bDateMultiple):?>
									<input type="text"
									       id="<?= $arParams['UNIQUE_FORM_ID']; ?>_FIELD_<?=$fk?>_2"
									       name="CUSTOM_FIELDS[<?=$fk?>][]"
									       value="<?=$arResultDateValues[1]?>"
									       style="<?= $arParams['FORM_STYLE_INPUT'] ?>"
										<?if($arParams['INCLUDE_PLACEHOLDER']):?> placeholder="<?=date('d.m.Y');?>" <?endif?>
										<? if(in_array("required", $arFields)): ?> class="required"<? endif ?>>
									<?$APPLICATION->IncludeComponent(
										"bitrix:main.calendar",
										"",
										Array(
											"SHOW_INPUT" => "N",
											"FORM_NAME" => "api_feedback_form",
											"INPUT_NAME" => $arParams['UNIQUE_FORM_ID'] ."_FIELD_". $fk ."_2",
											"INPUT_NAME_FINISH" => "",
											"INPUT_VALUE" => "",
											"INPUT_VALUE_FINISH" => "",
											"SHOW_TIME" => "N",
											"HIDE_TIMEBAR" => "Y"
										),
										null,
										Array(
											'HIDE_ICONS' => 'Y'
										)
									);?>
								<?endif;?>
							</div>
						<?
						}
	                    else
	                    {?>
	                        <div class="<?=$tpl_class_name;?>_<?= ToLower('CUSTOM_FIELD_' . $fk) ?>" style="<?= $arParams['FORM_STYLE_DIV'] ?>">
		                        <?if(!$arParams['HIDE_FIELD_NAME']):?>
		                        <label style="<?= $arParams['FORM_STYLE_LABEL'] ?>">
			                        <?= $arFields[0] ?>: <? if(in_array("required", $arFields)): ?> <span class="asterisk"> *</span><? endif ?>
		                        </label>
		                        <?endif;?>
		                        <input type="<?=$arFields[2]=='email' ? 'text' : $arFields[2];?>"
		                               name="CUSTOM_FIELDS[<?=$fk?>][]"
		                               value="<?=$arResult["CUSTOM_FIELD_".$fk]?>"
		                               style="<?= $arParams['FORM_STYLE_INPUT'] ?>"
			                            <?if($arParams['INCLUDE_PLACEHOLDER']):?> placeholder="<?= $arFields[0] ?>" <?endif?>
			                            <? if(in_array("required", $arFields)): ?> class="required"<? endif ?>>
	                        </div>
	                    <?}
                    break;

					case "textarea":
						?>
						<div class="<?=$tpl_class_name;?>_<?= ToLower('CUSTOM_FIELD_' . $fk) ?>" style="<?= $arParams['FORM_STYLE_DIV'] ?>">
							<?if(!$arParams['HIDE_FIELD_NAME']):?>
							<label style="<?= $arParams['FORM_STYLE_LABEL'] ?>">
								<?= $arFields[0] ?>: <? if(in_array("required", $arFields)): ?> <span class="asterisk"> *</span><? endif ?>
							</label>
							<?endif;?>
							<textarea name="CUSTOM_FIELDS[<?=$fk?>][]"
							          style="<?= $arParams['FORM_STYLE_TEXTAREA'] ?>"
									  <?if($arParams['INCLUDE_PLACEHOLDER']):?> placeholder="<?= $arFields[0] ?>" <?endif?>
									  <? if(in_array("required", $arFields)): ?> class="required"<? endif ?>><?=$arResult["CUSTOM_FIELD_".$fk]?></textarea>
						</div>
						<?
					break;
					//\\v1.2.9
				}
			}
			?>
		<? endif; ?>
		<?
		//Execute <textarea>
		if(count($arParams['DISPLAY_FIELDS']) > 0)
		{
			foreach($arParams['DISPLAY_FIELDS'] as $FIELD)
			{
				$field_name = !empty($arParams['USER_' . $FIELD]) ? $arParams['USER_' . $FIELD] : GetMessage('MFT_' . $FIELD);

				if($FIELD == 'AUTHOR_MESSAGE' || $FIELD == 'AUTHOR_NOTES')
				{?>
				<div class="<?=$tpl_class_name;?>_<?= ToLower($FIELD) ?>" style="<?= $arParams['FORM_STYLE_DIV'] ?>">
					<?if(!$arParams['HIDE_FIELD_NAME']):?>
					<label style="<?= $arParams['FORM_STYLE_LABEL'] ?>"><?= $field_name ?>:
						<? if(empty($arParams["REQUIRED_FIELDS"]) || in_array($FIELD, $arParams["REQUIRED_FIELDS"])): ?>
							<span class="asterisk"> *</span>
						<? endif ?>
					</label>
					<?endif;?>
					<textarea style="<?= $arParams['FORM_STYLE_TEXTAREA'] ?>" <?if($arParams['INCLUDE_PLACEHOLDER']):?> placeholder="<?= $field_name ?>" <?endif?>
					          name="<?= ToLower($FIELD) ?>"
						<? if(empty($arParams["REQUIRED_FIELDS"]) || in_array($FIELD, $arParams["REQUIRED_FIELDS"])): ?> class="required"<? endif ?>><?= $arResult[$FIELD] ?></textarea>
				</div>
				<?
				}
			}
			unset($FIELD);
		}
		?>
		<? if($arParams['SHOW_FILES']): ?>
			<div class="<?=$tpl_class_name;?>_<?= ToLower('UPLOAD_FILES'); ?>" style="<?= $arParams['FORM_STYLE_DIV'] ?>">
				<? for($i = 0; $i < $arParams['COUNT_INPUT_FILE']; $i++): ?>
					<div class="api-file-string">
						<?if(!$arParams['HIDE_FIELD_NAME']):?>
						<label style="<?= $arParams['FORM_STYLE_LABEL'] ?>"><?= $arParams['FILE_DESCRIPTION'][$i]; ?></label>
						<?endif;?>
						<div class="api-file-wrap">
							<span class="api-btn api-btn-small" onclick="$('#<?=$tpl_class_name;?>_finput_<?= $i ?>').click()"><?= GetMessage('MSG_SELECT_FILE') ?></span>
							<span class="api-file-name" id="<?=$tpl_class_name;?>_fname_<?= $i ?>"><?= GetMessage('MSG_FILE_NOT_SELECT') ?></span>
							<input type="file"
							       name="UPLOAD_FILES[]"
							       id="<?=$tpl_class_name;?>_finput_<?= $i ?>"
							       onchange="$('#<?=$tpl_class_name;?>_fname_<?= $i ?>').text(this.value);"
								<?if($arParams['SET_ATTACHMENT_REQUIRED']):?> class="required"<?endif;?>>
						</div>
					</div>
				<? endfor; ?>
				<?if($arParams['SHOW_ATTACHMENT_EXTENSIONS']):?>
					<div class="api-file-string">
						<?if(!$arParams['HIDE_FIELD_NAME']):?>
						<label style="<?= $arParams['FORM_STYLE_LABEL'] ?>"></label>
						<?endif;?>
						<div class="api-file-wrap api-file-ext"><?=$arParams['FILE_EXTENSIONS'];?></div>
					</div>
				<?endif;?>
			</div>
		<? endif; ?>
		<? if($arParams['USE_CAPTCHA']): ?>
			<div class="mf-captcha">
				<?if(!$arParams['HIDE_FIELD_NAME']):?>
				<label style="<?= $arParams['FORM_STYLE_LABEL'] ?>">&nbsp;</label>
				<?endif;?>
				<div class="mf-captcha-wrap">
					<div class="mf-text"><?= GetMessage('MFT_CAPTCHA') ?></div>
					<input type="hidden" name="captcha_sid" value="<?= $arResult['capCode'] ?>">
					<img src="/bitrix/tools/captcha.php?captcha_sid=<?= $arResult['capCode'] ?>" width="180" height="40" alt="CAPTCHA">
					<div class="mf-text"><?= GetMessage('MFT_CAPTCHA_CODE') ?> <span class="asterisk">*</span></div>
					<input type="text" name="captcha_word" size="30" maxlength="45" value="" class="required" autocomplete="off">
				</div>
			</div>
		<? endif; ?>

		<?if(!empty($arResult["ERROR_MESSAGE"])){?>
			<div class="error">
				<div class="validation-summary-errors" data-valmsg-summary="true">
					<ul>
						<?foreach($arResult["ERROR_MESSAGE"] as $arError){
							echo "<li>".$arError."</li>";
						}?>
					</ul>
				</div>
			</div>
		<?	}	?>
		
		<p>Fields marked * must be filled out</p>

		<div id="progress" style="display:none;">
			<img src="/Content/images/misc/bx_loader.gif">
		</div>
		
		<div style="text-align: center">
			<input type="submit" name="submit" style="<?= $arParams['FORM_STYLE_SUBMIT'] ?>"  class="<?=$arParams['FORM_SUBMIT_CLASS'];?>" id="<?=$arParams['FORM_SUBMIT_ID'];?>" value="<?=$arResult['FORM_SUBMIT_VALUE'];?>">
		</div>
			
	</form>