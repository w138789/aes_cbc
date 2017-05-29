<?php
namespace app\admin\controller;

use \think\Controller;
use \think\Db;

class Index extends Base
{

    public $privateKey = "kskskdflajflakdslkfjalk";
    public $keyOne = '079';

    public function index()
    {
        if ($_POST)
        {
            $str  = $_POST['str'];
            $strs = explode('|', $str);
            unset($strs[0]);
            $k    = 0;
            $s    = '';
            $name = array();
            foreach ($strs as $v)
            {
                $vs = explode('^', $v);
                if ($vs[0] == 'value_one')
                {
                    if (!empty($vs[1]))
                    {
                        $re             = $this->mcrypt_en($vs[1]);
                        $vs[1]          = $re[1];
                        $name['one_iv'] = $re[0];
                    }
                }
                if ($vs[0] == 'value_two')
                {
                    if (!empty($vs[1]))
                    {
                        $re             = $this->mcrypt_en($vs[1]);
                        $vs[1]          = $re[1];
                        $name['two_iv'] = $re[0];
                    }
                }
                if ($vs[0] == 'value_three')
                {
                    if (!empty($vs[1]))
                    {
                        $re               = $this->mcrypt_en($vs[1]);
                        $vs[1]            = $re[1];
                        $name['three_iv'] = $re[0];
                    }
                }

                $name[$vs[0]] = $vs[1];
                $s            = $s . $vs[1];
                if ($vs[0] == 'app_name')
                {
                    $k++;
                }
                if ($vs[0] == 'project_name')
                {
                    if (empty($s))
                    {
                        return '没有内容';
                    }
                    $projectId = model('ProjectName')->addOne($name);
                }
                if ($vs[0] == 'value_three')
                {
                    if (empty($s))
                    {
                        return '没有内容';
                    }
                    unset($name['project_name']);
                    $name['project_id'] = $projectId;
                    $s                  = '';
                    $aa[]               = $name;
                }
            }
            model('AppName')->addAll($aa);
            return $aa;
        }
        $projects = model('ProjectName')->select();
        return $this->fetch('index', ['projects' => $projects]);
    }

    public function show($project_id)
    {
        $data = model('AppName')
            ->where('project_id', $project_id)
            ->select();
        foreach ($data as $k => $v)
        {
            if (isset($v['value_one']) && !empty($v['value_one']))
            {
                $v['value_one'] = $this->mcrypt_de($v['value_one'], $v['one_iv']);
            }
            if (isset($v['value_two']) && !empty($v['value_two']))
            {
                $v['value_two'] = $this->mcrypt_de($v['value_two'], $v['two_iv']);
            }
            if (isset($v['value_three']) && !empty($v['value_three']))
            {
                $v['value_three'] = $this->mcrypt_de($v['value_three'], $v['three_iv']);
            }
            unset($v['one_iv']);
            unset($v['two_iv']);
            unset($v['three_iv']);
            $datas[$k] = $v;
        }
        $projects = model('ProjectName')->select();
        $app_name = model('ProjectName')->where('project_id', $project_id)->value('project_name');
        $this->assign('project_id', $project_id);
        $this->assign('projects', $projects);
        $this->assign('app_names', $datas);
        $this->assign('app_name', $app_name);
        return $this->fetch('show');
    }

    public function edit($project_id)
    {
        $data = model('AppName')
            ->where('project_id', $project_id)
            ->select();
        foreach ($data as $k => $v)
        {
            if (isset($v['value_one']) && !empty($v['value_one']))
            {
                $v['value_one'] = $this->mcrypt_de($v['value_one'], $v['one_iv']);
            }
            if (isset($v['value_two']) && !empty($v['value_two']))
            {
                $v['value_two'] = $this->mcrypt_de($v['value_two'], $v['two_iv']);
            }
            if (isset($v['value_three']) && !empty($v['value_three']))
            {
                $v['value_three'] = $this->mcrypt_de($v['value_three'], $v['three_iv']);
            }
            unset($v['one_iv']);
            unset($v['two_iv']);
            unset($v['three_iv']);
            $datas[$k] = $v;
        }
        $projects = model('ProjectName')->select();
        $app_name = model('ProjectName')->where('project_id', $project_id)->value('project_name');
        $this->assign('app_names', $datas);
        $this->assign('projects', $projects);
        $this->assign('app_name', $app_name);
        $this->assign('project_id', $project_id);
        return $this->fetch('edit');
    }

    public function update()
    {
        if ($_POST)
        {
            $str        = $_POST['str'];
            $project_id = $_POST['project_id'];
            $strs       = explode('|', $str);
            unset($strs[0]);
            $k    = 0;
            $s    = '';
            $name = array();
            foreach ($strs as $v)
            {
                $vs = explode('^', $v);
                if ($vs[0] == 'value_one')
                {
                    if (!empty($vs[1]))
                    {
                        $re             = $this->mcrypt_en($vs[1]);
                        $vs[1]          = $re[1];
                        $name['one_iv'] = $re[0];
                    }
                }
                if ($vs[0] == 'value_two')
                {
                    if (!empty($vs[1]))
                    {
                        $re             = $this->mcrypt_en($vs[1]);
                        $vs[1]          = $re[1];
                        $name['two_iv'] = $re[0];
                    }
                }
                if ($vs[0] == 'value_three')
                {
                    if (!empty($vs[1]))
                    {
                        $re               = $this->mcrypt_en($vs[1]);
                        $vs[1]            = $re[1];
                        $name['three_iv'] = $re[0];
                    }
                }

                $name[$vs[0]] = $vs[1];
                $s            = $s . $vs[1];
                if ($vs[0] == 'app_name')
                {
                    $k++;
                }
                if ($vs[0] == 'project_name')
                {
                    if (empty($s))
                    {
                        return '没有内容';
                    }
                    model('ProjectName')->updateOne($name, $project_id);
                }
                if ($vs[0] == 'value_three')
                {
                    if (empty($s))
                    {
                        return '没有内容';
                    }
                    unset($name['project_name']);
                    //$name['project_id'] = $projectId;
                    $s    = '';
                    $aa[] = $name;
                }
            }

            model('AppName')->updateAll($aa);
            return $aa;
        }
    }

    public function mcrypt_en($data)
    {

        $privateKey = $this->pad2Length($this->privateKey, 16);
        //$iv = '5555555555555555';
        $cipher  = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_ECB, '');
        $iv_size = mcrypt_enc_get_iv_size($cipher);
        $iv      = mcrypt_create_iv($iv_size, MCRYPT_RAND); #IV自动生成？
        //echo '自动生成iv的长度:' . strlen($iv) . '位:' . bin2hex($iv) . '<br>';
        //$iv = '1234567812345678';
        $iv       = bin2hex($iv);
        $result[] = $iv;
        //$data = "usaogou";
        $iv = $this->iv($iv);
        //加密
        $encrypted = mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $privateKey, $data, MCRYPT_MODE_CBC, $iv);
        $result[]  = base64_encode($encrypted);

        return $result;
    }

    public function mcrypt_de($data, $iv)
    {
        $privateKey = $this->pad2Length($this->privateKey, 16);
        //echo $iv;
        //$iv            = '1234567812345678';
        $ivs           = $this->iv($iv);
        $encryptedData = base64_decode($data);
        $decrypted     = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $privateKey, $encryptedData, MCRYPT_MODE_CBC, $ivs);
        return rtrim($decrypted, "\0");
    }

    //将解密后多余的长度去掉
    function trimEnd($text)
    {
        $len = strlen($text);
        $c   = $text[$len - 1];
        if (ord($c) < $len)
        {
            for ($i = $len - ord($c); $i < $len; $i++)
            {
                if ($text[$i] != $c)
                {
                    return $text;
                }
            }
            return substr($text, 0, $len - ord($c));
        }
        return $text;
    }

    public function iv($iv)
    {

        $iv = substr($iv, 0, -3);
        //echo '转字符串: ' . $iv . '<br>';
        $iv = $iv . $this->keyOne;
        return hex2bin($iv);

    }

    /**
     * 补全字符串
     * @param $text
     * @param $padlen
     * @return string
     */
    public function pad2Length($text, $padlen)
    {
        $len  = strlen($text) % $padlen;
        $res  = $text;
        $span = $padlen - $len;
        for ($i = 0; $i < $span; $i++)
        {
            $res .= chr($span);
        }
        return $res;
    }

}
