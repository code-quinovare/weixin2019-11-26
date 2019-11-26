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
class yytj_crm extends MY_Controller_Site
{
    /***********管理员登录*************/
    /*
     *2019-11-05
     */
    public function index()
    {
        if(!empty($this->session->userdata('login'))){
            if(!empty($_GET['page'])){
                $page = $_GET['page'];
            }else{
                $page = 1;
            }
            $page_limit = ($page-1)*20; //分页
            $query = $this->db->query(
                "SELECT
                    id,buy_time,project_num,name,phone,address,address1,address2,minaddress,channel,time
                 FROM
                    appointment
                 WHERE 
                    status = 1
                 ORDER BY 
                    id
                 DESC
                    limit $page_limit,20");
            $row = $query->result_array();
            //总记录数
            if(!empty($this->getCount())){
                $total = $this->getCount()[0]['total'];
            }else{
                $total = 0;
            }
            $pageCount = ceil($total/20);
            $this->page_data['pageCount'] = $pageCount;
            $this->page_data['data']=$row;
            $this->loadView('yytj_crm/index.html', $this->page_data);
        }else{
            echo "<script> window.location.href='/yytj_crm/login';</script>";
        }
    }
    /*
     * 统计总记录数
     * 2019-11-05
     * status = 1
     */
    private function getCount()
    {
        $query = $this->db->query(
            "SELECT
                    count(id) as total
             FROM
                    appointment
             WHERE 
                    status = 1
             ORDER BY 
                    id
             DESC
              ");
        return $query->result_array();
    }
    /*
     * Login
     */
    public function login()
    {
        $this->loadView('yytj_crm/login.html');
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
                "SELECT
                    id
                 FROM
                    crm_admin
                 WHERE
                    account = '$accout'
                 AND
                    password = '$password'
            ");
            $row = $query->result_array();
            if(!empty($row)){
                $this->session->set_userdata('login', 'sign_in');
                echo "<script> window.location.href='/yytj_crm';</script>";
            }else{
                echo "<script>  alert('账号或密码错误！'); window.location.href='/yytj_crm/login';</script>";
            }
        } else{
            echo "<script>  alert('请输入账号密码'); window.location.href='/yytj_crm/login';</script>";
        }
    }
    /*
     * 导出
     * 2019-11-05
     * /yytj_crm/export
     */
    public function export()
    {
        if(!empty($this->session->userdata('login'))){
            if(!empty($_POST['id'])) {
                $ids = $_POST['id'];
                $id = implode(',', $ids);
                $this->load->model('yytj_model');
                $result = $this->yytj_model->getExport($id);
                foreach ($result as $key => $value) {
                    //提交时间
                    $result[$key]['time'] = date('Y-m-d H:i:s', $result[$key]['time']);
                    //phone number
                    $result[$key]['phone'] = ' '. $result[$key]['phone'];
                }
                $datalist = $result;
                $this->excel($datalist);
            }else {
                echo "<script language=javascript>  alert('未选择任何数据'); history.back(-1);</script>";
            }
        }else{
            echo "<script>  alert('请登录'); window.location.href='/yytj_crm/login';</script>";
        }
    }
    /*
     * 修改
     * 2019-11-06
     */
    public function editInfo()
    {
        if(!empty($this->session->userdata('login'))){
            if(!empty($_GET['id'])){
                $id = $_GET['id'];
                $this->load->model('yytj_model');
                $userdata = $this->yytj_model->userInfo($id);
                $datas['data'] = $userdata[0];
                $this->load->view('yytj_crm/edit_info.html',$datas);
            }else{
                echo "<script language=javascript> history.back();</script>";
            }
        }else{
            echo "<script>  alert('请登录'); window.location.href='/yytj_crm/login';</script>";
        }
    }
    /*
     * 修改处理
     * 2019-11-06
     * checkEdit
     */
    public function checkEdit()
    {
        if(!empty($_POST)){
            $id = $_POST['id'];
            $data['name'] = $_POST['name'];
            $data['phone'] = $_POST['phone'];
            $data['project_num'] = $_POST['project_num'];
            $data['address'] = $_POST['address'];
            $data['address1'] = $_POST['address1'];
            $data['address2'] = $_POST['address2'];
            $data['minaddress'] = $_POST['minaddress'];
            $data['buy_time'] = $_POST['buy_time'];
            $data['channel'] = $_POST['channel'];
            $this->load->model('yytj_model');
            $re = $this->yytj_model->impEdit($id,$data);
            if($re){
                echo "<script language=javascript> alert('修改成功！'); history.back();</script>";
            }else{
                echo "<script language=javascript> alert('修改失败！'); history.back();</script>";
            }
        }
    }
    /*
     * 新增
     * addInfo
     * 2019-11-08
     */
    public function addInfo()
    {
        if(!empty($this->session->userdata('login'))){
            $this->load->view('yytj_crm/add_info.html');
        }else{
            echo "<script> alert('请登录'); window.location.href='/yytj_crm/login';</script>";
        }
    }
    /*
     * 新增-数据处理
     * 2019-11-08
     */
    public function checkAdd()
    {
        if(!empty($_POST)){
            $data['name'] = $_POST['name'];
            $data['phone'] = $_POST['phone'];
            $data['project_num'] = strtoupper($_POST['project_num']);
            $data['address'] = $_POST['address'];
            $data['address1'] = $_POST['address1'];
            $data['address2'] = $_POST['address2'];
            $data['minaddress'] = $_POST['minaddress'];
            $data['buy_time'] = $_POST['buy_time'];
            $data['channel'] = $_POST['channel'];
            $data['ip'] = $_SERVER["REMOTE_ADDR"];
            $data['status'] = 1;
            $data['type'] = 2;
            $data['time'] = time();
            $re = $this->db->insert('appointment',$data);
            if($re){
                echo "<script language=javascript> alert('添加成功！'); history.back(-1);</script>";
            }else{
                echo "<script language=javascript> alert('添加失败！'); history.back(-1);</script>";
            }
        }
    }
    /*
     * 搜索
     * 2019-11-06
     */
    public function search()
    {
        if(!empty($this->session->userdata('login'))){
            if(!empty($_GET['keys'])){
                $keys = $_GET['keys'];
                $this->load->model('yytj_model');
                $result = $this->yytj_model->searchModel($keys);
                $datas['data'] = $result;
                $this->load->view('yytj_crm/search_info.html',$datas);
            }else{
                echo "<script language=javascript> alert('请输入内容'); history.back();</script>";
            }
        }else{
            echo "<script> alert('请登录'); window.location.href='/yytj_crm/login';</script>";
        }
    }
    /*
     * 筛选-按时间
     * 2019-11-06
     */
    public function screenGettime()
    {
        if(!empty($_GET['start']) && !empty($_GET['end']) ){
            $start = strtotime($_GET['start']);
            $end = strtotime($_GET['end']) + (24*60*60);
            $query = $this->db->query(
                "SELECT
                    app.`id`,
                    app.`name`,
                    app.`phone`,
                    app.`project_num`,
                    app.`address`,
                    app.`address1`,
                    app.`address2`,
                    app.`minaddress`,
                    app.`buy_time`,
                    app.`channel`,
                    app.`time`
                FROM
                     `appointment` as app
                WHERE 
                    app.`status` = 1
                AND 
                    app.time > $start && app.time < $end
                ORDER BY 
                    app.time
                DESC 
            ")->result_array();
            $datas['data'] = $query;
            $datas['count'] = count($query);
            $this->load->view('yytj_crm/screen_info.html',$datas);
            //$sql .= " order by `time` desc ";
        } else{
            echo "<script language=javascript> alert('请选择时间');history.back(-1);</script>";
        }

    }
    /*
     * 删除
     * 2019-11-05
     * delInfo
     */
    public function delInfo()
    {
        if(!empty($this->session->userdata('login'))){
            if(!empty($_GET['id'])){
                $id = $_GET['id'];
                $arr_id = explode(',',$id);
                $tmp = array();
                reset($arr_id);
                while (list($key, $val) = each($arr_id)) {
                    $tmp[] = array('id'=>$val,'status'=>2);
                }
                $re = $this->db->update_batch('appointment', $tmp, 'id');
                if(!$re){
                    echo "<script language=javascript> alert('删除成功！'); history.back(-1);</script>";
                } else{
                    echo "<script language=javascript> alert('删除失败！'); history.back(-1);</script>";
                }
            }else{
                echo "<script>  alert('未选择任何数据'); history.back(-1);</script>";
            }
        }else{
            echo "<script>  alert('请登录'); window.location.href='/yytj_crm/login';</script>";
        }
    }
    /*
     * PHPExcel
     * 2019-11-05
     */
    private function excel($datalist)
    {
        $this->load->library('PHPExcel');
        $this->load->library('PHPExcel/IOFactory');
        //创建对象
        $excel = new \PHPExcel();
        //Excel表格式,这里简略写了8列
        $letter = array('A','B','C','D','E','F','G','H','I','J','K','L','N','O','P');
        //表头数组
        $tableheader = array('客户姓名','手机号','注射器编号','省','市','区/县','详细地址','购买日期','渠道','提交时间');
        //填充表头信息
        for($i = 0;$i < count($tableheader);$i++) {
            $excel->getActiveSheet()->setCellValue("$letter[$i]1","$tableheader[$i]");
        }
        //表格数组
        $data=$datalist;
        //填充表格信息
        for ($i = 2;$i <= count($data) + 1;$i++) {
            $j = 0;
            foreach ($data[$i - 2] as $key=>$value) {
                $excel->getActiveSheet()->setCellValue("$letter[$j]$i","$value");
                $j++;
            }
        }
        $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);      //第一行是否加粗
        $excel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
        $excel->getActiveSheet()->getStyle('C1')->getFont()->setBold(true);
        $excel->getActiveSheet()->getStyle('D1')->getFont()->setBold(true);
        $excel->getActiveSheet()->getStyle('E1')->getFont()->setBold(true);
        $excel->getActiveSheet()->getStyle('F1')->getFont()->setBold(true);
        $excel->getActiveSheet()->getStyle('G1')->getFont()->setBold(true);
        $excel->getActiveSheet()->getStyle('H1')->getFont()->setBold(true);
        $excel->getActiveSheet()->getStyle('I1')->getFont()->setBold(true);
        $excel->getActiveSheet()->getStyle('J1')->getFont()->setBold(true);
        $excel->getActiveSheet()->getStyle('K1')->getFont()->setBold(true);
        $excel->getActiveSheet()->getStyle('L1')->getFont()->setBold(true);
        $excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);      //水平居中
        $excel->getActiveSheet()->getStyle('B1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $excel->getActiveSheet()->getStyle('C1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $excel->getActiveSheet()->getStyle('D1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $excel->getActiveSheet()->getStyle('E1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $excel->getActiveSheet()->getStyle('F1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $excel->getActiveSheet()->getStyle('G1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $excel->getActiveSheet()->getStyle('H1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $excel->getActiveSheet()->getStyle('I1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $excel->getActiveSheet()->getStyle('J1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $excel->getActiveSheet()->getStyle('K1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $excel->getActiveSheet()->getStyle('L1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        //设置列宽度
        $excel->getActiveSheet()->getColumnDimension('A')->setWidth(12);
        $excel->getActiveSheet()->getColumnDimension('B')->setWidth(14);
        $excel->getActiveSheet()->getColumnDimension('C')->setWidth(14);
        $excel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
        $excel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
        $excel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
        $excel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
        $excel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
        $excel->getActiveSheet()->getColumnDimension('I')->setWidth(12);
        $excel->getActiveSheet()->getColumnDimension('J')->setWidth(16);

        //设置对齐
        //$excel->getActiveSheet()->getStyle('A')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        //创建Excel输入对象
        $write = new \PHPExcel_Writer_Excel5($excel);
        $time=time();
        $date = date('YmdHi',$time);
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
        header("Content-Type:application/force-download");
        header("Content-Type:application/vnd.ms-execl");
        header("Content-Type:application/octet-stream");
        header("Content-Type:application/download");;
        header("Content-Disposition:attachment;filename=预约登记信息$date.xls");
        header("Content-Transfer-Encoding:binary");
        $write->save('php://output');
    }
    /*
     * 退出
     */
    public function loginout()
    {
        //退出
        $this->session->unset_userdata('login');
        echo "<script> window.location.href='/yytj_crm/login';</script>";
    }
}