<?php
/**
 * 后台入口文件
 */

//检查认证
check_auth($site_setting['user'],$site_setting['password']);



$page = empty($_GET['page']) ? 'index' : $_GET['page'];
//如果页面是修改edit_category
if ($page == 'edit_category') {
    //获取id
    $id = intval($_GET['id']);
    //查询单条分类信息
    $category = $db->get('on_categorys','*',[ 'id'  =>  $id ]);
    //checked按钮
    if( $category['property'] == 1 ) {
        $category['checked'] = 'checked';
    }
    else{
        $category['checked'] = '';
    }
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

//如果页面是添加链接页面
if ($page == 'add_link') {
    //查询所有分类信息
    $categorys = $db->select('on_categorys','*',[ 'ORDER'  =>  ['weigth'    =>  'DESC'] ]);
    //checked按钮
    if( $category['property'] == 1 ) {
        $category['checked'] = 'checked';
    }
    else{
        $category['checked'] = '';
    }
}

//如果是退出
//如果页面是添加链接页面
if ($page == 'logout') {
    //清除cookie
    setcookie("key", $key, -(time()+7 * 24 * 60 * 60),"/");
    //跳转到首页
    header('location:'.dirname($_SERVER['PHP_SELF']));
    exit;
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
    $key = md5($user.$password.$ip.'onenav');
    //获取cookie
    $cookie = $_COOKIE['key'];
    //如果cookie的值和计算的key不一致，则没有权限
    if( $cookie != $key ){
        exit("<h3>认证失败，请<a href = './index.php?c=login'>重新登录</a>！</h3>");
    }
}


// 载入前台首页模板
require('templates/admin/'.$page);