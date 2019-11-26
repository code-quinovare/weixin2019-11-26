<?php
require_once ('application/core/MY_Controller.php');

/**
 * 注册产品展示
 * Enter description here .
 *
 *
 *
 *
 * @author
 *
 * @property
 *
 */
class product  extends MY_Controller_Site
{
    const API_OPEN = "https://open.weixin.qq.com/connect/oauth2/authorize";
    public $open_id = '';

    public function __construct()
    {
        parent::__construct();
        $CI = & get_instance();
        $this->page_data['redirect'] = base_url('register_project');
        if($this->input->get('open_id')){
            $this->page_data['redirect'] = base_url('register_project?open_id='.$this->input->get('open_id'));
        }
        if($this->input->get('token')){
            $this->page_data['redirect'] = base_url('register_project?token='.$this->input->get('token'));
        }
        $CI->config->load('wechat');
        $wechat_config = $CI->config->item('wechat');
        $this->appid = $wechat_config['appid'];
    }

    public function index()
    {
        $Agent = $_SERVER['HTTP_USER_AGENT'];
        if(strpos($Agent,'MicroMessenger')){
            $redirect_uri = urldecode(base_url('wechat_oAuth2/index'));
            $this->page_data['redirect'] = self::API_OPEN . '?appid=' . $this->appid . '&redirect_uri=' . $redirect_uri . '&response_type=code&scope=snsapi_base&state=registerProject#wechat_redirect';
        }
        $this->loadView('product_register.html', $this->page_data);
    }
    
    public function player()
    {
        $this->loadView('product_videos.html', $this->page_data);
    }
    //conn
    public function connect()
    {
        $this->loadView('product_conn.html', $this->page_data);
    }
    //确认收货
    public function confrimGoogs()
    {
        if(!empty($_POST)){
            $id = $_POST['id'];
            $open_id = $_POST['open_id'];
            $data['status'] = 4;
            $data['updatetime'] = time();
            $this->load->model('project_model');
            $result = $this->project_model->conGoods($id,$data);
            if($result){
               echo "<script language=javascript> alert('收货成功！');location.href='http://quinnovare.cn/user?open_id=$open_id';</script>";
            }else{
                echo "<script language=javascript> alert('收货失败！'); history.back();</script>";
            }
        }
    }
    //新闻报道
    public function news()
    {
        $this->loadView('product_news.html', $this->page_data);
    }
    //糖朝视频
    public function tcPlayer()
    {
        $this->loadView('tangchao_videos.html', $this->page_data);
    }
    //腾讯云视频
    public function tcPlayer_tx()
    {
        $this->loadView('txy_videos.html', $this->page_data);
    }
    //招聘
    public function hr()
    {
        $this->loadView('hr.html', $this->page_data);
    }
    //地区经理
    public function hr_area_yg()
    {
        $this->page_data['city'] = "云贵";
        $this->loadView('zp/hr_area_yg.html', $this->page_data);
    }
    public function hr_area_fz()
    {
        $this->page_data['city'] = "福州";
        $this->loadView('zp/hr_area_fz.html', $this->page_data);
    }
    public function hr_area_hz()
    {
        $this->page_data['city'] = "杭州";
        $this->loadView('zp/hr_area_fz.html', $this->page_data);
    }
    public function hr_area_sh()
    {
        $this->page_data['city'] = "上海";
        $this->loadView('zp/hr_area_fz.html', $this->page_data);
    }
    public function hr_area_zz()
    {
        $this->page_data['city'] = "郑州";
        $this->loadView('zp/hr_area_fz.html', $this->page_data);
    }
    public function hr_area_cd()
    {
        $this->page_data['city'] = "成都";
        $this->loadView('zp/hr_area_fz.html', $this->page_data);
    }
    public function hr_area_cq()
    {
        $this->page_data['city'] = "重庆";
        $this->loadView('zp/hr_area_fz.html', $this->page_data);
    }
    public function hr_area_nj()
    {
        $this->page_data['city'] = "南京";
        $this->loadView('zp/hr_area_fz.html', $this->page_data);
    }
    public function hr_area_sjz()
    {
        $this->page_data['city'] = "石家庄";
        $this->loadView('zp/hr_area_fz.html', $this->page_data);
    }
    public function hr_area_gz()
    {
        $this->page_data['city'] = "广州";
        $this->loadView('zp/hr_area_fz.html', $this->page_data);
    }
    public function hr_area_wh()
    {
        $this->page_data['city'] = "武汉";
        $this->loadView('zp/hr_area_fz.html', $this->page_data);
    }
    //销售代表
    public function hr_xsdb_hz()
    {
        $this->page_data['city'] = "杭州";
        $this->loadView('zp/hr_xsdb_hz.html', $this->page_data);
    }
    //苏州
    public function hr_xsdb_fz()
    {
        $this->page_data['city'] = "苏州";
        $this->loadView('zp/hr_xsdb_hz.html', $this->page_data);
    }
    public function hr_xsdb_sh()
    {
        $this->page_data['city'] = "上海";
        $this->loadView('zp/hr_xsdb_hz.html', $this->page_data);
    }
    public function hr_xsdb_zz()
    {
        $this->page_data['city'] = "郑州";
        $this->loadView('zp/hr_xsdb_hz.html', $this->page_data);
    }
    public function hr_xsdb_cd()
    {
        $this->page_data['city'] = "成都";
        $this->loadView('zp/hr_xsdb_hz.html', $this->page_data);
    }
    public function hr_xsdb_cq()
    {
        $this->page_data['city'] = "重庆";
        $this->loadView('zp/hr_xsdb_hz.html', $this->page_data);
    }
    public function hr_xsdb_nj()
    {
        $this->page_data['city'] = "南京";
        $this->loadView('zp/hr_xsdb_hz.html', $this->page_data);
    }
    public function hr_xsdb_nb()
    {
        $this->page_data['city'] = "宁波";
        $this->loadView('zp/hr_xsdb_hz.html', $this->page_data);
    }
    public function hr_xsdb_bj()
    {
        $this->page_data['city'] = "北京";
        $this->loadView('zp/hr_xsdb_bj.html', $this->page_data);
    }
    public function hr_xsdb_gz()
    {
        $this->page_data['city'] = "广州";
        $this->loadView('zp/hr_xsdb_hz.html', $this->page_data);
    }
    public function hr_xsdb_nc()
    {
        $this->page_data['city'] = "南昌";
        $this->loadView('zp/hr_xsdb_hz.html', $this->page_data);
    }
    public function hr_xsdb_xz()
    {
        $this->page_data['city'] = "大连";
        $this->loadView('zp/hr_xsdb_hz.html', $this->page_data);
    }
    public function hr_xsdb_hf()
    {
        $this->page_data['city'] = "合肥";
        $this->loadView('zp/hr_xsdb_hz.html', $this->page_data);
    }
    public function hr_xsdb_km()
    {
        $this->page_data['city'] = "昆明";
        $this->loadView('zp/hr_xsdb_hz.html', $this->page_data);
    }
    public function hr_xsdb_gy()
    {
        $this->page_data['city'] = "贵阳";
        $this->loadView('zp/hr_xsdb_hz.html', $this->page_data);
    }
    public function hr_xsdb_tj()
    {
        $this->page_data['city'] = "天津";
        $this->loadView('zp/hr_xsdb_hz.html', $this->page_data);
    }
    public function hr_xsdb_cc()
    {
        $this->page_data['city'] = "长春";
        $this->loadView('zp/hr_xsdb_hz.html', $this->page_data);
    }
    public function hr_xsdb_sz()
    {
        $this->page_data['city'] = "深圳";
        $this->loadView('zp/hr_xsdb_hz.html', $this->page_data);
    }
    public function hr_xsdb_lz()
    {
        $this->page_data['city'] = "兰州";
        $this->loadView('zp/hr_xsdb_hz.html', $this->page_data);
    }
    public function hr_xsdb_heb()
    {
        $this->page_data['city'] = "哈尔滨";
        $this->loadView('zp/hr_xsdb_hz.html', $this->page_data);
    }
    public function hr_xsdb_ty()
    {
        $this->page_data['city'] = "太原";
        $this->loadView('zp/hr_xsdb_hz.html', $this->page_data);
    }
    //区域医学经理
    public function hr_regmark_qd()
    {
        $this->page_data['city'] = "北京/上海/广州";
        $this->loadView('zp/hr_regmark.html', $this->page_data);
    }
    //线下客服专员
    public function hr_regmark_xxkf()
    {
        $this->page_data['city'] = "石家庄/哈尔滨/西安";
        $this->loadView('zp/hr_regmark_xxkf.html', $this->page_data);
    }
    //医学经理
    public function hr_yxjl()
    {
        $this->loadView('zp/hr_yxjl.html', $this->page_data);
    }
    //产品经理
    public function hr_cpjl()
    {
        $this->loadView('zp/hr_cpjl.html', $this->page_data);
    }
    //机械研发
    public function hr_jxyf()
    {
        $this->loadView('zp/hr_jxyf.html', $this->page_data);
    }
    //总监助理
    public function hr_zjzl()
    {
        $this->loadView('zp/hr_zjzl.html', $this->page_data);
    }
    //生产经理
    public function hr_scjl()
    {
        $this->loadView('zp/hr_scjl.html', $this->page_data);
    }
    //生产工人
    public function hr_scgr()
    {
        $this->loadView('zp/hr_scgr.html', $this->page_data);
    }
    //质检员
    public function hr_zjy()
    {
        $this->loadView('zp/hr_zjy.html', $this->page_data);
    }
    //注册 测试
    public function regindex()
    {
        $this->loadView('showProjects.html', $this->page_data);
    }
    //公司介绍
    public function gsjs()
    {
        $this->loadView('gsjs.html');
    }
    public function apiTest()
    {
       /* $date=date("Y-m-d H:i:s");//取得系统时间
        $ip = $_SERVER["REMOTE_ADDR"]; //取得发言的IP地址
        $api = file_get_contents("http://ip.taobao.com/service/getIpInfo.php?ip=$ip");
        if($api == false){
            $api = file_get_contents("http://freeapi.ipip.net/$ip");
            $newStr = sprintf('%-15s', $ip);//减号表示从右边补全
            $fp=fopen("dataApi.txt","a");//以只写模式打开gb.dat文本文件,文件指针指向文件尾部.
            $str =$newStr."|".$date."|".$api;
            fwrite($fp,$str);//将数据写入文件
            fclose($fp);//关闭文件

        }else{
            $re = json_decode($api,true);
            //var_dump($re);

            $country = $re['data']['country'];
            $region = $re['data']['region'];
            $city = $re['data']['city'];
            $isp = $re['data']['isp'];
            $newStr = sprintf('%-15s', $ip);//减号表示从右边补全

            $fp=fopen("dataApi.txt","a");//以只写模式打开gb.dat文本文件,文件指针指向文件尾部.
            $str =$newStr."|".$date."|".$country."|".$region."|".$city."|".$isp."\n";
            fwrite($fp,$str);//将数据写入文件
            fclose($fp);//关闭文件
        }*/
        echo "<br/>";
        echo "&nbsp;";echo "&nbsp;";echo "&nbsp;";echo "&nbsp;";
        echo "<a href='https://www.wenjuan.com/s/FZrAvi/'>线下活动报名1</a>";
        echo "<br/>";
        echo "&nbsp;";echo "&nbsp;";echo "&nbsp;";echo "&nbsp;";
        echo "<a href='https://www.wenjuan.com/s/FZrAvi/'>线下活动报名2</a>";
        echo "<br/>";
        echo "&nbsp;";echo "&nbsp;";echo "&nbsp;";echo "&nbsp;";
        echo "<a href='https://www.wenjuan.com/s/FZrAvi/'>线下活动报名3</a>";
       /* if(empty($_GET['num'])){
            exit('num等于16位数字');
        }
        $project_num = $_GET['num'];
        function checkProject($project_num)
        {
            $client = new SoapClient('http://digitcode.yesno.com.cn/CCNOutService/OutDigitCodeService.asmx?wsdl');
            var_dump($client);die;
            $client->soap_defencoding = 'UTF-8';
            // 参数转为数组形式传递
            $aryPara = array(
                'userID' => 'b6cf5d36063e44b2aa1a7d33599a1b3e',
                'userPwd' => '50e374505e31470dad4455951ea42066',
                'ip' => $_SERVER['REMOTE_ADDR'],
                'acCode' => $project_num,
                'language' => '1',
                'channel' => 'X'
            );
            // 调用远程函数
            $result =  $client->Get_AcCodeInfoInterface($aryPara);

            return $result;
        }

        function xml_to_array( $xml,$first_code,$last_code ){
            $chars = preg_split($first_code, $xml, 0, PREG_SPLIT_OFFSET_CAPTURE);
            if(isset($chars[1][0])&&!empty($chars[1][0])){
                $code = explode($last_code,$chars[1][0]);
                if(!empty($code)){
                    return   $code[0];
                }
            }
            return false;
            //print_R($chars);die;
        }
        $re = checkProject("$project_num");
        var_dump($re);
        echo '<br/>';
        $zcode = xml_to_array($re->reply,"/<zcode>/","</zcode>");
        echo "获取产品编号：";
        var_dump($zcode);*/


    }


}










