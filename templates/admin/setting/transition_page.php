<?php echo $transition_page['control']; ?>
<!-- 过渡页面设置 -->
<?php require_once(dirname(__DIR__).'/header.php'); ?>
<?php include_once(dirname(__DIR__).'/left.php'); ?>
<div class="layui-body">
<!-- 内容主体区域 -->
<div class="layui-row content-body place-holder">
    <!-- 说明提示框 -->
    <div class="layui-col-lg12">
      <div class="setting-msg">
      过渡页使用说明，请参考：<a href="https://dwz.ovh/mrkx1" target = "_blank" title = "过渡页使用说明">https://dwz.ovh/mrkx1</a>
      </div>
    </div>
    <!-- 说明提示框END -->
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

        <div class="layui-form-item layui-form-text">
            <label class="layui-form-label">过渡页菜单(订阅可用)</label>
            <div class="layui-input-block">
                <textarea name = "menu" placeholder="请参考帮助文档进行设置！" rows = "4" class="layui-textarea"><?php echo $transition_page['menu']; ?></textarea>
            </div>
        </div>

        <!-- <div class="layui-form-item layui-form-text">
            <label class="layui-form-label">自定义footer，支持HTML(订阅可用)</label>
            <div class="layui-input-block">
                <textarea name = "footer" placeholder="请参考帮助文档进行设置！" rows = "4" class="layui-textarea"><?php echo $transition_page['footer']; ?></textarea>
            </div>
        </div> -->

        <div class="layui-form-item layui-form-text">
            <label class="layui-form-label">广告1(订阅可用)</label>
            <div class="layui-input-block">
                <textarea name = "a_d_1" placeholder="请参考帮助文档进行设置！" rows = "2" class="layui-textarea"><?php echo $transition_page['a_d_1']; ?></textarea>
            </div>
        </div>

        <div class="layui-form-item layui-form-text">
            <label class="layui-form-label">广告2(订阅可用)</label>
            <div class="layui-input-block">
                <textarea name = "a_d_2" placeholder="请参考帮助文档进行设置！" rows = "2" class="layui-textarea"><?php echo $transition_page['a_d_2']; ?></textarea>
            </div>
        </div>

        <div class="layui-form-item">
            <button class="layui-btn" lay-submit="" lay-filter="set_transition_page">保存设置</button>
        </div>

    </form>
    </div>
</div>
</div>

<?php include_once(dirname(__DIR__).'/footer.php'); ?>