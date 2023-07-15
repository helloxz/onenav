# OneNav

[中文](./README.md) | English

___

OneNav is an open-source, free bookmark (navigation) management program developed using PHP + SQLite 3. It features a simple interface, easy installation, and convenient usage. OneNav helps you manage your browser bookmarks centrally, solving the problems of syncing and accessing across devices, platforms, and browsers. Deploy it in one place and access it from anywhere.

![](https://i.bmp.ovh/imgs/2020/12/40f222b7da7a89c9.png)

![](https://i.bmp.ovh/imgs/2021/04/5c46f84f158d8d3a.png)

![](https://img.rss.ink/imgs/2022/03/cba9f1946776a8f0.png)

![](https://img.rss.ink/imgs/2022/03/4b1d6c95484e69bc.png)

![](https://img.rss.ink/imgs/2022/06/08/401b42279dd971f0.png)

![](https://img.rss.ink/imgs/2022/06/07/1a2f6c3f81b64f6a.png)

![](https://img.rss.ink/imgs/2022/06/06/172432e9d3564113.png)

![](https://i.bmp.ovh/imgs/2020/12/abba0af566f3c16a.png)

> **Special Note: Without the author's permission, do not use OneNav for profit-making or commercial activities, nor use it for illegal purposes. Otherwise, you will bear the corresponding legal responsibility!!!**

## Feature Highlights

* Supports backend management
* Supports private links
* Supports bulk import of bookmarks from Chrome/Firefox/Edge
* Supports multiple theme styles
* Supports automatic link information recognition
* Supports API
* Supports Docker deployment
* Supports uTools plugins
* Supports secondary categories
* Supports [browser extension](https://dwz.ovh/4kxn2) for Chromium kernel (plugin)
* Supports online updates
* Mobile version backend

## Installation

**Regular Installation:**

1. Requires PHP environment and must support SQLite3
2. Download and unzip the source code to the root directory of the site
3. Visit the homepage and follow the prompts to initialize username/password
4. Access the backend: `http://IP/index.php?c=login`

**Docker Deployment:**

```bash
docker run -itd --name="onenav" -p 80:80 \
    -v /data/onenav:/data/wwwroot/default/data \
    helloz/onenav:0.9.32
```
* The first `80` is the customized access port, which can be modified, and the second `80` is the container port, please do not modify
* `/data/onenav`: Local mount directory for persistent storage of Onenav data
* `0.9.32`: Replace with the latest version number of OneNav, which can be found through [releases](https://github.com/helloxz/onenav/releases)

> For more instructions, please refer to the help document: https://dwz.ovh/onenav

## Demo

* **Official demo site:** [http://demo.onenav.top/](http://demo.onenav.top/index.php?c=login)
* Account/Password: `xiaoz`/`xiaoz.me`

___

The following are some user demo sites of OneNav, in no particular order.

* OneNav: [https://nav.rss.ink/](https://nav.rss.ink/)
* Thousand-line Bookmark: [http://www.52qx.club/](http://www.52qx.club/)
* Nyuji Bookmark: [http://www.1006788.com/](http://www.1006788.com/)
* DiscoveryNav: [https://nav.miooku.com/](https://nav.miooku.com/)

## OneNav Exchange Group

* [https://dwz.ovh/qxsul](https://dwz.ovh/qxsul)

## Acknowledgements

Thanks to `@Baisu`/`@itushan` for their code contributions and theme development, as well as other OneNav contributors and users. There are too many to list, so please understand.

OneNav would not be possible without the following projects. We express our gratitude (in no particular order).

* [WebStackPage](https://github.com/WebStackPage/WebStackPage.github.io)
* [LayUI](https://github.com/sentsin/layui)
* [Medoo](https://github.com/catfan/Medoo)
* [MDUI](https://github.com/zdhxiong/mdui)
