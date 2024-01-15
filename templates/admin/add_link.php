<?php include_once('header.php'); ?>
<?php include_once('left.php'); ?>

<div class="layui-body">
<!-- 内容主体区域 -->
<div class="layui-row content-body place-holder">
    <!-- 说明提示框 -->
    <div class="layui-col-lg12">
      <div class="setting-msg">
        <p>1. 权重越大，排序越靠前</p>
        <p>2. 识别功能可以自动获取链接标题和描述信息，但不确保一定成功</p>
        <p>3. 仅 5iux/heimdall/tushan2/webstack 支持自定义图标，其余主题均自动获取链接图标。</p>
      </div>
    </div>
    <!-- 说明提示框END -->
    <div class="layui-col-lg12">
    <form class="layui-form layui-form-pane">
    <div class="layui-form-item">
    <label class="layui-form-label">URL</label>
    <div class="layui-input-block">
      <input id = "url" name="url" required  lay-verify="required" placeholder="请输入有效链接" autocomplete="off" class="layui-input">
    </div>
  </div>
<!-- 添加备用链接 -->
  <div class="layui-col-lg12">
    <div class="layui-form-item">
    <label class="layui-form-label">备用URL</label>
    <div class="layui-input-block">
      <input type="url" id = "url_standby" name="url_standby" placeholder="请输入备用链接，如果没有，请留空" autocomplete="off" class="layui-input">
    </div>
  </div>
  <!-- 备用链接END -->

  <div class="layui-form-item">
    <label class="layui-form-label">图标</label>
    <div class="layui-input-inline" style="width:810px;">
      <button type="button" id = "iconUpload" name="iconUpload" class="layui-btn"><i class="layui-icon">&#xe67c;</i>上传图标</button>
      <button type="button" class="layui-btn layui-btn-danger" onclick="del_link_icon()">删除图标</button>
      <!-- 显示图标 -->
      <div id="show_icon">
        <img src="static/images/white64.png" alt="">
      </div>
      <!-- 显示图标 -->
      <div class="layui-form-mid layui-word-aux" style = "float:right;">图标最小尺寸建议为 64 * 64像素，大小不超过100KB，仅部分主题支持自定义图标！</div>
    </div>
  </div>

  <div class="layui-form-item">
    <label class="layui-form-label">图标链接</label>
    <div class="layui-input-block">
    <input type="url" id = "font_icon" name="font_icon" placeholder="请输入图标链接，如果没有，请留空（可输入外部https链接）" autocomplete="off" class="layui-input">
    </div>
  </div>

  <div class="layui-form-item">
    <label class="layui-form-label">链接名称</label>
    <div class="layui-input-block">
      <input type="text" id = "title" name="title" required  lay-verify="required" placeholder="请输入链接名称" autocomplete="off" class="layui-input">
    </div>
  </div>
  <div class="layui-form-item">
    <label class="layui-form-label">所属分类</label>
    <div class="layui-input-block">
      <select name="fid" lay-verify="required" lay-search>
        <option value=""></option>
        <?php foreach ($categorys as $category) {
          # code...
        ?>
        <option value="<?php echo $category['id'] ?>"><?php echo $category['name']; ?></option>
        <?php } ?>
      </select>
    </div>
  </div>
  <div class="layui-form-item">
    <label class="layui-form-label">权重</label>
    <div class="layui-input-block">
      <input type="number" name="weight" min = "0" max = "999" value = "0" required  lay-verify="required|number" placeholder="权重越高，排名越靠前，范围为0-999" autocomplete="off" class="layui-input">
    </div>
  </div>
  
  
  <div class="layui-form-item">
    <label class="layui-form-label">是否私有</label>
    <div class="layui-input-inline">
      <input type="checkbox" name="property" value = "1" lay-skin="switch" lay-text="是|否">
    </div>
    <div class="layui-form-mid layui-word-aux">私有链接需要登录后才能查看！</div>
  </div>
  
  <div class="layui-form-item layui-form-text">
    <label class="layui-form-label">描述（选填）</label>
    <div class="layui-input-block">
      <textarea name="description" id = "description" placeholder="请输入内容" class="layui-textarea"></textarea>
    </div>
  </div>
  <div class="layui-form-item">
      <button class="layui-btn" id = "add_link" lay-submit lay-filter="add_link">添加</button>
      <!-- <button class="layui-btn" lay-submit lay-filter="get_link_info">识别</button> -->
      <a href="javascript:;" class="layui-btn" onclick="get_link_info()">识别</a>
      <button type="reset" class="layui-btn layui-btn-primary">重置</button>
  </div>
</form>
    </div>
    
</div>
<!-- 内容主题区域END -->
</div>

<?php include_once('footer.php'); ?>