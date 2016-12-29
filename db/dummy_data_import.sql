/* Empty Database */
SET FOREIGN_KEY_CHECKS=0;
TRUNCATE TABLE roles;
TRUNCATE TABLE users;
TRUNCATE TABLE hashtypes;
TRUNCATE TABLE moods;
TRUNCATE TABLE hashtags;
TRUNCATE TABLE feedback;
TRUNCATE TABLE feedback_hashtag;
TRUNCATE TABLE votes;
TRUNCATE TABLE reports;
SET FOREIGN_KEY_CHECKS=1;
 
/* Insert Data */
INSERT INTO roles (id,rolename,can_delete,can_write,can_report,can_vote,can_edit_states,can_edit_users,can_edit_hashtag,created_at,updated_at) VALUES
	(1,"Student",0,1,1,1,0,0,0,UTC_TIMESTAMP(),UTC_TIMESTAMP()),
	(2,"Moderator",1,1,1,1,0,0,0,UTC_TIMESTAMP(),UTC_TIMESTAMP()),
	(3,"Dozent",0,0,1,0,0,0,0,UTC_TIMESTAMP(),UTC_TIMESTAMP()),
	(9,"Administrator",1,1,1,1,1,1,1,UTC_TIMESTAMP(),UTC_TIMESTAMP());

INSERT INTO users (id,mailaddress,password,role_id,status,created_at,updated_at) VALUES
	(1,"admin@platypus.ch","1234",9,1,UTC_TIMESTAMP(),UTC_TIMESTAMP()),
	(2,"student1@stud.hslu.platypus.ch","1234",9,1,UTC_TIMESTAMP(),UTC_TIMESTAMP()),
	(3,"student2@stud.hslu.platypus.ch","1234",9,0,UTC_TIMESTAMP(),UTC_TIMESTAMP()),
	(4,"moderator@stud.hslu.platypus.ch","1234",9,1,UTC_TIMESTAMP(),UTC_TIMESTAMP()),
	(5,"dozent@stud.hslu.platypus.ch","1234",9,1,UTC_TIMESTAMP(),UTC_TIMESTAMP());

INSERT INTO hashtypes(id,hashtype_description,created_at,updated_at) VALUES
	(1,"Semester",UTC_TIMESTAMP(),UTC_TIMESTAMP()),
	(2,"Module",UTC_TIMESTAMP(),UTC_TIMESTAMP()),
	(3,"Campus",UTC_TIMESTAMP(),UTC_TIMESTAMP()),
	(4,"User Defined",UTC_TIMESTAMP(),UTC_TIMESTAMP());

INSERT INTO moods(id,moodname,created_at,updated_at) VALUES
	(1,"Kritik",UTC_TIMESTAMP(),UTC_TIMESTAMP()),
	(2,"Positives",UTC_TIMESTAMP(),UTC_TIMESTAMP()),
	(3,"Feedback",UTC_TIMESTAMP(),UTC_TIMESTAMP());

INSERT INTO hashtags(id,hashtext,hashtypes_id,created_at,updated_at) VALUES
	(1,"HS16",1,UTC_TIMESTAMP(),UTC_TIMESTAMP()),
	(2,"FS17",1,UTC_TIMESTAMP(),UTC_TIMESTAMP()),
	(3,"PRG1",2,UTC_TIMESTAMP(),UTC_TIMESTAMP()),
	(4,"PRG2",2,UTC_TIMESTAMP(),UTC_TIMESTAMP()),
	(5,"PREN1",2,UTC_TIMESTAMP(),UTC_TIMESTAMP()),
	(6,"PREN2",2,UTC_TIMESTAMP(),UTC_TIMESTAMP()),
	(7,"SSM",2,UTC_TIMESTAMP(),UTC_TIMESTAMP()),
	(8,"MENSA",3,UTC_TIMESTAMP(),UTC_TIMESTAMP()),
	(9,"CAMPUS",3,UTC_TIMESTAMP(),UTC_TIMESTAMP()),
	(10,"UNTERRICHT",3,UTC_TIMESTAMP(),UTC_TIMESTAMP()),
	(11,"INFRASTRUKTUR",4,UTC_TIMESTAMP(),UTC_TIMESTAMP());

INSERT INTO feedback(id,feedback_text,parent_id,moods_id,feedback_status,user_id,created_at,updated_at) VALUES
	(1, "Schlechte Organisation",NULL,1,1,1,UTC_TIMESTAMP(),UTC_TIMESTAMP()),
	(2, "Langweiliger Unterricht",NULL,1,1,1,UTC_TIMESTAMP(),UTC_TIMESTAMP()),
	(3, "Das finde ich auch",2,1,1,1,UTC_TIMESTAMP(),UTC_TIMESTAMP()),
	(4, "Sehr Kompetente Dozenten",NULL,2,1,1,UTC_TIMESTAMP(),UTC_TIMESTAMP()),
	(5, "Bitte Unterlagen schneller hochladen",NULL,3,1,1,UTC_TIMESTAMP(),UTC_TIMESTAMP());

INSERT INTO feedback_hashtag(id,hashtag_id,feedback_id,created_at,updated_at) VALUES
	(1,1,1,UTC_TIMESTAMP(),UTC_TIMESTAMP()),
	(2,3,1,UTC_TIMESTAMP(),UTC_TIMESTAMP()),
	(3,1,2,UTC_TIMESTAMP(),UTC_TIMESTAMP()),
	(4,4,2,UTC_TIMESTAMP(),UTC_TIMESTAMP()),
	(5,2,3,UTC_TIMESTAMP(),UTC_TIMESTAMP()),
	(6,3,3,UTC_TIMESTAMP(),UTC_TIMESTAMP()),
	(7,2,4,UTC_TIMESTAMP(),UTC_TIMESTAMP()),
	(8,7,4,UTC_TIMESTAMP(),UTC_TIMESTAMP()),
	(9,1,5,UTC_TIMESTAMP(),UTC_TIMESTAMP()),
	(10,6,5,UTC_TIMESTAMP(),UTC_TIMESTAMP());

INSERT INTO votes(feedback_id,user_id,direction,created_at,updated_at) VALUES
	(1,1,1,UTC_TIMESTAMP(),UTC_TIMESTAMP()),
	(1,2,1,UTC_TIMESTAMP(),UTC_TIMESTAMP()),
	(1,3,1,UTC_TIMESTAMP(),UTC_TIMESTAMP()),
	(2,1,1,UTC_TIMESTAMP(),UTC_TIMESTAMP()),
	(2,2,0,UTC_TIMESTAMP(),UTC_TIMESTAMP()),
	(2,3,0,UTC_TIMESTAMP(),UTC_TIMESTAMP()),
	(3,1,1,UTC_TIMESTAMP(),UTC_TIMESTAMP());

INSERT INTO reports(feedback_id,user_id,created_at,updated_at) VALUES
	(2,1,UTC_TIMESTAMP(),UTC_TIMESTAMP());

