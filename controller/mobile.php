<?php
/**
 * 手机后台入口文件
 */
// 载入辅助函数
require('functions/helper.php');

//检查认证
check_auth($site_setting['user'],$site_setting['password']);

//获取版本号
$version = new_get_version();

/**
 * 检查授权
 */

function check_auth($user,$password){
    if ( !is_login() ) {
        $msg = "<h3>认证失败，请<a href = 'index.php?c=login'>重新登录</a>！</h3>";
        require('templates/admin/403.php');
        exit;
    }
}

// 载入前台首页模板
require('templates/mobile/index.php');