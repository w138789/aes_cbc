<?php
namespace app\admin\controller;

use \think\Controller;
use \think\Hook;

Hook::listen('CheckAuth', $params);

class Index extends Controller
{
    public function index()
    {
        return $this->fetch('index');
    }
}
