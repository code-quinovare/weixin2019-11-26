<?php
include "MyCurl.php";
$token = "14_3qheiOY8da96V1J6NLPt3J22IsFJkFZqRx2SZlW9zSLJr1dqGFGZzQ1q14CRT-Tf9ghXOPTqItPCWNwK6LRSZTbPTiAihwzWWSZOZLPQsQygxMV1AxZDw2BXq_3VLZeeN377cID3VpfwLTNbSMUfAAAEYG14_3qheiOY8da96V1J6NLPt3J22IsFJkFZqRx2SZlW9zSLJr1dqGFGZzQ1q14CRT-Tf9ghXOPTqItPCWNwK6LRSZTbPTiAihwzWWSZOZLPQsQygxMV1AxZDw2BXq_3VLZeeN377cID3VpfwLTNbSMUfAAAEYG";
$urls = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".$token;
$auth_redirect_uri = "http://quinnovare.cn/wechat_oAuth2/index";
$url = "https://open.weixin.qq.com/connect/oauth2/authorize?" . "appid=" . "wxb7729605637ecb26" . "&redirect_uri=" . urldecode($auth_redirect_uri) . "&response_type=code&scope=snsapi_base";
//创建一级菜单
//button =>[]
$data=array(
    "button" => array(
        array(
            "name" => "快舒尔",
            "sub_button" => array(
                array(
                    "type" => "view",
                    "name" => "公司介绍",
                    "url" => $url . "&state=company#wechat_redirect"
                ),
                array(
                    "type" => "view",
                    "name" => "新闻报道",
                    "url" => $url . "&state=about#wechat_redirect"
                ),
                array(
                    "type" => "view",
                    "name" => "患者故事",
                    "url" => $url . "&state=article#wechat_redirect"
                ),
                array(
                    "type" => "view",
                    "name" => "往期回顾",
                    "url" => "https://mp.weixin.qq.com/mp/profile_ext?action=home&__biz=MzA3MDkyMDgwOA==&scene=126#wechat_redirect"
                ),
            )
        ),
        array(
            "name" => "产品中心" ,
            "sub_button" => array(
                array(
                    "type" => "click",
                    "name" => "QS-P型无针注射器",
                    "key" =>"qs_p"
                ),
                array(
                    "type" => "click",
                    "name" =>"QB-P智能控温管家",
                    "key" => "qb_p"
                ),
                array(
                    "type" => "view",
                    "name" => "操作视频",
                    "url" => "http://quinnovare.cn/product/player"
                ),
            )
        ),
        array(
            "name" => "用户中心",
            "sub_button" => array(
                array(
                    "type" => "view",
                    "name" => "会员登录",
                    "url" => $url . "&state=login#wechat_redirect"
                ),
                array(
                    "type" => "view",
                    "name" => "产品注册",
                    "url" => $url . "&state=registerProject#wechat_redirect"
                ),
                array(
                    "type" => "click",
                    "name" =>"联系客服",
                    "key" => "connect"
                ),
                array(
                    "type" => "view",
                    "name" =>"优惠兑换",
                    "url" => $url . "&state=exlogin#wechat_redirect"
                ),
                array(
                    "type" => "view",
                    "name" => "我的优惠",
                    "url" => $url . "&state=mydiscount#wechat_redirect"
                )
            )
        )
    ),
);
//如果包含汉字，请传入第二参数
$str = json_encode($data,JSON_UNESCAPED_UNICODE);
echo $str.'<br/>';
var_dump( MyCurl::post($urls,$str));