<!DOCTYPE html>
<html lang="zh">
  <head>
    <meta charset="UTF-8" />
    <link rel="icon" href="/favicon.ico" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo $site['title']; ?></title>
    <script type="module" crossorigin src="templates/universal/assets/index.js?version=<?php echo $version; ?>"></script>
    <link rel="stylesheet" href="templates/universal/assets/index.css?version=<?php echo $version; ?>">
    <?php echo $site['custom_header']; ?>
  </head>
  <body>
    <div id="app"></div>
    
  </body>
</html>
