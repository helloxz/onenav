<!-- 主题设置 -->
<?php require_once(dirname(__DIR__).'/header.php'); ?>
<?php include_once(dirname(__DIR__).'/left.php'); ?>
<div class="layui-body">
<!-- 内容主体区域 -->
<div class="layui-row content-body place-holder" id = "layer-photos">
    <!-- 说明提示框 -->
    <div class="layui-col-lg12">
      <div class="setting-msg">
        <p>1. 主题更换及设置说明，请参考：<a href="https://dwz.ovh/yoyaf" target = "_blank" title = "主题更换及设置说明">https://dwz.ovh/yoyaf</a></p>
        <p>2. 主题本身不收取费用，但为了分摊服务器存储和带宽成本，主题下载和更新需要订阅用户才能使用，敬请谅解！订阅地址：<a href="https://dwz.ovh/69h9q" rel="nofollow" target="_blank" title="购买订阅服务">https://dwz.ovh/69h9q</a></p>
        <p>3. 部分主题来自其它开源项目，OneNav仅做适配，主题版权归原作者所有</p>
        <p>4. 主题提交请联系QQ:446199062</p>
      </div>
    </div>
    <!-- 说明提示框END -->
    <div class="layui-col-lg12">
        <div class="layui-row layui-col-space24">
            

            <!-- 主题列表new -->
            <?php foreach ($themes as $key => $theme) {
                //var_dump($theme['info']->name);
            ?>
            <div class="layui-col-md3">
                <div class="layui-card custom-card">
                    <div class="layui-card-header" id="<?php echo $key; ?>">
                        <div class="them-header">
                            <div class="left">
                                <span class = "name"><?php echo $key; ?> - <?php echo $theme['info']->version ?></span>
                                <?php if( $current_them == $key ) { ?>
                                    <!-- <span style = "color:#ff5722;">（使用中）</span> -->
                                <?php } ?>
                            </div>
                            <div class="right">
                                <span class="renewable" style="color:#FF5722;font-size:14px;"></span>
                            </div>
                        </div>
                        

                    </div>
                    <div class="layui-card-body">
                        <!-- 主题图片 -->
                        <div class = "screenshot">
                            <p><img layer-src="<?php echo $theme['info']->screenshot; ?>" src="<?php echo $theme['info']->screenshot; ?>" alt=""></p>
                            <?php if( $current_them == $key ) { ?>
                                <div class="in-use">使用中</div>
                            <?php } ?>
                        </div>
                        
                        <!-- 主题图片END -->
                        <hr>
                        <div class = "thme-btns">
                            <div class="layui-btn-group">
                                <button type="button" class="layui-btn layui-btn-sm" onclick = "set_theme('<?php echo $key; ?>')">使用</button>
                                <button type="button" class="layui-btn layui-btn-sm" onclick = "theme_detail('<?php echo $key; ?>')">详情</button>
                                <button type="button" class="layui-btn layui-btn-sm" onclick = "theme_config('<?php echo $key; ?>')">参数设置</button>
                                <button type="button" class="layui-btn layui-btn-sm" onclick = "update_theme('<?php echo $key; ?>','<?php echo $theme['info']->version; ?>')">更新</button>
                                <a class="layui-btn layui-btn-sm" target = "_blank" href="/index.php?theme=<?php echo $key;  ?>">预览</a>
                                <button type="button" class="layui-btn layui-btn-sm layui-btn-danger" onclick = "delete_theme('<?php echo $key; ?>')">删除</button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <?php } ?>
            <!-- 主题列表new END -->

        </div>
    </div>
    <hr>
    <!-- 在线主题 -->
    <div class="layui-col-lg12">
        <h2 style = "padding-bottom:16px;padding-top:8px;">在线主题：</h2>
        <div class="layui-row layui-col-space24">
        <?php foreach ($theme_list as $key => $theme) {
                //var_dump($theme['info']->name);
            ?>
            <!-- 在线主题列表 -->
            
            <div class="layui-col-md3">
                <div class="layui-card custom-card">
                    <div class="layui-card-header">
                        <?php echo $key; ?> - <?php echo $theme->version ?>
                    </div>
                    <div class="layui-card-body">
                        <!-- 主题图片 -->
                        <div class = "screenshot">
                            <p><img layer-src="<?php echo $theme->screenshot; ?>" src="<?php echo $theme->screenshot; ?>" alt=""></p>
                        </div>
                        <!-- 主题图片END -->
                        <hr>
                        <div class = "thme-btns">
                            <div class="layui-btn-group">
                                <button type="button" class="layui-btn layui-btn-sm" onclick = "down_theme('<?php echo $key; ?>','download')">下载</button>
                                <a class="layui-btn layui-btn-sm" title = "查看<?php echo $key; ?>演示" target = "_blank" href="https://nav.rss.ink/index.php?theme=<?php echo $key; ?>">查看演示</a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <!-- 主题列表END -->
            <?php } ?>
        </div>
    </div>
    <!-- 在线主题END -->
</div>
</div>
<?php include_once(dirname(__DIR__).'/footer.php'); ?>
<script>
layui.use('layer', function(){
    var layer = layui.layer;
});
function theme_detail(name){
    layer.open({
        title: name,
        type:2,
        area: ['60%', '59%'],
        content:'/index.php?c=admin&page=setting/theme_detail&name=' + name
    });   
}

function theme_detail_online(name){
    layer.open({
        title: name,
        type:2,
        area: ['60%', '59%'],
        content:'/index.php?c=admin&page=setting/theme_detail&name=' + name
    });   
}
//主题参数设置
function theme_config(name){
    layer.open({
        title: "设置主题【" + name + "】参数：",
        type:2,
        area: ['620px', '560px'],
        content:'/index.php?c=admin&page=setting/theme_config&name=' + name
    });
}

function set_theme(name) {
    $.post("/index.php?c=api&method=set_theme",{key:"theme",value:name},function(data,status){
        if( data.code == 0 ) {
            layer.msg(data.data, {icon: 1});
            setTimeout(() => {
                location.reload();
            }, 2000);
        }
        else{
            layer.msg(data.err_msg, {icon: 5});
        }
    });
}

function down_theme(name,type) {
    //请求订阅接口，并获取key、value
    var index = layer.load(1);
    // $.ajax({
    //     'url': '/index.php?c=api&method=check_subscribe',
    //     'type': 'GET',
    //     'async': false,
    //     success:function(result) {
            
    //     }
    // });
    $.get("/index.php?c=api&method=check_subscribe",function(result,status){
        if( result.code == 200 ) {
            var key = result.data.key;
            var value = result.data.value;
            //继续下载主题
            $.get("/index.php?c=api&method=down_theme",{name:name,key:key,value:value,type:type},function(data,status){
                //如果下载成功
                if( data.code == 200 ) {
                    layer.closeAll('loading');
                    layer.msg(data.msg, {icon: 1});
                    //重载当前页面
                    setTimeout(() => {
                    window.location.reload();
                    }, 2000);
                }
                else{
                    layer.closeAll('loading');
                    layer.msg(data.msg, {icon: 5});
                }
            });
        }
        else{
            layer.closeAll('loading');
            layer.msg(result.msg, {icon: 5});
        }
    });
}
//更新主题
function update_theme(name,version){
    //获取远程主题最新版本号
    var index = layer.load(1);
    var infourl = "https://onenav.xiaoz.top/themes/" + name + "/info.json";
    $.ajax({
        type:"HEAD",
        async:true,
        url:infourl,
        statusCode: {
        200: function() {
            $.get("https://onenav.xiaoz.top/themes/" + name + "/info.json",function(data,status){
                let new_version = data.version;
                if ( version >= new_version ) {
                    layer.closeAll('loading');
                    layer.msg('已经是最新版本，无需更新！', {icon: 5});
                }
                else{
                    down_theme(name,'update');
                }
            });
        },
        403:function() {
            layer.closeAll('loading');
            layer.msg('更新失败，权限不足！', {icon: 5});
        },
        404:function() {
            layer.closeAll('loading');
            layer.msg('更新失败，远程服务器上不存在此主题！', {icon: 5});
        }
        }
    });
    
}

//遍历所有主题，检查是否有更新
function check_update(){
    console.log('fdsfsdf');
    //请求远程主题列表
    $.get("https://onenav.xiaoz.top/v1/theme_list.php",function(data,status){
        let result = data.data;
        console.log(result);
        //console.log(result.5iux);
        for (const obj in result) {
            //获取主题名称
            let select = `#${obj} .name`;
            let value = $(select).text();
            
            //如果获取到的数据为空
            if( value == '' ) {
                continue;
            }
            
            //获取最新版本
            let latest_version = result[obj].version;
            //获取当前版本
            let current_version = value.split(' - ')[1];
            //如果存在最新版本
            if( latest_version > current_version ) {
                console.log("#" + obj + " .renewable");
                $("#" + obj + " .renewable").append(`(可更新至${latest_version})`);
            }
        }
    });
}
check_update();


layer.photos({
  photos: '#layer-photos'
  ,anim: 5 //0-6的选择，指定弹出图片动画类型，默认随机（请注意，3.0之前的版本用shift参数）
}); 
</script>