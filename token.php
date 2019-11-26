<?php
include "MyCurl.php";

//设置appid和appsecret
// define('APPID', "wx476b5ea1a9f2ed6a");
define('APPID', "wxb7729605637ecb26");
// define('APPSECRET', 'bc2f52bfb5e9a4c3a0fbed933fddc58a');
define('APPSECRET', '8b9972f5a999568b60f74def0c974554');
define('TOKENFILE', 'token.txt');

//获取token
function getToken()
{
	// 在本地文件中查找token
	if (file_exists(TOKENFILE)) {
		//判断是否过期
		$fcTime = filectime(TOKENFILE);
		if ($fcTime + 7200 > time()) {//没过期
			$content = file_get_contents(TOKENFILE);
			return $content;
		} else {
			unlink(TOKENFILE);//删除文件
			return requireToken();
		}
	} else {//如果本地没有，到服务器上请求
		return requireToken();
	}
}


//请求token
function requireToken()
{
	$url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential";
	$url .= "&appid=" . APPID."&secret=".APPSECRET;
	$content =  MyCurl::get($url);
	$arr = json_decode($content,true);
	$content = $arr['access_token'];
	file_put_contents(TOKENFILE, $content);
	return $content;
}