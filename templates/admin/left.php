<div class="layui-side layui-bg-black">
    <div class="layui-side-scroll">
      <!-- 左侧导航区域（可配合layui已有的垂直导航） -->
      <ul class="layui-nav layui-nav-tree"  lay-filter="test">
        <li class="layui-nav-item layui-nav-itemed">
          <a class="" href="javascript:;">分类管理</a>
          <dl class="layui-nav-child">
            <dd><a href="/index.php?c=admin&page=category_list">分类列表</a></dd>
            <dd><a href="/index.php?c=admin&page=add_category">添加分类</a></dd>
          </dl>
        </li>
        
      </ul>
      <ul class="layui-nav layui-nav-tree"  lay-filter="test">
        <li class="layui-nav-item layui-nav-itemed">
          <a class="" href="javascript:;">链接管理</a>
          <dl class="layui-nav-child">
            <dd><a href="/index.php?c=admin&page=link_list">我的链接</a></dd>
            <dd><a href="/index.php?c=admin&page=add_link">添加链接</a></dd>
          </dl>
        </li>
        
      </ul>
    </div>
  </div>