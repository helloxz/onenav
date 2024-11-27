<?php echo $transition_page['control']; ?>
<!-- API页面设置 -->
<?php require_once(dirname(__DIR__).'/header.php'); ?>
<?php include_once(dirname(__DIR__).'/left.php'); ?>
<div class="layui-body">
<!-- 内容主体区域 -->
<div class="layui-row content-body place-holder">
    <!-- 说明提示框 -->
    <div class="layui-col-lg12">
      <div class="page-msg">
        <ol>
          <li>订阅用户可以对数据库进行本地备份和回滚</li>
          <li>备份数据库仅保存最近10份数据</li>
          <li>该功能仅辅助备份使用，无法确保100%数据安全，因此定期对整个站点打包备份仍然是必要的</li>
          <li>如果您需要迁移数据，步骤为：立即备份 > 下载备份到本地 > 新安装OneNav > 上传备份 > 回滚</li>
        </ol>
      </div>
    </div>
    <!-- 说明提示框END -->
    <div class="layui-col-lg12">
      <!-- 数据表格 -->
      <table class="layui-hide" id="mytable" lay-filter="mytable"></table>
      <!-- 数据表格END -->
      <!-- 最右侧的操作选项 -->
      <script type="text/html" id="tooloption">
        <a class="layui-btn layui-btn-xs" lay-event="restore">回滚</a>
        <a class="layui-btn layui-btn-xs" lay-event="download">下载</a>
        <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
      </script>  
      <!-- 操作选项END -->

      <!-- 头部工具栏 -->
      <script type="text/html" id="toolbarheader">
        <div class="layui-btn-container">
          <button class="layui-btn layui-btn-sm" lay-event="backup">立即备份</button>
          
        </div>
      </script>
      <!-- 头部工具栏END -->

      <!-- 上传按钮 -->
      <div class="upload-backup">
        <button type="button" class="layui-btn layui-btn-sm upload-bakcup" lay-options="{accept: 'file'}">
          <i class="layui-icon layui-icon-upload"></i> 
          上传备份
        </button>
      </div>
      <!-- 上传按钮END -->

    </div>

    
</div>
</div>


<?php include_once(dirname(__DIR__).'/footer.php'); ?>

<script>
  layui.use(['table','upload'],function(){
    var table = layui.table;
    var upload = layui.upload;
    // 渲染上传
    // 渲染
    upload.render({
      elem: '.upload-bakcup', // 绑定多个元素
      url: '/index.php?c=api&method=upload_backup', // 设置上传接口
      accept: 'file', // 普通文件
      exts:'db3', // 允许的后缀
      before: function(obj){ // 选择文件后
        layer.load();
        var files = obj.pushFile();
        let file = Object.values(files)[0];
        
        // 得到文件名
        let name = file.name;
          // 正则判断文件名是否符合规范，文件名格式如：onenav_202312071528_0.9.32.db3
          let reg = /^onenav_[0-9]{12}_[0-9]{1,2}\.[0-9]{1,2}\.[0-9]{1,2}\.db3$/;
          if( !reg.test(name) ) {
            layer.msg('文件格式不正确！',{icon:5});
            // 关闭loading
            layer.closeAll('loading');
            return false;
          }

      },
      done: function(res){
        layer.msg('上传成功！',{icon:1});
        table.reload('tableid', {
          where: { //设定异步数据接口的额外参数，任意设
            aaaaaa: 'xxx'
          }
        }); 

        layer.closeAll('loading');
      },
      error: function(index, upload){
        layer.msg('上传出错！',{icon:5});
        layer.closeAll('loading');
      }
    });

    // 渲染表格
    table.render({
    elem: '#mytable'
    ,id: 'tableid'
    ,url:'/index.php?c=api&method=backup_db_list' // 此处为静态模拟数据，实际使用时需换成真实接口
    ,toolbar: '#toolbarheader'
    ,totalRow: true // 开启合计行
    ,cols: [[
      {field:'id', width:80, title: '序号'}
      ,{field:'name', title:'数据库文件名',width:300}
      ,{field:'mtime', width:80, title: '备份时间', width:240}
      ,{field:'size', width:115, title: '数据库大小'}
      ,{fixed: 'right', title:'操作', toolbar: '#tooloption'}
    ]]
    
  });
  // 渲染表格END

  // 表头工具栏
  //触发事件
  table.on('toolbar(mytable)', function(obj){
    var checkStatus = table.checkStatus(obj.config.id);
    switch(obj.event){
      case 'backup':
        $.get("/index.php?c=api&method=backup_db",function(data,status){
          if( data.code == 200 ) {
            layer.msg('备份成功！',{icon:1});
            //刷新表格
            table.reload('tableid', {
              where: { //设定异步数据接口的额外参数，任意设
                aaaaaa: 'xxx'
              }
            }); 
          }
          else{
            layer.msg(data.msg,{icon:5});
          }
        });
      break;
    };
  });
  // 表头工具栏END
  
  //单元格工具事件
  table.on('tool(mytable)', function(obj){ // 注：test 是 table 原始标签的属性 lay-filter="对应的值"
    var data = obj.data; //获得当前行数据
    var layEvent = obj.event; //获得 lay-event 对应的值（也可以是表头的 event 参数对应的值）
    var tr = obj.tr; //获得当前行 tr 的 DOM 对象（如果有的话）
  
    if(layEvent === 'restore'){ //回滚
      layer.confirm('确定回滚吗？', {icon:3,title:'提示'},function(index){
        
        $.get("/index.php?c=api&method=restore_db",{name:data.name},function(data,status){
          if(data.code == 200) {
            layer.close(index);
            layer.msg('回滚成功！',{icon:1})
            
          }
          else{
            layer.close(index);
            layer.msg(data.msg,{icon:5})
            
          }
        });
        
      });
    } 
    else if( layEvent === 'download' ) {
      var data = obj.data; //获得当前行数据
      window.location.href = "?c=api&method=down_db&name=" + data.name;
    }
    else if(layEvent === 'del'){ //删除
      layer.confirm('确定删除吗？', {icon:3,title:'提示'},function(index){
        
        $.get("/index.php?c=api&method=del_backup_db",{name:data.name},function(data,status){
          if(data.code == 200) {
            obj.del(); // 删除对应行（tr）的 DOM 结构，并更新缓存
            layer.close(index);
          }
          else{
            layer.msg(data.msg,{icon:5})
            layer.close(index);
          }
        });
        
      });
    }
  });
  //单元格工具事件END

  });
</script>