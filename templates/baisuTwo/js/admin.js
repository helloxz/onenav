layui.use(['dropdown', 'layer', 'form'], function() {
	var dropdown = layui.dropdown,
		layer = layui.layer,
		form = layui.form,
		$ = layui.jquery;
	//右键菜单
	dropdown.render({
		elem: '.urllist',
		trigger: 'contextmenu' //右键事件
			,
		data: [{
			title: '访问',
			templet: '<i class="iconfont icon-charulianjie"></i> {{d.title}}',
			id: 1
		}, {
			title: '复制',
			templet: '<div class="copybtn"><i class="iconfont icon-fuzhi"></i> {{d.title}}</div>',
			id: 2
		}, {
			title: '编辑',
			templet: '<i class="iconfont icon-bianji"></i> {{d.title}}',
			id: 3
		}, {
			title: '删除',
			templet: '<i class="iconfont icon-shanchu"></i> {{d.title}}',
			id: 4
		}],
		click: function(data, othis) {
			var elem = $(this.elem),
				listId = elem.data('id');
			    listUrl = elem.data('url');
			switch(data.id) {
				case 1:
					window.open('index.php?c=click&id=' + listId, '_blank');
					break;
				case 2:
					copyUrl(listUrl);
					console.log('复制' + listId);
					break;
				case 3:
					window.open('index.php?c=admin&page=edit_link&id=' + listId, '_blank');
					console.log('编辑' + listId);
					break;
				case 4:
					layer.confirm('一定要删除吗？', {
						btn: ['删除', '取消'] //按钮
					}, function() {
						deleteUrl(listId)
					}, function() {
						layer.msg('取消删除！', {
							time: 600,
						});
					});
					console.log('删除' + listId);
					break;
					
			}
		}
	});
	//添加弹窗
	$('#addsite').click(function() {
		layer.open({
			type: 1,
			title: false,
			closeBtn: 0,
			shadeClose: true,
			skin: 'addsiteBox',
			content: $('#addsiteBox')
		});
	})
	$('.addsite-main .list.type span.fid').click(function() {
		var fid = $(this).data('fid');
		$('#fid').val(fid);
		$(this).addClass("hover").siblings().removeClass('hover');
	});
	//监听提交
	form.on('submit(add_link)', function(data) {
		//		layer.msg(JSON.stringify(data.field));
		var datas = JSON.stringify(data.field);
		addUrl(data.field);
		return false;
	});

	//识别链接信息
	$("input#title").focus(function() {
		var titleval = $("input#title").val();
		var urlval = $("input#url").val();
		if(urlval !== "" && titleval == "") {
			layer.msg('链接信息识别中', {
				icon: 16,
			});
			getUrlinfo(urlval)
		}
	});

});