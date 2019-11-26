<?php
$appid     = "wxb7729605637ecb26";
$appsecret = "8b9972f5a999568b60f74def0c974554";
$url       = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appid&secret=$appsecret";

$ch = curl_init(); // 创建一个 cURL 资源
//curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch,CURLOPT_USERAGENT,$_SERVER['HTTP_USER_AGENT']);//模拟浏览器动作
curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,0); //不验证HTTPS
curl_setopt($ch, CURLOPT_URL, $url); // CURLOPT_URL 目标 url 地址
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); // CURLOPT_SSL_VERIFYPEER False: 终止 cURL 在服务器进行验证
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // CURLOPT_RETURNTRANSFER 返回原生的（Raw）输出
$output = curl_exec($ch);

var_dump($output);
curl_close($ch);


$json_output = json_decode($output);
var_dump($json_output);
