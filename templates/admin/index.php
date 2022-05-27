<?php include_once('header.php'); ?>
<?php include_once('left.php'); ?>
  
  
  <div class="layui-body place-holder">
    <!-- 内容主体区域 -->
    <div style="padding: 15px;">
      <div class="layui-container" style = "margin-top:2em;">
        <div class="layui-row layui-col-space18">
          <div class="layui-col-lg4">
            <div class = "admin-msg">当前版本：<span id = "current_version"><?php echo file_get_contents('version.txt'); ?></span>
            <span id = "update_msg" style = "display:none;">（<a style = "color: #FF5722;" href = "https://github.com/helloxz/onenav/releases" title = "下载最新版OneNav" target = "_blank" id="current_version">有可用更新</a>）</span>
          </div>
          </div>
            <div class="layui-col-lg4">
                <div class = "admin-msg">
                  最新版本：<span><span id = "getting">获取中...</span><a href = "https://github.com/helloxz/onenav/releases" title = "下载最新版OneNav" target = "_blank" id="latest_version"></a></span>
                  (<a href="/index.php?c=admin&page=setting/subscribe" title = "订阅后可一键更新">一键更新</a>)
                </div>
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
            <div class = "admin-msg">QQ:446199062</div>
          </div>
          <div class="layui-col-lg4">
            <div class = "admin-msg">Blog: <a href="https://www.xiaoz.me/" rel = "nofollow" target="_blank">https://www.xiaoz.me/</a></div>
          </div>
          <div class="layui-col-lg4">
            <div class = "admin-msg">捐赠地址: <a href="https://dwz.ovh/donation" rel = "nofollow" target="_blank">https://dwz.ovh/donation</a></div>
          </div>
            <div class="layui-col-lg4">
                <div class = "admin-msg">Chrome浏览器扩展: <a href="https://dwz.ovh/4kxn2" title = "适用于Chromium内核的浏览器扩展" rel = "nofollow" target="_blank">https://dwz.ovh/4kxn2</a></div>
            </div>

          <!-- 日志输出窗口 -->
          <div class="layui-col-lg12">
            <p><h3 style = "padding-bottom:1em;">日志输出：</h3></p>
            <textarea id = "console_log" name="desc" rows="20" placeholder="日志输出控制台" class="layui-textarea" readonly="readonly"></textarea>
          </div>
          <!-- 日志输出窗口END -->

        </div>
      </div>
    </div>
  </div>
  
<?php include_once('footer.php'); ?>
<script>
  check_db_down();
  check_weak_password();
  get_sql_update_list();
  get_latest_version();
</script>
