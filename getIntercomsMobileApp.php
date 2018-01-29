<?php
define('ABSOLUTE_PATH', dirname(__FILE__).'/');
define('DB_CHARSET', 'utf8');
define('IS_HTTPS', (! empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' || ! empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https' || isset($_SERVER['HTTP_X_HTTPS']) && $_SERVER['HTTP_X_HTTPS'] == '1'));
define('BASE_PATH', "http".(IS_HTTPS ? "s" : '')."://".getenv("HTTP_HOST")."/".(REVATIVE_PATH ? REVATIVE_PATH.'/' : ''));
define('CSS_PATH', "http".(IS_HTTPS ? "s" : '')."://".getenv("HTTP_HOST")."/assets/" );
header('Content-Type: text/html; charset=utf-8');

if (! defined('TIMEZONE') || !TIMEZONE || @!date_default_timezone_set(TIMEZONE))
{
	@date_default_timezone_set('Asia/Yekaterinburg');
}

require_once ABSOLUTE_PATH.'config/main_config.php';
require_once ABSOLUTE_PATH.'includes/database.php';
DB::connect('mysqli://'.DB_USER.':'.DB_PASSWORD.'@'.DB_HOST.'/'.DB_NAME,true);

if(!empty($_GET['sip']))
{
	if($_GET['sip']=='123')
	{
		//echo '[{"intercom":"10001005","name":"\u0433\u043b\u0430\u0432\u043d\u044b\u0439 \u0432\u0445\u043e\u0434"},{"intercom":"10001001","name":"\u041f\u043e\u0436\u0430\u0440\u043d\u044b\u0439 \u0432\u044b\u0445\u043e\u0434"}]';
		echo '[{"intercom":"123","name":"Intercom door"}]';
		die();
	}
	$client_id=DB::query_result("select client_id from ClientKeys  where sip='%s'",$_GET['sip']); 
	if(empty($client_id))die();
	$intercoms=DB::query_fetch_all("select number intercom, comment name, device_type from Intercoms i join ClientIntercom ci on ci.intercom_id=i.id where ci.client_id='%d'",$client_id);
	
	foreach($intercoms as &$intercom)
	{
		if( (in_array($_GET['sip'],array('2523869','777888','2598489','2710113', '4701397','1978568','8742065'))
			//,'8742065' баймлер
				or in_array($intercom['device_type'],array('A7','280','bas-ip')) ) and !in_array($_GET['sip'],'6289396','9092157','3949432'))
		{
			switch($intercom['device_type'])
			{
				case 'A7':
				case '280':
				case 'bas-ip':
					$intercom['codec']='h.264';
					break;
				default:
					$intercom['codec']='h.263';
			}
			$intercom['codec']='h.264';
		}
		else unset($intercom['device_type']);
		/**/
	}
	if($_GET['sip']=='1047770')
		$intercoms[]=array('intercom'=>'1','name'=>'Атрон');
	
	if(!empty($intercoms))echo json_encode($intercoms);
}	


?>