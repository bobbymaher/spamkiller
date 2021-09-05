<?php

$files = ['php', 'txt', 'log', 'csv'];

foreach ($files as $file) {

    foreach (range('a', 'z') as $column) {

        $ch = curl_init();
        $url = 'https://www.example.com/' . $column . '.' . $file;
        echo $url . PHP_EOL;

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

        curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');

        $headers = array();
        $headers[] = 'Connection: keep-alive';
        $headers[] = 'Pragma: no-cache';
        $headers[] = 'Cache-Control: no-cache';
        $headers[] = 'Upgrade-Insecure-Requests: 1';
        $headers[] = 'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/92.0.4515.131 Safari/537.36';
        $headers[] = 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9';
        $headers[] = 'Sec-Gpc: 1';
        $headers[] = 'Accept-Language: en-GB,en-US;q=0.9,en;q=0.8';
        $headers[] = 'Dnt: 1';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        $httpStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        echo 'HTTP '. $httpStatus . ($httpStatus==404? '' : '    !!!') .  PHP_EOL;
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch) . PHP_EOL;
        } else {

            //var_dump($result);
        }
        curl_close($ch);
    }
}
