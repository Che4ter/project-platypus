CREATE USER IF NOT EXISTS 'platypus'@'localhost' IDENTIFIED BY 'platypus';
CREATE USER IF NOT EXISTS 'platypus'@'172.17.0.1' IDENTIFIED BY 'platypus';

DROP DATABASE IF EXISTS platypus;

CREATE DATABASE IF NOT EXISTS platypus;

USE platypus;

GRANT ALL ON platypus.* TO 'platypus'@'localhost';
GRANT ALL ON platypus.* TO 'platypus'@'172.17.0.1';

CREATE TABLE roles(
	id INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  	rolename VARCHAR(30) NOT NULL,
  	can_delete BINARY DEFAULT false,
  	can_write BINARY DEFAULT false,
  	can_report BINARY DEFAULT false,
  	can_vote BINARY DEFAULT false,
	can_edit_states BINARY DEFAULT false,
	can_edit_users BINARY DEFAULT false,
	can_edit_hashtag BINARY DEFAULT false,
	created_at DATETIME,
	updated_at DATETIME,
	PRIMARY KEY(id)
);

CREATE TABLE users(
	id INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
	mailaddress VARCHAR(150),
	password VARCHAR(255) NOT NULL,
  	role_id INTEGER UNSIGNED NOT NULL,
  	status INTEGER UNSIGNED NOT NULL,
	created_at DATETIME,
	updated_at DATETIME,
	PRIMARY KEY(id),
	UNIQUE(mailaddress),
  	FOREIGN KEY (role_id) REFERENCES roles(id)
);

CREATE TABLE hashtypes(
	id INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
	hashtype_description VARCHAR(50),
	created_at DATETIME,
	updated_at DATETIME,
	PRIMARY KEY(id)
);

CREATE table moods(
	id INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
	moodname VARCHAR(50),
	created_at DATETIME,
	updated_at DATETIME,
	PRIMARY KEY(id)
);

CREATE TABLE hashtags(
	id INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
	hashtext VARCHAR(50) NOT NULL,
	hashtypes_id INTEGER UNSIGNED NOT NULL,
	created_at DATETIME,
	updated_at DATETIME,
	PRIMARY KEY(id),
	UNIQUE(hashtext),
	FOREIGN KEY (hashtypes_id) REFERENCES hashtypes(id)
);

CREATE TABLE feedback(
	id INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
	feedback_text VARCHAR(500) NOT NULL,
  	parent_id INTEGER UNSIGNED DEFAULT NULL,
  	moods_id INTEGER UNSIGNED,
  	feedback_status INTEGER UNSIGNED,
  	is_deleted BINARY DEFAULT false,
  	user_id INTEGER UNSIGNED NOT NULL,
	created_at DATETIME,
	updated_at DATETIME,
	PRIMARY KEY(id),
  	FOREIGN KEY (moods_id) REFERENCES moods(id),
  	FOREIGN KEY (parent_id) REFERENCES feedback(id),
  	FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE feedback_hashtag(
	id INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
	hashtag_id INTEGER UNSIGNED NOT NULL,
  	feedback_id INTEGER UNSIGNED NOT NULL,
	created_at DATETIME,
	updated_at DATETIME,
  	PRIMARY KEY(id),
  	FOREIGN KEY (hashtag_id) REFERENCES hashtags(id),
  	FOREIGN KEY (feedback_id) REFERENCES feedback(id)
);

CREATE TABLE votes(
	id INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
	feedback_id INTEGER UNSIGNED NOT NULL,
  	user_id INTEGER UNSIGNED NOT NULL,
	direction BINARY,
	created_at DATETIME,
	updated_at DATETIME,
  	PRIMARY KEY(id),
  	FOREIGN KEY (feedback_id) REFERENCES feedback(id),
  	FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE reports(
	id INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
	feedback_id INTEGER UNSIGNED NOT NULL,
  	user_id INTEGER UNSIGNED NOT NULL,
	created_at DATETIME,
	updated_at DATETIME,
  	PRIMARY KEY(id),
  	FOREIGN KEY (feedback_id) REFERENCES feedback(id),
  	FOREIGN KEY (user_id) REFERENCES users(id)
);
