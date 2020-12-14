<!DOCTYPE html>
<html lang="zh">

<head>
    </script>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="author" content="viggo" />
    <title><?php echo $site_setting['title']; ?></title>
    <meta name="keywords" content="<?php echo $site_setting['title']; ?>">
    <meta name="description" content="<?php echo $site_setting['description']; ?>">
    <link rel="shortcut icon" href="templates/default/assets/images/favicon.ico">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Arimo:400,700,400italic">
    <link rel="stylesheet" href="templates/default/assets/css/fonts/linecons/css/linecons.css">
    <link rel='stylesheet' href='https://libs.xiaoz.top/font-awesome/4.7.0/css/font-awesome.css'>
    <link rel="stylesheet" href="templates/default/assets/css/fonts/fontawesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="templates/default/assets/css/bootstrap.css">
    <link rel="stylesheet" href="templates/default/assets/css/xenon-core.css">
    <link rel="stylesheet" href="templates/default/assets/css/xenon-components.css">
    <link rel="stylesheet" href="templates/default/assets/css/xenon-skins.css">
    <link rel="stylesheet" href="templates/default/assets/css/nav.css">
    <script src="templates/default/assets/js/jquery-1.11.1.min.js"></script>
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!-- / FB Open Graph -->
</head>

<body class="page-body">
    <!-- skin-white -->
    <div class="page-container">
        <div class="sidebar-menu toggle-others fixed">
            <div class="sidebar-menu-inner">
                <header class="logo-env">
                    <!-- logo -->
                    <div class="logo">
                        <a href="/" class="logo-expanded">
                            <!-- <img src="templates/default/assets/images/logo@2x.png" width="100%" alt="" /> -->
                            <h1 style = "color:#0099FF;">OneNav</h1>
                        </a>
                        <a href="/" class="logo-collapsed">
                            <img src="templates/default/assets/images/logo-collapsed@2x.png" width="40" alt="" />
                        </a>
                    </div>
                    <div class="mobile-menu-toggle visible-xs">
                        <a href="#" data-toggle="user-info-menu">
                            <i class="linecons-cog"></i>
                        </a>
                        <a href="#" data-toggle="mobile-menu">
                            <i class="fa-bars"></i>
                        </a>
                    </div>
                </header>
                
                <ul id="main-menu" class="main-menu">
                    <?php
                        //遍历分类目录并显示
                        foreach ($categorys as $category) {
                        //var_dump($category);
                        
                    ?>
                    <li>
                        <a href="#category-<?php echo $category['id']; ?>" class="smooth">
                            
                            <span class="title">&nbsp; <?php echo $category['name']; ?></span>
                        </a>
                    </li>
                    <?php } ?>
                    <!-- <li>
                        <a href="#社区资讯" class="smooth">
                            <i class="linecons-doc"></i>
                            <span class="title">社区资讯</span>
                        </a>
                    </li> -->
                    <li>
                        <a href="https://www.xiaoz.me/about">
                            <span class="title">&nbsp;<i class="fa fa-user-circle"></i> 关于本站</span>
                        </a>
                    </li>
                    <!-- <div class="submit-tag">
                        <a href="about.html">
                            <i class="linecons-heart"></i>
                            <span class="tooltip-blue">关于本站</span>
                            <span class="label label-Primary pull-right hidden-collapsed">♥︎</span>
                        </a>
                    </div> -->
                </ul>
            </div>
        </div>
        <div class="main-content">
            <nav class="navbar user-info-navbar" role="navigation">
                <!-- User Info, Notifications and Menu Bar -->
                <!-- Left links for user info navbar -->
                <!-- <ul class="user-info-menu left-links list-inline list-unstyled">
                    <li class="hidden-sm hidden-xs">
                        <a href="#" data-toggle="sidebar">
                            <i class="fa-bars"></i>
                        </a>
                    </li>
                    <li class="dropdown hover-line language-switcher">
                        <a href="../cn/index.html" class="dropdown-toggle" data-toggle="dropdown">
                            <img src="templates/default/assets/images/flags/flag-cn.png" alt="flag-cn" /> Chinese
                        </a>
                        <ul class="dropdown-menu languages">
                            <li>
                                <a href="../en/index.html">
                                    <img src="templates/default/assets/images/flags/flag-us.png" alt="flag-us" /> English
                                </a>
                            </li>
                            <li class="active">
                                <a href="../cn/index.html">
                                    <img src="templates/default/assets/images/flags/flag-cn.png" alt="flag-cn" /> Chinese
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
                <ul class="user-info-menu right-links list-inline list-unstyled">
                    <li class="hidden-sm hidden-xs">
                        <a href="https://github.com/WebStackPage/WebStackPage.github.io" target="_blank">
                            <i class="fa-github"></i>  GitHub
                        </a>
                    </li>
                </ul> -->
                <!-- <a href="https://github.com/WebStackPage/WebStackPage.github.io" target="_blank"><img style="position: absolute; top: 0; right: 0; border: 0;" src="https://s3.amazonaws.com/github/ribbons/forkme_right_darkblue_121621.png" alt="Fork me on GitHub"></a> -->

            </nav>
            <!-- 常用推荐 -->
            <!-- 遍历分类目录 -->
            <?php foreach ( $categorys as $category ) {
                $fid = $category['id'];
                $links = get_links($fid);
                //如果分类是私有的
                if( $category['property'] == 1 ) {
                    $property = '<i class="fa fa-expeditedssl" style = "color:#5FB878"></i>';
                }
                else {
                    $property = '';
                }
            ?>
            <h4 class="text-gray" id = "category-<?php echo $fid ?>"><?php echo $category['name']; ?> <?php echo $property; ?></h4>
            <!-- 遍历链接 -->
            <div class="row">
                <?php
                    foreach ($links as $link) {
                        //判断是否是私有项目
                        if( $link['property'] == 1 ) {
                            $privacy_class = 'property';
                        }
                        else {
                            $privacy_class = '';
                        }
                        
                    //var_dump($link);
                ?>
                <div class="col-sm-3">
                    <div class="<?php echo $privacy_class; ?> xe-widget xe-conversations box2 label-info" onclick="window.open('/index.php?c=click&id=<?php echo $link['id']; ?>', '_blank')" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="<?php echo $link['url']; ?>">
                        <div class="xe-comment-entry">
                            <!-- <a class="xe-user-img">
                                <img data-src="templates/default/assets/images/logos/uisdc.png" class="lozad img-circle" width="40">
                            </a> -->
                            
                            <span class="label label-info" data-toggle="tooltip" data-placement="left" title="" data-original-title="Hello I am a Tooltip"></span>
                            <div class="xe-comment">
                                <a href="#" class="xe-user-name overflowClip_1">
                                <img src="https://favicon.rss.ink/?url=<?php echo $link['url']; ?>" alt="HUAN" width="16" height="16" />
                                    <strong><?php echo $link['title']; ?></strong>
                                </a>
                                <p class="overflowClip_2"><?php echo $link['description']; ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
            <div class="placeholder" style = "height:2em;"></div> 
            <?php } ?>
            
            <br />
            
            <!-- END 常用推荐 -->
                
            
            
            

            <!-- Main Footer -->
            <!-- Choose between footer styles: "footer-type-1" or "footer-type-2" -->
            <!-- Add class "sticky" to  always stick the footer to the end of page (if page contents is small) -->
            <!-- Or class "fixed" to  always fix the footer to the end of page -->
            <footer class="main-footer sticky footer-type-1">
                <div class="footer-inner">
                    <!-- Add your copyright text here -->
                    <div class="footer-text">
                        &copy; 2020
                        Theme design by Viggo.
                        Powered by <a href="https://github.com/helloxz/onenav" rel = "nofollow" target="_blank"><strong>OneNav</strong></a> | 
                        <a href="/index.php?c=login">login</a>
                        <!--  - Purchase for only <strong>23$</strong> -->
                    </div>
                    <!-- Go to Top Link, just add rel="go-top" to any link to add this functionality -->
                    <div class="go-up">
                        <a href="#" rel="go-top">
                            <i class="fa-angle-up"></i>
                        </a>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <!-- 锚点平滑移动 -->
    <script type="text/javascript">
    $(document).ready(function() {
         //img lazy loaded
         const observer = lozad();
         observer.observe();

        $(document).on('click', '.has-sub', function(){
            var _this = $(this)
            if(!$(this).hasClass('expanded')) {
               setTimeout(function(){
                    _this.find('ul').attr("style","")
               }, 300);
              
            } else {
                $('.has-sub ul').each(function(id,ele){
                    var _that = $(this)
                    if(_this.find('ul')[0] != ele) {
                        setTimeout(function(){
                            _that.attr("style","")
                        }, 300);
                    }
                })
            }
        })
        $('.user-info-menu .hidden-sm').click(function(){
            if($('.sidebar-menu').hasClass('collapsed')) {
                $('.has-sub.expanded > ul').attr("style","")
            } else {
                $('.has-sub.expanded > ul').show()
            }
        })
        $("#main-menu li ul li").click(function() {
            $(this).siblings('li').removeClass('active'); // 删除其他兄弟元素的样式
            $(this).addClass('active'); // 添加当前元素的样式
        });
        $("a.smooth").click(function(ev) {
            ev.preventDefault();

            public_vars.$mainMenu.add(public_vars.$sidebarProfile).toggleClass('mobile-is-visible');
            ps_destroy();
            $("html, body").animate({
                scrollTop: $($(this).attr("href")).offset().top - 30
            }, {
                duration: 500,
                easing: "swing"
            });
        });
        return false;
    });

    var href = "";
    var pos = 0;
    $("a.smooth").click(function(e) {
        $("#main-menu li").each(function() {
            $(this).removeClass("active");
        });
        $(this).parent("li").addClass("active");
        e.preventDefault();
        href = $(this).attr("href");
        pos = $(href).position().top - 30;
    });
    </script>
    <!-- Bottom Scripts -->
    <script src="templates/default/assets/js/bootstrap.min.js"></script>
    <script src="templates/default/assets/js/TweenMax.min.js"></script>
    <script src="templates/default/assets/js/resizeable.js"></script>
    <script src="templates/default/assets/js/joinable.js"></script>
    <script src="templates/default/assets/js/xenon-api.js"></script>
    <script src="templates/default/assets/js/xenon-toggles.js"></script>
    <!-- JavaScripts initializations and stuff -->
    <script src="templates/default/assets/js/xenon-custom.js"></script>
    <script src="templates/default/assets/js/lozad.js"></script>
</body>

</html>
