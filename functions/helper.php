<?php
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


function is_login(){
    $key = md5(USER.PASSWORD.'onenav'.$_SERVER['HTTP_USER_AGENT']);
    //获取session
    $session = $_COOKIE['key'];
    //如果已经成功登录
    if($session === $key) {
        return true;
    }
    else{
        return false;
    }
}

//后续全局函数全部以g_命名开头
function g_extend_js() {
    //载入js扩展
    if( file_exists('data/extend.js') ) {
        echo '<script src = "data/extend.js"></script>';
    }
    else{
        echo '';
    }
}