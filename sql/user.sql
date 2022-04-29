DROP TABLE IF EXISTS users;

CREATE TABLE IF NOT EXISTS users(
	u_id INT(4) NOT NULL PRIMARY KEY AUTO_INCREMENT,
	u_fname VARCHAR(255) NOT NULL,
	u_lname VARCHAR(255) NOT NULL,
	u_phone VARCHAR(20) NOT NULL,
	u_password VARCHAR(255) NOT NULL,
	u_gender CHAR NOT NULL CHECK(u_gender = 'M' OR u_gender = 'F'),
	u_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	u_location VARCHAR(255) NOT NULL,
	u_loc_latlong VARCHAR(20) NOT NULL
)ENGINE=INNODB;

INSERT INTO users(u_fname, u_lname, u_phone, u_password, u_gender, u_date, u_location, u_loc_latlong)
VALUES("Pragati", "Karmacharya", "9803993178", "54321", "F", DEFAULT, "Pulchowk, Lalitpur", "27.6853, 85.3317");

DELETE FROM users WHERE u_id = {id};