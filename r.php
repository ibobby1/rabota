<?php
define('ABSOLUTE_PATH', dirname(__FILE__).'/');
require_once ABSOLUTE_PATH.'config/main_config.php';


require_once ABSOLUTE_PATH.'includes/database.php';
DB::connect('mysqli://'.DB_USER.':'.DB_PASSWORD.'@'.DB_HOST.'/'.DB_NAME,true);

function GUID()
{
    if (function_exists('com_create_guid') === true)
    {
        return trim(com_create_guid(), '{}');
    }

    return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
}


//$server=$_SERVER;
$serverString = $_SERVER['HTTP_CONTENT_NAME'];
$serverStringArray= preg_split("/,/", $serverString);
$name=$serverStringArray[0];
$flat=preg_split('/\-/', $name)[1];
$flat=preg_split('/\./', $flat)[0];
$flat=intval($flat);
$name=preg_split('/\-/', $name)[0];
if(strpos($name,'am1970')!=false)
	$name='cam'.date("YmdHis",time()-3600*floatval(TIME_ZONE));
$name=$name.".jpg";
$intercom=$serverStringArray[1];
$guid='';

$intercom_id=DB::query_result("SELECT id FROM Intercoms where number='%s' and trash='0'",$intercom);

if (preg_match('/cam(\d{10})-/', $serverString, $regs)) {
	$data=DB::query_fetch_array("SELECT * FROM IntercomLogs where intercom_id=%d and timestamp >= %d and timestamp <=%d order by id desc",$intercom_id,intval($regs[1])-3,intval($regs[1])+3);
	if(!empty($data))
	{
		if(!empty($data['flat']))$flat=$data['flat'];		
		$guid = GUID();
		DB::query("update IntercomLogs set guid='%s' where id=%d",$guid,$data['id']);
	}	
} 


if (preg_match('/(?:(\()|(\{))?\b[a-f0-9]{8}(?:-[a-f0-9]{4}){3}-[a-f0-9]{12}\b(?(1)\))(?(2)\})/', $serverString, $regs)) {
	//cam20170925172026-7ce48c59-dfbc-564f-5658-a4378f2e37cb.jpg
	$data=DB::query_fetch_array("SELECT * FROM IntercomLogs where intercom_id=%d and timestamp between  %d and %d ",$intercom_id,$regs[0]-3,$regs[0]+3);
	if(!empty($data))
	{
		$flat=$data['flat'];
		$intercom_id=$data['intercom_id'];
		$client_id=$data['client_id'];
	}
	$guid = $regs[0];
}
$filename=ABSOLUTE_PATH.'/photo/'.$intercom.'/'.$flat.'/'.$name;
$filename_local='photo/'.$intercom.'/'.$flat.'/'.$name;



$dirname=dirname($filename);
if (!is_dir($dirname))
{
	$test=mkdir($dirname, 0777, true);
}
$res = file_get_contents("php://input");

$file = fopen($filename, "w");
fputs($file, $res);
fclose($file);
if(empty($intercom))return;
$client_id=0;

if($intercom_id)
	$client_id=DB::query_result("SELECT client_id FROM ClientIntercom where flat='%s' and intercom_id=%d",$flat,$intercom_id);
DB::query("INSERT INTO IntercomPhotos
(`name`,
`intercom_id`,
`client_id`,
`flat`,
`intercom_date`,
`created`,
guid)
VALUES
(
'%s',
%d,
%d,
'%s',
'%s',
%d,
'%s');",$filename_local,$intercom_id,$client_id,$flat,$serverStringArray[0],time(),$guid);



//$miniImage=new SimpleImage();
//$miniImage->load('/var/www/photo/'.$intercom.'/'.$flat.'/'.$name);
//$miniImage->resize(50,50);
////$newName=preg_split('/\./', $name)[0];
//$newName=$newName."Mini.jpg";
//$miniImage->save('/var/www/photo/'.$intercom.'/'.$flat.'/'.$newName);



