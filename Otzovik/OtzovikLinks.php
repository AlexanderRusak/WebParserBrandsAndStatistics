<?php
header('Content-type:text/html; charset="utf-8"');
require 'phpQuery.php';
$url='http://otzyvy.by/odegda/show/524.html';

$ch=curl_init($url);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$res=curl_exec($ch);
curl_close($ch);

//$test= '1 1 1 1 1  1 1 1 1 1 ';
//print_r(substr_count($res, 'BOSS'));
         $arrayResult=[];
         $filename ='D:\OSPanel\domains\parsing\Lamoda\shops.txt';
         $file = fopen($filename, rb);
         while (($str = fgets($file, 4096)) !== false)
         {
            $list = explode(',', $str);
         
            foreach( $list as $word)
            {
              
               $count=substr_count($res, $word);
              echo $word." => ".$count.",<br/>";
                  //ключ значение в массив           
                          
            }
           
         }
         fclose($file);
         var_dump($array);
         
         



?>
