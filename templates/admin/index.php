<?php include_once('header.php'); ?>
<?php include_once('left.php'); ?>
  
  
  <div class="layui-body">
    <!-- 内容主体区域 -->
    <div style="padding: 15px;">
      <div class="layui-container" style = "margin-top:2em;">
        <div class="layui-row layui-col-space18">
          <div class="layui-col-lg4">
            <div class = "admin-msg">当前版本：<?php echo file_get_contents('version.txt'); ?></div>
          </div>
          <div class="layui-col-lg4">
            <div class = "admin-msg">QQ群1：147687134</div>
          </div>
          <div class="layui-col-lg4">
            <div class = "admin-msg">QQ群2：932795364</div>
          </div>
          <div class="layui-col-lg4">
            <div class = "admin-msg">社区支持：<a href="https://dwz.ovh/vd0bw" rel = "nofollow" target="_blank" title="访问下问社区">https://dwz.ovh/vd0bw</a></div>
          </div>
          <div class="layui-col-lg4">
            <div class = "admin-msg">项目地址：<a href="https://github.com/helloxz/onenav" rel = "nofollow" target="_blank">https://github.com/helloxz/onenav</a></div>
          </div>
          <div class="layui-col-lg4">
            <div class = "admin-msg">帮助文档：<a href="https://dwz.ovh/onenav" rel = "nofollow" target="_blank">https://dwz.ovh/onenav</a></div>
          </div>
          <div class="layui-col-lg4">
            <div class = "admin-msg">QQ:337003006</div>
          </div>
          <div class="layui-col-lg4">
            <div class = "admin-msg">Blog: <a href="https://www.xiaoz.me/" rel = "nofollow" target="_blank">https://www.xiaoz.me/</a></div>
          </div>
          <div class="layui-col-lg4">
            <div class = "admin-msg">捐赠地址: <a href="https://dwz.ovh/donation" rel = "nofollow" target="_blank">https://dwz.ovh/donation</a></div>
          </div>
        </div>
      </div>
    </div>
  </div>
  
<?php include_once('footer.php'); ?>
<script>
  check_weak_password();
</script>
