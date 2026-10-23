<?php
/**
 * name:一些通用的前端页面控制器
 */

require('functions/helper.php');

//获取版本号
$version = new_get_version();

//获取当前站点信息
$site = get_site_setting();


//载入视图
require('templates/universal/index.php');