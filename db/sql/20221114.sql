CREATE TABLE on_shares (
	id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
	sid TEXT(8) NOT NULL,
	add_time TEXT(10) NOT NULL,
	expire_time TEXT(10) NOT NULL,
	password TEXT(16),
	cid INTEGER NOT NULL,
	note TEXT(2048)
);
CREATE UNIQUE INDEX on_shares_sid_IDX ON on_shares (sid);