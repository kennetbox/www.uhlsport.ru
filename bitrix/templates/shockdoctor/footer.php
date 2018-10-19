<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>


<? if(strpos($dir,'/catalog') === false && strpos($dir,'/sports') === false && strpos($dir,'/sale') === false) { ?>
	<? if(strpos($dir,'/personal/cart') !== false) { ?>
	</div> <!-- end cart -->
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
	</div> <!-- end content -->
	</div> <!-- end modules -->
	<? } elseif(strpos($dir,'/athletes') !== false || strpos($dir,'/register') !== false || strpos($dir,'/login') !== false || strpos($dir,'/personal') !== false || strpos($dir,'/company/news') !== false || strpos($dir,'/auth') !== false) { ?>
	</div><!-- [end col-main] -->
	<? } ?>
</div> <!-- end main -->
<? } ?>


<div class="footer-container">
	<div class="container">
	<div class="footer">
		<div class="footer-col footer-about">
					
					<? /* [Меню "Наша компания"] */ ?>
					<?$APPLICATION->IncludeComponent('bitrix:menu',
						"bottom_menu_shockdoctor", array(
								"ROOT_MENU_TYPE" => "bottom",
								"MENU_CACHE_TYPE" => "Y",
								"MENU_CACHE_TIME" => "36000000",
								"MENU_CACHE_USE_GROUPS" => "Y",
								"MENU_CACHE_GET_VARS" => array(),
								"MAX_LEVEL" => "1",
								"USE_EXT" => "N",
								"ALLOW_MULTI_SELECT" => "N"
						)
					);?>
					
					<? /* [Копирайт] */ ?>
					<?$APPLICATION->IncludeComponent("bitrix:main.include", "", array("AREA_FILE_SHOW" => "file", "PATH" => SITE_DIR."include/copyright.php"), false);?>

		</div>
		<div class="footer-col footer-service">
				
					<? /* [Обслуживание клиентов] */ ?>
					<?$APPLICATION->IncludeComponent("bitrix:main.include", "", array("AREA_FILE_SHOW" => "file", "PATH" => SITE_DIR."include/clents_time.php"), false);?>

					<? /* [Поддержка покупателей] */ ?>
					<?$APPLICATION->IncludeComponent("bitrix:main.include", "", array("AREA_FILE_SHOW" => "file", "PATH" => SITE_DIR."include/buyers_support.php"), false);?>

		</div>
		<div class="footer-col footer-medical">

					<? /* [Медицинский центр] */ ?>
					<?$APPLICATION->IncludeComponent("bitrix:main.include", "", array("AREA_FILE_SHOW" => "file", "PATH" => SITE_DIR."include/medical_center.php"), false);?>

		</div>
		<div class="footer-col footer-connect">
					<? /* [Мы в сети] */ ?>
					<?$APPLICATION->IncludeComponent("bitrix:main.include", "", array("AREA_FILE_SHOW" => "file", "PATH" => SITE_DIR."include/social.php"), false);?>
					
		</div>
	</div> <!-- end footer -->
	</div> <!-- end container -->
</div><!-- /footer-container -->
</div> <!-- end page -->

</div> <!-- end wrapper -->

<div id="header-account2" class="skip-content2"><div class="youama-login-window" style="display: none;">
        <div class="youama-window-outside">
            <span class="close">×</span>

            <div class="youama-window-inside">

                <div class="youama-window-title">
                    <h3>
                        Вход на сайт                    </h3>
                </div>

                <div class="account-login">
                    <script type="text/javascript">
                        //<![CDATA[
                        var dataForm = new VarienForm('login-form', true);
                        //]]>
                    </script>

                </div>
                	<?//форма авторизации?>
                   <?$APPLICATION->IncludeComponent(
					   "bitrix:system.auth.authorize",
					   "shockdoctor",
					   Array(
					      "REGISTER_URL" => "",
					      "PROFILE_URL" => "",
					      "SHOW_ERRORS" => "Y"
					   ),
					false
					);?>

            </div>
        </div>
    </div>

    <div class="youama-register-window" style="display: none;">
        <div class="youama-window-outside">
            <span class="close">×</span>

            <div class="youama-window-inside">
                <div class="youama-window-title">
                    <h3>
                        Registration                    </h3>
                    
                </div>

                <div class="youama-window-box first">
                    <div class="youama-window-subtitle youama-showhideme">
                        <p>Profile Informations</p>
                    </div>
                    <div class="youama-window-content">
                        <div class="input-fly youama-showhideme input-firstname">
                            <label for="youama-firstname">First Name <span>*</span></label>
                            <input type="text" placeholder="First Name" id="youama-firstname" name="youama-firstname" value="" style="background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAABHklEQVQ4EaVTO26DQBD1ohQWaS2lg9JybZ+AK7hNwx2oIoVf4UPQ0Lj1FdKktevIpel8AKNUkDcWMxpgSaIEaTVv3sx7uztiTdu2s/98DywOw3Dued4Who/M2aIx5lZV1aEsy0+qiwHELyi+Ytl0PQ69SxAxkWIA4RMRTdNsKE59juMcuZd6xIAFeZ6fGCdJ8kY4y7KAuTRNGd7jyEBXsdOPE3a0QGPsniOnnYMO67LgSQN9T41F2QGrQRRFCwyzoIF2qyBuKKbcOgPXdVeY9rMWgNsjf9ccYesJhk3f5dYT1HX9gR0LLQR30TnjkUEcx2uIuS4RnI+aj6sJR0AM8AaumPaM/rRehyWhXqbFAA9kh3/8/NvHxAYGAsZ/il8IalkCLBfNVAAAAABJRU5ErkJggg==&quot;); background-attachment: scroll; background-size: 16px 18px; background-position: 98% 50%; background-repeat: no-repeat;">
                            <div class="youama-ajaxlogin-error err-firstname err-nofirstname err-dirtyfirstname" style="display: none;"></div>
                        </div>
                        <div class="input-fly youama-showhideme input-lastname">
                            <label for="youama-lastname">Last Name <span>*</span></label>
                            <input type="text" placeholder="Last Name" id="youama-lastname" name="youama-lastname" value="">
                            <div class="youama-ajaxlogin-error err-lastname err-nolastname err-dirtylastname" style="display: none;"></div>
                        </div>
                        <div class="input-fly input-fly-checkbox youama-showhideme">
                            <input type="checkbox" id="youama-newsletter" name="youama-newsletter" value="ok">
                            <label for="youama-newsletter">Subscribe to Newsletter</label>
                        </div>
                    </div>
                </div>

                <div class="youama-window-box second">
                    <div class="youama-window-subtitle youama-showhideme">
                        <p>Login Details</p>
                    </div>
                    <div class="youama-window-content">
                        <div class="input-fly youama-showhideme input-email">
                            <label>E-mail address <span>*</span></label>
                            <input type="text" placeholder="E-mail address" class="youama-email" name="youama-email" value="">
                            <div class="youama-ajaxlogin-error err-email err-noemail err-wrongemail err-emailisexist" style="display: none;"></div>
                        </div>
                        <div class="input-fly youama-showhideme input-password">
                            <label>Password <span>*</span></label>
                            <input type="password" placeholder="Password" class="youama-password" name="youama-password" value="" style="background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAACIUlEQVQ4EX2TOYhTURSG87IMihDsjGghBhFBmHFDHLWwSqcikk4RRKJgk0KL7C8bMpWpZtIqNkEUl1ZCgs0wOo0SxiLMDApWlgOPrH7/5b2QkYwX7jvn/uc//zl3edZ4PPbNGvF4fC4ajR5VrNvt/mo0Gr1ZPOtfgWw2e9Lv9+chX7cs64CS4Oxg3o9GI7tUKv0Q5o1dAiTfCgQCLwnOkfQOu+oSLyJ2A783HA7vIPLGxX0TgVwud4HKn0nc7Pf7N6vV6oZHkkX8FPG3uMfgXC0Wi2vCg/poUKGGcagQI3k7k8mcp5slcGswGDwpl8tfwGJg3xB6Dvey8vz6oH4C3iXcFYjbwiDeo1KafafkC3NjK7iL5ESFGQEUF7Sg+ifZdDp9GnMF/KGmfBdT2HCwZ7TwtrBPC7rQaav6Iv48rqZwg+F+p8hOMBj0IbxfMdMBrW5pAVGV/ztINByENkU0t5BIJEKRSOQ3Aj+Z57iFs1R5NK3EQS6HQqF1zmQdzpFWq3W42WwOTAf1er1PF2USFlC+qxMvFAr3HcexWX+QX6lUvsKpkTyPSEXJkw6MQ4S38Ljdbi8rmM/nY+CvgNcQqdH6U/xrYK9t244jZv6ByUOSiDdIfgBZ12U6dHEHu9TpdIr8F0OP692CtzaW/a6y3y0Wx5kbFHvGuXzkgf0xhKnPzA4UTyaTB8Ph8AvcHi3fnsrZ7Wore02YViqVOrRXXPhfqP8j6MYlawoAAAAASUVORK5CYII=&quot;); background-attachment: scroll; background-size: 16px 18px; background-position: 98% 50%; background-repeat: no-repeat;">
                            <div class="youama-ajaxlogin-error err-password err-dirtypassword err-nopassword err-shortpassword err-longpassword" style="display: none;"></div>
                        </div>
                        <div class="input-fly youama-showhideme input-passwordsecond">
                            <label for="youama-passwordsecond">Password confirmation <span>*</span></label>
                            <input type="password" placeholder="Password confirmation" id="youama-passwordsecond" name="youama-passwordsecond" value="" style="background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAACIUlEQVQ4EX2TOYhTURSG87IMihDsjGghBhFBmHFDHLWwSqcikk4RRKJgk0KL7C8bMpWpZtIqNkEUl1ZCgs0wOo0SxiLMDApWlgOPrH7/5b2QkYwX7jvn/uc//zl3edZ4PPbNGvF4fC4ajR5VrNvt/mo0Gr1ZPOtfgWw2e9Lv9+chX7cs64CS4Oxg3o9GI7tUKv0Q5o1dAiTfCgQCLwnOkfQOu+oSLyJ2A783HA7vIPLGxX0TgVwud4HKn0nc7Pf7N6vV6oZHkkX8FPG3uMfgXC0Wi2vCg/poUKGGcagQI3k7k8mcp5slcGswGDwpl8tfwGJg3xB6Dvey8vz6oH4C3iXcFYjbwiDeo1KafafkC3NjK7iL5ESFGQEUF7Sg+ifZdDp9GnMF/KGmfBdT2HCwZ7TwtrBPC7rQaav6Iv48rqZwg+F+p8hOMBj0IbxfMdMBrW5pAVGV/ztINByENkU0t5BIJEKRSOQ3Aj+Z57iFs1R5NK3EQS6HQqF1zmQdzpFWq3W42WwOTAf1er1PF2USFlC+qxMvFAr3HcexWX+QX6lUvsKpkTyPSEXJkw6MQ4S38Ljdbi8rmM/nY+CvgNcQqdH6U/xrYK9t244jZv6ByUOSiDdIfgBZ12U6dHEHu9TpdIr8F0OP692CtzaW/a6y3y0Wx5kbFHvGuXzkgf0xhKnPzA4UTyaTB8Ph8AvcHi3fnsrZ7Wore02YViqVOrRXXPhfqP8j6MYlawoAAAAASUVORK5CYII=&quot;); background-attachment: scroll; background-size: 16px 18px; background-position: 98% 50%; background-repeat: no-repeat;">
                            <div class="youama-ajaxlogin-error err-passwordsecond err-nopasswordsecond err-notsamepasswords" style="display: none;"></div>
                        </div>
                        <div class="input-fly input-fly-checkbox youama-showhideme">
                            <input type="checkbox" id="youama-licence" name="youama-licence" value="ok">
                            <label for="youama-licence">I accept the <a href="https://www.shockdoctor.com/terms/" target="_blank">Terms and Coditions</a></label>
                            <div class="youama-ajaxlogin-error err-nolicence" style="display: none;"></div>
                        </div>
                    </div>
                </div>

                <div class="youama-window-box last">
                    <div class="youama-window-content box-contents youama-showhideme">
                        <button type="button" class="button btn-reg btn-proceed-checkout btn-checkout youama-ajaxlogin-button">
                            <span>
                                <span>
                                    Register                                </span>
                            </span>
                        </button>
                        <p id="y-to-login" class="yoauam-switch-window">
                            or login                        </p>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="youama-ajaxlogin-loader">
    </div><div class="youama-confirmmsg-window" style="display:none;">
        <div class="youama-window-outside">
            <span class="close">×</span><br>
            <div class="alert alert-success">Account confirmation is required. Please, check your email for the confirmation link.</div>
        </div>
    </div></div>
<script type="text/javascript">
	jQuery(document).ready(function(){
		var login = jQuery('.login_link');
		var login_window = jQuery('.youama-login-window'); 
		var register_window = jQuery('.youama-register-window'); 
		var close = jQuery('span.close');

		var up_register = jQuery('#y-to-register');
		var up_login = jQuery('#y-to-login');

	login.click(function (e) {
	        e.preventDefault();
			login_window.show();
	 });
	close.click(function (e) {
	        e.preventDefault();
			login_window.hide();
			register_window.hide();
	 });

	up_register.click(function (e) {
	        e.preventDefault();
	        register_window.slideToggle();
			login_window.slideToggle();
			
	 });
	up_login.click(function (e) {
	        e.preventDefault();
			register_window.slideToggle();
			login_window.slideToggle();
	 });

    jQuery('.grouped-product').css({
        'width':'30%',
        'float':'left'
    });

});
</script>

<!-- Yandex.Metrika counter -->
<script type="text/javascript" >
    (function (d, w, c) {
        (w[c] = w[c] || []).push(function() {
            try {
                w.yaCounter50801350 = new Ya.Metrika2({
                    id:50801350,
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
<noscript><div><img src="https://mc.yandex.ru/watch/50801350" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->
</body>
</html>

