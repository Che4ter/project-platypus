CREATE USER IF NOT EXISTS 'platypus'@'localhost' IDENTIFIED BY 'platypus';

CREATE DATABASE IF NOT EXISTS platypus;

USE platypus;

GRANT ALL ON platypus.* TO 'platypus'@'localhost';

CREATE TABLE Roles(
	role_ID integer PRIMARY KEY,
  	rolename varchar(15) not null,
  	can_delete binary DEFAULT false,
  	can_write binary DEFAULT false,
  	can_report binary DEFAULT false,
  	can_vote binary DEFAULT false,
	can_edit_states binary DEFAULT false,
	can_edit_users binary DEFAULT false,
	can_edit_Hashtag binary DEFAULT false
);

create TABLE Users(
	mailaddress varchar(150) PRIMARY KEY,
	password varchar(255) not null,
  	fk_role integer not null,
  	status integer not null,
  	FOREIGN KEY (fk_role) REFERENCES Roles(role_ID)
);

CREATE TABLE Hashtypes(
	hashtype_ID integer PRIMARY KEY,
	moodname varchar(50)
);

create table Moods(
	mood_ID integer PRIMARY KEY,
	moodname varchar(50)
);

CREATE TABLE Hashtag(
	hashtext varchar(50) PRIMARY KEY,
	fk_hashtype integer not null,
	FOREIGN KEY (fk_hashtype) REFERENCES Hashtypes(hashtype_ID)
);

CREATE TABLE Feedback(
	feedback_ID integer PRIMARY KEY,
	feedback_text varchar(500) NOT NULL,
  	fk_parent int DEFAULT 0,
  	fk_mood int,
  	feedback_status integer,
  	deleted binary DEFAULT false,
  	created datetime,
  	fk_user varchar(150) not null,
  	FOREIGN KEY (fk_mood) REFERENCES Moods(mood_ID),
  	FOREIGN KEY (fk_parent) REFERENCES Feedback(feedback_ID),
  	FOREIGN KEY (fk_user) REFERENCES Users(mailaddress)
);


CREATE TABLE Feedback_Hashtag(
	fk_hashtext varchar(50) not null,
  	fk_feedback integer not null,
  	PRIMARY KEY (fk_hashtext, fk_feedback),
  	FOREIGN KEY (fk_hashtext) REFERENCES Hashtag(hashtext),
  	FOREIGN KEY (fk_feedback) REFERENCES Feedback(feedback_ID)
);

CREATE TABLE Votes(
	fk_feedback_ID integer not null,
  	fk_mailaddress varchar(150) not null,
	direction binary,
  	PRIMARY KEY (fk_feedback_ID, fk_mailaddress),
  	FOREIGN KEY (fk_feedback_ID) REFERENCES Feedback(feedback_ID),
  	FOREIGN KEY (fk_mailaddress) REFERENCES Users(mailaddress)
);

CREATE TABLE Reports(
	fk_feedback_ID integer not null,
  	fk_mailaddress varchar(150) not null,
  	PRIMARY KEY(fk_feedback_ID, fk_mailaddress),
  	FOREIGN KEY (fk_feedback_ID) REFERENCES Feedback(feedback_ID),
  	FOREIGN KEY (fk_mailaddress) REFERENCES Users(mailaddress)
);
