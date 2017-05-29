<?php
namespace app\admin\model;

use think\Model;

class AppName extends Model
{
    function addAll($data)
    {
        $this->saveAll($data);
    }
    function updateAll($data)
    {
        $this->saveAll($data);
    }
}