DROP TABLE IF EXISTS requests_count;

CREATE TABLE IF NOT EXISTS request_count(
	pending INT(2) NOT NULL DEFAULT 0,
	fulfilled INT(2) NOT NULL DEFAULT 0,
	total INT(4) NOT NULL DEFAULT 0,
	u_id INT(4) NOT NULL,
	FOREIGN KEY(u_id) REFERENCES users(u_id)
)ENGINE=INNODB;

INSERT INTO request_count(pending, fulfilled, total, u_id)
VALUES(3, 4, 7, 1);


DROP TABLE IF EXISTS  painter_request_history;

CREATE TABLE IF NOT EXISTS painter_request_history(
	complete_date TIMESTAMP NOT NULL,
	u_id INT(4) NOT NULL,
	FOREIGN KEY(u_id) REFERENCES users(u_id),
	b_id INT(4) NOT NULL,
	FOREIGN KEY(b_id) REFERENCES painting_businesses(b_id)
)ENGINE=INNODB;

INSERT INTO painter_request_history(complete_date, u_id, b_id)
VALUES(CURRENT_TIMESTAMP, 1, 2);


CREATE TABLE IF NOT EXISTS painter_requests(
)ENGINE=INNODB;