<?php
/**
 * name:API入口文件，也可以称之为中间件
 * update:2022/03
 * author:xiaoz<xiaoz93@outlook.com>
 * blog:xiaoz.me
 */

//允许跨域访问
header("Access-Control-Allow-Origin: *");
require('./class/Api.php');

$api = new Api($db);

//获取请求方法
$method = $_GET['method'];
//可变函数变量
$var_func = htmlspecialchars(trim($method),ENT_QUOTES);
//判断函数是否存在，存在则条用可变函数，否则抛出错误
if ( function_exists($var_func) ) {
    //调用可变函数
    $var_func($api);
}else{
    exit('method not found!');
}



/**
 * 添加分类目录入口
 */
function add_category($api){
    //获取token
    $token = $_POST['token'];
    //获取分类名称
    $name = $_POST['name'];
    //获取私有属性
    $property = empty($_POST['property']) ? 0 : 1;
    //获取权重
    $weight = empty($_POST['weight']) ? 0 : intval($_POST['weight']);
    //获取描述
    $description = empty($_POST['description']) ? '' : $_POST['description'];
    //描述过滤
    $description = htmlspecialchars($description);
    //获取字体图标
    $font_icon = htmlspecialchars($_POST['font_icon'],ENT_QUOTES);
    $api->add_category($token,$name,$property,$weight,$description,$font_icon);
}
/**
 * 修改分类目录入口
 */
function edit_category($api){
    //获取ID
    $id = intval($_POST['id']);
    
    //获取token
    $token = $_POST['token'];
    //获取分类名称
    $name = $_POST['name'];
    //获取私有属性
    $property = empty($_POST['property']) ? 0 : 1;
    //获取权重
    $weight = empty($_POST['weight']) ? 0 : intval($_POST['weight']);
    //获取描述
    $description = empty($_POST['description']) ? '' : $_POST['description'];
    //描述过滤
    $description = htmlspecialchars($description);
    //字体图标
    $font_icon = htmlspecialchars($_POST['font_icon'],ENT_QUOTES);
    $api->edit_category($token,$id,$name,$property,$weight,$description,$font_icon);
}
/**
 * 删除分类目录
 */
function del_category($api){
    //获取ID
    $id = intval($_POST['id']);
    //获取token
    $token = $_POST['token'];
    $api->del_category($token,$id);
}
/**
 * 插入链接
 */
function add_link($api){
    //add_link($token,$fid,$title,$url,$description = '',$weight = 0,$property = 0)
    //获取token
    $token = $_POST['token'];
    
    //获取fid
    $fid = intval(@$_POST['fid']);
    $title = $_POST['title'];
    $url = $_POST['url'];
    $url_standby = $_POST['url_standby'];
    $description = empty($_POST['description']) ? '' : $_POST['description'];
    $weight = empty($_POST['weight']) ? 0 : intval($_POST['weight']);
    $property = empty($_POST['property']) ? 0 : 1;
    
    $api->add_link($token,$fid,$title,$url,$description,$weight,$property,$url_standby);
    
}
/**
 * 修改链接
 */
function edit_link($api){
    //add_link($token,$fid,$title,$url,$description = '',$weight = 0,$property = 0)
    //获取token
    $token = $_POST['token'];
    $id = intval(@$_POST['id']);
    
    //获取fid
    $fid = intval(@$_POST['fid']);
    $title = $_POST['title'];
    $url = $_POST['url'];
    $url_standby = $_POST['url_standby'];
    $description = empty($_POST['description']) ? '' : $_POST['description'];
    $weight = empty($_POST['weight']) ? 0 : intval($_POST['weight']);
    $property = empty($_POST['property']) ? 0 : 1;
    
    $api->edit_link($token,$id,$fid,$title,$url,$description,$weight,$property,$url_standby);
    
}

/**
 * 删除链接
 */
function del_link($api){
    $token = $_POST['token'];
    $id = intval(@$_POST['id']);
    $api->del_link($token,$id);
}
/**
 * 查询分类目录列表
 */
function category_list($api){
    $page = empty(intval($_GET['page'])) ? 1 : intval($_GET['page']);
    $limit = empty(intval($_GET['limit'])) ? 10 : intval($_GET['limit']);
    $api->category_list($page,$limit);
}

/**
 * 查询链接列表
 */
function link_list($api){
    $page = empty(intval($_GET['page'])) ? 1 : intval($_GET['page']);
    $limit = empty(intval($_GET['limit'])) ? 10 : intval($_GET['limit']);
    //获取token
    $token = $_POST['token'];
    //获取分类ID
    $category_id = empty($_POST['category_id']) ? null : intval($_POST['category_id']);
    $data = [
        'page'          =>  $page,
        'limit'         =>  $limit,
        'token'         =>  $token,
        'category_id'   =>  $category_id
    ];
    $api->link_list($data);
}

/**
 * 获取链接标题、描述等信息
 */
function get_link_info($api) {
    //获取token
    $token = $_POST['token'];
    //获取URL
    $url = @$_POST['url'];
    $api->get_link_info($token,$url);
}

/**
 * 获取一个链接的信息，指存储在数据库的信息
 */
function get_a_link($api) {
    //获取token
    $data['token'] = htmlspecialchars($_POST['token']);
    //获取链接的ID
    $data['id'] = intval(htmlspecialchars($_GET['id']));
    $api->get_a_link($data);
}

/**
 * 添加自定义js
 */
function add_js($api) {
    //获取token
    $token = $_POST['token'];
    $content = @$_POST['content'];
    $api->add_js($token,$content);
}
// 上传书签
function upload($api){
    //获取token
    $token = $_POST['token'];
    //获取上传类型
    $type = $_GET['type'];
    $api->upload($token,$type);
}
//书签导入
function imp_link($api) {
    //获取token
    $token = $_POST['token'];
    //获取书签路径
    $filename = trim($_POST['filename']);
    $fid = intval($_POST['fid']);
    $property = intval(@$_POST['property']);
    $api->imp_link($token,$filename,$fid,$property);
}
//检查弱密码
function check_weak_password($api) {
    //获取token
    $token = $_POST['token'];
    $api->check_weak_password($token);
}

//获取sql更新列表
function get_sql_update_list($api){
    $data = [];
    $api->get_sql_update_list($data);
}

//执行SQL更新
function exe_sql($api) {
    $data['name'] = htmlspecialchars(trim($_GET['name']));
    $api->exe_sql($data);
}