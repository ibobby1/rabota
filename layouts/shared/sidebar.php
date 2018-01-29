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
			<li <?= (strpos($_SERVER["REQUEST_URI"], "index.php") !== false || $_SERVER["REQUEST_URI"] == '/control/' ? 'class="active"' : '') ?>> 
				<a href="/control/index.php"><i class="fa fa-users"></i><span class="title">Личный кабинет</span></a> 
			</li>	
			<li <?= (strpos($_SERVER["REQUEST_URI"], "history.php") !== false || $_SERVER["REQUEST_URI"] == '/control/history.php' ? 'class="active"' : '') ?>> 
				<a href="/control/history.php"><i class="fa fa-history"></i><span class="title">Журнал</span></a> 
			</li>	
			<li <?= (strpos($_SERVER["REQUEST_URI"], "keys.php") !== false ? 'class="active"' : '') ?>> 
				<a href="/control/keys.php"><i class="icon-key"></i><span class="title">Ключи</span></a> 
			</li>
			<li <?= (strpos($_SERVER["REQUEST_URI"], "edit.php") !== false ? 'class="active"' : '') ?>> 
				<a href="/control/edit.php"><i class="glyphicon glyphicon-edit"></i><span class="title">Редактирование данных</span></a> 
			</li>

            <li <?= (strpos($_SERVER["REQUEST_URI"], "about.php") !== false ? 'class="active"' : '') ?>> 
            	<a href="/control/about.php"><i class="icon-flow-tree"></i><span class="title">О системе</span></a>
            </li>
            <li <?= (strpos($_SERVER["REQUEST_URI"], "help.php") !== false ? 'class="active"' : '') ?>> 
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
			<!--li <?= (strpos($_SERVER["REQUEST_URI"], "tarifs.php") !== false ? 'class="active"' : '') ?>> 
            	<a href="/control/tarifs.php"><i class="fa fa-credit-card-alt"></i><span class="title">Тарифы</span></a>
            </li-->
		</ul>
		<!-- /main navigation -->		
  </div>
  <!-- /page sidebar -->