<?php
// 载入辅助函数
require('functions/helper.php');

//获取link.id
$id = intval($_GET['id']);

//如果链接为空
if(empty($id)) {
    $msg = '<p>无效ID！</p>';
    require('templates/admin/403.php');
    exit();
}

//查询链接信息
$link = $db->get('on_links',['id','fid','url','property','click'],[
    'id'    =>  $id
]);

//如果查询失败
if( !$link ){
    $msg = '<p>无效ID！</p>';
    require('templates/admin/403.php');
    exit();
}

//查询该ID的父及ID信息
$category = $db->get('on_categorys',['id','property'],[
    'id'    =>  $link['fid']
]);

//link.id为公有，且category.id为公有
if( ( $link['property'] == 0 ) && ($category['property'] == 0) ){
    //增加link.id的点击次数
    $click = $link['click'] + 1;
    //更新数据库
    $update = $db->update('on_links',[
        'click'     =>  $click
    ],[
        'id'    =>  $id
    ]);
    //如果更新成功
    if($update) {
        //进行header跳转
        header('location:'.$link['url']);
        exit;
    }
}
//如果已经成功登录，直接跳转
elseif( is_login() ) {
    //增加link.id的点击次数
    $click = $link['click'] + 1;
    //更新数据库
    $update = $db->update('on_links',[
        'click'     =>  $click
    ],[
        'id'    =>  $id
    ]);
    //如果更新成功
    if($update) {
        //进行header跳转
        header('location:'.$link['url']);
        exit;
    }
}
//其它情况则没有权限
else{
    $msg = '<p>很抱歉，该页面是私有的，您无权限访问此页面。</p>
    <p>如果您是管理员，请尝试登录OneNav后台并重新访问。</p>';
    require('templates/admin/403.php');
    exit();
}