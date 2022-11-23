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
$link = $db->get('on_links',['id','fid','url','url_standby','property','click','title','description','font_icon'],[
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

//判断用户是否登录
if( is_login() ) {
    $is_login = TRUE;
}

//查询过渡页设置
$transition_page = $db->get('on_options','value',[ 'key'  =>  "s_transition_page" ]);
$transition_page = unserialize($transition_page);

//获取当前站点信息
$site = $db->get('on_options','value',[ 'key'  =>  "s_site" ]);
$site = unserialize($site);

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
        //判断是否开启过渡页面
        if ( ($transition_page['control'] == 'off') && ( empty($link['url_standby']) ) ){
            //进行header跳转
            header('location:'.$link['url']);
        }
        //如果备用链接不为空，或者开启了过渡页面
        else if( !empty($link['url_standby']) || ($transition_page['control'] == 'on') ) {
            #加载跳转模板
            require('templates/admin/click.php');
        }
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
        //判断是否开启过渡页面
        if ( ($transition_page['control'] == 'off') && ( empty($link['url_standby']) ) ){
            //进行header跳转
            header('location:'.$link['url']);
        }
        else if( !empty($link['url_standby']) || ($transition_page['control'] == 'on') ) {
            #加载跳转模板
            require('templates/admin/click.php');
        }
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