	<!-- Page Sidebar -->
	<div class="page-sidebar">
	
		<!-- Site header  -->
		<header class="site-header">
		  <div class="site-logo"><a href="/"><img src="<? echo BASE_PATH; ?>images/feelindomophone-logo.svg" alt="Умный домофон" title="Умный домофон"></a></div>
		  <div class="sidebar-collapse hidden-xs"><a class="sidebar-collapse-icon" href="#"><i class="icon-menu"></i></a></div>
		  <div class="sidebar-mobile-menu visible-xs"><a data-target="#side-nav" data-toggle="collapse" class="mobile-menu-icon" href="#"><i class="icon-menu"></i></a></div>
		</header>
		<!-- /site header -->
		
		<!-- Main navigation -->
		<ul id="side-nav" class="main-menu navbar-collapse collapse">
			<li> 
				<a href="/control/"><i class="fa fa-users"></i><span class="title">Личный кабинет</span></a> 
			</li>	
			<li> 
				<a href="/control/?reg"><i class="fa fa-check-square-o"></i><span class="title">Регистрация</span></a> 
			</li>	
            <li <?= (strpos($_SERVER["REQUEST_URI"], "about.php") !== false ? 'class="active"' : '') ?>> 
            	<a href="/control/about.php"><i class="icon-flow-tree"></i><span class="title">О системе</span></a>
            </li>
            <li <?= (strpos($_SERVER["REQUEST_URI"], "/help.php") !== false ? 'class="active"' : '') ?>> 
            	<a href="/control/help.php"><i class="icon-thumbs-up"></i><span class="title">Помощь</span></a>
            </li>
            <li <?= (strpos($_SERVER["REQUEST_URI"], "contact.php") !== false ? 'class="active"' : '') ?>> 
            	<a href="/control/contact.php"><i class="icon-mail"></i><span class="title">Наши контакты</span></a>
            </li>
			<li <?= (strpos($_SERVER["REQUEST_URI"], "payment_help.php") !== false ? 'class="active"' : '') ?>> 
            	<a href="/control/payment_help.php"><i class="fa fa-credit-card-alt"></i><span class="title">Оплата</span></a>
            </li>
            <li <?= (strpos($_SERVER["REQUEST_URI"], "services.php") !== false ? 'class="active"' : '') ?>> 
            	<a href="/control/services.php"><i class="fa fa-credit-card-alt"></i><span class="title">Услуги и сервисы</span></a>
            </li>
		</ul>
		<!-- /main navigation -->		
  </div>
  <!-- /page sidebar -->