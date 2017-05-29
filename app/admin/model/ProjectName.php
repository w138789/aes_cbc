<?php
namespace app\admin\model;

use think\Model;

class ProjectName extends Model
{
    function addOne($data)
    {
        $this->save($data);
        return $this->project_id;
    }
    function updateOne($data, $project_id)
    {
        $this->where('project_id', $project_id)
            ->update($data);
    }
}