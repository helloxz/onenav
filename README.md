# OneNav

中文 | [English](./README_EN.md)

___

OneNav 是一款功能强大且简洁高效的浏览器书签管理器，支持集中式管理书签，完美解决跨设备、跨平台、跨浏览器的同步与访问难题，实现一处部署、随处访问。它不仅安装简单、界面简洁、操作方便，还可与浏览器扩展（插件）配合使用，为你带来更加高效便捷的书签管理体验。

![73a785f1df68a69f.png](https://img.rss.ink/imgs/2024/11/28/73a785f1df68a69f.png)

**强大的链接拖拽排序**

在default2主题中你可以自由的拖动链接快速排序。

![](https://sv.png.pub/imgs/2024/11/28/1ec844b98e9b84f0.gif)

> 注意：需要登录后，点击链接图标才能触发拖拽，点击其他区域无法拖拽！！！

**书签搜索**

通过顶部的搜索框，可以通过关键词模糊搜索匹配的链接，然后快速打开。

![61bac5d46d30be1c.png](https://img.rss.ink/imgs/2024/11/28/61bac5d46d30be1c.png)

**右键菜单**

当您将鼠标移动到链接后，可以点击鼠标右键调出**右键菜单**，右键菜单支持：打开链接、打开备用链接、复制链接、显示二维码、编辑链接、删除链接等快捷操作。

![532eb46f4da3c4ae.png](https://img.rss.ink/imgs/2024/11/28/532eb46f4da3c4ae.png)

需要特别说明的是**打开备用链接**，OneNav在很早的版本中就支持了这个功能，该功能适用于以下情况：

1. 您在NAS中部署了一个服务，现在想内网访问内网IP，外网访问外网域名
2. 那么你可以将外网域名添加到主链接中，将内网IP添加到备用链接中
3. 通过default2主题的右键菜单，根据您的情况访问主链接或备用链接

> 注意：如果没有添加备用链接，则右键菜单不会出现【打开备用链接】按钮。

**底部工具栏**

底部工具栏默认对访客隐藏，只有党管理员登录后才会显示，支持5个操作按钮，分别是：添加链接、返回顶部、订阅管理、系统状态、后台管理。

![12efff04c347d853.png](https://img.rss.ink/imgs/2024/11/28/12efff04c347d853.png)

**支持PWA应用**

PWA（Progressive Web App）是一种结合网页和原生应用优势的技术，default2主题已经支持PWA，现在可以像APP一样在手机上使用OneNav，下面以Edge手机浏览器举例说明。

需要先对Edge手机浏览器进行权限设置 - 其他权限 - 打开桌面快捷方式这个权限。

![d4dbef380fe34185.jpg](https://img.rss.ink/imgs/2024/11/28/d4dbef380fe34185.jpg)

打开Edge底部的工具菜单栏 - 找到『添加至手机』

![2a3c1702412cbfa5.jpg](https://img.rss.ink/imgs/2024/11/28/2a3c1702412cbfa5.jpg)

然后确认安装。

![29e6224fffdf8999.jpg](https://img.rss.ink/imgs/2024/11/28/29e6224fffdf8999.jpg)

安装完毕后手机桌面上会出现一个【OneNav】图标，点击图标就能像APP一样使用OneNav啦。

![76e2ce0e8390eb4e.jpg](https://img.rss.ink/imgs/2024/11/28/76e2ce0e8390eb4e.jpg)

**前台编辑**

default2 主题使书签分类和链接管理更加高效，所有的添加、编辑、修改和删除操作都可以在前台通过弹窗完成，无需进入后台，从而大大提升了管理效率。

![81976354a0b749e7.png](https://img.rss.ink/imgs/2024/11/28/81976354a0b749e7.png)

> **特别声明：未经作者允许，请勿将OneNav进行获利行为或进行商业行为，亦不得用于非法用途，否则自行承担相应法律责任！！！**

## 功能特色

* 支持后台管理
* 支持私有链接
* 支持Chrome/Firefox/Edge书签批量导入
* 支持多种主题风格
* 支持链接信息自动识别
* 支持API
* 支持Docker部署
* 支持二级分类
* 支持[浏览器扩展](https://dwz.ovh/4kxn2)（插件）
* 支持后台一键在线升级
* 支持链接拖拽排序
* 支持PWA应用
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
    helloz/onenav
```
* 第一个`80`是自定义访问端口，可以自行修改，第二个`80`是容器端口，请勿修改
* `/data/onenav`：本机挂载目录，用于持久存储Onenav数据

> 更多说明，请参考帮助文档：https://dwz.ovh/onenav

## Demo

* **官方演示站点：**[http://demo.onenav.top/](http://demo.onenav.top/index.php?c=login)
* 账号/密码：`xiaoz`/`xiaoz.me`


## OneNav交流群

* [https://dwz.ovh/qxsul](https://dwz.ovh/qxsul)

## 鸣谢

感谢`@百素`/`@itushan`的代码贡献及主题开发，以及其它OneNav贡献者和使用者，名字太多无法一一列举，还请谅解。

OneNav诞生离不开以下项目，在此表示感谢（排名不分先后）。

* [WebStackPage](https://github.com/WebStackPage/WebStackPage.github.io)
* [LayUI](https://github.com/sentsin/layui)
* [Medoo](https://github.com/catfan/Medoo)
* [MDUI](https://github.com/zdhxiong/mdui)
