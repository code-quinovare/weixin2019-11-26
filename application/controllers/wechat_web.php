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
class wechat_web extends MY_Controller_Site
{
    /***********用户*************/
    public function web()
    {
        $this->loadView('wechat_web/wechat_index.html');
    }
    public function web2()
    {
        $this->loadView('wechat_web/wechat_index2.html');
    }

}