<!DOCTYPE html>
<html lang="zh-cn" xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta charset="utf-8" />
	<title>初始化OneNav用户名/密码</title>
	<meta name="generator" content="EverEdit" />
	<meta name="author" content="" />
	<meta name="keywords" content="" />
	<meta name="description" content="" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<link rel='stylesheet' href='static/layui/css/layui.css'>
	  <link rel='stylesheet' href='templates/admin/static/style.css'>
	  <style>
		  body{
			  /* background:url(templates/admin/static/bg.jpg); */
			  background: linear-gradient(to right, #a8c0ff, #3f2b96);
			  color: #333333;
		  }
		  .box{
			padding:18px;
			background-color:#fff;
			border-radius:12px;
			color: #333333;
			/** 阴影特效 */
			box-shadow: 0 0 10px rgba(0,0,0,0.1);
		  }
		  .box-title{
			text-align:center;
			color: #2f363c;
			padding:18px 0 30px 0;
		  }
		  
	  </style>
</head>
<body>

<div class="layui-container">
	<div class="layui-row">
		
		<div class="layui-col-lg4 layui-col-md-offset4" style ="margin-top:4em;">
			<!-- star box -->
			<div class="box">
			<div class="box-title">
				<h2>初始化OneNav</h2>
			</div>
			<form class="layui-form layui-form-pane" action="">
				<div class="layui-form-item">
					<label class="layui-form-label">用户名</label>
					<div class="layui-input-block">
					<input type="text" name="username" required  lay-verify="required" placeholder="3-32位的字母或数字" autocomplete="off" class="layui-input">
					</div>
				</div>
				
				<div class="layui-form-item">
					<label class="layui-form-label">密码</label>
					<div class="layui-input-block">
					<input type="password" name="password" required  lay-verify="required" placeholder="6-16位字母、数字或特殊字符" autocomplete="off" class="layui-input">
					</div>
				</div>

				<div class="layui-form-item">
					<label class="layui-form-label">确认密码</label>
					<div class="layui-input-block">
					<input type="password" name="password2" required  lay-verify="required" placeholder="6-16位字母、数字或特殊字符" autocomplete="off" class="layui-input">
					</div>
				</div>

				<div class="layui-form-item">
					<label class="layui-form-label">邮箱</label>
					<div class="layui-input-block">
					<input type="text" name="email" required  lay-verify="required|email" placeholder="请输入您的常用邮箱" autocomplete="off" class="layui-input">
					</div>
				</div>
				
				<div class="layui-form-item">
					<button class="layui-btn" lay-submit lay-filter="init_onenav" style = "width:100%;">完成初始化</button>
				</div>
	
			</form>
			</div>
			<!-- end box -->
		</div>
	</div>
</div>


<script src = 'static/js/jquery.min.js'></script>
<script src = 'static/layui/layui.js'></script>
<script src="templates/admin/static/embed.js?v=0.9.25"></script>
</body>
</html>