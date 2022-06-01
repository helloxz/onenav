<?php include_once('header.php'); ?>
<?php include_once('left.php'); ?>

<div class="layui-body">
<!-- 内容主体区域 -->
<div class="layui-row content-body place-holder">
    <!-- 说明提示框 -->
    <div class="layui-col-lg12">
      <div class="setting-msg">
      关于字体图标的说明请参考帮助文档：<a href="https://dwz.ovh/7nr1f" target = "_blank" title = "字体图标使用说明">https://dwz.ovh/7nr1f</a>
      </div>
    </div>
    <!-- 说明提示框END -->
    <div class="layui-col-lg6">
    <form class="layui-form layui-form-pane">
  <div class="layui-form-item">
    <label class="layui-form-label">分类名称</label>
    <div class="layui-input-block">
      <input type="text" name="name" required  lay-verify="required" placeholder="请输入分类名称" autocomplete="off" class="layui-input">
    </div>
  </div>

  <div class="layui-form-item">
      <label for="" class="layui-form-label">字体图标：</label>
      <div class="layui-input-block">
          <input name="font_icon" type="text" id="iconHhys2" value="" lay-filter="iconHhys2" class="layui-input">
      </div>
  </div>

  <div class="layui-form-item">
      <label class="layui-form-label">父级分类</label>
      <div class="layui-input-block">
      <select name="fid" lay-verify="">
      <option value="0">无</option>
        <?php foreach ($categorys as $key => $category) {
          
        ?>
          <option value="<?php echo $category['id']; ?>"><?php echo $category['name']; ?></option>
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
    <div class="layui-input-block">
      <input type="checkbox" name="property" value = "1" lay-skin="switch" lay-text="是|否">
    </div>
  </div>
  
  <div class="layui-form-item layui-form-text">
    <label class="layui-form-label">描述</label>
    <div class="layui-input-block">
      <textarea name="description" placeholder="请输入内容" class="layui-textarea"></textarea>
    </div>
  </div>
  <div class="layui-form-item">
      <button class="layui-btn" lay-submit lay-filter="add_category">添加</button>
      <button type="reset" class="layui-btn layui-btn-primary">重置</button>
  </div>
</form>
    </div>
    
</div>
<!-- 内容主题区域END -->
</div>
  
<?php include_once('footer.php'); ?>
<script>
  //参考：https://gitee.com/luckygyl/iconFonts
  layui.use(['iconHhysFa'], function(){
  var iconHhysFa = layui.iconHhysFa;
  iconHhysFa.render({
      // 选择器，推荐使用input
      elem: '#iconHhys2',
      // 数据类型：fontClass/awesome，推荐使用fontClass
      type: 'awesome',
      // 是否开启搜索：true/false
      search: true,
      // fa 图标接口
      url: './static/font-awesome/4.7.0/less/variables.less',
      // 是否开启分页
      page: true,
      // 每页显示数量，默认12
      limit: 30,
      // 点击回调
      value:'fa-bookmark-o', //自定义默认图标
      click: function(data) {
          console.log(data);
      },
      // 渲染成功后的回调
      success: function(d) {
          console.log(d);
      }
  });
})
</script>