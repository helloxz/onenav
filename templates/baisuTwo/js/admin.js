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
					layer.open({
						type: 1,
						title: false,
						closeBtn: 0,
						shadeClose: true,
						skin: 'addsiteBox',
						content: $('#editsiteBox')
					});
					console.log('编辑' + listId);
					get_a_link(listId);
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
	//添加链接弹窗
	$('#addsite').click(function() {
		layer.open({
			type: 1,
			title: false,
			closeBtn: 0,
			shadeClose: true,
			skin: 'addsiteBox',
			content: $('#addsiteBox')
		});
	});
	$('.addsite-main .list.type span.fid').click(function() {
		var fid = $(this).data('fid');
		$('#addsiteBox input#fid').val(fid);
		$('#editsiteBox input#fid').val(fid);
		$(this).addClass("hover").siblings().removeClass('hover');
	});
	//监听提交-添加链接
	form.on('submit(add_link)', function(data) {
		//		layer.msg(JSON.stringify(data.field));
		var datas = JSON.stringify(data.field);
		addUrl(data.field);
		return false;
	});
	//监听提交-修改链接
	form.on('submit(edit_link)', function(data) {
		console.log(data.field)
		editUrl(data.field)
		return false;
	});
	//监听提交-添加分类
	form.on('submit(add_fid)', function(data) {
		console.log(data.field);
		addFID(data.field)
		return false;
	});
	//监听提交-修改分类
	form.on('submit(edit_fid)', function(data) {
		console.log(data.field);
		editFID(data.field)
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
	
	//添加分类弹窗
	$('#addCat').click(function() {
		layer.open({
			type: 1,
			title: false,
			closeBtn: 0,
			shadeClose: true,
			skin: 'addsiteBox',
			content: $('#addFidBox')
		});
	});

	// 修改分类弹窗
	$('span.editFid').click(function() {
		layer.open({
			type: 1,
			title: false,
			closeBtn: 0,
			shadeClose: true,
			skin: 'addsiteBox',
			content: $('#editFidBox')
		});
		var fid = $(this).data('fid');
		get_a_category(fid)
		console.log('编辑' + fid);
	});

	//查询单个链接信息
	function get_a_link(id) {
		$.get("index.php?c=api&method=get_a_link", {
			id: id
		}, function(data, status) {
			//			console.log(data);
			if(data.code == 0) {
				console.log(data);
				if(data.data.property == 0) {
					var property = false
				} else {
					var property = true
				};

				$('.addsite-main .list.type span.editfid-' + data.data.fid).addClass("hover").siblings().removeClass('hover');

				form.val('editsite', {
					"id": data.data.id,
					"url": data.data.url,
					"title": data.data.title,
					"description": data.data.description,
					"fid": data.data.fid,
					"weight": data.data.weight,
					"property": property,
				});
			} else {
				//获取信息失败
				layer.msg('获取信息失败，请重试！', {
					icon: 5,
				});
			}
		});

	};

	//查询单个分类信息
	function get_a_category(id) {
		$.post("/index.php?c=api&method=get_a_category", {
			id: id
		}, function(data, status) {
						console.log(data);
			if(data.code == 0) {
				console.log(data);
				if(data.data.property == 0) {
					var property = false
				} else {
					var property = true
				};
				form.val('editfid', {
					"id": data.data.id,
					"name": data.data.name,
					"font_icon": data.data.font_icon,
					"description": data.data.description,
					"weight": data.data.weight,
					"property": property,
				});
			} else {
				//获取信息失败
				layer.msg('获取信息失败，请重试！', {
					icon: 5,
				});
			}
		});

	};
	


});

//修改链接
function editUrl(data) {

	$.post("/index.php?c=api&method=edit_link", {
		fid: data.fid,
		id: data.id,
		url: data.url,
		title: data.title,
		weight: data.weight,
		property: data.property,
		description: data.description,
	}, function(data, status) {
		console.log(data)
		console.log(status)
		if(data.code == 0) {
			layer.msg('修改成功！', {
				icon: 6,
				time: 600,
				end: function() {
					window.location.reload();
					return false;
				}
			});
		} else {
			//修改失败
			layer.msg('修改失败，请重试！', {
				icon: 5,
			});
		}
	});
};

//添加分类
function addFID(data) {
	$.post("/index.php?c=api&method=add_category", {
		name: data.name,
		font_icon: data.font_icon,
		weight: data.weight,
		property: data.property,
		description: data.description,
	}, function(data, status) {
		console.log(data)
		console.log(status)
		if(data.code == 0) {
			layer.msg('添加成功！', {
				icon: 6,
				time: 600,
				end: function() {
					window.location.reload();
					return false;
				}
			});
		} else {
			//修改失败
			layer.msg('添加失败，请重试！', {
				icon: 5,
			});
		}
	});
}

//修改分类
function editFID(data) {
	$.post("/index.php?c=api&method=edit_category", {
		id: data.id,
		name: data.name,
		font_icon: data.font_icon,
		weight: data.weight,
		property: data.property,
		description: data.description,
	}, function(data, status) {
		console.log(data)
		console.log(status)
		if(data.code == 0) {
			layer.msg('添加成功！', {
				icon: 6,
				time: 600,
				end: function() {
//					window.location.reload();
					return false;
				}
			});
		} else {
			//修改失败
			layer.msg('添加失败，请重试！', {
				icon: 5,
			});
		}
	});
}


//
//		fid: data.fid,
//		id: data.id,
//		url: data.url,
//		title: data.title,
//		weight: data.weight,
//		property: data.property,
//		description: data.description,