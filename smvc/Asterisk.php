<?php
//Подключение AMI
	include("includes/asteriskAmi.php");
	require_once 'includes/PAMI/Autoloader/Autoloader.php';
	PAMI\Autoloader\Autoloader::register();
	use PAMI\Client\Impl\ClientImpl as PamiClient;
	use PAMI\Message\Action\GetConfigAction; 
	use PAMI\Message\Action\OriginateAction; 
	

class Asterisk
{
	
}