<!-- 主题设置 -->
<?php require_once(dirname(__DIR__).'/header.php'); ?>
<?php include_once(dirname(__DIR__).'/left.php'); ?>
<div class="layui-body">
<!-- 内容主体区域 -->
<div class="layui-row content-body place-holder">
    <!-- 说明提示框 -->
    <div class="layui-col-lg12">
      <div class="setting-msg">
      主题更换及设置说明，请参考：<a href="https://dwz.ovh/yoyaf" target = "_blank" title = "主题更换及设置说明">https://dwz.ovh/yoyaf</a>
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
                    <div class = "screenshot"><p><img src="<?php echo $theme['info']->screenshot; ?>" alt=""></p></div>
                    <!-- 主题图片END -->
                    
                    <p>
                    <div class="layui-btn-group">
                        <button type="button" class="layui-btn layui-btn-sm" onclick = "set_theme('<?php echo $key; ?>')">使用</button>
                        <button type="button" class="layui-btn layui-btn-sm" onclick = "theme_detail('<?php echo $key; ?>')">详情</button>
                        <button type="button" class="layui-btn layui-btn-sm" onclick = "theme_config('<?php echo $key; ?>')">参数设置</button>
                        <button type="button" class="layui-btn layui-btn-sm layui-btn-danger" onclick = "delete_theme('<?php echo $key; ?>')">删除</button>
                        <?php if( $current_them == $key ) { ?>
                        <button type="button" class="layui-btn layui-btn-sm layui-btn-danger">当前主题</button>
                        <?php } ?>

                    </div>
                    </p>
                </fieldset>
            </div>
            <!-- 主题列表END -->
            <?php } ?>
        </div>
    </div>
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
</script>