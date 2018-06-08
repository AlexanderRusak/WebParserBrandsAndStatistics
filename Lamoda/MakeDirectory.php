<?php
error_reporting(-1);
header('Content-Type: text/html; charset=utf-8');
set_time_limit(0);
ini_set('MAX_EXECUTION_TIME', 86400);
ini_set('MAX_EXECUTION_TIME', -1);
function Test($SplitArray,$ShopName){
	$ShopName= (iconv('utf-8', 'windows-1251', $ShopName));
	if (!file_exists('Totally\\"$ShopName"')) {
		mkdir("Totally/$ShopName", 0700);
	}
	$todayTottally = (string)date("d-m-Y").' '."$ShopName".'.txt';
	file_put_contents('Totally\\'."$ShopName".'\\'.$todayTottally, $SplitArray);
}

?>