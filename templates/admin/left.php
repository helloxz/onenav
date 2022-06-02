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
            <dd><a href="/index.php?c=admin&page=imp_link">书签导入</a></dd>
          </dl>
        </li>
      </ul>

      <!-- 系统设置 -->
      <ul class="layui-nav layui-nav-tree"  lay-filter="test">
        <li class="layui-nav-item layui-nav-itemed">
          <a class="" href="javascript:;">系统设置</a>
          <dl class="layui-nav-child">
            <dd><a href="/index.php?c=admin&page=setting/subscribe">订阅 & 更新</a></dd>
            <dd><a href="/index.php?c=admin&page=setting/site">站点设置</a></dd>
            <dd><a href="/index.php?c=admin&page=setting/theme">主题设置</a></dd>
            <dd><a href="/index.php?c=admin&page=setting/transition_page">过渡页面</a></dd>
            <dd><a href="/index.php?c=admin&page=setting/api">获取API</a></dd>
          </dl>
        </li>
      </ul>
      <!-- 系统设置END -->

      <!-- <ul class="layui-nav layui-nav-tree"  lay-filter="test">
        <li class="layui-nav-item layui-nav-itemed">
          <a class="" href="javascript:;">高级功能</a>
          <dl class="layui-nav-child">
            <dd><a href="/index.php?c=admin&page=ext_js">自定义JavaScript</a></dd>
          </dl>
        </li>
      </ul> -->

    </div>
  </div>