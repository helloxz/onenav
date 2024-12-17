ALTER TABLE on_links ADD check_status INTEGER DEFAULT (0) NOT NULL;
ALTER TABLE on_links ADD last_checked_time TEXT;