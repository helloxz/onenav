# OneNav主题
onenav导航的主题
![输入图片说明](https://images.gitee.com/uploads/images/2022/0226/233837_3fa5c693_1718725.png "屏幕截图.png")
![输入图片说明](https://images.gitee.com/uploads/images/2022/0226/233859_ed83bce1_1718725.png "屏幕截图.png")

## 天气插件
天气插件采用的是【和风天气】的标准版天气插件，可无限制免费试用，需要先注册和风天气账号，
[和风天气账号注册](https://id.qweather.com/#/register)；
[和风天气创建插件页面](https://widget.qweather.com/create-standard)
插件 选择【横版】、【款：240px】、【高:180px】;否则会出现样式偏移的问题。其他条件任选。
生成代码后  除第一行`<div id="he-plugin-standard"></div>`外，其他代码复制到主题文件夹下`index.php`底部对应位置即可。


## 一键添加
![输入图片说明](https://images.gitee.com/uploads/images/2021/0410/112213_3a134ad6_1718725.gif "a.gif")

在浏览器标签栏添加新标签
标签名称栏随意填写
标签地址栏，填写一下地址代码

```
javascript: var url = location.href;
var title = document.title;
void(open('http://www.你的域名.com/index.php?c=admin&page=add_quick_tpl&url=' + encodeURIComponent(url) + '&title=' + encodeURIComponent(title), "_blank", "toolbar=yes, location=yes, directories=no, status=no, menubar=yes, scrollbars=yes, resizable=no, copyhistory=yes, left=200,top=200,width=400, height=460"));
```
注意域名要替换成你的域名，然后保存即可。


## 相关链接

* [OneNav官网](https://nav.rss.ink/)
* [onenav作者](https://www.xiaoz.me/)