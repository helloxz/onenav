<?php include_once('header.php'); ?>
<?php include_once('left.php'); ?>

<div class="layui-body">
<!-- 内容主体区域 -->
<div class="layui-row content-body">
    <div class="layui-col-lg12">
        <table id="category_list" lay-filter="mycategory"></table>
    </div>
    <script type="text/html" id="nav_operate">
        <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
        <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del" onclick = "">删除</a>
    </script>
</div>
<!-- 内容主题区域END -->
</div>
  
<?php include_once('footer.php'); ?>