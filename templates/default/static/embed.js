function gotop(){
	$("html,body").animate({scrollTop: '0px'}, 600);
}
$(".search").blur(function(data,status){
	var keywords = $(".search").val();
	console.log(keywords);
	if( keywords == ''){
		$(".mdui-typo-title").removeClass("mdui-hidden");
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
	  $(".mdui-typo-title").addClass("mdui-hidden");
    },
    onInput(el) {
		$(".mdui-typo-title").addClass("mdui-hidden");
    },
    onVisible(el) {
		$(".mdui-typo-title").removeClass("mdui-hidden");
    },
    onEmpty(el) {
		$(".mdui-typo-title").removeClass("mdui-hidden");
    }
  });
//鼠标移动到链接修改为原始URL
