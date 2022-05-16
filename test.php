<?php
$content = file_get_contents("data.json");
$data = json_decode($content);
// var_dump($data);
// exit;
//定义一个空的二维数组
$link_data = array();


//遍历节点
function get_link($data) {
    global $link_data;

    foreach ($data as $key => $value) {
        //获取子节点长度
        $children_length = count($value->children);
        if( $children_length === 0 ) {
            $arr[$value->name] = $value->web;
            array_push($link_data,$arr);
            unset($arr);
        }
        else{
            if( count($value->web) !== 0 ) {
                $new_arr[$value->name] = $value->web;
                array_push($link_data,$new_arr);
                unset($new_arr);
            }
            
            get_link($value->children);
        }
    
    }

}
get_link($data);
var_dump($link_data);