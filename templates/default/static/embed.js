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


$(document).ready(function(){
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
            
        }},
        "sep1": "---------",
        "qrcode": {name: "二维码", icon:"fa-qrcode"}
    }
});

});