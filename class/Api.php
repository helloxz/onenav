<?php
/**
 * name:API核心类
 * update:2020/12
 * author:xiaoz<xiaoz93@outlook.com>
 * blog:xiaoz.me
 */
class Api {
    protected $db;
    public function __construct($db){
        $this->db = $db;
        //返回json类型
        header('Content-Type:application/json; charset=utf-8');
    }
    /**
     * name:创建分类目录
     */
    public function add_category($token,$name,$property = 0,$weight = 0,$description = '',$font_icon = ''){
        $this->auth($token);
        $data = [
            'name'          =>  htmlspecialchars($name,ENT_QUOTES),
            'add_time'      =>  time(),
            'weight'        =>  $weight,
            'property'      =>  $property,
            'description'   =>  htmlspecialchars($description,ENT_QUOTES),
            'font_icon'     =>  $font_icon
        ];
        //插入分类目录
        $this->db->insert("on_categorys",$data);
        //返回ID
        $id = $this->db->id();
        //如果id为空（NULL），说明插入失败了，姑且认为是name重复导致
        if( empty($id) ){
            $this->err_msg(-1000,'Categorie already exist!');
        }
        else{
            //成功并返回json格式
            $data = [
                'code'      =>  0,
                'id'        =>  intval($id)
            ];
            exit(json_encode($data));
        }
        
    }
    /**
     * 修改分类目录
     * 
     */
    public function edit_category($token,$id,$name,$property = 0,$weight = 0,$description = '',$font_icon = ''){
        $this->auth($token);
        //如果id为空
        if( empty($id) ){
            $this->err_msg(-1003,'The category ID cannot be empty!');
        }
        //如果分类名为空
        elseif( empty($name) ){
            $this->err_msg(-1004,'The category name cannot be empty!');
        }
        //更新数据库
        else{
            $data = [
                'name'          =>  htmlspecialchars($name,ENT_QUOTES),
                'up_time'      =>  time(),
                'weight'        =>  $weight,
                'property'      =>  $property,
                'description'   =>  htmlspecialchars($description,ENT_QUOTES),
                'font_icon'     =>  $font_icon
            ];
            $re = $this->db->update('on_categorys',$data,[ 'id' => $id]);
            //var_dump( $this->db->log() );
            //获取影响行数
            $row = $re->rowCount();
            if($row) {
                $data = [
                    'code'  =>  0,
                    'msg'   =>  'successful'
                ];
                exit(json_encode($data));
            }
            else{
                $this->err_msg(-1005,'The category name already exists!');
            }
        }
    }
    /**
     * 删除分类目录
     */
    public function del_category($token,$id) {
        //验证授权
        $this->auth($token);
        //如果id为空
        if( empty($id) ){
            $this->err_msg(-1003,'The category ID cannot be empty!');
        }
        //如果分类目录下存在数据
        $count = $this->db->count("on_links", [
            "fid" => $id
        ]);
        //如果分类目录下存在数据，则不允许删除
        if($count > 0) {
            $this->err_msg(-1006,'The category is not empty and cannot be deleted!');
        }
        else{
            $data = $this->db->delete('on_categorys',[ 'id' => $id] );
            //返回影响行数
            $row = $data->rowCount();
            if($row) {
                $data = [
                    'code'  =>  0,
                    'msg'   =>  'successful'
                ];
                exit(json_encode($data));
            }
            else{
                $this->err_msg(-1007,'The category delete failed!');
            }
        }
    }
    
    /**
     * name:返回错误（json）
     * 
     */
    protected function err_msg($code,$err_msg){
        $data = [
            'code'      =>  $code,
            'err_msg'   =>  $err_msg
        ];
        //返回json类型
        header('Content-Type:application/json; charset=utf-8');
        exit(json_encode($data));
    }
    /**
     * name:验证方法
     */
    protected function auth($token){
        //计算正确的token：用户名 + TOKEN
        $token_yes = md5(USER.TOKEN);
        //如果token为空，则验证cookie
        if(empty($token)) {
            if( !$this->is_login() ) {
                $this->err_msg(-1002,'Authorization failure!');
            }
        }
        else if($token != $token_yes){
            $this->err_msg(-1002,'Authorization failure!');
        }
        else{
            return true;
        }
    }
    /**
     * name:添加链接
     */
    public function add_link($token,$fid,$title,$url,$description = '',$weight = 0,$property = 0){
        $this->auth($token);
        $fid = intval($fid);
        //检测链接是否合法
        $this->check_link($fid,$title,$url);
        //合并数据
        $data = [
            'fid'           =>  $fid,
            'title'         =>  htmlspecialchars($title,ENT_QUOTES),
            'url'           =>  $url,
            'description'   =>  htmlspecialchars($description,ENT_QUOTES),
            'add_time'      =>  time(),
            'weight'        =>  $weight,
            'property'      =>  $property
        ];
        //插入数据库
        $re = $this->db->insert('on_links',$data);
        //返回影响行数
        $row = $re->rowCount();
        //如果为真
        if( $row ){
            $id = $this->db->id();
            $data = [
                'code'      =>  0,
                'id'        =>  $id
            ];
            exit(json_encode($data));
        }
        //如果插入失败
        else{
            $this->err_msg(-1011,'The URL already exists!');
        }
    }
    /**
     * 批量导入链接
     */
    public function imp_link($token,$filename,$fid,$property = 0){
        $this->auth($token);
        //检查文件是否存在
        if ( !file_exists($filename) ) {
            $this->err_msg(-1016,'File does not exist!');
        }
        //解析HTML数据
        $content = file_get_contents($filename);

        $pattern = "/<A.*<\/A>/i";

        preg_match_all($pattern,$content,$arr);
        //失败次数
        $fail = 0;
        //成功次数
        $success = 0;
        //总数
        $total = count($arr[0]);
        foreach( $arr[0] as $link )
        {
            $pattern = "/http.*\"? ADD_DATE/i";
            preg_match($pattern,$link,$urls);
            $url = str_replace('" ADD_DATE','',$urls[0]);
            $pattern = "/>.*<\/a>$/i";
            preg_match($pattern,$link,$titles);
            
            $title = str_replace('>','',$titles[0]);
            $title = str_replace('</A','',$title);
            
            //如果标题或者链接为空，则不导入
            if( ($title == '') || ($url == '') ) {
                $fail++;
                continue;
            }
            $data = [
                'fid'           =>  $fid,
                'description'   =>  '',
                'add_time'      =>  time(),
                'weight'        =>  0,
                'property'      =>  $property
            ];
            $data['title'] = $title;
            $data['url']    = $url;
            
            //插入数据库
            $re = $this->db->insert('on_links',$data);
            //返回影响行数
            $row = $re->rowCount();
            //如果为真
            if( $row ){
                $id = $this->db->id();
                $data = [
                    'code'      =>  0,
                    'id'        =>  $id
                ];
                $success++;
                
            }
            //如果插入失败
            else{
                $fail++;
            }
        }
        //删除书签
        unlink($filename);
        $data = [
            'code'      =>  0,
            'msg'       =>  '总数：'.$total.' 成功：'.$success.' 失败：'.$fail
        ];
        exit(json_encode($data));
    }
    /**
     * 书签上传
     * type:上传类型，默认为上传书签，后续类型保留使用
     */
    public function upload($token,$type){
        $this->auth($token);
        if ($_FILES["file"]["error"] > 0)
        {
            $this->err_msg(-1015,'File upload failed!');
        }
        else
        {
            $filename = $_FILES["file"]["name"];
            //获取文件后缀
            $suffix = explode('.',$filename);
            $suffix = strtolower(end($suffix));
            
            //临时文件位置
            $temp = $_FILES["file"]["tmp_name"];
            if( $suffix != 'html' ) {
                //删除临时文件
                unlink($filename);
                $this->err_msg(-1014,'Unsupported file suffix name!');
            }
            
            if( copy($temp,'data/'.$filename) ) {
                $data = [
                    'code'      =>  0,
                    'file_name' =>  'data/'.$filename
                ];
                exit(json_encode($data));
            }
        }
    }
    /**
     * name:修改链接
     */
    public function edit_link($token,$id,$fid,$title,$url,$description = '',$weight = 0,$property = 0){
        $this->auth($token);
        $fid = intval($fid);
        //检测链接是否合法
        $this->check_link($fid,$title,$url);
        //查询ID是否存在
        $count = $this->db->count('on_links',[ 'id' => $id]);
        //如果id不存在
        if( (empty($id)) || ($count == false) ) {
            $this->err_msg(-1012,'link id not exists!');
        }
        //合并数据
        $data = [
            'fid'           =>  $fid,
            'title'         =>  htmlspecialchars($title,ENT_QUOTES),
            'url'           =>  $url,
            'description'   =>  htmlspecialchars($description,ENT_QUOTES),
            'up_time'       =>  time(),
            'weight'        =>  $weight,
            'property'      =>  $property
        ];
        //插入数据库
        $re = $this->db->update('on_links',$data,[ 'id' => $id]);
        //返回影响行数
        $row = $re->rowCount();
        //如果为真
        if( $row ){
            $id = $this->db->id();
            $data = [
                'code'      =>  0,
                'msg'        =>  'successful'
            ];
            exit(json_encode($data));
        }
        //如果插入失败
        else{
            $this->err_msg(-1011,'The URL already exists!');
        }
    }
    
    /**
     * 删除链接
     */
    public function del_link($token,$id){
        //验证token是否合法
        $this->auth($token);
        //查询ID是否存在
        $count = $this->db->count('on_links',[ 'id' => $id]);
        //如果id不存在
        if( (empty($id)) || ($count == false) ) {
            $this->err_msg(-1010,'link id not exists!');
        }
        else{
            $re = $this->db->delete('on_links',[ 'id' =>  $id] );
            if($re) {
                $data = [
                    'code'  =>  0,
                    'msg'   =>  'successful'
                ];
                exit(json_encode($data));
            }
            else{
                $this->err_msg(-1010,'link id not exists!');
            }
        }
    }
    /**
     * 验证链接合法性
     */
    protected function check_link($fid,$title,$url){
        //如果父及（分类）ID不存在
        if( empty($fid )) {
            $this->err_msg(-1007,'The category id(fid) not exist!');
        }
        //如果父及ID不存在数据库中
        //验证分类目录是否存在
        $count = $this->db->count("on_categorys", [
            "id" => $fid
        ]);
        if ( empty($count) ){
            $this->err_msg(-1007,'The category not exist!');
        }
        //如果链接标题为空
        if( empty($title) ){
            $this->err_msg(-1008,'The title cannot be empty!');
        }
        //链接不能为空
        if( empty($url) ){
            $this->err_msg(-1009,'URL cannot be empty!');
        }
        //链接不合法
        if( !filter_var($url, FILTER_VALIDATE_URL) ) {
            $this->err_msg(-1010,'URL is not valid!');
        }
        return true;
    }
    /**
     * 查询分类目录
     */
    public function category_list($page,$limit){
        $offset = ($page - 1) * $limit;
        //如果成功登录，则查询所有
        if( $this->is_login() ){
            $sql = "SELECT * FROM on_categorys ORDER BY weight DESC,id DESC LIMIT {$limit} OFFSET {$offset}";
        }
        else{
            $sql = "SELECT * FROM on_categorys WHERE property = 0 ORDER BY weight DESC,id DESC LIMIT {$limit} OFFSET {$offset}";
        }
        //统计总数
        $count = $this->db->count('on_categorys','*');
        //原生查询
        $datas = $this->db->query($sql)->fetchAll();
        $datas = [
            'code'      =>  0,
            'msg'       =>  '',
            'count'     =>  $count,
            'data'      =>  $datas
        ];
        exit(json_encode($datas));
    }
    /**
     * 查询链接
     * 接收一个数组作为参数
     */
    public function link_list($data){
        $limit = $data['limit'];
        $token = $data['token'];
        $offset = ($data['page'] - 1) * $data['limit'];
        $fid = @$data['category_id'];
        
        //如果存在分类ID，则根据分类ID进行查询
        if ($data['category_id'] != null) {
            
            $cid_sql = "WHERE fid = $fid";
            //统计链接总数
            $count = $this->db->count('on_links','*',[
                'fid'   =>  $fid
            ]);
        }
        else{
            //统计链接总数，没有分类ID的情况
            $count = $this->db->count('on_links','*');
        }
        //如果成功登录，但token为空
        if( ($this->is_login()) && (empty($token)) ){
            $sql = "SELECT *,(SELECT name FROM on_categorys WHERE id = on_links.fid) AS category_name FROM on_links ${cid_sql} ORDER BY weight DESC,id DESC LIMIT {$limit} OFFSET {$offset}";
        }
        
        //如果token验证通过
        elseif( (!empty($token)) && ($this->auth($token)) ) {
            $sql = "SELECT *,(SELECT name FROM on_categorys WHERE id = on_links.fid) AS category_name FROM on_links ${cid_sql} ORDER BY weight DESC,id DESC LIMIT {$limit} OFFSET {$offset}";
        }
        //如果即没有登录成功，又没有token，则默认为游客
        else{
            $cid_sql = empty($fid) ? null : "AND fid = $fid";
            if($cid_sql == null) {
                //统计链接总数，不存在分类ID的情况
                $count = $this->db->count('on_links','*',[ 'property'   =>  0 ]);
            }
            else{
                //统计链接总数，存在分类ID的情况
                $count = $this->db->count('on_links','*',[ 
                    'property'  =>  0,
                    'fid'       =>  $fid 
                ]);
            }
            
            $sql = "SELECT *,(SELECT name FROM on_categorys WHERE id = on_links.fid) AS category_name FROM on_links WHERE property = 0 ${cid_sql} ORDER BY weight DESC,id DESC LIMIT {$limit} OFFSET {$offset}";
        }

        //打印SQL
        //echo $sql;

        //如果查询的总数大于limit，则以limit为准
        //$count = ( $count > $limit) ? $limit : $count;
       
        //原生查询
        $datas = $this->db->query($sql)->fetchAll();
        $datas = [
            'code'      =>  0,
            'msg'       =>  '',
            'count'     =>  $count,
            'data'      =>  $datas
        ];
        exit(json_encode($datas));
    }
    /**
     * 查询单个链接
     * 此函数接收一个数组
     */
    public function get_a_link($data) {
        $id = $data['id'];
        $token = $data['token'];
        $link_info = $this->db->get("on_links","*",[
            "id"    =>  $id
        ]);
        //打印链接信息
        //var_dump($link_info);
        //如果是公开链接，则直接返回
        if ( $link_info['property'] == "0" ) {
            $datas = [
                'code'      =>  0,
                'data'      =>  $link_info
            ];
            
        }
        //如果是私有链接，并且认证通过
        elseif( $link_info['property'] == "1" ) {
            if ( $this->auth($token) ) {
                $datas = [
                    'code'      =>  0,
                    'data'      =>  $link_info
                ];
            }
            
            //exit(json_encode($datas));
        }
        //如果是其它情况，则显示为空
        else{
            $datas = [
                'code'      =>  0,
                'data'      =>  []
            ];
            //exit(json_encode($datas));
        }
        exit(json_encode($datas));
    }
    /**
     * 验证是否登录
     */
    protected function is_login(){
        $key = md5(USER.PASSWORD.'onenav');
        //获取session
        $session = $_COOKIE['key'];
        //如果已经成功登录
        if($session == $key) {
            return true;
        }
        else{
            return false;
        }
    }
    /**
     * 获取链接信息
     */
    public function get_link_info($token,$url){
        $this->auth($token);
        //检查链接是否合法
        //链接不合法
        if( !filter_var($url, FILTER_VALIDATE_URL) ) {
            $this->err_msg(-1010,'URL is not valid!');
        }
        //获取网站标题
        $c = curl_init(); 
        curl_setopt($c, CURLOPT_URL, $url); 
        curl_setopt($c, CURLOPT_RETURNTRANSFER, 1); 
        curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($c, CURLOPT_SSL_VERIFYHOST, false);
        //设置超时时间
        curl_setopt($c , CURLOPT_TIMEOUT, 10);
        $data = curl_exec($c); 
        curl_close($c); 
        $pos = strpos($data,'utf-8'); 
        if($pos===false){$data = iconv("gbk","utf-8",$data);} 
        preg_match("/<title>(.*)<\/title>/i",$data, $title); 
        
        $link['title'] =  $title[1]; 

        //获取网站描述
        $tags = get_meta_tags($url);
        $link['description'] = $tags['description'];
        
        $data = [
            'code'      =>  0,
            'data'      =>  $link
        ];
        exit(json_encode($data));
    }
    /**
     * 自定义js
     */
    public function add_js($token,$content){
        $this->auth($token);
        //如果内容为空
        // if( $content == '' ){
        //     $this->err_msg(-1013,'The content cannot be empty!');
        // }
        //写入文件
        try{
            file_put_contents("data/extend.js",$content);
            $data = [
                'code'      =>  0,
                'data'      =>  'success'
            ];
            exit(json_encode($data));
        }
        catch(Exception $e){
            $this->err_msg(-2000,$e->getMessage());
        }
    }
    /**
     * 获取IP
     */
    //获取访客IP
    protected function getIP() { 
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
     * name:检查弱密码
     */
    public function check_weak_password($token){
        $this->auth($token);
        //如果用户名、密码为初始密码，则提示修改
        if ( ( USER == 'xiaoz' ) && ( PASSWORD == 'xiaoz.me' ) ) {
            $this->err_msg(-1,'Weak password!');
        }
    }
    /**
     * 获取SQL更新列表
     * 循环读取db/sql/目录下的.sql文件
     */
    public function get_sql_update_list($data) {
        //鉴权
        if( !$this->is_login() ) {
            $this->err_msg(-1002,'Authorization failure!');
        }
        //待更新的数据库文件目录
        $sql_dir = 'db/sql/';
        //待更新的sql文件列表，默认为空
        $sql_files_all = [];
        //打开一个目录，读取里面的文件列表
        if (is_dir($sql_dir)){
            if ($dh = opendir($sql_dir)){
                while (($file = readdir($dh)) !== false){
                //排除.和..
                if ( ($file != ".") && ($file != "..") ) {
                    array_push($sql_files_all,$file);

                }
            }
                //关闭句柄
                closedir($dh);
            }
        }
        //判断数据库日志表是否存在
        $sql = "SELECT count(*) AS num FROM sqlite_master WHERE type='table' AND name='on_db_logs'";
        //查询结果
        $q_result = $this->db->query($sql)->fetchAll();
        //如果数量为0，则说明on_db_logs这个表不存在，需要提前导入
        $num = intval($q_result[0]['num']);
        if ( $num === 0 ) {
            $data = [
                "code"      =>  0,
                "data"      =>  ['on_db_logs.sql']
            ];
            exit(json_encode($data));
        }else{
            //如果不为0，则需要查询数据库更新表里面的数据进行差集比对
            $get_on_db_logs = $this->db->select("on_db_logs",[
                "sql_name"
            ],[
                "status"    =>  "TRUE"
            ]);
            //声明一个空数组，存储已更新的数据库列表
            $already_dbs = [];
            foreach ($get_on_db_logs as $value) {
                array_push($already_dbs,$value['sql_name']);
            }
            
            //array_diff() 函数返回两个数组的差集数组
            $diff_result = array_diff($sql_files_all,$already_dbs);
            //去掉键
            $diff_result = array_values($diff_result);
            sort($diff_result);
            
            $data = [
                "code"      =>  0,
                "data"      =>  $diff_result
            ];
            exit(json_encode($data));
        }

    }
    /**
     * 执行SQL更新语句，只执行单条更新
     */
    public function exe_sql($data) {
        //鉴权
        if( !$this->is_login() ) {
            $this->err_msg(-1002,'Authorization failure!');
        }
        //数据库sql目录
        $sql_dir = 'db/sql/';
        $name = $data['name'];
        $sql_name = $sql_dir.$name;
        //如果文件不存在，直接返回错误
        if ( !file_exists($sql_name) ) {
            $this->err_msg(-2000,$name.'不存在!');
        }
        //读取需要更新的SQL内容
        try {
            $sql_content = file_get_contents($sql_name);
            $result = $this->db->query($sql_content);
            //如果SQL执行成功，则返回
            if( $result ) {
                //将更新信息写入数据库
                $insert_re = $this->db->insert("on_db_logs",[
                    "sql_name"      =>  $name,
                    "update_time"   =>  time(),
                    "status"        =>  "TRUE"
                ]);
                if( $insert_re ) {
                    $data = [
                        "code"      =>  0,
                        "data"      =>  $name."更新完成！"
                    ];
                    exit(json_encode($data));
                }
                else {
                    $this->err_msg(-2000,$name."更新失败，请人工检查！");
                }
                
            }
            else{
                //如果执行失败
                $this->err_msg(-2000,$name."更新失败，请人工检查！");
            }
        } catch(Exception $e){
            $this->err_msg(-2000,$e->getMessage());
        }
    }
    
}

