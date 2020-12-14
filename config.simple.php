<?php
//载入数据库配置
require 'class/Medoo.php';
use Medoo\Medoo;
$db = new medoo([
    'database_type' => 'sqlite',
    'database_file' => 'db/onenav.db3'
]);

//用户名
define('USER','xiaoz');
//密码
define('PASSWORD','xiaoz.me');
//邮箱，用于后台Gravatar头像显示
define('EMAIL','337003006@qq.com');
//token参数，API需要使用
define('TOKEN','xiaoz.me');
//主题风格
define('TEMPLATE','default');

$site_setting = [];
//用户名
$site_setting['user']           =   USER;
$site_setting['password']       =   PASSWORD;

//站点标题
$site_setting['title']          =   'OneNav';
//站点关键词
$site_setting['keywords']       =   'OneNav,简洁导航,云链接,个人书签';
//站点描述
$site_setting['description']    =   '';

