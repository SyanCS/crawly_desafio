<?php 

	include 'CrawlerTest.php';
	
	$crawlerTeste = new CrawlerTest();
	$result = $crawlerTeste->testCrawler();

	if($result){
		echo 'teste ok';
	} else {
		echo 'falha teste';
	}
?>