<?php
//载入数据库配置
require 'class/Medoo.php';
use Medoo\Medoo;
$db = new medoo([
    'database_type' => 'sqlite',
    'database_file' => 'data/onenav.db3'
]);

//用户名
define('USER','{username}');
//密码
define('PASSWORD','{password}');
//邮箱，用于后台Gravatar头像显示
define('EMAIL','{email}');
//token参数，API需要使用，0.9.19版本这个废弃了，请通过后台设置
define('TOKEN','xiaoz.me');
//主题风格,0.9.18废弃了，请通过后台设置
define('TEMPLATE','default');

//站点信息
$site_setting = [];
//站点标题
$site_setting['title']          =   'OneNav';
//文字Logo
$site_setting['logo']          =   'OneNav';
//站点关键词
$site_setting['keywords']       =   'OneNav,OneNav导航,OneNav书签,开源导航,开源书签,简洁导航,云链接,个人导航,个人书签';
//站点描述
$site_setting['description']    =   'OneNav是一款使用PHP + SQLite3开发的简约导航/书签管理器，免费开源。';

//这两项不要修改
$site_setting['user']           =   USER;
$site_setting['password']       =   PASSWORD;