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
          <li>订阅用户可以对指定分类下的书签进行分享</li>
          <li>比如：您可以将某个私有分类通过设置密码的方式分享给您的好友</li>
          <li>若密码留空，则不需要密码也能访问</li>
          <li>分享支持删除操作（浏览器全屏才能查看到）</li>
        </ol>
      </div>
    </div>
    <!-- 说明提示框END -->

    <!-- 创建分享 -->
    <div class="layui-col-lg12">
      <form class="layui-form layui-form-pane" action="">
        <div class="layui-form-item">
          <label class="layui-form-label">选择分类</label>
          <div class="layui-input-block">
            <select name="cid" lay-verify="required" lay-search="">
              <option value="">请选择要分享的分类</option>
              <?php foreach ($categorys as $category) {
                # code...
              ?>
              <option value="<?php echo $category['id'] ?>"><?php echo $category['name']; ?></option>
              <?php } ?>
            </select>
          </div>
        </div>
        <div class="layui-form-item">
          <label class="layui-form-label">过期时间</label>
          <div class="layui-input-block"> <!-- 注意：这一层元素并不是必须的 -->
            <input type="text" placeholder = "过期时间不能小于当前时间" lay-verify="required" class="layui-input" name = "expire_time" id="expire_time">
          </div>
        </div>
        <div class="layui-form-item">
          <label class="layui-form-label">设置密码</label>
          <div class="layui-input-block">
            <input type="text" id = "password" name="password" placeholder="如果留空则视为公开分享" autocomplete="off" class="layui-input">
          </div>
          
        </div>
        <div class="layui-form-item layui-form-text">
          <label class="layui-form-label">备注</label>
          <div class="layui-input-block">
            <textarea name="note" placeholder="请输入备注内容" class="layui-textarea"></textarea>
          </div>
        </div>
        <button class="layui-btn" lay-submit lay-filter="create_share">创建</button>
        <a class="layui-btn" href="javascript:;" onclick="new_pass()">更换密码</a>
        <button type="reset" class="layui-btn layui-btn-primary">重置</button>
      </form>
    </div>
    <!-- 创建分享END -->

    <div class="layui-col-lg12">
      <div style="margin-top:18px;"></div>
      <!-- 数据表格 -->
      <table class="layui-hide" id="mytable" lay-filter="mytable"></table>
      <!-- 数据表格END -->
      <!-- 最右侧的操作选项 -->
      <script type="text/html" id="tooloption">
        <a class="layui-btn layui-btn-xs" lay-event="copy_link">复制链接</a>
        <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
      </script>  
      <!-- 操作选项END -->
      <!-- 头部工具栏 -->
      <script type="text/html" id="toolbarheader">
        <div class="layui-btn-container">
          <button class="layui-btn layui-btn-sm" lay-event="share">创建分享</button>
        </div>
      </script>
      <!-- 头部工具栏END -->

      <div style="margin-bottom:18px;"></div>
    </div>
</div>
</div>


<?php include_once(dirname(__DIR__).'/footer.php'); ?>

<script>
  //页面加载时，生成一个4位的随机密码
  $(document).ready(function(){
    $("#password").val(getRandStr(4));
  });
  layui.use('laydate', function(){
  var laydate = layui.laydate;
  
    //执行一个laydate实例
    laydate.render({
      elem: '#expire_time' //指定元素
      ,type: 'datetime'
    });
  });

  //提交创建分享表单
  layui.use('form', function(){
    var form = layui.form;
    
    //提交
    form.on('submit(create_share)', function(data){

      //console.log(data.field);
      //return false;

      //return false;
      $.post("/index.php?c=api&method=create_share",data.field,function(data,status){
        if( data.code == 200 ) {
          layer.msg("成功！",{icon:1});
          //重载表格
          layui.use('table', function(){
            var table = layui.table;
            table.reload('tableid', {
              where: { //设定异步数据接口的额外参数，任意设
                aaaaaa: 'xxx'
              }
              ,page: {
                curr: 1 //重新从第 1 页开始
              }
            }); 
          });
          
        }
        else{
          layer.msg(data.msg,{icon:5});
        }
        
      });

      //阻止表单提交
      return false;

    });

    
  });

  layui.use(['table'],function(){
    var table = layui.table;
    // 渲染表格
    table.render({
    elem: '#mytable'
    ,id: 'tableid'
    ,page: true
    ,url:'/index.php?c=api&method=share_list' // 此处为静态模拟数据，实际使用时需换成真实接口
    // ,toolbar: '#toolbarheader'
    // ,totalRow: true // 开启合计行
    ,cols: [[
      {field:'id', width:80, title: 'ID'}
      ,{field:'sid', title:'SID',width:110,templet:function(d){
        let sid = d.sid;
        
        return `<a href = "/index.php?c=universal#/share/${sid}" target = "_blank" title = "点击打开">${sid}</a>`;
      }}
      ,{field:'category_name', title:'分类名称',width:200}
      ,{field:'add_time', title: '添加时间', width:240}
      ,{field:'expire_time', width:240, title: '过期时间',templet:function(d){
        let e_time = d.expire_time;
        let current_time = new Date( Date.parse(new Date()) );
        let expire_time = new Date(Date.parse(d.expire_time));

        if( current_time > expire_time ) {
          return `<span>${e_time}</span> <button class="layui-btn layui-btn-xs layui-btn-disabled">已过期</button>`;
        }
        else{
          return `<span>${e_time}</span> <button class="layui-btn layui-btn-xs">正常</button>`;
        }
      }}
      ,{field:'password', width:200, title: '密码'}
      ,{field:'note', width:200, title: '备注'}
      ,{fixed: 'right', title:'操作', toolbar: '#tooloption'}
    ]]
    
  });
  // 渲染表格END

  // 表头工具栏
  //触发事件
  table.on('toolbar(mytable)', function(obj){
    var checkStatus = table.checkStatus(obj.config.id);
    switch(obj.event){
      case 'share':
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
  
    if(layEvent === 'copy_link'){ //复制分享链接和密码
      var copy = new clipBoard(document.getElementById('mytable'), {
        beforeCopy: function() {
          
        },
        copy: function() {
           let link = window.location.href + "index.php?c=universal#/share/" + data.sid;
           link = link.replace('index.php?c=admin&page=setting/share','');
           let password = data.password;
           layer.msg("分享链接已复制！",{icon:1});
           return `链接：${link} 密码：${password}`;
        },
        afterCopy: function() {

        }
      });
    } 
    else if(layEvent === 'del'){ //删除
      layer.confirm('确定删除吗？', {icon:3,title:'提示'},function(index){
        
        $.get("/index.php?c=api&method=del_share&id=" + data.id,function(data,status){
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
  //更换一个新的随机密码
  function new_pass(){
    $("#password").val(getRandStr(4));
    return false;
  }
</script>