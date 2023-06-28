function gotop(){
	$("html,body").animate({scrollTop: '0px'}, 600);
}
$(".search").blur(function(data,status){
	var keywords = $(".search").val();
	
	if( keywords == ''){
		$(".cat-title").removeClass("mdui-hidden");
	}
	
});
var h = holmes({
    input: '.search',
    find: '.link-space',
    placeholder: '<h3>未搜索到匹配结果！</h3>',
    mark: false,
	hiddenAttr: true,
	// 找到了就添加visible类，没找到添加mdui-hidden
    class: {
      visible: 'visible',
      hidden: 'mdui-hidden'
    },
    onHidden(el) {
	//   console.log('hidden', el);
	  
    },
    onFound(el) {
	//   console.log('found', el);
	  $(".cat-title").addClass("mdui-hidden");
    },
    onInput(el) {
		$(".cat-title").addClass("mdui-hidden");
    },
    onVisible(el) {
		$(".cat-title").removeClass("mdui-hidden");
    },
    onEmpty(el) {
		$(".cat-title").removeClass("mdui-hidden");
    }
  });
//鼠标移动到链接修改为原始URL

//js获取协议和域名部分
function get_domain(){
  //获取协议
  var protocol = window.location.protocol;
  protocol = protocol + '//';
  //获取端口号
  var port = window.location.port;
  if( (port == 80) || (port == 443) ){
    port = '';
  }
  var hostname = window.location.hostname;
  domain = protocol + port + hostname;
  return domain;
}
//弹窗
function msg(text){
  // alert('dfd');
  $html = '<div class = "msg">' + text + '</div>';
  $("body").append($html);
  $(".msg").fadeIn();
  $(".msg").fadeOut(3000);
  // $(".msg").remove();
}

function admin_menu() {
  // 加载管理员右键菜单
    //初始化菜单
    $.contextMenu({
      selector: '.link-space',
      callback: function(key, options) {
       link_id = $(this).attr('id');
      link_id = link_id.replace('id_','');
          
   },
      items: {
        "open":{name: "打开",icon:"fa-external-link",callback:function(key,opt){
            var link_id = $(this).attr('id');
            link_id = link_id.replace('id_','');
            var tempwindow=window.open('_blank');
            tempwindow.location='index.php?c=click&id='+link_id;
          }},
          "edit": {name: "编辑", icon: "edit",callback:function(key,opt){
            var link_id = $(this).attr('id');
            link_id = link_id.replace('id_','');
            var tempwindow=window.open('_blank');
            tempwindow.location='index.php?c=admin&page=edit_link&id='+link_id;
          }},
          "delete": {name: "删除", icon: "delete",callback:function(){
              var link_id = $(this).attr('id');
              link_id = link_id.replace('id_','');
              mdui.confirm('确认删除？',
              function(){
                  $.post("index.php?c=api&method=del_link",{id:link_id},function(data,status){
                    //如果删除成功，则移除元素
                    if(data.code == 0) {
                      $("#id_" + link_id).remove();
                    }
                    else{
                      //删除失败
                      mdui.alert(data.err_msg);
                    }
                  });
              },
              function(){
                //点击取消按钮，不做操作
                return true;
              }
            );
          }},
          "sep1": "---------",
          "qrcode": {name: "二维码", icon:"fa-qrcode",callback:function(data,status){
              var link_title = $(this).attr('link-title');
              
              //link_title = link_title.substr(0,8);
              // link_title = link_title + '...';
              var link_id = $(this).attr('id');
              link_id = link_id.replace('id_','');
              var domain = get_domain();
              var url = domain + '/click/' + link_id;
              
              mdui.dialog({
                'title':link_title,
                'cssClass':'show_qrcode',
                'content':`<div id="qrcode"></div>`
              });
              
              let qrcode = new QRCode(document.getElementById('qrcode'), url);
          }},
          "copy":{name:"复制链接",icon:"copy",callback:function(){
            link_url = $(this).attr('link-url');
            // 复制按钮
            var copy = new clipBoard($(".context-menu-icon-copy"), {
              beforeCopy: function() {
                
              },
              copy: function() {
                return link_url;
                
              },
              afterCopy: function() {
                layer.msg('链接已复制！');
              }
          });
            // 复制按钮END
    
          }}

      }
  });
      // 加载右键菜单END
}


function user_menu() {
  // 加载游客右键菜单
//初始化菜单
$.contextMenu({
  selector: '.link-space',
  callback: function(key, options) {
   link_id = $(this).attr('id');
  link_id = link_id.replace('id_','');
      
},
  items: {
    "open":{name: "打开",icon:"fa-external-link",callback:function(key,opt){
        var link_id = $(this).attr('id');
        link_id = link_id.replace('id_','');
        var tempwindow=window.open('_blank');
        tempwindow.location='index.php?c=click&id='+link_id;
      }},
      "sep1": "---------",
      "qrcode": {name: "二维码", icon:"fa-qrcode",callback:function(data,status){
          var link_title = $(this).attr('link-title');
          
          // link_title = link_title.substr(0,8);
          // link_title = link_title + '...';
          var link_id = $(this).attr('id');
          link_id = link_id.replace('id_','');
          var domain = get_domain();
          var url = domain + '/click/' + link_id;

          mdui.dialog({
            'title':link_title,
            'cssClass':'show_qrcode',
            'content':`<div id="qrcode"></div>`
          });

          let qrcode = new QRCode(document.getElementById('qrcode'), url);
      }},
      "copy":{name:"复制链接",icon:"copy",callback:function(){
        link_url = $(this).attr('link-url');
        // 复制按钮
        var copy = new clipBoard($(".context-menu-icon-copy"), {
          beforeCopy: function() {
            
          },
          copy: function() {
            return link_url;
            
          },
          afterCopy: function() {
            //msg('链接已复制！');
            // mdui.alert('链接已复制！');
            layer.msg('链接已复制！');
          }
      });
        // 复制按钮END

      }}

  }
});
    // 加载游客右键菜单END
};

// 添加链接按钮
$("#add").click(function(){
  open_add_link();
});

function open_add_link(){
  layer.open({
    type: 2,
    title: '添加链接',
    maxmin: true,
    shadeClose: true, //点击遮罩关闭层
    area : ['800px' , '520px'],
    content: '/index.php?c=admin&page=add_link_tpl'
  });
}
//搜索框失去焦点
function clean_search(){
  $(".search").val('');
  $(".search").blur();
}
//搜索框得到焦点
function on_search(){
  $(".search").focus();
  $(".search").val('');
}
//快捷键支持
// hotkeys('a,esc', function (event, handler){
//   switch (handler.key) {
//     case 'a': open_add_link();
//       break;
//     case 'esc': clean_search();
//       break;
    
//     default: alert(event);
//   }
// });

//链接跳转
function goto(url) {
    window.location.href = url;
}

function getCookie(cname)
{
  var name = cname + "=";
  var ca = document.cookie.split(';');
  for(var i=0; i<ca.length; i++) 
  {
    var c = ca[i].trim();
    if (c.indexOf(name)==0) return c.substring(name.length,c.length);
  }
  return "";
}
//切换mdui的主题
function change_theme() {
    var d = new Date();
    d.setTime(d.getTime()+(30*24*60*60*1000));
    var expires = "expires="+d.toGMTString();
    
    if( ( getCookie("docs-theme-layout") == "" ) || ( getCookie("docs-theme-layout") == "light" ) ) {
      var docs_theme_layout = "dark";
    }
    else{
      var docs_theme_layout = "light";
    }
    document.cookie = "docs-theme-layout=" + docs_theme_layout + "; " + expires + " path=/";
    window.location.href = "/";
}


$(document).ready(function(){
  let $ = mdui.$;
  var inst = new mdui.Drawer('#drawer');
  var cid = getURLParam('cid');
  console.log(cid);
  if( cid !== null ) {
    // 关闭左侧抽屉栏
    inst.close();
  }
});

// 获取参数值
function getURLParam(paramName) {
  // 获取URL的查询参数部分
  var queryString = window.location.search;

  // 创建一个新的URLSearchParams实例
  var urlParams = new URLSearchParams(queryString);

  // 使用get()方法来获取指定参数的值
  var paramValue = urlParams.get(paramName);

  return paramValue;
}