<?php
require_once ('application/core/MY_Model.php');

class product_model extends MY_Model
{
    public $table_name = "user_project";
    public function findAll($search,$page,$per_page){
        $sql = "
                SELECT
                    user_project.`id`,
                    user_project.`user_id`,
                    user_project.`project_type`,
                    user_project.`project_num`,
                    user_project.`status`,
                    user_project.`add_time`,
                    user_info.`username`,
                    user_info.`mobile`,
                    user_info.`user_id`
                FROM
                    `user_project`
                Left Join
                    `user_info`
                On
                    user_project.user_id = user_info.user_id
                JOIN 
                (SELECT id FROM user_project as user_project ORDER BY id DESC)user_project_order ON user_project.id = user_project_order.id 
            ".$this->getSearch($search);
        //$sql .= " order by  up.id desc ";
        $sql .= $this->getLimitStr($page, $per_page);
        $result = $this->query($sql);
        return $result;
    }
    
    public function count(){
         $sql = "
                SELECT
                    count(user_project.id) as total
                FROM
                    `user_project`
              " ;
           // " .$this->getSearch($search);
        return $this->queryOne($sql);
    }
    
    public function getSearch($search) {
        $where = '';
        if( $search != '' ){
            if($search['key'] != '' ){
                $where .= "and user_project.`project_num` like('%" . $search['key']."%') or user_info.`username` like('%" . $search['key']."%')  or user_info.`mobile` like('%" . $search['key']."%')"  ;
            }
            if($search['project_type'] != '' ){
                $where .= "and user_project.`project_type` = '".$search['project_type']."'" ;
            }
            $where = trim($where,'and');
            $where = $where?' WHERE ' .$where:'' ;
        }
        return $where;
        //return '';
    }
    
    public function delete($id){
        $idArr = explode(',',$id);
        $this->db->where_in('id',$idArr);
        return $this->db->delete($this->table_name);
        //echo $this->db->last_query();
    }

    public function getData2($start,$end){
        $sql = "
            SELECT
                   u.`id`,
                    u.`status`,
                    user_project.`project_num`,
                    e.`id` as `eid`,
                    e.`ename`,
                    e.`ephone`,
                    e.`eaddress`,
                    e.`eaddress1`,
                    e.`eaddress2`,
                    e.`minaddress`,
                    e.`time`,
                    e.`exname`,
                    e.`exnum`,
                    e.`updatetime`,
                    e.`fang_status`,
                    e.`status`
                FROM
                     `express` as e
                LEFT JOIN 
                  user_project
                ON 
                  user_project.`id` = e.`pid`
                LEFT JOIN
                 `user` as u
                ON
                    u.`id` = e.`uid` 
                AND 
                   user_project.`user_id` = u.`id` 
                WHERE 
                    u.`status` = 4
            " ;
        $sql .= " order by `time` desc ";
        $sql .= " limit $start,$end";
        return  $this->query($sql);
    }
    /*
     * search
     * 模糊搜索 %$keys%
     * 2019-11-04
     */
    public function searchModel($keys){
        $sql = "
            SELECT
                   u.`id`,
                    u.`status`,
                    user_project.`project_num`,
                    e.`id` as `eid`,
                    e.`ename`,
                    e.`ephone`,
                    e.`eaddress`,
                    e.`eaddress1`,
                    e.`eaddress2`,
                    e.`minaddress`,
                    e.`time`,
                    e.`exname`,
                    e.`exnum`,
                    e.`updatetime`,
                    e.`fang_status`,
                    e.`status`
                FROM
                     `express` as e
                LEFT JOIN 
                  user_project
                ON 
                  user_project.`id` = e.`pid`
                LEFT JOIN
                 `user` as u
                ON
                    u.`id` = e.`uid`
                WHERE 
                    u.`status` = 4
                    AND 
                      e.ename
                    LIKE 
                      '%$keys%'
                    OR
                      e.ephone
                    LIKE 
                      '%$keys%'
                    OR
                      user_project.project_num
                    LIKE 
                      '%$keys%'
            " ;
        $sql .= " order by `time` desc ";
        return  $this->query($sql);
    }
    /*
     * 产品注册搜索（新）
     * 2019-11-18
     */
    public function search($key)
    {
        $sql_up = "
            SELECT
                    up.`id`,
                    up.`user_id`,
                    up.`project_type`,
                    up.`project_num`,
                    up.`add_time`
                FROM
                     `user_project` as up
                WHERE 
                      up.project_num = '$key'
            " ;
        //return  $this->query($sql);
        $re_up = $this->query($sql_up);

        if(!empty($re_up)){
            $user_id =   $re_up[0]['user_id'];
            $sql_ui = "SELECT username,mobile FROM user_info WHERE user_id = $user_id";
            $re_ui = $this->query($sql_ui);
            return array_merge($re_up[0],$re_ui[0]);
        }else{
            return 0;
        }
    }
    /*
     * 总记录数
     * 2019-11-04
     */
    public function getData2count(){
        $sql = "
            SELECT
                   u.`id`,
                    u.`status`,
                    user_project.`project_num`,
                    e.`id` as `eid`,
                    e.`ename`,
                    e.`ephone`,
                    e.`eaddress`,
                    e.`minaddress`,
                    e.`time`,
                    e.`exname`,
                    e.`exnum`,
                    e.`updatetime`,
                    e.`fang_status`,
                    e.`status`
                FROM
                     `express` as e
                LEFT JOIN 
                  user_project
                ON 
                  user_project.`id` = e.`pid`
                LEFT JOIN
                 `user` as u
                ON
                    u.`id` = e.`uid` 
                AND 
                   user_project.`user_id` = u.`id` 
                WHERE 
                    u.`status` = 4
            " ;
        return  $this->query($sql);
    }
    /*
     * 导出
     * 2018-07-20
     */
    public function getExport($id){
        $sql = "
            SELECT
                    e.`ename`,
                    e.`ephone`,
                    user_project.`project_num`,
                    e.`eaddress`,
                    e.`eaddress1`,
                    e.`eaddress2`,
                    e.`minaddress`,
                    e.`time`,
                    e.`exname`,
                    e.`exnum`,
                    e.`fang_status`,
                    e.`status`
                FROM
                     `express` as e
                LEFT JOIN 
                  user_project
                ON 
                  user_project.`id` = e.`pid`
                WHERE 
                    e.`id` 
                 IN 
                    ($id)
            " ;
        $sql .= " order by `time` desc ";
        return  $this->query($sql);
    }
    //查询收件人信息
    public function userEx($eid){
        $sql = " 
                SELECT 
                    id,
                    ename,
                    ephone,
                    eaddress,
                    eaddress1,
                    eaddress2,
                    minaddress,
                    exname,
                    fang_status,
                    exnum
                FROM
                    `express`
                WHERE
                    id = $eid
            ";
        return $this->query($sql);
    }
    //用户
    public function editInfou($id,$data){
        $this->db->where('id',$id);
        return $this->db->update('express',$data);
    }
    //快递
    public function editInfoe($id,$data){
        $this->db->where('id',$id);
        return $this->db->update('express',$data);
    }
    //回访状态
    public function editFangs($id,$data){
        $this->db->where('id',$id);
        return $this->db->update('express',$data);
    }
    //自动收货
    public function zdsh($id,$data){
        $this->db->where('id',$id);
        return $this->db->update('express',$data);
    }
}