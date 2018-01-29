<?php
define('ABSOLUTE_PATH', dirname(dirname(__FILE__)).'/');
error_reporting(E_ALL);

define('DB_CHARSET', 'utf8');
define("REVATIVE_PATH", "admin");
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
require_once ABSOLUTE_PATH.'includes/notify.php';
DB::connect('mysqli://'.DB_USER.':'.DB_PASSWORD.'@'.DB_HOST.'/'.DB_NAME,true);

$extentions_head='/etc/asterisk/extensions.head';
$extentions='/etc/asterisk/extensions.conf';
$users_head='/etc/asterisk/users.head';
$users='/etc/asterisk/users.conf';
$last_extentions_stamp=ABSOLUTE_PATH.'files/history/extensions';
$last_users_stamp=ABSOLUTE_PATH.'files/history/users';
$ext_config=file_get_contents($extentions_head);
$ext_config_notify='';
$users_config=file_get_contents($users_head);
$need_reload=false;

$intercoms=DB::query_fetch_all("select * from Intercoms where trash='0'",'id');
$added_serial=array();
foreach($intercoms as $intercom)
{
	$intercom_id=$intercom['id'];
	
	if(!empty($intercom['number']) and !empty($intercom['sip_password']) and !isset($added_serial[$intercom['number']]))
	{
		$sip_login=$intercom['number'];
		$users_config.="\n[$sip_login](domofon)
mailbox = $sip_login
username = $sip_login
cid_number = $sip_login
macaddress = $sip_login
label = $sip_login
secret =".$intercom['sip_password']."
";
		$added_serial[$intercom['number']]=true;
	}
	/*
	$keys=DB::query_fetch_all("select ci.id sip_id, k.number, k.phone ci.flat, k.sip, c.password client_password from ClientKeys k 
		join ClientIntercom ci on ci.client_id=k.client_id and ci.intercom_id=k.intercom_id		
		join Clients c on c.id=ci.client_id and c.act='1' and c.trash='0'
		where k.intercom_id=%d and k.act='1'", $intercom_id);
	$i=1;
	$sip_keys=array();
	$phone_keys=array();
	$flats=array();
	foreach($keys as $key)
	{
		if(!empty($key['sip']) and !empty($key['client_password'])){
			if(!isset($sip_keys[$key['sip_id']]))$sip_keys[$key['sip_id']]=array();
			
			$sip_keys[$key['sip_id']][]="sip/".$key['sip'];
			
			//$ext_config.="exten => ".$key['sip_id'].",$i,dial(sip/".$key['sip'].", 5)\n";
			$sip_login=$key['sip'];
			$users_config.="\n[$sip_login](flat)
mailbox = $sip_login
username = $sip_login
cid_number = $sip_login
macaddress = $sip_login
label = $sip_login
secret =".$key['client_password']." 
";
		}
	}
	echo $users_config;
	*/
	$flats=DB::query_fetch_all("select * from ClientIntercom where intercom_id=%d", $intercom_id);
	
	foreach($flats as $flat)
	{
		$sip=array();
		$call=array();
#		$notify='';
#		$notifyClient=DB::query_fetch_all("select notify from ClientsNotifycations where client_id=%d and status='1' and intercom=%d ",$flat['client_id'],$intercom['number']);
#		foreach($notifyClient as $clientNotify){
#		$notify=$clientNotify['notify'];
#		}
		$keys_flat=DB::query_fetch_all("select i.*, k.phone, k.sip, c.password from IntercomKeys i 
			join ClientKeys k on k.id=i.key_id and k.act='1'
			join Clients c on c.id=k.client_id and c.act='1' and c.trash='0'
			where i.clientintercom_id=%d",$flat['id']);
		
		
		foreach($keys_flat as $key)
		{
			if($key['send_mobile']=='1')
			{
				$key['sip'] = preg_replace('/[^0-9]/', '',$key['sip']);
				$sip[]='sip/'.$key['sip'];
				if(!isset($user_added[$key['sip']]))
				{
				$sip_login=$key['sip'];
				$users_config.="\n[$sip_login](flat)
mailbox = $sip_login
username = $sip_login
cid_number = $sip_login
macaddress = $sip_login
label = $sip_login
secret =".$key['password']." 
";
				$user_added[$key['sip']]=true;
				}
			}
			if($key['send_call']=='1' and !empty($key['phone']))
			{
				$key['phone']=preg_replace('/[^0-9]/', '',$key['phone']);
				$call[]="sip/8".$key['phone']."@trg";
			}
			
		}
		$i=1;
		if(!empty($sip))
		{
			$ext_config.="exten => ".$flat['id'].",$i,dial(".implode('/&',$sip).", ".XMPP_WAIT.")\n";
			$i++;
		}
		if(!empty($call))
			$ext_config.="exten => ".$flat['id'].",$i,dial(".implode('&',$call).")\n";

##		if($notify=='2')
#		{
#			$ext_config_notify.="[outgoing_to_".$flat['id']."]\n";
#			$ext_config_notify.="exten => s,1,Answer\n";
#			$ext_config_notify.="exten => s,n,Wait(1)\n";
#			$ext_config_notify.="exten => s,n,Background(/usr/local/share/asterisk/sounds/".$flat['client_id'].")\n";
#			$ext_config_notify.="exten => s,n,hangup\n";
#		}
		$ext_config_notify.=generateExtensionsNotify($flat['client_id'],$intercom['number'],$flat['id']);

	}
	
	/*
	$keys=DB::query_fetch_all("select ci.id sip_id, k.number, k.phone, ik.send_call, ik.send_mobile, k.code, ci.flat, k.sip, c.password client_password from ClientKeys k 
		join ClientIntercom ci on ci.client_id=k.client_id and ci.intercom_id=k.intercom_id
		join IntercomKeys ik on ik.clientintercom_id=ci.id
		join Clients c on c.id=ci.client_id and c.act='1' and c.trash='0'
		where k.intercom_id=%d and k.act='1'", $intercom_id);
	foreach($keys as $key)
	{	
	
		if($key['send_call']=='1' and !empty($key['phone']) and preg_match('/^(\d{10})$/', $key['phone']))		
		{
			if(!isset($phone_keys[$key['sip_id']]))$phone_keys[$key['sip_id']]=array();
			
			$phone_keys[$key['sip_id']][]="sip/8".$key['phone']."@trg";			
		}
		$i++;
	}
	foreach($sip_keys as $id=>$key)
	{
		$ext_config.="exten => ".$id.",1,dial(".implode('&',$key).", ".XMPP_WAIT.")\n";
	}
	foreach($phone_keys as $id=>$key)
	{
		if(!empty($sip_keys))$i=2;
		else $i=1;
		$ext_config.="exten => ".$id.",$i,dial(".implode('&',$key).")\n";
	}
	
	foreach($keys as $key)
	{		
		if(!empty($sip_keys))$i=2;
		else $i=1;
		
		if($key['send_call']=='1' and !empty($key['phone']) and preg_match('/^(\d{10})$/', $key['phone']))
		{
			$ext_config.="exten => ".$key['sip_id'].",$i,dial(sip/8".$key['phone']."@trg)\n";
			$i++;
		}		
	}*/
}	

$ext_config.="exten => 112,1,Dial(SIP/".EMEGRGENCY_PHONE."@trg)\n";
//$md5_extentions='';
//if(file_exists($last_extentions_stamp))$md5_extentions=file_get_contents($last_extentions_stamp);

$md5_extentions=md5_file($extentions);
$md5_data=md5($ext_config);
if($md5_extentions !=$md5_data)
{
	file_put_contents($extentions,$ext_config);
	file_put_contents($extentions,$ext_config_notify, FILE_APPEND | LOCK_EX);
	file_put_contents($last_extentions_stamp.date("d.m.Y_H:i:s").'.hist',$ext_config);
	echo exec('sudo asterisk -rx "dialplan reload"');
	echo '<br>';
}else echo 'not need update extensions.conf<br>';
//$md5_users='';
//if(file_exists($last_users_stamp))$md5_users=file_get_contents($last_users_stamp);

$md5_users=md5_file($users);
$md5_data=md5($users_config);
if($md5_users !=$md5_data)
{
	file_put_contents($users,$users_config);
	file_put_contents($last_users_stamp.date("d.m.Y_H:i:s").'.hist',$users_config);
	echo 'update users.conf<br>';
	echo exec('sudo asterisk -rx "sip reload"');
	echo '<br>';
}else echo 'not need update users.conf<br>';
/*if(!empty(INTERCOM))
{
	$data='';
	$intercom_id=DB::query_result("select id from Intercoms where number = '%s' and trash='0'",INTERCOM);
	if(empty($intercom_id))die('Error:wrong intercom number');
	$flats=DB::query_fetch_all("select ci.id sip_id, ci.client_id, ci.flat, c.guestCode, c.sipAdress,silentModeStart,silentModeFinish,silentModeActive, 
		ci.analog  from ClientIntercom ci join Clients c on c.id=ci.client_id and c.trash='0' and c.act='1' where ci.intercom_id=%d",$intercom_id);
	if(empty($flats))die();
	$send_calls=array();
	$keys=DB::query_fetch_all("select ci.sip_id, k.number, k.phone, k.send_call, k.code, ci.flat from ClientKeys k 
		join ClientIntercom ci on ci.client_id=k.client_id and ci.intercom_id=k.intercom_id
		where k.intercom_id=%d and k.act='1'", $intercom_id);
	foreach($keys as $key)
	{		
		if(!empty($key['number']))$data.="rf:".$key['flat'].":".$key['number']."\n";
		if(!empty($key['code']))$data.="key:".$key['flat'].":".$key['code']."\n";
		if($key['send_call']=='1')$send_calls[$key['sip_id']]=true;
			
			//$data.="sip:".$key['flat'].":".$key['phone']."@".SIP_HOST."\n";
		
	}
	
	foreach($flats as $flat)
	{
		if(empty($flat['flat']))continue;
		if($flat['analog']!='')$data.="ana:".$flat['flat'].":".$flat['analog']."\n";
		if(!empty($flat['guestCode']))$data.="key:".$flat['flat'].":".$flat['guestCode']."\n";
		//if(!empty($flat['sipAdress']))$data.="sip:".$flat['flat'].":".$flat['sipAdress']."\n";
		if($flat['silentModeActive']=='1' and !empty($flat['silentModeStart']) and !empty($flat['silentModeFinish']))
			$data.="skip:".$flat['flat'].":".$flat['silentModeStart']."-".$flat['silentModeFinish']."\n";
		//$data.="rf:".$key['number']."\n";
		if(isset($send_calls[$flat['sip_id']]))
			$data.="sip:".$flat['flat'].":".$flat['sip_id']."@".SIP_HOST."\n";
	}
	
	//$data.="sip:76:".$flat['sipAdress']."\n";
	file_put_contents(ABSOLUTE_PATH.'files/history/'.INTERCOM.'_'.date("d.m.Y_H:i:s").'.hist',$data);
	echo $data;
	exit();
}


*/
#	function generateExtensionsNotify($client_id,$intercom,$flat_id)
#		{
#			$notify='';
#			$ext_config_notify='';
#			$notifyClient=DB::query_fetch_all("select notify from ClientsNotifycations where client_id=%d and status='1' and intercom=%d ",$client_id,$intercom);
#			foreach($notifyClient as $clientNotify){
#				$notify=$clientNotify['notify'];
#			}
#			if($notify=='2')
#			{
#				$ext_config_notify.="[outgoing_to_".$flat_id."]\n";
#				$ext_config_notify.="exten => s,1,Answer\n";
#				$ext_config_notify.="exten => s,n,Wait(1)\n";
#				$ext_config_notify.="exten => s,n,Background(/usr/local/share/asterisk/sounds/".$client_id.")\n";
#				$ext_config_notify.="exten => s,n,hangup\n";
#			}
#		return $ext_config_notify;
#		}

?>