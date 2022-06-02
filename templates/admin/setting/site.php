<!-- 站点设置 -->
<!-- 主题设置 -->
<?php require_once(dirname(__DIR__).'/header.php'); ?>
<?php include_once(dirname(__DIR__).'/left.php'); ?>
<div class="layui-body">
<!-- 内容主体区域 -->
<div class="layui-row content-body place-holder" style="padding-bottom: 3em;">
    <!-- 说明提示框 -->
    <div class="layui-col-lg12">
      <div class="setting-msg">
      站点设置使用说明，请参考：<a href="https://dwz.ovh/un5rz" target = "_blank" title = "站点设置使用说明">https://dwz.ovh/un5rz</a>
      </div>
    </div>
    <!-- 说明提示框END -->
    <div class="layui-col-lg6">
    <form class="layui-form layui-form-pane" action="">

        <div class="layui-form-item">
            <label class="layui-form-label">网站标题</label>
            <div class="layui-input-block">
                <input type="text" name="title" value = "<?php echo $site['title']; ?>" required  lay-verify="required" autocomplete="off" placeholder="请输入网站标题" class="layui-input">
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">网站logo</label>
            <div class="layui-input-block">
                <input type="text" name="logo" value = "<?php echo $site['logo']; ?>" autocomplete="off" placeholder="网站logo地址，部分主题可能不支持" class="layui-input">
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">副标题</label>
            <div class="layui-input-block">
            <input type="text" name="subtitle" value = "<?php echo $site['subtitle']; ?>" autocomplete="off" placeholder="请输入副标题" class="layui-input">
            </div>
        </div>


        <div class="layui-form-item">
            <label class="layui-form-label">网站关键词</label>
            <div class="layui-input-block">
            <input type="text" name="keywords" value = "<?php echo $site['keywords']; ?>" autocomplete="off" placeholder="输入网站关键词，用英文状态的逗号分隔" class="layui-input">
            </div>
        </div>

        <div class="layui-form-item layui-form-text">
            <label class="layui-form-label">网站描述</label>
            <div class="layui-input-block">
            <textarea placeholder="网站描述，一般不超过200字符" name = "description" class="layui-textarea"><?php echo $site['description']; ?></textarea>
            </div>
        </div>

        <div class="layui-form-item layui-form-text">
            <label class="layui-form-label">自定义header</label>
            <div class="layui-input-block">
                <textarea name = "custom_header" placeholder="您可以自定义<header>...</header>之间的内容，如果您不清楚，请勿填写！" rows = "8" class="layui-textarea"><?php echo $site['custom_header']; ?></textarea>
            </div>
        </div>

        <div class="layui-form-item layui-form-text">
            <label class="layui-form-label">自定义footer(支持HTML代码，订阅可用)</label>
            <div class="layui-input-block">
                <textarea name = "custom_footer" placeholder="自定义站点底部信息，请填写HTML代码" class="layui-textarea"><?php echo $site['custom_footer']; ?></textarea>
            </div>
        </div>

        <div class="layui-form-item">
            <button class="layui-btn" lay-submit="" lay-filter="set_site">保存设置</button>
        </div>

    </form>
    </div>
</div>
</div>

<?php include_once(dirname(__DIR__).'/footer.php'); ?>