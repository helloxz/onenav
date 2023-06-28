<?php include_once('header.php'); ?>
<?php include_once('left.php'); ?>

<div class="layui-body">
<!-- 内容主体区域 -->
<div class="layui-row content-body place-holder">
    <!-- 说明提示框 -->
    <div class="layui-col-lg12">
      <div class="setting-msg">
        <p>1. 注意：当分类下存在链接时，此分类不允许删除，如果需要删除分类请先前往【<a href = "/index.php?c=admin&page=link_list">我的链接</a>】删除此分类下的所有链接后再操作！</p>
      </div>
    </div>
    <!-- 说明提示框END -->
    <div class="layui-col-lg12">
        <table id="category_list" lay-filter="mycategory"></table>
    </div>
    <script type="text/html" id="nav_operate">
        <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
        <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del" onclick = "">删除</a>
    </script>

    <!-- 表头工具栏 -->
    <script type="text/html" id="catToolbar">
    <div class="layui-btn-container">
        <button class="layui-btn layui-btn-sm" lay-event="setPrivate">设为私有</button>
        <button class="layui-btn layui-btn-sm" lay-event="setPublic">设为公开</button>
    </div>
    </script>
    <!-- 表头工具栏END -->
</div>
<!-- 内容主题区域END -->
</div>
  
<?php include_once('footer.php'); ?>

<script>
layui.use(['table','layer','form'], function(){
    var table = layui.table;
    var form = layui.form;
    layer = layui.layer;

    // 表头工具栏事件
    table.on('toolbar(mycategory)', function(obj){
        var id = obj.config.id;
        var checkStatus = table.checkStatus(id);
        var othis = lay(this);
        var data = checkStatus.data;
        var ids = [];
        data.map(function(value,index){
            ids.push(value.id);
        });

        switch(obj.event){
        case 'setPrivate':
            // 设为私有,1
            set_cat_batch(ids,1);
        break;
        case 'setPublic':
            // 设为公开，0
            set_cat_batch(ids,0);
        break;
        };
    });
});

//设置分类属性，
function set_cat_batch(ids,property) {
    if( ids.length === 0 ) {
      layer.msg("请先选择分类!",{icon:5});
    }
    else{
      $.post("/index.php?c=api&method=set_cat_batch",{ids:ids,property:property},function(data,status){
        if( data.code == 200 ){
            layui.use(function(){
                var table = layui.table;
                table.reloadData('category_list', {
                    where: {
                        abc: '123456',
                    },
                    scrollPos: 'fixed',  // 保持滚动条位置不变 - v2.7.3 新增
                });
            });
            
          layer.msg("设置已更新！",{icon:1});
        }
        else{
            layer.msg("设置失败！",{icon:5});
        }
      });
    }
}
</script>