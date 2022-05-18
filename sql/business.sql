create table business_profile(
	B_PROFILE_ID INT PRIMARY KEY AUTO_INCREMENT,
	B_PROFILE_NAME VARCHAR(50) NOT NULL,
	B_PROFILE_IMAGE VARCHAR(255) NOT NULL
	U_ID INT NOT NULL,
	CONSTRAINT business_profile_u_id_fk FOREIGN KEY(U_ID) REFERENCES users(U_ID) ON DELETE CASCADE
)ENGINE=INNODB;

CREATE TABLE IF NOT EXISTS business(
	BUSINESS_ID INT PRIMARY KEY AUTO_INCREMENT,
	BUSINESS_TYPE INT NOT NULL,
	B_PROFILE_ID INT NOT NULL,
	CONSTRAINT business_b_profile_id_fk FOREIGN KEY(B_PROFILE_ID) REFERENCES business_profile(B_PROFILE_ID) ON DELETE CASCADE,
	CONSTRAINT business_business_type_fk FOREIGN KEY(BUSINESS_TYPE) REFERENCES business_category(B_CAT_ID) ON DELETE CASCADE
)ENGINE=INNODB;

CREATE TABLE IF NOT EXISTS business_info(
	B_INFO_ID INT PRIMARY KEY AUTO_INCREMENT,
	B_INFO_REVENUE FLOAT DEFAULT 0.0,
	B_INFO_RATING FLOAT DEFAULT 0.0,
	B_INFO_TOTAL INT DEFAULT 0,
	BUSINESS_ID INT NOT NULL,
	CONSTRAINT business_info_business_id_fk FOREIGN KEY(BUSINESS_ID) REFERENCES business(BUSINESS_ID) ON DELETE CASCADE
)ENGINE=INNODB;

CREATE TABLE IF NOT EXISTS business_category(
	B_CAT_ID INT PRIMARY KEY,
	B_CAT_NAME VARCHAR(50) NOT NULL,
	B_CAT_ICON VARCHAR(255) NOT NULL
)ENGINE=INNODB;


-------------------------------------------------------------------------
DELIMITER %%
CREATE TRIGGER insert_default_business_info AFTER INSERT ON business
	FOR EACH ROW
	BEGIN 
		DECLARE BID int;
		SET BID = new.BUSINESS_ID;
		INSERT INTO business_info(B_INFO_REVENUE, B_INFO_RATING, B_INFO_TOTAL, BUSINESS_ID) values(DEFAULT, DEFAULT, DEFAULT, BID);
	END%%
DELIMITER ;

DELIMITER %%
CREATE TRIGGER delete_business_info_on_business_delete AFTER DELETE ON business
	FOR EACH ROW
	BEGIN 
		DECLARE BID int;
		SET BID = old.BUSINESS_ID;
		DELETE FROM business_info WHERE BUSINESS_ID = BID;
	END%%
DELIMITER ;
-------------------------------------------------------------------------
-------------------------------------------------------------------------
DELIMITER %%
CREATE PROCEDURE remove_business(IN B_ID INT)
BEGIN
	START TRANSACTION;
	DELETE FROM business WHERE BUSINESS_ID = B_ID;
	COMMIT;
END%%
DELIMITER ;
-------------------------------------------------------------------------