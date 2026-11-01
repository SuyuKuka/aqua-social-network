CREATE DATABASE IF NOT EXISTS aqua_db;
USE aqua_db;

DROP TABLE IF EXISTS comments;
DROP TABLE IF EXISTS likes;
DROP TABLE IF EXISTS subs;
DROP TABLE IF EXISTS message;
DROP TABLE IF EXISTS users;

CREATE TABLE IF NOT EXISTS users(
 id int(10) UNSIGNED ZEROFILL AUTO_INCREMENT PRIMARY KEY,
 pseudo varchar(32) NOT NULL,
 password varchar(100) NOT NULL,
 email varchar(535) NOT NULL,
 birthday date NOT NULL,
 pfp varchar(535) NOT NULL DEFAULT 'uploads/default.png',
 isAdmin tinyint(1) NOT NULL DEFAULT 0
);

CREATE TABLE IF NOT EXISTS message(
 id int(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 user_id int(10) UNSIGNED ZEROFILL,
 message text(2000) NOT NULL,
 image varchar(535),
 timestamp datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
 FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS subs(
 user int(10) UNSIGNED ZEROFILL NOT NULL,
 subto int(10) UNSIGNED ZEROFILL NOT NULL,
 PRIMARY KEY(user, subto),
 FOREIGN KEY (user) REFERENCES users(id) ON DELETE CASCADE,
 FOREIGN KEY(subto) REFERENCES users(id) ON DELETE CASCADE 
);

CREATE TABLE IF NOT EXISTS likes(
 liked_post int(10) UNSIGNED NOT NULL,
 liked_by int(10) UNSIGNED ZEROFILL NOT NULL,
 PRIMARY KEY(liked_post, liked_by),
 FOREIGN KEY (liked_post) REFERENCES message(id) ON DELETE CASCADE,
 FOREIGN KEY (liked_by) REFERENCES users(id) ON DELETE CASCADE
); 

CREATE TABLE IF NOT EXISTS comments(
 id int(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 message_id int(10) UNSIGNED NOT NULL,
 comment text(500) NOT NULL,
 author int(10) UNSIGNED ZEROFILL NOT NULL,
 timestamp datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
 FOREIGN KEY (message_id) REFERENCES message(id) ON DELETE CASCADE,
 FOREIGN KEY (author) REFERENCES users(id) ON DELETE CASCADE
);

INSERT INTO users(id,pseudo,password,email,birthday,pfp,isAdmin) VALUES
(1,'Admin',MD5('Admin123'),'admin@gmail.com','2000-01-01','uploads/644bca441f63a-pdp.jpg',1),
(2,'notme',MD5('NotMe123'),'notme@gmail.com','1999-01-05','uploads/default.png',0),
(3,'Carapuce',MD5('Carapuce123'),'carapuce@gmail.com','2002-02-04','uploads/default.png',0),
(4,'Haru',MD5('HaruRu123'),'haru@gmail.com','2000-12-11','uploads/6456ba6aad8a1-Adagaki_Aki.png',0),
(5,'LocalMagician',MD5('LocalMagician123'),'magimagi@gmail.com','2003-04-20','uploads/64578feb409e2-93ddece49a8760277de2bc642df86cb7.png',0);

INSERT INTO message(id,user_id,message,image) VALUES
(1,1,'Hello everyone,<br/> Remember the rule of common sense and have fun!',NULL),
(2,2,'I have been playing Persona 4 lately.','release/6456ba3ba7e50-93ddece49a8760277de2bc642df86cb7.png'),
(3,4,'','release/6457998da2fcf-anju.png'),
(4,3,'Just found this it looks nice.','release/037290b3fcb6f9e575dfa823d859facf-transformed.png');

INSERT INTO subs(user,subto) VALUES
(4,1),
(2,1),
(3,1),
(3,2),
(1,4);

INSERT INTO likes(liked_post,liked_by) VALUES
(1,2),
(1,3),
(3,1),
(2,3);

INSERT INTO comments(id,message_id,comment,author) VALUES
(1,1,'ROGER',3),
(2,1,'ok',2),
(3,2,'Seems nice',3);


