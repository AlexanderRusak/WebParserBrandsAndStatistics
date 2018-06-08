<?php
header('Content-type:text/html; charset="utf-8"');
require 'phpQuery.php';
function brandsName(){
$url='https://www.lamoda.by/brands/';
$file=file_get_contents($url);
$doc=phpQuery::newDocument($file);
$brands=$doc->find('.brands__link');
	foreach ($brands as $brand) {
		$pqBrand=pq($brand);
		$textBrands[]=$pqBrand->text().",";
	}
file_put_contents('brands.csv', $textBrands);
}
brandsName();

?>