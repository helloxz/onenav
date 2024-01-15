<?php
/**
 * 后台入口文件
 */
// 载入辅助函数
require('functions/helper.php');

//检查认证
check_auth($site_setting['user'],$site_setting['password']);

//获取版本号
// function get_version(){
//     if( file_exists('version.txt') ) {
//         $version = @file_get_contents('version.txt');
//         return $version;
//     }
//     else{
//         $version = 'null';
//         return $version;
//     }
// }
//获取版本号
$version = new_get_version();

$page = empty($_GET['page']) ? 'index' : $_GET['page'];
// 正则判断page，只能允许字符+数字和下划线组合
$pattern = "/^[a-zA-Z0-9_\/]+$/";
if ( !preg_match($pattern,$page) ) {
    exit('非法请求!');
}


//如果是后台首页，则判断是否是手机访问，并决定是否跳转到手机版页面
if( $page == 'index' ) {
    jump_mobile();
}

//如果页面是修改edit_category
if ( ($page == 'edit_category') || ($page == 'edit_category_new') ) {
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

//备份页面
if( $page == 'setting/backup' ) {
    
    
}

//如果页面是修改link
if ( ( $page == 'edit_link' ) || ( $page === 'edit_link_new' ) ) {
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
if ( ($page == 'add_link') || ($page == 'add_link_tpl') || ($page == 'add_quick_tpl') || ($page == 'setting/share') ) {
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
                case 'mobile':
                case 'universal':
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

    //获取在线主题列表
    $theme_list = curl_get("https://onenav.xiaoz.top/v1/theme_list.php");
    $theme_list = json_decode($theme_list)->data;
    //var_dump($theme_list);
    //去重一下
    foreach ($themes as $key => $value) {
        unset($theme_list->$key);
    }
    
}

//站点设置页面
if( $page == 'setting/site' ) {
    //获取当前站点信息
    $site = $db->get('on_options','value',[ 'key'  =>  "s_site" ]);
    $site = unserialize($site);
}

//站点订阅页面
if( $page == 'setting/subscribe' ) {
    //获取当前站点信息
    $subscribe = $db->get('on_options','value',[ 'key'  =>  "s_subscribe" ]);
    
    $subscribe = unserialize($subscribe);

    //获取当前版本信息
    $current_version = explode("-",file_get_contents("version.txt"));
    $current_version = str_replace("v","",$current_version[0]);

    
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

// 判断$page文件是否存在，不存在，则终止执行
$full_page_path = 'templates/admin/'.$page;
if( !file_exists($full_page_path) ) {
    exit("file does not exist!");
}

// 载入前台首页模板
require('templates/admin/'.$page);