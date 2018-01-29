<?php
error_reporting(E_ALL);
if(!empty($_GET['sip']))
{
	header("Content-Type: image/jpeg");
	readfile('photo/10001000/cam20161209055755.jpg');
}

?>