<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<? if(!$_REQUEST["ajax"] && @$_REQUEST["ajax"] != "Y"){ ?>

		</div>
		</div><!-- end #content -->
		<footer>
			<div id="footer">
				<div class="headline"></div>
				<div class="container_16">
					<div class="grid_9">
						<div class="grid_7 alpha products">
							<h4>Продукты</h4>
							<?$APPLICATION->IncludeComponent(
								"bitrix:catalog.section.list",
								"products_menu_template1",
								Array(
									"IBLOCK_TYPE" => "catalog",
									"IBLOCK_ID" => "2",
									"SECTION_ID" => $_REQUEST["SECTION_ID"],
									"SECTION_CODE" => "",
									"COUNT_ELEMENTS" => "Y",
									"TOP_DEPTH" => "2",
									"SECTION_FIELDS" => array(0=>"",1=>"",),
									"SECTION_USER_FIELDS" => array(0=>"",1=>"",),
									"SECTION_URL" => "",
									"CACHE_TYPE" => "A",
									"CACHE_TIME" => "36000000",
									"CACHE_GROUPS" => "Y",
									"ADD_SECTIONS_CHAIN" => "Y",
									"VIEW_MODE" => "LINE",
									"SHOW_PARENT_NAME" => "Y"
								)
							);?>
						</div>
						<div class="grid_2 omega dealers">
							<h4>Дилеры</h4>
							<ul>
								<?$APPLICATION->IncludeComponent(
									"bitrix:news.list",
									"footer_country_template",
									Array(
										"IBLOCK_TYPE" => "dealers",
										"IBLOCK_ID" => "5",
										"NEWS_COUNT" => "2",
										"SORT_BY1" => "SORT",
										"SORT_ORDER1" => "DESC",
										"SORT_BY2" => "SORT",
										"SORT_ORDER2" => "ASC",
										"FILTER_NAME" => "",
										"FIELD_CODE" => array(0=>"",1=>"",),
										"PROPERTY_CODE" => array(0=>"SHOW_FOOTER",1=>"",),
										"CHECK_DATES" => "Y",
										"DETAIL_URL" => "",
										"AJAX_MODE" => "N",
										"AJAX_OPTION_JUMP" => "N",
										"AJAX_OPTION_STYLE" => "Y",
										"AJAX_OPTION_HISTORY" => "N",
										"CACHE_TYPE" => "A",
										"CACHE_TIME" => "36000000",
										"CACHE_FILTER" => "N",
										"CACHE_GROUPS" => "Y",
										"PREVIEW_TRUNCATE_LEN" => "",
										"ACTIVE_DATE_FORMAT" => "d.m.Y",
										"SET_STATUS_404" => "N",
										"SET_TITLE" => "N",
										"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
										"ADD_SECTIONS_CHAIN" => "N",
										"HIDE_LINK_WHEN_NO_DETAIL" => "N",
										"PARENT_SECTION" => "",
										"PARENT_SECTION_CODE" => "",
										"INCLUDE_SUBSECTIONS" => "Y",
										"PAGER_TEMPLATE" => ".default",
										"DISPLAY_TOP_PAGER" => "N",
										"DISPLAY_BOTTOM_PAGER" => "N",
										"PAGER_TITLE" => "Новости",
										"PAGER_SHOW_ALWAYS" => "N",
										"PAGER_DESC_NUMBERING" => "N",
										"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
										"PAGER_SHOW_ALL" => "N",
										"DISPLAY_DATE" => "N",
										"DISPLAY_NAME" => "Y",
										"DISPLAY_PICTURE" => "N",
										"DISPLAY_PREVIEW_TEXT" => "N",
										"AJAX_OPTION_ADDITIONAL" => ""
									)
								);?>
								<li><a href="/dealers/">View all...</a></li>
							</ul>
						</div>
					</div>
					<div class="grid_7">
						<div class="grid_2 alpha service">
							<h4>Услуги</h4>
							<ul>
								<li>
									<a href="/services/info/">Информация</a>
								</li>
							</ul>
						</div>
						<div class="grid_4 contact">
							<h4>Контакты</h4>
							<address>
								Официальный представитель<br>
								в России<br/>
								Компания "СпортDепо"<br/>
								123060, г. Москва, <br/>
								1-ый Волоколамский проезд,</br>
								д. 10, стр. 10<br>
								+7 (495) 287-90-39<br/>
								8 (800) 775-33-76<br/>
								<a href="mailto:info@sportdepo.ru">info@sportdepo.ru</a><br/>
								<a href="sportdepo.ru">sportdepo.ru</a><br/>
								
							</address><br/>
							<a href="/info/">Imprint</a><br/>
							<a href="/info/contact.php">Контакты</a><br/>
						</div>
						<div class="grid_1 socialmedia omega">
							<?/*
							<a href="http://www.facebook.com/pages/UHLSPORT-USA/187230199528">
								<img src="<?=SITE_TEMPLATE_PATH?>/images/footer_fb_55x55.png" alt="uhlsport on Facebook"/>
							</a>
							*/?>
							<a href="http://www.youtube.com/uhlsportTV">
								<img src="<?=SITE_TEMPLATE_PATH?>/images/footer_yt_55x55.png" alt="uhlsport on Facebook"/>
							</a>
						</div>
					</div>
				</div>
			</div>
			<!-- Yandex.Metrika counter -->
			<script type="text/javascript" >
			    (function (d, w, c) {
			        (w[c] = w[c] || []).push(function() {
			            try {
			                w.yaCounter50801326 = new Ya.Metrika2({
			                    id:50801326,
			                    clickmap:true,
			                    trackLinks:true,
			                    accurateTrackBounce:true,
			                    webvisor:true
			                });
			            } catch(e) { }
			        });

			        var n = d.getElementsByTagName("script")[0],
			            s = d.createElement("script"),
			            f = function () { n.parentNode.insertBefore(s, n); };
			        s.type = "text/javascript";
			        s.async = true;
			        s.src = "https://mc.yandex.ru/metrika/tag.js";

			        if (w.opera == "[object Opera]") {
			            d.addEventListener("DOMContentLoaded", f, false);
			        } else { f(); }
			    })(document, window, "yandex_metrika_callbacks2");
			</script>
			<noscript><div><img src="https://mc.yandex.ru/watch/50801326" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
			<!-- /Yandex.Metrika counter -->
		</footer>
	</div>
</body>
</html>

<? } // не Ajax - корзина ?>
