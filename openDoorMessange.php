<?php
/* Срипт открытия домофона из мобильного приложения, входящие параметры sip - sip адрес ключа , intercom - номер домофона*/
define('ABSOLUTE_PATH', dirname(__FILE__).'/');
define('DB_CHARSET', 'utf8');
define('MOD_DEVELOPER', true);
error_reporting(E_ALL);
define("REVATIVE_PATH", "admin");
define('IS_HTTPS', (! empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' || ! empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https' || isset($_SERVER['HTTP_X_HTTPS']) && $_SERVER['HTTP_X_HTTPS'] == '1'));
define('BASE_PATH', "http".(IS_HTTPS ? "s" : '')."://".getenv("HTTP_HOST")."/".(REVATIVE_PATH ? REVATIVE_PATH.'/' : ''));
header('Content-Type: text/html; charset=utf-8');

if (! defined('TIMEZONE') || !TIMEZONE || @!date_default_timezone_set(TIMEZONE))
{
	@date_default_timezone_set('Asia/Yekaterinburg');
}

require_once ABSOLUTE_PATH.'config/main_config.php';
require_once ABSOLUTE_PATH.'includes/database.php';

require_once ABSOLUTE_PATH.'includes/xmpphp/XMPP.php';
DB::connect('mysqli://'.DB_USER.':'.DB_PASSWORD.'@'.DB_HOST.'/'.DB_NAME,true);

#$argv[1];
#$argv[2];

#if(!empty($_GET['id_client']))
if(!empty($argv[1]))
{
#	$client_id=$_GET['id_client'];
	$client_id=$argv[1];
#	$intercom=intval($_GET['intercom']);
	$intercom=intval($argv[2]);
#	$client_id=DB::query_result("select client_id from ClientKeys  where sip='%s'",$sip_key); 
#	if(empty($client_id))die('failure');
	$intercom_count=DB::query_result("select count(i.number) from Intercoms i join ClientIntercom ci on ci.intercom_id=i.id where ci.client_id=%d and i.number='%d'",$client_id, $intercom);
	$intercom_flat=DB::query_result("select ci.flat from Intercoms i join ClientIntercom ci on ci.intercom_id=i.id where ci.client_id=%d and i.number='%d'",$client_id, $intercom);
	$intercom_type=DB::query_result("select i.device_type from Intercoms i join ClientIntercom ci on ci.intercom_id=i.id where ci.client_id=%d and i.number='%d'",$client_id, $intercom);
	if($intercom_count>0)
	{
		if($intercom_type=='bas-ip' or $intercom_type=='A7')
		{
			require_once ABSOLUTE_PATH.'includes/dnake.php';
			dnakeOpen($intercom);
			die('success');
		}
		// отправка сообщения по xmpp, настройки подключения в config/main_config.php
		$con = new XMPPHP_XMPP(XMPP_HOST, XMPP_PORT, XMPP_USER, XMPP_PASSWORD, 'xmpphp', XMPP_HOST, $printlog=false, $loglevel=XMPPHP_Log::LEVEL_INFO);
		try {
			$con->useEncryption(false);
			$con->connect();
			$con->processUntil('session_start');
			$con->presence();
			$con->getRoster();
			$con->message($intercom.'@'.XMPP_HOST, 'OPEN');
			$con->message('service@'.XMPP_HOST, 'putlog <id>'.$intercom.'</id><flat>'.$intercom_flat.'</flat><client>'.$client_id.'</client><pass>no</pass><event>0</event><time>'.time().'</time>mobile open');
			$con->disconnect();
			echo "success";
		} 
		catch(XMPPHP_Exception $e) {
			//die($e->getMessage());
			echo "failure";
		}	
	}else die('failure');
	
}	




?>