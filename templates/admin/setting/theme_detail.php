<!-- 主题详情页面 -->
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <title>OneNav后台管理</title>
  <link rel='stylesheet' href='static/layui/css/layui.css'>
  <link rel='stylesheet' href='templates/admin/static/style.css?v=v0.9.17-20220314'>
  <style>
    :root{
        --c-bg:#f5f7fb;
        --c-bg-alt:#ffffff;
        --c-text:#2f363c;
        --c-text-light:#5d6b76;
        --c-primary:#2b7bcb;
        --c-primary-grad-start:#2b7bcb;
        --c-primary-grad-end:#6fb7ff;
        --c-accent:#318ce3;
        --c-border:#e3e8ef;
        --c-radius:14px;
        --c-shadow:0 4px 12px -2px rgba(28,39,49,.08),0 8px 24px -4px rgba(28,39,49,.06);
        --c-shadow-hover:0 6px 18px -2px rgba(28,39,49,.15),0 14px 32px -6px rgba(28,39,49,.12);
        --duration:.35s;
        --ease:cubic-bezier(.4,.14,.3,1);
    }
    @media (prefers-color-scheme: dark){
        :root{
            --c-bg:#151a20;
            --c-bg-alt:#1e252c;
            --c-text:#e6ecf2;
            --c-text-light:#9aa5b1;
            --c-border:#2a323c;
            --c-shadow:0 4px 14px -2px rgba(0,0,0,.55),0 8px 28px -6px rgba(0,0,0,.4);
            --c-shadow-hover:0 6px 20px -2px rgba(0,0,0,.6),0 16px 40px -8px rgba(0,0,0,.5);
        }
        .description{background:rgba(49,140,227,.15);}
    }
    body{
        background:linear-gradient(135deg,var(--c-bg) 0%,var(--c-bg-alt) 100%);
        font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif;
        color:var(--c-text);
        line-height:1.55;
        -webkit-font-smoothing:antialiased;
        padding:2.2rem 1.4rem 3rem;
    }
    .page-wrap{
        max-width:1180px;
        margin:0 auto;
        display:flex;
        gap:1.8rem;
        align-items:flex-start;
        flex-wrap:wrap;
        opacity:0;
        animation:fadeIn .6s var(--ease) forwards;
        margin-top:1em;
        margin-bottom:1em;
    }
    @keyframes fadeIn{to{opacity:1;transform:none}} 
    .card{
        background:var(--c-bg-alt);
        border:1px solid var(--c-border);
        border-radius:var(--c-radius);
        box-shadow:var(--c-shadow);
        transition:box-shadow var(--duration) var(--ease),transform var(--duration) var(--ease),border-color var(--duration) var(--ease);
        position:relative;
        overflow:hidden;
    }
    .card:hover{
        box-shadow:var(--c-shadow-hover);
        transform:translateY(-4px);
        border-color:rgba(49,140,227,.35);
    }
    .left-pane{
        flex:1 1 62%;
        min-width:320px;
        padding:1.2rem 1.2rem 1.6rem;
    }
    .right-pane{
        flex:1 1 300px;
        max-width:360px;
        padding:1.6rem 1.4rem 2rem;
        display:flex;
        flex-direction:column;
        gap:.75rem;
    }
    .theme-screenshot{
        border-radius:10px;
        overflow:hidden;
        position:relative;
        background:linear-gradient(135deg,#d9e6f2,#f2f8fc);
        aspect-ratio:16/9;
        display:flex;
        align-items:center;
        justify-content:center;
        box-shadow:inset 0 0 0 1px rgba(255,255,255,.4);
    }
    .theme-screenshot img{
        width:100%;
        height:100%;
        object-fit:cover;
        display:block;
        filter:saturate(1.04);
        transform:scale(1.01);
        transition:transform 1.2s var(--ease),filter .8s var(--ease);
    }
    .theme-screenshot:hover img{
        transform:scale(1.045);
        filter:saturate(1.12);
    }
    .detail h1{
        background:linear-gradient(90deg,var(--c-primary-grad-start) 0%,var(--c-primary-grad-end) 85%);
        -webkit-background-clip:text;
        -webkit-text-fill-color:transparent;
        font-size:2rem;
        font-weight:700;
        letter-spacing:.5px;
        margin:0 0 .6rem;
        line-height:1.25;
    }
    .description{
        background:linear-gradient(125deg,rgba(49,140,227,.15),rgba(49,140,227,.08));
        color:var(--c-text);
        padding:.85rem 1rem;
        border-radius:10px;
        font-size:.92rem;
        line-height:1.5;
        position:relative;
        border:1px solid rgba(49,140,227,.25);
    }
    .meta-item{
        margin:0;
        font-size:.9rem;
        color:var(--c-text-light);
        display:flex;
        gap:.4rem;
        align-items:center;
    }
    .meta-item strong{
        font-weight:600;
        color:var(--c-text);
        background:linear-gradient(90deg,rgba(49,140,227,.18),rgba(49,140,227,0));
        padding:.2rem .55rem;
        border-radius:6px;
        font-size:.78rem;
        letter-spacing:.5px;
        text-transform:uppercase;
    }
    .links a{
        color:var(--c-accent);
        position:relative;
        font-weight:500;
        text-decoration:none;
        display:inline-flex;
        align-items:center;
        gap:.35rem;
    }
    .links a::after{
        content:"";
        position:absolute;
        left:0;
        bottom:-2px;
        height:2px;
        width:0;
        background:linear-gradient(90deg,var(--c-accent),var(--c-primary-grad-end));
        transition:width .45s var(--ease);
        border-radius:2px;
    }
    .links a:hover::after{width:100%;}
    .badge{
        display:inline-block;
        padding:.25rem .55rem;
        background:linear-gradient(90deg,var(--c-primary-grad-start),var(--c-primary-grad-end));
        color:#fff;
        border-radius:20px;
        font-size:.7rem;
        letter-spacing:.5px;
        font-weight:500;
        box-shadow:0 2px 4px rgba(43,123,203,.35);
        margin-left:.4rem;
        vertical-align:middle;
    }
    .split-line{
        height:1px;
        background:linear-gradient(90deg,rgba(49,140,227,.35),rgba(49,140,227,0));
        margin:1rem 0 .5rem;
        border:none;
    }
    @media (max-width:880px){
        .page-wrap{flex-direction:column;}
        .left-pane,.right-pane{max-width:100%;}
        .detail h1{font-size:1.65rem;}
        body{padding:1.6rem 1rem 2.4rem;}
    }
  </style>
</head>
<body class="layui-fluid">
    <!-- 新布局容器 -->
    <div class="page-wrap">
        <div class="card left-pane">
            <div class="theme-screenshot">
                <img src="<?php echo $theme->screenshot; ?>" alt="<?php echo $theme->name; ?> Screenshot">
            </div>
        </div>
        <div class="card right-pane detail">
            <!-- 标题 + 版本徽标 -->
            <h1>
                <?php echo $theme->name; ?>
            </h1>
            <div class="description">
                <?php echo $theme->description; ?>
            </div>
            <hr class="split-line">
            <p class="meta-item"><strong>更新时间</strong><?php echo $theme->update; ?></p>
            <p class="meta-item"><strong>作者</strong><?php echo $theme->author; ?></p>
            <p class="meta-item links">
                <strong>使用说明</strong>
                <a href="<?php echo $theme->help_url; ?>" target="_blank" rel="nofollow noopener noreferrer">
                    <?php echo $theme->help_url; ?>
                </a>
            </p>
            <p class="meta-item links">
                <strong>主页</strong>
                <a href="<?php echo $theme->homepage; ?>" target="_blank" rel="nofollow noopener noreferrer">
                    <?php echo $theme->homepage; ?>
                </a>
            </p>
        </div>
    </div>
    <!-- ...existing code (原布局结构已替换为上方 page-wrap，更现代化) ... -->
</body>
</html>