<?php 

	include 'Crawler.php';
	
	$crawler = new Crawler("http://applicant-test.us-east-1.elasticbeanstalk.com");
	$crawler->getCookiesAndToken();
	echo $crawler->getAnswer();
?>