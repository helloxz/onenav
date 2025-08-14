<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?php echo $site['title']; ?> - <?php echo $site['subtitle']; ?></title>
    <meta name="keywords" content="<?php echo $site['keywords']; ?>" />
    <meta name="description" content="<?php echo $site['description']; ?>" />
    
    <!-- Bootstrap 4 CSS -->
    <link rel="stylesheet" href="static/bootstrap4/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="static/font-awesome/4.7.0/css/font-awesome.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="templates/<?php echo $template; ?>/static/style.css?v=<?php echo $version; ?>">
    
    <?php echo $site['custom_header']; ?>
    <style>
    <?php if( $theme_config->link_description == "hide" ) { ?>
        .bookmark-description {
            display: none;
        }
    <?php } ?>
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top shadow">
        <div class="container">
            <!-- Brand -->
            <a class="navbar-brand fw-bold" href="/" title="<?php echo $site['description']; ?>">
                <i class="fa fa-bookmark-o me-2"></i>
                <?php echo $site['title']; ?>
            </a>
            
            <!-- Mobile menu toggle -->
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" 
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <!-- Navigation Links -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <?php if( is_login() ) { ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/index.php?c=admin" target="_blank" title="后台管理">
                            <i class="fa fa-cog"></i> 管理后台
                        </a>
                    </li>
                    <?php } else { ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/index.php?c=login" target="_blank" title="登录">
                            <i class="fa fa-sign-in"></i> 登录
                        </a>
                    </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="main-content">
        <div class="container">
            <!-- Search Section -->
            <section class="search-section">
                <div class="row justify-content-center">
                    <div class="col-lg-8 col-md-10">
                        <div class="search-container">
                            <div class="search-box" id="searchBox">
                                <i class="fa fa-search search-icon" aria-hidden="true"></i>
                                <input type="text" class="search-input" id="searchInput" placeholder="搜索书签..." autocomplete="off" />
                                <button class="search-clear" id="clearSearch" type="button" title="清除"><i class="fa fa-times"></i></button>
                            </div>
                            <div class="search-suggestions" id="searchSuggestions"></div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Categories Navigation -->
            <!-- 如果存在cid参数，则不显示 -->
            <?php if( !isset($_GET['cid']) ) { ?>
            <section class="categories-nav">
                <div class="category-tabs-scroll" id="catTabsScrollWrap">
                    <button class="cat-scroll-btn prev" id="catScrollPrev" type="button" aria-label="向左"><i class="fa fa-angle-left"></i></button>
                    <div class="cat-scroll-inner" id="catScrollInner">
                        <ul class="nav nav-tabs category-tabs flex-nowrap" id="categoryTabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" href="javascript:void(0);" data-category="all" role="tab">
                                    <i class="fa fa-home"></i> 全部
                                </a>
                            </li>
                            <?php foreach ($categorys as $category) { 
                                $font_icon = empty($category['font_icon']) ? 'fa fa-folder' : $category['font_icon'];
                            ?>
                            <li class="nav-item">
                                <a class="nav-link" href="javascript:void(0);" data-category="<?php echo $category['id']; ?>" role="tab">
                                    <i class="<?php echo $font_icon; ?>"></i> 
                                    <?php echo htmlspecialchars_decode($category['name']); ?>
                                </a>
                            </li>
                            <?php } ?>
                        </ul>
                    </div>
                    <button class="cat-scroll-btn next" id="catScrollNext" type="button" aria-label="向右"><i class="fa fa-angle-right"></i></button>
                </div>
            </section>
            <?php } ?>

            <!-- Back Button for Category View -->
            <?php if( isset($_GET['cid']) ) { ?>
            <section class="back-section">
                <div class="row">
                    <div class="col-12">
                        <a href="javascript:history.back()" class="btn btn-outline-primary btn-back">
                            <i class="fa fa-arrow-left"></i> 返回
                        </a>
                    </div>
                </div>
            </section>
            <?php } ?>

            <!-- Bookmarks Grid -->
            <section class="bookmarks-section">
                <?php foreach ($categorys as $category) {
                    $fid = $category['id'];
                    $links = $get_links($fid);
                    $font_icon = empty($category['font_icon']) ? 'fa fa-folder' : $category['font_icon'];
                    
                    // 如果分类是私有的
                    $property_icon = ($category['property'] == 1) ? '<i class="fa fa-lock text-warning ml-1" title="该分类是私有的，仅登录后可见！"></i>' : '';
                ?>
                
                <div class="category-section" id="category-<?php echo $category['id']; ?>" data-category="<?php echo $category['id']; ?>">
                    <div class="row">
                        <div class="col-12">
                            <h3 class="category-title">
                                <i class="<?php echo $font_icon; ?> category-icon"></i>
                                <?php echo htmlspecialchars_decode($category['name']); ?>
                                <?php echo $property_icon; ?>
                                <span class="badge badge-secondary ml-2"><?php echo count($links); ?></span>
                            </h3>
                        </div>
                    </div>

                    <div class="bookmarks-grid">
                        <?php foreach ($links as $link) {
                            // 默认描述
                            $link['description'] = empty($link['description']) ? '作者很懒，没有填写描述。' : $link['description'];
                            $id = $link['id'];
                            
                            // 直链模式
                            if( $site['link_model'] === 'direct' ) {
                                $url = $link['url'];
                            } else {
                                $url = '/index.php?c=click&id='.$link['id'];
                            }
                        ?>
                            <div class="bookmark-card" data-title="<?php echo $link['title']; ?>" 
                                 data-url="<?php echo $link['url']; ?>" data-description="<?php echo $link['description']; ?>">
                                
                                <?php if($link['property'] == 1) { ?>
                                <div class="private-badge" title="改链接是私有的，仅登录后可见！">
                                    <i class="fa fa-lock"></i>
                                </div>
                                <?php } ?>
                                
                                <a href="<?php echo $url; ?>" target="_blank" class="bookmark-link">
                                    <div class="bookmark-header">
                                        <div class="bookmark-favicon">
                                            <?php if( $theme_config->favicon == "online") { 
                                                // 提取基础域名(协议+主机)，去掉路径
                                                $parsed_url = parse_url($link['url']);
                                                if( isset($parsed_url['scheme']) && isset($parsed_url['host']) ){
                                                    $favicon_domain = $parsed_url['scheme'].'://'.$parsed_url['host'];
                                                } elseif( isset($parsed_url['host']) ){
                                                    $favicon_domain = 'https://'.$parsed_url['host'];
                                                } else {
                                                    $favicon_domain = $link['url'];
                                                }
                                                if ($link['font_icon']) {
                                                    $icon_url = $link['font_icon'];
                                                }
                                                else{
                                                    $icon_url = "https://t0.gstatic.cn/faviconV2?client=SOCIAL&type=FAVICON&fallback_opts=TYPE,SIZE,URL&size=32&url=".urlencode($favicon_domain);
                                                }
                                            ?>
                                                <img loading="lazy" src="<?php echo $icon_url; ?>" 
                                                     width="24" height="24">
                                            <?php } else { 
                                                if ($link['font_icon']) {
                                                    $icon_url = $link['font_icon'];
                                                } else {
                                                    $icon_url = "/index.php?c=ico&text=".$link['title'];
                                                }
                                            ?>
                                                <img loading="lazy" src="<?php echo $icon_url; ?>" 
                                                     width="24" height="24">
                                            <?php } ?>
                                        </div>
                                        <div class="bookmark-title" title="<?php echo $link['title']; ?>"><?php echo $link['title']; ?></div>
                                    </div>
                                    <div class="bookmark-description">
                                        <?php echo $link['description']; ?>
                                    </div>
                                    <div class="bookmark-url">
                                        <?php echo parse_url($link['url'], PHP_URL_HOST); ?>
                                    </div>
                                </a>
                                <div class="bookmark-actions bottom-right">
                                    <button class="btn btn-xs btn-action copy-link" data-url="<?php echo $link['url']; ?>" title="复制链接">
                                        <i class="fa fa-copy"></i>
                                    </button>
                                    <button class="btn btn-xs btn-action qr-code" data-url="<?php echo $link['url']; ?>" title="二维码">
                                        <i class="fa fa-qrcode"></i>
                                    </button>
                                </div>
                            </div>
                        <?php } ?>
                        
                        <!-- More Button -->
                        <?php if( !isset($_GET['cid']) && get_links_number($fid) > $link_num ) { ?>
                            <div class="bookmark-card more-card">
                                <a href="/index.php?cid=<?php echo $category['id']; ?>" class="more-link simple-more" aria-label="查看更多分类 <?php echo htmlspecialchars_decode($category['name']); ?> 的链接">
                                    <div class="more-text">查看更多</div>
                                    <div class="more-count">还有 <?php echo get_links_number($fid) - $link_num; ?> 个链接</div>
                                </a>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <?php } ?>
            </section>
        </div>
    </main>

    <!-- Footer -->
    <footer class="site-footer">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <?php if(empty( $site['custom_footer']) ){ ?>
                    <p>&copy; <?php echo date("Y"); ?> Powered by 
                        <a href="https://www.onenav.top/" target="_blank" rel="nofollow">OneNav</a>
                    </p>
                    <?php } else {
                        echo $site['custom_footer'];
                    } ?>
                </div>
            </div>
        </div>
    </footer>

    <!-- Floating Action Buttons -->
    <div class="floating-actions">
        <?php if( is_login() ) { ?>
            <button class="fab fab-add" id="addLinkBtn" title="快速添加链接">
                <i class="fa fa-plus"></i>
            </button>
        <?php } ?>
        <button class="fab fab-top" id="backToTop" title="返回顶部">
            <i class="fa fa-arrow-up"></i>
        </button>
    </div>

    <!-- QR Code Modal -->
    <div class="modal fade" id="qrModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">二维码</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <div id="qrcode"></div>
                    <p class="mt-3 text-muted" id="qrUrl"></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="static/js/jquery.min.js"></script>
    <script src="static/bootstrap4/js/bootstrap.bundle.min.js"></script>
    <script src="static/layer/layer.js"></script>
    <script src="static/js/clipBoard.min.js"></script>
    <script src="static/js/qrcode.min.js"></script>
    <script src="templates/<?php echo $template; ?>/static/embed.js?v=<?php echo $version; ?>"></script>
    <!-- <script>
    <?php echo $onenav['right_menu']; ?>
    </script> -->
</body>
</html>
