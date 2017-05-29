<?php
namespace app\admin\behavior;

use think\Controller;
use think\Session;

/**
 *
 */
class UserCheck
{
    use \traits\controller\Jump;

    public function run(&$params)
    {
        if (!session::get('name'))
        {
            return $this->redirect('login/index');

        }
    }
}
