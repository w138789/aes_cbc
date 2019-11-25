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
function send_mail_qq($text)
{
    $smtpserver     = "smtp.163.com";              //SMTP服务器
    $smtpserverport = 25;                      //SMTP服务器端口
    $smtpusermail   = "sujianxun123456@163.com";      //SMTP服务器的用户邮箱
    $smtpuser       = "sujianxun123456@163.com";         //SMTP服务器的用户帐号
    $smtppass       = "w7026546";                 //SMTP服务器的用户密码
    $smtpemailto    = "294496623@qq.com";       //发送给谁
    $mailsubject    = "明天天气";        //邮件主题
    $mailbody       = $text;      //邮件内容
    $mailtype       = "TXT";                      //邮件格式（HTML/TXT）,TXT为文本邮件
    $smtp           = new SMTP($smtpserver, $smtpserverport, true, $smtpuser, $smtppass);
    $smtp->debug    = false;                     //是否显示发送的调试信息
    $smtp->sendmail($smtpemailto, $smtpusermail, $mailsubject, $mailbody, $mailtype);

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
    if ($header == true)
    {
        $this_header = ["Content-Type:text/html;charset=utf-8"];
        curl_setopt($curl, CURLOPT_HTTPHEADER, $this_header);
    }
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
    if (!empty($data))
    {
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    }
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($curl);
    curl_close($curl);
    return $output;
}
