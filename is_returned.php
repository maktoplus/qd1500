<?php


set_time_limit(0);//让程序一直执行下去
$interval = 10;//每隔一定时间运行
do{
    $msg=date("Y-m-d H:i:s");

	$url = "http://127.0.0.11/login/is_returned.html";

	$res = file_get_contents($url);

	echo $res;

    sleep($interval);//等待时间，进行下一次操作。
}while(true);



?>