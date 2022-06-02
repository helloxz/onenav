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
        <ol>
            <li>您可以前往：<a href="https://dwz.ovh/69h9q" rel = "nofollow" target = "_blank" title = "购买订阅服务">https://dwz.ovh/69h9q</a> 购买订阅服务，订阅后可以：</li>
            <li>1. 享受一键更新OneNav</li>
            <li>2. 可在线更新和下载主题（实现中...）</li>
            <li>3. 可享受一对一售后服务（仅限高级版和商业版）</li>
            <li>4. 可帮助OneNav持续发展，让OneNav变得更加美好</li>
            <li>5. 更多高级功能（自定义版权、广告管理等）</li>
        </ol>
      </div>
    </div>
    <!-- 说明提示框END -->
    <!-- 订阅表格 -->
    <div class="layui-col-lg6">
    <h2 style = "margin-bottom:1em;">我的订阅：</h2>
    <form class="layui-form layui-form-pane" action="">

        <div class="layui-form-item">
            <label class="layui-form-label">订单号</label>
            <div class="layui-input-block">
                <input type="text" id = "order_id" name="order_id" value = "<?php echo $subscribe['order_id']; ?>" required  lay-verify="required" autocomplete="off" placeholder="请输入订单号" class="layui-input">
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">订阅邮箱</label>
            <div class="layui-input-block">
                <input type="email" name="email" id = "email" value = "<?php echo $subscribe['email']; ?>" required lay-verify="required|email" autocomplete="off" placeholder="订阅邮箱" class="layui-input">
            </div>
        </div>

        <div class="layui-form-item" style = "display:none;">
            <label class="layui-form-label">域名</label>
            <div class="layui-input-block">
                <input type="text" name="domain" id = "domain" value = "<?php echo $_SERVER['HTTP_HOST']; ?>" autocomplete="off" placeholder="网站域名" class="layui-input">
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">到期时间</label>
            <div class="layui-input-block">
            <input type="text" name="end_time" id = "end_time" readonly="readonly" value = "<?php echo date("Y-m-d",$subscribe['end_time']); ?>" autocomplete="off" placeholder="订阅到期时间" class="layui-input">
            </div>
        </div>

        <div class="layui-form-item">
            <button class="layui-btn" lay-submit="" lay-filter="set_subscribe">保存设置</button>
            <button class="layui-btn" lay-submit="" lay-filter="reset_subscribe">删除订阅</button>
            <a class="layui-btn layui-btn-danger" rel = "nofollow" target = "_blank" title = "点此购买订阅" href="https://dwz.ovh/69h9q"><i class="fa fa-shopping-cart"></i> 购买订阅</a>
        </div>

    </form>
    </div>
    <!-- 订阅表格END -->
    <hr>
    <div class="layui-col-lg12">
        <!-- <h3>更新</h3> -->
        <form class="layui-form layui-form-pane" action="">

            <div class="layui-form-item">
                <div class="layui-inline">
                    <label class="layui-form-label">当前版本</label>
                    <div class="layui-input-inline">
                        <input type="text" readonly = "readonly" id = "current_version" name="current_version" value = "<?php echo $current_version; ?>" required  lay-verify="required" autocomplete="off" placeholder="当前版本" class="layui-input">
                    </div>
                    <label class="layui-form-label">可用版本</label>
                    <div class="layui-input-inline">
                        <input type="text" readonly = "readonly" name="new_version" id = "new_version" value = "" required  lay-verify="required" autocomplete="off" placeholder="无可用版本" class="layui-input">
                    </div>
                </div>
            </div>
            

        </form>
        <div class="layui-input-inline">
            <button id = "btn_update" class="layui-btn" lay-submit="" onclick = "update_main()">立即更新</button>
            <button id = "btn_updating" style = "display:none;" class="layui-btn layui-btn-disabled" >更新中，请勿关闭窗口</button>
            <a href="https://dwz.ovh/7q4z6" title = "点此查看更新失败的原因" rel = "nofollow" target = "_blank">更新失败？</a>
        </div>
        <!-- 更新进度条 -->
        <div id="progress">
            <div class="layui-progress layui-progress-big" lay-filter="update_progress" lay-showPercent="true">
                <div class="layui-progress-bar layui-bg-blue" lay-percent="0%"></div>
            </div>
            <div id="msg" style = "margin-top:1em;"></div>
        </div>
        <!-- 更新进度条END -->
    </div>

    <!-- 日志面板 -->
    <div class="layui-col-lg12" style = "margin-top:1em;">
    <div class="layui-collapse">
        <div class="layui-colla-item">
            <h2 class="layui-colla-title">日志输出：</h2>
            <div class="layui-colla-content">
                <div id = "update_log"></div>
            </div>
        </div>
    </div>
    <!-- 日志面板END -->
</div>
</div>


<?php include_once(dirname(__DIR__).'/footer.php'); ?>

<script>
    
    //获取可更新版本
    function available_version() {
        var current_version = $("#current_version").val();
        $.get("https://onenav.xiaoz.top/v1/get_version.php",{version:current_version},function(data,status){
            $("#new_version").val(data);
        });
    }
    available_version();
    //立即更新按钮
    function update_main() {
        //清空日志面板
        var update_log = $("#update_log").html();
        var current_version = $("#current_version").val();
        var new_version = $("#new_version").val();
        //如果当前版本和最新版本相同，则不能更新
        if (current_version >= new_version) {
            layer.msg("已经是最新版本，无需更新！",{icon:5});
            return false;
        }
        //如果可用版本为空
        if ( new_version == '' ) {
            layer.msg("无可用版本，无需更新！",{icon:5});
            return false;
        }
        
        //否则可以更新
        else {
            $("#btn_update").hide();
            $("#btn_updating").show();
            update_status("1%","准备更新...");
            $("#update_log").append("准备更新...\n");
            //第一步检查更新信息
            $.get("/index.php?c=api&method=check_subscribe",function(data,status){
                update_status("10%","正在验证订阅信息...");
                $("#update_log").append("正在验证订阅信息...<br />");
                if( data.code == 200 ) {
                    update_status("30%","订阅信息验证通过...");
                    $("#update_log").append("订阅信息验证通过...<br />");
                    //取得必要的变量
                    var email = data.data.email;
                    var domain = data.data.domain;
                    var key = data.data.key;
                    var value = data.data.value;
                    //下载更新程序
                    $.get("/index.php?c=api&method=up_updater",function(data,status) {
                        update_status("50%","正在检查更新程序...");
                        $("#update_log").append("正在检查更新程序...<br />");
                        if( data.code == 200 ) {
                            //继续往下执行
                            update_status("70%","更新程序准备完成...");
                            $("#update_log").append("更新程序准备完成...<br />");
                            //准备下载升级包
                            update_status("80%","准备下载升级包...");
                            $("#update_log").append("准备下载升级包...<br />");
                            $.get("/update.php",{version:new_version,key:key,value:value,type:'main'},function(data,stauts){
                                update_status("90%","升级包下载完毕，正在校验版本...");
                                $("#update_log").append("升级包下载完毕，正在校验版本...<br />");
                                if( data.code == 200 ) {
                                    //校验新版本
                                    $.get("/index.php?c=api&method=check_version",{version:new_version},function(data,status){
                                        if(data.code == 200) {
                                            update_status("100%","更新完成，请前往后台检查<a href = '/index.php?c=admin'>更新数据库</a>！");
                                            $("#update_log").append("更新完成，请前往后台检查<a href = '/index.php?c=admin'>更新数据库</a>！<br />");
                                            //$("#btn_update").show();
                                            //$("#btn_updating").hide();
                                            $("#btn_updating").show();
                                        }
                                        else {
                                            update_error(data.msg);
                                            //layer.msg(data.msg,{icon:5,time: 0});
                                        }
                                    });
                                }
                                else{
                                    update_error(data.msg);
                                    //layer.msg(data.msg,{icon:5,time: 0});
                                }
                            });
                        }
                        else {
                            update_error(data.msg);
                            //layer.msg(data.msg,{icon:5,time: 0});
                        }
                    });
                }
                else{
                    update_error(data.msg);
                    //layer.msg(data.msg,{icon:5,time: 0});
                }
            });
        }
    }
    //进度和更新提示函数
    function update_status(progress,msg) {
        layui.use('element', function(){
            var element = layui.element;
            $("#progress").show();
            element.progress('update_progress', progress);
            $("#msg").html(msg);
        });
        
    }
    //更新失败时的提示
    function update_error(msg) {
            layer.open({
            title: '更新失败:'
            ,content: msg
            ,icon:5
        }); 
        $("#progress").hide();
        $("#btn_update").show();
        $("#btn_updating").hide();
    }
</script>