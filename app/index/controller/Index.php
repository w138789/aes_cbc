<?php

namespace app\index\controller;

use think\Controller;

class Index extends Controller
{
    public function index()
    {
        return $this->fetch();
    }

    public static function weather()
    {
        $url    = 'https://www.tianqiapi.com/api/?version=v1&cityid=101280101&appid=79153923&appsecret=z4wwVL4o';
        $result = httpRequest($url);
        $result = json_decode($result, true);
        $string = '广州 ' . $result['data'][1]['day'] . ' 气温: 最高 ' . $result['data'][1]['tem1'] . ' 最低 ' . $result['data'][1]['tem2'] . ' ' . $result['data'][1]['index'][3]['title'] . ' 等级 ' . $result['data'][1]['index'][3]['level'] . ' ' . $result['data'][1]['index'][3]['desc'];
        $data   = [
            'sendMail' => [
                '294496623@qq.com',
            ],
            'title'    => '明天天气',
            'text'     => $string,
        ];
        send_mail_more($data);
        return $result;
    }

    /**
     * 每日提醒支付原生微信订单
     */
    public static function remind()
    {
        $string = '支付原生微信订单';
        $data = [
            'sendMail' => [
                '294496623@qq.com',
            ],
            'title'    => '支付原生微信订单',
            'text'     => $string,
        ];
        send_mail_more($data);
    }
}
