# OneNav

OneNav是一款开源免费的书签（导航）管理程序，使用使用PHP + SQLite 3开发，界面简洁，安装简单，使用方便。OneNav可帮助你你将浏览器书签集中式管理，解决跨设备、跨平台、跨浏览器之间同步和访问困难问题，做到一处部署，随处访问。

![](https://i.bmp.ovh/imgs/2020/12/40f222b7da7a89c9.png)

![](https://i.bmp.ovh/imgs/2021/04/5c46f84f158d8d3a.png)

![](https://img.rss.ink/imgs/2022/03/cba9f1946776a8f0.png)

![](https://img.rss.ink/imgs/2022/03/4b1d6c95484e69bc.png)

![](https://img.rss.ink/imgs/2022/06/08/401b42279dd971f0.png)

![](https://img.rss.ink/imgs/2022/06/07/1a2f6c3f81b64f6a.png)

![](https://img.rss.ink/imgs/2022/06/06/172432e9d3564113.png)

![](https://i.bmp.ovh/imgs/2020/12/abba0af566f3c16a.png)

> **特别声明：未经作者允许，请勿将OneNav进行获利行为或进行商业行为，亦不得用于非法用途，否则自行承担相应法律责任！！！**

## 功能特色

* 支持后台管理
* 支持私有链接
* 支持Chrome/Firefox/Edge书签批量导入
* 支持多种主题风格
* 支持链接信息自动识别
* 支持API
* 支持Docker部署
* 支持uTools插件
* 支持二级分类
* 支持Chromium内核的[浏览器扩展](https://dwz.ovh/4kxn2)（插件）
* 支持在线更新
* 手机版后台

## 安装

**常规安装：**

1. 需安装PHP环境，并确保支持SQLite3
2. 下载源码解压到站点根目录
3. 访问首页根据提示初始化用户名/密码
4. 访问后台：`http://IP/index.php?c=login`

**Docker部署：**

```bash
docker run -itd --name="onenav" -p 80:80 \
    -v /data/onenav:/data/wwwroot/default/data \
    helloz/onenav:0.9.30
```
* 第一个`80`是自定义访问端口，可以自行修改，第二个`80`是容器端口，请勿修改
* `/data/onenav`：本机挂载目录，用于持久存储Onenav数据
* `0.9.30`：改成OneNav最新版本号，可以通过[releases](https://github.com/helloxz/onenav/releases)查看最新版本号

> 更多说明，请参考帮助文档：https://dwz.ovh/onenav

## Demo

* **官方演示站点：**[http://demo.onenav.top/](http://demo.onenav.top/index.php?c=login)
* 账号/密码：`xiaoz`/`xiaoz.me`

___

以下是OneNav部分用户演示站，排名不分先后。

* OneNav：[https://nav.rss.ink/](https://nav.rss.ink/)
* 千行书签：[http://www.52qx.club/](http://www.52qx.club/)
* 纽及书签：[http://www.1006788.com/](http://www.1006788.com/)
* DiscoveryNav：[https://nav.miooku.com/](https://nav.miooku.com/)

## OneNav交流群

* [https://dwz.ovh/qxsul](https://dwz.ovh/qxsul)

## 鸣谢

感谢`@落幕`/`@百素`/`@itushan`的代码贡献及主题开发，以及其它OneNav贡献者和使用者，名字太多无法一一列举，还请谅解。

OneNav诞生离不开以下项目，在此表示感谢（排名不分先后）。

* [WebStackPage](https://github.com/WebStackPage/WebStackPage.github.io)
* [LayUI](https://github.com/sentsin/layui)
* [Medoo](https://github.com/catfan/Medoo)
* [MDUI](https://github.com/zdhxiong/mdui)
