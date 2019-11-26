<?php
require_once ('application/core/MY_Controller.php');

/**
 * 预约登记
 *2019-10-24
 */
class reg_appointment  extends MY_Controller_Site
{
    public function index()
    {
        $this->loadView('appointment/reg_app.html');
    }
    public function doAppdata()
    {
        $data['buy_time'] = htmlspecialchars($this->input->post('buy_time'));
        $project_num = htmlspecialchars($this->input->post('project_num'));
        $data['project_num'] = strtoupper($project_num);    //转大写
        $data['name'] = htmlspecialchars($this->input->post('ename'));
        $data['phone'] = htmlspecialchars($this->input->post('ephone'));
        //省市区
        $data_add['addpro'] = htmlspecialchars($this->input->post('eaddpro'));
        $arr = explode(' ',$data_add['addpro']);
        if(!empty($arr[0])){
            $data['address'] = $arr[0];
        }else{
            $data['address'] = '';
        }
        if(!empty($arr[1])){
            $data['address1'] = $arr[1];
        }else{
            $data['address1'] = '';
        }
        if(!empty($arr[2])){
            $data['address2'] = $arr[2];
        }else{
            $data['address2'] = '';
        }
        //详细地址
        $data_add['addcity'] = htmlspecialchars($this->input->post('eaddcity'));
        if($data_add['addcity'] != ''){
            $data['minaddress'] = $data_add['addcity'];
        } else{
            $data['minaddress'] = '';
        }
        //渠道
        $data['channel'] = htmlspecialchars($this->input->post('channel'));
        $ip = $_SERVER["REMOTE_ADDR"];
        if (!empty($ip)){
            $data['ip'] = $ip;
        }else{
            $data['ip'] = '';
        }
        $data['ip'] = $_SERVER["REMOTE_ADDR"];
        $data['time'] = time();
        $data['status'] = 1;
        $data['type'] = 1;
        $re = $this->db->insert('appointment',$data);
        if($re){
            echo $this->result_lib->setInfoJson('提交成功');
            exit();
        }else{
        echo $this->result_lib->setErrorsJson('提交失败');
        }
    }
}
