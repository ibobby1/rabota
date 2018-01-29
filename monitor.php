<!DOCTYPE html>
<html lang='ru'>
<head>
<meta http-equiv='X-UA-COMPATIBLE' content='IE=edge'/>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
<title>Feelin' - твой умный домофон</title>
   
</head>
<body style="background:#505050;text-align:center;">

<img src="/assets/images/feelindomophone-logo.svg" alt="Умный домофон" title="Умный домофон" width="250">
<div id="digital_watch" style="color:white"></div>
<p style="color:#00b8ce;font-size: 19px;">Для вызова наберите номер квартиры</p>
<script type="text/javascript">
	<?php
	$timestamp=time();
	?>
                var YEAR = <?= date('Y', $timestamp) ?>;
                var MONTH = <?= date('m', $timestamp) ?>;
                var DAY = <?= date('d', $timestamp) ?>;
                var HOUR = <?= date('H', $timestamp) ?>;
                var MINUTE = <?= date('i', $timestamp) ?>;
                var SECOND = <?= date('s', $timestamp) ?>;

                setTimeout(updateDateTime, 1000);

                 function updateDateTime() {
                  
switch (MONTH*1-1)
{
  case 0: fMonth="января"; break;
  case 1: fMonth="февраля"; break;
  case 2: fMonth="марта"; break;
  case 3: fMonth="апреля"; break;
  case 4: fMonth="мая"; break;
  case 5: fMonth="июня"; break;
  case 6: fMonth="июля"; break;
  case 7: fMonth="августа"; break;
  case 8: fMonth="сентября"; break;
  case 9: fMonth="октября"; break;
  case 10: fMonth="ноября"; break;
  case 11: fMonth="декабря"; break;
}
 
    var date = new Date();
    var hours = date.getHours();
    var minutes = date.getMinutes();
    var seconds = date.getSeconds();
    if (hours < 10) hours = "0" + hours;
    if (minutes < 10) minutes = "0" + minutes;
    if (seconds < 10) seconds = "0" + seconds;
    document.getElementById("digital_watch").innerHTML =  "Сегодня <b>"+DAY+' '+fMonth+' '+YEAR
	+' года</b> / <span style="font-size:30px">'+ HOUR + ":" + getTwoDigit(MINUTE) + ":" + getTwoDigit(SECOND)+'</span>';
	
                    SECOND += 1;

                    if (SECOND === 60) {
                        SECOND = 0;
                        MINUTE += 1;
                    }

                    if (MINUTE === 60) {
                        MINUTE = 0;
                        HOUR += 1;
                    }

                    if (HOUR === 24) {
                        HOUR = 0;
                        DAY += 1;
                    }

                    if (DAY === daysInMonth() + 1) {
                        DAY = 0;
                        MONTH += 1;
                    }

                    if (MONTH === 12) {
                        MONTH = 0;
                        YEAR += 1;
                    }

                    setTimeout(updateDateTime, 1000);
                }

                function daysInMonth() {
                    return new Date(YEAR, MONTH, 0).getDate();
                }

                function getTwoDigit(number) {
                    return (parseInt(number) < 10 ? '0' : '') + number;
                }
         
            /*
  function digitalWatch() {
	  Data = new Date();
Year = Data.getFullYear();
Month = Data.getMonth();
Day = Data.getDate();
 
// Преобразуем месяца
switch (Month)
{
  case 0: fMonth="января"; break;
  case 1: fMonth="февраля"; break;
  case 2: fMonth="марта"; break;
  case 3: fMonth="апреля"; break;
  case 4: fMonth="мая"; break;
  case 5: fMonth="июня"; break;
  case 6: fMonth="июля"; break;
  case 7: fMonth="августа"; break;
  case 8: fMonth="сентября"; break;
  case 9: fMonth="октября"; break;
  case 10: fMonth="ноября"; break;
  case 11: fMonth="декабря"; break;
}
 
    var date = new Date();
    var hours = date.getHours();
    var minutes = date.getMinutes();
    var seconds = date.getSeconds();
    if (hours < 10) hours = "0" + hours;
    if (minutes < 10) minutes = "0" + minutes;
    if (seconds < 10) seconds = "0" + seconds;
    document.getElementById("digital_watch").innerHTML =  "Сегодня <b>"+date.getDay()+' '+fMonth+' '+date.getFullYear()
	+' года</b> / <span style="font-size:30px">'+ hours + ":" + minutes + ":" + seconds+'</span>';
    setTimeout("digitalWatch()", 1000);
  }
  digitalWatch();*/
</script>
</body>
</html>
