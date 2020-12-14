<?php
/**
 * name:入口文件
 */

error_reporting(E_ALL^E_NOTICE^E_WARNING^E_DEPRECATED);
//获取控制器
$c = @$_GET['c'];
//进行过滤
$c = strip_tags($c);
//读取版本号
//$version = @file_get_contents("./functions/version.txt");
//载入配置文件
if( !file_exists('./config.php') ) {
	exit('<h3>配置文件不存在，请将config.simple.php复制一份并命名为config.php</h3>');
}

//载入配置文件
require("./config.php");

//根据不同的请求载入不同的方法
//如果没有请求控制器
if((!isset($c)) || ($c == '')){
	//载入主页
    include_once("./controller/index.php");
    
}

else{
	include_once("./controller/".$c.'.php');
}