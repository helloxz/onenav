<?php
/**
 * name:bing壁纸
 */
header('Content-Type:application/json; charset=utf-8');
// 载入辅助函数
require('functions/helper.php');
//获取当前主机名
$host = $_SERVER['HTTP_HOST'];
//获取reffrer
$referer = $_SERVER['HTTP_REFERER'];

//如果referer和主机名不匹配，则禁止调用
if ( ( !empty($referer) ) && ( !strstr($referer,$host)  ) ) {
    exit('调用失败');
}
session_start();

//如果session不为空，则使用session数据
if ( empty( $_SESSION['bing_data'] ) ) {
    $bing_data = curl_get("https://www.bing.com/HPImageArchive.aspx?format=js&idx=0&n=8",8);
    $_SESSION['bing_data'] = $bing_data;
    echo $bing_data;
}
else{
    echo $_SESSION['bing_data'];
}
