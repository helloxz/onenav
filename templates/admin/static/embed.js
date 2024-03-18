layui.config({
  base: './static/module/'
}).extend({
  iconHhysFa: 'iconHhys/iconHhysFa'
});



/**
 * 随机生成字符串
 * 参考：https://blog.csdn.net/jiciqiang/article/details/121915750
 * @param len 指定生成字符串长度
 */
 function getRandomString(len){
  let _charStr = 'abacdefghjklmnopqrstuvwxyzABCDEFGHJKLMNOPQRSTUVWXYZ0123456789',
      min = 0, 
      max = _charStr.length-1, 
      _str = '';                    //定义随机字符串 变量
  //判断是否指定长度，否则默认长度为15
  len = len || 15;
  //循环生成字符串
  for(var i = 0, index; i < len; i++){
      index = (function(randomIndexFunc, i){         
                  return randomIndexFunc(min, max, i, randomIndexFunc);
              })(function(min, max, i, _self){
                  let indexTemp = Math.floor(Math.random()*(max-min+1)+min),
                      numStart = _charStr.length - 10;
                  if(i==0&&indexTemp >=numStart){
                      indexTemp = _self(min, max, i, _self);
                  }
                  return indexTemp ;
              }, i);
      _str += _charStr[index];
  }
  return _str;
}

//生成6位随机数并存储到sessionStorage
function set_icon_name(){
  sessionStorage.icon_name = getRandomString(6);
}

//获取icon名称
function get_icon_name(){
  let icon_name;
  //从表单获取
  let tmp_name = $("#font_icon").val();
  if( tmp_name == undefined ) {
    return false;
  }
  
  tmp_name = tmp_name.split("/");
  tmp_name = tmp_name.pop();
  tmp_name = tmp_name.split(".");
  tmp_name = tmp_name[0];
  icon_name = tmp_name;
  //如果不存在，则从session获取
  if( icon_name == "" || icon_name == undefined ) {
    icon_name = sessionStorage.icon_name;
  }
  //如果session也不存在，则重新设置一个
  if( icon_name == "" || icon_name == undefined ) {
    set_icon_name();
    icon_name = sessionStorage.icon_name;
  }

  //最后返回
  return icon_name;
  
}

//获取老图标的完整路径
function get_old_pic() {
  let old_pic = $("#font_icon").val();
  if( old_pic != undefined ) {
    return old_pic;
  }
  else{
    return '';
  }
  
}


// 2022014
layui.use(['element','table','layer','form','upload','iconHhysFa'], function(){
    var element = layui.element;
    var table = layui.table;
    var form = layui.form;
    var upload = layui.upload;
    layer = layui.layer;

    //第一个实例
  table.render({
    elem: '#category_list',
    toolbar: '#catToolbar',
    height: 525
    ,url: 'index.php?c=api&method=category_list' //数据接口
    ,page: true //开启分页
    ,cols: [[ //表头
      {type: 'checkbox', fixed: 'left'},
      {field: 'id', title: 'ID', width:80, sort: true, fixed: 'left'}
      ,{field: 'font_icon', title: '图标', width:60, templet: function(d){
        return '<i class="fa-lg '+d.font_icon+'"></i>';
      }}
      ,{field: 'name', title: '分类名称', width:160}
      ,{field: 'fname', title: '父级分类', width:160}
      ,{field: 'link_num', title: '链接数量', width:110,sort:true}
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
      // 这是原来老的逻辑，跳转到新的页面进行编辑，不太友好
      // window.location.href = '/index.php?c=admin&page=edit_category&id=' + obj.data.id;
      // 新的逻辑改为当前页面iframe编辑
      layer.open({
        type: 2,
        title: '编辑分类',
        shadeClose: true,
        maxmin: true, //开启最大化最小化按钮
        area: ['900px', '660px'],
        content: '/index.php?c=admin&page=edit_category_new&id=' + obj.data.id
      });
    }
  });
  //渲染链接列表
  table.render({
    elem: '#link_list'
    ,height: 530
    ,url: 'index.php?c=api&method=link_list' //数据接口
    ,method: 'post'
    ,page: true //开启分页
    ,toolbar: '#linktool'
    ,cols: [[ //表头
      {type:'checkbox'} //开启复选框
      ,{field: 'id', title: 'ID', width:80, sort: true}
      ,{field: 'font_icon', title: '图标', width:60, templet:function(d){
        if(d.font_icon == null || d.font_icon == "")
        {
          return '<img src="static/images/default.png" width="28" height="28">';
        }
        else
        {
          let random = getRandStr(4);
          let font_icon = d.font_icon;
          return `<img src="${font_icon}?random=${random}" width="28" height="28">`;
        }
      }}
      // ,{field: 'fid', title: '分类ID',sort:true, width:90}
      ,{field: 'category_name', title: '所属分类',sort:true,width:120}
      ,{field: 'url', title: 'URL',width:140,templet:function(d){
        var url = '<a target = "_blank" href = "' + d.url + '" title = "' + d.url + '">' + d.url + '</a>';
        return url;
      }}
      ,{field: 'title', title: '链接标题', width:140,edit: 'text'}
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
      ,{field: 'weight', title: '权重', width: 75,sort:true,edit: 'text'}
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
      case "reset_query":
        reset_query();
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
      // window.location.href = '/index.php?c=admin&page=edit_link&id=' + obj.data.id;
      let height = window.innerHeight;
      if( height >= 800 ) {
        height = 800;
      }
      else{
        height = 700;
      }
      // 改成iframe编辑
      layer.open({
        type: 2,
        title: '编辑链接',
        shadeClose: true,
        maxmin: true, //开启最大化最小化按钮
        area: ['1000px', height + 'px'],
        content: '/index.php?c=admin&page=edit_link_new&id=' + obj.data.id
      });
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

  //新的登录
  form.on('submit(new_login)', function(data){
    //获取用户名
    var user = $("#user").val();
    //获取密码
    var password = $("#password").val();
    if ( user == '' || password == '' ) {
      layer.msg('用户名或密码不能为空！', {icon: 5});
      return false;
    }
    $.post('/index.php?c=login&check=login',{user:user,password:password},function(data,status){
      //如果添加成功
      if(data.code == 0) {
        window.location.href = '/index.php?c=admin';
      }
      else{
        layer.msg(data.err_msg, {icon: 5});
      }
    });
    //console.log(data.field) //当前容器的全部表单字段，名值对形式：{name: value}
    return false; //阻止表单跳转。如果需要表单跳转，去掉这段即可。
  });

  //初始化设置onenav密码
  form.on('submit(init_onenav)', function(data){
    //console.log(data.field.username);
    
    let username = data.field.username;
    let password = data.field.password;
    let password2 = data.field.password2;
    //正则验证用户名、密码
    var u_patt = /^[0-9a-z]{3,32}$/;
    if ( !u_patt.test(username) ) {
      layer.msg("用户名需要3-32位的小写字母或数字组合！", {icon: 5});
      return false;
    }
    //正则验证密码
    let p_patt = /^[0-9a-zA-Z!@#%^*.()]{6,16}$/;
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

  //新的手机登录
  form.on('submit(new_mobile_login)', function(data){
    //获取用户名
    var user = $("#m_user").val();
    //获取密码
    var password = $("#m_password").val();
    if ( user == '' || password == '' ) {
      layer.msg('用户名或密码不能为空！', {icon: 5});
      return false;
    }

    $.post('/index.php?c=login&check=login',{user:user,password:password},function(data,status){
      //如果登录成功
      if(data.code == 0) {
        window.location.href = '/index.php?c=mobile';
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
      ,url: 'index.php?c=api&method=q_category_link' //数据接口
      ,method: 'post'
      ,page: true //开启分页
      ,toolbar: '#linktool'
      ,where:{
        category_id:fid
      }
      ,cols: [[ //表头
        {type:'checkbox'} //开启复选框
        ,{field: 'id', title: 'ID', width:80, sort: true}
        ,{field: 'font_icon', title: '图标', width:60, templet:function(d){
          if(d.font_icon == null || d.font_icon == "")
          {
            return '<img src="static/images/default.png" width="28" height="28">';
          }
          else
          {
            let random = getRandStr(4);
            let font_icon = d.font_icon;
            return `<img src="${font_icon}?random=${random}" width="28" height="28">`;
          }
        }}
        // ,{field: 'fid', title: '分类ID',sort:true, width:90}
        ,{field: 'category_name', title: '所属分类',sort:true,width:120}
        ,{field: 'url', title: 'URL',width:140,templet:function(d){
          var url = '<a target = "_blank" href = "' + d.url + '" title = "' + d.url + '">' + d.url + '</a>';
          return url;
        }}
        ,{field: 'title', title: '链接标题', width:140,edit: 'text'}
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
        ,{field: 'weight', title: '权重', width: 75,sort:true,edit: 'text'}
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
    var index = layer.load(1);
    $.post('/index.php?c=api&method=set_site',data.field,function(data,status){
      if(data.code == 0) {
        layer.closeAll('loading');
        layer.msg(data.data, {icon: 1});
      }
      else{
        layer.closeAll('loading');
        layer.msg(data.err_msg, {icon: 5});
      }
    });
    //console.log(data.field) //当前容器的全部表单字段，名值对形式：{name: value}
    return false; //阻止表单跳转。如果需要表单跳转，去掉这段即可。
  });

  //保存订阅信息
  form.on('submit(set_subscribe)', function(data){
    var order_id = data.field.order_id;
    var index = layer.load(1);
    $.get('https://onenav.xiaoz.top/v1/check_subscribe.php',data.field,function(data,status){
      
      if(data.code == 200) {
        //order_id = data.data.order_id;
        email = data.data.email;
        end_time = data.data.end_time;
        //存储到数据库中
        $.post("index.php?c=api&method=set_subscribe",{order_id:order_id,email:email,end_time:end_time},function(data,status){
          if(data.code == 0) {
            layer.closeAll('loading');
            layer.msg(data.data, {icon: 1});
            setTimeout(() => {
              location.reload();
            }, 2000);
          }
          else{
            layer.closeAll('loading');
            layer.msg(data.err_msg, {icon: 5});
          }
        });
      }
      else{
        layer.closeAll('loading');
        layer.msg(data.msg, {icon: 5});
      }

    });
    console.log(data.field) //当前容器的全部表单字段，名值对形式：{name: value}
    return false; //阻止表单跳转。如果需要表单跳转，去掉这段即可。
  });
  //清空订阅信息
  form.on('submit(reset_subscribe)', function(data){
    //存储到数据库中
    $.post("index.php?c=api&method=set_subscribe",{order_id:'',email:'',end_time:null},function(data,status){
      if(data.code == 0) {
        //清空表单
      $("#order_id").val('');
      $("#email").val('');
      //$("#domain").val('');
      $("#end_time").val('');
        layer.msg(data.data, {icon: 1});
      }
      else{
        layer.closeAll('loading');
        layer.msg(data.err_msg, {icon: 5});
      }
    });
    return false; //阻止表单跳转。如果需要表单跳转，去掉这段即可。
  });

   //保存站点设置
   form.on('submit(set_transition_page)', function(data){
    var index = layer.load(1);
    $.post('/index.php?c=api&method=set_transition_page',data.field,function(data,status){
      if(data.code == 0) {
        layer.closeAll('loading');
        layer.msg(data.data, {icon: 1});
      }
      else{
        layer.closeAll('loading');
        layer.msg(data.err_msg, {icon: 5});
      }
    });
    //console.log(data.field) //当前容器的全部表单字段，名值对形式：{name: value}
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

  // 一键复制
  form.on('submit(one_copy)', function(data){
    if( (data.field.SecretKey != '') && (data.field.username != '' ) ) {
      let username = data.field.username;
      let sk = data.field.SecretKey;
      let token = md5(username + sk);
      let api_domain = $("#api_domain").val();
      let result = `${api_domain}|${token}`;
      lay.clipboard.writeText({
        text: result,
        done: function() {
          layer.msg("已复制！",{icon:1});
        },
        error: function() {
          layer.msg("复制失败！",{icon:5});
        }
      });
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
        //重新设置图标
        set_icon_name();
        layer.msg('已添加！', {icon: 1});
        //禁用按钮
        $("#add_link").addClass("layui-btn-disabled");
        setTimeout(()=>{
          window.location.reload();
        },1500);
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
    $.post('/index.php?c=api&method=edit_link&type=console',data.field,function(data,status){
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

  upload.render({
    elem: '#iconUpload' //绑定元素
    ,url: 'index.php?c=api&method=uploadImages' //上传接口
    ,accept:'file'
    ,exts: 'ico|jpg|jpeg|png|bmp|svg',
    size:100
    ,data: {
      //传递图片名称
      "icon_name":get_icon_name(),
      //传递老图片名称，接口先将老图片删除
      "old_pic":get_old_pic()
    },
    choose:function(obj){
      this.data.old_pic = get_old_pic();
    }
    ,done: function(res){
      //console.log(res);
      //上传完毕回调
      if( res.code == 200 ) {
        $("#font_icon").val(res.data.file_name);
        //显示图标
        $("#show_icon img").attr("src","/" + res.data.file_name + "?random" + getRandStr(4));
      }
      else if( res.code < 0) {
        layer.msg(res.msg, {icon: 5});
        layer.close();
      }
      
    }
    ,error: function(){
      layer.msg("发生预料之外的错误！", {icon: 5});
      layer.close();
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
    // 将时间戳转换为毫秒
    let timestampInMilliseconds = timestamp * 1000;

    // 创建新的Date对象
    let date = new Date(timestampInMilliseconds);

    // 获取年、月、日、小时、分钟，月份需要+1，因为Date对象中月份从0开始计数
    let year = date.getFullYear();
    let month = ("0" + (date.getMonth() + 1)).slice(-2);
    let day = ("0" + date.getDate()).slice(-2);
    let hours = ("0" + date.getHours()).slice(-2);
    let minutes = ("0" + date.getMinutes()).slice(-2);

    // 生成并返回格式化的日期字符串
    return `${year}-${month}-${day} ${hours}:${minutes}`;
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
  $("#console_log").append("检查数据库是否可被下载...<br />");
  $.ajax({
    type:"HEAD",
    async:false,
    url:"/data/onenav.db3",
    statusCode: {
      200: function() {
        $("#console_log").append("危险！！！危险！！！危险！！！数据库可被下载，请尽快参考帮助文档：https://dwz.ovh/jvr2t 加固安全设置！<br /><br />");
      },
      403:function() {
        $("#console_log").append("您的数据库看起来是安全的！<br />");
      }
    }
  });
}


//获取待更新数据库列表,http://onenav.com/index.php?c=api&method=exe_sql&name=on_db_logs.sql
function get_sql_update_list() {
  $("#console_log").append("----------------------------------------------------------------------<br />");
  $("#console_log").append("正在检查数据库更新...<br />");
  $.get("index.php?c=api&method=get_sql_update_list",function(data,status){

    if ( data.code == 0 ) {
      //如果没有可用更新，直接结束
      if ( data.data.length == 0 ) {
        $("#console_log").append("当前无可用更新！<br />");
        return false;
      }
      else{
        $("#console_log").append("检查到可更新SQL列表：<br />");
        $("#console_log").append("正在准备更新...<br />");
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
        
        
        //获取最新版本
        let latest_version = data.data;
        $("#latest_version").text(latest_version);

        // 改变显示内容
        let new_version = `
<a href="https://github.com/helloxz/onenav/releases" title="下载最新版OneNav" target="_blank" id="latest_version">${latest_version}</a> 
[<a href="/index.php?c=admin&page=setting/subscribe" title="订阅后可一键更新">一键更新</a>]
`;
        $("#new_version").html(new_version);
        $("#new_version").show();

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

//删除主题
function delete_theme(name) {
  layer.confirm('确认删除此主题(' + name + ')?', {icon: 3, title:'重要提示'}, function(index){
    $.post("index.php?c=api&method=delete_theme",{name:name},function(data,status){
      if( data.code == 200 ) {
        layer.msg(data.msg,{icon:1});
        setTimeout(() => {
          window.location.reload();
        }, 2000);
      }
      else{
        layer.msg(data.msg,{icon:5});
      }
    });
  });
}

//验证是否订阅
function check_subscribe(msg) {
  $.get("/index.php?c=api&method=check_subscribe",function(data,status){
    if( data.code == 200 ) {
      return true;
    }
    else{
      layer.msg(msg, {icon: 5});
      return false;
    }
  });
}

//随机数生成
function getRandStr(n) {
  var chars = ['0','1','2','3','4','5','6','7','8','9',
              'A','B','C','D','E','F','G','H','I','J','K','L','M',
              'N','O','P','Q','R','S','T','U','V','W','X','Y','Z'];
  var res = "";
  for(var i = 0; i < n ; i++) {
     var id = Math.floor(Math.random()*36);
     res += chars[id];
  }
  return res;
}

//删除图标
function del_link_icon(){
  let icon_path = $("#font_icon").val();
  //如果图标为空
  if( icon_path == "" ) {
    layer.msg("图标为空，无需删除！",{icon:1});
    return true;
  }
  console.log(icon_path.indexOf("http"));
  //如果图标包含http开头，则是网络图片，直接清空即可
  if( icon_path.indexOf("http") >= 0 ) {
    //置空
    $("#font_icon").val("");
    $("#show_icon img").attr("src","");
    layer.msg("图标已清空，请保存！",{icon:1});
    return true;
  }

  $.post("/index.php?c=api&method=del_link_icon",{icon_path:icon_path},function(data,status){
    if( data.code == 200 ) {
      $("#font_icon").val("");
      $("#show_icon img").attr("src","");
      layer.msg("图标已删除，请保存！",{icon:1});
    }
    else{
      layer.msg(data.msg,{icon:5});
    }
  });
}

$(document).ready(function() {
  // 获取当前页面的 URL
  var currentUrl = window.location.href;

  // 遍历导航栏菜单的子菜单项
  $('.layui-nav-child dd a').each(function() {
    var $this = $(this);
    var linkUrl = $this.attr('href');

    // 如果子菜单项的链接与当前页面的 URL 匹配，则为该子菜单项添加 'layui-this' 类
    if (currentUrl.indexOf(linkUrl) !== -1) {
      // 移除其他菜单项的 'layui-this' 类
      $('.layui-nav-child dd').removeClass('layui-this');

      // 为匹配的子菜单项添加 'layui-this' 类
      $this.parent().addClass('layui-this');

      // 结束遍历
      return false;
    }
  });
});

// 获取当前域名
function getCurrentDomain() {
  // 获取协议（包括末尾的冒号和斜杠）
  var protocol = window.location.protocol;

  // 获取域名
  var hostname = window.location.hostname;

  // 获取端口号
  var port = window.location.port;

  // 检查端口号是否为80或443，并相应地调整URL
  if (port === "80" || port === "443" || port === "") {
      return protocol + "//" + hostname;
  } else {
      return protocol + "//" + hostname + ":" + port;
  }
}
// 技术支持函数
function support() {
  let domain = getCurrentDomain();
  let description = "域名：" + domain; 
  let support_url = "https://support.xiuping.net/service/index?lang=zh_CN&product_id=1&description=" + description;
  layer.open({
    type: 2,
    title: false,
    shadeClose: true,
    shade: 0.8,
    area: ['700px', '780px'],
    content: support_url // iframe 的 url
  });
}