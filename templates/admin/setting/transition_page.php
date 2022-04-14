<?php echo $transition_page['control']; ?>
<!-- 过渡页面设置 -->
<?php require_once(dirname(__DIR__).'/header.php'); ?>
<?php include_once(dirname(__DIR__).'/left.php'); ?>
<div class="layui-body">
<!-- 内容主体区域 -->
<div class="layui-row content-body">
    <div class="layui-col-lg6">
    <form class="layui-form layui-form-pane" action="">

        <div class="layui-form-item">
            <label class="layui-form-label" style = "width:130px;">过渡页</label>
            <div class="layui-input-block">
            <input type="radio" name="control" value="off" <?php echo ( $transition_page['control'] == 'off' ) ? "checked" : ''; ?> title="关闭">
            <input type="radio" name="control" value="on" <?php echo ( $transition_page['control'] == 'on' ) ? "checked" : ''; ?> title="开启">
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label" style = "width:130px;">访客停留时间</label>
            <div class="layui-input-inline">
                <input type="number" min="0" max="86400" lay-verify="required|number" name="visitor_stay_time" value = "<?php echo $transition_page['visitor_stay_time']; ?>" autocomplete="off" placeholder="访客停留时间，单位s" class="layui-input">
            </div>
            <div class="layui-form-mid layui-word-aux">访客停留时间，单位秒</div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label" style = "width:130px;">管理员停留时间</label>
            <div class="layui-input-inline">
                <input type="number" min="0" max="86400" lay-verify="required|number" name="admin_stay_time" value = "<?php echo $transition_page['admin_stay_time']; ?>" required  lay-verify="required" autocomplete="off" placeholder="管理员停留时间，单位s" class="layui-input">
            </div>
            <div class="layui-form-mid layui-word-aux">管理员停留时间，单位秒</div>
        </div>

        <div class="layui-form-item">
            <button class="layui-btn" lay-submit="" lay-filter="set_transition_page">保存设置</button>
        </div>

    </form>
    </div>
</div>
</div>

<?php include_once(dirname(__DIR__).'/footer.php'); ?>