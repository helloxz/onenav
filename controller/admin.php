<?php
/**
 * 后台入口文件
 */

//检查认证
check_auth($site_setting['user'],$site_setting['password']);

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
//获取版本号
$version = get_version();

$page = empty($_GET['page']) ? 'index' : $_GET['page'];
//如果页面是修改edit_category
if ( $page == 'edit_category' ) {
    //获取id
    $id = intval($_GET['id']);
    //查询单条分类信息
    $sql = "SELECT *,(SELECT name FROM on_categorys WHERE id = a.fid LIMIT 1) AS fname FROM on_categorys AS a WHERE id = $id";
    $category_one = $db->query($sql)->fetchAll()[0];
    //$category_one = $db->get('on_categorys','*',[ 'id'  =>  $id ]);
    //查询父级分类
    $categorys = $db->select('on_categorys','*',[
        'fid'   => 0,
        'ORDER' =>  ['weight'    =>  'DESC'] 
    ]);
    //checked按钮
    if( $category_one['property'] == 1 ) {
        $category_one['checked'] = 'checked';
    }
    else{
        $category_one['checked'] = '';
    }
}

//如果是主题设置页面
if ( $page == "setting/theme_config" ){
    //获取主题名称
    $name = trim($_GET['name']);
    //获取主题目录
    if ( is_dir("templates/".$name) ) {
        $theme_dir = "templates/".$name;
    }
    else{
        $theme_dir = "data/templates/".$name;
    }
    //读取主题配置
    $config_content = @file_get_contents("templates/".$name."/info.json");
    if( !$config_content ) {
        $config_content = @file_get_contents("data/templates/".$name."/info.json");
    }
    $configs = json_decode($config_content);
    $configs = $configs->config;
    //获取当前的配置参数
    $current_configs = file_get_contents($theme_dir."/config.json");
    
    $current_configs = json_decode($current_configs);
    //var_dump($current_configs);
}

//添加分类页面
if ( $page == 'add_category' ) {
    //查询父级分类
    $categorys = $db->select('on_categorys','*',[
        'fid'   => 0,
        'ORDER' =>  ['weight'    =>  'DESC'] 
    ]);
}

//API设置页面
if( $page == 'setting/api' ) {
    //查询SecretKey
    $SecretKey = $db->get('on_options','*',[ 'key'  =>  'SecretKey' ])['value'];
    
}

//如果页面是修改link
if ($page == 'edit_link') {
    //查询所有分类信息，用于分类框选择
    $categorys = $db->select('on_categorys','*',[ 'ORDER'  =>  ['weigth'    =>  'DESC'] ]);
    //获取id
    $id = intval($_GET['id']);
    //查询单条链接信息
    $link = $db->get('on_links','*',[ 'id'  =>  $id ]);
    //查询单个分类信息
    $cat_name = $db->get('on_categorys',['name'],[ 'id' =>  $link['fid'] ]);
    $cat_name = $cat_name['name'];
    
    //checked按钮
    if( $link['property'] == 1 ) {
        $link['checked'] = 'checked';
    }
    else{
        $link['checked'] = '';
    }
}

//链接列表页面
if ( $page == "link_list" ) {
    //查询所有分类信息，用于分类框选择
    $categorys = $db->select('on_categorys','*',[ 'ORDER'  =>  ['weigth'    =>  'DESC'] ]);
}

//如果页面是添加链接页面
if ( ($page == 'add_link') || ($page == 'add_link_tpl') || ($page == 'add_quick_tpl') ) {
    //查询所有分类信息
    $categorys = $db->select('on_categorys','*',[ 'ORDER'  =>  ['weight'    =>  'DESC'] ]);
    //checked按钮
    if( $category['property'] == 1 ) {
        $category['checked'] = 'checked';
    }
    else{
        $category['checked'] = '';
    }
}

//导入书签页面
if ( $page == 'imp_link' ) {
    //查询所有分类信息
    $categorys = $db->select('on_categorys','*',[ 'ORDER'  =>  ['weight'    =>  'DESC'] ]);
    //checked按钮
    if( $category['property'] == 1 ) {
        $category['checked'] = 'checked';
    }
    else{
        $category['checked'] = '';
    }
}
//主题详情页面
if ( $page == 'setting/theme_detail' ) {
    //获取主题名称
    $name = @$_GET['name'];
    //主题目录
    $tpl_dir1 = dirname(__DIR__).'/templates/'.$name;
    //备用主题目录
    $tpl_dir2 = dirname(__DIR__).'/data/templates/'.$name;
    if( is_dir($tpl_dir1) ) {
        $info = file_get_contents($tpl_dir1.'/info.json');
    }
    else{
        $info = file_get_contents($tpl_dir2.'/info.json');
    }
    $theme = json_decode($info);
    //var_dump($theme);
}

//主题设置页面
if( $page == 'setting/theme' ) {
    //主题目录
    $tpl_dir1 = dirname(__DIR__).'/templates/';
    //备用主题目录
    $tpl_dir2 = dirname(__DIR__).'/data/templates/';
    
    //声明两个空数组用来存放模板目录列表
    $tpl_one = [];
    $tpl_two = [];
    //遍历第一个目录
    foreach ( scandir($tpl_dir1) as $value) {
        //完整的路径
        $path = $tpl_dir1.$value;
        //如果是目录，则push到目录列表1
        if( is_dir($path) ) {
            switch ($value) {
                case '.':
                case '..':
                case 'admin':
                    continue;
                    break;
                default:
                    array_push($tpl_one,$value);
                    break;
            }
            
        }
        else{
            continue;
        }
    }
    //如果第二个目录存在，则遍历
    if( is_dir($tpl_dir2) ) {
        foreach ( scandir($tpl_dir2) as $value) {
            //完整的路径
            $path = $tpl_dir2.$value;
            //如果是目录，则push到目录列表1
            if( is_dir($path) ) {
                switch ($value) {
                    case '.':
                    case '..':
                    case 'admin':
                        continue;
                        break;
                    default:
                        array_push($tpl_two,$value);
                        break;
                }
            }
            else{
                continue;
            }
        }
    }
    
    //合并目录
    //现在$tpl_one是合并后的完整主题列表
    $tpls = array_merge($tpl_one,$tpl_two);
    
    //读取主题里面的信息
    //设置一个空数组
    $data = [];
    
    foreach ($tpls as $value) {
        //如果文件存在
        if( is_file($tpl_dir1.$value.'/info.json') ) {
            $data[$value]['info'] = json_decode(@file_get_contents( $tpl_dir1.$value.'/info.json' ));
        }
        else{
            $data[$value]['info'] = json_decode(@file_get_contents( $tpl_dir2.$value.'/info.json' ));
        }
    }
    $themes = $data;
    //获取当前主题
    $current_them = $db->get('on_options','value',[ 'key'  =>  "theme" ]);
}

//站点设置页面
if( $page == 'setting/site' ) {
    //获取当前站点信息
    $site = $db->get('on_options','value',[ 'key'  =>  "s_site" ]);
    $site = unserialize($site);
}

//过渡页设置页面
if( $page == 'setting/transition_page' ) {
    //获取当前站点信息
    $transition_page = $db->get('on_options','value',[ 'key'  =>  "s_transition_page" ]);
    $transition_page = unserialize($transition_page);
}

//如果是退出
//如果页面是添加链接页面
if ($page == 'logout') {
    //清除cookie
    setcookie("key", $key, -(time()+7 * 24 * 60 * 60),"/");
    //跳转到首页
    header('location:/');
    exit;
}

//如果是自定义js页面
if ($page == 'ext_js') {
    //判断文件是否存在
    if (is_file('data/extend.js')) {
        $content = file_get_contents('data/extend.js');
    }
    else{
        $content = '';
    }
}

$page = $page.'.php';

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

/**
 * 检查授权
 */

function check_auth($user,$password){
    $ip = getIP();
    $key = md5($user.$password.'onenav');
    //获取cookie
    $cookie = $_COOKIE['key'];
    //如果cookie的值和计算的key不一致，则没有权限
    if( $cookie !== $key ){
        $msg = "<h3>认证失败，请<a href = 'index.php?c=login'>重新登录</a>！</h3>";
        require('templates/admin/403.php');
        exit;
    }
}


// 载入前台首页模板
require('templates/admin/'.$page);