<!DOCTYPE html>
<html lang="zh-ch" xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta charset="utf-8" />
	<title><?php echo $site_setting['title']; ?></title>
	<meta name="generator" content="EverEdit" />
	<meta name="author" content="xiaoz<www.xiaoz.me>" />
	<meta name="keywords" content="<?php echo $site_setting['keywords']; ?>" />
	<meta name="description" content="<?php echo $site_setting['description']; ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel='stylesheet' href='https://libs.xiaoz.top/mdui/v1.0.1/css/mdui.min.css'>
	<link rel="stylesheet" href="https://libs.xiaoz.top/font-awesome/4.7.0/css/font-awesome.css">
	<link rel="stylesheet" href="templates/<?php echo TEMPLATE; ?>/static/style.css">
	<script src = 'https://libs.xiaoz.top/mdui/v1.0.1/js/mdui.min.js'></script>
</head>
<body class = "mdui-drawer-body-left mdui-appbar-with-toolbar mdui-theme-primary-indigo mdui-theme-accent-pink mdui-theme-layout-auto mdui-loaded">
	<!--导航工具-->
	<header class = "mdui-appbar mdui-appbar-fixed">
		<div class="mdui-toolbar mdui-color-theme">
		<!-- <button class="mdui-btn" mdui-drawer="{target: '#drawer'}"><i class="mdui-icon material-icons">home</i></button> -->
		<span class="mdui-btn mdui-btn-icon mdui-ripple mdui-ripple-white" mdui-drawer="{target: '#drawer', swipe: true}"><i class="mdui-icon material-icons">menu</i></span>
		  <!-- <a href="javascript:;" class="mdui-btn mdui-btn-icon"><i class="mdui-icon material-icons">home</i></a> -->
		  <a href="/" class = "mdui-typo-headline" title = "<?php echo $site_setting['description'] ?>"><span class="mdui-typo-title"><?php echo $site_setting['logo']; ?></span></a>
		  <div class="mdui-toolbar-spacer"></div>
		  <!-- 搜索框 -->
		  <!-- <div class="mdui-col-lg-3">
			  <div class="mdui-textfield mdui-textfield-expandable mdui-float-right">
			<button class="mdui-textfield-icon mdui-btn mdui-btn-icon"><i class="mdui-icon material-icons">search</i></button>
			<input class="mdui-textfield-input" type="text" placeholder="Search"/>
			<button class="mdui-textfield-close mdui-btn mdui-btn-icon"><i class="mdui-icon material-icons">close</i></button>
			</div>
		</div> -->
		  <!-- 搜索框END -->
		  <a href="https://github.com/helloxz/onenav" rel = "nofollow" target="_blank" class="mdui-btn mdui-btn-icon mdui-ripple mdui-ripple-white" mdui-tooltip="{content: '查看 Github'}">
      <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 36 36" enable-background="new 0 0 36 36" xml:space="preserve" class="mdui-icon" style="width: 24px;height:24px;">
        <path fill-rule="evenodd" clip-rule="evenodd" fill="#ffffff" d="M18,1.4C9,1.4,1.7,8.7,1.7,17.7c0,7.2,4.7,13.3,11.1,15.5
	c0.8,0.1,1.1-0.4,1.1-0.8c0-0.4,0-1.4,0-2.8c-4.5,1-5.5-2.2-5.5-2.2c-0.7-1.9-1.8-2.4-1.8-2.4c-1.5-1,0.1-1,0.1-1
	c1.6,0.1,2.5,1.7,2.5,1.7c1.5,2.5,3.8,1.8,4.7,1.4c0.1-1.1,0.6-1.8,1-2.2c-3.6-0.4-7.4-1.8-7.4-8.1c0-1.8,0.6-3.2,1.7-4.4
	c-0.2-0.4-0.7-2.1,0.2-4.3c0,0,1.4-0.4,4.5,1.7c1.3-0.4,2.7-0.5,4.1-0.5c1.4,0,2.8,0.2,4.1,0.5c3.1-2.1,4.5-1.7,4.5-1.7
	c0.9,2.2,0.3,3.9,0.2,4.3c1,1.1,1.7,2.6,1.7,4.4c0,6.3-3.8,7.6-7.4,8c0.6,0.5,1.1,1.5,1.1,3c0,2.2,0,3.9,0,4.5
	c0,0.4,0.3,0.9,1.1,0.8c6.5-2.2,11.1-8.3,11.1-15.5C34.3,8.7,27,1.4,18,1.4z"></path>
	  </svg>
	  <a href="/index.php?c=login" title = "登录OneNav" target="_blank" class="mdui-btn mdui-btn-icon"><i class="mdui-icon material-icons">account_circle</i></a>
    </a>
		</div>
	</header>
	<!--导航工具END-->
	<!-- 返回顶部按钮 -->
	<div id="top"></div>
	<div class="top mdui-shadow-10"><a href="javascript:;" title="返回顶部" onclick="gotop()"><i class="mdui-icon material-icons">arrow_drop_up</i></div>
	<!-- 返回顶部END -->
		<!--左侧抽屉导航-->
	<!-- 默认抽屉栏在左侧 -->
	<div class="mdui-drawer" id="drawer">
	  <ul class="mdui-list">
	  	<?php
			//遍历分类目录并显示
			foreach ($categorys as $category) {
			//var_dump($category);
			
		?>
		<a href="#category-<?php echo $category['id']; ?>">
			<li class="mdui-list-item mdui-ripple">
				<div class="mdui-list-item-content category-name"><?php echo $category['name']; ?></div>
			</li>
		</a>
	    
		<?php } ?>
		<a href="https://www.xiaoz.me/" target="_blank" title="小z博客">
			<li class="mdui-list-item mdui-ripple">
			<div class="mdui-list-item-content category-name"><i class="fa fa-user-circle"></i> About</div>
			</li>
		</a>
	  </ul>
	</div>
	<!--左侧抽屉导航END-->

	<!--正文内容部分-->
	<div class="mdui-container">
		<div class="mdui-row">
			<!-- 遍历分类目录 -->
            <?php foreach ( $categorys as $category ) {
                $fid = $category['id'];
                $links = get_links($fid);
                //如果分类是私有的
                if( $category['property'] == 1 ) {
                    $property = '<i class="fa fa-expeditedssl" style = "color:#5FB878"></i>';
                }
                else {
                    $property = '';
                }
            ?>
			<div id = "category-<?php echo $category['id']; ?>" class = "mdui-col-xs-12 mdui-typo-title" style = "margin-top:1.5em;">
				<?php echo $category['name']; ?> <?php echo $property; ?>
				<span class = "mdui-typo-caption"><?php echo $category['description']; ?></span>
			</div>
			<!-- 遍历链接 -->
			<?php
				foreach ($links as $link) {
					//默认描述
					$link['description'] = empty($link['description']) ? '作者很懒，没有填写描述。' : $link['description'];
					
				//var_dump($link);
			?>
			<div class="mdui-col-lg-3 mdui-col-xs-12 link-space">
				<!--定义一个卡片-->
				<div class="mdui-card link-line mdui-hoverable">
						<!-- 如果是私有链接，则显示角标 -->
						<?php if($link['property'] == 1 ) { ?>
						<div class="angle">
							<span> </span>
						</div>
						<?php } ?>
						<!-- 角标END -->
						<a id = "id_<?php echo $link['id']; ?>" href="/index.php?c=click&id=<?php echo $link['id']; ?>" target="_blank" title = "<?php echo $link['description']; ?>">
							<div class="mdui-card-primary" style = "padding-top:16px;">
									<div class="mdui-card-primary-title link-title">
										<img src="https://favicon.rss.ink/v1/<?php echo base64($link['url']); ?>" alt="HUAN" width="16" height="16">
										<span><?php echo $link['title']; ?></span> 
									</div>

							</div>
						</a>
						
					
					<!-- 卡片的内容end -->
					<div class="mdui-card-content mdui-text-color-black-disabled" style="padding-top:0px;"><span class="link-content"><?php echo $link['description']; ?></span></div>
				</div>
				<!--卡片END-->
			</div>
			<?php } ?>
			<!-- 遍历链接END -->
			<?php } ?>
		</div>
	</div>
	<div class="mdui-divider" style = "margin-top:2em;"></div>
	<!--正文内容部分END-->
	<!-- footer部分 -->
	<footer>
		© 2020 Powered by <a target = "_blank" href="https://github.com/helloxz/onenav" title = "简约导航/书签管理器" rel = "nofollow">OneNav</a>.The author is <a href="https://www.xiaoz.me/" target="_blank" title = "小z博客">xiaoz.me</a>
	</footer>
	<!-- footerend -->
</body>
<script>
	//var inst = new mdui.Drawer(selector, options);
</script>
<script src = 'https://libs.xiaoz.top/jquery/2.2.4/jquery.min.js'></script>
<script src="templates/<?php echo TEMPLATE; ?>/static/embed.js"></script>
</html>
