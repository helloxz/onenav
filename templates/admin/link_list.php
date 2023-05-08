<?php include_once('header.php'); ?>
<?php include_once('left.php'); ?>

<div class="layui-body">
<!-- 内容主体区域 -->
<div class="layui-row content-body place-holder">
    <!-- 表单上面的按钮 -->
    <div class="lay-col-lg12">
    <form class="layui-form layui-form-pane" action="">
    <div class="layui-form-item">
    
        <div class="layui-inline">
        <div class="layui-input-inline">
            <select name="fid" lay-verify="" lay-search id = "fid">
            <option value="">请选择一个分类</option>
            <?php foreach( $categorys AS $category ){ ?>
            <option value="<?php echo $category['id'] ?>"><?php echo $category['name']; ?></option>
            <?php } ?>
            </select>   
        </div>
        <div class="layui-input-inline" style="width: 100px;">
            <button class="layui-btn" lay-submit lay-filter="screen_link">查询此分类下的链接</button>
        </div>
        
        </div>
    </div>
    </form>
    </div>
    <!-- 表单上面的按钮END -->
    <div class="layui-col-lg12">
        <table id="link_list" lay-filter="mylink" lay-data="{id: 'mylink_reload'}"></table>
        <!-- 开启表格头部工具栏 -->
        <script type="text/html" id="linktool">
        <div class="layui-btn-container">
            <button class="layui-btn layui-btn-sm layui-btn-danger" lay-event="getCheckData">删除选中</button>
            <button class="layui-btn layui-btn-sm" lay-event="readmoredata">批量修改分类</button>
            <button class="layui-btn layui-btn-sm" lay-event="set_private">设为私有</button>
            <button class="layui-btn layui-btn-sm" lay-event="set_public">设为公有</button>
            <!-- <button class="layui-btn layui-btn-sm" lay-event="getCheckLength">获取选中数目</button>
            <button class="layui-btn layui-btn-sm" lay-event="isAll">验证是否全选</button> -->
        </div>
        </script>
        <!-- 开启表格头部工具栏END -->
    </div>
    <script type="text/html" id="link_operate">
        <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
        <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del" onclick = "">删除</a>
    </script>
    <!-- 表单下面的按钮 -->
    <button style="margin-top:16px;" class="layui-btn layui-btn-sm" lay-submit onclick = "export_link()">导出所有链接</button>
    <!-- 表单下面的按钮END -->
</div>
<!-- 内容主题区域END -->
</div>

<script>
layui.use(['table'], function(){
    var table = layui.table;

    // 编辑单行
    table.on('edit(mylink)',function(obj){
        var field = obj.field; // 得到字段
        var value = obj.value; // 得到修改后的值
        var data = obj.data; // 得到所在行所有键值

        // 获取到权重并判断是否合法
        let weight = data.weight;
        if( /^[-+]?\d*\.?\d+$/.test(weight) == false ) {
            layer.msg("权重必须为数字！",{icon:5});
            return obj.reedit();
        }
        // 获取到标题并判断是否合法
        let title = data.title.trim();
        if( title.length == 0 ) {
            layer.msg("标题不能为空！",{icon:5});
            return obj.reedit();
        }

        // 请求后端API
        $.ajax({
            url: '/index.php?c=api&method=edit_link_row',
            type: 'POST',
            data: JSON.stringify(data),
            contentType: 'application/json',
            dataType: 'json',
            success: function(response) {
                // 请求成功后执行的代码
                if( response.code == 0 ) {
                    layer.msg("已修改！",{icon:1});
                }
                else{
                    layer.msg(response.msg,{icon:5});
                }
            },
            error: function(xhr, status, error) {
                // 请求出错时执行的代码
                console.log(error);
                layer.msg("修改失败！",{icon:5});
            }
        });
    })
});
    
    
</script>
<?php include_once('footer.php'); ?>