<?php include_once('s_header.php'); ?>
<div class="layui-container">
<!-- 内容主体区域 -->
<div class="layui-row">
  <!-- 说明提示框 -->
  <div class="layui-col-lg12">
      <div class="setting-msg" style = "margin-top:2em;">
        <p>1. 关于字体图标的说明请参考帮助文档：<a href="https://dwz.ovh/7nr1f" target = "_blank" title = "字体图标使用说明">https://dwz.ovh/7nr1f</a></p>
        <p>2. 权重越大，排序越靠前</p>
      </div>
    </div>
    <!-- 说明提示框END -->
    <div class="layui-col-lg12">
    <form class="layui-form layui-form-pane">
    <div class="layui-form-item" style = "display:none;">
    <label class="layui-form-label">分类ID</label>
    <div class="layui-input-block">
      <input type="text" name="id" required  lay-verify="required" value = '<?php echo $id; ?>' placeholder="请输入分类名称" autocomplete="off" class="layui-input">
    </div>
  </div>
  <div class="layui-form-item">
    <label class="layui-form-label">分类名称</label>
    <div class="layui-input-block">
      <input type="text" name="name" required  lay-verify="required" value = '<?php echo $category_one['name']; ?>' placeholder="请输入分类名称" autocomplete="off" class="layui-input">
    </div>
  </div>

  <div class="layui-form-item">
      <label class="layui-form-label">父级分类</label>
      <div class="layui-input-block">
      <select name="fid" lay-verify="">
        <!-- 显示上级分类，如果没有，则显示空 -->
        <?php if( empty( $category_one['fname'] ) ){
          
        ?>
        <!-- 如果上级分类名称为空 -->
          <option value="0">无</option>
        <?php }else{ ?>
          <option value="<?php echo $category_one['fid']; ?>"><?php echo $category_one['fname']; ?></option>
          <option value="0">无</option>
        <?php } ?>
        <!-- 显示上级分类END -->

        <!-- 遍历所有分类，但不显示对应的父级 -->
        <?php foreach ($categorys as $key => $category) {
           if ( $category['id'] == $category_one['fid'] ) {
             continue;
           }
           //如果分类ID的父级ID不能是自己
           if( $category['id'] == $id ) {
             continue;
           }
        ?>
          <option value="<?php echo $category['id']; ?>"><?php echo $category['name']; ?></option>
        <?php } ?>
        <!-- 遍历所有分类END -->
      </select> 
      </div>
    </div>

  <!-- <div class="layui-form-item">
    <label class="layui-form-label">字体图标</label>
    <div class="layui-input-block">
      <input type="text" name="font_icon" value = '<?php echo $category_one['font_icon']; ?>' placeholder="请输入字体图标，如：fa fa-bookmark-o" autocomplete="off" class="layui-input">
    </div>
  </div> -->

  <div class="layui-form-item">
      <label for="" class="layui-form-label">字体图标：</label>
      <div class="layui-input-inline" style = "width:240px;">
          <input name="font_icon" type="text" id="iconHhys2" value="<?php echo $category_one['font_icon']; ?>" lay-filter="iconHhys2" class="layui-input">
      </div>
      <div class="layui-form-mid layui-word-aux">
        图标对照表可参考：<a rel = "nofollow" target = "_blank" href="https://fontawesome.dashgame.com/">FontAwesome4</a>
      </div>
  </div>

  <div class="layui-form-item">
    <label class="layui-form-label">权重</label>
    <div class="layui-input-block">
      <input type="number" name="weight" min = "0" max = "999" value = "<?php echo $category_one['weight']; ?>" required  lay-verify="required|number" placeholder="权重越高，排名越靠前，范围为0-999" autocomplete="off" class="layui-input">
    </div>
  </div>
  
  
  <div class="layui-form-item">
    <label class="layui-form-label">是否私有</label>
    <div class="layui-input-inline" style = "width:240px;">
      <input type="checkbox" name="property" value = "1" lay-skin="switch" <?php echo $category_one['checked']; ?> lay-text="是|否">
    </div>
    <div class="layui-form-mid layui-word-aux">私有分类下的链接需要登录后才能查看。</div>
  </div>
  
  <div class="layui-form-item layui-form-text">
    <label class="layui-form-label">描述（选填）</label>
    <div class="layui-input-block">
      <textarea name="description" placeholder="请输入内容" class="layui-textarea"><?php echo $category_one['description']; ?></textarea>
    </div>
  </div>
  <div class="layui-form-item">
      <button class="layui-btn" lay-submit lay-filter="edit_category">更新</button>
      <button type="reset" class="layui-btn layui-btn-primary">重置</button>
  </div>
</form>
    </div>
    
</div>

<!-- 内容主题区域END -->
</div>

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
      value:'<?php echo str_replace("fa ","",$category_one["font_icon"]); ?>', //自定义默认图标
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