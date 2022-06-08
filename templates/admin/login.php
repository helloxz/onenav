<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./templates/admin/static/css/new.css">
  <link rel='stylesheet' href='static/layui/css/layui.css'>
  <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
  <title>OneNav管理员登录</title>
  <script>
    window.onload = function () {
      document.querySelector(".login").style.opacity = 1;
    }
  </script>
</head>

<body class="login">
  <div class="root">
    <section class="left">
      <img class="cover" src="./templates/admin/static/image/backgroundLogin.png" />
    </section>
    <section class="right">
      <!-- PC版的样式 -->
      <h2>OneNav后台管理系统</h2>
      <div class="login_frame">
        <div class="login_box">
          <h4>管理登录</h4>
          <h6>亲爱的管理员欢迎回来！</h6>
          <form action="" method="post">
            <div class="inp">
              <span class="label">用户名</span>
              <input type="text" id = "user" name="user" placeholder="请输入账号" />
            </div>
            <div class="inp">
              <span class="label">用户密码</span>
              <input type="password" id = "password" name="password" placeholder="请输入密码" />
            </div>
            <div class="submit">
              <input type="submit" lay-submit lay-filter="new_login" class="submit" value="登录">
            </div>
          </form>
        </div>
      </div>
    </section>
  </div>
  <div class="mobile">
    <!-- 手机版的样式 -->
    <h1>OneNav</h1>
    <form action="" method="post">
      <div class="inp">
        <span class="label">用户名</span>
        <input type="text" id = "m_user" name="user" placeholder="请输入账号" />
      </div>
      <div class="inp">
        <span class="label">用户密码</span>
        <input type="password" id = "m_password" name="password" placeholder="请输入密码" />
      </div>
      <div class="submit">
        <input type="submit" lay-submit lay-filter="new_mobile_login" class="submit" value="登录">
      </div>
    </form>
  </div>
  <footer>© 2022 Powered by <a style = "color:#FFFFFF;padding-left:6px;" href = "https://www.onenav.top/" target = "_blank" title = "开源免费书签管理系统"> OneNav</a></footer>
</body>
<script>
  //自己封装的弹出框
  function alt(text) {
    const t = document.createElement("div")
    t.innerText = text;
    Object.assign(t.style, {
      position: 'fixed',
      maxWidth: '300px',
      top: '50px',
      left: '0px',
      right: '0px',
      margin: '0 auto',
      color: '#000',
      background: '#fff',
      boxShadow: '0px 3px 4px rgba(197, 197, 197, 0.115)',
      padding: '15px 20px',
      borderRadius: '8px',
      transition: 'all .5s',
      opacity: 0,
      transform: 'translateY(-10px)'
    })
    document.body.append(t)
    setTimeout(_ => {
      t.style.transform = 'translateY(10px)'
      t.style.opacity = 1;
    }, 100)
    setTimeout(_ => {
      t.style.transform = 'translateY(-10px)'
      t.style.opacity = 0;
    }, 3000)
  }
</script>
<script src = 'static/js/jquery.min.js'></script>
<script src = 'static/layui/layui.js'></script>
<script src="templates/admin/static/embed.js"></script>
</html>