		<!-- Main header -->
		<div class="main-header row">
		  <div class="col-sm-6 col-xs-7">
		  
			<!-- User info -->
			<ul class="user-info pull-left">          
			  <li class="profile-info dropdown"><a data-toggle="dropdown" class="dropdown-toggle" href="#" aria-expanded="false"> <img width="44" class="img-circle avatar" alt="" src="<? echo BASE_PATH; ?>images/boss-512.png"><? echo $_SESSION["AUTH_NAME"] ?> <span class="caret"></span></a>
			  
				<!-- User action menu -->
				<ul class="dropdown-menu">				  
				  <li><a href="/control/edit.php"><i class="icon-user"></i>Профиль</a></li>
				  <li class="divider"></li>
				  <li><a href='#' class='logout'><i class="icon-logout"></i> Выйти</a></li>
				</ul>
	            <form method='POST' id='logout'>
    	        	<input type='hidden' name='logout' value='1'>
	            </form>                  
				<!-- /user action menu -->
				
			  </li>
			</ul>
			<!-- /user info -->
			
		  </div>
		  
		</div>
		<!-- /main header -->