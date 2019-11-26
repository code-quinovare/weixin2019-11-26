<?php
//自定义curl类，模拟各种请求
class MyCurl
{
	public static function get($url)
	{
		//1 初始curl
		$ch = curl_init($url);

		//2 设置参数
		//是否返回数据
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HEADER, false);//是否显示请求头
		curl_setopt($ch, CURLOPT_TIMEOUT, 10);//请求超时时间

        curl_setopt($ch,CURLOPT_USERAGENT,$_SERVER['HTTP_USER_AGENT']);//模拟浏览器动作
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,0); //不验证HTTPS

		//3执行
		$content = curl_exec($ch);

		//4 关闭
		curl_close($ch);

		return $content;
	}


	public static function post($url,$data)
	{
		//1 初始curl
		$ch = curl_init($url);

		//2 设置参数
		//是否返回数据
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);//是否显示请求头
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);//请求超时时间
        curl_setopt($ch, CURLOPT_POST, true);//使用post请求
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);//使用post请求的参数
		//3执行
		$content = curl_exec($ch);
		//var_dump(curl_error($content));
		//4 关闭
		curl_close($ch);

		return $content;
	}
}



