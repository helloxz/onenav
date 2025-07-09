<!DOCTYPE html>
<html lang="zh-CN">
  <head>
    <meta charset="utf-8">
    <meta content="<?php echo $site['keywords']; ?>" name="keywords">
    <meta content="<?php echo $site['description']; ?>" name="description">
    <meta content="IE=edge" http-equiv="X-UA-Compatible">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>
      <?php echo $site[ 'title']; ?> - <?php echo $site[ 'subtitle']; ?></title>
      <script type="module" crossorigin src="/templates/<?php echo $template; ?>/assets/index.js?v=<?php echo $info->version; ?>"></script>
    </script>
    <link href="/templates/<?php echo $template; ?>/assets/index.css?v=<?php echo $info->version; ?>" rel="stylesheet">
    <?php echo $site['custom_header']; ?>
    <link rel="manifest" href="/templates/<?php echo $template; ?>/manifest.json" />
  </head>
  
  <body>
    <div id="app"></div>
  </body>

</html>