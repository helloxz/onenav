// 2022014
layui.use(['element','table','layer','form','upload'], function(){
    var element = layui.element;
    var table = layui.table;
    var form = layui.form;
    var upload = layui.upload;
    layer = layui.layer;

    //第一个实例
  table.render({
    elem: '#category_list'
    ,height: 500
    ,url: 'index.php?c=api&method=category_list' //数据接口
    ,page: true //开启分页
    ,cols: [[ //表头
      {field: 'id', title: 'ID', width:80, sort: true, fixed: 'left'}
      ,{field: 'name', title: '分类名称', width:160}
      ,{field: 'fname', title: '父级分类', width:160}
      ,{field: 'add_time', title: '添加时间', width:160, sort: true,templet:function(d){
        var add_time = timestampToTime(d.add_time);
        return add_time;
      }}
      ,{field: 'up_time', title: '修改时间', width:160,templet:function(d){
          if(d.up_time != ''){
            var up_time = timestampToTime(d.up_time);
            return up_time;
          }
          else{
              return '';
          }
          
      }} 
      ,{field: 'weight', title: '权重', width: 100}
      ,{field: 'property', title: '是否私有', width: 120, sort: true,templet: function(d){
            if(d.property == 1) {
                return '<button type="button" class="layui-btn layui-btn-xs">是</button>';
            }
            else {
                return '<button type="button" class="layui-btn layui-btn-xs layui-btn-danger">否</button>';
            }
      }}
      ,{field: 'description', title: '描述'}
      ,{fixed: 'right', title:'操作', toolbar: '#nav_operate', width:150}
    ]]
  });

  //监听行工具事件
  table.on('tool(mycategory)', function(obj){
    var data = obj.data;
    //console.log(obj);
    //console.log(obj)
    if(obj.event === 'del'){
      layer.confirm('确认删除？',{icon: 3, title:'温馨提示！'}, function(index){
        $.post('/index.php?c=api&method=del_category',{'id':obj.data.id},function(data,status){
            
            if(data.code == 0){
                obj.del();
            }
            else{
                layer.msg(data.err_msg);
            }
        });
        layer.close(index);
      });
    } else if(obj.event === 'edit'){
      window.location.href = '/index.php?c=admin&page=edit_category&id=' + obj.data.id;
    }
  });
  //渲染链接列表
  table.render({
    elem: '#link_list'
    ,height: 520
    ,url: 'index.php?c=api&method=link_list' //数据接口
    ,method: 'post'
    ,page: true //开启分页
    ,toolbar: '#linktool'
    ,cols: [[ //表头
      {type:'checkbox'} //开启复选框
      ,{field: 'id', title: 'ID', width:80, sort: true}
      // ,{field: 'fid', title: '分类ID',sort:true, width:90}
      ,{field: 'category_name', title: '所属分类',sort:true,width:120}
      ,{field: 'url', title: 'URL',width:140,templet:function(d){
        var url = '<a target = "_blank" href = "' + d.url + '" title = "' + d.url + '">' + d.url + '</a>';
        return url;
      }}
      ,{field: 'title', title: '链接标题', width:140}
      ,{field: 'add_time', title: '添加时间', width:148, sort: true,templet:function(d){
        var add_time = timestampToTime(d.add_time);
        return add_time;
      }}
      ,{field: 'up_time', title: '修改时间', width:148,sort:true,templet:function(d){
          if(d.up_time == null){
            return '';
          }
          else{
              var up_time = timestampToTime(d.up_time);
              return up_time;
          }
          
      }} 
      ,{field: 'weight', title: '权重', width: 75,sort:true}
      ,{field: 'property', title: '私有', width: 80, sort: true,templet: function(d){
            if(d.property == 1) {
                return '<button type="button" class="layui-btn layui-btn-xs">是</button>';
            }
            else {
                return '<button type="button" class="layui-btn layui-btn-xs layui-btn-danger">否</button>';
            }
      }}
      ,{field: 'click', title: '点击数',width:90,sort:true}
      ,{fixed: 'right', title:'操作', toolbar: '#link_operate'}
    ]]
  });

  //头链接工具栏事件
  table.on('toolbar(mylink)', function(obj){
    var checkStatus = table.checkStatus(obj.config.id);
    switch(obj.event){
      case 'getCheckData':
        var data = checkStatus.data;
        
        if( data.length == 0 ) {
          layer.msg('未选中任何数据！');
        }
        //遍历删除数据
        else{
          layer.confirm('确认删除选中数据？',{icon: 3, title:'温馨提示！'}, function(index){
            for (let i = 0; i < data.length; i++) {
              // $.post('/index.php?c=api&method=del_link',{'id':data[i].id},function(data,status){
              //   if(data.code == 0){
                  
              //   }
              //   else{
              //       layer.msg(data.err_msg);
              //   }
              // });
              $.ajax({
                'url': '/index.php?c=api&method=del_link',
                'type': 'POST',
                'async': false,
                'data':{'id':data[i].id}
              });
              
            }
            layer.open({
              title: '温馨提醒'
              ,content: '选中数据已删除！',
              yes: function(index, layero){
                window.location.reload();
                layer.close(index); //如果设定了yes回调，需进行手工关闭
              }
            });
            
          });
        }
        //console.log(data[0].id);
        //刷新当前页面
        //window.location.reload();
      break;
      case 'readmoredata':
        var data = checkStatus.data;
        fidtext = $("#fid option:selected").text();
        fid = $("#fid").val();
        fid = parseInt(fid);
        if( data.length == 0 ) {
          layer.msg('未选中任何数据！');
          return false;
        }
        
        if ( isNaN(fid) === true ){
          layer.msg('请先选择分类！',{icon:5});
        }
        else{
          
          layer.confirm('确认将选中链接的分类修改为【' + fidtext + '】?',{icon: 3, title:'温馨提示！'}, function(index){
            id = [];
            for(let i = 0;i < data.length;i++) {
              id.push(data[i].id);
            }
            
            $.post("/index.php?c=api&method=batch_modify_category",{id:id,fid:fid},function(data,status){
                if (data.msg === "success") {
                  layer.msg("修改成功！",{icon:1});
                  setTimeout(() => {
                    window.location.reload();
                  }, 2000);
                }
                else{
                  layer.msg(data.err_msg,{icon:5});
                }
            });
          });
        }
        //console.log(data);
      break;
      case "set_private":
        //用户点击设为私有按钮
        var data = checkStatus.data;
        ids = [];
        //获取链接所有ID，并拼接为数组
        for(let i = 0;i < data.length;i++) {
          ids.push(data[i].id);
        }
        //调用函数设为私有
        set_link_attribute(ids,1);
        break;
      case "set_public":
        //用户点击设为私有按钮
        var data = checkStatus.data;
        ids = [];
        //获取链接所有ID，并拼接为数组
        for(let i = 0;i < data.length;i++) {
          ids.push(data[i].id);
        }
        //调用函数设为公有
        set_link_attribute(ids,0);
        break;
      case 'isAll':
        layer.msg(checkStatus.isAll ? '全选': '未全选');
      break;
      
      //自定义头工具栏右侧图标 - 提示
      case 'LAYTABLE_TIPS':
        layer.alert('这是工具栏右侧自定义的一个图标按钮');
      break;
    };
  });
  //监听链接工具
  table.on('tool(mylink)', function(obj){
    var data = obj.data;
    //console.log(obj);
    //console.log(obj)
    if(obj.event === 'del'){
      layer.confirm('确认删除？',{icon: 3, title:'温馨提示！'}, function(index){
        $.post('/index.php?c=api&method=del_link',{'id':obj.data.id},function(data,status){
            if(data.code == 0){
                obj.del();
            }
            else{
                layer.msg(data.err_msg);
            }
        });
        layer.close(index);
      });
    } else if(obj.event === 'edit'){
      window.location.href = '/index.php?c=admin&page=edit_link&id=' + obj.data.id;
    }
  });

  //登录
  form.on('submit(login)', function(data){
    $.post('/index.php?c=login&check=login',data.field,function(data,status){
      //如果添加成功
      if(data.code == 0) {
        window.location.href = '/index.php?c=admin';
      }
      else{
        layer.msg(data.err_msg, {icon: 5});
      }
    });
    console.log(data.field) //当前容器的全部表单字段，名值对形式：{name: value}
    return false; //阻止表单跳转。如果需要表单跳转，去掉这段即可。
  });

  //初始化设置onenav密码
  form.on('submit(init_onenav)', function(data){
    console.log(data.field.username);
    
    let username = data.field.username;
    let password = data.field.password;
    let password2 = data.field.password2;
    //正则验证用户名、密码
    var u_patt = /^[0-9a-z]{3,32}$/;
    if ( !u_patt.test(username) ) {
      layer.msg("用户名需要3-32位的字母或数字组合！", {icon: 5});
      return false;
    }
    //正则验证密码
    let p_patt = /^[0-9a-zA-Z!@#$%^&*.()]{6,16}$/;
    if ( !p_patt.test(password) ) {
      layer.msg("密码需要6-16字母、数字或特殊字符！", {icon: 5});
      return false;
    }
    if( password !== password2) {
      layer.msg("两次密码不一致！", {icon: 5});
      return false;
    }
    $.post('/index.php?c=init',data.field,function(data,status){
      //如果添加成功
      if(data.code == 200) {
        layer.msg(data.msg, {icon: 1});
        setTimeout(() => {
          window.location.href = "/index.php?c=login";
        }, 2000);
      }
      else{
        layer.msg(data.err_msg, {icon: 5});
      }
    });
    //console.log(data.field) //当前容器的全部表单字段，名值对形式：{name: value}
    return false; //阻止表单跳转。如果需要表单跳转，去掉这段即可。
  });
  //手机登录
  form.on('submit(mobile_login)', function(data){
    $.post('/index.php?c=login&check=login',data.field,function(data,status){
      //如果登录成功
      if(data.code == 0) {
        window.location.href = '/';
      }
      else{
        layer.msg(data.err_msg, {icon: 5});
      }
    });
    console.log(data.field) //当前容器的全部表单字段，名值对形式：{name: value}
    return false; //阻止表单跳转。如果需要表单跳转，去掉这段即可。
  });

  //筛选链接
  form.on('submit(screen_link)', function(data){
    fid = data.field.fid;
    if( fid == "" ) {
      layer.msg("请先选择分类！",{icon:5});
      return false;
    }
    //表格重载
    var tableIns = table.render({
      elem: '#link_list'
      ,height: 520
      ,url: 'index.php?c=api&method=link_list' //数据接口
      ,method: 'post'
      ,page: true //开启分页
      ,toolbar: '#linktool'
      ,where:{
        category_id:fid
      }
      ,cols: [[ //表头
        {type:'checkbox'} //开启复选框
        ,{field: 'id', title: 'ID', width:80, sort: true}
        // ,{field: 'fid', title: '分类ID',sort:true, width:90}
        ,{field: 'category_name', title: '所属分类',sort:true,width:120}
        ,{field: 'url', title: 'URL',width:140,templet:function(d){
          var url = '<a target = "_blank" href = "' + d.url + '" title = "' + d.url + '">' + d.url + '</a>';
          return url;
        }}
        ,{field: 'title', title: '链接标题', width:140}
        ,{field: 'add_time', title: '添加时间', width:148, sort: true,templet:function(d){
          var add_time = timestampToTime(d.add_time);
          return add_time;
        }}
        ,{field: 'up_time', title: '修改时间', width:148,sort:true,templet:function(d){
            if(d.up_time == null){
              return '';
            }
            else{
                var up_time = timestampToTime(d.up_time);
                return up_time;
            }
            
        }} 
        ,{field: 'weight', title: '权重', width: 75,sort:true}
        ,{field: 'property', title: '私有', width: 80, sort: true,templet: function(d){
              if(d.property == 1) {
                  return '<button type="button" class="layui-btn layui-btn-xs">是</button>';
              }
              else {
                  return '<button type="button" class="layui-btn layui-btn-xs layui-btn-danger">否</button>';
              }
        }}
        ,{field: 'click', title: '点击数',width:90,sort:true}
        ,{fixed: 'right', title:'操作', toolbar: '#link_operate'}
      ]]
    });

    //console.log(data.field) //当前容器的全部表单字段，名值对形式：{name: value}
    return false; //阻止表单跳转。如果需要表单跳转，去掉这段即可。
  });

  //保存站点设置
  form.on('submit(set_site)', function(data){
    $.post('/index.php?c=api&method=set_site',data.field,function(data,status){
      if(data.code == 0) {
        layer.msg(data.data, {icon: 1});
      }
      else{
        layer.msg(data.err_msg, {icon: 5});
      }
    });
    console.log(data.field) //当前容器的全部表单字段，名值对形式：{name: value}
    return false; //阻止表单跳转。如果需要表单跳转，去掉这段即可。
  });

   //保存站点设置
   form.on('submit(set_transition_page)', function(data){
    $.post('/index.php?c=api&method=set_transition_page',data.field,function(data,status){
      if(data.code == 0) {
        layer.msg(data.data, {icon: 1});
      }
      else{
        layer.msg(data.err_msg, {icon: 5});
      }
    });
    console.log(data.field) //当前容器的全部表单字段，名值对形式：{name: value}
    return false; //阻止表单跳转。如果需要表单跳转，去掉这段即可。
  });

  //添加分类目录
  form.on('submit(add_category)', function(data){
    $.post('/index.php?c=api&method=add_category',data.field,function(data,status){
      //如果添加成功
      if(data.code == 0) {
        layer.msg('已添加！', {icon: 1});
      }
      else{
        layer.msg(data.err_msg, {icon: 5});
      }
    });
    console.log(data.field) //当前容器的全部表单字段，名值对形式：{name: value}
    return false; //阻止表单跳转。如果需要表单跳转，去掉这段即可。
  });
  //添加自定义js
  form.on('submit(add_js)', function(data){
    $.post('/index.php?c=api&method=add_js',data.field,function(data,status){
      //如果添加成功
      if(data.code == 0) {
        layer.msg('已添加！', {icon: 1});
      }
      else{
        layer.msg(data.err_msg, {icon: 5});
      }
    });
    //console.log(data.field) //当前容器的全部表单字段，名值对形式：{name: value}
    return false; //阻止表单跳转。如果需要表单跳转，去掉这段即可。
  });
  //修改分类目录
  form.on('submit(edit_category)', function(data){
    $.post('/index.php?c=api&method=edit_category',data.field,function(data,status){
      //如果添加成功
      if(data.code == 0) {
        layer.msg('已修改！', {icon: 1});
      }
      else{
        layer.msg(data.err_msg, {icon: 5});
      }
    });
    console.log(data.field) //当前容器的全部表单字段，名值对形式：{name: value}
    return false; //阻止表单跳转。如果需要表单跳转，去掉这段即可。
  });

  //生成token
  form.on('submit(create_sk)', function(data){
    if( data.field.SecretKey == '' ) {
      $.post('/index.php?c=api&method=create_sk',data.field,function(data,status){
        //如果添加成功
        if(data.code == 0) {
          $("#SecretKey").val(data.data);
          layer.msg('SecretKey生成完毕！', {icon: 1});
        }
        else{
          layer.msg(data.err_msg, {icon: 5});
        }
      });
    }
    else{
      layer.msg('SecretKey已经存在！', {icon: 5});
    }
    
    //console.log(data.field) //当前容器的全部表单字段，名值对形式：{name: value}
    return false; //阻止表单跳转。如果需要表单跳转，去掉这段即可。
  });

  //更换token
  form.on('submit(change_sk)', function(data){
    if( data.field.SecretKey != '' ) {
      $.post('/index.php?c=api&method=create_sk',data.field,function(data,status){
        //如果添加成功
        if(data.code == 0) {
          $("#SecretKey").val(data.data);
          layer.msg('SecretKey已更换！', {icon: 1});
        }
        else{
          layer.msg(data.err_msg, {icon: 5});
        }
      });
    }
    else{
      layer.msg('请先生成SecretKey！', {icon: 5});
    }
    
    //console.log(data.field) //当前容器的全部表单字段，名值对形式：{name: value}
    return false; //阻止表单跳转。如果需要表单跳转，去掉这段即可。
  });

  //计算token
  form.on('submit(cal_token)', function(data){
    if( (data.field.SecretKey != '') && (data.field.username != '' ) ) {
      let username = data.field.username;
      let sk = data.field.SecretKey;
      let token = md5(username + sk);
      $("#token").val(token);
      layer.msg('token计算成功！', {icon: 1});
    }
    else{
      layer.msg('SecretKey为空，请先生成！', {icon: 5});
    }
    
    //console.log(data.field) //当前容器的全部表单字段，名值对形式：{name: value}
    return false; //阻止表单跳转。如果需要表单跳转，去掉这段即可。
  });

  //添加链接
  form.on('submit(add_link)', function(data){
    $.post('/index.php?c=api&method=add_link',data.field,function(data,status){
      //如果添加成功
      if(data.code == 0) {
        layer.msg('已添加！', {icon: 1});
      }
      else{
        layer.msg(data.err_msg, {icon: 5});
      }
    });
    console.log(data.field) //当前容器的全部表单字段，名值对形式：{name: value}
    return false; //阻止表单跳转。如果需要表单跳转，去掉这段即可。
  });
  //识别链接信息
  form.on('submit(get_link_info)', function(data){
    $.post('/index.php?c=api&method=get_link_info',data.field.url,function(data,status){
      //如果添加成功
      if(data.code == 0) {
        console.log(data);
      }
      else{
        layer.msg(data.err_msg, {icon: 5});
      }
    });
    console.log(data.field) //当前容器的全部表单字段，名值对形式：{name: value}
    return false; //阻止表单跳转。如果需要表单跳转，去掉这段即可。
  });
  //更新链接
  form.on('submit(edit_link)', function(data){
    $.post('/index.php?c=api&method=edit_link',data.field,function(data,status){
      //如果添加成功
      if(data.code == 0) {
        layer.msg('已更新！', {icon: 1});
      }
      else{
        layer.msg(data.err_msg, {icon: 5});
      }
    });
    console.log(data.field) //当前容器的全部表单字段，名值对形式：{name: value}
    return false; //阻止表单跳转。如果需要表单跳转，去掉这段即可。
  });
  //识别链接信息
  form.on('submit(get_link_info)', function(data){
    //是用ajax异步加载
    $.post('/index.php?c=api&method=get_link_info',data.field,function(data,status){
      //如果添加成功
      if(data.code == 0) {
        console.log(data);
      }
      else{
        layer.msg(data.err_msg, {icon: 5});
      }
    });
    console.log(data.field) //当前容器的全部表单字段，名值对形式：{name: value}
    return false; //阻止表单跳转。如果需要表单跳转，去掉这段即可。
  });
  //导入书签
  //识别链接信息
  form.on('submit(imp_link)', function(data){
    //用ajax异步加载
    $.post('/index.php?c=api&method=import_link',data.field,function(data,status){
      //如果添加成功
      if(data.code == 200) {
        layer.open({
          title: '导入完成'
          ,content: "总数:" + data.msg.count + " 成功:" + data.msg.success + " 失败:" + data.msg.failed
        });
        //layer.msg('已添加！', {icon: 1});
      }
      else{
        layer.msg(data.err_msg, {icon: 5});
      }
    });
    console.log(data.field) //当前容器的全部表单字段，名值对形式：{name: value}
    return false; //阻止表单跳转。如果需要表单跳转，去掉这段即可。
  });
  
  //书签上传
  //执行实例
  upload.render({
    elem: '#up_html' //绑定元素
    ,url: 'index.php?c=api&method=upload' //上传接口
    ,accept:'file'
    ,exts: 'html|HTML'
    ,done: function(res){
      //console.log(res);
      //上传完毕回调
      if( res.code == 0 ) {
        $("#filename").val(res.file_name);
      }
      else if( res.code < 0) {
        layer.msg(res.err_msg, {icon: 5});
        layer.close();
      }
      
    }
    ,error: function(){
      //请求异常回调
    }
  });

});

function get_link_info() {
    var url = $("#url").val();
    var index = layer.load(1);
    $.post('/index.php?c=api&method=get_link_info',{url:url},function(data,status){
      //如果添加成功
      if(data.code == 0) {
        if(data.data.title != null) {
          $("#title").val(data.data.title);
        }
        if(data.data.description != null) {
          $("#description").val(data.data.description);
        }
        
        layer.close(index);
      }
      else{
        layer.msg(data.err_msg, {icon: 5});
        layer.close(index);
      }
    });
}

function  timestampToTime(timestamp) {
    var  date =  new  Date(timestamp * 1000); //时间戳为10位需*1000，时间戳为13位的话不需乘1000
    Y = date.getFullYear() +  '-' ;
    M = (date.getMonth()+1 < 10 ?  '0' +(date.getMonth()+1) : date.getMonth()+1) +  '-' ;
    D = date.getDate() +  ' ' ;
    h = date.getHours() +  ':' ;
    m = date.getMinutes();
    s = date.getSeconds();
    return  Y+M+D+h+m;
}

function del_category(id){
	layer.confirm('确认删除这张图片？', {icon: 3, title:'温馨提示！'}, function(index){
        $.post("/set/del_img",{imgid:imgid,path:path,thumbnail_path:thumbnail_path},function(data,status){
			var re = JSON.parse(data);
            if(re.code == 200) {
                $("#img"+id).remove();
                console.log("#img"+id);
            }
            else{
                layer.msg(data);
            }
        });
    
    layer.close(index);
    });
}

//弱密码检查
function check_weak_password(){
  $.get("/index.php?c=api&method=check_weak_password",function(data,status){
    if (data.err_msg === 'Weak password!') {
      layui.use('layer', function(){
        var layer = layui.layer;
        
        layer.open({
          title:'风险提示！',
          content: '系统检测到您使用的默认密码，请参考<a href = "https://dwz.ovh/ze1ts" target = "_blank" style = "color:#01AAED;">帮助文档</a>尽快修改！' //这里content是一个普通的String
        });
      });   
    }
  });
}
//检测数据库是否可能被下载
function check_db_down(){
  $("#console_log").append("检查数据库是否可被下载...\n");
  $.ajax({
    type:"HEAD",
    async:false,
    url:"/data/onenav.db3",
    statusCode: {
      200: function() {
        $("#console_log").append("危险！！！危险！！！危险！！！数据库可被下载，请尽快参考帮助文档：https://dwz.ovh/jvr2t 加固安全设置！\n\n");
      },
      403:function() {
        $("#console_log").append("您的数据库看起来是安全的！\n\n");
      }
    }
  });
}


//获取待更新数据库列表,http://onenav.com/index.php?c=api&method=exe_sql&name=on_db_logs.sql
function get_sql_update_list() {
  $("#console_log").append("正在检查数据库更新...\n");
  $.get("index.php?c=api&method=get_sql_update_list",function(data,status){

    if ( data.code == 0 ) {
      //如果没有可用更新，直接结束
      if ( data.data.length == 0 ) {
        $("#console_log").append("当前无可用更新！\n");
        return false;
      }
      else{
        $("#console_log").append("检查到可更新SQL列表：\n");
        $("#console_log").append("正在准备更新...\n");
        for(i in data.data) {
          sqlname = data.data[i];
          //$("#console_log").append(data.data[i] + "\n");
          exe_sql(sqlname);
        }
      }
    }
  });
}

//更新SQL函数
function exe_sql(sqlname) {
  $.ajax({ url: "index.php?c=api&method=exe_sql&name=" + sqlname, async:false, success: function(data,status){
    if( data.code == 0 ){
      $("#console_log").append(data.data + "\n" );
    }
    else {
      $("#console_log").append(sqlname + "更新失败！\n");
    }
  }});
}

//获取GET参数，参考：https://www.runoob.com/w3cnote/js-get-url-param.html
function getQueryVariable(variable)
{
  var query = window.location.search.substring(1);
  var vars = query.split("&");
  for (var i=0;i<vars.length;i++) {
          var pair = vars[i].split("=");
          if(pair[0] == variable){return pair[1];}
  }
  return(false);
}

//获取最新版本
function get_latest_version(){
    $.post("/index.php?c=api&method=get_latest_version",function(data,status){
        //console.log(data.data);
        $("#getting").hide();
        
        //获取最新版本
        let latest_version = data.data;
        $("#latest_version").text(latest_version);

        //获取当前版本
        let current_version = $("#current_version").text();

        let pattern = /[0-9]+\.[0-9\.]+/;
        current_version = pattern.exec(current_version)[0];
        latest_version = pattern.exec(latest_version)[0];

        //如果当前版本小于最新版本，则提示更新
        if( current_version < latest_version ) {
          $("#update_msg").show();
        }
    });
    
}

//设置链接属性，公有或私有,接收一个链接id数组和一个链接属性
function set_link_attribute(ids,property) {
    if( ids.length === 0 ) {
      layer.msg("请先选择链接!",{icon:5});
    }
    else{
      $.post("/index.php?c=api&method=set_link_attribute",{ids:ids,property:property},function(data,status){
        if( data.code == 200 ){
          layer.msg("设置已更新！",{icon:1});
        }
        else{
            layer.msg("设置失败！",{icon:5});
        }
      });
    }
}

//导出所有链接
function export_link(url, fileName) {
  layer.confirm('导出的链接可以导入到浏览器也可以再次导入到OneNav！', {icon: 3, title:'确定导出所有链接？'}, function(index){
    var date = new Date();
  var current_time = date.toLocaleDateString();
  current_time = current_time.replaceAll("/",".");
  var url = "index.php?c=api&method=export_link";
  var fileName = "OneNav_Export_" + current_time + ".html";
  var x = new XMLHttpRequest();
  x.open("GET", url, true);
  x.responseType = 'blob';
  x.onload=function(e) {
      var url = window.URL.createObjectURL(x.response)
      var a = document.createElement('a');
      a.href = url
      a.download = fileName;
      a.click()
  }
  x.send();
    
    layer.close(index);
  });
  
}