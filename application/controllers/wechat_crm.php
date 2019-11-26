<?php
require_once ('application/core/MY_Controller.php');
/**
 *
 * Enter description here .
 *
 * @author
 * @property
 *
 */
class wechat_crm extends MY_Controller_Site
{
    /***********用户*************/
    //活动
    public function activity()
    {
        $this->loadView('arr_img.html');
    }
    public function web()
    {
        $this->loadView('message_web.html');
    }
    //dataCheck
    public function dataCheck()
    {
        $name = $_POST['name'];
        $content = $_POST['content'];
        $email = $_POST['email'];
        $date=date("Y-m-d H:i:s");//取得系统时间
        $ip = $_POST['ip']; //取得发言的IP地址
        $api = file_get_contents("http://ip.taobao.com/service/getIpInfo.php?ip=$ip");
        if($api == false){
            $api = file_get_contents("http://freeapi.ipip.net/$ip");
            $str = $api;

        }else{
            $re = json_decode($api,true);
            $country = $re['data']['country'];
            $region = $re['data']['region'];
            $city = $re['data']['city'];
            $isp = $re['data']['isp'];
            $str = $country."|".$region."|".$city."|".$isp."\n";
        }
        $data['name'] = $name;
        $data['email'] = $email;
        $data['content'] = $content;
        $data['ip'] = $ip;
        $data['address'] = $str;
        $data['addtime'] = $date;
        //信息入库
        $this->db->insert('wechat_message',$data);
    }
    
    /***********用户*************/

    /*
     *
     * Gaoxianghua
     * 2019/05/22 10:00:00
     *
     */
    public function index()
    {
        //退出
        //$this->session->unset_userdata('login');
        //var_dump($this->input->ip_address());
        //
        //var_dump($this->session->userdata('login'));
        if(!empty($this->session->userdata('login'))){
            $query = $this->db->query(
                "  SELECT
                    name,email,content,address,addtime
                 FROM
                     wechat_message
                ORDER BY 
                id
                DESC 
            "
            );
            $row = $query->result_array();

            $this->page_data['data']=$row;

            $this->loadView('crm_index.html', $this->page_data);

        }else{
            echo "<script> window.location.href='/wechat_crm/login';</script>";
        }
    }
    /*
     * Login
     */
    public function login()
    {
        $this->loadView('crm_login.html');
    }
    /*
    * ckeckLogin
    */
    public function check_login()
    {
        if(!empty($_POST['account']) && !empty($_POST['password'])){
            $accout = $_POST['account'];
            $password = md5($_POST['password']);
            $query = $this->db->query(
                "  SELECT
                    id
                 FROM
                     crm_admin
                WHERE 
                account = '$accout'
                AND 
                password = '$password'
            "
            );
            $row = $query->result_array();
            if(!empty($row)){
                $this->session->set_userdata('login', 'sign_in');
                //var_dump($this->session->userdata('login'));
                echo "<script> window.location.href='/wechat_crm';</script>";
            }else{
                echo "<script>  alert('账号或密码错误！'); window.location.href='/wechat_crm/login';</script>";
            }


        } else{
            echo "<script>  alert('账号或密码错误！'); window.location.href='/wechat_crm/login';</script>";
        }
    }
    /*
     * 退出
     */
    public function loginout()
    {
        //退出
        $this->session->unset_userdata('login');
        echo "<script> window.location.href='/wechat_crm/login';</script>";
    }
}