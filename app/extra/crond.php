<?php
/**
 * 计划任务的配置表
 */

$crond_list = array(
    //每分钟
    '*' => [
        'app\index\controller\Index::remind',
    ],

    '20:00' => ['app\index\controller\Index::weather'],  //每天某时
    '10:06' => ['app\index\controller\Index::remind'],  //每天某时

    //'*:50' => ['app\rearend\controller\Crond::supplierDiscount'],  //每小时订单收货
    //'02:10'      => ['app\rearend\controller\Crond::digitalRightsCondition'],  //每天某时
    //'09:00'      => ['app\rearend\controller\Crond::dailySummary'],  //每天某时
    //'*-01 00:00' => [],  //每月
);

return $crond_list;