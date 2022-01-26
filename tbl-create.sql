CREATE DATABASE IF NOT EXISTS lesson2 DEFAULT CHARACTER SET utf8mb4;
use lesson2;

DROP TABLE IF EXISTS members;
CREATE TABLE members (
    id INT(10) AUTO_INCREMENT,
    email VARCHAR(128) NOT NULL UNIQUE,
    user VARCHAR(128) NOT NULL,
    password VARCHAR(100),
    name VARCHAR(128),
    address VARCHAR(128),
    gender INT(1),
    picture VARCHAR(256),
    activated INT(1) NOT NULL DEFAULT 0,
    banned INT(1) DEFAULT 0,
    lastlogin DATETIME,
    createdate DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updatedate DATETIME NULL ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY(id)
) DEFAULT CHARSET=utf8mb4;

/* テストデータ投入 */
INSERT INTO members (email, user, name, gender) VALUE ('ichiro@xxx.com','uer1','山田一郎',1);
INSERT INTO members (email, user, name, gender) VALUE ('jiro@xxx.com','uer2','山田次郎',1);
INSERT INTO members (email, user, name, gender) VALUE ('ken@www.com','uer3','太田健一',1);
