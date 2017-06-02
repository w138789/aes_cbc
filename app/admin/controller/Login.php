<?php
namespace app\admin\controller;

use \think\Controller;
use \think\Session;

class Login extends Controller
{
    public function index()
    {
        $name = session::get('name');
        if (empty($name))
        {

            $this->assign('name', 'sus');
            return $this->fetch('index');
        } else
        {
            $this->redirect('index/index');
        }
    }

    public function UserCheck($userName, $password, $mailValidate)
    {
        $mailValidates = session::pull('mailValidate');
        if ($userName == 'su' && $password == '123456' && !empty($mailValidate) && $mailValidates == $mailValidate)
        {
            session::set('name', 'su');
            //return session::get('name');
            $this->success('登录成功', 'index/index');
        } else
        {
            $this->error('登录失败', 'login/index');
        }
    }

    public function logout()
    {
        session::delete('name');
        //return session::get('name');
        $this->success('退出成功', 'login/index');

    }

    public function sendMail()
    {
        $text = rand('1000', '9999');
        session::set('mailValidate', $text);
        $result = send_mail($text);
        return $result;
    }

}
