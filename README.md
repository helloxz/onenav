# onenav
使用PHP + SQLite 3开发的简约导航/书签管理器，xiaoz新作，欢迎体验。

![](https://i.bmp.ovh/imgs/2020/12/40f222b7da7a89c9.png)



![](https://i.bmp.ovh/imgs/2020/12/7a1eee25c16d2d81.png)



![](https://i.bmp.ovh/imgs/2020/12/abba0af566f3c16a.png)



## 功能特色

* 支持后台管理
* 支持私有链接
* 支持多种主题风格（默认内置2套模板）
* 支持链接信息自动识别
* 支持API

## 安装

**常规安装：**

1. 需安装PHP环境，并确保支持SQLite3
2. 下载源码解压到站点根目录
3. 将`config.simple.php`复制为`data/config.php`并填写自己的站点信息
5. 访问后台：`http://IP/index.php?c=login`

**Docker部署：**

```bash
docker run -itd --name="onenav" -p 80:80 \
    -e USER='xiaoz' -e PASSWORD='xiaoz.me' \
    -v /data/onenav:/data/wwwroot/default/data \
    helloz/onenav
```

* `USER`：设置用户名，上述设置为`xiaoz`
* `PASSWORD`：设置密码，上述设置为`xiaoz.me`
* `/data/onenav`：本机挂载目录，用于持久存储Onenav数据

> 更多说明，请参考帮助文档：https://www.yuque.com/helloz/onenav

## 联系我

* Blog:https://www.xiaoz.me/
* QQ:337003006
* QQ群：147687134

## 鸣谢

OneNav诞生离不开以下项目，在此表示感谢（排名不分先后）。

* [WebStackPage](https://github.com/WebStackPage/WebStackPage.github.io)
* [LayUI](https://github.com/sentsin/layui)
* [Medoo](https://github.com/catfan/Medoo)
* [MDUI](https://github.com/zdhxiong/mdui)