<?php
error_reporting(-1);
header('Content-Type: text/html; charset=utf-8');
set_time_limit(0);
ini_set('MAX_EXECUTION_TIME', 86400);
ini_set('MAX_EXECUTION_TIME', -1);
$path='Totally';
if (!file_exists($path)) {
	mkdir("Totally/", 0700);
}

function Reader(){
    $content=file_get_contents('Responses\\'.'UsingResponses.txt');
	$content=explode(" ",$content);
	return $content;
}
function getStatistics($CommentsUrl,$Shops,$ResponsesCount){
$ctsCommentsUrl=count($CommentsUrl);
for ($i=0; $i<$ctsCommentsUrl; ++$i) {	
$textNames=[];
$textDates=[];
$textComments=[];
$textSplit=[];
$url=$CommentsUrl[$i];
$ch=curl_init($url);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$res=curl_exec($ch);
curl_close($ch);
$doc=phpQuery::newDocument($res);
$names=$doc->find('.section-comments__rev')->find('span');
$dates=$doc->find('.section-comments__rev')->find('time');
$comments=$doc->find('.text');
foreach ($names as $name) 
    {
		$pqName=pq($name);
		$textNames[]=$pqName->text();
	}
foreach ($dates as $date) 
    {
		$pqDate=pq($date);
		$textDates[]=$pqDate->text();
	}
foreach ($comments as $comment) 
    {
		$pqComments=pq($comment);
		$textComments[]=$pqComments->text();
	}
	
	$size=count($textNames);
	for($j=0; $j<$size; ++$j)
	{
		
	
       $textSplit[]=$textNames[$j]." ".$textDates[$j]." ".$textComments[$j].";";
       
	}
	
	 Test($textSplit,$Shops[$i]);
	 
 }
}
?>