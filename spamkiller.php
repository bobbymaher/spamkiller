<?php

$redirectURL = '';
function utf8_random_string(int $length): string
{
    $r = "";

    for ($i = 0; $i < $length; $i++) {
        $codePoint = mt_rand(0x80, 0xffff);
        $char = \IntlChar::chr($codePoint);
        if ($char !== null && \IntlChar::isprint($char)) {
            $r .= $char;
        } else {
            $i--;
        }
    }

    return $r;
}


function generateRandomString($length = 10)
{
    return substr(str_shuffle(str_repeat($x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length / strlen($x)))), 1, $length);
}
$sleep = 0;


$maxlength = 800;

$i = 0;

while (true) {
 
    $ch = curl_init();
    $random = generateRandomString(9);
    //$random = utf8_random_string($maxlength / 2) . utf8_random_string($maxlength / 2);
    $url = 'https://www.example.com/q.php?' . $random;
    //echo $url . PHP_EOL;
    echo 'pingin ' . $maxlength . PHP_EOL;
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
    curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');
    //curl_setopt($ch, CURLOPT_CONNECTTIMEOUT_MS, 500); 

    $randIP = mt_rand(0, 255) . "." . mt_rand(0, 255) . "." . mt_rand(0, 255) . "." . mt_rand(0, 255);
    echo 'spoofed ' . $randIP . PHP_EOL;


    $headers = array();
    $headers[] = 'Connection: keep-alive';
    $headers[] = 'Pragma: no-cache';
    $headers[] = 'Cache-Control: no-cache';
    $headers[] = 'Upgrade-Insecure-Requests: 1';
    $headers[] = 'User-Agent: ' . $random;
    $headers[] = 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9';
    $headers[] = 'Sec-Gpc: 1';
    $headers[] = 'Accept-Language: en-GB,en-US;q=0.9,en;q=0.8';
    $headers[] = 'Dnt: 1';
    $headers[] = "REMOTE_ADDR: $randIP";
    $headers[] = "X_FORWARDED_FOR: $randIP";

    curl_setopt($ch, CURLOPT_REFERER, $redirectURL);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $result = curl_exec($ch);
    $httpStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    echo 'HTTP '. $httpStatus . PHP_EOL;

    if($httpStatus != 301){
        die('diein as code is no longer 301');
    }

    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch) . PHP_EOL;
        $sleep++;

    } else {
        if ($sleep > 0) {
            $sleep--;
        }

        $redirectURL = curl_getinfo($ch,CURLINFO_REDIRECT_URL);
        echo 'REDIRECT '. $redirectURL . PHP_EOL;
        var_dump($result);

    }
    curl_close($ch);
    if ($sleep > 0) {
        echo "sleeping $sleep" . PHP_EOL;
       sleep($sleep);
    }
    $i++;
    echo '---- done ' . $i . ' ----' . PHP_EOL;
   
}
