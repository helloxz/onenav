/*
 Navicat Premium Data Transfer

 Source Server         : Onenav
 Source Server Type    : SQLite
 Source Server Version : 3030001
 Source Schema         : main

 Target Server Type    : SQLite
 Target Server Version : 3030001
 File Encoding         : 65001

 Date: 11/12/2020 22:48:17
*/

PRAGMA foreign_keys = false;

-- ----------------------------
-- Table structure for on_categorys
-- ----------------------------
DROP TABLE IF EXISTS "on_categorys";
CREATE TABLE "on_categorys" (
  "id" INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
  "name" TEXT(32) NOT NULL,
  "add_time" TEXT(10) NOT NULL,
  "up_time" TEXT(10) DEFAULT '',
  "weight" integer(3) NOT NULL DEFAULT 0,
  "property" integer(1) NOT NULL DEFAULT 0,
  "description" TEXT(128) DEFAULT ''
);

-- ----------------------------
-- Records of on_categorys
-- ----------------------------

-- ----------------------------
-- Table structure for on_links
-- ----------------------------
DROP TABLE IF EXISTS "on_links";
CREATE TABLE "on_links" (
  "id" INTEGER NOT NULL,
  "fid" INTEGER(5) NOT NULL,
  "title" TEXT(64) NOT NULL,
  "url" TEXT(256) NOT NULL,
  "description" TEXT(256),
  "add_time" TEXT(10) NOT NULL,
  "up_time" TEXT(10),
  "weight" integer(3) NOT NULL DEFAULT 0,
  "property" integer(1) NOT NULL DEFAULT 0,
  "click" integer NOT NULL DEFAULT 0,
  PRIMARY KEY ("id")
);

-- ----------------------------
-- Records of on_links
-- ----------------------------

-- ----------------------------
-- Table structure for sqlite_sequence
-- ----------------------------
DROP TABLE IF EXISTS "sqlite_sequence";
CREATE TABLE "sqlite_sequence" (
  "name",
  "seq"
);

-- ----------------------------
-- Records of sqlite_sequence
-- ----------------------------
INSERT INTO "sqlite_sequence" VALUES ('on_categorys', 0);

-- ----------------------------
-- Auto increment value for on_categorys
-- ----------------------------

PRAGMA foreign_keys = true;
