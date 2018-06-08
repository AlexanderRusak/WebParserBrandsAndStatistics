<?php
header('Content-type:text/html; charset="utf-8"');
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
$ch=curl_init($url);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$res=curl_exec($ch);
curl_close($ch);
$doc=phpQuery::newDocument($res);
$pages=$doc->find('.paging')->find('li:last')->text();
for ($i=0; $i<$pages ; ++$i) { 
	$url='https://www.vitrini.by/places/shopping/clothes/'.$i."/";
    $ch=curl_init($url);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$resShops=curl_exec($ch);
	curl_close($ch);
	$doc=phpQuery::newDocument($resShops);
    $shops=$doc->find('.store-box__title');
	foreach ($shops as $key=>$shop) {
		$pqShop=pq($shop);
		$textShops[]=$pqShop->text()." ";
	}
$raitings=$doc->find('.raiting')->find('span');
	foreach ($raitings as $key=> $raiting) {
		$pqRaiting=pq($raiting);
		$textRaiting[]=$pqRaiting->text()." ";
	}
$responses=$doc->find('.response')->find('span');
	foreach ($responses as $key=>$response) {
		$pqResponse=pq($response);
		$textResponses[]=$pqResponse->text()." ";
	}
$responsesUrl=$doc->find('.response')->find('a');
	foreach ($responsesUrl as $key=>$resUrl) {
		$pqUrl=pq($resUrl);
		$textUrl[]=$pqUrl->attr('href');
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
echo $cts;
for($i=0;$i<$cts;++$i)
		{
			$fileTotal[$i]= $textShops[$i]." ".$textRaiting[$i]." ".$textResponses[$i].",";
		}
		file_put_contents('Total\\'.$todayTotal, $fileTotal);
		file_put_contents('Total\\'.$todayTotalcsv, $fileTotal);
getStatistics($textUrl,$textShops,$textResponses);
}
shopsName();
?>