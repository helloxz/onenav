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
    </div>
    </form>
    <!-- 表单上面的按钮END -->
    <div class="layui-col-lg12">
        <table id="link_list" lay-filter="mylink" lay-data="{id: 'mylink_reload'}"></table>
        <!-- 开启表格头部工具栏 -->
        <script type="text/html" id="linktool">
        <div class="layui-btn-container">
            <button class="layui-btn layui-btn-sm layui-btn-danger" lay-event="getCheckData">删除选中</button>
            <button class="layui-btn layui-btn-sm" lay-event="readmoredata">批量修改分类</button>
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
</div>
<!-- 内容主题区域END -->
</div>
  
<?php include_once('footer.php'); ?>