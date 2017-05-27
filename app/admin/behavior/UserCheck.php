<?php
namespace app\admin\behavior;

use \traits\controller\Jump;//类里面引入jump;类
use \think\Session;

class UserCheck
{
    public function run(&$params)
    {
        $name = session::get('name');
        if (empty($name))
        {
            return $this->error('请登录！', 'login/index');
        }
    }
}