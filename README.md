# onenav
使用PHP + SQLite 3开发的简约导航/书签管理器，xiaoz新作，欢迎体验。

![](https://i.bmp.ovh/imgs/2020/12/7a1eee25c16d2d81.png)

![](https://i.bmp.ovh/imgs/2020/12/abba0af566f3c16a.png)



## 功能特色

* 支持后台管理
* 支持私有链接
* 支持链接信息自动识别
* 支持API

## 安装

1. 需安装PHP环境，并确保支持SQLite3
2. 下载源码解压到站点根目录
3. 将`config.simple.php`修改为`config.php`并填写自己的站点信息
4. 将`db/onenav.simple.db3`重命名为`onenav.db3`
5. 访问后台：`http://IP/index.php?c=login`