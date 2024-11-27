<?php
/**
 * name:一些通用的前端页面控制器
 */

require('functions/helper.php');

//获取版本号
$version = new_get_version();

//获取当前站点信息
$site = $db->get('on_options','value',[ 'key'  =>  "s_site" ]);
$site = unserialize($site);


//载入视图
require('templates/universal/index.php');