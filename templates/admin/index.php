<?php include_once('header.php'); ?>
<?php include_once('left.php'); ?>
  
  
  <div class="layui-body place-holder">
    <!-- 内容主体区域 -->
    <div style="padding: 15px;">
      <div class="layui-container" style = "margin-top:2em;">
        <div class="layui-row layui-col-space18">

          <div class="layui-col-lg3">
            <div class = "admin-msg">
              <h2>当前版本</h2>
              <p class="text">
                <span id = "current_version">
                <?php echo file_get_contents('version.txt'); ?></span>
                <span id = "update_msg" style = "display:none;">（<a style = "color: #FF5722;" href = "https://github.com/helloxz/onenav/releases" title = "下载最新版OneNav" target = "_blank" id="current_version">有可用更新</a>）</span>
              </p>
            </div>
            </div>

            <div class="layui-col-lg3">
                <div class = "admin-msg">
                  <h2>最新版本</h2>
                  <p class="text" id = "new_version">
                    <i class="layui-icon layui-icon-loading-1 layui-anim layui-anim-rotate layui-anim-loop"></i> 
                  </p>
                </div>
            </div>

            <div class="layui-col-lg3">
                <div class = "admin-msg">
                  <h2>分类数量</h2>
                  <p class="text">
                    <a href="/index.php?c=admin&page=category_list"><span id="cat_num"></span></a>
                  </p>
                </div>
            </div>

            <div class="layui-col-lg3">
                <div class = "admin-msg">
                  <h2>链接数量</h2>
                  <p class="text">
                    <a href="/index.php?c=admin&page=link_list"><span id="link_num"></span></a>
                  </p>
                </div>
            </div>

            <div class="layui-col-lg3">
                <div class = "admin-msg">
                  <h2>PHP版本</h2>
                  <p class="text">
                    <span id="php_version"></span>
                  </p>
                </div>
            </div>

          <div class="layui-col-lg3">
            <div class = "admin-msg">
              <h2>交流群</h2>
              <p class="text">
              <a target = "_blank" rel = "nofollow" href="https://dwz.ovh/qxsul" title = "点此加入OneNav交流群">https://dwz.ovh/qxsul</a>
              </p>
            </div>
          </div>

          <div class="layui-col-lg3">
            <div class = "admin-msg">
              <h2>社区支持</h2>
              <p class="text">
                <a href="https://dwz.ovh/vd0bw" rel = "nofollow" target="_blank" title="访问下问社区">https://dwz.ovh/vd0bw</a>
              </p>
            </div>
          </div>

          <div class="layui-col-lg3">
            <div class = "admin-msg">
              <h2>项目地址</h2>
              <p class="text"><a href="https://github.com/helloxz/onenav" rel = "nofollow" target="_blank">https://github.com/helloxz/onenav</a></p>
            </div>
          </div>

          <div class="layui-col-lg3">
            <div class = "admin-msg">
              <h2>帮助文档</h2>
              <p class="text"><a href="https://dwz.ovh/onenav" rel = "nofollow" target="_blank">https://dwz.ovh/onenav</a></p>
            </div>
          </div>

          <div class="layui-col-lg3">
            <div class = "admin-msg">
              <h2>作者博客</h2>
              <p class="text">
              <a href="https://blog.xiaoz.org/" rel = "nofollow" target="_blank">https://blog.xiaoz.org/</a>
              </p>
            </div>
          </div>

          <div class="layui-col-lg3">
            <div class = "admin-msg">
             <h2>购买订阅</h2>
              <p class="text">
                <a href="https://dwz.ovh/69h9q" rel = "nofollow" target="_blank">https://dwz.ovh/69h9q</a>
              </p>
            </div>
          </div>

          <div class="layui-col-lg3">
              <div class = "admin-msg">
                <h2>Chrome浏览器扩展</h2>
                <p class="text">
                  <a href="https://dwz.ovh/4kxn2" title = "适用于Chromium内核的浏览器扩展" rel = "nofollow" target="_blank">https://dwz.ovh/4kxn2</a>
                </p>
              </div>
          </div>

          <!-- 日志输出窗口 -->
          <div class="layui-col-lg12">
            <p><h3 style = "padding-bottom:1em;">日志输出：</h3></p>
            <blockquote class="layui-elem-quote" id = "console_log">
              
            </blockquote>
            <!-- <textarea id = "console_log" name="desc" rows="20" placeholder="日志输出控制台" class="layui-textarea" readonly="readonly"></textarea> -->
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
  app_info();
  // 获取app_info
  function app_info(){
    //alert("dsdfd");
    let api_url = "/index.php?c=api&method=app_info";
    console.log(api_url);
    $.get(api_url,function(data,status){
      data = data.data;
      $("#php_version").html(data.php_version);
      $("#cat_num").html(data.cat_num);
      $("#link_num").html(data.link_num);
    });
  }
  
</script>
