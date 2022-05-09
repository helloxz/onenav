<?php include_once('header.php'); ?>
<?php include_once('left.php'); ?>

<div class="layui-body">
<!-- 内容主体区域 -->
<div class="layui-row content-body place-holder">
    <div class="layui-col-lg6 layui-col-md-offset3">
      <div class="setting-msg">仅支持 <em>.html</em> 格式导入，导入时会自动创建不存在的分类，使用前请参考<a href="https://dwz.ovh/ij3mq" target="_blank" rel = "nofollow">帮助文档</a> 。</div>
    <!-- 上传 -->
    <div class="layui-upload-drag" id="up_html">
      <i class="layui-icon layui-icon-upload"></i>
      <p>点击上传，或将书签拖拽到此处</p>
      <div class="layui-hide" id="file">
        <hr>
        <img src="" alt="上传成功后渲染" style="max-width: 100%">
      </div>
    </div>
    <!-- 上传END -->
    <form class="layui-form layui-form-pane">
    <div class="layui-form-item">
    <label class="layui-form-label">书签路径</label>
    <div class="layui-input-block">
      <input type="text" id = "filename" name="filename" required  lay-verify="required" placeholder="请输入书签路径" autocomplete="off" class="layui-input">
    </div>
  </div>
  <!-- <div class="layui-form-item">
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
  </div> -->
  
  <div class="layui-form-item">
    <label class="layui-form-label">是否私有</label>
    <div class="layui-input-block">
      <input type="checkbox" name="property" value = "1" lay-skin="switch" lay-text="是|否">
    </div>
  </div>

  <div class="layui-form-item">
  <button class="layui-btn" lay-submit lay-filter="imp_link">开始导入</button>
  </div>
</form>
    </div>
    
</div>
<!-- 内容主题区域END -->
</div>
  
<?php include_once('footer.php'); ?>