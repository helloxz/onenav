<?php include_once('header.php'); ?>
<?php include_once('left.php'); ?>

<div class="layui-body">
<!-- 内容主体区域 -->
<div class="layui-row content-body">
    <div class="layui-col-lg12">
        <table id="link_list" lay-filter="mylink"></table>
        <!-- 开启表格头部工具栏 -->
        <script type="text/html" id="linktool">
        <div class="layui-btn-container">
            <button class="layui-btn layui-btn-sm layui-btn-danger" lay-event="getCheckData">删除选中</button>
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