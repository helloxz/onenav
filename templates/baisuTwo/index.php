<!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8" />
		<meta name="renderer" content="webkit|ie-comp|ie-stand">
		<meta http-equiv="X-UA-Compatible" content="IE=Edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no">
		<meta http-equiv="Cache-Control" content="no-transform">
		<meta name="applicable-device" content="pc,mobile">
		<meta name="MobileOptimized" content="width">
		<meta name="HandheldFriendly" content="true">
		<meta name="author" content="BaiSu" />
		<title>
			<?php echo $site_setting['title']; ?>
		</title>
		<meta name="keywords" content="<?php echo $site_setting['keywords']; ?>" />
		<meta name="description" content="<?php echo $site_setting['description']; ?>" />
		<link rel="stylesheet" type="text/css" href="templates/<?php echo TEMPLATE; ?>/css/style.css" />
		<link rel="stylesheet" href="https://libs.xiaoz.top/font-awesome/4.7.0/css/font-awesome.css">
		<link rel="stylesheet" type="text/css" href="templates/<?php echo TEMPLATE; ?>/layui/css/layui.css" />
		<style type="text/css">
			/*链接描述是否显示*/
			
			.site-main .site-list .list .desc {
				/*none：不显示，block:显示*/
				display: none;
			}
		</style>
	</head>

	<body>
		<!--手机顶部 S-->
		<!--手机顶部 S-->
		<div class="m-header">
			<div class="logo">
				<a href="/"><img src="templates/<?php echo TEMPLATE; ?>/images/logo.png" /></a>
			</div>
			<div class="navbar">
				<i class="iconfont icon-caidan"></i>
			</div>
			<div class="m-navlist-w">
				<div class="m-navlist">
					<?php
			foreach ($categorys as $category) {
				$font_icon = empty($category['font_icon']) ? '' : "<i class='{$category['font_icon']}'></i> ";
		?>
						<a href="#category-<?php echo $category['id']; ?>" class="list catlist">
							<?php echo $font_icon; ?>
							<?php echo htmlspecialchars_decode($category['name']); ?>
						</a>
						<?php } ?>
				</div>
			</div>
		</div>
		<!--手机顶部 E-->
		<!--手机顶部 E-->
		<!--左侧分类栏 S-->
		<div class="index-nav">
			<div class="logo">
				<a href="/"><img src="templates/<?php echo TEMPLATE; ?>/images/logo.png" /></a>
			</div>
			<div class="type-list">

				<?php
			foreach ($categorys as $category) {
				$font_icon = empty($category['font_icon']) ? '' : "<i class='{$category['font_icon']}'></i> ";
		?>
					<div class="list">
						<a class="catlist" href="#category-<?php echo $category['id']; ?>">
							<?php echo $font_icon; ?>
							<?php echo htmlspecialchars_decode($category['name']); ?>
						</a>
						<span class="editFid" data-fid = "<?php echo $category['id']; ?>"><i class="iconfont icon-bianji"></i></span>
					</div>
					<?php } ?>

					<div class="list add" id="addCat">
						<a>
							<i class="iconfont icon-tianjia"></i>添加分类</a>
					</div>
			</div>
			<div class="user-info">
				<div class="pic">
					<a href="/">
						<img src="templates/<?php echo TEMPLATE; ?>/images/touxiang.png" /></a>
				</div>
				<div class="text">
					<?php
		if( is_login() ) {
	  ?>
						<a href="/index.php?c=admin" target="_blank">
							<p class="t1">
								<?php echo $site_setting['title']; ?>
							</p>
							<p class="t2">管理后台</p>
						</a>
						<?php }else{ ?>
						<a href="/index.php?c=login" target="_blank">
							<p class="t1">尚未登录</p>
							<p class="t2">请先登录账户！</p>
						</a>
						<?php } ?>
				</div>
			</div>
		</div>
		<!--左侧分类栏 E-->
		<!--中间主体 S-->
		<div class="index-main">
			<!--搜索 S-->
			<div class="search-main-w">
				<div class="search-main">
					<div class="search-input">
						<input type="text" class="kw" name="search" id="search" value="" class="kw" placeholder="回车键百度搜索" autocomplete="off" />
						<button class="search-bendi"><i class="iconfont icon-sousuo"></i></button>
					</div>
					<div class="search-btnlist">
						<button class="search-btn" data-url="https://www.baidu.com/s?ie=UTF-8&wd=">
							<img src="templates/<?php echo TEMPLATE; ?>/images/icon/baidu.svg" />
							百度搜索</button>
						<button class="search-change"><i class="iconfont icon-xiangxia"></i></button>
						<div class="search-lists hide">
							<div class="list" data-url="https://www.baidu.com/s?ie=UTF-8&wd=">
								<img src="templates/<?php echo TEMPLATE; ?>/images/icon/baidu.svg" />百度搜索
							</div>
							<div class="list" data-url="https://www.google.com/search?q=">
								<img src="templates/<?php echo TEMPLATE; ?>/images/icon/google.svg" />谷歌搜索
							</div>
							<div class="list" data-url="https://cn.bing.com/search?q=">
								<img src="templates/<?php echo TEMPLATE; ?>/images/icon/bing.svg" />必应搜索
							</div>
							<div class="list" data-url="https://www.zhihu.com/search?type=content&q=">
								<img src="templates/<?php echo TEMPLATE; ?>/images/icon/zhihu.png" />知乎搜索
							</div>
							<div class="list" data-url="https://search.bilibili.com/all?keyword=">
								<img src="templates/<?php echo TEMPLATE; ?>/images/icon/bilibili.svg" />Bilibili搜索
							</div>
							<div class="list" data-url="https://s.weibo.com/weibo?q=">
								<img src="templates/<?php echo TEMPLATE; ?>/images/icon/weibo.svg" />微博搜索
							</div>
							<div class="list" data-url="https://so.toutiao.com/search?dvpf=pc&source=input&keyword=">
								<img src="templates/<?php echo TEMPLATE; ?>/images/icon/toutiao.ico" />头条搜索
							</div>
							<!--此处添加搜索引擎 S-->
							<!--<div class="list" data-url="搜索链接">
								<img src="搜索引擎图标路径" />搜索引擎名称
							</div>-->
							<!--此处添加搜索引擎 E-->

							<div class="list kongs"></div>
						</div>
					</div>
				</div>
				<div class="date-main">
					<time class="times" id="nowTime">00:00:00</time>
					<span class="dates" id="nowYmd">2022年02月28日</span>
					<div class="list">
						<span class="lunars" id="nowLunar">壬寅年正月廿八 </span>
						<span class="weeks" id="nowWeek">星期一</span>
					</div>
				</div>
				<div class="weather-main" id="he-plugin-standard"></div>
			</div>

			<div class="search">
				<div class="list">
					<input type="text" name="search" id="search" value="" class="kw" placeholder="输入关键词进行搜索，回车键百度搜索" autocomplete="off" />
					<button><i class="iconfont icon-sousuo"></i></button>
				</div>
			</div>
			<!--搜索 E-->
			<div class="site-main">
				<!-- 遍历分类目录 -->
				<?php foreach ( $categorys as $category ) {
                $fid = $category['id'];
                $links = get_links($fid);
                $font_icon = empty($category['font_icon']) ? '' : "<i class='{$category['font_icon']}'></i> ";
                //如果分类是私有的
                if( $category['property'] == 1 ) {
                    $property = '<span><i class="one iconfont icon-suo"></i></span>';
                }
                else {
                    $property = '';
                }
            ?>

				<div class="site-name" id="category-<?php echo $category['id']; ?>">
					<?php echo $font_icon; ?>
					<?php echo htmlspecialchars_decode($category['name']); ?>
					<?php echo $property; ?>
				</div>
				<div class="site-list">
					<!-- 遍历链接 -->
					<?php
				foreach ($links as $link) {
					//默认描述
					$link['description'] = empty($link['description']) ? '作者很懒，没有填写描述。' : $link['description'];
			?>
						<div class="list urllist" id="id_<?php echo $link['id']; ?>" data-id="<?php echo $link['id']; ?>" data-url="<?php echo $link['url']; ?>">
							<a href="/index.php?c=click&id=<?php echo $link['id']; ?>" target="_blank">
								<p class="name">
									<img src="https://favicon.rss.ink/v1/<?php echo base64($link['url']); ?>">
									<?php echo $link['title']; ?>
								</p>
								<p class="desc">
									<?php echo $link['description']; ?>
								</p>
							</a>
							<?php if($link['property'] == 1 ) { ?>
							<span><i class="one iconfont icon-suo"></i></span>
							<?php } ?>
						</div>
						<?php } ?>
						<div class="list kongs"></div>
						<div class="list kongs"></div>
						<div class="list kongs"></div>
						<div class="list kongs"></div>
				</div>
				<!-- 遍历链接END -->
				<?php } ?>

			</div>
		</div>
		<!--中间主体 E-->

		<!--底部版权 S-->
		<footer>
			© 2022 BaiSu，Powered by
			<a target="_blank" href="https://github.com/helloxz/onenav" title="简约导航/书签管理器" rel="nofollow">OneNav</a>
			<br> The theme author is
			<a href="https://gitee.com/baisucode/onenav" target="_blank">BaiSu</a>

		</footer>
		<!--底部版权 E-->
		<!--返回顶部 S-->
		<div class="tool-list">
			<?php
		if( is_login() ) {
	  ?>
				<div class="addsite list" id="addsite">
					<i class="iconfont icon-tianjia"></i>
				</div>
				<?php }else{ ?>
				<a href="/index.php?c=login" class="addsite list">
					<i class="iconfont icon-zhanghao"></i>
				</a>
				<?php } ?>
				<div class="scroll_top list">
					<i class="iconfont icon-top"></i>
				</div>
		</div>
		<!--返回顶部 E-->
		<!--添加链接 S-->
		<div class="addsite-main" id="addsiteBox">
			<div class="title">
				添加链接
			</div>
			<form class="layui-form list-w">
				<div class="list">
					<span class="icon"><i class="iconfont icon-charulianjie"></i></span>
					<input type="text" class="text" name="url" id="url" required lay-verify="required|url" placeholder="请输入完整的网址链接" autocomplete="off">
				</div>
				<div class="list">
					<span class="icon"><i class="iconfont icon-bianji"></i></span>
					<input type="text" class="text" name="title" id="title" required lay-verify="required" placeholder="请输入标题" autocomplete="off">
				</div>
				<div class="list type">
					<input type="hidden" name="fid" id="fid" value="" required lay-verify="required" />
					<?php foreach ($categorys as $category) {
        ?>
					<span class="fid" data-fid="<?php echo $category['id'] ?>"><?php echo htmlspecialchars_decode($category['name']); ?></span>
					<?php } ?>
					<span class="kongs"></span>
					<span class="kongs"></span>
					<span class="kongs"></span>
				</div>

				<div class="list list-2">
					<div class="li">
						<span>权重：</span>
						<input type="text" class="num" name="weight" min="0" max="999" value="0" required lay-verify="required|number" autocomplete="off">
					</div>
					<div class="li">
						私有：
						<input type="checkbox" lay-skin="switch" lay-text="是|否" name="property" value="1">
					</div>
				</div>
				<div class="list">
					<textarea name="description" id="description" placeholder="请输入站点描述（选填）"></textarea>
				</div>
				<div class="list">
					<button lay-submit lay-filter="add_link">添加</button>
				</div>

			</form>
		</div>
		<!--添加链接 E-->

		<!--修改链接 S-->
		<div class="addsite-main" id="editsiteBox">
			<div class="title">
				修改链接
			</div>
			<form class="layui-form list-w" lay-filter="editsite">
				<input type="hidden" name="id" id="id" value="" required lay-verify="required" />
				<div class="list">
					<span class="icon"><i class="iconfont icon-charulianjie"></i></span>
					<input type="text" class="text" name="url" id="url" required lay-verify="required|url" placeholder="请输入完整的网址链接" autocomplete="off">
				</div>
				<div class="list">
					<span class="icon"><i class="iconfont icon-bianji"></i></span>
					<input type="text" class="text" name="title" id="title" required lay-verify="required" placeholder="请输入标题" autocomplete="off">
				</div>
				<div class="list type">
					<input type="hidden" name="fid" id="fid" value="" required lay-verify="required" />
					<?php foreach ($categorys as $category) {
        ?>
					<span class="fid editfid-<?php echo $category['id'] ?>" data-fid="<?php echo $category['id'] ?>"><?php echo htmlspecialchars_decode($category['name']); ?></span>
					<?php } ?>
					<span class="kongs"></span>
					<span class="kongs"></span>
					<span class="kongs"></span>
				</div>

				<div class="list list-2">
					<div class="li">
						<span>权重：</span>
						<input type="text" class="num" name="weight" min="0" max="999" value="0" required lay-verify="required|number" autocomplete="off">
					</div>
					<div class="li">
						私有：
						<input type="checkbox" lay-skin="switch" lay-text="是|否" name="property" value="1">
					</div>
				</div>
				<div class="list">
					<textarea name="description" id="description" placeholder="请输入站点描述（选填）"></textarea>
				</div>
				<div class="list">
					<button lay-submit lay-filter="edit_link">修改</button>
				</div>

			</form>
		</div>
		<!--修改链接 E-->

		<!--添加分类 S-->
		<div class="addsite-main" id="addFidBox">
			<div class="title">
				添加分类
			</div>
			<form class="layui-form list-w" lay-filter="editsite">
				<div class="list">
					<span class="icon"><i class="iconfont icon-bianji"></i></span>
					<input type="text" class="text" name="name" id="name" required lay-verify="required" placeholder="请输入分类名称" autocomplete="off">
				</div>
				<div class="list">
					<span class="icon"><i class="iconfont icon-shezhi1"></i></span>
					<input type="text" class="text" name="font_icon" id="font_icon" required lay-verify="required" placeholder="请输入或选择分类图标" autocomplete="off">
				</div>

				<div class="list list-2">
					<div class="li">
						<span>权重：</span>
						<input type="text" class="num" name="weight" min="0" max="999" value="0" required lay-verify="required|number" autocomplete="off">
					</div>
					<div class="li">
						私有：
						<input type="checkbox" lay-skin="switch" lay-text="是|否" name="property" value="1">
					</div>
				</div>
				<div class="list">
					<textarea name="description" id="description" placeholder="请输入分类描述（选填）"></textarea>
				</div>
				<div class="list">
					<button lay-submit lay-filter="add_fid">添加</button>
				</div>

			</form>
		</div>
		<!--添加分类 E-->

		<!--修改分类 S-->
		<div class="addsite-main" id="editFidBox">
			<div class="title">
				修改分类
			</div>
			<form class="layui-form list-w" lay-filter="editfid">
				<input type="hidden" name="id" id="id" value="" required lay-verify="required" />
				<div class="list">
					<span class="icon"><i class="iconfont icon-bianji"></i></span>
					<input type="text" class="text" name="name" id="name" required lay-verify="required" placeholder="请输入分类名称" autocomplete="off">
				</div>
				<div class="list">
					<span class="icon"><i class="iconfont icon-shezhi1"></i></span>
					<input type="text" class="text" name="font_icon" id="font_icon" required lay-verify="required" placeholder="请输入或选择分类图标" autocomplete="off">
				</div>

				<div class="list list-2">
					<div class="li">
						<span>权重：</span>
						<input type="text" class="num" name="weight" min="0" max="999" value="0" required lay-verify="required|number" autocomplete="off">
					</div>
					<div class="li">
						私有：
						<input type="checkbox" lay-skin="switch" lay-text="是|否" name="property" value="1">
					</div>
				</div>
				<div class="list">
					<textarea name="description" id="description" placeholder="请输入分类描述（选填）"></textarea>
				</div>
				<div class="list">
					<button lay-submit lay-filter="edit_fid">修改</button>
				</div>

			</form>
		</div>
		<!--修改分类 E-->

		<!--iconfont-->
		<link rel="stylesheet" type="text/css" href="//at.alicdn.com/t/font_3000268_oov6h4vru0h.css" />
		<script src="//at.alicdn.com/t/font_3000268_oov6h4vru0h.js" type="text/javascript" charset="utf-8"></script>
		<!--JS-->
		<script src="templates/<?php echo TEMPLATE; ?>/js/jquery-3.5.1.min.js" type="text/javascript" charset="utf-8"></script>
		<script src="templates/<?php echo TEMPLATE; ?>/layui/layui.js" type="text/javascript" charset="utf-8"></script>
		<script src="templates/<?php echo TEMPLATE; ?>/js/clipboard.min.js" type="text/javascript" charset="utf-8"></script>
		<script src="templates/<?php echo TEMPLATE; ?>/js/holmes.js" type="text/javascript" charset="utf-8"></script>
		<script src="templates/<?php echo TEMPLATE; ?>/js/lunar.js" type="text/javascript" charset="utf-8"></script>
		<script src="templates/<?php echo TEMPLATE; ?>/js/common.js" type="text/javascript" charset="utf-8"></script>
		<?php
		if( is_login() ) {
	  ?>
			<script src="templates/<?php echo TEMPLATE; ?>/js/admin.js" type="text/javascript" charset="utf-8"></script>

			<?php } ?>

			<!--天气代码替换处 S-->
			<script type="text/javascript">
				WIDGET = {
					"CONFIG": {
						"layout": "1",
						"width": "240",
						"height": "180",
						"background": "1",
						"dataColor": "FFFFFF",
						"borderRadius": "6",
						"modules": "10",
						"key": "7423b182d5cb48239f19df9e25cdf320"
					}
				}
			</script>
			<script src="https://widget.qweather.net/standard/static/js/he-standard-common.js?v=2.0"></script>
			<!--天气代码替换处 E-->

	</body>

</html>