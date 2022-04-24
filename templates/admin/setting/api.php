<?php echo $transition_page['control']; ?>
<!-- API页面设置 -->
<?php require_once(dirname(__DIR__).'/header.php'); ?>
<?php include_once(dirname(__DIR__).'/left.php'); ?>
<div class="layui-body">
<!-- 内容主体区域 -->
<div class="layui-row content-body place-holder">
    <!-- 说明提示框 -->
    <div class="layui-col-lg12">
      <div class="setting-msg">
      API使用说明，请参考：<a href="https://dwz.ovh/viot5" target = "_blank" title = "OneNav API使用说明">https://dwz.ovh/viot5</a>
      </div>
    </div>
    <!-- 说明提示框END -->
    <div class="layui-col-lg6">
    <form class="layui-form layui-form-pane" action="">

        <div class="layui-form-item">
            <label class="layui-form-label" style = "width:130px;">用户名</label>
            <div class="layui-input-inline">
                <input style = "width:400px;" type="text" readonly="readonly" name="username" value = "<?php echo USER; ?>" autocomplete="off" placeholder="OneNav用户名" class="layui-input">
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label" style = "width:130px;">SecretKey</label>
            <div class="layui-input-inline">
                <input style = "width:400px;" type="text" readonly="readonly" name="SecretKey" id = "SecretKey" value = "<?php echo $SecretKey; ?>" autocomplete="off" placeholder="OneNav SecretKey" class="layui-input">
            </div>
            
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label" style = "width:130px;">Token</label>
            <div class="layui-input-inline">
                <input style = "width:400px;" type="text" name="token" id="token" readonly="readonly" autocomplete="off" placeholder="点击下方按钮可以计算Token" class="layui-input">
            </div>
            
        </div>

        <div class="layui-form-item">
            <button class="layui-btn" lay-submit="" lay-filter="create_sk">生成SecretKey</button>
            <button class="layui-btn" lay-submit="" lay-filter="change_sk">更换SecretKey</button>
            <button class="layui-btn" lay-submit="" lay-filter="cal_token">计算Token</button>
        </div>

    </form>
    </div>
</div>
</div>

<?php include_once(dirname(__DIR__).'/footer.php'); ?>