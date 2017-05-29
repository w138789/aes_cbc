<?php
namespace app\admin\model;

use think\Model;

class AppName extends Model
{
    function addAll($data)
    {
        $this->saveAll($data);
    }
    function addOne($data)
    {
        $this->insert($data);
    }
    function updateOne($data,$id)
    {
        $this->where($id)
        ->update($data);
    }
}