<?php
//MD5自增
function autoIncrementMD5($len=32)
{
    $key="";
    $len =  $len-10;
    $pattern='abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    for($i=0;$i<$len;$i++)
    {
        $key .= $pattern{mt_rand(0,51)};    //生成php随机数
    }
    $key=$key.time();
    return md5($key);
}
//获取当前时间 对应数据库 DATETIME 类型
function currentDateTime($format="Y-m-d H:i:s"){
   return date($format,time());
}
