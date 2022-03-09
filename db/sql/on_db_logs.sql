-- 2022/03/07数据库升级脚本
-- 创建数据库升级记录表，用于新增的SQL升级成功后记录到表，方便下次比对
CREATE TABLE on_db_logs (
	id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
	sql_name TEXT(32) NOT NULL,
	update_time NUMERIC NOT NULL,
	status TEXT(5) DEFAULT 'TRUE' NOT NULL,
	extra TEXT(512),
	CONSTRAINT on_db_logs_UN UNIQUE (sql_name)
);
CREATE UNIQUE INDEX on_db_logs_sql_name_IDX ON on_db_logs (sql_name);
