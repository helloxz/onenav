<?php

/**
 * 首字母头像
 * @param $text
 * @return string
 * 原作者：http://t.zoukankan.com/ccw869476711-p-13596791.html
 */
function letter_avatar($text)
{
    $total = unpack('L', hash('adler32', $text, true))[1];
    $hue = $total % 360;
    list($r, $g, $b) = hsv2rgb($hue / 360, 0.3, 0.9);

    $bg = "rgb({$r},{$g},{$b})";
    $color = "#ffffff";
    $first = mb_strtoupper(mb_substr($text, 0, 1));
    $src = '<svg xmlns="http://www.w3.org/2000/svg" version="1.1" height="100" width="100"><rect fill="' . $bg . '" x="0" y="0" width="100" height="100"></rect><text x="50" y="50" font-size="50" text-copy="fast" fill="' . $color . '" text-anchor="middle" text-rights="admin" alignment-baseline="central">' . $first . '</text></svg>';
    //$value = 'data:image/svg+xml;base64,' . $src;
    $value = $src;
    return $value;
}


function hsv2rgb($h, $s, $v)
{
    $r = $g = $b = 0;

    $i = floor($h * 6);
    $f = $h * 6 - $i;
    $p = $v * (1 - $s);
    $q = $v * (1 - $f * $s);
    $t = $v * (1 - (1 - $f) * $s);

    switch ($i % 6) {
        case 0:
            $r = $v;
            $g = $t;
            $b = $p;
            break;
        case 1:
            $r = $q;
            $g = $v;
            $b = $p;
            break;
        case 2:
            $r = $p;
            $g = $v;
            $b = $t;
            break;
        case 3:
            $r = $p;
            $g = $q;
            $b = $v;
            break;
        case 4:
            $r = $t;
            $g = $p;
            $b = $v;
            break;
        case 5:
            $r = $v;
            $g = $p;
            $b = $q;
            break;
    }

    return [
        floor($r * 255),
        floor($g * 255),
        floor($b * 255)
    ];
}

/**
 * 输出svg图像
 */
function output_ico() {
    //获取文字
    $text = @trim($_GET['text']);
    $text = empty($text) ? '空' : $text;
    
    //获取当前主机名
    $host = $_SERVER['HTTP_HOST'];
    //获取reffrer
    $referer = $_SERVER['HTTP_REFERER'];

    //如果referer和主机名不匹配，则禁止调用
    if ( ( !empty($referer) ) && ( !strstr($referer,$host)  ) ) {
        exit('调用失败');
    }
    else{
        header('Cache-Control: max-age=604800');
        header('Content-Type:image/svg+xml');
        echo letter_avatar($text);
    }
    
}

//调用ico输出函数
output_ico();