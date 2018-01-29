<?php 

class User
{
	public $user_login;
	public $user_name;
	public $user_role_id;
	public $user_session_code;
	public $user_uk_id;
	
    public function __construct()
	{
		if(!empty($_SESSION["user"]))
		{
			$this->user_login=$_SESSION["user"]['login'];
			$this->user_name=$_SESSION["user"]['name'];
			$this->user_id=$_SESSION["user"]['id'];
			$this->user_uk_id=$_SESSION["user"]['uk_id'];
			$this->user_role_id=$_SESSION["user"]['role_id'];
			$this->user_session_code=$_SESSION["user"]['session_code'];
		}
	}
	
    public function checkSession()
    {
		if($_SERVER['REQUEST_URI']== '/'.REVATIVE_PATH.'/user/login/')return;

		if ($_SESSION["auth"] !== true) {
			setcookie("last_url",$_SERVER['REQUEST_URI']);
			header("Location: ".BASE_PATH.'user/login/'); 
			exit;
		}
		else {
			$auth= DB::query_result("select count(id) from Users where session_code='%s' and id=%d and trash='0' and act='1'",$this->user_session_code,$this->user_id);
			if($auth==0)
			{
				unset($_SESSION["auth"],$_SESSION["user"]);
				$_SESSION['message']='Авторизация пройдена на другом устройстве';
				setcookie("last_url",$_SERVER['REQUEST_URI']);
				header("Location: ".BASE_PATH.'user/login/'); 
				exit;
			}
		}
	}
	public function getClientIP($headerContainingIPAddress = null)
    {
        if (!empty($headerContainingIPAddress)) {
            return isset($_SERVER[$headerContainingIPAddress]) ? trim($_SERVER[$headerContainingIPAddress]) : false;
        }
        $knowIPkeys = [
            'HTTP_CLIENT_IP',
            'HTTP_X_FORWARDED_FOR',
            'HTTP_X_FORWARDED',
            'HTTP_X_CLUSTER_CLIENT_IP',
            'HTTP_FORWARDED_FOR',
            'HTTP_FORWARDED',
            'REMOTE_ADDR'
        ];
        foreach ($knowIPkeys as $key) {
            if (array_key_exists($key, $_SERVER) !== true) {
                continue;
            }
            foreach (explode(',', $_SERVER[$key]) as $ip) {
                $ip = trim($ip);
                if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 | FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false) {
                    return $ip;
                }
            }
        }
        return false;
    }
}