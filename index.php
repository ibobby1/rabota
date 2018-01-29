<?php
 include ("./includes/header.php"); ?>
<!DOCTYPE html>
<html lang='ru'>
<head>
<meta http-equiv='X-UA-COMPATIBLE' content='IE=edge'/>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
<title>Feelin' - твой умный домофон</title>
    <link rel='stylesheet' type='text/css' href='/assets/css/bootstrap.css' />
    <link rel='stylesheet' type='text/css' href='/assets/old/main.css' />
    <link rel='stylesheet' type='text/css' href='/assets/old/core.css' />
	<link href="/assets/css/mouldifi-core.css" rel="stylesheet" />
	<link href="/assets/css/mouldifi-forms.css" rel="stylesheet" />
	<script type='text/javascript' src='/assets/js/jquery.min.js'></script>
    <script type='text/javascript' src='/assets/js/plugins/jquery.masked.input.js'></script>
    <script>
	jQuery(function () {
		jQuery("input[name=phone], input[name=keyPhone]").mask("( 999 ) 999 9999");	
	});
	</script>
</head>
<body><div class='page page_home'>
        <div class='page__layout'>
          <div class='header'>
      		<div class='header__layout'> <a href='/' class='logo logo_main'></a>
      			<div class='nav nav_main'>
                <div class="register"><a href="/control/?reg" id="newUser" class="nav__link">Регистрация</a></div>
				<ul class='nav__list'>
      				<li class='nav__item'><a id='about' class='nav__link' href='/control/about.php'>О системе</a> </li>
            		<li class='nav__item'> <a id='contacts' class='nav__link' href='/control/contact.php'>Контакты</a> </li>
            		<li class='nav__item userNav'><a class='nav__link' id='help' href='/control/help.php'>Помощь</a></li>
            		<li class='nav__item userNav'><a class='nav__link' href='/control/payment_help.php'>Оплата</a></li>
                    
				</ul>    
      			</div>
      		</div>
      	</div>
        </div><div class='section section_main'>
				<div class='section__content'>
				<div class='content'>
				<div class='row'>
                <style>
				.login-branding {display: none;}
				.login-container {padding-top: 0;}

				</style>
				<?php include ("./layouts/shared/login_page.php"); ?>


				</div>
        				<div class='advantage'>
			            <div class='title'>Преимущества перед традиционными системами</div>
			            <ul class='list_advantage'>
			              <li class='list__item'><span class='icon icon_adv control'></span>Полный контроль и удобное управление </li>
			              <li class='list__item'><span class='icon icon_adv cost'></span>Невысокая абонентская плата </li>
			              <li class='list__item'><span class='icon icon_adv security'></span>Комплексный подход к безопасности </li>
			            </ul>
			       </div>
						</div>
						</div>
						</div><div class='footer'>
            <div class='footer__content'>
              <p>Feelin` домофон – это самый простой способ контролировать состояние Вашего жилища удаленно с любого стационарного или мобильного телефона, компьютера, планшета. Мы предлагаем симбиоз систем видеонаблюдения, контроля доступа, сигнализации, автоматизации с возможностью управления посредством Internet-технологий. Живите в ногу со временем, почувствуйте все преимущества инновационного решения, подключив его уже сегодня!</p>
			  <div>Служба поддержки: support@rontel.ru<br>+7 (351) 729-8001</div><br>
              <div id='mobileAppIcons'><a id='iosFooter' href="https://itunes.apple.com/ru/app/umnyj-domofon/id1064868272?mt=8"></a>
			  <a href="https://play.google.com/store/apps/details?id=ru.maxet_line.feelinintercomclient" id='androidFooter'></a></div>
              <p class='copyright'>&copy; 2016  FEELIN' домофон. Все права защищены</p>
              <div class='nav nav_footer'>
                <ul class='nav__list'>
                  <li class='nav__item'> <a id='about' class='nav__link' href='/control/about.php'>О системе</a> </li>
                  <li class='nav__item'> <a id='contacts' class='nav__link' href='/control/contact.php'>Контакты</a> </li>
                </ul>
              </div>
              <div class='socials'>
                <ul class='list list_h'>
      <li class='list__item'><a id='facebookLink' href='https://www.facebook.com/sharer/sharer.php?u=df.feelinhome.ru' title='Facebook' class='icon icon_facebook'></a></li>
                  <li class='list__item'><a id='twitterLink' href='http://twitter.com/share' title='Twitter' class='icon icon_twitter'></a></li>
                  <li class='list__item'><a id='googleLink' href='https://plus.google.com/share?url=http://df.feelinhome.ru' title='google plus' class='icon icon_gplus'></a></li>
                  <li class='list__item'><a id='vkLink' href='http://vkontakte.ru/share.php?url=http://df.feelinhome.ru' title='В Контакте' class='icon icon_vk'></a></li>
                  <li class='list__item'><a id='odnLink' href='http://www.odnoklassniki.ru/dk?st.cmd=addShare&amp;st.s=1&amp;st._surl=df.feelinhome.ru' target='_blank' title='Одноклассники' class='icon icon_odnoklassniki'></a></li>
                </ul>
              </div>
            </div>
          <div class='modal fade' id='activateForm' tabindex='-1' role='dialog' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
				<div class='modal-dialog'>
				<div class='modal-content'>
				<div class='modal-body'>
					<ul class='nav nav-tabs' role='tablist' id='tabs'>
						<li class='active'><a href='#forPhys' role='tab' data-toggle='tab'>Для физических лиц</a></li>
						<li><a href='#forOrg' role='tab' data-toggle='tab'>Для юридических лиц</a></li>
					</ul>
					<div class='tab-content'>
						<div class='active tab-pane' id='forPhys'>
							<div class='block sendForm'>
							<form id='sendFormPhys' method='POST' action='/index/activate' autocomplete='off'>
								<div class='column'>
									<p>Фамилия:</p> 
									<p>Имя:</p>
									<p>Отчество:</p>
									<p>Город:</p>
									<p>Контактный телефон:</p>
									<p>E-mail:</p>
									<p>Адрес:</p>
									<p>Требуемое количество ключей:</p>
								</div>
								<div class='column'>
									<input type='text' name='lastNameSend' id='lastNameSend' placeholder='Иванов' class='sendFormInput'></input>
									<input type='text' name='firstNameSend' id='firstNameSend' placeholder='Иван' class='sendFormInput'></input>
									<input type='text' name='fatherNameSend' id='fatherNameSend' placeholder='Иванович' class='sendFormInput'></input>
									<input type='text' name='citySend' id='citySend' placeholder='Город' class='sendFormInput'></input>
									<input id='sendFormForPhys' type='text' name='phoneSend' placeholder='Контактный телефон' class='sendFormInput'></input>
									<input type='text' name='emailSend' id='emailSend' placeholder='email@gmail.com' class='sendFormInput'></input>
									<input type='text' name='addressSend' id='addressSend' placeholder='Адрес' class='sendFormInput'></input>
									<input type='text' id='keyAmountSend' name='keyAmountSend' placeholder='4' class='sendFormInput span2'></input>
									<input  id='sendPhysButton' class='button button_at_left' type='submit'></input>
								</div>
								<div class='column'>
									<div id='lastNameSendMark' class='icon_mark'>.</div>
									<div id='firstNameSendMark' class='icon_mark'>.</div>
									<div id='fatherNameSendMark' class='icon_mark'>.</div>
									<div id='citySendMark' class='icon_mark'>.</div>
									<div id='sendFormForPhysMark' class='icon_mark'>.</div>
									<div id='emailSendMark' class='icon_mark'>.</div>
									<div id='addressSendMark' class='icon_mark'>.</div>
									<div id='keyAmountSendMark' class='icon_mark'>.</div>
								</div>
								</form>
							</div>
						</div>
						<div class='tab-pane' id='forOrg'>
							<div class='block sendForm'>
							<form id='sendFormOrg' method='POST' action='/index/activate' autocomplete='off'>
							<div class='column'>
								<p>Полное наименование:</p>
								<p>Город:</p>
								<p>Контактное лицо:</p>
								<p>Телефон:</p>
								<p>E-mail:</p>
								<p>Вы хотите</p>
								<p>Комментарии</p>
							</div>
							<div class='column'>
								<input type='text' id='organisationNameSend' name='organisationNameSend' placeholder='Наименование' class='sendFormInput'></input>
								<input type='text' id='organisationCitySend' name='organisationCitySend' placeholder='Москва' class='sendFormInput'></input>
								<input type='text' id='organisationContactPersonSend' name='organisationContactPersonSend' placeholder='Контактное лицо' class='sendFormInput'></input>
								<input id='sendFormForOrg' type='text' name='organisationPhoneSend' placeholder='Телефон' class='sendFormInput'></input>
								<input type='text' id='organisationEmailSend' name='organisationEmailSend' placeholder='email@gmail.com' class='sendFormInput'></input><br>
								<input type='radio' name='orgVar' value='intercom'>Приобрести домофон<br>
								<nobr><input type='radio' name='orgVar' value='abonents'>Подключить абонентов</nobr><br>
								<input type='text' id='organisationCommentSend' name='organisationCommentSend' placeholder='Комментарий' class='sendFormInput'></input><br>
								<input id='sendOrgButton' class='button button_at_left' type='submit'></input>
							</div>
							<div class='column'>
								<div id='organisationNameSendMark' class='icon_mark'>.</div>
								<div id='organisationCitySendMark' class='icon_mark'>.</div>
								<div id='organisationContactPersonSendMark' class='icon_mark'>.</div>
								<div id='sendFormForOrgMark' class='icon_mark'>.</div>
								<div id='organisationEmailSendMark' class='icon_mark'>.</div>
								<div id='orgVarMark' class='icon_mark'>.</div>
							</div>
							</form>
							</div>
						</div>
					</div></div>
				</div>
				</div>
		</div>
          
          </div>
      </div>
<!-- Yandex.Metrika counter --> <script type="text/javascript"> (function (d, w, c) { (w[c] = w[c] || []).push(function() { try { w.yaCounter40262734 = new Ya.Metrika({ id:40262734, clickmap:true, trackLinks:true, accurateTrackBounce:true, ut:"noindex" }); } catch(e) { } }); var n = d.getElementsByTagName("script")[0], s = d.createElement("script"), f = function () { n.parentNode.insertBefore(s, n); }; s.type = "text/javascript"; s.async = true; s.src = "https://mc.yandex.ru/metrika/watch.js"; if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); } })(document, window, "yandex_metrika_callbacks"); </script> <noscript><div><img src="https://mc.yandex.ru/watch/40262734?ut=noindex" style="position:absolute; left:-9999px;" alt="" /></div></noscript> <!-- /Yandex.Metrika counter -->
<script type="text/javascript">
    var reformalOptions = {
        project_id: 976725,
        project_host: "feelinhome.reformal.ru",
        tab_orientation: "right",
        tab_indent: "80%",
        tab_bg_color: "#00a5be",
        tab_border_color: "#FFFFFF",
        tab_image_url: "//tab.reformal.ru/T9GC0LfRi9Cy0Ysg0Lgg0L%252FRgNC10LTQu9C%252B0LbQtdC90LjRjw==/FFFFFF/88128dfd6ca0743b5ccc2f8afed9f3b1/right/0/tab.png",
        tab_border_width: 0
    };
    
    (function() {
        var script = document.createElement('script');
        script.type = 'text/javascript'; script.async = true;
        script.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'media.reformal.ru/widgets/v3/reformal.js';
        document.getElementsByTagName('head')[0].appendChild(script);
    })();
</script><noscript><a href="//reformal.ru"><img src="//media.reformal.ru/reformal.png" /></a><a href="//feelinhome.reformal.ru">Oтзывы и предложения для Feelin умный домофон</a></noscript>

</body>
</html>
