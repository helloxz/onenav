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
    //获取分级ID
    $fid = intval($_POST['fid']);
    //获取权重
    $weight = empty($_POST['weight']) ? 0 : intval($_POST['weight']);
    //获取描述
    $description = empty($_POST['description']) ? '' : $_POST['description'];
    //描述过滤
    $description = htmlspecialchars($description);
    //获取字体图标
    $font_icon = htmlspecialchars($_POST['font_icon'],ENT_QUOTES);
    $api->add_category($token,$name,$property,$weight,$description,$font_icon,$fid);
}
/**
 * 修改分类目录入口
 */
function edit_category($api){
    //获取ID
    $id = intval($_POST['id']);
    //获取父级ID
    $fid = intval($_POST['fid']);
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
    $api->edit_category($token,$id,$name,$property,$weight,$description,$font_icon,$fid);
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
    $page = empty(intval($_REQUEST['page'])) ? 1 : intval($_REQUEST['page']);
    $limit = empty(intval($_REQUEST['limit'])) ? 10 : intval($_REQUEST['limit']);
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
 * 根据ID获取单个分类信息
 */
function get_a_category($api) {
    //获取token
    $data['token'] = @$_POST['token'];
    //获取分类ID
    $data['id'] = intval(trim($_POST['id']));
    //var_dump($data);
    $api->get_a_category($data);
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
//新版书签批量导入并自动创建分类
function import_link($api) {
    //获取token
    $token = $_POST['token'];
    //获取书签路径
    $filename = trim($_POST['filename']);
    $fid = intval($_POST['fid']);
    $property = intval(@$_POST['property']);
    $api->import_link($filename,$property);
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

//设置options表
function set_theme($api) {
    $key = 'theme';
    $value = htmlspecialchars($_POST['value']);
    $api->set_option($key,$value);
}

//设置站点信息
function set_site($api) {
    //获取传递过来的参数
    //获取网站标题
    $data['title'] = htmlspecialchars($_POST['title']);
    //获取网站logo
    $data['logo'] = htmlspecialchars($_POST['logo']);
    //获取副标题
    $data['subtitle'] = htmlspecialchars($_POST['subtitle']);
    //获取关键词
    $data['keywords'] = htmlspecialchars($_POST['keywords']);
    //获取描述
    $data['description'] = htmlspecialchars($_POST['description']);
    //获取自定义header
    $data['custom_header'] = $_POST['custom_header'];
    //获取自定义footer
    $data['custom_footer'] = $_POST['custom_footer'];
    //序列化存储
    $value = serialize($data);
    

    $api->set_option('s_site',$value);
}

//设置过渡页面
function set_transition_page($api) {
    //获取传递过来的参数
    //获取开关
    $data['control'] = htmlspecialchars(trim($_POST['control']));
    //获取游客停留时间
    $data['visitor_stay_time'] = intval($_POST['visitor_stay_time']);
    //获取管理员停留时间
    $data['admin_stay_time'] = intval($_POST['admin_stay_time']);
    
    //序列化存储
    $value = serialize($data);   

    $api->set_option('s_transition_page',$value);
}

//生成create_sk
function create_sk($api) {
    $api->create_sk();
}

//获取onenav最新版本号
function get_latest_version() {
    try {
        $curl = curl_init("https://git.xiaoz.me/xiaoz/onenav/raw/branch/main/version.txt");

        curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/100.0.4896.127 Safari/537.36 Edg/100.0.1185.50");
        curl_setopt($curl, CURLOPT_FAILONERROR, true);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        #设置超时时间，最小为1s（可选）
        curl_setopt($curl , CURLOPT_TIMEOUT, 5);

        $html = curl_exec($curl);
        curl_close($curl);
        $data = [
            "code"      =>  200,
            "msg"       =>  "",
            "data"      =>  $html
        ];
        
    } catch (\Throwable $th) {
        $data = [
            "code"      =>  200,
            "msg"       =>  "",
            "data"      =>  ""
        ];
    }
    exit(json_encode($data));
}

//批量修改链接分类
function batch_modify_category($api) {
    //获取id列表
    $id = $_POST['id'];
    //获取分类ID
    $fid = intval($_POST['fid']);

    $data = [
        'id'    =>  $id,
        'fid'   =>  $fid
    ];
    
    $api->batch_modify_category($data);
}

//保存主题参数设置
function save_theme_config($api) {
    //获取所有POST数组，并组合为对象
    $post_data = $_POST;
    //数组转对象
    foreach ($post_data as $key => $value) {
        $data['config']->$key = $value;
    }
    $data['name'] = $post_data['name'];
    unset($data['config']->name);
    $api->save_theme_config($data);
}
//获取主题配置信息
function get_theme_config($api) {
    $api->get_theme_config();
}

//批量设置链接私有属性
function set_link_attribute($api) {
    $ids = $_POST['ids'];
    $property = intval( $_POST['property'] );
    $data = [
        "ids"      =>   $ids,
        "property" =>   $property
    ];
    $api->set_link_attribute($data);
}

//导出链接数据
function export_link($api) {
    header('Content-Type: text/html;charset=utf8');
    $data = $api->export_link();
    //当前时间
    $current = time();
    echo <<< EOF
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=UTF-8">
<TITLE>从OneNav导出的书签</TITLE>
<H1>Bookmarks</H1>
EOF;
    //遍历结果
    foreach ($data as $key => $value) {
        echo "<DT><H3 ADD_DATE=\"$current\" LAST_MODIFIED=\"$current\">$key</H3>\n";
        echo "<DL><P></P>\n";
        foreach ($value as $link) {
            $title = $link['title'];
            $add_time = $link['add_time'];
            $url = $link['url'];
            echo "<DT><A HREF=\"$url\" ADD_DATE=\"$add_time\" ICON=\"\">$title</a></DT>\n";
        }
        echo "<P></P></DL>\n";
        echo "</DT>\n";

    }
}

//获取用户登录状态
function check_login($api) {
    $api->check_login();
}