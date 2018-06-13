<?php
header('Content-type:text/html; charset="utf-8"');
$start = microtime(true);
set_time_limit(0);
ini_set('MAX_EXECUTION_TIME', 86400);
ini_set('MAX_EXECUTION_TIME', -1);
require 'ResponseAndDate.php';
require 'MakeDirectory.php';
require 'phpQuery.php';
function shopsName(){
$fileTotal=[];
$today; 
$url='https://www.vitrini.by/places/shopping/clothes/';
try {
	$ch=curl_init($url);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$res=curl_exec($ch);
if ($res==FALSE) {
	throw new Exception("The execution was not successful: "." file ".__FILE__." on line ".__LINE__, 1);
	exit();
	}
}
catch (Exception $ExecutionErr) {
	echo $ExecutionErr->getMessage();
}
curl_close($ch);
$doc=phpQuery::newDocument($res);
			try {
$pages=$doc->find('.paging')->find('li:last')->text();
if (is_null($pages) || $pages==0) {
throw new Exception("Parse error: "." file ".__FILE__." on line ".__LINE__, 1);
				                  }
				}				 
			catch (Exception $ParseErr) {
			echo $ParseErr->getMessage();
			exit();
				}
for ($i=0; $i<$pages ; ++$i) { 
	$url='https://www.vitrini.by/places/shopping/clothes/'.$i."/";
    $ch=curl_init($url);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$resShops=curl_exec($ch);
			try{
			if ($resShops==FALSE) {
			throw new Exception("The execution was not successful: "." file ".__FILE__." on line ".__LINE__, 1);
			exit();
				}
}				
			catch (Exception $ExecutionShopsErr) {
			echo $ExecutionShopsErr->getMessage();
}
	curl_close($ch);
	$doc=phpQuery::newDocument($resShops);
	try {
		$shops=$doc->find('.store-box__title');
		if ($shops=="") {
		throw new Exception("Parse error: "." file ".__FILE__." on line ".__LINE__, 1);
		exit();
				                  }
	foreach ($shops as $key=>$shop) {
		$pqShop=pq($shop);
		$textShops[]=$pqShop->text()." ";
	}
$raitings=$doc->find('.raiting')->find('span');
		if ($raitings=="") {
		throw new Exception("Parse error: "." file ".__FILE__." on line ".__LINE__, 1);
		exit();
				                  }
	foreach ($raitings as $key=>$raiting) {
		$pqRaiting=pq($raiting);
		$textRaiting[]=$pqRaiting->text()." ";
	}
$responses=$doc->find('.response')->find('span');
if ($responses=="") {
		throw new Exception("Parse error: "." file ".__FILE__." on line ".__LINE__, 1);
		exit();
				                  }
	foreach ($responses as $key=>$response) {
		$pqResponse=pq($response);
		$textResponses[]=$pqResponse->text()." ";
	}
$responsesUrl=$doc->find('.response')->find('a');
if ($responsesUrl=="") {
		throw new Exception("Parse error: "." file ".__FILE__." on line ".__LINE__, 1);
		exit();
				                  }
	foreach ($responsesUrl as $key=>$resUrl) {
		$pqUrl=pq($resUrl);
		$textUrl[]=$pqUrl->attr('href');
	}
	 } 
	catch (Exception $ExexptionParseShops) {
		echo $ExexptionParseShops->getMessage();
	}
}
$todayRaiting=(string)date("d-m-Y").' Raiting.txt';
$todayShops=(string)date("d-m-Y").' Shops.txt';
$todayResponses=(string)date("d-m-Y").' Responses.txt';
$todayTotal=(string)date("d-m-Y").' Total.txt';
$todayTotalcsv=(string)date("d-m-Y").' Total.csv';
file_put_contents('Raitings\\'.$todayRaiting, $textRaiting);
file_put_contents('Shops\\'.$todayShops, $textShops);
file_put_contents('Responses\\'.$todayResponses, $textResponses);
$cts=count($textShops);//counts of text shops
for($i=0;$i<$cts;++$i)
		{
			$fileTotal[$i]= $textShops[$i]." ".$textRaiting[$i]." ".$textResponses[$i].",";
		}
		file_put_contents('Total\\'.$todayTotal, $fileTotal);
		file_put_contents('Total\\'.$todayTotalcsv, $fileTotal);
//getStatistics($textUrl,$textShops,$textResponses);

}
shopsName();

$time = microtime(true) - $start;
printf('Скрипт выполнялся %.4F мин.', $time/60);
?>