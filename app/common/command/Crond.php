<?php
namespace app\common\command;
use think\Config;
use think\console\Command;
use think\console\Input;
use think\console\Output;

class Crond extends Command {

    protected function configure(){
        $this->setName('task')->setDescription('基本定时任务');
    }

    protected function execute(Input $input, Output $output){
        $this->doCron();
        $output->writeln("crond execute success!");
    }
    public function doCron(){
        //记录开始运行的时间
        $GLOBALS['_beginTime'] = microtime(TRUE);

        ini_set('max_execution_time', 0);   //永不超时
        $time = time();
        $exe_method = [];
        $crond_list = Config::get('crond');
        $sys_crond_timer = Config::get('sys_crond_timer');
        foreach($sys_crond_timer as $format){
            $key = date($format, ceil($time));
            if(is_array(@$crond_list[$key])){
                $exe_method = array_merge($exe_method, $crond_list[$key]);
            }
        }

        if(!empty($exe_method)){
            foreach ($exe_method as $method){
                if(!is_callable($method)){
                    //方法不存在的话就跳过不执行
                    continue;
                }
                echo date('Y-m-d H:i:s')."\n";
                echo "run crond --- {$method}()\n";
                $runtime_start = microtime(true);

                call_user_func($method);    //执行任务方法
                $runtime = microtime(true) - $runtime_start;
                echo "{$method}(), execute: {$runtime}\n\n";
            }
            $time_total = microtime(true) - $GLOBALS['_beginTime'];
            echo "total:{$time_total}\n";
        }
    }

}