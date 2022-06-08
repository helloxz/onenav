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
    //搜索字体图标是否包含'fa '，如果不包含则自动加上
    if( !strstr($font_icon,'fa ') ) {
        $font_icon = 'fa '.$font_icon;
    }
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
    //搜索字体图标是否包含'fa '，如果不包含则自动加上
    if( !strstr($font_icon,'fa ') ) {
        $font_icon = 'fa '.$font_icon;
    }
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
 * 查询分类下的链接
 */
function q_category_link($api){
    $page = empty(intval($_REQUEST['page'])) ? 1 : intval($_REQUEST['page']);
    $limit = empty(intval($_REQUEST['limit'])) ? 10 : intval($_REQUEST['limit']);
    //获取token
    $token = $_POST['token'];
    //获取分类ID
    $category_id = empty($_REQUEST['category_id']) ? null : intval($_REQUEST['category_id']);
    $data = [
        'page'          =>  $page,
        'limit'         =>  $limit,
        'token'         =>  $token,
        'category_id'   =>  $category_id
    ];
    $api->q_category_link($data);
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

    if( !empty($data['custom_footer']) ) {
        if( !$api->is_subscribe() ) {
            $api->err_msg(-2000,'保存失败，自定义footer需要订阅用户才能使用，若未订阅请留空！');
        }
        
    }
    

    $api->set_option('s_site',$value);
}

//阻止非订阅用户保存设置
function _deny_set($content,$err_msg) {
    global $api;
    //验证订阅,返回TRUE或FALSE
    if ( !isset($_SESSION['subscribe']) ) {
        //验证订阅,返回TRUE或FALSE
        $result = $api->is_subscribe();
    }
    
    //如果内容是空的，直接允许
    if ( empty($content) ) {
        return TRUE;
    }
    else{
        if( $_SESSION['subscribe'] === TRUE ) {
            return TRUE;
        }
        else{
            $api->err_msg(-2000,$err_msg);
        }

    }
}
//设置订阅信息
function set_subscribe($api) {
    //获取订单ID
    $data['order_id'] = htmlspecialchars( trim($_REQUEST['order_id']) );
    //获取邮箱
    $data['email'] = htmlspecialchars( trim($_REQUEST['email']) );
    //到期时间
    $data['end_time'] = htmlspecialchars( trim($_REQUEST['end_time']) );
    //重置订阅状态
    session_start();
    $_SESSION['subscribe'] = NULL;

    //序列化存储
    $value = serialize($data);

    //序列化存储到数据库
    $api->set_option('s_subscribe',$value);
}
//检查订阅信息
function check_subscribe($api) {
    $api->check_subscribe();
}
//检查更新程序
function up_updater($api) {
    $api->up_updater();
}
//验证当前版本是否匹配
function check_version($api) {
    $version = $_REQUEST['version'];
    $api->check_version($version);
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
    //获取菜单
    $data['menu'] = $_POST['menu'];
    //获取footer
    $data['footer'] = $_POST['footer'];
    //获取广告
    $data['a_d_1'] = $_POST['a_d_1'];
    $data['a_d_2'] = $_POST['a_d_2'];
    

    //验证订阅
    _deny_set($data['menu'],'保存失败，过渡页菜单需要订阅用户才能使用！');
    _deny_set($data['footer'],'保存失败，自定义footer需要订阅用户才能使用！');
    _deny_set($data['a_d_1'],'保存失败，自定义广告需要订阅用户才能使用！');
    _deny_set($data['a_d_2'],'保存失败，自定义广告需要订阅用户才能使用！');
    
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
    $token = trim($_REQUEST['token']);
    $api->check_login($token);
}

//删除主题
function delete_theme($api) {
    $name = $_REQUEST['name'];
    $api->delete_theme($name);
}

//下载主题
function down_theme() {
    global $api;
    $data['name'] = trim($_REQUEST['name']);
    $data['key'] = trim( $_REQUEST['key'] );
    $data['value'] = trim( $_REQUEST['value'] );
    $data['type'] = trim( $_REQUEST['type'] );

    $api->down_theme($data);
}