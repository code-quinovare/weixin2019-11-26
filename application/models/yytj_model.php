<?php
require_once ('application/core/MY_Model.php');

class yytj_model extends MY_Model
{
    public $table_name = "appointment";
    /*
     * 导出
     * 2019-11-05
     */
    public function getExport($id){
        $sql = "
            SELECT
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
                    app.`id` 
                 IN 
                    ($id)
            " ;
        $sql .= " order by `time` desc ";
        return  $this->query($sql);
    }
    /*
     * 修改-根据id获取信息
     * 2019-11-06
     */
    public function userInfo($id)
    {
        $sql = "
            SELECT
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
                    app.`id` = $id
            " ;
        return  $this->query($sql);
    }
    /*
     * 执行修改
     * 2019-11-06
     */
    public function impEdit($id,$data){
        $this->db->where('id',$id);
        return $this->db->update('appointment',$data);
    }
    /*
     * 搜索
     * 2019-11-06
     */
    public function searchModel($keys)
    {
        $sql = "
            SELECT
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
                    app.name
                    LIKE 
                    '%$keys%'
                    OR 
                    app.phone
                    LIKE 
                    '%$keys%'
                    OR 
                    app.project_num
                    LIKE 
                    '%$keys%'
                    " ;
        return  $this->query($sql);
    }

}