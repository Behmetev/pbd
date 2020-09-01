<?php
include_once 'dbconn.php';

function gen_uuid() {
    return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
        mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),
        mt_rand( 0, 0xffff ),
        mt_rand( 0, 0x0fff ) | 0x4000,
        mt_rand( 0, 0x3fff ) | 0x8000,
        mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
    );
}

$data = array(
    'v' => 1,
    'tid' => $tid,
    'cid' => gen_uuid(),
    't' => 'event'
);

$data['ec'] = "category";
$data['ea'] = "product";
$data['el'] = "element";
$data['ev'] = "34";

//$url = https://www.google-analytics.com/collect
$url = 'https://www.google-analytics.com/debug/collect';
$content = http_build_query($data);
$content = utf8_encode($content);
$user_agent = 'Example/1.0 (http://example.com/)';

$ch = curl_init();
curl_setopt($ch,CURLOPT_USERAGENT, $user_agent);
curl_setopt($ch,CURLOPT_URL, $url);
curl_setopt($ch,CURLOPT_HTTPHEADER,array('Content-type: application/x-www-form-urlencoded'));
curl_setopt($ch,CURLOPT_HTTP_VERSION,CURL_HTTP_VERSION_1_1);
curl_setopt($ch,CURLOPT_POST, TRUE);
curl_setopt($ch,CURLOPT_POSTFIELDS, $content);
curl_exec($ch);
curl_close($ch);