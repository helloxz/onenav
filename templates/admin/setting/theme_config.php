<!-- 主题详情页面 -->
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <title>OneNav后台管理</title>
  <link rel='stylesheet' href='static/layui/css/layui.css'>
  <link rel='stylesheet' href='templates/admin/static/style.css?v=v0.9.17-20220314'>
</head>
<body class="layui-fluid">
    <div class="layui-row" style = "margin-top:1em;">
        <!-- 说明提示框 -->
    <div class="layui-col-lg12">
      <div class="setting-msg">
      主题自定义参数设置，请参考：<a href="https://dwz.ovh/gnae4" target = "_blank" title = "主题参数设置说明">https://dwz.ovh/gnae4</a>，如果您不清楚，请勿修改。
      </div>
    </div>
    <!-- 说明提示框END -->
        <div class="layui-col-sm10 layui-col-sm-offset1">
    <form class="layui-form layui-form-pane">
  <div class="layui-form-item">
    <label class="layui-form-label" style = "width:35%;">主题名称</label>
    <div class="layui-input-inline" style = "width:63%;">
      <input type="text" name="name" required  lay-verify="required" value = "<?php echo $name; ?>" readonly="readonly" class="layui-input">
    </div>
  </div>
<!-- 遍历配置选项 -->
  <?php foreach ($configs as $key => $config) {
      //如果config.json获取到的数据是空的，则读取info.json
      $value = empty( $current_configs->$key ) ? $config : $current_configs->$key;
  ?>
  <div class="layui-form-item">
    <label class="layui-form-label" style = "width:35%;"><?php echo $key; ?></label>
    <div class="layui-input-inline" style = "width:63%;">
      <input type="text" name="<?php echo $key; ?>" value = "<?php echo $value; ?>" class="layui-input">
    </div>
  </div>
  <?php } ?>
  <!-- 遍历配置选项END -->
  <div class="layui-form-item">
      <button class="layui-btn" lay-submit lay-filter="save_theme_config">保存</button>
  </div>
</form>
        </div>
    </div>
<script src="static/js/jquery.min.js"></script>
<script src="static/layui/layui.js"></script>
<script>
layui.use(['layer','form'], function(){
    var layer = layui.layer;
    var form = layui.form;

    form.on('submit(save_theme_config)', function(data){
        console.log(data.field);
        $.post("/index.php?c=api&method=save_theme_config",data.field,function(data,status){
            if( data.data == 'success') {
                layer.msg("设置已更新！",{icon:1});
            }
            else{
                layer.msg(data.err_msg,{icon:5});
            }
            
        });
        return false;
    });
});

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
</body>
</html>