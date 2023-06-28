<!DOCTYPE html>
<html lang="zh-ch" xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta charset="utf-8" />
	<title><?php echo $site['title']; ?> - <?php echo $site['subtitle']; ?></title>
	<meta name="generator" content="EverEdit" />
	<meta name="author" content="xiaoz<www.xiaoz.me>" />
	<meta name="keywords" content="<?php echo $site['keywords']; ?>" />
	<meta name="description" content="<?php echo $site['description']; ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel='stylesheet' href='static/mdui/css/mdui.css'>
	<link rel='stylesheet' href='static/jQuery-contextMenu/jquery.contextMenu.min.css'>
	<link rel="stylesheet" href="static/font-awesome/4.7.0/css/font-awesome.css">
	<link rel="stylesheet" href="templates/<?php echo $template; ?>/static/style.css?v=<?php echo $version; ?>">
	<script src = 'static/mdui/js/mdui.min.js'></script>
	<?php echo $site['custom_header']; ?>
	<style>
	<?php if( $theme_config->link_description == "hide" ) { ?>
		.link-content{
			display:none;
		}
		.link-line{
			height:56px;
		}
	<?php } ?>
	</style>
</head>
<?php
	// 根据cookie来设置mdui主题
	$md_theme = $_COOKIE['docs-theme-layout'];
	if( empty($md_theme) || ( $md_theme == "light" ) ) {
		$md_theme = "";
	}
	else{
		$md_theme = "mdui-theme-layout-dark";
	}
?>
<body class = "mdui-drawer-body-left mdui-appbar-with-toolbar <?php echo $md_theme ?> mdui-theme-primary-indigo mdui-theme-accent-pink mdui-loaded">
	<!--导航工具-->
	<header class = "mdui-appbar mdui-appbar-fixed">
		<div class="mdui-toolbar mdui-color-theme">
		<!-- <button class="mdui-btn" mdui-drawer="{target: '#drawer'}"><i class="mdui-icon material-icons">home</i></button> -->
		<span class="mdui-btn mdui-btn-icon mdui-ripple mdui-ripple-white" mdui-drawer="{target: '#drawer', swipe: true}"><i class="mdui-icon material-icons">menu</i></span>
		  <!-- <a href="javascript:;" class="mdui-btn mdui-btn-icon"><i class="mdui-icon material-icons">home</i></a> -->
		  <a href="/" class = "mdui-typo-headline" title = "<?php echo $site['description'] ?>"><span class="mdui-typo-title default-title"><h1><?php echo $site['title']; ?></h1></span></a>
		  <div class="mdui-toolbar-spacer"></div>
		  <!-- 新版搜索框 -->
		  	
			<!-- 新版搜索框END -->
		  
	  <?php
		if( is_login() ) {
	  ?>	
	  <a class = "mdui-hidden-xs" href="/index.php?c=admin" title = "后台管理" target="_blank" class="mdui-btn mdui-btn-icon"><i class="mdui-icon material-icons">account_circle</i></a>
	  <?php }else{ ?>
		<a class = "mdui-hidden-xs" href="/index.php?c=login" title = "登录OneNav" target="_blank" class="mdui-btn mdui-btn-icon"><i class="mdui-icon material-icons">account_circle</i></a>
	  <?php } ?>
    </a>
		</div>
	</header>
	<!--导航工具END-->

	<!-- 添加按钮 -->
	<?php
		if( is_login() ) {
	?>	
	<div class="right-button mdui-hidden-xs" style="position: fixed;right:10px;bottom:80px;z-index:1000;">
		<div>
		<button title = "快速添加链接" id = "add" class="mdui-fab mdui-color-theme-accent mdui-ripple mdui-fab-mini"><i class="mdui-icon material-icons">add</i></button>
		</div>
	</div>
	<?php } ?>
	<!-- 添加按钮END -->
	<!-- 返回顶部按钮 -->
	<div id="top"></div>
	<div class="top mdui-shadow-10">
		<a href="javascript:;" title="返回顶部" onclick="gotop()"><i class="mdui-icon material-icons">arrow_drop_up</i></a>
	</div>
	<!-- 返回顶部END -->
	<!--左侧抽屉导航-->
	<!-- 默认抽屉栏在左侧 -->
	<div class="mdui-drawer" id="drawer">
	  <ul class="mdui-list">
	  	<?php
			//遍历分类目录并显示
			foreach ($category_parent as $category) {
			//var_dump($category);
			$font_icon = empty($category['font_icon']) ? '' : "<i class='{$category['font_icon']}'></i> ";
		?>
          <div class="mdui-collapse" mdui-collapse>
              <div class="mdui-collapse-item">
        <div class="mdui-collapse-item-header">
		<a href="#category-<?php echo $category['id']; ?>">
			<li class="mdui-list-item mdui-ripple">
				<div class="mdui-list-item-content category-name"><?php echo $font_icon; ?><?php echo htmlspecialchars_decode($category['name']); ?></div>
                <i class="mdui-collapse-item-arrow mdui-icon material-icons">keyboard_arrow_down</i>
			</li>
		</a>
        </div>
		<!-- 遍历二级分类-->
          <div class="mdui-collapse-item-body">
         <ul>
         <?php foreach (get_category_sub( $category['id'] ) AS $category_sub){

         ?>
            <a href="#category-<?php echo $category_sub['id']; ?>">
                <li class="mdui-list-item mdui-ripple" style="margin-left:-4.3em;">
                    <div class="mdui-list-item-content category_sub">
                        <i>
                        <i class="<?php echo $category_sub['font_icon']; ?>"></i><?php echo htmlspecialchars_decode($category_sub['name']); ?>
                        </i>
                    </div>
                </li>
            </a>
         <?php } ?>
        </ul>
        </div>
		<!--遍历二级分类END-->
		</div>
        </div>
		<?php } ?>
		<!-- 华丽的分割线 -->
		<div class="mdui-divider"></div>
		<!-- 华丽的分割线END -->
		
		<?php
			if ( !is_login() ) {
		?>
		<a href="/index.php?c=login" title="手机登录" class="mdui-hidden-sm-up">
			<li class="mdui-list-item mdui-ripple">
			<div class="mdui-list-item-content category-name"><i class="fa fa-dashboard"></i> 登录</div>
			</li>
		</a>
		<?php } else { ?>
		<a href="/index.php?c=mobile" title="后台管理" class="mdui-hidden-sm-up">
			<li class="mdui-list-item mdui-ripple">
			<div class="mdui-list-item-content category-name"><i class="fa fa-dashboard"></i> 后台管理</div>
		</li>
		</a>
		<?php } ?>
		<!-- 切换主题 -->
		<a href="javascript:;" onclick = "change_theme()" title="点击可切换主题风格">
			<li class="mdui-list-item mdui-ripple">
				<div class="mdui-list-item-content category-name"><i class="fa fa-adjust"></i> 切换风格</div>
			</li>
		</a>
		<!-- 切换主题END -->
	  </ul>
	</div>
	<!--左侧抽屉导航END-->

	<!--正文内容部分-->
	<div class="<?php echo ( $theme_config->full_width_mode == "off") ? "mdui-container" : "mdui-container-fluid"; ?>">
		<!-- 搜索框 -->
		<div class="mdui-row">
			<div class="mdui-col-md-12 mdui-col-xs-12 mdui-col-xl-6 mdui-col-offset-xl-3">
				<div class="mdui-textfield mdui-textfield-floating-label">
					<!-- <label class="mdui-textfield-label">输入书签关键词进行搜索</label> -->
					<input class="mdui-textfield-input search" placeholder="输入书签关键词进行搜索" type="text" />
					<i class="mdui-icon material-icons" style = "position:absolute;right:2px;">search</i>
				</div>
			</div>
		</div>
		<!-- 搜索框END -->
		<div class="mdui-row">
			<?php
				if( isset($_GET['cid']) ) {
					echo '<a href="/" id = "backButton"> << 返回</a>';
				}
			?>
			<!-- 遍历分类目录 -->
            <?php foreach ( $categorys as $category ) {
                $fid = $category['id'];
                $links = $get_links($fid);
				$font_icon = empty($category['font_icon']) ? '' : "<i class='{$category['font_icon']}'></i> ";
                //如果分类是私有的
                if( $category['property'] == 1 ) {
                    $property = '<i class="fa fa-expeditedssl" style = "color:#5FB878"></i>';
                }
                else {
                    $property = '';
                }
            ?>
			<div id = "category-<?php echo $category['id']; ?>" class = "mdui-col-xs-12 mdui-typo-title cat-title">
				<?php echo $font_icon; ?>
				<?php echo htmlspecialchars_decode($category['name']); ?> <?php echo $property; ?>
			</div>
			<!-- 遍历链接 -->
			<?php
				foreach ($links as $link) {
					//默认描述
					$link['description'] = empty($link['description']) ? '作者很懒，没有填写描述。' : $link['description'];
					$id = $link['id'];
					//直链模式
					if( $site['link_model'] === 'direct' ) {
						$url = $link['url'];
					}
					else{
						$url = '/index.php?c=click&id='.$link['id'];
					}
				//var_dump($link);
			?>
			<a href="<?php echo $url; ?>" target="_blank" title = "<?php echo $link['description']; ?>">
			<div class="mdui-col-lg-2 mdui-col-md-3 mdui-col-sm-4 mdui-col-xs-6 link-space" id = "id_<?php echo $link['id']; ?>" link-title = "<?php echo $link['title']; ?>" link-url = "<?php echo $link['url']; ?>">
				<!-- 用来搜索匹配使用 -->
				<span style = "display:none;"><?php echo $link['url']; ?></span>
				<!-- 用来搜索匹配使用END -->
				<!--定义一个卡片-->
				<div class="mdui-card link-line mdui-hoverable">
						<!-- 如果是私有链接，则显示角标 -->
						<?php if($link['property'] == 1 ) { ?>
						<div class="angle">
							<span> </span>
						</div>
						<?php } ?>
						<!-- 角标END -->
							<div class="mdui-card-primary" style = "padding-top:16px;">
									<div class="mdui-card-primary-title link-title">
										<!-- 网站图标显示方式 -->
										<?php if( $theme_config->favicon == "online") { ?>
											<img src="https://favicon.png.pub/v1/<?php echo base64($link['url']); ?>" alt="HUAN" width="16" height="16">
										<?php }else{ ?>
											<img src="/index.php?c=ico&text=<?php echo $link['title']; ?>" alt="" width="16" height="16" />
										<?php } ?>
										<span class="link_title"><?php echo $link['title']; ?></span> 
									</div>
							</div>
					<!-- 卡片的内容end -->
					<div class="mdui-card-content mdui-text-color-black-disabled" style="padding-top:0px;"><span class="link-content"><?php echo $link['description']; ?></span></div>
				</div>
				<!--卡片END-->
			</div>
			</a>
			<?php } ?>
			<!-- 遍历链接END -->

			<!-- 更多 -->
			<?php
				if( !isset($_GET['cid']) && get_links_number($fid) > $link_num  ) {
			?>
			<a href="/index.php?cid=<?php echo $category['id']; ?>" title = "点此可查看该分类下的所有链接">
				<div class="mdui-col-lg-2 mdui-col-md-3 mdui-col-sm-4 mdui-col-xs-6 link-space">
					<!--定义一个卡片-->
					<div class="mdui-card link-line mdui-hoverable">
						<div class="mdui-card-primary" style = "padding-top:16px;">
								<div class="mdui-card-primary-title link-title">
									<!-- 网站图标显示方式 -->
									<img src="/index.php?c=ico&text=更" alt="" width="16" height="16" />
									<span class="link_title">查看更多>></span> 
								</div>
						</div>
						<!-- 卡片的内容end -->
						<div class="mdui-card-content mdui-text-color-black-disabled" style="padding-top:0px;">
							<span class="link-content">
								点此可查看该分类下的所有链接！
							</span>
						</div>
					</div>
					<!--卡片END-->
				</div>
			</a>
			<!-- 更多END -->
			<?php } ?>
			<?php } ?>
		</div>
		<!-- row end -->

		
	</div>
	<div class="mdui-divider" style = "margin-top:2em;"></div>
	<!--正文内容部分END-->
	<!-- footer部分 -->
	<!-- 未经作者授权，请勿去掉版权，否则可能影响作者更新代码的积极性或直接放弃维护此项目。 -->
	<footer>
		<?php if(empty( $site['custom_footer']) ){ ?>
		© 2023 Powered by <a target = "_blank" href="https://github.com/helloxz/onenav" title = "简约导航/书签管理器" rel = "nofollow">OneNav</a>.The author is <a href="https://www.xiaoz.me/" target="_blank" title = "小z博客">xiaoz.me</a>
		<?php }else{
			echo $site['custom_footer'];
		} ?>
	</footer>
	<!-- footerend -->
	
</body>
<script src = 'static/js/jquery.min.js'></script>
<script src="static/layer/layer.js"></script>
<script src = 'static/jQuery-contextMenu/jquery.contextMenu.min.js'></script>
<script src = 'static/js/clipBoard.min.js'></script>
<script src = 'static/js/qrcode.min.js'></script>
<script src = "templates/<?php echo $template; ?>/static/holmes.js"></script>
<script src="templates/<?php echo $template; ?>/static/embed.js?v=<?php echo $version; ?>"></script>
<script>
<?php echo $onenav['right_menu']; ?>
</script>
</html>
