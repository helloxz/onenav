<?php
$content = file_get_contents("bookmarks_2022_5_6.html");//读入文件
$HTMLs = explode("\n",$content);//分割文本
$data = []; //链接组
$categorys = []; //分类信息组
$categoryt = []; //分类信息表

// 遍历HTML
foreach( $HTMLs as $HTMLh ){
    //匹配分类名称
    if( preg_match("/<DT><H3.+>(.*)<\/H3>/i",$HTMLh,$category) ){
        //匹配到文件夹名时加入数组
        array_push($categoryt,$category[1]);
        array_push($categorys,$category[1]);
    }elseif( preg_match('/<\/DL><p>/i',$HTMLh) ){
        //匹配到文件夹结束标记时删除一个
        array_pop($categorys);
    }elseif( preg_match('/<DT><A HREF="(.+)" ADD_DAT.+>(.+)<\/A>/i',$HTMLh,$urls) ){
        $datat['category'] =  $categorys[count($categorys) -1];
        $datat['title'] = $urls[2];
        $datat['url'] = $urls[1];
        array_push($data,$datat);
    }
}
$categoryt = array_unique($categoryt);
var_dump($categoryt);exit;