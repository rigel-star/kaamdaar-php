CREATE TABLE IF NOT EXISTS request_history(
	DATE_COMPLETE TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	U_ID INT,
	CONSTRAINT request_history_u_id_fk FOREIGN KEY(U_ID) REFERENCES users(U_ID) ON DELETE SET NULL,
	B_PROFILE_ID INT,
	CONSTRAINT request_history_b_profile_id_fk FOREIGN KEY(B_PROFILE_ID) REFERENCES business_profile(B_PROFILE_ID) ON DELETE SET NULL
)ENGINE=INNODB;


CREATE TABLE IF NOT EXISTS request(
	REQUEST_ID INT PRIMARY KEY AUTO_INCREMENT,
	REQUEST_TYPE INT NOT NULL,
	REQEUST_LOCATION VARCHAR(50) NOT NULL,
	REQUEST_LATLONG VARCHAR(20) NOT NULL,
	U_ID INT NOT NULL,
	CONSTRAINT request_u_id_fk FOREIGN KEY(U_ID) REFERENCES users(U_ID) ON DELETE CASCADE,
	CONSTRAINT request_request_type_fk FOREIGN KEY(REQUEST_TYPE) REFERENCES business_category(B_CAT_ID) ON DELETE CASCADE
)ENGINE=INNODB;


CREATE TABLE IF NOT EXISTS request_count(
	PENDING INT(2) NOT NULL DEFAULT 0,
	FULFILLED INT(2) NOT NULL DEFAULT 0,
	TOTAL INT(4) NOT NULL DEFAULT 0,
	U_ID INT(4) NOT NULL,
	CONSTRAINT request_count_u_id_fk FOREIGN KEY(u_id) REFERENCES users(U_ID) ON DELETE CASCADE
)ENGINE=INNODB;


CREATE TRIGGER increment_request_count AFTER INSERT ON request
	FOR EACH ROW
		UPDATE request_count SET PENDING = PENDING + 1, TOTAL = TOTAL + 1 WHERE U_ID = new.U_ID;