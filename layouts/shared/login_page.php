<body class="login-page">
<div class="login-container">
	<div class="login-branding">
		<a href="/"><img src="<? echo BASE_PATH; ?>images/feelindomophone-logo.svg" alt="Умный домофон" title="Умный домофон"></a>
	</div>
	<div class="login-content">
    
<?php
if (isset($_GET["reg"])) {

echo '<h2><strong>Регистрация</strong></h2>
		<form method="post" action="/control/?reg">
			<input type="hidden" name="register" value="1">  
        	'.$auth_err.'

			  <div class="form-group">
				<label>Код</label>
				<input type="text" placeholder="Код активации" maxlength="10" name="code" class="form-control" required>
			  </div>
			  <div class="form-group">
				<label>Номер квартиры</label>
				<input type="text" placeholder="Номер" name="flat" class="form-control" value="'.(isset($_POST["flat"]) ? $_POST["flat"] : "").'" required>
			  </div>				  

			  <div class="form-group">
				<label>Фамилия</label>
				<input type="text" placeholder="Фамилия" id="last_name" name="last_name" class="form-control" value="'.(isset($_POST["last_name"]) ? $_POST["last_name"] : "").'" required>
			  </div>
			  <div class="form-group">
				<label>Имя</label>
				<input type="text" placeholder="Имя" name="first_name" class="form-control" value="'.(isset($_POST["first_name"]) ? $_POST["first_name"] : "").'" required>
			  </div>
			  <div class="form-group">
				<label>Отчество</label>
				<input type="text" placeholder="Отчество" name="father_name" class="form-control" value="'.(isset($_POST["father_name"]) ? $_POST["father_name"] : "").'">
			  </div>
			  <div class="form-group">
				<label>Основной телефон</label>
					<div class="input-group">
					  <span class="input-group-addon">+7</span>
					  <input type="text" placeholder="(912)3456789" name="phone" class="form-control" value="'.(isset($_POST["phone"]) ? $_POST["phone"] : "").'" required>
					</div>
					<span class="help-block m-b-none">Для авторизации и отправки СМС уведомлений </span>
			  </div>							  
			  <div class="form-group">
				<label>E-mail</label>
				<input type="email" placeholder="E-mail" name="email" class="form-control" value="'.(isset($_POST["email"]) ? $_POST["email"] : "").'" required>
			  </div>
			  <div class="form-group">
				<label>Пароль</label>
				<input type="password" placeholder="Пароль" name="password" class="form-control" required>
				<p class="help-block">Пароль должен содержать только цифры и латинские буквы</p>
			  </div>					  							  
			  <div class="form-group">
				<!--label></label-->
				<div class="checkbox">						
					<label> <input type="checkbox" name="error_oferta" value="1"><a href="/oferta.html">Я принимаю условия договора оферты</a></label><br>
				</div>
			  </div>
			
			<div class="form-group">
				<button class="btn btn-primary btn-block btn-form-valid">Зарегистрироваться</button>
			</div>
            <p class="text-center"><a href="/control/">Войти</a></p>
		</form>';
	
	
}
else {

echo '<h2><strong>Авторизация</strong></h2>
		<form method="post" action="/control/">  
        	'.$auth_err.'
			<div class="form-group">
				<div class="input-group">
				  <span class="input-group-addon">+7</span>
				  <input type="text" name="phone" placeholder="Телефон" class="form-control" value="'.(isset($_POST["phone"]) ? $_POST["phone"] : "").'" required>
				</div>			
			</div>                        
			<div class="form-group">
				<input type="password" name="pasw" placeholder="Пароль" class="form-control">
			</div>
			<div class="form-group">
				 <div class="checkbox checkbox-replace">
					<input type="checkbox" id="remeber">
					<label for="remeber">Запомнить меня</label>
				  </div>
			 </div>
			<div class="form-group">
				<button class="btn btn-primary btn-block">Войти</button>
			</div>
            <p class="text-center"><a href="/control/?reg">Регистрация</a></p>
		</form>';
}
		
?>		
		
	</div>
</div>