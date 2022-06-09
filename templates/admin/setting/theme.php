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
        <p>2. 为了分摊服务器成本，主题下载和更新需要订阅用户才能使用，敬请谅解！订阅地址：<a href="https://dwz.ovh/69h9q" rel="nofollow" target="_blank" title="购买订阅服务">https://dwz.ovh/69h9q</a></p>
        <p>3. 部分主题来自其它开源项目，OneNav仅做适配，主题版权归原作者所有</p>
        <p>4. 主题提交请联系QQ:446199062</p>
      </div>
    </div>
    <!-- 说明提示框END -->
    <div class="layui-col-lg12">
        <div class="layui-row layui-col-space24">
            <?php foreach ($themes as $key => $theme) {
                //var_dump($theme['info']->name);
            ?>
            <!-- 主题列表 -->
            <div class="layui-col-lg3 layui-col-md6 layui-col-sm12">
                <fieldset style = "padding:1em;border:0px;height:280px;border:1px dashed #1E9FFF;box-shadow: 2px 2px 3px #888888;color:#666666">
                    <legend style = "font-size:24px;"><?php echo $key; ?> - <?php echo $theme['info']->version ?></legend>
                    
                    <!-- 主题图片 -->
                    <div class = "screenshot"><p><img layer-src="<?php echo $theme['info']->screenshot; ?>" src="<?php echo $theme['info']->screenshot; ?>" alt=""></p></div>
                    <!-- 主题图片END -->
                    
                    <p>
                    <div class="layui-btn-group">
                        <button type="button" class="layui-btn layui-btn-sm" onclick = "set_theme('<?php echo $key; ?>')">使用</button>
                        <button type="button" class="layui-btn layui-btn-sm" onclick = "theme_detail('<?php echo $key; ?>')">详情</button>
                        <button type="button" class="layui-btn layui-btn-sm" onclick = "theme_config('<?php echo $key; ?>')">参数设置</button>
                        <button type="button" class="layui-btn layui-btn-sm" onclick = "update_theme('<?php echo $key; ?>','<?php echo $theme['info']->version; ?>')">更新</button>
                        <button type="button" class="layui-btn layui-btn-sm layui-btn-danger" onclick = "delete_theme('<?php echo $key; ?>')">删除</button>
                        <?php if( $current_them == $key ) { ?>
                        <button type="button" class="layui-btn layui-btn-sm layui-btn-danger">当前</button>
                        <?php } ?>

                    </div>
                    </p>
                </fieldset>
            </div>
            <!-- 主题列表END -->
            <?php } ?>
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
            <div class="layui-col-lg3 layui-col-md6 layui-col-sm12">
                <fieldset style = "padding:1em;border:0px;height:280px;border:1px dashed #1E9FFF;box-shadow: 2px 2px 3px #888888;color:#666666">
                    <legend style = "font-size:24px;"><?php echo $key; ?> - <?php echo $theme->version ?></legend>
                    
                    <!-- 主题图片 -->
                    <div class = "screenshot"><p><img layer-src="<?php echo $theme->screenshot; ?>" src="<?php echo $theme->screenshot; ?>" alt=""></p></div>
                    <!-- 主题图片END -->
                    
                    <p>
                    <div class="layui-btn-group">
                        <button type="button" class="layui-btn layui-btn-sm" onclick = "down_theme('<?php echo $key; ?>','download')">下载</button>
                        <!-- <button type="button" class="layui-btn layui-btn-sm" onclick = "theme_detail_online('<?php echo $key; ?>')">详情</button> -->
                    </div>
                    </p>
                </fieldset>
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

layer.photos({
  photos: '#layer-photos'
  ,anim: 5 //0-6的选择，指定弹出图片动画类型，默认随机（请注意，3.0之前的版本用shift参数）
}); 
</script>