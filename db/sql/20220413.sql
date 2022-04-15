DROP TABLE on_options;
CREATE TABLE on_options (
  "id" INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
  "key" TEXT(64) NOT NULL,
  "value" TEXT,
  "extend" TEXT,
  CONSTRAINT "option_key_only" UNIQUE ("key" ASC)
);

CREATE INDEX "main"."on_options_id_IDX"
ON "on_options" (
  "id" ASC,
  "key" ASC
);
CREATE INDEX "main"."on_options_key_IDX"
ON "on_options" (
  "key" ASC
);