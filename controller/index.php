<?php
/**
 * 首页模板入口
 */
//如果已经登录，获取所有分类和链接
if( is_login() ){
    //查询所有分类目录
    $categorys = $db->select('on_categorys','*',[
        "ORDER" =>  ["weight" => "DESC"]
    ]);
    //查询一级分类目录，分类fid为0的都是一级分类
    $category_parent = $db->select('on_categorys','*',[
        "fid"   =>  0,
        "ORDER" =>  ["weight" => "DESC"]
    ]);
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
    //右键菜单标识
    $onenav['right_menu'] = 'admin_menu();';
}
//如果没有登录，只获取公有链接
else{
    //查询分类目录
    $categorys = $db->select('on_categorys','*',[
        "property"  =>  0,
        "ORDER" =>  ["weight" => "DESC"]
    ]);
    //查询一级分类目录，分类fid为0的都是一级分类
    $category_parent = $db->select('on_categorys','*',[
        "fid"   =>  0,
        'property'  =>  0,
        "ORDER" =>  ["weight" => "DESC"]
    ]);
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
        $fid = intval($fid);
        $links = $db->select('on_links','*',[ 
            'fid' =>  $fid,
            'property'  =>  0,
            'ORDER' =>  ["weight" => "DESC"]
        ]);
        return $links;
    }
    //右键菜单标识
    $onenav['right_menu'] = 'user_menu();';
}


//获取访客IP
function getIP() { 
    if (getenv('HTTP_CLIENT_IP')) { 
    $ip = getenv('HTTP_CLIENT_IP'); 
  } 
  elseif (getenv('HTTP_X_FORWARDED_FOR')) { 
      $ip = getenv('HTTP_X_FORWARDED_FOR'); 
  } 
      elseif (getenv('HTTP_X_FORWARDED')) { 
      $ip = getenv('HTTP_X_FORWARDED'); 
  } 
    elseif (getenv('HTTP_FORWARDED_FOR')) { 
    $ip = getenv('HTTP_FORWARDED_FOR'); 
  } 
    elseif (getenv('HTTP_FORWARDED')) { 
    $ip = getenv('HTTP_FORWARDED'); 
  } 
  else { 
      $ip = $_SERVER['REMOTE_ADDR']; 
  } 
      return $ip; 
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
//判断用户是否已经登录
function is_login(){
    $key = md5(USER.PASSWORD.'onenav');
    //获取session
    $session = $_COOKIE['key'];
    //如果已经成功登录
    if($session == $key) {
        return true;
    }
    else{
        return false;
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
//获取当前站点信息
$site = $db->get('on_options','value',[ 'key'  =>  "s_site" ]);
$site = unserialize($site);

//获取主题配置信息
//获取主题配置
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


require($tpl_dir.$template.'/index.php');
?>