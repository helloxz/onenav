-- 分类目录增加字体图标列
ALTER TABLE on_categorys ADD font_icon TEXT(32);
-- 链接表新增字段topping，默认值0（不置顶），1为置顶，先保留后续使用
ALTER TABLE on_links ADD topping INTEGER DEFAULT 0 NOT NULL;
-- 增加一个备用链接字段
ALTER TABLE on_links ADD url_standby TEXT(256);

