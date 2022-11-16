<!DOCTYPE html>
<html lang="zh-cn" xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta charset="utf-8" />
	<title><?php echo $link['title']; ?> - <?php echo $site['title']; ?></title>
	<meta name="keywords" content="<?php echo $link['title']; ?>" />
	<meta name="description" content="<?php echo $link['description']; ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="static/bootstrap4/css/bootstrap.min.css" type="" media=""/>
	<script src = "static/js/jquery.min.js"></script>
	<script src="static/bootstrap4/js/bootstrap.min.js"></script>
	<style>
		body{
			background-color:#f3f3f3;
		}
		.prevent-overflow{
			width:260px;
			overflow: hidden;/*超出部分隐藏*/
			white-space: nowrap;/*不换行*/
			text-overflow:ellipsis;/*超出部分文字以...显示dsds*/
		}
		.a_d img{
			max-width:100%;
			padding-top:1em;
			padding-bottom:1em;
		}
		#menu{
			width:100%;
			background-color: #343a40!important;
		}
		.link-box{
			background-color:#FFFFFF;
			border-radius:6px;
			text-align:center;
		}
		.link-box .notice-title{
			font-size:22px;
			color:#2f2f2f;
			padding-top:24px;
		}
		.link-box .notice-des{
			color:#888888;
			font-size:16px;
		}
		.link-box .link{
			border:border:1px solid;
			border-radius:4px;
			background:#fafafa;
			width:90%;
			margin-left:auto;
			margin-right:auto;
			padding:16px;
			margin-top:12px;
			text-align:left;
			overflow: hidden;/*超出部分隐藏*/
			white-space: nowrap;/*不换行*/
			text-overflow:ellipsis;/*超出部分文字以...显示dsds*/
		}
		.link-box .icon{
			width:40px;
			height:40px;
			background:#bcc6d8;
			line-height:36px;
			border-radius:2px;
			text-align:center;
			display:inline-block;
			/* font-size:20px; */
		}
		.link-btn a{
			margin-top:20px;
			margin-bottom:20px;
			border-radius:22px;
			color:#ea725d;
			border:1px solid #ea725d;
			background:#FFFFFF;
			width:166px;
		}
		.link-btn a:hover{
			border:1px solid #ea725d;
			background:#ea725d;
		}
		.link a{
			text-decoration-line: none; 
			-moz-text-decoration-line: none;
		}
		.site-title{
			text-align:center;
			padding-bottom:18px;
		}
		.site-title h1{
			font-size:2.2rem;
		}
		.site-title a{
			color:#333333;
			text-decoration-line: none; 
			-moz-text-decoration-line: none;
		}
	</style>
	<?php echo $site['custom_header']; ?>
	<?php
		//不存在多个链接的情况，如果用户已经登录，则1s后跳转，不然等5s
		if( empty($link['url_standby']) ) {
			//游客停留时间
			$visitor_stay_time = $transition_page['visitor_stay_time'];
			//管理员停留时间
			$admin_stay_time = $transition_page['admin_stay_time'];
			
			if ($is_login) {
				header("Refresh:$admin_stay_time;url=".$link['url']);
			}
			else{
				header("Refresh:$visitor_stay_time;url=".$link['url']);
			}
		}
		
	?>
</head>
<body>
	
	<div class="container" style = "margin-top:24px;">
		<!-- 广告1 -->
		<div class= "row">
			<div class="col-sm-8 offset-sm-2 a_d">
			<?php echo $transition_page['a_d_1']; ?>
			</div>
		</div>
		<!-- 广告1 END -->
		<div class="row">
			<!-- 网站名称 -->
			<div class="col-sm-8 offset-sm-2">
				<div class="site-title"><a href="/" title = "<?php echo $site['title']; ?>"><h1><?php echo $site['title']; ?></h1></a></div>
			</div>
			<!-- 网站名称END -->
			<!-- 链接内容 -->
			<div class="col-sm-8 offset-sm-2">
				<div class="link-box">
					<div class="notice-title">即将跳转到外部网站</div>
					<div class="notice-des">安全性未知，是否继续</div>
					<div class="link" title="主链接">
						<span class="icon"><?xml?><svg width="24" height="24" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M26.2401 16.373L17.1001 7.23303C14.4388 4.57168 10.0653 4.6303 7.33158 7.36397C4.59791 10.0976 4.53929 14.4712 7.20064 17.1325L15.1359 25.0678" stroke="#f3f3f3" stroke-width="4" stroke-linecap="round" stroke-linejoin="bevel"/><path d="M32.9027 23.0031L40.838 30.9384C43.4994 33.5998 43.4407 37.9733 40.7071 40.707C37.9734 43.4407 33.5999 43.4993 30.9385 40.8379L21.7985 31.6979" stroke="#f3f3f3" stroke-width="4" stroke-linecap="round" stroke-linejoin="bevel"/><path d="M26.1093 26.1416C28.843 23.4079 28.9016 19.0344 26.2403 16.373" stroke="#f3f3f3" stroke-width="4" stroke-linecap="round" stroke-linejoin="bevel"/><path d="M21.7989 21.7984C19.0652 24.5321 19.0066 28.9056 21.6679 31.5669" stroke="#f3f3f3" stroke-width="4" stroke-linecap="round" stroke-linejoin="bevel"/></svg></span>
						<a href="<?php echo $link['url']; ?>" rel = "nofollow" title = "<?php echo $link['title']; ?>"><?php echo $link['url']; ?></a>
					</div>
					<?php if( !empty( $link['url_standby'] ) ) { ?>
					<div class="link" title = "备用链接">
						<span class="icon">
						<?xml?><svg width="24" height="24" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M30 19H20C15.5817 19 12 22.5817 12 27C12 31.4183 15.5817 35 20 35H36C40.4183 35 44 31.4183 44 27C44 24.9711 43.2447 23.1186 42 21.7084" stroke="#f3f3f3" stroke-width="4" stroke-linecap="round" stroke-linejoin="bevel"/><path d="M6 24.2916C4.75527 22.8814 4 21.0289 4 19C4 14.5817 7.58172 11 12 11H28C32.4183 11 36 14.5817 36 19C36 23.4183 32.4183 27 28 27H18" stroke="#f3f3f3" stroke-width="4" stroke-linecap="round" stroke-linejoin="bevel"/></svg>
						</span>
						<a href="<?php echo $link['url_standby']; ?>" rel = "nofollow" title = "<?php echo $link['title']; ?>"><?php echo $link['url_standby']; ?></a>
					</div>
					<?php } ?>
					<div class="link-btn">
						<a class="btn btn-primary" rel = "nofollow" title = "继续前往：<?php echo $link['title']; ?>" href="<?php echo $link['url']; ?>">继续前往</a>
					</div>
				</div>
			</div>
			<!-- 链接内容END -->
			
		</div>
		<!-- 广告2 -->
		<div class= "row">
			<div class="col-sm-8 offset-sm-2 a_d">
			<?php echo $transition_page['a_d_2']; ?>
			</div>
		</div>
		<!-- 广告2 END -->
		
	</div>
</body>
</html>
