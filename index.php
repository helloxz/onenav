<?php
/**
 * name:入口文件
 */
error_reporting(E_ALL^E_NOTICE^E_WARNING^E_DEPRECATED);
header("content-Type: text/html; charset=Utf-8");
//获取控制器
$c = @$_GET['c'];
//进行过滤
$c = strip_tags($c);
//读取版本号
//$version = @file_get_contents("./functions/version.txt");
//载入配置文件
//如果配置文件不存在，则载入初始化文件
if( !file_exists('./data/config.php') ) {
	include_once("controller/init.php");
	//exit('<h3>配置文件不存在，请将站点目录下的config.simple.php复制为data/config.php</h3>');
}
//检查数据库是否存在，不存在则复制数据库
if( !file_exists('./data/onenav.db3') ) {
	if ( !copy('db/onenav.simple.db3','data/onenav.db3') ) {
		exit("数据库复制失败，请检查目录权限！");
	}
	// copy('db/.htaccess','data/.htaccess');
}

//载入配置文件
require("./data/config.php");

//根据不同的请求载入不同的方法
//如果没有请求控制器
if((!isset($c)) || ($c == '')){
	//载入主页
    include_once("./controller/index.php");
    
}

else{
	//对请求参数进行过滤，同时检查文件是否存在
	$c = str_replace('\\','/',$c);
	$pattern = "%\./%";
	if ( preg_match_all($pattern,$c) ) {
		exit('非法请求!');
	}
	//控制器文件
	$controller_file = "./controller/".$c.'.php';
	if( file_exists($controller_file) ) {
		include_once($controller_file);
	} else{
		exit('Controller not exist!');
	}
	
}