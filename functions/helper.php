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

//curl get请求
function curl_get($url,$timeout = 10) {
    $curl = curl_init($url);
	#设置useragent
    curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.5005.63 Safari/537.36");
    curl_setopt($curl, CURLOPT_FAILONERROR, true);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    #设置超时时间，最小为1s（可选）
    curl_setopt($curl , CURLOPT_TIMEOUT, $timeout);

    $html = curl_exec($curl);
    curl_close($curl);
    return $html;
}

//获取版本号，新写的
function new_get_version(){
    if( file_exists('version.txt') ) {
        $version = @file_get_contents('version.txt');
        $version = explode("-",$version)[0];
        $version = str_replace("v","",$version);
        return $version;
    }
    else{
        $version = 'null';
        return $version;
    }
}

//随机数生成
function GetRandStr($len) 
{ 
    $chars = array( 
        "a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k",  
        "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v",  
        "w", "x", "y", "z", "A", "B", "C", "D", "E", "F", "G",  
        "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R",  
        "S", "T", "U", "V", "W", "X", "Y", "Z", "0", "1", "2",  
        "3", "4", "5", "6", "7", "8", "9" 
    ); 
    $charsLen = count($chars) - 1; 
    shuffle($chars);   
    $output = ""; 
    for ($i=0; $i<$len; $i++) 
    { 
        $output .= $chars[mt_rand(0, $charsLen)]; 
    }  
    return $output;  
}

//跳转到手机版页面
function jump_mobile() {
    $ua = $_SERVER['HTTP_USER_AGENT'];

    if( stristr($ua,'iphone') || stristr($ua,'android') ) {
        header("Location: /index.php?c=admin");
        exit;
    }
}