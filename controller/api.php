<?php
/**
 * name:API入口文件
 * update:2020/12
 * author:xiaoz<xiaoz93@outlook.com>
 * blog:xiaoz.me
 */

//允许跨域访问
header("Access-Control-Allow-Origin: *");
require('./class/Api.php');

$api = new Api($db);

//获取请求方法
$method = $_GET['method'];
//对方法进行判断，对应URL路由：/index.php?c=api&method=xxx
switch ($method) {
    case 'add_category':
        add_category($api);
        break;
    case 'edit_category':
        edit_category($api);
        break;
    case 'del_category':
        del_category($api);
        break;
    case 'add_link':
        add_link($api);
        break;
    case 'edit_link':
        edit_link($api);
        break;
    case 'del_link':
        del_link($api);
        break;
    case 'category_list':
        category_list($api);
        break;
    case 'link_list':
        link_list($api);
        break;
    case 'get_link_info':
        get_link_info($api);
        break;
    case 'add_js':
        add_js($api);
        break;
    case 'upload':
        upload($api);
        break;
    case 'imp_link':
        imp_link($api);
    case 'check_weak_password':
        check_weak_password($api);
        break;
    case 'get_a_link':
        get_a_link($api);
        break;
    default:
        # code...
        break;
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
    $api->add_category($token,$name,$property,$weight,$description);
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
    $api->edit_category($token,$id,$name,$property,$weight,$description);
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
    $description = empty($_POST['description']) ? '' : $_POST['description'];
    $weight = empty($_POST['weight']) ? 0 : intval($_POST['weight']);
    $property = empty($_POST['property']) ? 0 : 1;
    
    $api->add_link($token,$fid,$title,$url,$description,$weight,$property);
    
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
    $description = empty($_POST['description']) ? '' : $_POST['description'];
    $weight = empty($_POST['weight']) ? 0 : intval($_POST['weight']);
    $property = empty($_POST['property']) ? 0 : 1;
    
    $api->edit_link($token,$id,$fid,$title,$url,$description,$weight,$property);
    
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