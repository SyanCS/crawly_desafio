<?php 

include 'Crawler.php';

class CrawlerTest {

    public function testCrawler()
    {
        $crawler = new Crawler('http://applicant-test.us-east-1.elasticbeanstalk.com');
        $crawler->getCookiesAndToken();
        if (is_numeric($crawler->getAnswer())) {
            return true;
        } else {
            return false;
        }
    }
}

?>