<?php
function randomkeys($len=32)
{
    $len =  $len-10;
    $pattern='abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $key="";
    for($i=0;$i<$len;$i++)
    {
        $key .= $pattern{mt_rand(0,51)};    //生成php随机数
    }
    $key=$key.time();
    return $key;
}

/** 获取当前时间戳，精确到毫秒 */

function microtime_float()
{
    list($usec, $sec) = explode(" ", microtime());
    return ((float)$usec + (float)$sec);
}



/** 格式化时间戳，精确到毫秒，x代表毫秒 */

function microtime_format($tag, $time)
{
    list($usec, $sec) = explode(".", $time);
    $date = date($tag,$usec);
    return str_replace('x', $sec, $date);
}

/*echo microtime_float().'<BR>';
echo time().'<BR>';
echo randomkeys().'<BR>';

echo microtime().'<BR>';
echo md5('abc').'<BR>';
echo md5('ABC').'<BR>';*/

echo date_format(date_create("2016-09-25"),"Y/m/d").'<BR>';
echo date("Y-m-d H:i:s",time()).'<BR>';


class StatusCode
{
    const STATUS_ERROR = 900; //开发者末定义错误
    const STATUS_ERROR_VESION = 901; //版本错误
    const STATUS_ERROR_API_EXISTS = 909; //接口不存在
}

echo StatusCode::STATUS_ERROR.'<BR>';

if([0]){
    echo "222222";
}else
    echo "3333333333";