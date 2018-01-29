		<div class="header-secondary row gray-bg" style="padding:0;">
		<div class="col-lg-12">
			<!--div class="page-heading clearfix">
				<!--h1 class="page-title pull-left"><?# if(!empty($nav_arr[FILE_NAME])) echo  $nav_arr[FILE_NAME]->name ?></h1-->
			<!--/div-->
			<!-- Breadcrumb -->
			<ol class="breadcrumb breadcrumb-2"> 
				<li><a href="/control/"><i class="fa fa-home"></i>Главная</a></li>
				<?= (FILE_NAME == 'index.php' ? '' : '<li><a href="/control/'.FILE_NAME.'">'.(!empty($nav_arr[FILE_NAME])?$nav_arr[FILE_NAME]->class:'').' '.(!empty($nav_arr[FILE_NAME])?$nav_arr[FILE_NAME]->name:'').'</a></li>') ?>
			</ol>
		</div>
		</div>
