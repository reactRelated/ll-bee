<?php
$arg = 1;
$as = 1;
$test = function ($a) use ($arg){
    var_dump($a);
    var_dump($arg);
    $arg ++;
    $a++;
    var_dump($a);
    var_dump($arg);
};
$test($as);  //输出text

$arg ++;
$as ++;
$test($as); //输出text

echo $arg;
echo $as;
