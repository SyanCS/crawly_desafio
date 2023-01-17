<?php

class Crawler {
    
    private $url;
    private $cookies;
    private $token;
    
    public function __construct($url){
        $this->url = $url;
    }
    
    public function getCookiesAndToken(){
        // Prepara a requisição GET
        $ch = curl_init($this->url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, true);
        
        // Executa a requisição
        $response = curl_exec($ch);
        
        // Extrai os cookies
        preg_match_all('/^Set-Cookie:\s*([^;]*)/mi', $response, $matches);
        $this->cookies = implode(';', $matches[1]);
        
        // Extrai o token
        preg_match('/id\=\"token\"\s+value\=\"(.+)\"/i', $response, $matches);
        $this->token = $matches[1];
        
        // Finaliza a requisição
        curl_close($ch); 
    }
    
    public function getAnswer() {


        $command = "curl '".$this->url."' \
          -H 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9' \
          -H 'Accept-Language: pt-BR,pt;q=0.9,en-US;q=0.8,en;q=0.7' \
          -H 'Cache-Control: max-age=0' \
          -H 'Connection: keep-alive' \
          -H 'Content-Type: application/x-www-form-urlencoded' \
          -H 'Cookie: ".$this->cookies."' \
          -H 'Origin: ".$this->url."' \
          -H 'Referer: ".$this->url."/' \
          -H 'Upgrade-Insecure-Requests: 1' \
          -H 'User-Agent: Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Safari/537.36' \
          --data-raw "."'token=".$this->findAnswer($this->token)."' \
          --compressed \
          --insecure";

        exec($command, $exec_result);

        $dom = new DOMDocument();
        $dom->loadHTML($exec_result[0]);

        $span = $dom->getElementById('answer');
        $answer = $span->nodeValue;

        return $answer;
    }

    private function findAnswer($token){
        $replacements = array("a" => "z", "b" => "y", "c" => "x", "d" => "w", "e" => "v", "f" => "u", "g" => "t", "h" => "s", "i" => "r", "j" => "q", "k" => "p", "l" => "o", "m" => "n", "n" => "m", "o" => "l", "p" => "k", "q" => "j", "r" => "i", "s" => "h", "t" => "g", "u" => "f", "v" => "e", "w" => "d", "x" => "c", "y" => "b", "z" => "a", "0" => "9", "1" => "8", "2" => "7", "3" => "6", "4" => "5", "5" => "4", "6" => "3", "7" => "2", "8" => "1", "9" => "0");
    
        $e = str_split($token);
        for ($t = 0; $t < count($e); $t++) {
            if (array_key_exists($e[$t], $replacements)) {
                $e[$t] = $replacements[$e[$t]];
            }
        }
        $token = implode($e);
        return $token;
    }
}