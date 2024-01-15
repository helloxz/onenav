<?php
/**
 * 首页模板入口
 */

//获取当前站点信息
$site = $db->get('on_options','value',[ 'key'  =>  "s_site" ]);
$site = unserialize($site);
// 获取链接数量,默认为30
$link_num = empty( $site['link_num'] ) ? 30 : intval($site['link_num']);



//如果已经登录，获取所有分类和链接
// 载入辅助函数
require('functions/helper.php');
if( is_login() ){
    //查询所有分类目录
    $categorys = [];
    //查询一级分类目录，分类fid为0的都是一级分类
    $category_parent = $db->select('on_categorys','*',[
        "fid"   =>  0,
        "ORDER" =>  ["weight" => "DESC"]
    ]);
    //遍历一级分类，然后获取下面的二级分类，获取到了就push
    foreach ($category_parent as $key => $value) {
        //把一级分类先加入到空数组
        array_push($categorys,$value);
        //然后查询他下面的子分类，再追加到数组
        $category_subs = $db->select('on_categorys','*',[
            "fid"   =>  $value['id'],
            "ORDER"     =>  ["weight" => "DESC"]
        ]);
        
        foreach ($category_subs as $category_sub) {
            array_push($categorys,$category_sub);
        }
    }
    //根据分类ID查询二级分类，分类fid大于0的都是二级分类
    function get_category_sub($id) {
        global $db;
        $id = intval($id);

        $category_sub = $db->select('on_categorys','*',[
            "fid"   =>  $id,
            "ORDER"     =>  ["weight" => "DESC"]
        ]);

        return $category_sub;
    }

    //根据category id查询链接
    function get_links($fid) {
        global $db;
        $fid = intval($fid);
        $links = $db->select('on_links','*',[ 
                'fid'   =>  $fid,
                'ORDER' =>  ["weight" => "DESC"]
            ]);
        return $links;
    }
    
    //根据category id查询有限链接
    function get_limit_links($fid) {
        global $db;
        global $link_num;
        $fid = intval($fid);
        $links = $db->select('on_links','*',[ 
                'fid'   =>  $fid,
                'ORDER' =>  ["weight" => "DESC"],
                'LIMIT' =>  $link_num
            ]);
        
        return $links;
    }
    
    //右键菜单标识
    $onenav['right_menu'] = 'admin_menu();';
}
//如果没有登录，只获取公有链接
else{
    // 检查分类是否全私有，如果是，则跳转到登录界面
    check_all_cat();
    //查询分类目录
    $categorys = [];
    //查询一级分类目录，分类fid为0的都是一级分类
    $category_parent = $db->select('on_categorys','*',[
        "fid"   =>  0,
        'property'  =>  0,
        "ORDER" =>  ["weight" => "DESC"]
    ]);
    //遍历一级分类，然后获取下面的二级分类，获取到了就push
    foreach ($category_parent as $key => $value) {
        //把一级分类先加入到空数组
        array_push($categorys,$value);
        //然后查询他下面的子分类，再追加到数组
        $category_subs = $db->select('on_categorys','*',[
            "fid"   =>  $value['id'],
            'property'  =>  0,
            "ORDER"     =>  ["weight" => "DESC"]
        ]);
        
        foreach ($category_subs as $category_sub) {
            array_push($categorys,$category_sub);
        }
    }
    //根据分类ID查询二级分类，分类fid大于0的都是二级分类
    function get_category_sub($id) {
        global $db;
        $id = intval($id);

        $category_sub = $db->select('on_categorys','*',[
            "fid"   =>  $id,
            'property'  =>  0,
            "ORDER"     =>  ["weight" => "DESC"]
        ]);

        return $category_sub;
    }
    //根据category id查询链接
    function get_links($fid) {
        global $db;
        global $link_num;
        $fid = intval($fid);
        $links = $db->select('on_links','*',[ 
            'fid' =>  $fid,
            'property'  =>  0,
            'ORDER' =>  ["weight" => "DESC"]
        ]);
        return $links;
    }
    //根据category id查询有限链接
    function get_limit_links($fid) {
        global $db;
        $fid = intval($fid);
        $links = $db->select('on_links','*',[ 
                'fid'   =>  $fid,
                'property'  =>  0,
                'ORDER' =>  ["weight" => "DESC"],
                'LIMIT' =>  $link_num
            ]);
        return $links;
    }
    //右键菜单标识
    $onenav['right_menu'] = 'user_menu();';
}

// 新增一个可变函数，来根据不同的情况使用不同的方法查询分类下的链接
$get_links = 'get_limit_links';
//获取分类ID
$cid = @$_GET['cid'];

// 如果存在分类ID，则只查询这个分类
if ( !empty($cid) ) {
    foreach ($categorys as $key => $tmp) {
        if( $tmp['id'] == $cid ) {
            $empty_cat[0] = $tmp;
            break;
        }
    }
    $get_links = 'get_links';
    unset($categorys);
    $categorys[0] = $empty_cat[0];
}

//获取版本号
function get_version(){
    if( file_exists('version.txt') ) {
        $version = @file_get_contents('version.txt');
        return $version;
    }
    else{
        $version = 'null';
        return $version;
    }
} 

//将URL转换为base64编码
function base64($url){
    $urls = parse_url($url);

    //获取请求协议
    $scheme = empty( $urls['scheme'] ) ? 'http://' : $urls['scheme'].'://';
    //获取主机名
    $host = $urls['host'];
    //获取端口
    $port = empty( $urls['port'] ) ? '' : ':'.$urls['port'];

    $new_url = $scheme.$host.$port;
    return base64_encode($new_url);
}

//获取版本号
$version = get_version();
//载入js扩展
if( file_exists('data/extend.js') ) {
    $onenav['extend'] = '<script src = "data/extend.js"></script>';
}
else{
    $onenav['extend'] = '';
}


// 载入前台首页模板
//查询主题设置
$template = $db->get("on_options","value",[
    "key"   =>  "theme"
]);
//获取用户传递的主题参数
$theme = trim( @$_GET['theme'] );
//如果用户传递了主题参数
if( !empty($theme) ) {
    //获取所有主题
    $themes = get_all_themes();

    //查找主题是否存在
    if( array_search($theme,$themes) !== FALSE ) {
        //改变默认主题
        $template = $theme;
    }
    else{
        //主题不存在，终止执行
        exit("<h1>主题参数错误！</h1>");
    }
}


//获取主题配置信息
if( file_exists("templates/".$template."/config.json") ) {
    $config_file = "templates/".$template."/config.json";
}
else if( file_exists("data/templates/".$template."/config.json") ) {
    $config_file = "data/templates/".$template."/config.json";
}
else if( file_exists("templates/".$template."/info.json") ) {
    $config_file = "templates/".$template."/info.json";
}
else {
    $config_file = "data/templates/".$template."/info.json";
}

//读取主题配置
$config_content = @file_get_contents($config_file);
//如果是info.json,则特殊处理下
if ( strstr($config_file,"info.json") ) {
    $config_content = json_decode($config_content);
    $theme_config = $config_content->config;
}
else{
    $config_content = $config_content;
    $theme_config = json_decode($config_content);
}




//判断文件夹是否存在
if( is_dir('templates/'.$template) ){
    $tpl_dir = 'templates/';
}
else{
    $tpl_dir = 'data/templates/';
}

//定义搜索引擎
$search_engines = [
    "baidu"     =>  [
        "name"  =>  "百度",
        "url"   =>  "https://www.baidu.com/s?ie=utf-8&word="
    ],
    "google"    =>  [
        "name"  =>  "Google",
        "url"   =>  "https://www.google.com/search?q="
    ],
    "bing"      =>  [
        "name"  =>  "必应",
        "url"   =>  "https://cn.bing.com/search?FORM=BESBTB&q="
    ],
    "sogou"     =>  [
        "name"  =>  "搜狗",
        "url"   =>  "https://www.sogou.com/web?query="
    ],
    "so360"       =>  [
        "name"  =>  "360搜索",
        "url"   =>  "https://www.so.com/s?ie=utf-8&fr=none&src=360sou_newhome&ssid=&q="
    ],
    "zhihu"     =>  [
        "name"  =>  "知乎",
        "url"   =>  "https://www.zhihu.com/search?type=content&q="
    ],
    "weibo"     =>  [
        "name"  =>  "微博",
        "url"   =>  "https://s.weibo.com/weibo?q="
    ] 
];

//获取主题的最低版本要求
$info_json = @file_get_contents($tpl_dir.$template."/info.json");

if( $info_json ) {
    $info = json_decode($info_json);
    
    $min_version = @$info->require->min;
    //获取到了最低版本
    if( !empty($min_version) ) {
        //如果主程序不满足主题要求
        if( new_get_version() <  $min_version ) {
            $onenav_version = new_get_version();
            exit($template."主题要求最低OneNav版本为：".$min_version."，您当前OneNav版本为：".$onenav_version."，请先<a title = 'OneNav升级说明' href = 'https://dwz.ovh/br5wt' target = '_blank'>升级OneNav版本！</a>");
        }
    }
}

// 该分类下可见的链接数量
function get_links_number($fid){
    $number = count(get_links($fid));
    return $number;
}

//载入主题
require($tpl_dir.$template.'/index.php');