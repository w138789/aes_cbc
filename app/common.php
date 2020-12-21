<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
function send_mail($text)
{
    $smtpserver     = "smtp.163.com";              //SMTP服务器
    $smtpserverport = 25;                      //SMTP服务器端口
    $smtpusermail   = "sujianxun123456@163.com";      //SMTP服务器的用户邮箱
    $smtpemailto    = "sujianxun123456@163.com";       //发送给谁
    $smtpuser       = "sujianxun123456@163.com";         //SMTP服务器的用户帐号
    $smtppass       = "w7026546";                 //SMTP服务器的用户密码
    $mailsubject    = "系统验证邮件";        //邮件主题
    $mailbody       = "你的密码是" . $text;      //邮件内容
    $mailtype       = "TXT";                      //邮件格式（HTML/TXT）,TXT为文本邮件
    $smtp           = new SMTP($smtpserver, $smtpserverport, true, $smtpuser, $smtppass);
    $smtp->debug    = false;                     //是否显示发送的调试信息
    $smtp->sendmail($smtpemailto, $smtpusermail, $mailsubject, $mailbody, $mailtype);

}

// 应用公共文件
function send_mail_qq($sendMail, $title, $text)
{
    $smtpserver     = "smtp.163.com";              //SMTP服务器
    $smtpserverport = 25;                      //SMTP服务器端口
    $smtpusermail   = "sujianxun123456@163.com";      //SMTP服务器的用户邮箱
    $smtpuser       = "sujianxun123456@163.com";         //SMTP服务器的用户帐号
    $smtppass       = "w7026546";                 //SMTP服务器的用户密码
    $smtpemailto    = $sendMail;       //发送给谁
    $mailsubject    = $title;        //邮件主题
    $mailbody       = $text;      //邮件内容
    $mailtype       = "TXT";                      //邮件格式（HTML/TXT）,TXT为文本邮件
    $smtp           = new SMTP($smtpserver, $smtpserverport, true, $smtpuser, $smtppass);
    $smtp->debug    = false;                     //是否显示发送的调试信息
    $smtp->sendmail($smtpemailto, $smtpusermail, $mailsubject, $mailbody, $mailtype);

}


// 发送多人邮件
function send_mail_more($data)
{
    $sendMail = $data['sendMail'];
    $title    = $data['title'];
    $text     = $data['text'];
    if (is_array($sendMail)) {
        foreach ($sendMail as $k => $v) {
            send_mail_qq($v, $title, $text);
        }
    }
}

/**
 * curl get 或 pust
 * @param $url
 * @param null $data
 * @return mixed
 */
function httpRequest($url, $data = null, $header = false)
{
    $curl = curl_init();
    if ($header == true) {
        $this_header = ["Content-Type:text/html;charset=utf-8"];
        curl_setopt($curl, CURLOPT_HTTPHEADER, $this_header);
    }
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
    if (!empty($data)) {
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    }
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($curl);
    curl_close($curl);
    return $output;
}

/**
 * 文件日志写入
 * @param array $data 记录内容
 * @param string $level 一级文件夹名称
 * @param string $sign 二级文件夹名称
 * @param bool $execution_allow 是否加入扩展信息
 */
function writeLog($data, $level = 'log', $sign = 'default', $execution_allow = true)
{
    //创建文件夹
    if (empty($level)) {
        $level = 'log';
    }
    $dir = ROOT_PATH . 'log/' . $level . '/';
    if (empty($sign)) {
        $sign = 'default';
    }
    $dir .= $sign . '/';
    $dir .= date('Ym') . '/';
    if (!file_exists($dir)) {
        mkdir($dir, 0777, true);
    }
    //计算文件大小
    $mb      = 1024;
    $File    = $dir . date('d') . ".txt";
    $maxSize = $mb * 10;  //1M * x 每个文件大小  10不等于10M
    if (is_file($File)) {
        $arrs = glob($dir . date('d') . '{-*,.*}*', GLOB_BRACE);
        if (count($arrs) > 1) {
            $file = $dir . date('d') . '-' . (count($arrs) - 1) . ".txt";
        } else {
            $file = $arrs[0];
        }

        $fileSize = filesize($file);
        $fileSize /= pow($mb, 1);
        if ($fileSize >= $maxSize) {
            $file    = explode("/", $file);
            $file    = $file[count($file) - 1];
            $file    = explode('-', $file);
            $file    = count($file) > 1 ? explode('.', $file[1])[0] : 0;
            $dirFile = $dir . date('d') . '-' . ($file + 1) . '.txt';
        } else {
            $dirFile = $file;
        }
    } else {
        $dirFile = $File;
    }

    //写入文件执行路径
    $filePath = "[ " . \think\Request::instance()->module() . '/' . \think\Request::instance()->controller() . '/' . \think\Request::instance()->action() . " ] ";


    // 获取基本信息
    $current_uri = '';
    if (isset($_SERVER['HTTP_HOST'])) {
        $current_uri = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    } else {
        if (isset($_SERVER['argv'])) $current_uri = "cmd:" . implode(' ', $_SERVER['argv']);
        if (isset($_SERVER['REMOTE_ADDR'])) $current_uri = "socket:" . $_SERVER['REMOTE_ADDR'];
    }
    $runtime    = round(microtime(true) - THINK_START_TIME, 10);
    $reqs       = $runtime > 0 ? number_format(1 / $runtime, 2) : '∞';
    $memory_use = number_format((memory_get_usage() - THINK_START_MEM) / 1024, 2);
    //组合数据
    $text  = '';
    $datas = [
        'time'           => date('Y-m-d H:i:s'),
        'execution_data' => [
            'path'        => $filePath,
            'current_uri' => $current_uri,
            'runtime'     => number_format($runtime, 6) . 's',
            'reqs'        => $reqs . 'req/s',
            'memory_use'  => $memory_use . 'kb',
            'file_load'   => count(get_included_files()),
            'ip'          => request()->ip(),
            'header'      => request()->header(),
        ],
        'request'        => input(),
    ];
    if (empty($execution_allow) && isset($datas['execution_data'])) unset($datas['execution_data']);
    $datas['data'] = $data;
    $text          .= json_encode($datas, JSON_UNESCAPED_UNICODE);
    file_put_contents($dirFile, $text . "\r\n", FILE_APPEND);
}
