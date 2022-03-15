var bodyH = $('.index-main').height();
var winH = $(window).height() - 100;
if(bodyH > winH) {
	$('footer').addClass('show');
};

//删除链接
function deleteUrl(id) {
	$.post("index.php?c=api&method=del_link", {
		id: id
	}, function(data, status) {
		//如果删除成功，则移除元素
		console.log(data)
		if(data.code == 0) {
			layer.msg('删除成功！', {
				icon: 6,
				time: 600,
			});
			$("#id_" + id).remove();
		} else {
			//删除失败
			layer.msg('删除失败，请重试！', {
				icon: 5,
			});
		}
	});
};

//复制链接
function copyUrl(url) {
	var clipboard = new ClipboardJS('.copybtn', {
		text: function() {
			return url;
		}
	});
	clipboard.on('success', function(e) {
		layer.msg('复制成功！', {
			icon: 6,
			time: 600,
		});
		e.clearSelection();
	});

	clipboard.on('error', function(e) {
		layer.msg('复制失败！', {
			icon: 5,
			time: 600,
		});
		console.error('Action:', e.action);
		console.error('Trigger:', e.trigger);
	});
};

//添加链接
function addUrl(data) {
	console.log(data.fid)

	$.post("index.php?c=api&method=add_link", {
		url: data.url,
		title: data.title,
		fid: data.fid,
		weight: data.weight,
		property: data.property,
		description: data.description,
	}, function(data, status) {
		console.log(data)
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
			//添加失败
			layer.msg('添加失败，请重试！', {
				icon: 5,
			});
		}
	});
}

//识别链接信息
function getUrlinfo(url) {
	console.log(url);
	$.post('/index.php?c=api&method=get_link_info', {
		url: url
	}, function(data, status) {
		//如果添加成功
		layer.close(layer.index);
		if(data.code == 0) {
			console.log(data);
			if(data.data.title == null) {
				layer.msg('标题获取失败，请手动输入！', {
					icon: 5,
					time: 1000,
				});
			};
			$("input#title").val(data.data.title);
			$("textarea#description").val(data.data.description);
		} else {
			layer.msg(data.err_msg, {
				icon: 5,
				time: 1000,
			});
		}
	});
}

//搜索引擎切换
function searchChange() {
	$(".search-change").click(function() {
		$('.search-lists').toggleClass('hide');
		console.log('1')
	});
	$(".search-lists .list").click(function() {
		var souurl = $(this).data('url');
		var text = $(this).html();
		$('.search-btn').html(text);
		$('.search-btn').attr('data-url', souurl);
		$('.search-lists').addClass('hide');
		console.log(souurl);

	});
	$(".search-btn").click(function() {
		var url = $(this).attr('data-url');
		var kw = $('#search').val();
		if(kw !== "") {
			window.open(url + kw);
		} else {
			layer.msg('未输入搜索框关键词！', {
				time: 1000,
			});
		}
	});
}
searchChange();
//回车键、本地搜索
function keyClick() {
	$('body').keyup(function(e) {
		if(e.keyCode === 13) {
			var isFocus = $("#search").is(":focus");
			if(true == isFocus) {
				console.log(isFocus);
				var url = $('.search-btn').attr('data-url');
				var kw = $('#search').val();
				if(kw !== "") {
					window.open(url + kw);
				} else {
					layer.msg('未输入搜索框关键词！', {
						time: 1000,
					});
				}
			}
		}
	});
	$("#search").focus(function(data, status) {
		$('.search-lists').addClass('hide');
	});
	$("#search").blur(function(data, status) {
		if($("#search").val() == '') {
			$(".site-name").removeClass("hidden");
		};
	});
	var h = holmes({
		input: '#search',
		find: '.urllist',
		placeholder: '<div class="empty">未搜索到匹配结果！</div>',
		mark: false,
		hiddenAttr: true,
		class: {
			visible: 'visible',
				hidden: 'hidden'
		},
		onFound(el) {
			$(".site-name").addClass("hidden");
		},
		onInput(el) {
			$(".site-name").addClass("hidden");
		},
		onVisible(el) {
			$(".site-name").removeClass("hidden");
		},
		onEmpty(el) {
			$(".site-name").removeClass("hidden");
		},
	});

}
keyClick();

//锚点、返回顶部
$("a.catlist").click(function() {
	$("html, body").animate({
		scrollTop: $($(this).attr("href")).offset().top - 5 + "px"
	}, 500);
	return false;
});
$('.scroll_top').click(function() {
	$('html,body').animate({
		scrollTop: '0px'
	}, 500);
});
$(window).scroll(function() {
	if($(window).scrollTop() >= 100) {
		$(".scroll_top").fadeIn(1000);
	} else {
		$(".scroll_top").stop(true, true).fadeOut(1000);
	}
});

//时间
function getNow(Mytime) {
	return Mytime < 10 ? '0' + Mytime : Mytime;
}

function CurrentTime() {
	var myDate = new Date();
	//获取当前小时数(0-23)
	var h = myDate.getHours();
	//获取当前分钟数(0-59)
	var m = myDate.getMinutes();
	//获取当前秒数(0-59)
	var s = myDate.getSeconds();
	var nowTime = getNow(h) + ':' + getNow(m) + ":" + getNow(s);
	$('#nowTime').text(nowTime);
	setTimeout("CurrentTime()", 1000); //设定定时器，循环运行     
}
CurrentTime();

var myDate = new Date();
//获取当前年份
var year = myDate.getFullYear();
//获取当前月份
var month = myDate.getMonth() + 1;
//获取当前日期
var date = myDate.getDate();
var nowDate = year + ' 年 ' + getNow(month) + " 月 " + getNow(date) + " 日";
$('#nowYmd').text(nowDate);

$('.date-main').click(function() {
	window.open('https://wannianli.tianqi.com/');
});
//获取农历
var lunarD = Lunar.fromDate(myDate);
console.log(lunarD);
var lunarNowDate = lunarD.getYearInGanZhi() + '年' + lunarD.getMonthInChinese() + "月" + lunarD.getDayInChinese();
$('#nowLunar').text(lunarNowDate);

//获取星期
var nowWeek = lunarD.getWeekInChinese();
$('#nowWeek').text('星期' + nowWeek);

//手机端
$(".navbar").click(function() {
	$(".m-navlist-w").slideToggle();
	$(this).toggleClass("hover");
});
$(".m-navlist a.list").click(function() {
	$(".m-navlist-w").slideUp();
});