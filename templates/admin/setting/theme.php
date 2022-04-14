<!-- 主题设置 -->
<?php require_once(dirname(__DIR__).'/header.php'); ?>
<?php include_once(dirname(__DIR__).'/left.php'); ?>
<div class="layui-body">
<!-- 内容主体区域 -->
<div class="layui-row content-body">
    <div class="layui-col-lg12">
        <div class="layui-row layui-col-space24">
            <?php foreach ($themes as $key => $theme) {
                //var_dump($theme['info']->name);
            ?>
            <!-- 主题列表 -->
            <div class="layui-col-lg2">
                <fieldset style = "padding:1em;border:0px;height:180px;background-color:#EEEEEE;box-shadow: 2px 2px 3px #888888;color:#666666">
                    <legend style = "font-size:38px;"><?php echo $key; ?></legend>
                    <p><h1><?php echo $theme['info']->name ?></h1></p>
                    <p>版本：<?php echo $theme['info']->version ?></p>
                    <p>更新时间：<?php echo $theme['info']->update ?></p>
                    <br />
                    <p>
                    <div class="layui-btn-group">
                        <button type="button" class="layui-btn layui-btn-sm" onclick = "set_theme('<?php echo $key; ?>')">使用</button>
                        <button type="button" class="layui-btn layui-btn-sm" onclick = "theme_detail('<?php echo $key; ?>')">详情</button>
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

function set_theme(name) {
    $.post("/index.php?c=api&method=set_theme",{key:"theme",value:name},function(data,status){
        if( data.code == 0 ) {
            layer.msg(data.data, {icon: 1});
            setTimeout(() => {
                location.reload();
            }, 2000);
        }
        else{
            layer.msg(data.data, {icon: 5});
        }
    });
}
</script>