<?php
/**
 * 登录入口
 */

// 载入辅助函数
require('functions/helper.php');

$username = $site_setting['user'];
$password = $site_setting['password'];
$ip = getIP();
//如果认证通过，直接跳转到后台管理
$key = md5($username.$password.'onenav'.$_SERVER['HTTP_USER_AGENT']);
//获取cookie
$cookie = $_COOKIE['key'];

//如果已经登录，直接跳转
if( is_login() ){
    header('location:index.php?c=admin');
    exit;
}

//登录检查
if( $_GET['check'] == 'login' ) {
    $user = $_POST['user'];
    $pass = $_POST['password'];
    header('Content-Type:application/json; charset=utf-8');
    if( ($user === $username) && ($pass === $password) ) {
        $key = md5($username.$password.'onenav'.$_SERVER['HTTP_USER_AGENT']);
        //开启httponly支持
        setcookie("key", $key, time()+30 * 24 * 60 * 60,"/",NULL,false,TRUE);
        $data = [
            'code'      =>  0,
            'msg'   =>  'successful'
        ];
    }
    else{
        $data = [
            'code'      =>  -1012,
            'err_msg'   =>  '用户名或密码错误！'
        ];
        
        
    }
    exit(json_encode($data));
}
//如果cookie的值和计算的key不一致，则没有权限


// if ( ($_SERVER['PHP_AUTH_PW'] !== $password) || ($_SERVER['PHP_AUTH_USER'] !== $username) ){
//     header('WWW-Authenticate: Basic realm="Please verify."');
//     header('HTTP/1.0 401 Unauthorized');
//     exit("<h2>认证失败！</h2>");
// }
// else{
    
//     $key = md5($username.$password.$ip.'onenav');
//     //设置cookie
//     setcookie("key", $key, time()+7 * 24 * 60 * 60,"/");
//     header('location:index.php?c=admin');
// }


// 载入后台登录模板
require('templates/admin/login.php');