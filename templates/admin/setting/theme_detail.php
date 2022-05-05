<!-- 主题详情页面 -->
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <title>OneNav后台管理</title>
  <link rel='stylesheet' href='static/layui/css/layui.css'>
  <link rel='stylesheet' href='templates/admin/static/style.css?v=v0.9.17-20220314'>
</head>
<body class="layui-fluid">
    <div class="layui-row" style = "margin-top:1em;">
        <div class="layui-col-sm9" style = "border-right:1px solid #e2e2e2;">
            <div style = "margin-left:1em;margin-right:1em;">
                <img src="<?php echo $theme->screenshot; ?>" alt="" style = "max-width:100%;">
            </div>
        </div>
        <div class="layui-col-sm3">
            <div style = "margin-left:1em;margin-right:1em;">
            <h1><?php echo $theme->name; ?></h1>
            <p>描述：<?php echo $theme->description; ?></p>
            <p>版本：<?php echo $theme->version; ?></p>
            <p>更新时间：<?php echo $theme->update; ?></p>
            <p>作者：<?php echo $theme->author; ?></p>
            <p>使用说明：<a style = "color:#01AAED;" href="<?php echo $theme->help_url; ?>" target="_blank" rel = "nofollow"><?php echo $theme->help_url; ?></a></p>
            <p>主页：<a style = "color:#01AAED;" href="<?php echo $theme->homepage; ?>" target="_blank" rel = "nofollow"><?php echo $theme->homepage; ?></a></p>
            </div>
        </div>
    </div>
</body>
</html>